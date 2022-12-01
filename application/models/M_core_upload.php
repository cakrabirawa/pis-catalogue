<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_upload extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}
	function gf_upload()
	{
		$this->load->library(array('libUpload'));
		$oFolder = $this->input->post('oAddPath', TRUE);
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$DS        = DIRECTORY_SEPARATOR;
		$sHomeDir  = getcwd() . $DS . $oConfig['UPLOAD_DIR'] . $DS;
		if (trim($oFolder) !== "")
			$sHomeDir .= $oFolder . $DS;
		if (!file_exists($sHomeDir)) {
			mkdir($sHomeDir);
			chmod($sHomeDir, 0777);
		}
		$libUpload = new libUpload();
		return $libUpload->gfUpload(array("oPath" => $sHomeDir));
	}
	function gf_checking_file()
	{
		$sReturn = null;
		$sUUID = $this->input->post('sUUID', TRUE);

		$sF = json_decode($this->m_core_apps->gf_enc_dec(array("sData" => $sUUID, "nSeed" => $this->input->post('nSeed', TRUE), "sMode" => "DEC")), TRUE);
		$sUUID = trim($sF['sData']);

		$sql = "call sp_query('select count(sFileName) as c from tx_pm_uploads where sStatusDelete is null and sUUID = ''" . trim($sUUID) . "'' ')";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $rs->row_array();
			if (intval($row['c']) === 0)
				$sReturn = array("status" => 0, "message" => "Ooppss,,, File Not Found or Already Deleted from the Server.");
			else {
				$sql = "call sp_query('select concat(sPathFolder, sFileName) as sFullFileName from tx_pm_uploads where sStatusDelete is null and sUUID = ''" . trim($sUUID) . "'' ')";
				$rs = $this->db->query($sql);
				$row = $rs->row_array();
				if (!file_exists($row['sFullFileName'])) {
					$sReturn = array("status" => 0, "message" => "Ooppss,,, File Not Found or Already Deleted from the Server.");
					$sql = "call sp_query('update tx_pm_uploads set sStatusDelete = ''V'', dDeleteOn = CURRENT_TIMESTAMP, sDeleteBy = ''Checking Download'' where sStatusDelete is null and sUUID = ''" . trim($sUUID) . "'' ')";
					$this->db->trans_begin();
					$this->db->query($sql);
					if ($this->db->trans_status() === FALSE)
						$this->db->trans_rollback();
					else
						$this->db->trans_commit();
				} else
					$sReturn = array("status" => 1, "message" => "", "filename" => base64_encode($row['sFullFileName']));
			}
		}
		return json_encode($sReturn);
	}
	function gf_checking_physical_file()
	{
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$DS        = DIRECTORY_SEPARATOR;
		$sFileName = $this->input->post('sFileName', TRUE);
		$sHomeDir  = getcwd() . $DS . $oConfig['UPLOAD_DIR'] . $DS;
		return json_encode(array("status" => file_exists($sHomeDir . $sFileName)));
	}
	function gf_remove_physical_file()
	{
		$sReturn = null;
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$DS        = DIRECTORY_SEPARATOR;
		$sFileName = $this->input->post('sFileName', TRUE);
		$sHomeDir  = getcwd() . $DS . $oConfig['UPLOAD_DIR'] . $DS;
		if (file_exists($sHomeDir . $sFileName)) {
			//-- Remove Physical File
			$a = unlink($sHomeDir . $sFileName);

			//-- Remove From Database
			$sql = "call sp_query('update tm_user_uploads set sStatusDelete = ''V'', sDeleteBy = ''" . $this->session->userdata('sRealName') . "'', dDeleteOn = CURRENT_TIMESTAMP where sOriginalFileName = ''" . trim($sFileName) . "'' and sStatusDelete is null '); ";
			$this->db->query($sql);
			if ($this->db->trans_status() === FALSE)
				$this->db->trans_rollback();
			else
				$this->db->trans_commit();
			$sReturn = json_encode(array("status" => $a));
		} else
			$sReturn = json_encode(array("status" => FALSE));
		return $sReturn;
	}
	function gf_get_file_upload_info($oParams = array())
	{
		$sReturn = null;
		$sql = "call sp_query('select * from tm_user_uploads where nUnitId_fk = " . $this->session->userdata('nUnitId_fk') . " and sStatusDelete is null and sUploadId = ''" . trim($oParams['sUploadId']) . "'' ');";
		$rs = $this->db->query($sql);
		return json_encode(array("oData" => $rs->row_array()));
	}
}
