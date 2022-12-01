<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_edit_profile extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}
	function gf_transact()
	{
		$txtUserName 			= $this->input->post('txtUserName', TRUE);
		$txtUserNameOld 	= $this->input->post('txtUserNameOld', TRUE);
		$txtUserRealName 	= $this->input->post('txtUserRealName', TRUE);
		$txtEmail					= $this->input->post('txtEmail', TRUE);
		$txtEmailOld 			= $this->input->post('txtEmailOld', TRUE);
		$txtPassword 			= $this->input->post('txtPassword', TRUE);
		$txtPasswordAgain = $this->input->post('txtPasswordAgain', TRUE);
		$hideOldPassword 	= $this->input->post('hideOldPassword', TRUE);
		$nUserId 					= $this->session->userdata('nUserId');
		$txtAboutMe 			= $this->input->post('txtAboutMe', TRUE);
		$hideStatus 			= $this->input->post('hideStatus', TRUE);
		$sReturn 					= null;

		//Array

		$hideFileNameOld 	= $this->input->post('hideFileNameOld', TRUE);
		$hideFileName 		= $this->input->post('hideFileName', TRUE);
		$hideFileSize 		= $this->input->post('hideFileSize', TRUE);
		$hideFileHash 		= $this->input->post('hideFileHash', TRUE);
		$hideMode 				= $this->input->post('hideMode', TRUE);

		/*if(trim($hideStatus) !== "")
		{
			if(trim($hideFileNameOld[0]) !== "") {
				$sFileName = getcwd().DIRECTORY_SEPARATOR."uploads".DIRECTORY_SEPARATOR."avatar".DIRECTORY_SEPARATOR.trim($hideFileNameOld[0]);
				if(file_exists($sFileName))
					unlink($sFileName);
			}
		}*/

		$this->m_core_apps->gf_clean_avatar();

		if (in_array(trim($hideMode), array("I", "U"))) {
			if (strtolower(trim($txtUserName)) !== strtolower(trim($txtUserNameOld))) {
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(
					array(
						"sTableName" => "tm_user_logins",
						"sFieldName" => "sUserName",
						"sContent"   => trim($txtUserName)
					)
				), TRUE);

				if (intVal($sRet['status']) === 1) {
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
					return $sReturn;
					exit(0);
				}
			}
		}

		if (in_array(trim($hideMode), array("I", "U"))) {
			if (strtolower(trim($txtEmailOld)) !== strtolower(trim($txtEmail))) {
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_user_logins", "sFieldName" => "sEmail", "sContent" => trim($txtEmail))), TRUE);
				if (intVal($sRet['status']) === 1) {
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
					return $sReturn;
					exit(0);
				}
			}
		}
		$sql = "call sp_query('update tm_user_logins set sUserName = ''" . trim($txtUserName) . "'', sRealName = ''" . trim($txtUserRealName) . "'', sEmail = ''" . trim($txtEmail) . "'', sAboutMe = ''" . trim($txtAboutMe) . "'' ";
		if (trim($hideOldPassword) !== trim($txtPasswordAgain))
			$sql .= ", sPassword = md5(''" . trim($txtPassword) . "'') ";
		if(trim($hideFileName[0]) !== "")
			$sql .= ", sAvatar = ''" . trim($hideFileName[0]) . "'' ";
		$sql .= "where nUserId = " . $nUserId . " and sStatusDelete is null')";

		$this->db->trans_begin();
		$this->db->query($sql);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$sReturn = json_encode(array("status" => -1, "message" => "Failed"));
		} else {
			$this->session->set_userdata("sUserName", trim($txtUserName));
			$this->db->trans_commit();
			$sReturn = json_encode(array("status" => 1, "message" => "Data has been Submitted.", "avatar" => trim($hideFileName[0]) === "" ? trim($hideFileNameOld[0]) : trim($hideFileName[0])));
		}
		return $sReturn;
	}
}
