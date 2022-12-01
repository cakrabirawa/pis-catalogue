<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_user_auth_menu extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_user_auth_menu'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] 			= 'backend/v_core_user_auth_menu';
		$this->data['o_page_title'] = 'User Auth';
		$this->data['o_page_desc'] 	= 'Maintenance User Auth';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_user_auth_menu"));
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->data['o_user_group'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => true, "sSQL" => "select nGroupUserId, sGroupUserName from tm_user_groups where sStatusDelete is null", "sFieldId" => "nGroupUserId", "sFieldValues" => "sGroupUserName"));
		$this->data['o_user_unit'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => true, "sSQL" => "select nUnitId, sUnitName from tm_user_groups_units where sStatusDelete is null", "sFieldId" => "nUnitId", "sFieldValues" => "sUnitName"));
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_transact()
	{
		print $this->m_core_user_auth_menu->gf_transact();
	}
	function gf_load_auth_menu()
	{
		$oData = $_POST;
		$c = new libPaging();
		if (intval($oData['nGroupUserId']) !== 0) {
			$sParam = array(
				"sSQL"  				       => "select a.nMenuId as `Menu Id`, a.sMenuName as `Menu Name`, ifnull((select p.sMenuName from tm_user_menu p where p.sStatusDelete is null and p.nMenuId = a.nMenuParentId_fk), 'Root') as `Menu Parent Name`, concat('<input type=''checkbox''', 'id=''chkVisible''', ' name=''chkVisible''', ' ', ifnull((select case when p.sVisible = '1' then 'checked' else '' end from tm_user_menu_auth p where p.sFlag = 'MENU_APPS' and p.nUnitId_fk = " . trim($oData['nUnitId']) . " and p.nMenuId_fk = a.nMenuId and p.nGroupUserId_fk = " . trim($oData['nGroupUserId']) . " and p.sStatusDelete is null), ''), ' />') as `Visible`, concat('<input type=''checkbox''', 'id=''chkSave''', ' name=''chkSave''', ' ', ifnull((select case when p.sSave = '1' then 'checked' else '' end from tm_user_menu_auth p where p.sFlag = 'MENU_APPS' and p.nUnitId_fk = " . trim($oData['nUnitId']) . " and p.nMenuId_fk = a.nMenuId and p.nGroupUserId_fk = " . trim($oData['nGroupUserId']) . " and p.sStatusDelete is null), ''), ' />') as `Save`, concat('<input type=''checkbox''', 'id=''chkUpdate''', ' name=''chkUpdate''', ' ', ifnull((select case when p.sUpdate = '1' then 'checked' else '' end from tm_user_menu_auth p where p.sFlag = 'MENU_APPS' and p.nUnitId_fk = " . trim($oData['nUnitId']) . " and p.nMenuId_fk = a.nMenuId and p.nGroupUserId_fk = " . trim($oData['nGroupUserId']) . " and p.sStatusDelete is null), ''), ' />') as `Update`, concat('<input type=''checkbox''', 'id=''chkDelete''', ' name=''chkDelete''', ' ', ifnull((select case when p.sDelete = '1' then 'checked' else '' end from tm_user_menu_auth p where p.sFlag = 'MENU_APPS' and p.nUnitId_fk = " . trim($oData['nUnitId']) . " and p.nMenuId_fk = a.nMenuId and p.nGroupUserId_fk = " . trim($oData['nGroupUserId']) . " and p.sStatusDelete is null), ''), ' />') as `Delete`, a.sCreateBy as `Create By`, a.dCreateOn as `Create On` from tm_user_menu a  where a.sStatusDelete is null and a.sMenuName <> '-' order by a.dCreateOn desc",
				"sTitleHeader" 				 => "Search Authorized Menu",
				"sCycleParam"          => array("nGroupUserId" => trim($oData['nGroupUserId']), "nUnitId" => trim($oData['nUnitId'])),
				"sCallBackURLPaging"	 => site_url() . "c_core_user_auth_menu/gf_load_auth_menu",
				"bDebugSQL"            => false,
				"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
				"sInitHeaderFields"    => array("Menu Id"),
				"sDefaultFieldSearch"  => "Menu Name",
				"sJSParam"             => array("gf_bind_click()"),
				"sTheme"               => "default"
			);
		} else {
			$sParam = array(
				"sSQL"  				       => "select a.nMenuId as `Menu Id`, a.sMenuName as `Menu Name`, ifnull((select p.sMenuName from tm_user_menu p where p.sStatusDelete is null and p.nMenuId = a.nMenuParentId_fk), 'Root') as `Menu Parent Name`, concat('<input type=''checkbox''', 'id=''chkVisible''', ' name=''chkVisible''', ' ', ifnull((select case when p.sVisible = '1' then 'checked' else '' end from tm_user_menu_auth p where p.sFlag = 'MENU_APPS' and p.nMenuId_fk = a.nMenuId and p.nGroupUserId_fk = " . trim($oData['nGroupUserId']) . " and p.sStatusDelete is null), ''), ' />') as `Visible`, concat('<input type=''checkbox''', 'id=''chkSave''', ' name=''chkSave''', ' ', ifnull((select case when p.sSave = '1' then 'checked' else '' end from tm_user_menu_auth p where p.sFlag = 'MENU_APPS' and p.nMenuId_fk = a.nMenuId and p.nGroupUserId_fk = " . trim($oData['nGroupUserId']) . " and p.sStatusDelete is null), ''), ' />') as `Save`, concat('<input type=''checkbox''', 'id=''chkUpdate''', ' name=''chkUpdate''', ' ', ifnull((select case when p.sUpdate = '1' then 'checked' else '' end from tm_user_menu_auth p where p.sFlag = 'MENU_APPS' and p.nMenuId_fk = a.nMenuId and p.nGroupUserId_fk = " . trim($oData['nGroupUserId']) . " and p.sStatusDelete is null), ''), ' />') as `Update`, concat('<input type=''checkbox''', 'id=''chkDelete''', ' name=''chkDelete''', ' ', ifnull((select case when p.sDelete = '1' then 'checked' else '' end from tm_user_menu_auth p where p.sFlag = 'MENU_APPS' and p.nMenuId_fk = a.nMenuId and p.nGroupUserId_fk = " . trim($oData['nGroupUserId']) . " and p.sStatusDelete is null), ''), ' />') as `Delete`, a.sCreateBy as `Create By`, a.dCreateOn as `Create On` from tm_user_menu a  where a.sStatusDelete is null and a.sMenuName <> '-' order by a.dCreateOn desc",
				"sTitleHeader" 				 => "Search Authorized Menu",
				"sCycleParam"          => array("nGroupUserId" => trim($oData['nGroupUserId'])),
				"sCallBackURLPaging"	 => site_url() . "c_core_user_auth_menu/gf_load_auth_menu",
				"bDebugSQL"            => false,
				/*"sFieldIgnore"         => array("sCreateBy"),*/
				"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
				"sInitHeaderFields"    => array("Menu Id"),
				"sDefaultFieldSearch"  => "Menu Name",
				"sJSParam"             => array("gf_bind_click()"),
				"sTheme"               => "default"
			);
		}
		$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
}
