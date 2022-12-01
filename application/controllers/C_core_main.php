<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_main extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else
			$this->load->model(array('m_core_login', 'm_core_user_menu', 'm_prepayment_karyawan', 'm_prepayment_pengajuan_pre_payment', 'm_core_user_login', 'm_core_apps', 'm_core_main', 'm_core_chart'));
	}
	public function index()
	{
		$this->data['o_page'] 						= 'backend/v_core_welcome';
		$this->data['o_page_title'] 			= 'Welcome to Your Dashboard, ' . $this->session->userdata('sRealName') . ' !';
		$this->data['o_page_desc'] 				= '';
		$this->data['o_extra']      			= $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_main", "loadMenu" => true));
		$this->data['o_info'] 						= $this->m_core_user_login->gf_user_info();		
		$this->data['o_config'] 					= $this->m_core_apps->gf_read_config_apps();
		$this->load->view('backend/v_core_main', $this->data);
	}

	function gf_chart()
	{
		print $this->m_core_chart->gf_chart_orders();
	}
}
