<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_user_login extends CI_Controller
{			
	var $nUnitId = null;
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_user_login'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_user_login';
		$this->data['o_page_title'] = 'User Login';
		$this->data['o_page_desc'] = 'Maintenance User Login';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_user_login"));
		$this->nUnitId = $this->session->userdata('nUnitId_fk');
	}
	function index()
	{
		$this->data['o_mode'] = "I";
		$this->data['o_divisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaDivisi, nIdDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi", ));	
		$this->data['o_user_group'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => true, "sSQL" => "select nGroupUserId, sGroupUserName from tm_user_groups where sStatusDelete is null and nGroupUserId <> 0", "sFieldId" => "nGroupUserId", "sFieldValues" => "sGroupUserName"));
		$this->data['o_unit'] = $this->m_core_user_login->gf_load_unit();
		$this->data['o_group'] = $this->m_core_user_login->gf_load_group();
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_load_data()
	{
		$c = new libPaging();
		$sParam = array(
			"sSQL"  				       => "select a.nUserId as `User Id`, a.sUserName as `User Name`, a.sRealName as `Real Name`, a.sEmail as `Email`, group_concat(c.sGroupUserName) as `Group User Name` from tm_user_logins a left join tm_user_logins_groups b on b.nUserId_fk = a.nUserId left join tm_user_groups c on c.nGroupUserId = b.nGroupUserId_fk where a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null group by a.nUserId, a.sUserName, a.sRealName, a.sEmail  order by a.dCreateOn desc",
			"sTitleHeader" 				 => "Search User Login",
			"sCallBackURLPaging"	 => site_url() . "c_core_user_login/gf_load_data",
			"sCallBackURLPageEditDelete" => site_url() . "c_core_user_login/gf_exec",
			"sLookupEditDelete"    => true,
			"bDebugSQL"            => false,
			"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
			"sInitHeaderFields"    => array("User Name"),
			"sDefaultFieldSearch"  => "User Name",
			"sTheme"               => "default"
		);
		$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
	function gf_exec()
	{
		$this->data['o_data'] = $this->m_core_user_login->gf_load_data();
		$this->data['o_mode'] = "";
		$this->data['o_unit'] = $this->m_core_user_login->gf_load_unit(array("bFill" => true, "nUserId" => $this->data['o_data'][0]['nUserId']));
		$this->data['o_group'] = $this->m_core_user_login->gf_load_group(array("bFill" => true, "nUserId" => $this->data['o_data'][0]['nUserId']));
		$this->data['o_divisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaDivisi, nIdDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi", ));	
		$this->data['o_user_group'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => true, "sSQL" => "select nGroupUserId, sGroupUserName from tm_user_groups where sStatusDelete is null and nGroupUserId <> 0", "sFieldId" => "nGroupUserId", "sFieldValues" => "sGroupUserName"));
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_transact()
	{
		print $this->m_core_user_login->gf_transact();
	}
	function gf_load_image($sFileName = null)
	{
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$DS        = DIRECTORY_SEPARATOR;
		$file  = getcwd() . $DS . $oConfig['UPLOAD_DIR'] . $DS . "avatar" . $DS . trim($sFileName);
		$file_extension = strtolower(substr(strrchr(basename($file), "."), 1));
		switch ($file_extension) {
			case "gif":
				$ctype = "image/gif";
				break;
			case "png":
				$ctype = "image/png";
				break;
			case "jpeg":
				$ctype = "image/jpg";
				break;
			case "jpg":
				$ctype = "image/jpeg";
				break;
			default:
		}
		header('Content-Type:' . $ctype);
		header('Content-Length: ' . filesize($file));
		print file_get_contents($file);
	}
	function gf_search_user_login()
	{
		print $this->m_core_user_login->gf_search_user_login();
	}
	function gf_load_store()
	{
		$oData = $_POST;
		$c = new libPaging();

		if(trim($oData['nUserId']) === "(AUTO)")
			$sql = "select a.nUnitId as `Group Unit Id`, a.sUnitName as `Group Unit Name`, concat('<input type=''checkbox''', 'id=''chkVisible''', ' name=''chkVisible''', ' ') as `Allow` from tm_user_groups_units a  where a.sStatusDelete is null order by a.dCreateOn desc";
		else
			$sql = "select a.nUnitId as `Group Unit Id`, a.sUnitName as `Group Unit Name`, concat('<input type=''checkbox''', 'id=''chkVisible''', ' name=''chkVisible''', ' ', case when (select count(1) from tm_user_units p where p.nUnitId_fk = a.nUnitId and p.nUserId_fk = ".trim($oData['nUserId']).") > 0 then 'checked' else '' end) as `Pick` from tm_user_groups_units a  where a.sStatusDelete is null order by a.dCreateOn desc";
		$sParam = array(
			"sSQL"  				       => $sql,
			"sTitleHeader" 				 => "Search User Group Unit",
			"sCycleParam"          => array("nUserId" => trim($oData['nUserId'])),
			"sCallBackURLPaging"	 => site_url() . "c_core_user_login/gf_load_store",
			"bDebugSQL"            => false,
			"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
			"sInitHeaderFields"    => array("Group Unit Id"),
			"sDefaultFieldSearch"  => "Group Unit Name",
			"sJSParam"             => array("gf_bind_click()"),
			"sTheme"               => "default"
		);
		$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
	function gf_load_user_by_group_user()
	{
		print $this->m_core_user_login->gf_load_user_by_group_user();
	}
}
