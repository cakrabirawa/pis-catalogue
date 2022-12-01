<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_dev_logs extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}

	function gf_load_data($sParam = null)
	{
		$oParam = $_POST;
		$oData = $sParam === null ? $oParam['Dev_Logs_Id'] : $sParam['Dev_Logs_Id'];
		$sql = "call sp_query('select sDevLogId, sDevLogName, date_format(dDevLogDate, ''%d/%m/%Y'') as dDevLogDate, sDevLogDesc, sDevLogIdParent_fk, nPercentage from tm_user_dev_log where sStatusDelete is null and sDevLogId = ''" . trim($oData) . "'' ')";
		$rs = $this->db->query($sql);
		return $rs->result_array();
	}

	function gf_transact()
	{
		$txtDevLogId = $this->input->post('txtDevLogId', TRUE);
		$txtDevLogDate = $this->input->post('txtDevLogDate', TRUE);
		$hideMode = $this->input->post('hideMode', TRUE);
		$txtDevLogDesc = $this->input->post('txtDevLogDesc', TRUE);
		$selDevLogSubjectParent = $this->input->post('selDevLogSubjectParent', TRUE);
		$txtDevLogSubject = $this->input->post('txtDevLogSubject', TRUE);
		$selDevLogPercentage = $this->input->post('selDevLogPercentage', TRUE);
		$sReturn = null;

		$UUID = "NULL";
		if (trim($hideMode) !== "I")
			$UUID = trim($txtDevLogId);

		$sql = "call sp_tm_user_dev_log ('" . trim($hideMode) . "', '" . trim($UUID) . "', '" . trim($txtDevLogSubject) . "', '" . $this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtDevLogDate), "sSeparatorFrom" => "/", "sSeparatorTo" => "-")) . " " . date('H:i:s') . "', '" . trim($txtDevLogDesc) . "', " . (trim($selDevLogSubjectParent) === "" ? "NULL" : "'" . trim($selDevLogSubjectParent) . "'") . ", " . trim($selDevLogPercentage) . ", '" . trim($this->session->userdata('sRealName')) . "')";

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
