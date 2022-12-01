<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_apps extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	function gf_highlight($oParams = array())
	{
		$a = explode(' ', trim($oParams['sHighlightText']));
		$str = preg_replace('/' . implode('|', $a) . '/i', '<span style="background-color:' . trim($oParams['sHighlightColor']) . '; color:#000;">$0</span>', trim($oParams['sSearchText']));
		return $str;
	}
	function gf_render_paging_data($oParams = array())
	{
		$oRecordSet = $oParams['oRecordSet'];
		$t = $oParams['oShow'];
		$p = $oParams['oPage'];
		$position = !empty($oParams['oPosition']) && array_key_exists("oPosition", $oParams) ? $oParams['oPosition'] : null;

		$a = array();
		$b = null;
		$sReturn = null;
		$oFieldSet  = $oRecordSet->field_data();
		if ($oRecordSet->num_rows() > 0) {
			$i = 0;
			$x = 0;
			foreach ($oRecordSet->result_array() as $row) {
				if (intval($p) === -1)
					$a[] = array($row);
				else {
					if (intval($p) === 1 && $i < $t)
						$a[] = array($row);
					else if (($i >= ($p * $t - $t)) && ($i < ($p * $t)))
						$a[] = array($row);
				}
				$i++;
			}
			$b = "<ul class=\"pagination pagination-sm\">";

			//-- Halaman cuma 1, jangan munculin Next Prev nya
			if (ceil($oRecordSet->num_rows() / $t) > 1)
				$b .= "<li><button id=\"button-paging\" class=\"btn btn-default btn-sm\" title=\"Next Page\">Next</button>&nbsp;</li>";

			for ($i = 1; $i <= ceil($oRecordSet->num_rows() / $t); $i++) {
				$l = (($i - 1) * ($t - 1) + $i) - 1;
				if (intval($i) === intval($p))
					$b .= "<li class=\"active\"><button id=\"button-paging\" class=\"btn btn-danger btn-sm\" title=\"Page: " . $i . "\">" . $i . "</button>&nbsp;</li>";
				else
					$b .= "<li><button id=\"button-paging\" class=\"btn btn-default btn-sm\" title=\"Page: " . $i . "\">" . $i . "</button>&nbsp;</li>";
			}
			if (ceil($oRecordSet->num_rows() / $t) > 1)
				$b .= "<li><button id=\"button-paging\" class=\"btn btn-default btn-sm hidden\" title=\"Previous Page\">Previous</button>&nbsp;</li>";
			$b .= "</ul>";
		}
		return json_encode(array("sData" => $a, "sPaging" => $b));
	}
	function gf_render_pagging_num($oParams = array())
	{
		$oRecordSet = $oParams['oRecordSet'];
		$t = $oParams['oShow'];
		$p = $oParams['oPage'];
		$position = !empty($oParams['oPosition']) && array_key_exists("oPosition", $oParams['oPosition']) ? $oParams['oPosition'] : null;

		$sReturn = null;
		if ($oRecordSet->num_rows() > 0) {
			$sReturn = "<ul class=\"pagination pagination-sm\">";
			$sReturn .= "<li><button id=\"button-paging\" class=\"btn btn-default btn-sm\" title=\"Next Page\">Next</button>&nbsp;</li>";

			for ($i = 1; $i <= ceil($oRecordSet->num_rows() / $t); $i++) {
				$l = (($i - 1) * ($t - 1) + $i) - 1;
				if (intval($i) === intval($p))
					$sReturn .= "<li class=\"active\"><button id=\"button-paging\" class=\"btn btn-danger btn-sm\" title=\"Page: " . $i . "\">" . $i . "</button>&nbsp;</li>";
				else
					$sReturn .= "<li><button id=\"button-paging\" class=\"btn btn-default btn-sm\" title=\"Page: " . $i . "\">" . $i . "</button>&nbsp;</li>";
			}
			$sReturn .= "<li><button id=\"button-paging\" class=\"btn btn-default btn-sm\" title=\"Previous Page\">Previous</button>&nbsp;</li>";
			$sReturn .= "</ul>";
		}
		return json_encode(array("sPaging" => $sReturn));
	}
	function gf_max_int_id($oParams = array())
	{
		$sql = "select case when count(" . trim($oParams['sFieldName']) . ") = 0 then 1 else max(" . trim($oParams['sFieldName']) . ") + 1 end as c from " . trim($oParams['sTableName']) . " " . trim($oParams['sParam']);
		$sOutput = $this->db->query($sql);
		$oRow = $sOutput->row_array();
		return $oRow['c'];
	}
	function gf_load_select_option($oParams = array())
	{
		//-- Kirim Object Koneksi jangan lupa
		//-- Ado @ 13/02/2017 13:50

		//$oPISDb = $this->load->database('pis', TRUE); 
		//$sql = "select * from tm_Unit";
		//$rs = $oPISDb->query($sql);

		//-- Parameter kirim object letakan di Array => $oParams['oObjCon'] = $this->load->database('pis', TRUE)


		$oObjCon = array_key_exists("oObjCon", $oParams) ? $oParams['oObjCon'] : $this->db;
		$sParams = array_key_exists("sParams", $oParams) ? trim($oParams['sParams']) : "";

		if (array_key_exists('sSQLData', $oParams) && array_key_exists('sSQLDataKey', $oParams)) {
			//-- Ada SQL Sumber nya untuk matching, Multiple Option, Ado 17 Oktober 2018 14:05
			$arrayData = array();
			$rsData = $oObjCon->query($oParams['sSQLData']);
			foreach ($rsData->result_array() as $row)
				array_push($arrayData, $row[$oParams['sSQLDataKey']]);
			//-- Jangan lupa suply key nya untuk ditampung di Array
		}

		$sReturn = null;
		//$sql = "OSearchItem 'SearchNative', '".trim($oParams['sSQL'])."'";
		$sql = $oParams['sSQL'];

		$rs = $oObjCon->query($sql . " " . $sParams);
		if (array_key_exists("bDebug", $oParams)) {
			if ($oParams['bDebug'])
				print $sql . " " . $sParams;
		}

		if (!array_key_exists('bDisabledPilihText', $oParams))
			$sReturn .= "<option " . (array_key_exists('bUnSelectFirstOption', $oParams) ? "" : "selected") . " value=\"" . (array_key_exists("sDefaultPilihValue", $oParams) ? trim($oParams['sDefaultPilihValue']) : "") . "\">" . (array_key_exists("sCustomPilihString", $oParams) ? trim($oParams['sCustomPilihString']) : "--Pilih--") . "</option>";
		foreach ($rs->result_array() as $r) {
			if (array_key_exists('sSQLData', $oParams) && array_key_exists('sSQLDataKey', $oParams)) {
				if (in_array(trim($r[$oParams['sFieldId']]), $arrayData))
					$sReturn .= "<option " . (array_key_exists("sDataSubText", $oParams) ? "data-subtext=\"" . trim($r[$oParams['sDataSubText']]) . "\"" : "") . " selected value=\"" . trim($r[$oParams['sFieldId']]) . "\">" . trim($r[$oParams['sFieldValues']]) . "</option>";
				else
					$sReturn .= "<option " . (array_key_exists("sDataSubText", $oParams) ? "data-subtext=\"" . trim($r[$oParams['sDataSubText']]) . "\"" : "") . "  value=\"" . trim($r[$oParams['sFieldId']]) . "\">" . trim($r[$oParams['sFieldValues']]) . "</option>";
			} else {
				if (array_key_exists("sFieldInitValue", $oParams)) {
					if (trim($r[$oParams['sFieldId']]) === trim($oParams['sFieldInitValue']))
						$sReturn .= "<option " . (array_key_exists("sDataSubText", $oParams) ? "data-subtext=\"" . trim($r[$oParams['sDataSubText']]) . "\"" : "") . " selected value=\"" . trim($r[$oParams['sFieldId']]) . "\">" . trim($r[$oParams['sFieldValues']]) . "</option>";
					else
						$sReturn .= "<option " . (array_key_exists("sDataSubText", $oParams) ? "data-subtext=\"" . trim($r[$oParams['sDataSubText']]) . "\"" : "") . "  value=\"" . trim($r[$oParams['sFieldId']]) . "\">" . trim($r[$oParams['sFieldValues']]) . "</option>";
				} else
					$sReturn .= "<option " . (array_key_exists("sDataSubText", $oParams) ? "data-subtext=\"" . trim($r[$oParams['sDataSubText']]) . "\"" : "") . "  value=\"" . trim($r[$oParams['sFieldId']]) . "\">" . trim($r[$oParams['sFieldValues']]) . "</option>";
			}
		}
		return $sReturn;
	}
	function gf_a_go($oParams = array())
	{
		$date = trim($oParams['oDate']);
		if (empty($date))
			return "No date provided";
		$periods   = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
		$lengths   = array("60", "60", "24", "7", "4.35", "12", "10");
		$now       = time();
		$unix_date = strtotime($date);
		if (empty($unix_date))
			return "Bad date";
		if ($now > $unix_date) {
			$difference = $now - $unix_date;
			$tense      = "ago";
		} else {
			$difference = $unix_date - $now;
			$tense      = "from now";
		}
		for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++)
			$difference /= $lengths[$j];
		$difference = round($difference);
		if ($difference != 1)
			$periods[$j] .= "s";
		return "$difference $periods[$j] {$tense}";
	}
	function gf_conv_size($oParams = array())
	{
		$bytes = $oParams['oBytes'];
		$precision = !empty($oParams['oPrecision']) && array_key_exists("oPrecision", $oParams) ? $oParams['oPrecision'] : 0;
		if ($bytes >= 1073741824)
			$bytes = number_format($bytes / 1073741824, $precision) . ' GB';
		elseif ($bytes >= 1048576)
			$bytes = number_format($bytes / 1048576, $precision) . ' MB';
		elseif ($bytes >= 1024)
			$bytes = number_format($bytes / 1024, $precision) . ' KB';
		elseif ($bytes > 1)
			$bytes = $bytes . ' B';
		elseif ($bytes == 1)
			$bytes = $bytes . ' B';
		else
			$bytes = '0 B';
		return $bytes;
	}
	function gf_conv_size1($oParams = array())
	{
		$size = $oParams['oBytes'];
		$filesizename = array(" Bytes", " KB", " MB", " GB", " TB", " PB", " EB", " ZB", " YB");
		return $size ? round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . $filesizename[$i] : '0 Bytes';
	}
	function gf_parse_date($oParams = array())
	{
		$sReturn = "";
		$oDate = explode($oParams['sSeparatorFrom'], $oParams['sDate']);
		if (trim($oParams['sFromFormat']) === 'dmy') {
			if (trim($oParams['sToFormat']) === "ymd")
				$sReturn = $oDate[2] . $oParams['sSeparatorTo'] . $oDate[1] . $oParams['sSeparatorTo'] . $oDate[0];
			else if (trim($oParams['sToFormat']) === "mdy")
				$sReturn = $oDate[1] . $oParams['sSeparatorTo'] . $oDate[0] . $oParams['sSeparatorTo'] . $oDate[2];
		} elseif (trim($oParams['sFromFormat']) === 'mdy') {
			if (trim($oParams['sToFormat']) === "ymd")
				$sReturn = $oDate[2] . $oParams['sSeparatorTo'] . $oDate[0] . $oParams['sSeparatorTo'] . $oDate[1];
			else if (trim($oParams['sToFormat']) === "dmy")
				$sReturn = $oDate[1] . $oParams['sSeparatorTo'] . $oDate[0] . $oParams['sSeparatorTo'] . $oDate[2];
		} elseif (trim($oParams['sFromFormat']) === 'ymd') {
			if (trim($oParams['sToFormat']) === "dmy")
				$sReturn = $oDate[2] . $oParams['sSeparatorTo'] . $oDate[1] . $oParams['sSeparatorTo'] . $oDate[0];
			else if (trim($oParams['sToFormat']) === "mdy")
				$sReturn = $oDate[1] . $oParams['sSeparatorTo'] . $oDate[2] . $oParams['sSeparatorTo'] . $oDate[0];
		}
		return $sReturn;
	}
	function gf_random_string($oParams = array())
	{
		$sReturn = "";
		$sPossible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		for ($i = 0; $i < $oParams['oLength']; $i++)
			$sReturn .= substr($sPossible, (floor(rand() * strlen($sPossible))));
		return $sReturn;
	}
	function gf_check_double_data_in_table($oParams = array())
	{
		$sReturn = null;
		$sTable = trim($oParams['sTableName']);
		$sFieldName = trim($oParams['sFieldName']);
		$sContent = trim($oParams['sContent']);

		$sParams = array_key_exists("sParams", $oParams) ? trim($oParams['sParams']) : " ";
		$bDisabledUnitId = array_key_exists("bDisabledUnitId", $oParams);
		$sParams = array_key_exists("bDisabledUnitId", $oParams) ? "" : $sParams . " and nUnitId_fk = " . $this->session->userdata('nUnitId_fk');

		$sql = "select count(" . $sFieldName . ") as c from " . $sTable . " where lower(" . $sFieldName . ") = lower('" . $sContent . "') and sStatusDelete is null " . trim($sParams) . ";";
		$rs = $this->db->query("call sp_query('" . str_replace("'", "''", $sql) . "');");
		if ($rs->num_rows() > 0) {
			$row = $rs->row_array();
			if (intVal($row['c']) > 0)
				$sReturn = json_encode(array("status" => 1, "message" => "Duplicate entry in table <b>" . $sTable . "</b> on field <b>" . $sFieldName . "</b>. Your entry is <b>" . $sContent . "</b>. Please entry another value."));
			else
				$sReturn = json_encode(array("status" => 0, "message" => "Checking Passed.<br >Query:<br />[ " . trim($sql) . " ]"));
		}
		return $sReturn;
	}
	function gf_check_field_in_table($oParams = array())
	{
		$sReturn = null;
		$sTable = trim($oParams['sTableName']);
		$sFieldName = trim($oParams['sFieldName']);
		$sContent = trim($oParams['sContent']);

		$sParams = array_key_exists("sParams", $oParams) ? trim($oParams['sParams']) : " ";
		$bDisabledUnitId = array_key_exists("bDisabledUnitId", $oParams);
		$sParams = array_key_exists("bDisabledUnitId", $oParams) ? "" : $sParams . " and nUnitId_fk = " . $this->session->userdata('nUnitId_fk');

		$sql = "select count(" . $sFieldName . ") as c from " . $sTable . " where lower(" . $sFieldName . ") = lower('" . $sContent . "') and sStatusDelete is null " . trim($sParams) . ";";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $rs->row_array();
			if (intVal($row['c']) > 0)
				$sReturn = json_encode(array("status" => 1, "message" => "Data OK."));
			else
				$sReturn = json_encode(array("status" => 0, "message" => "Data " . trim($oParams['sValueLabel']) . " not found in table " . $sTable . " or already removed. Please check your entry."));
		}
		return $sReturn;
	}
	function gf_check_foreign_key_use($oParams = array())
	{
		$sReturn = null;
		$sDatabaseName = trim($oParams['sDatabaseName']);
		$sFieldName = trim($oParams['sFieldName']);
		$sContent = trim($oParams['sContent']);


		$sParams = array_key_exists("sParams", $oParams) ? trim($oParams['sParams']) : " ";
		$bDisabledUnitId = array_key_exists("bDisabledUnitId", $oParams);
		$sParams = array_key_exists("bDisabledUnitId", $oParams) ? "" : $sParams . " and nUnitId_fk = " . $this->session->userdata('nUnitId_fk');


		$sql = "CALL sp_check_delete_field('" . trim($sDatabaseName) . "', '" . trim($sFieldName) . "', '" . trim($sContent) . "', '" . ($sParams) . "');";
		$rs = $this->db->query($sql);
		//exit($sql);
		if ($rs->num_rows() > 0) {
			$row = $rs->row_array();
			if (intVal($row['c']) > 0)
				$sReturn = json_encode(array("status" => 1, "message" => "Data " . trim($oParams['sValueLabel']) . " already in use. You can't modified or deleted this Data. Please check your entry.<br /><br /><b>Stored Procedure Script: </b><br />" . trim($sql)));
			else
				$sReturn = json_encode(array("status" => 0, "message" => "Data OK."));
		}
		return $sReturn;
	}
	function gf_is_mobile()
	{
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		$b = preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4));
		return $b;
	}
	function gf_folder_size($oParams = array())
	{
		$size = 0;
		foreach (glob(rtrim($oParams['sPath'], '/') . '/*', GLOB_NOSORT) as $each) {
			$size += is_file($each) ? filesize($each) : $this->gf_folder_size(array("sPath" => $each));
		}
		return $this->gf_conv_size($size);
	}
	function gf_get_user_ip()
	{
		// check for shared internet/ISP IP
		if (!empty($_SERVER['HTTP_CLIENT_IP']) && $this->gf_validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
			return $_SERVER['HTTP_CLIENT_IP'];
		}

		// check for IPs passing through proxies
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			// check if multiple ips exist in var
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
				$iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				foreach ($iplist as $ip) {
					if ($this->gf_validate_ip($ip))
						return $ip;
				}
			} else {
				if ($this->gf_validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
					return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		}
		if (!empty($_SERVER['HTTP_X_FORWARDED']) && $this->gf_validate_ip($_SERVER['HTTP_X_FORWARDED']))
			return $_SERVER['HTTP_X_FORWARDED'];
		if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && $this->gf_validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
			return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
		if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && $this->gf_validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
			return $_SERVER['HTTP_FORWARDED_FOR'];
		if (!empty($_SERVER['HTTP_FORWARDED']) && $this->gf_validate_ip($_SERVER['HTTP_FORWARDED']))
			return $_SERVER['HTTP_FORWARDED'];

		// return unreliable ip since all else failed
		return $_SERVER['REMOTE_ADDR'];
	}
	function gf_validate_ip($ip)
	{
		if (strtolower($ip) === 'unknown')
			return false;

		// generate ipv4 network address
		$ip = ip2long($ip);

		// if the ip is set and not equivalent to 255.255.255.255
		if ($ip !== false && $ip !== -1) {
			// make sure to get unsigned long representation of ip
			// due to discrepancies between 32 and 64 bit OSes and
			// signed numbers (ints default to signed in PHP)
			$ip = sprintf('%u', $ip);
			// do private network range checking
			if ($ip >= 0 && $ip <= 50331647) return false;
			if ($ip >= 167772160 && $ip <= 184549375) return false;
			if ($ip >= 2130706432 && $ip <= 2147483647) return false;
			if ($ip >= 2851995648 && $ip <= 2852061183) return false;
			if ($ip >= 2886729728 && $ip <= 2887778303) return false;
			if ($ip >= 3221225984 && $ip <= 3221226239) return false;
			if ($ip >= 3232235520 && $ip <= 3232301055) return false;
			if ($ip >= 4294967040) return false;
		}
		return true;
	}
	function gf_insert_log($oParams = array())
	{
		//---------------------------------------------
		$sql = "call sp_query('insert into tm_user_logs values (UUID(), CURRENT_TIMESTAMP(), ''" . trim($oParams['sType']) . "'', ''" . trim($oParams['sMessage']) . "'', " . $this->session->userdata('nUserId') . ")');";
		$this->db->trans_begin();
		$this->db->query($sql);
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return -1;
		} else {
			$this->db->trans_commit();
			return 1;
		}
		//---------------------------------------------
	}
	function gf_send_email($oParams = array())
	{
		$oData = $this->gf_read_config_apps();
		//-----------------------------
		$this->load->library('libMail');
		$mail = new libMail();
		$mail->IsSMTP();
		$mailException = null;
		$sReturn = null;
		try {
			$mail->Host       = trim($oData['HOST_MAIL_SERVER']);
			$mail->SMTPDebug  = 0;
			$mail->SMTPAuth   = true;
			$mail->Port       = trim($oData['PORT_MAIL_SERVER']);
			$mail->Username   = trim($oData['USER_MAIL_SERVER']);
			$mail->Password   = trim($oData['PWD_MAIL_SERVER']);

			$mail->Subject    = trim($oParams['sSubject']);
			$mail->AltBody    = trim($oParams['sMessage']);
			$mail->Body       = trim($oParams['sMessage']);

			//------------------------------------------------------------------------------------------
			if (is_array($oParams['sTO'])) {
				foreach ($oParams['sTO'] as $row)
					$mail->AddAddress(trim($row));
			} else
				$mail->AddAddress(trim($oParams['sTO']));
			//------------------------------------------------------------------------------------------
			if (array_key_exists("sCC", $oParams)) {
				if (is_array($oParams['sCC'])) {
					foreach ($oParams['sCC'] as $row)
						$mail->AddCC(trim($row));
				} else
					$mail->AddCC(trim($oParams['sCC']));
			}
			//------------------------------------------------------------------------------------------
			if (array_key_exists("sBCC", $oParams)) {
				if (is_array($oParams['sBCC'])) {
					foreach ($oParams['sBCC'] as $row)
						$mail->AddBCC(trim($row));
				} else
					$mail->AddBCC(trim($oParams['sBCC']));
			}
			//------------------------------------------------------------------------------------------


			$mail->SetFrom(trim($oData['USER_MAIL_SERVER']), empty($oParams['sSenderName']) ? $this->config->item('ConAppName') : trim($oParams['sSenderName']));
			$mail->isHTML(true);
			$mail->MsgHTML(trim($oParams['sMessage']));

			//$DS = DIRECTORY_SEPARATOR;		  
			//$mail->AddAttachment(getcwd().$DS."bootstrap".$DS."css".$DS."bootstrap.min.css", "body01.css");      
			//$mail->AddAttachment(getcwd().$DS."dist".$DS."css".$DS."AdminLTE.min.css", "body02.css"); 

			$mail->Send();
			$mailException = json_encode(array("status" => 1, "message" => "Message Sent OK\n"));
			//$mail->AddAttachment('images/phpmailer_mini.gif'); 
			//$mail->AddReplyTo('ado@gramedia.com', 'Edwar Rinaldo');
			//$mail->SMTPSecure = "ssl";
		} catch (phpmailerException $e) {
			$mailException = $e->errorMessage();
			$sReturn = json_encode(array("status" => -1, "message" => $mailException));
			return $sReturn;
			exit(0);
		} catch (Exception $e) {
			$mailException = $e->getMessage();
			$sReturn = json_encode(array("status" => -1, "message" => $mailException));
			return $sReturn;
			exit(0);
		}
		return $sReturn;
	}
	function gf_send_email_x($oParams)
	{
		$oConfig = $this->m_core_apps->gf_read_config_apps(array("API_MAIL_POOLING_HOST", "BEHIND_THE_PROXY", "NOTIF_TO_EMAIL"));
		$os 		 = strtoupper(substr(PHP_OS, 0, 3));
		$SP 		 = DIRECTORY_SEPARATOR;
		$SCRIPT  = null;
		//--- Temp File
		$sFileName = substr(uniqid(), 5) . ".txt";
		$sFolder = sys_get_temp_dir();
		$sFullPath = $sFolder . $SP . $sFileName;
		if (!file_exists($sFullPath)) {
			$myfile = fopen($sFullPath, "w") or die("Unable to open file!");
			$txt = "from_name=".trim($oParams['sFromName'])."&to_email=" . trim($oParams['sEmail']) . "&subject_email=" . trim($oParams['sEmailSubject']) . "&text_email=" . trim(strip_tags($oParams['sEmailMessage'])) . "&html_email=" . trim($oParams['sEmailMessage']);
			fwrite($myfile, $txt);
			fclose($myfile);
		}
		$PARAMS2 = trim($oConfig['API_MAIL_POOLING_HOST']);
		$PARAMS1 = "-X POST -d @" . $sFullPath;
		$PARAMS3 = "";
		if (trim($oConfig['BEHIND_THE_PROXY']) === "TRUE") {
			$oConfig = $this->m_core_apps->gf_read_config_apps(array("PROXY_ADDRESS"));
			$PARAMS3 = "--proxy " . trim($oConfig['PROXY_ADDRESS']);
		}
		if (trim($os) === "WIN") {
			$DS = DIRECTORY_SEPARATOR;
			$CURL_PATH = getcwd() . $DS . "curl" . $DS . "curl.exe";
			$SCRIPT = $CURL_PATH . " " . $PARAMS1 . " " . $PARAMS2 . " " . $PARAMS3 . " -k";
			pclose(popen("start /B " . $SCRIPT, "r"));
		} else if (trim($os) === "LIN") {
			$SCRIPT = "curl " . $PARAMS1 . " " . $PARAMS2 . " " . $PARAMS3 . " -k";
			exec($SCRIPT . " > /dev/null &");
		}
	}
	function gf_send_wa($oParams)
	{
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$SP = DIRECTORY_SEPARATOR;
		$os = strtoupper(substr(PHP_OS, 0, 3));
		//------------------------------------------------
		$sFileName = substr(uniqid(), 5) . ".txt";
		$sFolder = sys_get_temp_dir();
		$sFullPath = $sFolder . $SP . $sFileName;
		if (!file_exists($sFullPath)) {
			$myfile = fopen($sFullPath, "w") or die("Unable to open file!");
			$txt = "phonenumber=".trim($oParams['sNoHP'])."&message=".trim($oParams['sWAMessage'])."&fromapp=prepayment2";
			fwrite($myfile, $txt);
			fclose($myfile);
		}
		//------------------------------------------------
		$PARAMS2 = trim($oConfig['WHATSAPP_API_ENDPOINT']);
		$PARAMS1 = "-X POST -d @" . trim($sFullPath);
		$PARAMS3 = "";
		if (trim($oConfig['BEHIND_THE_PROXY']) === "TRUE") {
			$oConfig = $this->m_core_apps->gf_read_config_apps(array("PROXY_ADDRESS"));
			$PARAMS3 = "--proxy " . trim($oConfig['PROXY_ADDRESS']);
		}
		if (trim($os) === "WIN") {
			$DS = DIRECTORY_SEPARATOR;
			$CURL_PATH = getcwd() . $DS . "curl" . $DS . "curl.exe";
			$SCRIPT = $CURL_PATH . " " . $PARAMS1 . " " . $PARAMS2 . " " . $PARAMS3 . " -k";
			pclose(popen("start /B " . $SCRIPT, "r"));
		} else if (trim($os) === "LIN") {
			$SCRIPT = "curl " . $PARAMS1 . " " . $PARAMS2 . " " . $PARAMS3 . " -k";
			exec($SCRIPT . " > /dev/null &");
		}
	}
	function gf_unique_id()
	{
		return md5(uniqid());
	}
	function gf_random($oParams = array())
	{
		$Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
		$QuantidadeCaracteres = strlen($Caracteres);
		$QuantidadeCaracteres--;
		$Hash = NULL;
		for ($x = 1; $x <= $oParams['oLength']; $x++) {
			$Posicao = rand(0, $QuantidadeCaracteres);
			$Hash .= substr($Caracteres, $Posicao, 1);
		}
		return $Hash;
	}
	function gf_enc_dec($oParams = array())
	{
		$sReturn = null;
		$sData = trim($oParams['sData']);
		$nSeed = intval($oParams['nSeed']);
		$sMode = trim($oParams['sMode']);
		for ($i = 0; $i < $nSeed; $i++) {
			if (trim($sMode) === "ENC")
				$sData = base64_encode(($sData));
			elseif (trim($sMode) === "DEC")
				$sData = base64_decode(($sData));
		}
		$sReturn = $sData;
		return json_encode(array("sData" => $sReturn));
	}
	function gf_read_config_apps($oParams=array())
	{
		$oData = null;
		if(count($oParams) === 0)
			$sql = "call sp_query('select sAppsConfigValue, sAppsConfigKey from tm_apps_config where sStatusDelete is null')";
		else
			$sql = "call sp_query('select sAppsConfigValue, sAppsConfigKey from tm_apps_config where sStatusDelete is null and sAppsConfigKey in (''".implode("'', ''", $oParams)."'')')";
		$rs = $this->db->query($sql);
		foreach ($rs->result_array() as $row)
			$oData[$row['sAppsConfigKey']] = $row['sAppsConfigValue'];
		$rs->free_result();
		return $oData;
	}
	function gf_get_max_pattern_id($oParams = array())
	{
		$sReturn = null;
		$sql = "call sp_core_get_max_id_string('" . trim($oParams['sTableName']) . "', '" . trim($oParams['sFieldName']) . "', '" . trim($oParams['sPrefix']) . "', " . trim($oParams['nLength']) . ", '" . $oParams['sParams'] . "')";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $rs->row_array();
			$sReturn = $row['max_id'];
		}
		return $sReturn;
	}
	function gf_get_max_date_pattern($oParams = array())
	{
		$sReturn = null;
		$sql = "call sp_core_get_max_id_date_counter('" . trim($oParams['sPrefix']) . "'," . trim($oParams['nLength']) . ", '" . trim($oParams['sTableName']) . "', '" . trim($oParams['sFieldName']) . "', '" . $oParams['sParams'] . "', 'FULL.DATE.ONLY')";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $rs->row_array();
			$sReturn = $row['max_id'];
		}
		return $sReturn;
	}
	function gf_read_email_template($oParams = array())
	{
		$sReturn = null;
		$DS = DIRECTORY_SEPARATOR;
		$EmailTemplateNamePath = getcwd() . $DS . "emails" . $DS . trim($oParams['sFileName']);
		$this->load->library('libIO');
		$libIO = new libIO();
		if (file_exists($EmailTemplateNamePath)) {
			$sReturn = $libIO->gf_read_file(array("path" => $EmailTemplateNamePath));
			$sReturn = json_decode($sReturn, TRUE);
			//--
			$oContent     = trim($sReturn['txtNativeHTML']);
			$oSQL         = trim($sReturn['txtNativeSQL']);
			//--
			if (is_array($oParams['oParams'])) {
				foreach ($oParams['oParams'] as $key => $value)
					$oSQL = str_replace(trim("@" . $key), trim($value), trim($oSQL));
			}
			//--
			$this->load->library('libRptEngine');
			$libRptEngine = new libRptEngine();
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
			$sReturn = str_replace("<tr><td></td></tr>", "", $libRptEngine->gf_process($oContent, $oRowData));
		}
		return json_encode(array("sData" => trim($sReturn), "sSQL" => trim($oSQL), "sContent" => $oContent));
	}
	function gf_query_to_grid($oParams = array())
	{
		$oConfig = $this->gf_read_config_apps();
		$sReturn = null;
		$sql = trim($oParams['sSQL']);
		$rs = $this->db->query($sql);
		$sReturn = "<div class=\"table-responsive\">";
		$sReturn .= "<table class=\"" . trim($oConfig['TABLE_CLASS']) . "\">";
		//----------------------------
		$sReturn .= "<tr>";
		$sReturn .= "<td>No</td>";
		foreach ($rs->field_data() as $fld) {
			if (array_key_exists("oShowField", $oParams)) {
				if (in_array(trim($fld->name), $oParams['oShowField']))
					$sReturn .= "<td>" . trim($fld->name) . "</td>";
			} else
				$sReturn .= "<td>" . trim($fld->name) . "</td>";
		}
		$sReturn .= "</tr>";
		//----------------------------
		if ($rs->num_rows() > 0) {
			$i = 1;
			foreach ($rs->result_array() as $row) {
				$r = "<tr>";
				$r .= "<td class=\"text-right\">" . $i . "</td>";
				foreach ($rs->field_data() as $fld) {
					if (array_key_exists("oShowField", $oParams)) {
						if (in_array(trim($fld->name), $oParams['oShowField']))
							$r .= "<td>" . trim($row[$fld->name]) . "</td>";
					} else
						$r .= "<td>" . trim($row[$fld->name]) . "</td>";
				}
				$r .= "</tr>";
				$sReturn .= $r;
				$i++;
			}
			$sReturn .= "<tr><td colspan=\"10\">Data Count: " . $rs->num_rows() . "</td></tr>";
		} else
			$sReturn = "<tr><td colspan=\"10\">Data not found</td></tr>";
		$sReturn .= "</table>";
		$sReturn .= "</div>";
		return $sReturn;
	}
	function gf_generate_log_col($oParams = array())
	{
		$sPrefix = array_key_exists("sPrefix", $oParams) ? trim($oParams['sPrefix']) . "." : "";
		//$s = "concat('Insert: ', ifnull(sCreateBy, ''), '@', ifnull(dCreateOn, ''), '<br />', 'Last Update: ', ifnull(sLastEditBy, ''), '@', ifnull(dLastEditOn, ''), '<br />', 'Delete: ', ifnull(sDeleteBy, ''), '@', ifnull(dDeleteOn, '')) as `Logs`";// is null then ''''"
		$s = $sPrefix . "sCreateBy as `Created By`, " . $sPrefix . "dCreateOn as `Created On`, " . $sPrefix . "sLastEditBy as `Last Edited By`, " . $sPrefix . "dLastEditOn as `Last Edited On`/*, " . $sPrefix . "sDeleteBy as `Deleted By`, " . $sPrefix . "dDeleteOn as `Deleted On`, " . $sPrefix . "sStatusDelete as `Status Delete`*/";
		return $s;
	}
	function gf_query_to_json($oParams = array())
	{
		$sql = trim($oParams['sSQL']);
		$rs = $this->db->query($sql);
		$sReturn = null;
		if (array_key_exists('single', $oParams))
			$sReturn = array("oData" => $rs->row_array());
		else if (array_key_exists('multi', $oParams))
			$sReturn = array("oData" => $rs->result_array());
		return json_encode($sReturn);
	}
	function gf_parse_ini_file($oParams = array())
	{
		$oParams = count($oParams) === 0 ? $this->input->post('sPath') : $oParams['sPath'];
		$myfile = fopen($oParams, "r") or die("Unable to open file!");
		$s = fread($myfile, filesize($oParams));
		fclose($myfile);
		return $s;
	}
	function gf_group_array_by_key($oParams = array())
	{
		$result = array();
		$key = trim($oParams['sKey']);
		$data = $oParams['sData'];
		foreach ($data as $val) {
			if (array_key_exists($key, $val))
				$result[$val[$key]][] = $val;
			else
				$result[""][] = $val;
		}
		return $result;
	}
	function gf_clean_avatar()
	{
		$sReturn = null;
		$sql = "call sp_query('select sAvatar from tm_user_logins where sStatusDelete is null');";
		$rs = $this->db->query($sql);
		$oAvatarArray = $rs->result_array();

		$SP = DIRECTORY_SEPARATOR;
		$filelist = array();
		if ($handle = opendir(getcwd() . $SP . "uploads" . $SP . "avatar")) {
			while ($entry = readdir($handle)) {
				if (in_array(trim($entry), array(".", ".."))) break;
				if (!in_array(trim($entry), $oAvatarArray))
					unlink(getcwd() . $SP . "uploads" . $SP . "avatar" . $SP . trim($entry));
			}
			closedir($handle);
		}
	}
	function gf_count_files_in_directory($oParams = array())
	{
		return json_encode(array("oCountOfFiles" => iterator_count(new FilesystemIterator(trim($oParams['sPath']), FilesystemIterator::SKIP_DOTS))));
	}
	function gf_delete_files_in_directory($oParams = array())
	{
		$dirname = trim($oParams['sPath']);
		$c = json_decode($this->m_core_apps->gf_count_files_in_directory(array("sPath" => $dirname)), TRUE);
		$c = intval($c['oCountOfFiles']);
		$d = 0;
		$e = intval($oParams['oDel']);
		$f = intval($c) - intval($e);
		if (is_dir($dirname))
			$dir_handle = opendir($dirname);
		if (!$dir_handle)
			return false;
		while ($file = readdir($dir_handle)) {
			if ($file != "." && $file != "..") {
				if (!is_dir($dirname . DIRECTORY_SEPARATOR . $file)) {
					$filelastmodified = filemtime($dirname . DIRECTORY_SEPARATOR . $file);
					//----------------------------------------------------------------
					// Hajar semua
					unlink($dirname . DIRECTORY_SEPARATOR . $file);
					//----------------------------------------------------------------
					//24 hours in a day * 3600 seconds per hour
					//if((time() - $filelastmodified) > 24*3600)
					//{
					//unlink($dirname.DIRECTORY_SEPARATOR.$file);
					//}
					//----------------------------------------------------------------
					// 10 menit terakhir
					//if((time()-$filelastmodified) > 600)
					//	unlink($dirname.DIRECTORY_SEPARATOR.$file);
					//----------------------------------------------------------------
				} else
					$this->gf_delete_files_in_directory(array("sPath" => $dirname . DIRECTORY_SEPARATOR . $file, "oDel" => intval($e)));
				$d++;
			}
			if ($d > $f)
				break;
		}
		closedir($dir_handle);
	}
	function get_os()
	{
		$os_platform  = "Unknown OS Platform";
		$os_array     = array(
			'/windows nt 10/i'      =>  'Windows 10',
			'/windows nt 6.3/i'     =>  'Windows 8.1',
			'/windows nt 6.2/i'     =>  'Windows 8',
			'/windows nt 6.1/i'     =>  'Windows 7',
			'/windows nt 6.0/i'     =>  'Windows Vista',
			'/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
			'/windows nt 5.1/i'     =>  'Windows XP',
			'/windows xp/i'         =>  'Windows XP',
			'/windows nt 5.0/i'     =>  'Windows 2000',
			'/windows me/i'         =>  'Windows ME',
			'/win98/i'              =>  'Windows 98',
			'/win95/i'              =>  'Windows 95',
			'/win16/i'              =>  'Windows 3.11',
			'/macintosh|mac os x/i' =>  'Mac OS X',
			'/mac_powerpc/i'        =>  'Mac OS 9',
			'/linux/i'              =>  'Linux',
			'/ubuntu/i'             =>  'Ubuntu',
			'/iphone/i'             =>  'iPhone',
			'/ipod/i'               =>  'iPod',
			'/ipad/i'               =>  'iPad',
			'/android/i'            =>  'Android',
			'/blackberry/i'         =>  'BlackBerry',
			'/webos/i'              =>  'Mobile'
		);
		foreach ($os_array as $regex => $value)
			if (preg_match($regex, $_SERVER['HTTP_USER_AGENT']))
				$os_platform = $value;
		return $os_platform;
	}
	function gf_recordset_export($oParams = array())
	{
		$sReturn = null;
		$hideSQL = trim($oParams['sSQL']);
		$hideFileName = array_key_exists("sFileName", $oParams) ? trim($oParams['sFileName']) : "Export_" . date('d_m_Y_H_i_s');
		$hideFileExt = array_key_exists("sFileExt", $oParams) ? trim($oParams['sFileExt']) : "xls";
		$hideHeaderDesc = array_key_exists("sHeaderDesc", $oParams) ? $oParams['sHeaderDesc'] : $this->input->post('sHeaderDesc', TRUE);
		$rs = $this->db->query($hideSQL);
		$fields = $rs->field_data();
		$numfield = $rs->num_fields();
		$sReturn .= "<table>";
		//-------------------------------
		foreach ($hideHeaderDesc as $s)
			$sReturn .= "<tr><td style=\"font-weight: bold; font-size: 18pt; text-align: center;\" colspan=\"" . trim($rs->num_fields()) . "\">" . $s . "</td></tr>";
		//-------------------------------
		$sReturn .= "<tr>";
		foreach ($fields as $f) {
			$sLinkActive = trim($f->name);
			$sReturn .= "<td>" . $sLinkActive . "</td>";
		}
		$sReturn .= "</tr>";
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $row) {
				$sReturn .= "<tr class=\"cursor-pointer\">";
				foreach ($fields as $f) {
					$sReturn .= "<td>" . ((in_array($f->type, array(5)) && !$f->primary_key && is_numeric(trim($row[$f->name]))) ? number_format(trim($row[$f->name]), 0) : trim($row[$f->name])) . "</td>";
				}
				$sReturn .= "</tr>";
			}
		} else
			$sReturn .= "<tr><td class=\"text-center\" colspan=\"" . trim($rs->num_fields()) . "\">No Data, Please check your parameters !</td>";
		$sReturn .= "</table>";
		header("Content-type: application/vnd-ms-excel");
		header("Content-Disposition: attachment; filename=" . trim($hideFileName) . "." . trim($hideFileExt));
		header("Pragma: no-cache");
		header("Expires: 0");
		print $sReturn;
	}
	function gf_get_result_array($oParams = array())
	{
		return $this->db->query($oParams['sql'])->result_array();
	}
	function gf_get_row_array($oParams = array())
	{
		return $this->db->query($oParams['sql'])->row_array();
	}
	function gf_load_additional_data($oParams = array())
	{
		$data['o_side_bar'] = array_key_exists("loadMenu", $oParams) ? $this->m_core_user_menu->gf_recursive_side_bar(array("nMenuId" => 0, "nMenuIdInit" => 0)) : "";
		$data['o_info'] = $this->m_core_user_login->gf_user_info();
		$data['o_config'] = $this->m_core_apps->gf_read_config_apps();
		$oAuth = json_decode($this->m_core_user_login->gf_load_auth(array("sMenuCtlName" => trim($oParams['sMenuCtlName']))), TRUE);
		$data['o_save']   = trim($oAuth['sSave']);
		$data['o_update'] = trim($oAuth['sUpdate']);
		$data['o_delete'] = trim($oAuth['sDelete']);
		$data['o_cancel'] = trim($oAuth['sCancel']);
		return $data;
	}
	function gf_delete_file_in_folder_in_days($oParams = array())
	{
		$files = glob($oParams['oPath'] . "*");
		$now   = time();
		foreach ($files as $file) {
			if (is_file($file)) {
				//2 days
				if ($now - filemtime($file) >= 60 * 60 * 24 * intval($oParams['oDays']))
					unlink($file);
			}
		}
	}
	function gf_delete_file_in_folder_in_hours($oParams = array())
	{
		$files = glob($oParams['oPath'] . "*");
		$now   = time();
		foreach ($files as $file) {
			if (is_file($file)) {
				//2 days
				if ($now - filemtime($file) >= 60 * 60 * intval($oParams['oHours']))
					unlink($file);
			}
		}
	}
	function gf_delete_file_in_folder_in_minutes($oParams = array())
	{
		$files = glob($oParams['oPath'] . "*");
		$now   = time();
		foreach ($files as $file) {
			if (is_file($file)) {
				//2 days
				if ($now - filemtime($file) >= 60 * intval($oParams['oMinutes']))
					unlink($file);
			}
		}
	}
	function gf_delete_file_in_folder_in_seconds($oParams = array())
	{
		$files = glob($oParams['oPath'] . "*");
		$now   = time();
		foreach ($files as $file) {
			if (is_file($file)) {
				//2 days
				if ($now - filemtime($file) >= intval($oParams['oSeconds']))
					unlink($file);
			}
		}
	}
	function gf_minify_css($input)
	{
		if (trim($input) === "") return $input;
		return preg_replace(
			array(
				// Remove comment(s)
				'#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
				// Remove unused white-space(s)
				'#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~]|\s(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
				// Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
				'#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
				// Replace `:0 0 0 0` with `:0`
				'#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
				// Replace `background-position:0` with `background-position:0 0`
				'#(background-position):0(?=[;\}])#si',
				// Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
				'#(?<=[\s:,\-])0+\.(\d+)#s',
				// Minify string value
				'#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
				'#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
				// Minify HEX color code
				'#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
				// Replace `(border|outline):none` with `(border|outline):0`
				'#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
				// Remove empty selector(s)
				'#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
			),
			array(
				'$1',
				'$1$2$3$4$5$6$7',
				'$1',
				':0',
				'$1:0 0',
				'.$1',
				'$1$3',
				'$1$2$4$5',
				'$1$2$3',
				'$1:0',
				'$1$2'
			),
			$input
		);
	}
	function gf_minify_js($input)
	{
		//return $input;
		if (trim($input) === "") return $input;
		//return trim(preg_replace(array('/\s+/'), array(' '), $input));
		return preg_replace(
			/*array(
	            // Remove comment(s)
	            '#\s*("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')\s*|\s*\/\*(?!\!|@cc_on)(?>[\s\S]*?\*\/)\s*|\s*(?<![\:\=])\/\/.*(?=[\n\r]|$)|^\s*|\s*$#',
	            // Remove white-space(s) outside the string and regex
	            '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/)|\/(?!\/)[^\n\r]*?\/(?=[\s.,;]|[gimuy]|$))|\s*([!%&*\(\)\-=+\[\]\{\}|;:,.<>?\/])\s*#s',
	            // Remove the last semicolon
	            '#;+\}#',
	            // Minify object attribute(s) except JSON attribute(s). From `{'foo':'bar'}` to `{foo:'bar'}`
	            '#([\{,])([\'])(\d+|[a-z_][a-z0-9_]*)\2(?=\:)#i',
	            // --ibid. From `foo['bar']` to `foo.bar`
	            '#([a-z0-9_\)\]])\[([\'"])([a-z_][a-z0-9_]*)\2\]#i'
	        ),
	        array(
	            '$1',
	            '$1$2',
	            '}',
	            '$1$3',
	            '$1.$3'
	        )*/
			array(
				//MULTILINE_COMMENT
				'~\Q/*\E[\s\S]+?\Q*/\E~m',
				//SINGLELINE_COMMENT
				'~(?:http|ftp)s?://(*SKIP)(*FAIL)|//.+~m',
				//WHITESPACE
				'~/\s+/~m',
			),
			array(
				'',
				'',
				'',
			),
			$input
		);
	}
	function gf_get_user_info($oParams)
	{
		$sReturn = null;
		$sql = "call sp_query('select * from tm_user_logins where nUserId in (''".implode(",", $oParams)."'')');";
		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
			$sReturn = json_encode($rs->result_array());
		return $sReturn;
	}
	function gf_gray_scale_image($oParams)
	{
		$sFileName = $oParams['sImageRealPath'];
		$RsFileName = explode(DIRECTORY_SEPARATOR, $oParams['sImageRealPath']);
		$RsFileName = $RsFileName[count($RsFileName) - 1];
		$imgcreate = imagecreatefrompng($sFileName);
		if($imgcreate && imagefilter($imgcreate, IMG_FILTER_GRAYSCALE))
			imagepng($imgcreate, $RsFileName);
		imagedestroy($imgcreate);
	}
	function gf_add_stamp_image($oParams)
	{
		$DS = DIRECTORY_SEPARATOR;
		$stamp = imagecreatefrompng(getcwd().$DS."img".$DS."ap.png");
		$im = imagecreatefromjpeg(getcwd().$DS."uploads".$DS."customer".$DS.base64_decode($oParams));

		//print getcwd().$DS."img".$DS."ap.png";
		//exit(0);

		$marge_right = 10;
		$marge_bottom = 10;
		$sx = imagesx($stamp);
		$sy = imagesy($stamp);

		imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0, imagesx($stamp), imagesy($stamp));

		header('Content-type: image/png');
		imagepng($im);
		imagedestroy($im);
	}
}
