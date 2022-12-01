<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_open_reports_auth extends CI_Model
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
		$nIdOpenReport = $this->input->post('nIdOpenReport', TRUE);
		$nGroupUserId = $this->input->post('nGroupUserId', TRUE);
		$nUnitId = $this->input->post('nUnitId', TRUE);
		$sVisible = $this->input->post('sVisible', TRUE);
		$sSave = $this->input->post('sSave', TRUE);
		$sUpdate = $this->input->post('sUpdate', TRUE);
		$sDelete = $this->input->post('sDelete', TRUE);

		$sReturn = null;

		for ($i = 0; $i < count($nIdOpenReport); $i++) {
			$sRet = json_decode($this->m_core_apps->gf_check_field_in_table(array("bDisabledUnitId" => true, "sTableName" => "tm_user_open_reports", "sFieldName" => "nIdOpenReport", "sContent" => trim($nIdOpenReport[$i]), "sValueLabel" => "Menu Id")), TRUE);
			if (intVal($sRet['status']) === 0) {
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
				return $sReturn;
				exit(0);
			}
		}
		$this->db->trans_begin();
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$sql = "";
		for ($i = 0; $i < count($nIdOpenReport); $i++) {
			$sql .= "call sp_tm_user_menu_auth ('" . (intval($nGroupUserId) === intval($oConfig['ADMIN_GROUP_ID']) ? 'X' : 'D') . "', " . trim($nGroupUserId) . ", " . trim($nIdOpenReport[$i]) . ", NULL, NULL, NULL, NULL, NULL, 'MENU_OPEN_REPORTS',  " . (intval($nGroupUserId) === intval($oConfig['ADMIN_GROUP_ID']) ? 'NULL' : trim($nUnitId)) . ", NULL, '" . trim($this->session->userdata('sRealName')) . "');";
		}
		$this->db->query($sql);
		if (intval($nGroupUserId) === intval($oConfig['ADMIN_GROUP_ID'])) //-- Klo Admin Gak Usah Pake Id Unit
		{
			$sql = "";
			for ($i = 0; $i < count($nIdOpenReport); $i++) {
				$sql .= "call sp_tm_user_menu_auth ('I', " . trim($nGroupUserId) . ", " . trim($nIdOpenReport[$i]) . ", " . ($i + 1) . ", '" . trim($sVisible[$i]) . "', '" . trim($sSave[$i]) . "', '" . trim($sUpdate[$i]) . "', '" . trim($sDelete[$i]) . "', 'MENU_OPEN_REPORTS', NULL, NULL, '" . trim($this->session->userdata('sRealName')) . "');";
			}
			$this->db->query($sql);
		} else {
			$sql = "";
			for ($i = 0; $i < count($nIdOpenReport); $i++) {
				$sql .= "call sp_tm_user_menu_auth ('I', " . trim($nGroupUserId) . ", " . trim($nIdOpenReport[$i]) . ", " . ($i + 1) . ", '" . trim($sVisible[$i]) . "', '" . trim($sSave[$i]) . "', '" . trim($sUpdate[$i]) . "', '" . trim($sDelete[$i]) . "', 'MENU_OPEN_REPORTS', " . trim($nUnitId) . ", NULL, '" . trim($this->session->userdata('sRealName')) . "');";
			}
			$this->db->query($sql);
		}
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
