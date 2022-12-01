<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_units extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_units'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_units';
		$this->data['o_page_title'] = 'Units';
		$this->data['o_page_desc'] = 'Maintenance Units';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_units"));
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_transact()
	{
		print $this->m_core_units->gf_transact();
	}
	function gf_load_data()
	{
		$c = new libPaging();
		$sParam = array(
			"sSQL" => "select nUnitId as `Unit Id`, sUnitName as `Unit Name`, " . $this->m_core_apps->gf_generate_log_col() . " from tm_user_groups_units where sStatusDelete is null order by dCreateOn desc",
			"sTitleHeader" => "Title Sample",
			"sCallBackURLPaging"	 => site_url() . "c_core_units/gf_load_data",
			"sCallBackURLPageEditDelete" => site_url() . "c_core_units/gf_exec",
			"sLookupEditDelete" => true,
			"bDebugSQL" => false,
			"sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
			"sInitHeaderFields" => array("Unit Name"),
			"sDefaultFieldSearch"  => "Unit Name",
			"sTheme" => "default"
		);
		$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
	function gf_exec()
	{
		$this->data['o_mode'] = "";
		$this->data['o_data'] = $this->m_core_units->gf_load_data();
		$this->load->view($this->data['o_page'] , $this->data); 
	}
}
