<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_file_manager extends CI_Model
{
	var $sRoot;
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
		$this->sRoot = getcwd();
	}
	function gf_load_root_dir($sParam = array())
	{
		$path = $sParam['path'] === NULL ? $this->sRoot : (trim($sParam['path']) === "" ? getcwd() : base64_decode(trim($sParam['path'])));
		$sReturn = array();
		$filelist = array();
		$basepath = null;

		if ($handle = opendir($path)) {
			$i = 1;
			while ($entry = readdir($handle)) {
				if (in_array($entry, array("..", "."))) continue;

				$spath = $path . DIRECTORY_SEPARATOR . $entry;
				$pathinfo = pathinfo($spath);
				$basepath = $this->a(array("sData" => str_replace($this->sRoot, "root", $pathinfo['dirname']), "sPath" => $pathinfo['dirname']));
				$filelist[] = "<tr><td class=\"text-right\">" . $i . "</td><td><a class=\"btn btn-xs btn-default\" href=\"#\" title=\"Click here to load " . (is_file($spath) ? "File" : "Dir") . " " . $pathinfo['basename'] . "\" path=\"" . base64_encode($spath) . "\">" . $entry . "</a></td><td>" . (!is_file($spath) ? "<i class=\"fa fa-folder-o\"></i>" : "<i class=\"fa fa-file-o\"></i>") . "</td><td>" . (is_file($spath) ? "File" : "Dir") . "</td><td>" . (array_key_exists("extension", $pathinfo) ? "." . $pathinfo['extension'] : "") . "</td><td>" . (is_file($spath) ? $this->m_core_apps->gf_conv_size(array("oBytes" => filesize($spath), "oPrecision" => 0)) : $this->m_core_apps->gf_folder_size(array("sPath" => $spath))) . "</td><td>" . (date("F d Y H:i:s", filemtime($spath))) . "</td><td class=\"text-center\">" . (is_file($spath) ? "<a mode=\"rename\" href=\"#\" title=\"Rename this File\"><i class=\"fa fa-edit fa-1x\"></i></a> - <a mode=\"delete\" title=\"Delete this File\" href=\"#\"><i class=\"fa fa-trash fa-1x\"></i></a>" : "<a mode=\"rename\" href=\"#\" title=\"Rename this File\"><i class=\"fa fa-edit fa-1x\"></i></a></a> - <a mode=\"delete\" title=\"Delete this File\" href=\"#\"><i class=\"fa fa-trash fa-1x\"></i></a>") . "</td></tr>";
				$i++;
			}
			closedir($handle);
		}
		if (count($filelist) === 0) {
			$basepath = "<li><a href=\"#\" title=\"root\" path=\"" . base64_encode(getcwd()) . "\">root</a></li>";
		}
		return json_encode(array("data" => $filelist, "path" => $basepath));
	}
	function gf_rename_folder_file()
	{
		$sPath = trim($this->input->post('path', TRUE)) === "" ? getcwd() : base64_decode($this->input->post('path', TRUE));
		$oldname = $this->input->post('oldname', TRUE);
		$newname = $this->input->post('newname', TRUE);
		if (file_exists($sPath . DIRECTORY_SEPARATOR . $newname))
			$sReturn = json_encode(array("status" => false));
		else if (!file_exists($sPath . DIRECTORY_SEPARATOR . $oldname))
			$sReturn = json_encode(array("status" => false));
		else {
			rename($sPath . DIRECTORY_SEPARATOR . $oldname, $sPath . DIRECTORY_SEPARATOR . $newname);
			$sReturn = json_encode(array("status" => true));
		}
		return $sReturn;
	}
	function gf_delete_folder_file()
	{
		$sReturn = null;
		$sPath = trim($this->input->post('path', TRUE)) === "" ? getcwd() : base64_decode($this->input->post('path', TRUE));
		$sMode = $this->input->post('mode', TRUE);
		$sName = $this->input->post('name', TRUE);
		$sType = $this->input->post('type', TRUE);

		if (trim($sType) === "folder") {
			if (file_exists($sPath . DIRECTORY_SEPARATOR . $sName)) {
				$this->gf_it_trash_dir(array("dir" => $sPath . DIRECTORY_SEPARATOR . $sName));
				$sReturn = json_encode(array("status" => true));
			} else
				$sReturn = json_encode(array("status" => false));
		} else if (trim($sType) === "file") {
			//print ($sPath.DIRECTORY_SEPARATOR.$sName);
			//exit(0);
			if (file_exists($sPath . DIRECTORY_SEPARATOR . $sName)) {
				unlink($sPath . DIRECTORY_SEPARATOR . $sName);
				$sReturn = json_encode(array("status" => true));
			} else
				$sReturn = json_encode(array("status" => false));
		}
		return $sReturn;
	}
	function gf_it_trash_dir($sParam = array())
	{
		if (!is_dir($sParam['dir']))
			throw new InvalidArgumentException($sParam['dir'] . " must be a directory");
		if (substr($sParam['dir'], strlen($sParam['dir']) - 1, 1) != '/')
			$sParam['dir'] .= '/';
		$files = glob($sParam['dir'] . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file))
				$this->gf_it_trash_dir(array("dir" => $file));
			else
				unlink($file);
		}
		rmdir($sParam['dir']);
	}
	function gf_create_folder_file()
	{
		$sReturn = null;
		$sPath = trim($this->input->post('path', TRUE)) === "" ? getcwd() : base64_decode($this->input->post('path', TRUE));
		$sMode = $this->input->post('mode', TRUE);
		$sName = $this->input->post('name', TRUE);
		$sType = $this->input->post('type', TRUE);

		$sContent = $this->input->post('content', TRUE);
		$sFileName = $this->input->post('filepath', TRUE);


		if (trim($sType) === "folder") {
			if (!file_exists($sPath . DIRECTORY_SEPARATOR . $sName))
				$sReturn = json_encode(array("status" => mkdir($sPath . DIRECTORY_SEPARATOR . $sName)));
			else
				$sReturn = json_encode(array("status" => false));
		} else if (trim($sType) === "file") {
			$handle = null;
			if (!file_exists($sPath . DIRECTORY_SEPARATOR . $sName)) {
				$handle = fopen($sPath . DIRECTORY_SEPARATOR . $sName, "w");
				$sReturn = json_encode(array("status" => true));
				fclose($handle);
			} else {
				if (trim($sContent) !== "") {
					unlink($sPath . DIRECTORY_SEPARATOR . $sName);
					$handle = fopen($sPath . DIRECTORY_SEPARATOR . $sName, "w");
					fclose($handle);
				} else
					$sReturn = json_encode(array("status" => false));
			}

			if (trim($sContent) !== "") {
				fwrite($handle, htmlspecialchars($sContent));
				fclose($handle);
				$sReturn = json_encode(array("status" => true));
			}
		}
		return $sReturn;
	}
	function gf_save_file()
	{
		$sReturn = null;
		$sPath = trim($this->input->post('path', TRUE)) === "" ? getcwd() : base64_decode($this->input->post('path', TRUE));
		$sMode = $this->input->post('mode', TRUE);
		$sName = $this->input->post('name', TRUE);
		$sType = $this->input->post('type', TRUE);

		$sContent = $this->input->post('content');
		$sFileName = $this->input->post('filepath', TRUE);

		$x = $this->input->post('x', TRUE);

		$handle = null;
		if (trim($x) === "0")
			$sPath = $sPath . DIRECTORY_SEPARATOR . $sName;
		else if (trim($x) === "1") {
			$sPath = trim($sPath) === getcwd() ? trim($sPath) . DIRECTORY_SEPARATOR . $sName : trim($sPath);
			if (file_exists($sPath))
				unlink($sPath);
		}

		$handle = fopen($sPath, "w");
		if (trim($sContent) !== "") {
			/*$sContent = html_entity_decode(str_replace("[trashd].href", "window.locaion.href", $sContent));
			$a = explode("[trashd]", $sContent);
			$sContent = NULL;
			for($i=0; $i<count($a); $i++)
			{
				if($i % 2 === 0)
					$sContent .= $a[$i]."<script>";
				else
					$sContent .= $a[$i]."</script>";
			}
			$sContent = substr(trim($sContent), 0, (strlen($sContent) - strlen("<script>")));
			//print $sContent;
			//exit(0);*/
			$sContent = urldecode($sContent);
			fwrite($handle, $sContent);
			$sReturn = json_encode(array("status" => true));
		}
		fclose($handle);
		return $sReturn;
	}
	function a($sParam = array())
	{
		$sReturn = null;
		$b = explode(DIRECTORY_SEPARATOR, $sParam['sData']);
		for ($i = 0; $i < count($b); $i++) {
			$a = array("nPointer" => ($i === 0 ? count(explode(DIRECTORY_SEPARATOR, getcwd())) : count(explode(DIRECTORY_SEPARATOR, getcwd())) + $i), "sOffset" => $b[$i], "sData" => $sParam['sPath']);
			$c = $this->b($a);
			if (trim($c) !== "") {
				if (trim($b[$i]) !== "")
					$sReturn .= "<li><a href=\"#\" title=\"" . $c . "\" path=\"" . base64_encode($c) . "\">" . $b[$i] . "</a></li>";
			}
		}
		return $sReturn;
	}
	function b($sParam = array())
	{
		$sReturn = null;
		$a = explode(DIRECTORY_SEPARATOR, $sParam['sData']);
		for ($i = 0; $i < $sParam['nPointer']; $i++) {
			$sReturn .= $a[$i];
			$sReturn .= DIRECTORY_SEPARATOR;
		}
		return $sReturn;
	}
	function gf_read_file($sParam = array())
	{
		$this->load->library(array('libIO'));
		$libIO = new libIO();
		$sData = $libIO->gf_read_file(array("path" => base64_decode($sParam['path'])));
		$sPathInfo = pathinfo(base64_decode($sParam['path']));
		return json_encode(array("data" => trim($sData), "path" => str_replace($this->sRoot, "root", base64_decode($sParam['path'])), "ext" => $sPathInfo['extension']));
	}
}
