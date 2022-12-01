<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_forgot_password extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_login', 'm_core_user_login', 'm_core_forgot_password'));
	}
	public function d($sSession = "")
	{
		$data['o_config'] = $this->m_core_apps->gf_read_config_apps();
		$data['o_page'] = 'backend/v_core_forgot_password';
		$data['o_info'] = $this->m_core_forgot_password->gf_load_info($sSession);
		$this->load->view('backend/v_core_main', $data);
	}
	function gf_reset_password()
	{
		print $this->m_core_forgot_password->gf_reset_password();
	}
}
