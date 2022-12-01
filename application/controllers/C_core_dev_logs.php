<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_dev_logs extends CI_Controller
{
	var $data = null;
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_dev_logs'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_dev_logs';
		$this->data['o_page_title'] = 'Developer Logs';
		$this->data['o_page_desc'] = 'Maintenance Developer Logs';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_dev_logs"));
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->data['o_devlogsubject'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => false, "sSQL" => "select sDevLogId, sDevLogName, concat('<br />', sDevLogDesc) as sDevLogDesc from tm_user_dev_log where sStatusDelete is null", "sFieldId" => "sDevLogId", "sFieldValues" => "sDevLogName", "sDataSubText" => "sDevLogDesc"));
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	public function gf_exec()
	{
		$this->data['o_mode'] = "";
		$this->data['o_data'] = $this->m_core_dev_logs->gf_load_data();
		$this->data['o_devlogsubject'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => false, "sSQL" => "select sDevLogId, sDevLogName, concat('<br />', sDevLogDesc) as sDevLogDesc from tm_user_dev_log where sStatusDelete is null", "sFieldInitValue" => trim($this->data['o_data'][0]['sDevLogIdParent_fk']), "sFieldId" => "sDevLogId", "sFieldValues" => "sDevLogName", "sDataSubText" => "sDevLogDesc"));
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_load_data()
	{
		$c = new libPaging();
		$sParam = array(
			"sSQL"  				       => "select a.sDevLogId as `Dev Logs Id`, a.dDevLogDate as `Date`, a.sDevLogDesc as `Desc`, (select p.sDevLogDesc from tm_user_dev_log p where p.sStatusDelete is null and p.sDevLogId = a.sDevLogIdParent_fk) as `Parent`, a.nPercentage as `Percentage`  from tm_user_dev_log a where a.sStatusDelete is null order by a.dCreateOn desc",
			"sTitleHeader" 				 => "Search Dev Logs",
			"sCallBackURLPaging"	 => site_url() . "c_core_dev_logs/gf_load_data",
			"sCallBackURLPageEditDelete" => site_url() . "c_core_dev_logs/gf_exec",
			"sLookupEditDelete"    => true,
			"bDebugSQL"            => false,
			"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
			"sInitHeaderFields"    => array("Desc"),
			"sDefaultFieldSearch"  => "Desc",
			"sJSParam"             => array("gf_bind_event()"),
			"sTheme"               => "default"
		);
		$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
	function gf_transact()
	{
		print $this->m_core_dev_logs->gf_transact();
	}
}
