<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class c_prepayment_kategori_pre_payment extends CI_Controller { 
	var $data = null;
	public function __construct() 
	{ 
		parent::__construct(); 
		$a = new libSession(); 
		if($a->gf_check_session()) 
			redirect("c_core_login"); 
		else 
		{ 
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_prepayment_kategori_pre_payment')); 
			$this->load->library(array('libPaging')); 
		}	
		$this->data['o_page'] 			= 'backend/v_prepayment_kategori_pre_payment'; 
		$this->data['o_page_title'] = 'Kategori Pre Payment'; 
		$this->data['o_page_desc'] 	= 'Maintenance Kategori Pre Payment'; 
		$this->data['o_data'] 			= null;
		$this->data['o_extra']  		= $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_prepayment_kategori_pre_payment"));
	} 
	public function index() 
	{ 
		$this->data['o_mode'] = "I";
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	public function gf_exec() 
	{ 
		$this->data['o_mode'] = "";
		$this->data['o_data'] = $this->m_prepayment_kategori_pre_payment->gf_load_data(); 
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	function gf_transact() 
	{ 
		print $this->m_prepayment_kategori_pre_payment->gf_transact(); 
	} 
	function gf_load_data() 
	{ 
		$c = new libPaging(); 
		$sParam = array( "sSQL" => "select a.nIdKategoriPrePayment as `Id Kategori Pre Payment`, a.sNamaKategoriPrePayment as `Nama Kategori Pre Payment`, (select count(1) from tm_prepayment_kategori_pre_payment_d p where p.nIdKategoriPrePayment_fk = a.nIdKategoriPrePayment and p.sStatusDelete is null and p.nUnitId_fk = ".$this->session->userdata('nUnitId_fk').") as `Jml Komponen Pre Payment`, ".$this->m_core_apps->gf_generate_log_col(array("sPrefix" => "a"))."  from tm_prepayment_kategori_pre_payment_h a where a.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." order by a.dCreateOn desc",
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_kategori_pre_payment/gf_load_data",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_kategori_pre_payment/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("Nama Kategori Pre Payment"),
										 "sDefaultFieldSearch"  => "Nama Kategori Pre Payment",
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
	function gf_load_data_komponen_pre_payment() 
	{ 		
		$c = new libPaging(); 
		$nIdKategoriPrePayment = $this->input->post('nIdKategoriPrePayment', TRUE);
		$nUnitId = $this->session->userdata('nUnitId_fk');

		$sql = "select a.nIdKomponen as `Id Komponen Pre Payment`, a.sNamaKomponen as `Nama Komponen Pre Payment`, case when sTipeDataKomponen = 'N' then 'NUMERIC' else case when sTipeDataKomponen = 'D' then 'DATE' else case when sTipeDataKomponen = 'A' then 'ALPHA NUMERIC' end end end as `Tipe Data`, case when sAllowSummary = '1' then 'YES' else case when sAllowSummary = '0' then 'NO' end end as `Allow Summary`, a.nDigit as `Digit`, a.nDecimalPoint as `Dec. Point`, case when a.sAllowMultiply = '1' then 'YES' else case when a.sAllowMultiply = '0' then 'NO' end end as `Allow Multiply`, ";
		if(trim($nIdKategoriPrePayment) !== "")
		{
			$sql .= "concat('<input type=''text''', 'class=''form-control''', 'name=''txtSeq[]''',  'id=''txtSeq''',  ifnull((select case when count(p.nIdKomponen_fk) = 0 then 'disabled' else '' end from tm_prepayment_kategori_pre_payment_d p where p.nUnitId_fk = ".$nUnitId." and p.nIdKategoriPrePayment_fk = ".trim($nIdKategoriPrePayment)." and p.nIdKomponen_fk = a.nIdKomponen and p.sStatusDelete is null LIMIT 1), 'disabled'), ' placeholder=''Sequence Number'' value=''', ifnull((select nSeqNoCustom from tm_prepayment_kategori_pre_payment_d p where p.nUnitId_fk = ".$nUnitId." and p.nIdKategoriPrePayment_fk = ".trim($nIdKategoriPrePayment)." and p.nIdKomponen_fk = a.nIdKomponen and p.sStatusDelete is null LIMIT 1), ''),''' ',  'content-mode=''numeric'' />') as `Sequence`, ";

			$sql .= "concat('<input type=''checkbox''', 'id=''chkPick''', ' name=''chkPick[]''', ' ', ifnull((select case when count(p.nIdKomponen_fk) = 0 then '' else 'checked' end from tm_prepayment_kategori_pre_payment_d p where p.nUnitId_fk = ".$nUnitId." and p.nIdKategoriPrePayment_fk = ".trim($nIdKategoriPrePayment)." and p.nIdKomponen_fk = a.nIdKomponen and p.sStatusDelete is null LIMIT 1), ''), ' />')";
		}
		else
		{
			$sql .= "concat('<input type=''text''', 'class=''form-control''', 'name=''txtSeq[]''',  'id=''txtSeq''', 'disabled placeholder=''Sequence Number'' value='''' content-mode=''numeric'' />') as `Sequence`, ";
			$sql .= "concat('<input type=''checkbox''', 'id=''chkPick''', ' name=''chkPick[]''' ' />')";
		}
		$sql .= " as `Pick`";
		$sql .= " from tm_prepayment_komponen_pre_payment a where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." order by a.dCreateOn desc";

		$sParam = array( "sSQL" => $sql,
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_kategori_pre_payment/gf_load_data_komponen_pre_payment",
										 "sLookupEditDelete" => false,
										 "bDebugSQL" => false,
										 "sJSParam" => array("gf_bind_event()"),
										 "sCycleParam" => array("nIdKategoriPrePayment" => $nIdKategoriPrePayment),
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("Nama Komponen Pre Payment"),
										 "sDefaultFieldSearch"  => "Nama Komponen Pre Payment",
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
}