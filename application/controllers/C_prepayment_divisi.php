<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class c_prepayment_divisi extends CI_Controller { 
	var $data = null;
	public function __construct() 
	{ 
		parent::__construct(); 
		$a = new libSession(); 
		if($a->gf_check_session()) 
			redirect("c_core_login"); 
		else 
		{ 
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_prepayment_divisi')); 
			$this->load->library(array('libPaging')); 
		}	
		$this->data['o_page'] 			= 'backend/v_prepayment_divisi'; 
		$this->data['o_page_title'] = 'Divisi'; 
		$this->data['o_page_desc'] 	= 'Maintenance Divisi'; 
		$this->data['o_data'] 			= null;
		$this->data['o_extra']  		= $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_prepayment_divisi"));
	} 
	public function index() 
	{ 
		$this->data['o_mode'] = "I";
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	public function gf_exec() 
	{ 
		$this->data['o_mode'] = "";
		$this->data['o_data'] = $this->m_prepayment_divisi->gf_load_data(); 
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	function gf_transact() 
	{ 
		print $this->m_prepayment_divisi->gf_transact(); 
	} 
	function gf_load_data() 
	{ 
		$c = new libPaging(); 
		$sParam = array( "sSQL" => "select a.nIdDivisi as `Id Divisi`, a.sNamaDivisi as `Nama Divisi`, ".$this->m_core_apps->gf_generate_log_col(array("sPrefix" => "a"))."  from tm_prepayment_divisi a where a.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." order by a.dCreateOn desc",
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_divisi/gf_load_data",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_divisi/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("Nama Divisi"),
										 "sDefaultFieldSearch"  => "Nama Divisi",
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
}