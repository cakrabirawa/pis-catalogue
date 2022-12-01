<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_edit_profile extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_edit_profile'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_edit_profile';
		$this->data['o_page_title'] = 'Edit Profile';
		$this->data['o_page_desc']  = 'Maintenance Edit Profile';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_edit_profile"));
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_transact()
	{
		print $this->m_core_edit_profile->gf_transact();
	}
}
