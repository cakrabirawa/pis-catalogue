<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_login extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('libMailHelper'));
		$this->load->model(array('m_core_apps'));
	}
	function gf_check_login()
	{
		$sReturn = null;
		$sUserName = $this->input->post("txtUserNameLogin", TRUE);
		$sPassword = $this->input->post("txtPassword", TRUE);
		$sSecCode = $this->input->post("txtSecCodeLogin1", TRUE);
		if (trim($sSecCode) !== trim($this->session->userdata('captcha')))
			$sReturn = array("status" => -1, "message" => "Invalid Security Code...");
		else {
			$selUnit = $this->input->post("selUnit", TRUE);

			$sql = "call sp_query('select a.*, b.nUnitId_fk, c.sUnitName, (select p.nGroupUserId_fk from tm_user_logins_groups p where p.nUserId_fk = a.nUserId and p.sStatusDelete is null order by p.nGroupUserId_fk asc limit 1) as nGroupUserId_fk, (select q.sGroupUserName from tm_user_logins_groups p inner join tm_user_groups q on q.nGroupUserId = p.nGroupUserId_fk where p.nUserId_fk = a.nUserId and p.sStatusDelete is null and q.sStatusDelete is null order by p.nGroupUserId_fk asc limit 1) as sGroupUserName from tm_user_logins a inner join tm_user_units b on b.nUserId_fk = a.nUserId inner join tm_user_groups_units c on c.nUnitId = b.nUnitId_fk where (a.sUserName = ''" . trim($sUserName) . "'' or a.sEmail = ''" . trim($sUserName) . "'') and a.sPassword = ''" . md5(trim($sPassword)) . "'' and a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null and a.sSessionForgotPassword is null limit 1')";
			$rs = $this->db->query($sql);
			if ($rs->num_rows() > 0) {
				$row = $rs->row_array();
				$this->session->set_userdata($row);
				$sReturn = array("status" => 1);
				$this->m_core_apps->gf_insert_log(array("sType" => "LOGIN", "sMessage" => "User Has Logged..."));
			} else
				$sReturn = array("status" => -1, "message" => "Invalid Login...");
		}
		return json_encode($sReturn);
	}
	function gf_logout()
	{
		$this->session->flashdata();
		$this->session->sess_destroy();
	}
	function gf_load_data($sParam = null)
	{
		$sPost = $this->input->post('hideData', TRUE);
		$oData = is_null($sParam) ? $sPost[0] : $sParam['nUserId'];
		$sql = "call sp_query('select a.* from tm_user_logins a where  a.sStatusDelete is null and a.nUserId = " . $oData . "')";
		$rs = $this->db->query($sql);
		return $rs->row_array();
	}
	function gf_forgot_password()
	{
		$sReturn = null;
		//-- Check User Name or Email
		$sReturn = null;
		$sUserName = $this->input->post("txtUserNameLogin", TRUE);
		$sPassword = $this->input->post("txtPassword", TRUE);

		$sql = "call sp_query('select a.*, b.nUnitId_fk, c.sUnitName from tm_user_logins a inner join tm_user_units b on b.nUserId_fk = a.nUserId inner join tm_user_groups_units c 
						on c.nUnitId = b.nUnitId_fk where (a.sUserName = ''" . trim($sUserName) . "'' or a.sEmail = ''" . trim($sUserName) . "'') and a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null limit 1')";
		$rs = $this->db->query($sql);
		$row = $rs->row_array();
		if ($rs->num_rows() === 0)
			$sReturn = json_encode(array("status" => -1, "message" => "Invalid Email, Please check Email Address..."));
		else {
			$this->db->trans_begin();
			//-- Update sSessionForgotPassword jadi ke ISI
			$sql = "call sp_query('update tm_user_logins set sSessionForgotPassword = md5(concat(now(), uuid())) where (sUserName = ''" . trim($sUserName) . "'' or sEmail = ''" . trim($sUserName) . "'') and sStatusDelete is null')";
			$this->db->query($sql);
			if ($this->db->trans_status() === FALSE)
				$this->db->trans_rollback();
			else
				$this->db->trans_commit();
			//-- Send Email

			$sql = "call sp_query('select a.*, b.nUnitId_fk, c.sUnitName from tm_user_logins a inner join tm_user_units b on b.nUserId_fk = a.nUserId inner join tm_user_groups_units c 
							on c.nUnitId = b.nUnitId_fk where (a.sUserName = ''" . trim($sUserName) . "'' or a.sEmail = ''" . trim($sUserName) . "'') and a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null limit 1')";
			$rs = $this->db->query($sql);
			$row = $rs->row_array();
			$s = "<div class=\"col-lg-12\">Dear <b>" . trim($row['sRealName']) . "</b>,<br /><br />You have make a request to reset your password to access <b>" . $this->config->item('ConAppName') . "</b> Application. Click <a href=\"" . site_url() . "c_core_forgot_password/d/" . trim($row['sSessionForgotPassword']) . "\" class=\"text-red\">here</a> to reset your password.<br />Request Reset Date Time: " . date('d/m/Y H:i:s') . "<br />Request From: " . $this->m_core_apps->gf_get_user_ip() . "<br /><br />Sent from " . $this->config->item('ConAppName') . "  - Mail Blash Engine.<br />Sent Date Time: " . date('d/m/Y H:i:s') . "</div>" . str_repeat("<br />", 30);
			$oRet = $this->m_core_apps->gf_send_email(
				array(
					"sSubject" => trim($this->config->item('ConAppName')) . " - Request Reset Password",
					"sAltBody" => "",
					"sTO" => trim($row['sEmail']),
					"sName" => "Gramedia BOX",
					"sMessage" => "<!DOCTYPE html><html><head><meta charset=\"utf-8\"><meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"><meta content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" name=\"viewport\"><link rel=\"stylesheet\" href=\"" . site_url() . "bootstrap/css/bootstrap.min.css\" /><link rel=\"stylesheet\" href=\"" . site_url() . "dist/css/AdminLTE.min.css\" /><style>* { font-family: tahoma; font-size: 11px; }</style></head><body style=\"background-image: url('" . site_url() . "c_core_login/gf_load_file')\">" . $s . "</body></html>"
				)
			);

			$sReturn = json_encode(array("status" => 1, "message" => "We are was sent email to your mailbox. Please check there and follow the instruction.", "mailexception" => $oRet));
		}
		return $sReturn;
	}
	function gf_register()
	{
		$sReturn = null;
		$txtUserNameLogin = $this->input->post('txtUserNameLogin', TRUE);
		$txtRealName = $this->input->post('txtRealName', TRUE);
		$txtPassword = $this->input->post('txtPassword', TRUE);
		$sql = "call sp_query('select count(sEmail) as c from tm_user_logins where sEmail = ''" . trim($txtUserNameLogin) . "'' and sStatusDelete is null')";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $rs->row_array();
			if (intval($row['c']) > 0)
				$sReturn = json_encode(array("status" => -1, "message" => "Email: <b>" . trim($txtUserNameLogin) . "</b> already exists. Please use another Email Address or use forgot password if you want to reset your password."));
			else {
				$this->db->trans_begin();
				$sql = "call sp_tm_user_logins ('I', NULL, NULL, '" . trim($txtRealName) . "', '" . trim($txtUserNameLogin) . "', '" . trim($txtPassword) . "', 2, NULL, '" . trim($txtRealName) . "', null, null)";
				$this->db->query($sql);
				$sHash = md5(trim($txtUserNameLogin) . date('dmYHis'));
				$sql = "call sp_query('update tm_user_logins set sSessionForgotPassword = (''" . trim($sHash) . "'') where sEmail = ''" . trim($txtUserNameLogin) . "'' and sStatusDelete is null')";
				$this->db->query($sql);
				if ($this->db->trans_status() === FALSE)
					$this->db->trans_rollback();
				else {
					$this->db->trans_commit();
					$s = "<div class=\"col-lg-12\">Dear <b>" . trim($txtRealName) . "</b>,<br /><br />You have successfully regeistered to <b>" . $this->config->item('ConAppName') . "</b> Application. For completed registration, please click <a href=\"" . site_url() . "c_core_login/gf_activation/" . trim($sHash) . "\" class=\"text-red\">here</a> to activation your account.<br />Request Reset Date Time: " . date('d/m/Y H:i:s') . "<br />Request From: " . $this->m_core_apps->gf_get_user_ip() . "<br /><br />Sent from " . $this->config->item('ConAppName') . "  - Mail Blash Engine.<br />Sent Date Time: " . date('d/m/Y H:i:s') . "</div>" . str_repeat("<br />", 30);
					$oRet = $this->m_core_apps->gf_send_email(
						array(
							"sSubject" => trim($this->config->item('ConAppName')) . " - Registration",
							"sAltBody" => "",
							"sTO" => trim($txtUserNameLogin),
							"sName" => trim($txtRealName),
							"sMessage" => "<!DOCTYPE html><html><head><meta charset=\"utf-8\"><meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\"><meta content=\"width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no\" name=\"viewport\"><link rel=\"stylesheet\" href=\"" . site_url() . "bootstrap/css/bootstrap.min.css\" /><link rel=\"stylesheet\" href=\"" . site_url() . "dist/css/AdminLTE.min.css\" /><style>* { font-family: tahoma; font-size: 11px; }</style></head><body style=\"background-image: url('" . site_url() . "c_core_login/gf_load_file')\">" . $s . "</body></html>"
						)
					);
					$sReturn = json_encode(array("status" => 1, "message" => "Congratulation! Registered process has been completed. Please check your Inbox and follow the instruction."));
				}
			}
		}
		return $sReturn;
	}
	function gf_activation($sHash = null)
	{
		$sReturn = null;
		if (trim($sHash) === null)
			$sReturn = json_encode(array("status" => -1, "message" => "Invalid Registration Process!!!"));
		else {
			$sql = "call sp_query('select sSessionForgotPassword, sEmail from tm_user_logins where sSessionForgotPassword = ''" . trim($sHash) . "'' and sStatusDelete is null')";
			$rs = $this->db->query($sql);
			if ($rs->num_rows() > 0) {
				$row = $rs->row_array();
				if (trim($row['sSessionForgotPassword']) === "") {
					$sReturn = json_encode(array("status" => -1, "message" => "Invalid Registration Process!!!"));
				} else {
					$sql = "call sp_query('update tm_user_logins set sSessionForgotPassword = NULL where sEmail = ''" . trim($row['sEmail']) . "'' and sStatusDelete is null and sSessionForgotPassword is not null and trim(sSessionForgotPassword) <> '''' ')";
					$this->db->query($sql);
					if ($this->db->trans_status() === FALSE)
						$this->db->trans_rollback();
					else {
						$this->db->trans_commit();
						$sReturn = json_encode(array("status" => 1, "message" => "Congratulation. You have successfully to activation your account.", "sData" => $row));
					}
				}
			} else {
				$sReturn = json_encode(array("status" => -1, "message" => "Invalid Registration. Please check your Registration Process!!!"));
			}
		}
		return $sReturn;
	}
	function gf_is_admin()
	{
		$sql = "call sp_query('select nGroupUserId_fk from tm_user_logins where nUserId = " . $this->session->userdata('nUserId') . " and sStatusDelete is null')";
		$rs = $this->db->query($sql);
		$row = $rs->row_array();
		return json_encode(array("IsAdmin" => intval($row['nGroupUserId_fk']) === 0));
	}
	function gf_change_login($nUserId = null)
	{
		$sql = "call sp_query('select a.*, b.nUnitId_fk, c.sUnitName, (select p.sGroupUserName from tm_user_groups p inner join tm_user_logins_groups q on q.nGroupUserId_fk = p.nGroupUserId where p.sStatusDelete is null and q.sStatusDelete is null and q.nUserId_fk = " . trim($nUserId) . " order by q.nSeqNo desc limit 1) as `sGroupUserName`, (select q.nGroupUserId_fk from tm_user_groups p inner join tm_user_logins_groups q on q.nGroupUserId_fk = p.nGroupUserId where p.sStatusDelete is null and q.sStatusDelete is null and q.nUserId_fk = " . trim($nUserId) . " order by q.nSeqNo desc limit 1) as nGroupUserId_fk from tm_user_logins a inner join tm_user_units b on b.nUserId_fk = a.nUserId inner join tm_user_groups_units c on c.nUnitId = b.nUnitId_fk where a.nUserId = " . trim($nUserId) . " and a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null and a.sSessionForgotPassword is null limit 1')";
		//exit($sql);
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$user_data = $this->session->all_userdata();
			foreach ($user_data as $key => $value) {
				if (in_array(trim($key), array('session_id', 'ip_address', 'user_agent', 'last_activity')))
					$this->session->unset_userdata($key);
			}
			$row = $rs->row_array();
			$this->session->set_userdata($row);
			if (intval($row['nGroupUserId_fk']) > 0) {
				//$sql = "call sp_query('select * from tm_sco_employee where sEmployeeNIK = ''".$row['sUserName']."'' and sStatusDelete is null')";
				//$rs = $this->db->query($sql);
				//$row = $rs->row_array();
				//$this->session->set_userdata($row);
			} else {
				foreach ($user_data as $key => $value) {
					if (in_array(trim($key), array('session_id', 'ip_address', 'user_agent', 'last_activity')))
						$this->session->unset_userdata($key);
				}
			}
			//-------------------------------------------- End Get Employee Info
			$sReturn = array("status" => 1);
			$this->m_core_apps->gf_insert_log(array("sType" => "LOGIN", "sMessage" => "User Has Logged..."));
		} else
			$sReturn = array("status" => -1, "message" => "Invalid Login...");
		return json_encode($sReturn);
	}
}
