<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_upload extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps', 'm_core_upload', 'm_core_user_login'));
	}
	function gf_upload()
	{
		$this->m_core_user_login->gf_clean_avatar();
		print $this->m_core_upload->gf_upload();
	}
	function gf_checking_file()
	{
		print $this->m_core_upload->gf_checking_file();
	}
	function gf_download_file($oParams = array())
	{
		$sF = json_decode($this->m_core_apps->gf_enc_dec(array("sData" => trim($this->input->post('sFileName', TRUE)), "nSeed" => $this->input->post('nSeed', TRUE), "sMode" => "DEC")), TRUE);
		$path = trim($sF['sData']);
		$path = str_replace(array("\\\\"), array("\\"), trim($path));
		@ini_set('error_reporting', E_ALL & ~E_NOTICE);
		@apache_setenv('no-gzip', 1);
		@ini_set('zlib.output_compression', 'Off');
		$path_parts = pathinfo($path);
		$file_name  = $path_parts['basename'];
		$file_ext   = $path_parts['extension'];
		$file_path  = $path;
		$is_attachment = isset($_REQUEST['stream']) ? false : true;
		if (is_file($file_path)) {
			$file_size  = filesize($file_path);
			$file = @fopen($file_path, "rb");
			if ($file) {
				header("Pragma: public");
				header("Expires: -1");
				header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
				header("Content-Disposition: attachment; filename=\"$file_name\"");
				if ($is_attachment)
					header("Content-Disposition: attachment; filename=\"$file_name\"");
				else
					header('Content-Disposition: inline;');
				$ctype_default = "application/octet-stream";
				$content_types = array(
					"exe" => "application/octet-stream",
					"zip" => "application/zip",
					"mp3" => "audio/mpeg",
					"mpg" => "video/mpeg",
					"avi" => "video/x-msvideo"
				);
				$ctype = isset($content_types[$file_ext]) ? $content_types[$file_ext] : $ctype_default;
				header("Content-Type: " . $ctype);
				if (isset($_SERVER['HTTP_RANGE'])) {
					list($size_unit, $range_orig) = explode('=', $_SERVER['HTTP_RANGE'], 2);
					if ($size_unit == 'bytes')
						list($range, $extra_ranges) = explode(',', $range_orig, 2);
					else {
						$range = '';
						header('HTTP/1.1 416 Requested Range Not Satisfiable');
						exit;
					}
				} else
					$range = '';
				list($seek_start, $seek_end) = explode('-', $range, 2);
				$seek_end   = (empty($seek_end)) ? ($file_size - 1) : min(abs(intval($seek_end)), ($file_size - 1));
				$seek_start = (empty($seek_start) || $seek_end < abs(intval($seek_start))) ? 0 : max(abs(intval($seek_start)), 0);
				if ($seek_start > 0 || $seek_end < ($file_size - 1)) {
					header('HTTP/1.1 206 Partial Content');
					header('Content-Range: bytes ' . $seek_start . '-' . $seek_end . '/' . $file_size);
					header('Content-Length: ' . ($seek_end - $seek_start + 1));
				} else
					header("Content-Length: $file_size");
				header('Accept-Ranges: bytes');
				set_time_limit(0);
				fseek($file, $seek_start);
				while (!feof($file)) {
					print(@fread($file, 1024 * 8));
					ob_flush();
					flush();
					if (connection_status() != 0) {
						@fclose($file);
						exit;
					}
				}
				@fclose($file);
				exit;
			} else {
				header("HTTP/1.0 500 Internal Server Error");
				exit;
			}
		} else {
			header("HTTP/1.0 404 Not Found");
			exit;
		}
	}
	function gf_load_image($sParam = null)
	{
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$DS        = DIRECTORY_SEPARATOR;
		$file  = getcwd() . $DS . $oConfig['UPLOAD_DIR'] . $DS . trim($sParam);
		$file_extension = strtolower(substr(strrchr(basename($file), "."), 1));
		switch ($file_extension) {
			case "gif":
				$ctype = "image/gif";
				break;
			case "png":
				$ctype = "image/png";
				break;
			case "jpeg":
				$ctype = "image/jpg";
				break;
			case "jpg":
				$ctype = "image/jpeg";
				break;
			default:
		}
		header('Content-Type:' . $ctype);
		header('Content-Length: ' . filesize($file));
		//readfile($file);
		print file_get_contents($file);
		exit(0);
	}
	function gf_checking_physical_file()
	{
		print $this->m_core_upload->gf_checking_physical_file();
	}
	function gf_remove_physical_file()
	{
		print $this->m_core_upload->gf_remove_physical_file();
	}
	function gf_download_file_by_file_name()
	{
		$sFileName = $this->input->post('sFileName', TRUE);
		$sFolder = $this->input->post('sFolder', TRUE);
		$oConfig   = $this->m_core_apps->gf_read_config_apps();
		$DS        = DIRECTORY_SEPARATOR;
		$path      = getcwd() . $DS . $oConfig['UPLOAD_DIR'] . $DS . (trim($sFolder) !== "" && !empty($sFolder) ? trim($sFolder) . $DS : "") . $sFileName;
		@ini_set('error_reporting', E_ALL & ~E_NOTICE);
		@apache_setenv('no-gzip', 1);
		@ini_set('zlib.output_compression', 'Off');
		$path_parts = pathinfo($path);
		$file_name  = $path_parts['basename'];
		$file_ext   = $path_parts['extension'];
		$file_path  = $path;
		$is_attachment = isset($_REQUEST['stream']) ? false : true;
		if (is_file($file_path)) {
			$file_size  = filesize($file_path);
			$file = @fopen($file_path, "rb");
			if ($file) {
				header("Pragma: public");
				header("Expires: -1");
				header("Cache-Control: public, must-revalidate, post-check=0, pre-check=0");
				header("Content-Disposition: attachment; filename=\"$file_name\"");
				if ($is_attachment)
					header("Content-Disposition: attachment; filename=\"$file_name\"");
				else
					header('Content-Disposition: inline;');
				$ctype_default = "application/octet-stream";
				$content_types = array(
					"exe" => "application/octet-stream",
					"zip" => "application/zip",
					"mp3" => "audio/mpeg",
					"mpg" => "video/mpeg",
					"avi" => "video/x-msvideo"
				);
				$ctype = isset($content_types[$file_ext]) ? $content_types[$file_ext] : $ctype_default;
				header("Content-Type: " . $ctype);
				if (isset($_SERVER['HTTP_RANGE'])) {
					list($size_unit, $range_orig) = explode('=', $_SERVER['HTTP_RANGE'], 2);
					if ($size_unit == 'bytes')
						list($range, $extra_ranges) = explode(',', $range_orig, 2);
					else {
						$range = '';
						header('HTTP/1.1 416 Requested Range Not Satisfiable');
						exit;
					}
				} else
					$range = '';
				list($seek_start, $seek_end) = explode('-', $range, 2);
				$seek_end   = (empty($seek_end)) ? ($file_size - 1) : min(abs(intval($seek_end)), ($file_size - 1));
				$seek_start = (empty($seek_start) || $seek_end < abs(intval($seek_start))) ? 0 : max(abs(intval($seek_start)), 0);
				if ($seek_start > 0 || $seek_end < ($file_size - 1)) {
					header('HTTP/1.1 206 Partial Content');
					header('Content-Range: bytes ' . $seek_start . '-' . $seek_end . '/' . $file_size);
					header('Content-Length: ' . ($seek_end - $seek_start + 1));
				} else
					header("Content-Length: $file_size");
				header('Accept-Ranges: bytes');
				set_time_limit(0);
				fseek($file, $seek_start);
				while (!feof($file)) {
					print(@fread($file, 1024 * 8));
					ob_flush();
					flush();
					if (connection_status() != 0) {
						@fclose($file);
						exit;
					}
				}
				@fclose($file);
				exit;
			} else {
				header("HTTP/1.0 500 Internal Server Error");
				exit;
			}
		} else {
			header("HTTP/1.0 404 Not Found");
			exit;
		}
	}
	function gf_load_image_by_supload_id($sParam = null)
	{
		$oFileInfo = json_decode($this->m_core_upload->gf_get_file_upload_info(array("sUploadId" => $sParam)), TRUE);
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		if (trim($oFileInfo['oData']['sOriginalFileName']) !== "") {
			$DS        = DIRECTORY_SEPARATOR;
			$file  = getcwd() . $DS . $oConfig['UPLOAD_DIR'] . $oFileInfo['oData']['sPathFile'] . $oFileInfo['oData']['sOriginalFileName'];
			$file_extension = strtolower(substr(strrchr(basename($file), "."), 1));
			switch ($file_extension) {
				case "gif":
					$ctype = "image/gif";
					break;
				case "png":
					$ctype = "image/png";
					break;
				case "jpeg":
					$ctype = "image/jpg";
					break;
				case "jpg":
					$ctype = "image/jpeg";
					break;
				default:
			}
			header('Content-Type:' . $ctype);
			header('Content-Length: ' . filesize($file));
			print file_get_contents($file);
			exit(0);
		}
	}
}
