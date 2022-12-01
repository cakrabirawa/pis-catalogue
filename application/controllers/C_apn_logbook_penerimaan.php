<?php 
/*
------------------------------
Menu Name: Logbook Penerimaan
File Name: C_apn_logbook_penerimaan.php
File Path: D:\Project\PHP\apn\application\controllers\C_apn_logbook_penerimaan.php
Create Date Time: 2020-06-19 07:58:08
------------------------------
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class c_apn_logbook_penerimaan extends CI_Controller { 
	var $data = null;
	var $nUnitId = null;
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->nUnitId = $this->session->userdata('nUnitId_fk');
		$a = new libSession(); 
		if($a->gf_check_session()) 
			redirect("c_core_login"); 
		else 
		{ 
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_apn_logbook_penerimaan', 'm_apn_vendor')); 
			$this->load->library(array('libPaging')); 
		}	
		$this->data['o_page'] 			= 'backend/v_apn_logbook_penerimaan'; 
		$this->data['o_page_title'] = 'Logbook Penerimaan'; 
		$this->data['o_page_desc'] 	= 'Maintenance Logbook Penerimaan'; 
		$this->data['o_data'] 			= null;
		$this->data['o_extra']  		= $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_apn_logbook_penerimaan"));
	} 
	public function index() 
	{ 
		$this->data['o_mode'] = "I";
		$this->data['o_status_tx'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdStatusTX, sNamaStatusTX  from tm_apn_status_tx where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdStatusTX", "sFieldValues" => "sNamaStatusTX"));
		$this->data['o_status_doc'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdStatusDokumen, sNamaStatusDokumen  from tm_apn_status_dokumen where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdStatusDokumen", "sFieldValues" => "sNamaStatusDokumen"));
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	public function gf_exec() 
	{ 
		$this->data['o_mode'] = "";
		$this->data['o_data'] = $this->m_apn_logbook_penerimaan->gf_load_data(); 
		$this->data['o_status_tx'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdStatusTX, sNamaStatusTX  from tm_apn_status_tx where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdStatusTX", "sFieldValues" => "sNamaStatusTX", "sFieldInitValue" => $this->data['o_data'][0]['nIdStatusTX_fk']));	
		$this->data['o_status_doc'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdStatusDokumen, sNamaStatusDokumen  from tm_apn_status_dokumen where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdStatusDokumen", "sFieldValues" => "sNamaStatusDokumen", "sFieldInitValue" => $this->data['o_data'][0]['nIdStatusDokumen_fk']));	
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	function gf_transact() 
	{ 
		print $this->m_apn_logbook_penerimaan->gf_transact(); 
	} 
	function gf_load_data() 
	{ 
		$c = new libPaging(); 
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$sql = "select a.nIdPenerimaan as `Id Penerimaan`, a.dTglPenerimaan as `Tgl Penerimaan`, a.sIdVendor_fk as `Id Vendor`, d.sNamaVendor as `Nama Vendor`, a.sNoTiket as `No Tiket`, a.nNominal as `Nominal`, a.nQty as `Qty`, b.sNamaStatusDokumen as `Status Dokumen`, c.sNamaStatusTX as `Status Transaksi`, case when a.nIdStatusDokumen_fk = 1 then a.dTglEstimasiPayment else a.dTglReject end as `Tgl Estimasi / Reject`, (select p.sReceiptNo from tx_apn_email_log_track p where p.sStatusDelete is null and p.nUnitId_fk
	 = ".$nUnitId." and p.nIdPenerimaan_fk = a.nIdPenerimaan order by p.dCreateOn desc limit 1) as `No Receipt`, a.sNotes as `Notes`, a.sNamaPIC as `Nama PIC` from tx_apn_logbook_penerimaan a inner join tm_apn_status_dokumen b on b.nIdStatusDokumen = a.nIdStatusDokumen_fk inner join tm_apn_status_tx c on c.nIdStatusTX = a.nIdStatusTX_fk inner join tm_apn_vendor d on d.sIdVendor = a.sIdVendor_fk where a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null and d.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and b.nUnitId_fk = ".$nUnitId." and c.nUnitId_fk = ".$nUnitId." and d.nUnitId_fk = ".$nUnitId." order by a.dCreateOn desc";
		//print $sql;
		//exit();
		$sParam = array( "sSQL" => $sql,
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_apn_logbook_penerimaan/gf_load_data",
										 "sCallBackURLPageEditDelete" => site_url()."c_apn_logbook_penerimaan/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("Nama Vendor"),
										 "sDefaultFieldSearch"  => "Nama Vendor",
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
	function gf_load_data_vendor()
	{
		$c = new libPaging();
  	$sParam = array(
  										"sSQL"  				       => "select sIdVendor as `Id Vendor`, sNamaVendor as `Nama Vendor`, sVendorEmail as `Email` from tm_apn_vendor where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk'), 
  										"sTitleHeader" 				 => "Search Vendor",
  										"sCallBackURLPaging"	 => site_url()."c_apn_logbook_penerimaan/gf_load_data_vendor",
											"sLookupPopup"         => true,
											"sLookupMode"           => "single",
  										"sLookupEditDelete"    => false,
  										"bDebugSQL"            => false,
  										"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
  										"sInitHeaderFields"    => array("Nama Vendor"),
  										"sDefaultFieldSearch"  => "Nama Vendor",
  										"sTheme"               => "default",
  										"hideInitRowPage"      => 10 
  								 );		
  	$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
	function gf_load_data_vendor_detail()
	{
		print json_encode(array("oData" => $this->m_apn_vendor->gf_load_data(array("Id_Vendor" => $this->input->post('sIdVendor', TRUE)))));
	}
}