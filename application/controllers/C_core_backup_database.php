<?php
/*
------------------------------
Menu Name: Backup Database
File Name: C_core_backup_database.php
File Path: /var/www/pis/application/controllers/C_core_backup_database.php
Create Date Time: 2020-05-18 20:12:29
------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_backup_database extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_backup_database'));
	}
	public function index()
	{
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$data['o_page'] = 'backend/v_core_backup_database';
			$data['o_page_title'] = 'Backup Database';
			$data['o_page_desc'] = 'Maintenance Backup Database';
			$data['o_data'] = null;
			$data['o_mode'] = "I";
			$data['o_side_bar'] = $this->m_core_user_menu->gf_recursive_side_bar(array("nMenuId" => 0, "nMenuIdInit" => 0));
			$data['o_info'] = null;
			$data['o_config'] = $this->m_core_apps->gf_read_config_apps();
			$data['o_backuplist'] = $this->m_core_backup_database->gf_list_backup_file();
			$this->load->view('backend/v_core_main', $data);
		}
	}
	function gf_download_backup_file($filename)
	{
		$path = getcwd() . DIRECTORY_SEPARATOR . "backupdb" . DIRECTORY_SEPARATOR . $filename;
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
	function gf_execute_job()
	{
		$this->m_core_backup_database->gf_load_backup_file();
	}
}
