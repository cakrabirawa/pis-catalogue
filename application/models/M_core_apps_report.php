<?php
/*
------------------------------
Menu Name: Reports
File Name: M_core_apps_report.php
File Path: D:\Project\PHP\billing\application\models\M_core_apps_report.php
Create Date Time: 2019-06-27 21:19:31
------------------------------
*/
class m_core_apps_report extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}
	function gf_load_data($sParam = null)
	{
		$oParam = $_POST;
		$oData = $sParam === null ? $oParam['Id_Open_Reports'] : $sParam['Id_Open_Reports'];
		$sql = "call sp_query('select a.nOpenReportOutput, a.sHideColumns, a.sOpenReportsStaticParamsExcel, a.sOpenReportsDesc, a.sOpenReportsStaticParams, a.nIdOpenReport, a.nIdOpenReportParent_fk, a.sOpenReportsName, a.sOpenReportsSQL, a.nOpenReportsType, (select p.sOriginalFileName from tm_user_uploads p where p.sStatusDelete is null and p.sUploadId = a.sUUID) as sFileName, (select concat(p.sPathFile, p.sEncryptedFileName) from tm_user_uploads p where p.sStatusDelete is null and p.sUploadId = a.sUUID) as sFullFileName, a.nShowToUser, sUUID  from tm_user_open_reports a where a.sStatusDelete is null and a.nIdOpenReport = " . trim($oData) . "')";
		$rs = $this->db->query($sql);
		return $rs->result_array();
	}
	function gf_load_uploads_data($sUUID = null)
	{
		$sql = "call sp_query('select * from tm_user_uploads where sUploadId = ''" . trim($sUUID) . "'' and sStatusDelete is null');";
		return $this->db->query($sql)->row_array();
	}
	function gf_transact()
	{
		$txtIdOpenReports 					= $this->input->post('txtIdOpenReports', TRUE);
		$selIdOpenReportsParent 		= $this->input->post('selIdOpenReportsParent', TRUE);
		$txtOpenReportsName 				= $this->input->post('txtOpenReportsName', TRUE);
		$txtOpenReportsNameOld 			= $this->input->post('txtOpenReportsNameOld', TRUE);
		$hideSQL 										= $this->input->post('hideSQL', TRUE);
		$selOpenReportsType 				= $this->input->post('selOpenReportsType', TRUE);
		$selOpenReportsVisible 			= $this->input->post('selOpenReportsVisible', TRUE);
		$hideStaticParamsJSONSQL 		= $this->input->post('hideStaticParamsJSONSQL', TRUE);
		$hideStaticParamsJSONExcel 	= $this->input->post('hideStaticParamsJSONExcel', TRUE);
		$txtOpenReportsDesc 				= $this->input->post('txtOpenReportsDesc', TRUE);
		$txtHideColumn 							= $this->input->post('txtHideColumn', TRUE);
		$selOpenReportsOutput 			= $this->input->post('selOpenReportsOutput', TRUE);
		$hidePath 									= $this->input->post('hidePath', TRUE);
		$txtFileName 								= $this->input->post('txtFileName', TRUE);
		$hideRemoveUpload 					= $this->input->post('hideRemoveUpload', TRUE);
		$sUUIDOld 									= $this->input->post('sUUIDOld', TRUE);
		$sFullPathName 							= $this->input->post('sFullPathName', TRUE);

		//Array
		$hideFileName = $this->input->post('hideFileName', TRUE);
		$hideFileSize = $this->input->post('hideFileSize', TRUE);
		$hideFileHash = $this->input->post('hideFileHash', TRUE);
		$hideFileExt  = $this->input->post('hideFileExt', TRUE);

		$hideMode = $this->input->post('hideMode', TRUE);
		$sReturn = null;
		$UUID = "NULL";
		if (trim($hideMode) !== "I")
			$UUID = trim($txtIdOpenReports);
		if (in_array(trim($hideMode), array("I", "U"))) {
			if (strtolower(trim($txtOpenReportsName)) !== strtolower(trim($txtOpenReportsNameOld))) {
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("bDisabledUnitId" => TRUE, "sTableName" => "tm_user_open_reports", "sFieldName" => "sOpenReportsName", "sContent" => trim($txtOpenReportsName))), TRUE);
				if (intVal($sRet['status']) === 1) {
					$sReturn = json_encode(array("status" => 1, "message" => trim($sRet['message'])));
					return $sReturn;
					exit(0);
				}
			}
		}

		$sUniqueId = md5(uniqid());

		$sql = "call sp_tm_user_open_reports('" . $hideMode . "', " . trim($UUID) . ", " . (trim($selIdOpenReportsParent) === "" ? "NULL" : trim($selIdOpenReportsParent)) . ", '" . trim($txtOpenReportsName) . "', '" . str_replace("'", "''", trim($hideSQL)) . "', " . (trim($selOpenReportsType) === "" ? "NULL" : trim($selOpenReportsType)) . ", " . (trim($selOpenReportsVisible) === "" ? "NULL" : trim($selOpenReportsVisible)) . ", '" . str_replace("'", "''", trim($hideStaticParamsJSONSQL)) . "', '" . trim($txtOpenReportsDesc) . "', '" . trim($hideStaticParamsJSONExcel) . "', '" . trim($sUniqueId) . "', '" . trim($this->session->userdata('sRealName')) . "', '" . trim($txtHideColumn) . "', " . $selOpenReportsOutput . ");";


		if (trim($hideMode) === "U" || trim($hideMode) === "D") {
			if (trim($hideFileName[0]) !== "") //-- Update dan ganti file
			{
				$sql .= "call sp_tm_user_uploads('G', '" . trim($sUniqueId) . "', null, null, null, null, null, null, null, null, null, null, " . $this->session->userdata('nUnitId_fk') . ", null, '" . trim($this->session->userdata('sRealName')) . "');";
				if (trim($hideRemoveUpload) === "1") {
					//delete file
					$sFilePath = getcwd() . DIRECTORY_SEPARATOR . $sFullPathName;
					if (file_exists($sFilePath))
						unlink($sFilePath);
				}
			} else {
				$sql .= "call sp_query('update tm_user_uploads set sUploadId = ''" . trim($sUniqueId) . "'' where sUploadId = ''" . trim($sUUIDOld) . "'' and sStatusDelete is null and nUnitId_fk = " . $this->session->userdata('nUnitId_fk') . "');";
				if (trim($hideRemoveUpload) === "1") {
					$sql .= "call sp_tm_user_uploads('G', '" . trim($sUniqueId) . "', null, null, null, null, null, null, null, null, null, null, " . $this->session->userdata('nUnitId_fk') . ", null, '" . trim($this->session->userdata('sRealName')) . "');";
					$sFilePath = getcwd() . DIRECTORY_SEPARATOR . $sFullPathName;
					if (file_exists($sFilePath))
						unlink($sFilePath);
				}
			}
		}

		if (trim($hideMode) !== "D") {
			if (trim($hideFileName[0]) !== "") //-- Update dan ganti file
			{
				$sql .= "call sp_tm_user_uploads('I', '" . trim($sUniqueId) . "', '" . trim($txtFileName) . "', '" . trim($hideFileName[0]) . "', '" . trim($hideFileExt[0]) . "', '" . trim($hidePath) . "', " . trim($hideFileSize[0]) . ", " . $this->session->userdata('nUserId') . ", '" . trim($UUID) . "', null, null, null, " . $this->session->userdata('nUnitId_fk') . ", null, '" . trim($this->session->userdata('sRealName')) . "');";
			}
		}

		//exit($sql);

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
	function gf_parse_sql_x($sParams=null)
	{
		$sql = $sParams === null ? $this->input->post('hideSQL', TRUE) : trim($sParams['hideSQL']);
		$a = array(
								"@nUnitId", 
								"@dbname", 
								"@siteurl",
								"@loginrealname",
								"@datenow",
							);
		$b = array(
								$this->session->userdata('nUnitId_fk'), 
								trim($this->db->database), 
								site_url(),
								$this->session->userdata('sRealName'),
								date('d/m/Y H:i:s'),
							);
		$sql = str_replace($a, $b, $sql);
		return $sql;
	}
	function gf_parse_sql()
	{
		$sReturn = null;
		$sql = $this->gf_parse_sql_x(array("hideSQL" => trim($this->input->post('hideSQL', TRUE))));
		$sSQLSplit = explode("~", trim($sql));
		$nCountOfSQL = count($sSQLSplit);
		for ($i = 0; $i < $nCountOfSQL; $i++) {
			$rs = $this->db->query($sSQLSplit[$i]);
			$sReturn[$i] = array("data" . $i => $rs->result_array());
		}
		return json_encode(array("oData" => $sReturn, "oReportInfo" => null, "session" => array("login" => $this->session->userdata(), "datetime" => date('d/m/Y H:i:s'))));
	}
	function gf_copy_data()
	{
		$sReturn = null;
		$nIdOpenReport = $this->input->post('nIdOpenReport', TRUE);
		$sUUID = uniqid();
		$sql = "call sp_query('insert into tm_user_open_reports(nIdOpenReport, nIdOpenReportParent_fk, sOpenReportsName, sOpenReportsSQL, nOpenReportsType, nShowToUser, sOpenReportsStaticParams, sOpenReportsDesc, sOpenReportsStaticParamsExcel, sHideColumns, sCreateBy, dCreateOn, sUUID) select (select case when count(nIdOpenReport) = 0 then 1 else max(nIdOpenReport) + 1 end from tm_user_open_reports), nIdOpenReportParent_fk, concat(''Copy of '', sOpenReportsName), sOpenReportsSQL, nOpenReportsType, nShowToUser, sOpenReportsStaticParams, sOpenReportsDesc, sOpenReportsStaticParamsExcel, sHideColumns, sCreateBy, dCreateOn, ''".trim($sUUID)."'' from tm_user_open_reports where nIdOpenReport = " . trim($nIdOpenReport) . " and sStatusDelete is null');";
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
	function gf_download_report()
	{
		$hideUploadId 	= $this->input->post('hideUploadId', TRUE);
		$row 						= $this->gf_load_uploads_data($hideUploadId);
		$DS  	 					= DIRECTORY_SEPARATOR;
		$file  					= getcwd() . $DS . $row['sPathFile'] . $DS . $row['sEncryptedFileName'];
		$file_extension = strtolower(substr(strrchr(basename($file), "."), 1));
		switch ($file_extension) {
			case "mrt":
				$ctype = "application/mrt";
				break;
			default:
		}
		header('Content-Type:' . $ctype);
		header('Content-Length: ' . filesize($file));
		header('Content-Disposition: attachment; filename="' . $row['sOriginalFileName'] . '"');
		print file_get_contents($file);
		exit(0);
	}
	function gf_clean_mrt_unused_report()
	{
		$DS = DIRECTORY_SEPARATOR;
		$sFolder = array("mrt");
		$sql = "call sp_query('select sEncryptedFileName from tm_user_uploads where sStatusDelete is null and sPathFile = ''uploads\\\\\\\mrt\\\\\\\'' ');";
		$arrayFile = array();
		foreach ($this->db->query($sql)->result_array() as $row) {
			array_push($arrayFile, trim($row['sEncryptedFileName']));
		}
		foreach ($sFolder as $r) {
			$path = getcwd() . $DS . "uploads" . $DS . $r . $DS;
			if (file_exists($path)) {
				if ($handle = opendir($path)) {
					while ($entry = readdir($handle)) {
						if (in_array($entry, array("..", "."))) continue;
						if (!in_array($entry, $arrayFile)) {
							if (file_exists($path . $entry))
								unlink($path . $entry);
						}
					}
					closedir($handle);
				}
			}
		}
	}
}
