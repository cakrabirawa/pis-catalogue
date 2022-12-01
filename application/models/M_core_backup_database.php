<?php
/*
------------------------------
Menu Name: Backup Database
File Name: M_core_backup_database.php
File Path: /var/www/pis/application/models/M_core_backup_database.php
Create Date Time: 2020-05-18 20:12:29
------------------------------
*/
class m_core_backup_database extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}
	function gf_load_backup_file()
	{
		$PATH = getcwd() . DIRECTORY_SEPARATOR . "backupdb" . DIRECTORY_SEPARATOR;
		$dir = new DirectoryIterator($PATH);
		$i = 0;
		foreach ($dir as $fileinfo) {
			if (!$fileinfo->isDot())
				$i++;
		}

		if ($i > 4)
			shell_exec("rm /var/www/pis/backupdb/*");

		shell_exec("mysqldump -u root -pP@ssw0rd@! --routines -h 10.12.30.35 pisdb | gzip > /var/www/sco/backupdb/pisdb_`date '+%m-%d-%Y_%T'`.sql.gz");

		//return $this->gf_list_backup_file();	
	}
	function gf_list_backup_file()
	{
		$PATH = getcwd() . DIRECTORY_SEPARATOR . "backupdb" . DIRECTORY_SEPARATOR;
		$dir = new DirectoryIterator($PATH);
		$sReturn = array();
		$i = 1;
		foreach ($dir as $fileinfo) {
			if (!$fileinfo->isDot()) {
				array_push($sReturn, array("fileseq" => $i, "filename" => $fileinfo->getFilename(), "filemodified" => date('d-m-Y H:i:s', $fileinfo->getMTime()), "filesize" => $this->m_core_apps->gf_conv_size(array("oBytes" => $fileinfo->getSize()))));
				$i++;
			}
		}
		return json_encode($sReturn);
	}
}
