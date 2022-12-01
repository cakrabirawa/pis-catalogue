<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class c_core_404 extends CI_Controller {	
	public function __construct()
  {
    parent::__construct();    
		$a = new libSession(); 
		if($a->gf_check_session()) 
			redirect("c_core_login");
		else 
		{   
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_database')); 
			$this->load->library(array('libPaging')); 
		}	
  }  
  public function index()
  {
  	$data['o_page'] = 'backend/v_core_404';
		$data['o_page_title'] = '';
		$data['o_page_desc'] = '';		
		$data['o_info'] = $this->m_core_user_login->gf_user_info();		
		$data['o_config'] = $this->m_core_apps->gf_read_config_apps();
		$data['o_side_bar'] = $this->m_core_user_menu->gf_recursive_side_bar(array("nMenuId" => 0, "nMenuIdInit" => 0));
		$this->load->view('v_core_main', $data);
  }
}
