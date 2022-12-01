<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class c_core_main_front_end extends CI_Controller {	
	public function __construct()
  {
    parent::__construct();    
		$a = new libSession(); 
		if($a->gf_check_session()) 
			redirect("c_core_login");
		else 
			$this->load->model(array('m_core_login', 'm_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_logbook_penebusan_bs'));    
  }  
	public function index()
	{
		$data['o_page'] = 'backend/v_core_welcome';
		$data['o_page_title'] = 'Welcome to Your Dashboard, '.$this->session->userdata('sRealName').' !';
		$data['o_page_desc'] = '';	
		$data['o_info'] = $this->m_core_user_login->gf_user_info();		
		$data['o_config'] = $this->m_core_apps->gf_read_config_apps();
		$data['o_dashboard'] = json_decode($this->m_logbook_penebusan_bs->gf_load_dashboard(), TRUE);
		//------------------------------------------------------------------
		$data['o_side_bar'] = $this->m_core_user_menu->gf_recursive_side_bar(array("nMenuId" => 0, "nMenuIdInit" => 0));
		$this->m_core_apps->gf_insert_log(array("sType" => "MENU", "sMessage" => "User Has Access Menu: c_core_main_front_end"));
		$this->load->view('backend/v_core_main', $data);
	}
}