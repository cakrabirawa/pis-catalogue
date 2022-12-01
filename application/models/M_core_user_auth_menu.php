<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_user_auth_menu extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}
	function gf_load_data($sParam = null)
	{
		$oParam = $_POST;
		$oData = $sParam === null ? $oParam['User_Group_Id'] : $sParam['User_Group_Id'];
		$sql = "call sp_query('select * from tm_user_groups where nGroupUserId = ''" . trim($oData) . "'' and sStatusDelete is null')";
		$rs = $this->db->query($sql);
		return $rs->result_array();
	}
	function gf_transact()
	{
		$nMenuId = $this->input->post('nMenuId', TRUE);
		$nGroupUserId = $this->input->post('nGroupUserId', TRUE);
		$nUnitId = $this->input->post('nUnitId', TRUE);
		$sVisible = $this->input->post('sVisible', TRUE);
		$sSave = $this->input->post('sSave', TRUE);
		$sUpdate = $this->input->post('sUpdate', TRUE);
		$sDelete = $this->input->post('sDelete', TRUE);

		$sReturn = null;

		for ($i = 0; $i < count($nMenuId); $i++) {
			$sRet = json_decode($this->m_core_apps->gf_check_field_in_table(array("bDisabledUnitId" => true, "sTableName" => "tm_user_menu", "sFieldName" => "nMenuId", "sContent" => trim($nMenuId[$i]), "sValueLabel" => "Menu Id")), TRUE);
			if (intVal($sRet['status']) === 0) {
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
				return $sReturn;
				exit(0);
			}
		}

		$this->db->trans_begin();

		$oConfig = $this->m_core_apps->gf_read_config_apps();

		$sql = "";
		for ($i = 0; $i < count($nMenuId); $i++) {
			$sql .= "call sp_tm_user_menu_auth ('" . (intval($nGroupUserId) === intval($oConfig['ADMIN_GROUP_ID']) ? 'X' : 'D') . "', " . trim($nGroupUserId) . ", " . trim($nMenuId[$i]) . ", NULL, NULL, NULL, NULL, NULL, 'MENU_APPS',  " . (intval($nGroupUserId) === intval($oConfig['ADMIN_GROUP_ID']) ? 'NULL' : trim($nUnitId)) . ", NULL, '" . trim($this->session->userdata('sRealName')) . "');";
		}
		$this->db->query($sql);

		if (intval($nGroupUserId) === intval($oConfig['ADMIN_GROUP_ID'])) //-- Klo Admin Gak Usah Pake Id Unit
		{
			$sql = "";
			for ($i = 0; $i < count($nMenuId); $i++) {
				$sql .= "call sp_tm_user_menu_auth ('I', " . trim($nGroupUserId) . ", " . trim($nMenuId[$i]) . ", " . ($i + 1) . ", '" . trim($sVisible[$i]) . "', '" . trim($sSave[$i]) . "', '" . trim($sUpdate[$i]) . "', '" . trim($sDelete[$i]) . "', 'MENU_APPS', NULL, NULL, '" . trim($this->session->userdata('sRealName')) . "');";
			}
			$this->db->query($sql);
		} else {
			$sql = "";
			for ($i = 0; $i < count($nMenuId); $i++) {
				$sql .= "call sp_tm_user_menu_auth ('I', " . trim($nGroupUserId) . ", " . trim($nMenuId[$i]) . ", " . ($i + 1) . ", '" . trim($sVisible[$i]) . "', '" . trim($sSave[$i]) . "', '" . trim($sUpdate[$i]) . "', '" . trim($sDelete[$i]) . "', 'MENU_APPS', " . trim($nUnitId) . ", NULL, '" . trim($this->session->userdata('sRealName')) . "');";
			}
			$this->db->query($sql);
		}

		//print $sql;
		//exit(0);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$sReturn = json_encode(array("status" => -1, "message" => "Failed"));
		} else {
			$this->db->trans_commit();
			$sReturn = json_encode(array("status" => 1, "message" => "Data has been Submitted."));
		}
		return $sReturn;
	}
}
