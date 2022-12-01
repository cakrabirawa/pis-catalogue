<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_file_manager extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_file_manager'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_file_manager';
		$this->data['o_page_title'] = 'File Manager';
		$this->data['o_page_desc'] = 'Maintenance File Manager';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_file_manager"));
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->data['o_root_dir'] = $this->m_core_file_manager->gf_load_root_dir(array("path" => null));
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_load_file_folder()
	{
		$path = $this->input->post("path", TRUE);
		$mode = $this->input->post("mode", TRUE);
		print $this->m_core_file_manager->gf_load_root_dir(array("path" => $path, "mode" => $mode));
	}
	function gf_create_folder_file()
	{
		print $this->m_core_file_manager->gf_create_folder_file();
	}
	function gf_save_file()
	{
		print $this->m_core_file_manager->gf_save_file();
	}
	function gf_read_file()
	{
		$path = $this->input->post("path", TRUE);
		print $this->m_core_file_manager->gf_read_file(array("path" => $path));
	}
	function gf_rename_folder_file()
	{
		print $this->m_core_file_manager->gf_rename_folder_file();
	}
	function gf_delete_folder_file()
	{
		print $this->m_core_file_manager->gf_delete_folder_file();
	}
	function gf_transact()
	{
		print $this->m_core_file_manager->gf_transact();
	}
}
