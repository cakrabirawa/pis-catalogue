<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class c_prepayment_komponen_pre_payment extends CI_Controller { 
	var $data = null;
	public function __construct() 
	{ 
		parent::__construct(); 
		$a = new libSession(); 
		if($a->gf_check_session()) 
			redirect("c_core_login"); 
		else 
		{ 
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_prepayment_komponen_pre_payment')); 
			$this->load->library(array('libPaging')); 
		}	
		$this->data['o_page'] 			= 'backend/v_prepayment_komponen_pre_payment'; 
		$this->data['o_page_title'] = 'Komponen Pre Payment'; 
		$this->data['o_page_desc'] 	= 'Maintenance Komponen Pre Payment'; 
		$this->data['o_data'] 			= null;
		$this->data['o_extra']  		= $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_prepayment_komponen_pre_payment"));
	} 
	public function index() 
	{ 
		$this->data['o_mode'] = "I";
		$this->data['o_detail'] = $this->m_prepayment_komponen_pre_payment->gf_load_detail();
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	public function gf_exec() 
	{ 
		$this->data['o_mode'] = "";
		$this->data['o_data'] = $this->m_prepayment_komponen_pre_payment->gf_load_data(); 
		$this->data['o_grupuser'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nGroupUserId, sGroupUserName  from tm_user_groups where sStatusDelete is null and nGroupUserId > 0", "sFieldId" => "nGroupUserId", "sFieldValues" => "sGroupUserName"));	
		$this->data['o_detail'] = $this->m_prepayment_komponen_pre_payment->gf_load_detail(array("nIdKomponen" => $this->data['o_data'][0]['nIdKomponen']));
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	function gf_transact() 
	{ 
		print $this->m_prepayment_komponen_pre_payment->gf_transact(); 
	} 
	function gf_load_data() 
	{ 
		$c = new libPaging(); 
		$sParam = array( "sSQL" => "select a.nIdKomponen as `Id Komponen Pre Payment`, a.sNamaKomponen as `Nama Komponen Pre Payment`, case when sTipeDataKomponen = 'N' then 'NUMERIC' else case when sTipeDataKomponen = 'D' then 'DATE' else case when sTipeDataKomponen = 'A' then 'ALPHA NUMERIC' end end end as `Tipe Data`, case when sAllowSummary = '1' then 'YES' else case when sAllowSummary = '0' then 'NO' end end as `Allow Summary`, case when sAllowMultiply = '1' then 'YES' else case when sAllowMultiply = '0' then 'NO' end end as `Allow Multiply`, nDigit as `Digit`, nDecimalPoint as `Dec. Point`, a.sLabel as `Label`, a.sSatuan as `Satuan`, ".$this->m_core_apps->gf_generate_log_col(array("sPrefix" => "a"))."  from tm_prepayment_komponen_pre_payment a where a.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." order by a.dCreateOn desc",
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_komponen_pre_payment/gf_load_data",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_komponen_pre_payment/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("Nama Komponen Pre Payment"),
										 "sDefaultFieldSearch"  => "Nama Komponen Pre Payment",
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
}