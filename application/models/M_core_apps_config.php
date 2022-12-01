<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_apps_config extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}
	function gf_load_data($sParam = null)
	{
		$sReturn = null;
		$sql = "call sp_query('select * from tm_apps_config where sStatusDelete is null')";
		$rs = $this->db->query($sql);
		$i = 0;
		foreach ($rs->result_array() as $row) {
			$sReturn .= "<tr><td class=\"text-right\">" . ($i + 1) . "</td><td><input value=\"" . trim($row['sAppsConfigKey']) . "\" type=\"text\" name=\"txtConfigKey[]\" id=\"txtConfigKey\" class=\"form-control\" placeholder=\"Config Key\"></td><td><input value=\"" . trim($row['sAppsConfigValue']) . "\" type=\"text\" name=\"txtConfigValue[]\" id=\"txtConfigValue\" class=\"form-control\" placeholder=\"Config Value\"></td><td class=\"text-center\"><a name=\"cmd-remove-row\" id=\"cmd-remove-row\"><i class=\"text-red fa-2x fa fa-trash cursor-pointer\" title=\"Remove this Row\"></i></a></td></tr>";
			$i++;
		}
		return $sReturn;
	}
	function gf_transact()
	{
		$hideMode = $this->input->post('hideMode', TRUE);
		$sReturn = null;
		$UUID = "NULL";
		$this->db->trans_begin();
		$sql = "call sp_tm_apps_config('D', NULL, NULL, NULL, '" . trim($this->session->userdata('sRealName')) . "');";

		$txtConfigKey = $this->input->post('txtConfigKey', TRUE);
		$txtConfigValue = $this->input->post('txtConfigValue', TRUE);

		for ($i = 0; $i < count($txtConfigKey); $i++)
			$sql .= "call sp_tm_apps_config('I', '" . trim($txtConfigKey[$i]) . "', '" . htmlspecialchars(trim($txtConfigValue[$i]), ENT_NOQUOTES) . "', " . $i . ", '" . trim($this->session->userdata('sRealName')) . "');";

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
