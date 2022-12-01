<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_email_engine extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_email_engine'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_email_engine';
		$this->data['o_page_title'] = 'Email Engine';
		$this->data['o_page_desc'] = 'Maintenance Email Engine';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_email_engine"));
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->data['o_root_dir'] = $this->m_core_email_engine->gf_list_reports(array("path" => getcwd() . DIRECTORY_SEPARATOR . "emails" . DIRECTORY_SEPARATOR));
		$this->data['o_font'] = $this->m_core_email_engine->gf_load_font_dir();
		$this->data['o_report_list'] = $this->m_core_email_engine->gf_load_report_menu();
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_transact()
	{
		print $this->m_core_email_engine->gf_transact();
	}
	function gf_test_query()
	{
		print $this->m_core_email_engine->gf_load_field();
	}
	function gf_preview_reports()
	{
		print $this->m_core_email_engine->gf_preview_reports();
	}
	function gf_rename_folder_file()
	{
		print $this->m_core_email_engine->gf_rename_folder_file();
	}
	function gf_copy_folder_file()
	{
		print $this->m_core_email_engine->gf_copy_folder_file();
	}
	function gf_delete_folder_file()
	{
		print $this->m_core_email_engine->gf_delete_folder_file();
	}
	function gf_load_file_folder()
	{
		print $this->m_core_email_engine->gf_list_reports(array("path" => getcwd() . DIRECTORY_SEPARATOR . "emails" . DIRECTORY_SEPARATOR));
	}
	function gf_read_file()
	{
		$path = $this->input->post("path", TRUE);
		print $this->m_core_email_engine->gf_read_file(array("path" => $path));
	}
	function gf_exec_report()
	{
		$this->m_core_email_engine->gf_exec_report();
	}
}
