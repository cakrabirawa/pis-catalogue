<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_database extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_database'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_database';
		$this->data['o_page_title'] = 'Database';
		$this->data['o_page_desc'] = 'Maintenance Database';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_database"));
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->data['o_list_database'] = $this->gf_load_database_list();
		$this->data['o_server_info'] = $this->m_core_database->gf_server_info();
		$this->data['o_db_engine'] = $this->m_core_database->gf_load_info_core_engine();
		$this->data['o_db_charset'] = $this->m_core_database->gf_load_info_core_charset();
		$this->data['o_db_collate'] = $this->m_core_database->gf_load_info_core_collate();
		$this->data['o_db_data_type'] = $this->m_core_database->gf_load_info_core_data_type();
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_load_database_list()
	{
		return $this->m_core_database->gf_load_database();
	}
	function gf_load_database_lists()
	{
		print $this->m_core_database->gf_load_database();
	}
	function gf_transact()
	{
		print $this->m_core_database->gf_transact();
	}
	function gf_load_database()
	{
		print $this->m_core_database->gf_load_database();
	}
	function gf_load_attribute()
	{
		print $this->m_core_database->gf_load_attribute();
	}
	function gf_load_attribute_content()
	{
		print $this->m_core_database->gf_load_attribute_content();
	}
	function gf_load_table_content()
	{
		print $this->m_core_database->gf_load_table_content();
	}
	function gf_create_database()
	{
		print $this->m_core_database->gf_create_database();
	}
	function gf_create_table()
	{
		print $this->m_core_database->gf_create_table();
	}
	function gf_drop_database()
	{
		print $this->m_core_database->gf_drop_database();
	}
	function gf_read_stored_procedure()
	{
		print $this->m_core_database->gf_read_stored_procedure();
	}
	function gf_alter_remove_stored_procedure()
	{
		print $this->m_core_database->gf_alter_remove_stored_procedure();
	}
	function gf_execute_query()
	{
		print $this->m_core_database->gf_execute_query();
	}
}
