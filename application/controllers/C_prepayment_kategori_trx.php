<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class c_prepayment_kategori_trx extends CI_Controller { 
	public function __construct() 
	{ 
		parent::__construct(); 
		//--Session Validity 
		$a = new libSession(); 
		if($a->gf_check_session()) 
			redirect("c_core_login"); 
		else 
		{ 
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_prepayment_kategori_trx')); 
			$this->load->library(array('libPaging')); 
		}	
		//--End Session Validity 
	} 
	public function index() 
	{ 
		$data['o_page'] = 'backend/v_prepayment_kategori_trx'; 
		$data['o_page_title'] = 'Kategori TRX'; 
		$data['o_page_desc'] = 'Maintenance Kategori TRX'; 
		$data['o_data'] = null; 
		$data['o_mode'] = "I"; 
		$data['o_side_bar'] = $this->m_core_user_menu->gf_recursive_side_bar(array("nMenuId" => 0, "nMenuIdInit" => 0));
		$data['o_info'] = $this->m_core_user_login->gf_user_info();
		$data['o_config'] = $this->m_core_apps->gf_read_config_apps();
		//--Authorized-- 
		$oAuth = json_decode($this->m_core_user_login->gf_load_auth(array("sMenuCtlName" => "c_prepayment_kategori_trx")), TRUE); 
		$data['o_save']   = trim($oAuth['sSave']); 
		$data['o_update'] = trim($oAuth['sUpdate']); 
		$data['o_delete'] = trim($oAuth['sDelete']); 
		$data['o_cancel'] = trim($oAuth['sCancel']); 
		//--End Authorized 
		$this->load->view('backend/v_core_main', $data); 
	} 
	public function gf_exec() 
	{ 
		$data['o_page'] = 'backend/v_prepayment_kategori_trx'; 
		$data['o_page_title'] = 'Kategori TRX'; 
		$data['o_page_desc'] = 'Maintenance Kategori TRX'; 
		$data['o_data'] = null; 
		$data['o_mode'] = ""; 
		$data['o_data'] = $this->m_prepayment_kategori_trx->gf_load_data(); 
		$data['o_side_bar'] = $this->m_core_user_menu->gf_recursive_side_bar(array("nMenuId" => 0, "nMenuIdInit" => 0));
		$data['o_info'] = $this->m_core_user_login->gf_user_info();
		$data['o_config'] = $this->m_core_apps->gf_read_config_apps();
		//--Authorized-- 
		$oAuth = json_decode($this->m_core_user_login->gf_load_auth(array("sMenuCtlName" => "c_prepayment_kategori_trx")), TRUE); 
		$data['o_save']   = trim($oAuth['sSave']); 
		$data['o_update'] = trim($oAuth['sUpdate']); 
		$data['o_delete'] = trim($oAuth['sDelete']); 
		$data['o_cancel'] = trim($oAuth['sCancel']); 
		//--End Authorized 
		$this->load->view('backend/v_core_main', $data); 
	} 
	function gf_transact() 
	{ 
		print $this->m_prepayment_kategori_trx->gf_transact(); 
	} 
	function gf_load_data() 
	{ 
		$c = new libPaging(); 
		$sParam = array( "sSQL" => "select a.nIdKategoriTRX as `Id Kategori TRX`, a.sNamaKategoriTRX as `Nama Kategori TRX`, ".$this->m_core_apps->gf_generate_log_col(array("sPrefix" => "a"))."  from tm_prepayment_kategori_trx a where a.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." order by a.dCreateOn desc",
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_kategori_trx/gf_load_data",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_kategori_trx/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("Nama Kategori TRX"),
										 "sDefaultFieldSearch"  => "Nama Kategori TRX",
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
}