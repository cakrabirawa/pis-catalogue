<?php
/*
------------------------------
Menu Name: Reports
File Name: C_core_apps_report.php
File Path: D:\Project\PHP\billing\application\controllers\C_core_apps_report.php
Create Date Time: 2019-06-27 21:19:31
------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_apps_report extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_apps_report'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_apps_report';
		$this->data['o_page_title'] = 'Reports';
		$this->data['o_page_desc'] = 'Maintenance Reports';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_apps_report"));
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->data['o_or'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => true, "sSQL" => "select nIdOpenReport, sOpenReportsName from tm_user_open_reports where sStatusDelete is null", "sFieldId" => "nIdOpenReport", "sFieldValues" => "sOpenReportsName"));
		$this->m_core_apps_report->gf_clean_mrt_unused_report();
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	public function gf_exec()
	{
		$this->data['o_mode'] = "";
		$this->data['o_data'] = $this->m_core_apps_report->gf_load_data();
		$this->data['o_or'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => true, "sSQL" => "select nIdOpenReport, sOpenReportsName from tm_user_open_reports where sStatusDelete is null", "sFieldId" => "nIdOpenReport", "sFieldValues" => "sOpenReportsName", "sFieldInitValue" => $this->data['o_data'][0]['nIdOpenReportParent_fk']));
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_transact()
	{
		print $this->m_core_apps_report->gf_transact();
	}
	function gf_load_data()
	{
		$c = new libPaging();
		$sParam = array(
			"sSQL" => "select a.nIdOpenReport as `Id Open Reports`, (select p.sOpenReportsName from tm_user_open_reports p where p.sStatusDelete is null and p.nIdOpenReport = a.nIdOpenReportParent_fk ) as `Open Reports Parent Name`, a.sOpenReportsName as `Open Reports Name`, case when a.nOpenReportsType = 1 then 'DYNAMIC' else case when a.nOpenReportsType = 2 then 'STATIC BY PARAMS' else case when a.nOpenReportsType = 3 then 'STATIC BY VALUES' end end end as `Report Type`, case when a.nShowToUser = 1 then 'YES' else case when a.nShowToUser = 2 then 'NO' end end as `Show to User`, a.sOpenReportsDesc as `Report Desc`, case when a.nOpenReportOutput = 1 then 'GRID' else case when a.nOpenReportOutput then 'STIMULSOFT' end end as `Output To` from tm_user_open_reports a where a.sStatusDelete is null order by a.dCreateOn desc",
			"sTitleHeader" => "Title Sample",
			"sCallBackURLPaging"	 => site_url() . "c_core_apps_report/gf_load_data",
			"sCallBackURLPageEditDelete" => site_url() . "c_core_apps_report/gf_exec",
			"sLookupEditDelete" => true,
			"bDebugSQL" => false,
			"sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
			"sInitHeaderFields" => array("Open Reports Name"),
			"sDefaultFieldSearch"  => "Open Reports Name",
			"sJSParam" => array("gf_bind_event()"),
			"sTheme" => "default"
		);
		$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
	function gf_parse_sql()
	{
		print $this->m_core_apps_report->gf_parse_sql();
	}
	function gf_copy_data()
	{
		print $this->m_core_apps_report->gf_copy_data();
	}
	function gf_download_report()
	{
		$this->m_core_apps_report->gf_download_report();
	}
}
