<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_user_menu extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_user_menu'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_user_menu';
		$this->data['o_page_title'] = 'User Menu';
		$this->data['o_page_desc'] = 'Maintenance User Menu';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_user_menu"));
	}
	public function gf_load_icon_page()
	{
		$this->load->view('v_core_fa_icon');
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->data['o_parent_menu'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => true, "sSQL" => "select nMenuId, sMenuName from tm_user_menu where sStatusDelete is null", "sFieldId" => "nMenuId", "sFieldValues" => "sMenuName"));
		$oData = json_decode($this->m_core_user_menu->gf_get_menu_order(array("nMenuParentId" => 0)), TRUE);
		$this->data['o_max_menu_order'] = $oData['nMaxMenuOrder'];
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_transact()
	{
		print $this->m_core_user_menu->gf_transact();
	}
	function gf_load_data()
	{
		$c = new libPaging();
		$sParam = array(
			"sSQL"  				       => "select a.nMenuId as `Menu Id`, a.sMenuName as `Menu Name`, a.nMenuOrder as `Menu Order`, ifnull((select p.sMenuName from tm_user_menu p where p.sStatusDelete is null and p.nMenuId = a.nMenuParentId_fk), 'Root') as `Menu Parent Name`, a.nMenuParentId_fk as `Menu parent Id`, " . $this->m_core_apps->gf_generate_log_col() . " from tm_user_menu a  where sStatusDelete is null order by a.dCreateOn desc",
			"sTitleHeader" 				 => "Search Payment",
			"sCallBackURLPaging"	 => site_url() . "c_core_user_menu/gf_load_data",
			"sCallBackURLPageEditDelete" => site_url() . "c_core_user_menu/gf_exec",
			"sLookupEditDelete"    => true,
			"bDebugSQL"            => false,
			"sFieldIgnore"         => array("Menu Parent Id"),
			"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
			"sInitHeaderFields"    => array("Menu Name"),
			"sDefaultFieldSearch"  => "Menu Name",
			"sTheme"               => "default"
		);
		$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
	function gf_exec()
	{
		$this->data['o_data'] = $this->m_core_user_menu->gf_load_data();
		$oParam = $_POST;
		$this->data['o_side_bar'] = $this->m_core_user_menu->gf_recursive_side_bar(array("nMenuId" => 0, "nMenuIdInit" => 0));
		$this->data['o_parent_menu'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => true, "sSQL" => "select nMenuId, sMenuName from tm_user_menu where sStatusDelete is null", "sFieldId" => "nMenuId", "sFieldValues" => "sMenuName", "sFieldInitValue" => intVal($this->data['o_data'][0]['nMenuParentId_fk'])));
		$this->data['o_menu'] = $this->m_core_user_menu->gf_recursive_menu(array("nMenuId" => 0, "nMenuIdInit" => 0, "nMenuIdInit" => $oParam['Menu_parent_Id']));
		$this->data['o_mode'] = "";
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_get_menu_order()
	{
		$nMenuParentId = $this->input->post('nMenuParentId', TRUE);
		print $this->m_core_user_menu->gf_get_menu_order(array("nMenuParentId" => (trim($nMenuParentId) === "" ? "0" : trim($nMenuParentId))));
	}
	function gf_change_database($nUnitId = null)
	{
		$sReturn = json_decode($this->m_core_user_menu->gf_change_database($nUnitId), TRUE);
		if (intval($sReturn) === 1)
			$data['o_info'] = "You have successfully to change database accsess.";
		else
			$data['o_info'] = "You don't have permission to access this Database.";
		redirect('/', TRUE);
	}
	function gf_change_group($nGroupUserId = null)
	{
		$sReturn = json_decode($this->m_core_user_menu->gf_change_group($nGroupUserId), TRUE);
		if (intval($sReturn) === 1)
			$data['o_info'] = "You have successfully to change database accsess.";
		else
			$data['o_info'] = "You don't have permission to access this Database.";
		redirect('/', TRUE);
	}
	function gf_reload_side_bar_menu()
	{
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_user_menu"));
		print $this->data['o_extra']['o_side_bar'];
	}
}
