<?php 
/*
------------------------------
Menu Name: Dashboard
File Name: M_core_main.php
File Path: D:\Project\php\inventaris\application\models\M_core_main.php
Create Date Time: 2021-11-03 14:55:15
------------------------------
*/
class m_core_main extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps')); 
	} 
	function gf_load_dashboard()
	{
		$sReturn = null;
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$oConfig = $this->m_core_apps->gf_read_config_apps(array('LIMIT_SHOW_ORDER_SERVICE_DASHBOARD'));
		//--Jumlah Order All
		$sql = "call sp_query('select * from ( ";
		$sql .= "(select count(1) as oCountOrdersAll from tx_ms_orders_h where sStatusDelete is null and nUnitId_fk = ".$nUnitId.") as oCountOrdersAll, ";
		$sql .= "(select count(1) as oCountOrdersService from tx_ms_orders_h where sStatusDelete is null and nUnitId_fk = ".$nUnitId." and nIdTypeOrders_fk = 2) as oCountOrdersService, ";
		$sql .= "(select count(1) as oCountOrdersPeminjaman from tx_ms_orders_h where sStatusDelete is null and nUnitId_fk = ".$nUnitId." and nIdTypeOrders_fk = 6) as oCountOrdersPeminjaman ";
		$sql .= ")');";
		$row = $this->db->query($sql)->row_array();
		$sReturn['oCountOrdersAll'] = intval($row['oCountOrdersAll']);
		$sReturn['oCountOrdersService'] = intval($row['oCountOrdersService']);
		$sReturn['oCountOrdersPeminjaman'] = intval($row['oCountOrdersPeminjaman']);
		$sql = "call sp_query('select b.*, a.sSRNIK, a.sSRNama, b.sSRNoTicket, (select p.sNamaVendor from tb_ms_vendor p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nIdVendor = a.nSRIdVendor_fk) as sNamaVendor from tx_ms_orders_h a inner join tx_ms_orders_d b on b.nOrdersId_fk = a.nOrdersId where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and b.sStatusDelete is null and b.nUnitId_fk = ".$nUnitId." and a.nIdTypeOrders_fk = 2 and (select p.nIdStatus_fk from tx_ms_orders_status p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nOrdersId_fk = a.nOrdersId and p.sSRNoTicket = b.sSRNoTicket order by p.dCreateOn desc limit 1) = 5 order by a.dCreateOn desc limit ".intval($oConfig['LIMIT_SHOW_ORDER_SERVICE_DASHBOARD'])."');";
		$sReturn['oOrdersServiceList'] = $this->db->query($sql)->result_array();
		//-------------------------------------------
		return json_encode($sReturn);
	}
}