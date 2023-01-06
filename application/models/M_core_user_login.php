<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_user_login extends CI_Model
{
	var $oConfig = null;
	var $oRepoRoot = "D:\\Repositories\\";
	var $oHTPASSWDRoot = "c:\\htpasswd.exe";
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}
	function gf_load_data($sParam = null)
	{
		$oParam = $_POST;
		$oData = $sParam === null ? $oParam['User_Id'] : $sParam['User_Id'];
		$sql = "select * from tm_user_logins where nUserId = " . $oData . " and sStatusDelete is null";
		$rs = $this->db->query($sql);
		return $rs->result_array();
	}
	function gf_transact()
	{
		$txtUserId 							= $this->input->post('txtUserId', TRUE);
		$txtUserName 						= $this->input->post('txtUserName', TRUE);
		$txtUserNameOld 				= $this->input->post('txtUserNameOld', TRUE);
		$txtRealName 						= $this->input->post('txtRealName', TRUE);
		$txtEmail 							= $this->input->post('txtEmail', TRUE);
		$txtEmailOld  					= $this->input->post('txtEmailOld', TRUE);
		$txtPassword 						= $this->input->post('txtPassword', TRUE);
		$txtPasswordAgain 			= $this->input->post('txtPasswordAgain', TRUE);
		$txtPasswordOld 				= $this->input->post('txtPasswordOld', TRUE);
		$hideMode 							= $this->input->post('hideMode', TRUE);
		$chkUnit 							 	= $this->input->post('chkUnit', TRUE);
		$chkGroup 						 	= $this->input->post('chkGroup', TRUE);
		$selUserGroups 					= $this->input->post('selUserGroups', TRUE);
		$sReturn 								= null;

		if (in_array(trim($hideMode), array("I", "U"))) {
			for ($i = 0; $i < count($chkGroup); $i++)
			{
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(
					array(
						"sTableName" => "tm_user_groups",
						"sFieldName" => "nGroupUserId",
						"sContent"   => trim($chkGroup[$i]),
						"bDisabledUnitId" => TRUE
					)
				), TRUE);
				if (intVal($sRet['status']) === -1) {
					$this->db->trans_rollback();
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
					return $sReturn;
					exit(0);
				}
			}
			if (strtolower(trim($txtUserName)) !== strtolower(trim($txtUserNameOld))) {
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(
					array(
						"sTableName" => "tm_user_logins",
						"sFieldName" => "sUserName",
						"sContent"   => trim($txtUserName),
						"bDisabledUnitId" => TRUE
					)
				), TRUE);

				if (intVal($sRet['status']) === 1) {
					$this->db->trans_rollback();
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
					return $sReturn;
					exit(0);
				}
			}
			if (strtolower(trim($txtEmail)) !== strtolower(trim($txtEmailOld))) {
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(
					array(
						"sTableName" => "tm_user_logins",
						"sFieldName" => "sEmail",
						"sContent"   => trim($txtEmail),
						"bDisabledUnitId" => TRUE
					)
				), TRUE);

				if (intVal($sRet['status']) === 1) {
					$this->db->trans_rollback();
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
					return $sReturn;
					exit(0);
				}
			}
		}
		if (in_array(trim($hideMode), array("D"))) {
			$this->db->trans_begin();
			$sql = "call sp_tm_user_units ('D', " . trim($txtUserId) . ", null, null, null, '" . trim($this->session->userdata('sRealName')) . "');";
			$sql .= "call sp_tm_user_logins_groups ('D', " . trim($txtUserId) . ", null, null, null, '" . trim($this->session->userdata('sRealName')) . "');";
			$this->db->query($sql);
			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => $this->db->database, "sFieldName" => "nUserId_fk", "sContent" => trim($txtUserId), "bDisabledUnitId" => true, "sValueLabel" => "User Id Already use in other Table. Delete process failed...")), TRUE);
			if (intVal($sRet['status']) === 1) {
				$this->db->trans_rollback();
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
				return $sReturn;
				exit(0);
			}
			$this->db->trans_rollback();
		}
		$this->db->trans_begin();
		$UUID = $this->m_core_apps->gf_max_int_id(array("sFieldName" => "nUserId", "sTableName" => "tm_user_logins", "sParam" => ""));
		if (trim($hideMode) !== "I")
			$UUID = trim($txtUserId);

		if (trim($txtPassword) === trim($txtPasswordOld) && trim($hideMode) === "U")
			$hideMode = "P";

		$sql =  "call sp_tm_user_logins ('" . trim($hideMode) . "', " . trim($UUID) . ", '" . trim($txtUserName) . "', '" . trim($txtRealName) . "', '" . trim($txtEmail) . "', '" . (trim($txtPassword)) . "', null, null, null, '" . trim($this->session->userdata('sRealName')) . "');";
		$sql .= "call sp_tm_user_units ('D', " . trim($UUID) . ", null, null, null, '" . trim($this->session->userdata('sRealName')) . "');";
		$sql .= "call sp_tm_user_logins_groups ('D', " . trim($UUID) . ", null, null, null, '" . trim($this->session->userdata('sRealName')) . "');";
		if (trim($hideMode) !== "D") {	
			for ($i = 0; $i < count($chkUnit); $i++)
				$sql .= "call sp_tm_user_units ('I', " . trim($UUID) . ", " . trim($chkUnit[$i]) . ", " . ($i + 1) . ", null, '" . trim($this->session->userdata('sRealName')) . "');";
			for ($i = 0; $i < count($selUserGroups); $i++)
				$sql .= "call sp_tm_user_logins_groups ('I', " . trim($UUID) . ", " . ($i + 1) . ", " . trim($selUserGroups[$i]) . ", null, '" . trim($this->session->userdata('sRealName')) . "');";
		}
		//exit($sql);
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
	function gf_load_auth($sParam = array())
	{
		//-----------------------------
		$oSkinButtonTX = "primary";
		$oSkinButtonDeleteTX = "danger";
		$oSkinButtonCancel = "default";
		//-----------------------------
		$sReturn = null;
		$sParam['sParams'] = empty($sParam['sParams']) ? "" : $sParam['sParams'];
		$nGroupUserId = $this->session->userdata('nGroupUserId_fk');
		$sql = "call sp_query('select a.nGroupUserId_fk, a.nMenuId_fk, a.nSeqNo, a.sVisible, a.sSave, a.sUpdate, a.sDelete from tm_user_menu_auth a inner join tm_user_menu b on b.nMenuId = a.nMenuId_fk where a.sStatusDelete is null and b.sStatusDelete is null and a.nGroupUserId_fk = " . trim($nGroupUserId) . " and lower(b.sMenuCtlName) = lower(''" . trim($sParam['sMenuCtlName']) . "'') " . trim($sParam['sParams']);

		$oConfig = $this->m_core_apps->gf_read_config_apps();
		if (!in_array($nGroupUserId, array(intval($oConfig['ADMIN_GROUP_ID'])))) //-- Admin, Abaikan
			$sql .= " and nUnitId_fk = " . $this->session->userdata('nUnitId_fk');
		$sql .= "');";
		$rs = $this->db->query($sql);
		$sCancel = "<button id=\"button-submit\" class=\"btn btn-" . trim($oSkinButtonCancel) . "\" type=\"button\">Cancel</button>";
		$sSave = "<button id=\"button-submit\" class=\"btn btn-" . trim($oSkinButtonTX) . "\" type=\"button\" disabled>Save</button>";
		$sUpdate = "<button id=\"button-submit\" class=\"btn btn-" . trim($oSkinButtonTX) . "\" type=\"button\" disabled>Update</button>";
		$sDelete = "<button id=\"button-submit\" class=\"btn btn-" . trim($oSkinButtonDeleteTX) . "\" type=\"button\" disabled>Delete</button>";
		$sReturn = json_encode(array("sSave" => $sSave, "sUpdate" => $sUpdate, "sDelete" => $sDelete, "sCancel" => $sCancel));
		if ($rs->num_rows() > 0) {
			$row = $rs->row_array();
			$sVisible = $row['sVisible'];
			$oSave = $row['sSave'];
			$oUpdate = $row['sUpdate'];
			$oDelete = $row['sDelete'];
			$sSave = "<button id=\"button-submit\" class=\"btn btn-" . trim($oSkinButtonTX) . "\" type=\"button\">Save</button>";
			if (intval($oSave) === 0)
				$sSave = "<button id=\"button-submit\" class=\"btn btn-" . trim($oSkinButtonTX) . "\" type=\"button\" disabled>Save</button>";
			$sUpdate = "<button id=\"button-submit\" class=\"btn btn-" . trim($oSkinButtonTX) . "\" type=\"button\">Update</button>";
			if (intval($oUpdate) === 0)
				$sUpdate = "<button id=\"button-submit\" class=\"btn btn-" . trim($oSkinButtonTX) . "\" type=\"button\" disabled>Update</button>";
			$sDelete = "<button id=\"button-submit\" class=\"btn btn-" . trim($oSkinButtonDeleteTX) . "\" type=\"button\">Delete</button>";
			if (intval($oDelete) === 0)
				$sDelete = "<button id=\"button-submit\" class=\"btn btn-" . trim($oSkinButtonTX) . "\" type=\"button\" disabled>Delete</button>";
			$sReturn = json_encode(array("sSave" => $sSave, "sUpdate" => $sUpdate, "sDelete" => $sDelete, "sCancel" => $sCancel));
		}
		//-- Notification to Admin
		$lm = $this->load->library('libMailHelper');
		$lm = new libMailHelper();
		$lm->gf_set_from("ado@gramedia.com");
		$lm->gf_set_recipient(array("ado@gramedia.com"));
		$lm->gf_set_subject("Logbook AP Access Notification");
		$lm->gf_set_body("Dear Admin,<br />" . $this->session->userdata('sRealName') . " has been access controller: <b>" . trim($sParam['sMenuCtlName']) . "</b>");
		$lm->gf_send();
		//--
		return $sReturn;
	}
	function gf_load_unit($sParams = array())
	{
		$sReturn = null;
		$sData = "";
		$sql = "call sp_query('select nUnitId, sUnitName, 0 as nFlag from tm_user_groups_units where sStatusDelete is null')";
		if (array_key_exists("bFill", $sParams)) {
			$sql = "call sp_query('select a.nUnitId, a.sUnitName, (select count(p.nUnitId_fk) from tm_user_units p where p.nUnitId_fk = a.nUnitId and p.sStatusDelete is null and p.nUserId_fk = " . trim($sParams['nUserId']) . " and p.nUnitId_fk = a.nUnitId) as nFlag from tm_user_groups_units a where a.sStatusDelete is null')";
		}

		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$i = 1;
			foreach ($rs->result_array() as $row) {
				$sData .= "<tr><td>" . $i . "</td><td>" . trim($row['sUnitName']) . "</td><td class=\"text-center\"><input value=\"" . trim($row['nUnitId']) . "\" type=\"checkbox\" style=\"vertical-align: middle;\" name=\"chkUnit[]\" id=\"chkUnit\" " . (intVal($row['nFlag']) === 1 ? "checked" : "") . "/></td></tr>";
				$i++;
			}
		}
		return json_encode(array("data" => $sData));
	}
	function gf_load_group($sParams = array())
	{
		$sReturn = null;

		$sUserGroups = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nGroupUserId, sGroupUserName  from tm_user_groups where sStatusDelete is null ", "sFieldId" => "nGroupUserId", "sFieldValues" => "sGroupUserName"));				

		$sData = "";
		if (array_key_exists("bFill", $sParams)) {
			$sql = "call sp_query('select a.nGroupUserId, a.sGroupUserName from tm_user_groups a inner join tm_user_logins_groups b on b.nGroupUserId_fk = a.nGroupUserId where a.sStatusDelete is null and b.sStatusDelete is null and b.nUserId_fk = ".trim($sParams['nUserId'])."')";
			$rs = $this->db->query($sql);
			if($rs->num_rows() > 0) {
				if (array_key_exists("bFill", $sParams)) {
					foreach ($rs->result_array() as $row) {
						$sData .= "<tr><td>1</td><td><select class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" id=\"selUserGroups\" init=\"".$row['nGroupUserId']."\" placeholder=\"User Group\" allow-empty=\"false\" name=\"selUserGroups[]\">".$sUserGroups."</select></td><td class=\"text-center\"><i id=\"iRemoveRow\" class=\"fa fa-trash fa-2x text-red cursor-pointer\" title=\"Remove this Row\"></i></td></tr>";
					}
				}
			}
			else {
				$sData = "<tr><td>1</td><td><select class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" id=\"selUserGroups\" placeholder=\"User Group\" allow-empty=\"false\" name=\"selUserGroups[]\">".$sUserGroups."</select></td><td class=\"text-center\"><i id=\"iRemoveRow\" class=\"fa fa-trash fa-2x text-red cursor-pointer\" title=\"Remove this Row\"></i></td></tr>";
			}
		}
		else {
			$sData = "<tr><td>1</td><td><select class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" id=\"selUserGroups\" placeholder=\"User Group\" allow-empty=\"false\" name=\"selUserGroups[]\">".$sUserGroups."</select></td><td class=\"text-center\"><i id=\"iRemoveRow\" class=\"fa fa-trash fa-2x text-red cursor-pointer\" title=\"Remove this Row\"></i>
			</td></tr>";
		}

		/*if ($rs->num_rows() > 0) {
			$i = 1;
			foreach ($rs->result_array() as $row) {
				$sData .= "<tr><td>" . $i . "</td><td>" . trim($row['sGroupUserName']) . "</td><td><select ".(intVal($row['nFlag']) === 1 ? "" : "disabled")."  class=\"form-control selectpicker ".(intVal($row['nFlag']) === 1 ? "" : "disabled")."\" data-size=\"8\" data-live-search=\"true\" id=\"selUserGroups\" name=\"selUserGroups[]\" init=\"".$row['nUserIdApproval_fk']."\">".$sUserGroups."</select></td><td><select class=\"form-control selectpicker ".(intVal($row['nFlag']) === 1 ? "" : "disabled")."\" ".(intVal($row['nFlag']) === 1 ? "" : "disabled")." data-size=\"8\" data-live-search=\"true\" name=\"selDivision[]\" id=\"selDivision\" init=\"".$row['nUserIdApproval_fk']."\"></select></td><td class=\"text-center\"><input value=\"" . trim($row['nGroupUserId']) . "\" type=\"checkbox\" style=\"vertical-align: middle;\" name=\"chkGroup[]\" id=\"chkGroup\" " . (intVal($row['nFlag']) === 1 ? "checked" : "") . "/></td></tr>";
				$i++;
			}
		}*/
		return json_encode(array("data" => $sData));
	}
	function gf_user_info($oParams = array())
	{
		$sReturnInfo = null;
		$sReturnDb = null;
		$oParams = array_key_exists("nUserId", $oParams) ? trim($oParams['nUserId']) : $this->session->userdata('nUserId');
		$sql = "call sp_query('select a.*, ".$this->session->userdata('nGroupUserId_fk')." as nGroupUserId_fk, (select q.sGroupUserName from tm_user_groups q where q.nGroupUserId = ".$this->session->userdata('nGroupUserId_fk')." and sStatusDelete is null) as sGroupUserName, (select p.dLogDate from tm_user_logs p where p.sLogType = ''LOGIN'' and p.nUserId_fk = " . $oParams . " order by dLogDate desc limit 1) as dLastLoginDate, (select p.dDevLogDate from tm_user_dev_log p where p.sStatusDelete is null order by dDevLogDate desc limit 1) as `DevLastDate` from tm_user_logins a where a.nUserId = " . $oParams . " and a.sStatusDelete is null')";
		$rs = $this->db->query($sql);
		$sReturnInfo = null;
		if ($rs->num_rows() > 0)
			$sReturnInfo = $rs->row_array();
		$sql = "call sp_query('select a.*, b.sUnitName from tm_user_units a inner join tm_user_groups_units b on b.nUnitId = a.nUnitId_fk where nUserId_fk = " . $oParams . " and a.sStatusDelete is null and b.sStatusDelete is null')";
		$rs = $this->db->query($sql);
		$sReturnDb = null;
		if ($rs->num_rows() > 0)
			$sReturnDb = $rs->result_array();
		//------ Debug For Change User Without LOGIN
		$sql = "call sp_query('select distinct a.nUserId, a.sUserName, a.sRealName, a.sAboutMe, (select p.nGroupUserId_fk from tm_user_logins_groups p where p.nUserId_fk = a.nUserId and p.sStatusDelete is null order by p.nGroupUserId_fk asc limit 1) as nGroupUserId_fk, (select q.sGroupUserName from tm_user_logins_groups p inner join tm_user_groups q on q.nGroupUserId = p.nGroupUserId_fk where p.nUserId_fk = a.nUserId and p.sStatusDelete is null and q.sStatusDelete is null order by p.nGroupUserId_fk asc limit 1) as sGroupUserName from tm_user_logins a inner join tm_user_units b on b.nUserId_fk = a.nUserId where a.sStatusDelete is null and b.sStatusDelete is null and b.nUnitId_fk = " . $this->session->userdata('nUnitId_fk') . " order by a.sRealName')";
		$rs = $this->db->query($sql);
		$sReturnUserList = null;
		if ($rs->num_rows() > 0)
			$sReturnUserList = $rs->result_array();
		//------ End Debug
		$sql = "call sp_query('select a.nGroupUserId_fk, b.sGroupUserName from tm_user_logins_groups a inner join tm_user_groups b on b.nGroupUserId = a.nGroupUserId_fk where a.sStatusDelete is null and b.sStatusDelete is null and a.nUserId_fk = " . $oParams . "')";
		$rs = $this->db->query($sql);
		$sReturnGroupUser = null;
		if ($rs->num_rows() > 0)
			$sReturnGroupUser = $rs->result_array();
		return json_encode(array("sInfo" => $sReturnInfo, "sDb" => $sReturnDb, "sUserList" => $sReturnUserList, "sGroupList" => $sReturnGroupUser));
	}
	function gf_clean_avatar()
	{
		$arrFileDb = array();
		$DS = DIRECTORY_SEPARATOR;
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$sql = "call sp_query('select sAvatar from tm_user_logins where sStatusDelete is null');";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $row)
				array_push($arrFileDb, trim($row['sAvatar']));
			//-------------------------
			$path = getcwd() . $DS . trim($oConfig['UPLOAD_DIR']) . $DS . "avatar" . $DS;
			if ($handle = opendir($path)) {
				while (false !== ($file = readdir($handle))) {
					if ('.' === trim($file)) continue;
					if ('..' === trim($file)) continue;
					if (!in_array(trim($file), $arrFileDb)) {
						if (file_exists($path . $file))
							unlink($path . $file);
					}
				}
				closedir($handle);
			}
		}
	}
	function gf_search_user_login()
	{
		$sql = "call sp_query('select a.nUserId, a.sUserName, a.sRealName, a.sAboutMe from tm_user_logins a where a.sStatusDelete is null and (lower(a.sRealName) like lower(''%" . $this->input->post('sParam', TRUE) . "%'') or lower(a.sUserName) like lower(''%" . $this->input->post('sParam', TRUE) . "%'')) order by a.sRealName')";
		$rs = $this->db->query($sql);
		return json_encode(array("sData" => $rs->result_array(), "sSQL" => $sql));
	}
	function gf_read_htpasswd_file()
	{
		$sReturn = null;
		$sHTPasswdPath = "D:\\Repositories\\htpasswd";
		$sReturn = file_get_contents($sHTPasswdPath);
		return $sReturn;
	}
	function gf_load_user_by_group_user()
	{
		$nGropUserId = $this->input->post('nGropUserId', TRUE);
		$sql = "call sp_query('select a.nUserId, concat(a.sRealName, '' ('', c.sNIK,'')'') as sRealName from tm_user_logins a inner join tm_user_logins_groups b on b.nUserId_fk = a.nUserId inner join tm_prepayment_karyawan c on c.sNIK = a.sUserName where c.sStatusDelete is null and a.sStatusDelete is null and b.sStatusDelete is null and b.nGroupUserId_fk = ".$nGropUserId."');";
		$sUserGroups = $this->m_core_apps->gf_load_select_option(array("sSQL" => $sql, "sFieldId" => "nUserId", "sFieldValues" => "sRealName"));
		return $sUserGroups;				

	}

}
