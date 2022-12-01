<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_open_reports_auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_open_reports_auth'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_open_reports_auth';
		$this->data['o_page_title'] = 'Open Reports Auth';
		$this->data['o_page_desc'] = 'Maintenance Open Reports Auth';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_open_reports_auth"));
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
		print $this->m_core_open_reports_auth->gf_transact();
	}
	function gf_load_auth_menu()
	{
		$oData = $_POST;
		$c = new libPaging();
		if (intval($oData['nGroupUserId']) !== 0) {
			$sParam = array(
				"sSQL"  				       => "select a.nIdOpenReport as `Open Report Id`, a.sOpenReportsName as `Open Report Name`, ifnull((select p.sOpenReportsName from tm_user_open_reports p where p.sStatusDelete is null and p.nIdOpenReport = a.nIdOpenReportParent_fk), 'Root') as `Open Report Parent Name`, concat('<input type=''checkbox''', 'id=''chkVisible''', ' name=''chkVisible''', ' ', ifnull((select case when p.sVisible = '1' then 'checked' else '' end from tm_user_menu_auth p where p.sFlag = 'MENU_OPEN_REPORTS' and p.nUnitId_fk = " . trim($oData['nUnitId']) . " and p.nMenuId_fk = a.nIdOpenReport and p.nGroupUserId_fk = " . trim($oData['nGroupUserId']) . " and p.sStatusDelete is null), ''), ' />') as `Visible`, a.sCreateBy as `Create By`, a.dCreateOn as `Create On` from tm_user_open_reports a  where a.sStatusDelete is null and a.sOpenReportsName <> '-' order by a.dCreateOn desc",
				"sTitleHeader" 				 => "Search Authorized Open Reports",
				"sCycleParam"          => array("nGroupUserId" => trim($oData['nGroupUserId']), "nUnitId" => trim($oData['nUnitId'])),
				"sCallBackURLPaging"	 => site_url() . "c_core_open_reports_auth/gf_load_auth_menu",
				"bDebugSQL"            => false,
				"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
				"sInitHeaderFields"    => array("Open Report Id"),
				"sDefaultFieldSearch"  => "Open Report Name",
				"sJSParam"             => array("gf_bind_click()"),
				"sTheme"               => "default"
			);
		} else {
			$sParam = array(
				"sSQL"  				       => "select a.nIdOpenReport as `Open Report Id`, a.sOpenReportsName as `Open Report Name`, ifnull((select p.sOpenReportsName from tm_user_open_reports p where p.sStatusDelete is null and p.nIdOpenReport = a.nIdOpenReportParent_fk), 'Root') as `Open Report Parent Name`, concat('<input type=''checkbox''', 'id=''chkVisible''', ' name=''chkVisible''', ' ', ifnull((select case when p.sVisible = '1' then 'checked' else '' end from tm_user_menu_auth p where p.sFlag = 'MENU_OPEN_REPORTS' and p.nMenuId_fk = a.nIdOpenReport and p.nGroupUserId_fk = " . trim($oData['nGroupUserId']) . " and p.sStatusDelete is null), ''), ' />') as `Visible`, a.sCreateBy as `Create By`, a.dCreateOn as `Create On` from tm_user_open_reports a  where a.sStatusDelete is null and a.sOpenReportsName <> '-'",
				"sTitleHeader" 				 => "Search Authorized Menu",
				"sCycleParam"          => array("nGroupUserId" => trim($oData['nGroupUserId'])),
				"sCallBackURLPaging"	 => site_url() . "c_core_open_reports_auth/gf_load_auth_menu",
				"bDebugSQL"            => false,
				/*"sFieldIgnore"         => array("sCreateBy"),*/
				"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
				"sInitHeaderFields"    => array("Open Report Id"),
				"sDefaultFieldSearch"  => "Open Report Name",
				"sJSParam"             => array("gf_bind_click()"),
				"sTheme"               => "default"
			);
		}
		$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
}
