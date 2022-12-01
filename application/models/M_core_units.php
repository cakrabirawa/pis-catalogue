<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_units extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}
	function gf_load_data($sParam = null)
	{
		$oParam = $_POST;
		$oData = $sParam === null ? $oParam['Unit_Id'] : $sParam['Unit_Id'];
		$sql = "call sp_query('select * from tm_user_groups_units where nUnitId = " . $oData . " and sStatusDelete is null')";
		$rs = $this->db->query($sql);
		return $rs->result_array();
	}
	function gf_transact()
	{
		$txtUnitsId = $this->input->post('txtUnitsId', TRUE);
		$txtUnitsName  = $this->input->post('txtUnitsName', TRUE);
		$txtUnitsNameOld  = $this->input->post('txtUnitsNameOld', TRUE);
		$hideMode = $this->input->post('hideMode', TRUE);

		$sReturn = null;
		$UUID = "NULL";
		if (trim($hideMode) !== "I")
			$UUID = trim($txtUnitsId);
		if (in_array(trim($hideMode), array("I", "U"))) {
			if (strtolower(trim($txtUnitsName)) !== strtolower(trim($txtUnitsNameOld))) {
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("bDisabledUnitId" => TRUE, "sTableName" => "tm_user_groups_units", "sFieldName" => "sUnitName", "sContent" => trim($txtUnitsName))), TRUE);
				if (intVal($sRet['status']) === 1) {
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
					return $sReturn;
					exit(0);
				}
			}
		}
		if (in_array(trim($hideMode), array("D"))) {
			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => $this->db->database, "sFieldName" => "nUnitId_fk", "sContent" => trim($txtUnitsId), "sValueLabel" => "Unit Id")), TRUE);
			if (intVal($sRet['status']) === 1) {
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
				return $sReturn;
				exit(0);
			}
		}
		$sql = "call sp_tm_user_groups_units('" . trim($hideMode) . "', " . $UUID . ", '" . trim($txtUnitsName) . "', NULL, '" . trim($this->session->userdata('sRealName')) . "')";
		$this->db->trans_begin();
		$this->db->query($sql);
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
