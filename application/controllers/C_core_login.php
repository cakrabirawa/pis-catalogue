<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_login', 'm_core_user_login', 'm_core_user_menu'));
	}
	function index()
	{
		$a = new libSession();
		if ($a->gf_check_session()) {
			$this->data['o_page'] = 'backend/v_core_login';
			$this->data['o_page_title'] = 'Login Page';
			$this->data['o_page_desc'] = 'Login Page';
			$this->data['o_data'] 							= null;
			$this->data['o_extra']['o_config']	= $this->m_core_apps->gf_read_config_apps();
			$this->data['o_extra']['o_nav_bar']	= null;
			$this->data['o_extra']['o_save'] 		= null;
			$this->data['o_extra']['o_update'] 	= null;
			$this->data['o_extra']['o_delete'] 	= null;
			$this->data['o_extra']['o_cancel'] 	= null;
			$this->data['o_mode'] = "I";
			$this->load->view('backend/v_core_main', $this->data);
		} else
			redirect(site_url());
	}
	function gf_check_login()
	{
		print $this->m_core_login->gf_check_login();
	}
	function gf_register()
	{
		print $this->m_core_login->gf_register();
	}
	function gf_forgot_password()
	{
		print $this->m_core_login->gf_forgot_password();
	}
	function gf_change_login($nUserId = null)
	{
		$sOuput = json_decode($this->m_core_login->gf_change_login($nUserId), TRUE);
		if (intval($sOuput['status']) === 1)
			redirect("/", TRUE);
	}
	function gf_load_file()
	{
		$file = site_url() . "img/img_bg_login.png";
		$im = imagecreatefrompng($file);
		header('Content-Type: image/png');
		imagepng($im);
		imagedestroy($im);
	}
	function gf_activation($sHash = "")
	{
		$sReturn = json_decode($this->m_core_login->gf_activation($sHash), TRUE);
		$data['o_page'] = 'backend/v_core_registration';
		$data['o_config'] = $this->m_core_apps->gf_read_config_apps();
		$data['o_msg'] = $sReturn;
		//--Authorized --
		$this->load->view('backend/v_core_main', $data);
	}
	function gf_check_session_ajax()
	{
		print json_encode(array("status" => (trim($this->session->userdata('nUserId')) === "" ? 1 : 0)));
	}
}
