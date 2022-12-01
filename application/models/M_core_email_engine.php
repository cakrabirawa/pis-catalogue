<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_email_engine extends CI_Model
{
	var $sRoot;
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps', 'm_core_apps_report'));
		$this->sRoot = getcwd();
	}
	function gf_transact()
	{
		$SP = DIRECTORY_SEPARATOR;

		$txtReportEngineName = $this->input->post('txtReportEngineName', TRUE);
		$txtNativeSQL = $this->input->post('hideNativeSQL');
		$txtNativeHTML = $this->input->post('hideNativeHTML');
		$txtMarginTop = $this->input->post('txtMarginTop', TRUE);
		$txtMarginLeft = $this->input->post('txtMarginLeft', TRUE);
		$txtMarginBottom = $this->input->post('txtMarginBottom', TRUE);
		$txtMarginRight = $this->input->post('txtMarginRight', TRUE);
		$txtDisplayMode = $this->input->post('txtDisplayMode', TRUE);
		$selPaperSize = $this->input->post('selPaperSize', TRUE);
		$selPaperOrientation = $this->input->post('selPaperOrientation', TRUE);
		$selPaperFontName = $this->input->post('selPaperFontName', TRUE);
		$txtFontSize = $this->input->post('txtFontSize', TRUE);
		$txtReportEngineDesc = $this->input->post('txtReportEngineDesc', TRUE);

		$nOverwrite = $this->input->post('nOverwrite', TRUE);

		$tempArray = array("txtReportEngineName" => trim($txtReportEngineName), "txtNativeSQL" => trim($txtNativeSQL), "txtNativeHTML" => $txtNativeHTML, "txtMarginTop" => $txtMarginTop, "txtMarginLeft" => $txtMarginLeft, "txtMarginBottom" => $txtMarginBottom, "txtMarginRight" => $txtMarginRight, "txtDisplayMode" => $txtDisplayMode, "selPaperSize" => $selPaperSize, "selPaperOrientation" => $selPaperOrientation, "selPaperFontName" => $selPaperFontName, "txtFontSize" => $txtFontSize, "txtReportEngineDesc" => $txtReportEngineDesc);

		$hideMode = $this->input->post('hideMode', TRUE);
		$sReturn = null;
		$UUID = "NULL";

		//-- Create folder report if no exists
		$path = getcwd() . $SP . "emails" . $SP;
		if (!file_exists($path))
			mkdir($path);
		//-- End Create Folder  

		//-- Create file Report
		$handle = NULL;
		$filename = $path . $txtReportEngineName . ".eml";
		if (file_exists($filename) && trim($nOverwrite) === "") {
			$sReturn = json_encode(array("status" => -1, "message" => "File Name: " . $txtReportEngineName . ".wrpt Already exists. <br />Please Change your Report Engine Name and Save again!!!<br /><br />Press Close button to go back to Form or Click <button type=\"button\" id=\"cmdOverwrite\" class=\"btn btn-primary btn-sm\">Here</button> to Overwrite your Report."));
			return $sReturn;
			exit(0);
		} else {
			if (trim($nOverwrite) !== "" && file_exists($filename))
				unlink($filename);
		}

		if (!file_exists($filename)) {
			$handle = fopen($filename, "w+");
			fwrite($handle, json_encode($tempArray));
			fclose($handle);
		}
		//--

		$sReturn = json_encode(array("status" => 1, "message" => "File Name: " . $txtReportEngineName . ".wrpt has Success create on Server."));
		return $sReturn;
	}
	function gf_list_reports($sParam = array())
	{
		$SP = DIRECTORY_SEPARATOR;
		$path = trim($sParam['path']);

		//$path = $sParam['path'] === NULL ? $this->sRoot : (trim($sParam['path']) === "" ? getcwd() : base64_decode(trim($sParam['path'])));
		$sReturn = array();
		$filelist = array();
		$basepath = null;

		if ($handle = opendir($path)) {
			$i = 1;
			while ($entry = readdir($handle)) {
				if (in_array($entry, array("..", "."))) continue;

				$spath = $path . $entry;
				$pathinfo = pathinfo($spath);
				$basepath = $this->a(array("sData" => str_replace($this->sRoot, "root", $pathinfo['dirname']), "sPath" => $pathinfo['dirname']));
				$s = "<tr><td class=\"text-right\">" . $i . "</td>";
				$s .= " <td><a href=\"#\" path=\"" . base64_encode($spath) . "\">" . $entry . "</a></td>";
				$s .= " <td>" . (is_file($spath) ? $this->m_core_apps->gf_conv_size(array("oBytes" => filesize($spath), "oPrecision" => 2)) : $this->m_core_apps->gf_folder_size(array("sPath" => $spath))) . "</td><td>" . (date("F d Y H:i:s", filemtime($spath))) . "</td>";
				$s .= " <td class=\"text-center\">" . (is_file($spath) ? "<a mode=\"copy\" class=\"btn btn-primary btn-xs\" title=\"Copy this File\" href=\"#\">Copy</a> <a mode=\"rename\" href=\"#\" class=\"btn btn-warning btn-xs\" title=\"Rename this File\">Rename</a> <a mode=\"delete\" class=\"btn btn-danger btn-xs\" title=\"Delete this File\" href=\"#\">Remove</a>" : "<a mode=\"rename\" href=\"#\" title=\"Rename this File\">Rename</i></a> <a mode=\"delete\" title=\"Delete this File\" href=\"#\">Remove</a>") . "</td></tr>";
				$filelist[] = $s;
				$i++;
			}
			closedir($handle);
		}
		if (count($filelist) === 0) {
			$basepath = "<li><a href=\"#\" title=\"root\" path=\"" . base64_encode(getcwd()) . "\">root</a></li>";
			$filelist[] = "<tr><td colspan=\"8\" class=\"text-center\">File Not Found...</td></tr>";
		}
		return json_encode(array("data" => $filelist, "path" => $basepath));
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
	function gf_load_field()
	{
		$sReturn = null;
		$sTemp = null;
		$sSQL = $this->input->post("sSQL", TRUE);
		$sSQL          = $this->m_core_apps_report->gf_parse_sql_x(array("hideSQL" => $sSQL));
		$sSQL = explode("~", $sSQL);
		for ($i = 0; $i < count($sSQL); $i++) {
			if (trim($sSQL[$i]) !== "") {
				$sTemp = null;
				$rs = $this->db->query($sSQL[$i]);
				foreach ($rs->field_data() as $row)
					$sTemp .= "<option value=\"" . $row->name . "\">" . $row->name . "</option>";
				$sReturn .= $sTemp . "<option value=\"\">---RS:" . $i . "---</option>";
			}
		}
		return json_encode(array("data" => $sReturn));
	}
	function gf_load_font_dir($sParams = null)
	{
		$SP = DIRECTORY_SEPARATOR;
		$sReturn = null;
		$sDir = getcwd() . $SP . "plugins" . $SP . "dist" . $SP . "fonts" . $SP;
		$files = scandir($sDir);
		foreach ($files as $file) {
			if (trim($file) !== "." && trim($file) !== "..") {
				if ($sParams !== null && !empty($sParams['sFontName']))
					$sReturn .= "<option value=\"" . trim($file) . "\" " . (trim($sParams['sFontName']) === trim($file) ? "selected" : "") . ">" . trim($file) . "</option>";
				else
					$sReturn .= "<option value=\"" . trim($file) . "\">" . trim($file) . "</option>";
			}
		}
		return $sReturn;
	}
	function gf_preview_reports()
	{
		$txtNativeSQL = $this->input->post('hideNativeSQL');
		$txtNativeHTML = $this->input->post('hideNativeHTML');
		$html = $this->gf_convert_rpt_engine(
			array(
				"content" => trim($txtNativeHTML),
				"sql"     => trim($txtNativeSQL)
			)
		);
		return json_encode(array("oData" => $html));
	}
	function gf_convert_rpt_engine($sParam = null)
	{
		$this->load->library('libRptEngine');
		$libRptEngine = new libRptEngine();
		$sReturn       = "Check Your Report Engine. Some Problems Found...";
		$oContent      = trim($sParam['content']);
		$oSQL          = trim($sParam['sql']);
		$oSQL          = $this->m_core_apps_report->gf_parse_sql_x(array("hideSQL" => $oSQL));
		$cOSQL 				 = explode("~", $oSQL);
		$oRowData = array();
		if (count($cOSQL) > 1) {
			foreach ($cOSQL as $cSQL) {
				$rs = $this->db->query($cSQL);
				$oRowData[] = $rs->result_array();
			}
		} else {
			$rs = $this->db->query($oSQL);
			$oRowData[] = $rs->result_array();
		}
		$oContent = str_replace("<tr><td></td></tr>", "", $libRptEngine->gf_process($oContent, $oRowData));
		return $oContent;
	}
	function gf_rename_folder_file()
	{
		$sPath = trim($this->input->post('path', TRUE)) === "" ? getcwd() . DIRECTORY_SEPARATOR . "reports" : base64_decode($this->input->post('path', TRUE));
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
	function gf_copy_folder_file()
	{
		$sPath = trim($this->input->post('path', TRUE)) === "" ? getcwd() . DIRECTORY_SEPARATOR . "reports" : base64_decode($this->input->post('path', TRUE));
		$oldname = $this->input->post('oldname', TRUE);
		$newname = $this->input->post('newname', TRUE);
		if (file_exists($sPath . DIRECTORY_SEPARATOR . $newname))
			$sReturn = json_encode(array("status" => false));
		else if (!file_exists($sPath . DIRECTORY_SEPARATOR . $oldname))
			$sReturn = json_encode(array("status" => false));
		else {
			copy($sPath . DIRECTORY_SEPARATOR . $oldname, $sPath . DIRECTORY_SEPARATOR . $newname);
			$sReturn = json_encode(array("status" => true));
		}
		return $sReturn;
	}
	function gf_delete_folder_file()
	{
		$sReturn = null;
		$sPath = trim($this->input->post('path', TRUE)) === "" ? getcwd() . DIRECTORY_SEPARATOR . "emails" : base64_decode($this->input->post('path', TRUE));
		$sMode = $this->input->post('mode', TRUE);
		$sName = $this->input->post('name', TRUE);
		$sType = $this->input->post('type', TRUE);

		if (trim($sType) === "folder") {
			if (file_exists($sPath . DIRECTORY_SEPARATOR . $sName)) {
				$this->gf_it_remove_dir(array("dir" => $sPath . DIRECTORY_SEPARATOR . $sName));
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
	function gf_it_remove_dir($sParam = array())
	{
		if (!is_dir($sParam['dir']))
			throw new InvalidArgumentException($sParam['dir'] . " must be a directory");
		if (substr($sParam['dir'], strlen($sParam['dir']) - 1, 1) != '/')
			$sParam['dir'] .= '/';
		$files = glob($sParam['dir'] . '*', GLOB_MARK);
		foreach ($files as $file) {
			if (is_dir($file))
				$this->gf_it_remove_dir(array("dir" => $file));
			else
				unlink($file);
		}
		rmdir($sParam['dir']);
	}
	function gf_read_file($sParam = array())
	{
		$this->load->library(array('libIO'));
		$libIO = new libIO();
		$sData = $libIO->gf_read_file(array("path" => base64_decode($sParam['path'])));
		$a = explode(DIRECTORY_SEPARATOR, base64_decode($sParam['path']));
		$a = $a[count($a) - 1];
		$a = explode(".", $a);
		$sPathInfo = pathinfo(base64_decode($sParam['path']));
		return json_encode(array("filename" => $a[0], "data" => trim($sData), "path" => str_replace($this->sRoot, "root", base64_decode($sParam['path'])), "ext" => $sPathInfo['extension']));
	}
	function gf_load_report_menu($sParams = null)
	{
		$SP = DIRECTORY_SEPARATOR;
		$sReturn = null;
		$sDir = getcwd() . $SP . "emails" . $SP;

		if (!file_exists($sDir))
			mkdir($sDir);

		$files = scandir($sDir);
		$i = 0;
		foreach ($files as $file) {
			if (trim($file) !== "." && trim($file) !== "..") {
				if ($sParams !== null && !empty($sParams['sReportName']))
					$sReturn .= "<option value=\"" . trim($file) . "\" " . (trim($sParams['sReportName']) === trim($file) ? "selected" : "") . ">" . trim($file) . "</option>";
				else
					$sReturn .= "<option value=\"" . trim($file) . "\">" . trim($file) . "</option>";
				$i++;
			}
		}
		return $sReturn;
	}
	function gf_exec_report($sParams = null)
	{
		$this->load->library('pdf');
		$this->pdf->setPrintHeader(false);
		$this->pdf->setPrintFooter(false);

		//-- Read File Report
		$this->load->library(array('libIO'));
		$libIO = new libIO();
		$SP = DIRECTORY_SEPARATOR;
		$sPathReport = getcwd() . $SP . "reports" . $SP;
		$sFileName = $this->input->post('selReportName', TRUE);
		$sData = $libIO->gf_read_file(array("path" => $sPathReport . $sFileName));

		$sPathInfo = pathinfo($sPathReport . $sFileName);
		$sData = json_decode($sData, TRUE);

		$txtReportEngineName = $sData['txtReportEngineName'];
		$txtNativeSQL = $sData['txtNativeSQL'];
		$txtNativeHTML = $sData['txtNativeHTML'];
		$txtMarginTop = $sData['txtMarginTop'];
		$txtMarginLeft = $sData['txtMarginLeft'];
		$txtMarginBottom = $sData['txtMarginBottom'];
		$txtMarginRight = $sData['txtMarginRight'];
		$txtDisplayMode = $sData['txtDisplayMode'];
		$selPaperSize = $sData['selPaperSize'];
		$selPaperOrientation = $sData['selPaperOrientation'];
		$selPaperFontName = $sData['selPaperFontName'];
		$txtFontSize = $sData['txtFontSize'];
		$txtReportEngineDesc = $sData['txtReportEngineDesc'];
		//-- End Read File Report

		// set document information
		$this->pdf->SetCreator("Edwar Rinaldo Report Engine V 1.0");
		$this->pdf->SetAuthor('Edwar Rinaldo');
		$this->pdf->SetTitle($txtReportEngineName);
		$this->pdf->SetSubject('This Report Was Generate From Report Engine (c) Edwar Rinaldo as Ado For System and IT GoRP :: ' . $txtReportEngineDesc);
		//==
		$oContent = null;
		$oSQL = null;

		$this->pdf->SetAutoPageBreak(true, intval($txtMarginBottom));
		$this->pdf->SetMargins(intval($txtMarginLeft), intval($txtMarginTop));

		$oDirFont = getcwd() . $SP . "fonts" . $SP;
		$oFontName = TCPDF_FONTS::addTTFfont($oDirFont . $selPaperFontName, 'TrueTypeUnicode', '', 96);
		$this->pdf->SetFont($oFontName, '', 9, '', false);
		$this->pdf->SetDisplayMode(intval($txtDisplayMode));


		$oContent = trim($txtNativeHTML);
		$oSQL     = trim($txtNativeSQL);

		/* 
  		Replace Parameter sesuai dengan field yangn telah di buat, awali dengan tanda @ misal, 
  		select '@nama_penyusun' as sNamaPenyusun from tm_Penyusun, jadi nama parameter baik itu input text 
  		dan select harus sama dengan nama @nama_penyusun (field nya)
  	*/

		$oParams  = $_REQUEST;
		if (is_array($oParams)) {
			foreach ($oParams as $key => $value)
				$oSQL = str_replace(trim("@" . $key), trim($value), trim($oSQL));
		}

		$this->load->library('libRptEngine');
		$libRptEngine = new libRptEngine();
		//$oSQL = str_replace("@nUnitId", $this->session->userdata('ses_nIdUnit'), $oSQL);

		$cOSQL = explode("~", $oSQL);
		$oRowData = array();

		if (count($cOSQL) > 1) {
			foreach ($cOSQL as $cSQL) {
				$rs = $this->db->query($cSQL);
				$oRowData[] = $rs->result_array();
			}
		} else {
			$rs = $this->db->query($oSQL);
			$oRowData[] = $rs->result_array();
		}
		$oContent = str_replace("<tr><td></td></tr>", "", $libRptEngine->gf_process($oContent, $oRowData));

		/* 
  	//-- Barcode and Image Producer
  	$barcode = false;
	  // di html mencari text dengan format <span id="txt_barcode" data-x="124" data-y="20">[StringBarcode]</span>
	  if(strpos($html,'txt_barcode')!==false){
		  	$barcode = true;
		  	$base_url = base_url();
			$this->load->library('barcode');
			$subject = $html;
			$pattern = "/<span id=\"txt_barcode\" data-x=\"(.*)\" data-y=\"(.*)\">(.*)<\/span>/";
			preg_match_all($pattern, $subject, $matches);
			if(!empty($matches[3])){
				$array = array();
				for($inc=0; $inc<sizeof($matches[3]); $inc++){
					$array[$inc]['coor_x'] = $matches['1'][$inc];
					$array[$inc]['coor_y'] = $matches['2'][$inc];
					$array[$inc]['text'] = $matches['3'][$inc];
					$text_barcode = $matches['3'][$inc];
					if(!file_exists($_SERVER['DOCUMENT_ROOT']."/pis/barcode/".$text_barcode.".png")){
						$url = $this->barcode->gfCreateBarcode($text_barcode);
						$pattern = "/(.*)\/pis\/(.*)/";
						preg_match($pattern, $url, $match);
						$array[$inc]['url'] = $match[2];
					}else{
						$array[$inc]['url'] = "barcode/".$text_barcode.".png";
					}
				}
			}
	  }
	  
	  $withLogo = false;
	  //di html mencari text dengan format {logo:x=10,y=10,scale=25}path_to_logo.extensi{/logo}
	  if(strpos($html,'{logo:')){
		  $pattern = "/{logo:x=([0-9]+),y=([0-9]+),scale=([0-9]+)}(.*){\/logo}/";
		  preg_match($pattern, $html, $matches);
		  str_replace($matches[0],"",$html);
		  $logo_x = $matches[1];
		  $logo_y = $matches[2];
		  $logo_scale = $matches[3];
		  $url_logo =$matches[4];
		  
		  $withLogo = true;
	  }
  	*/

		$html = $oContent;

		$c = explode("[newpage]", $html);
		$p = null;
		if ($c > 2) {
			foreach ($c as $p) {
				if (trim($p) !== "")
					$this->pdf->AddPage(trim($selPaperOrientation), trim($selPaperSize));
				$this->pdf->writeHTML($p, true, false, false, false, '');
			}
		} else {
			$this->pdf->AddPage(trim($selPaperOrientation), trim($selPaperSize));
			$this->pdf->writeHTML($p, true, false, false, false, '');
		}

		/*if($barcode)
		{
			foreach($array as $each)
			{
				$this->pdf->SetXY($each['coor_x'], $each['coor_y']);
				$this->pdf->Image($base_url.$each['url'],'','',75);
			}
		}
		if($withLogo)
		{
			$this->pdf->SetXY($logo_x, $logo_y);
			$this->pdf->Image($base_url.'img/'.$url_logo,'','',$logo_scale);
		}*/
		$this->pdf->Output("Output.pdf", 'I');
	}
}
