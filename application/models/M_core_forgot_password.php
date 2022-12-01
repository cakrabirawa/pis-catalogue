<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_forgot_password extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}

	function gf_load_info($sSession = "")
	{
		$sql = "call sp_query('select a.*, b.nUnitId_fk, c.sUnitName from tm_user_logins a inner join tm_user_units b on b.nUserId_fk = a.nUserId inner join tm_user_groups_units c 
						on c.nUnitId = b.nUnitId_fk where sSessionForgotPassword = ''" . trim($sSession) . "'' and a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null limit 1')";
		$rs = $this->db->query($sql);
		return json_encode($rs->row_array());
	}

	function gf_reset_password()
	{
		$txtPassword = $this->input->post("txtPassword", TRUE);
		$txtPasswordAgain = $this->input->post("txtPasswordAgain", TRUE);
		$sSession = $this->input->post("sSession", TRUE);
		//---------------------------------------------------------------
		$sql = "call sp_query('select a.*, b.nUnitId_fk, c.sUnitName from tm_user_logins a inner join tm_user_units b on b.nUserId_fk = a.nUserId inner join tm_user_groups_units c on c.nUnitId = b.nUnitId_fk where sSessionForgotPassword = ''" . trim($sSession) . "'' and a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null limit 1')";
		$rs = $this->db->query($sql);
		$row = $rs->row_array();
		$s = "<div class=\"col-lg-12\">Dear <b>" . trim($row['sRealName']) . "</b>,<br />You have successfully changed the password. Click <a href=\"" . site_url() . "\" class=\"text-red\">here</a> to go to Application.<br /><br />Sent from " . $this->config->item('ConAppName') . "  - Mail Blash Engine.<br />Sent Date Time: " . date('d/m/Y H:i:s') . "</div>" . str_repeat("<br />", 30);
		$oRet = $this->m_core_apps->gf_send_email(
			array(
				"sSubject" => trim($this->config->item('ConAppName')) . " - Information about Reset Password",
				"sAltBody" => "",
				"sTO" => "ado@gramedia.com",
				"sName" => "Edwar Rinaldo",
				"sMessage" => "<!DOCTYPE html><html><head><meta charset=\"utf-8\"><meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"><meta content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" name=\"viewport\"><link rel=\"stylesheet\" href=\"" . site_url() . "bootstrap/css/bootstrap.min.css\" /><link rel=\"stylesheet\" href=\"" . site_url() . "dist/css/AdminLTE.min.css\" /><style>* { font-family: tahoma; font-size: 11px; }</style></head><body style=\"background-image: url('" . site_url() . "c_core_login/gf_load_file')\">" . $s . "</body></html>"
			)
		);
		//---------------------------------------------------------------
		$this->db->trans_begin();
		//-- Update sSessionForgotPassword jadi ke ISI
		$sql = "call sp_query('update tm_user_logins set sPassword = md5(''" . trim($txtPassword) . "''), sSessionForgotPassword = NULL where nUserId = " . trim($row['nUserId']) . " and sStatusDelete is null')";
		$this->db->query($sql);
		if ($this->db->trans_status() === FALSE)
			$this->db->trans_rollback();
		else
			$this->db->trans_commit();
		return json_encode(array("status" => 1, "message" => "You have successfully reset your password."));
	}
}
