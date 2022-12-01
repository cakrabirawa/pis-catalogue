<?php
/*
------------------------------
Menu Name: Brand
File Name: C_inv_brand.php
File Path: C:\xampp\xampp\htdocs\inventaris\application\controllers\C_inv_brand.php
Create Date Time: 2021-09-03 19:25:42
------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_dashboard extends CI_Controller
{
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_prepayment_karyawan', 'm_prepayment_pengajuan_pre_payment', 'm_core_user_login', 'm_core_user_login', 'm_core_apps', 'm_core_main', 'm_core_chart'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] 						= 'backend/v_core_welcome';
		$this->data['o_page_title'] 			= 'Welcome to Your Dashboard, ' . $this->session->userdata('sRealName') . ' !';
		$this->data['o_extra']      			= $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_dashboard"));
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->data['o_config'] = $this->m_core_apps->gf_read_config_apps();
		$this->data['o_punya_anak_buah'] = $this->m_prepayment_karyawan->gf_login_punya_anak_buah();
		$this->data['o_dashboard'] = json_decode($this->m_prepayment_pengajuan_pre_payment->gf_load_dashboard(), TRUE);
		$this->data['o_os'] = $this->m_core_apps->get_os();
		$this->load->view($this->data['o_page'] , $this->data); 
	}
}
