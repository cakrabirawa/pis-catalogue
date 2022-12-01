<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_user_group extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}

	function gf_load_data($sParam = null)
	{
		$oParam = $_POST;
		$oData = is_null($sParam) ? $oParam['Group_User_Id'] : $sParam['Group_User_Id'];
		$sql = "select * from tm_user_groups where nGroupUserId = " . $oData . " and sStatusDelete is null";
		$rs = $this->db->query($sql);
		return $rs->result_array();
	}

	function gf_transact()
	{
		$txtUserGroupId = $this->input->post('txtUserGroupId', TRUE);
		$txtUserGroupName = $this->input->post('txtUserGroupName', TRUE);
		$hideMode = $this->input->post('hideMode', TRUE);
		$txtUserGroupNameOld = $this->input->post('txtUserGroupNameOld', TRUE);

		$sReturn = null;

		$UUID = "NULL";
		if (trim($hideMode) !== "I")
			$UUID = trim($txtUserGroupId);

		if (in_array(trim($hideMode), array("I", "U"))) {
			if (strtolower(trim($txtUserGroupNameOld)) !== strtolower(trim($txtUserGroupName))) {
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(
					array(
						"sTableName" => "tm_user_groups",
						"sFieldName" => "sGroupUserName",
						"sContent"   => trim($txtUserGroupName),
						"bDisabledUnitId" => true
					)
				), TRUE);

				if (intVal($sRet['status']) === 1) {
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
					return $sReturn;
					exit(0);
				}
			}
		}

		if (in_array(trim($hideMode), array("D"))) {
			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(
				array(
					"sDatabaseName" => "mystores",
					"sFieldName" => "nGroupUserId_fk",
					"sContent"   => trim($txtUserGroupId),
					"sValueLabel" => "User Group Name",
					"bDisabledUnitId" => true
				)
			), TRUE);

			if (intVal($sRet['status']) === 1) {
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
				return $sReturn;
				exit(0);
			}
		}

		$sql = "call sp_tm_user_groups ('" . trim($hideMode) . "', " . trim($UUID) . ", '" . trim($txtUserGroupName) . "', null, '" . trim($this->session->userdata('sRealName')) . "')";

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
