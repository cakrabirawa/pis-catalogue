<?php 
/*
------------------------------
Menu Name: Karyawan
File Name: C_prepayment_karyawan.php
File Path: D:\Project\PHP\prepayment\application\controllers\C_prepayment_karyawan.php
Create Date Time: 2020-01-16 11:40:20
------------------------------
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class c_prepayment_karyawan extends CI_Controller { 
	var $data = null;
	public function __construct() 
	{ 
		parent::__construct(); 
		$a = new libSession(); 
		if($a->gf_check_session()) 
			redirect("c_core_login"); 
		else 
		{ 
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_prepayment_karyawan')); 
			$this->load->library(array('libPaging')); 
		}	
		$this->data['o_page'] 				= 'backend/v_prepayment_karyawan'; 
		$this->data['o_page_title'] 	= 'Karyawan'; 
		$this->data['o_page_desc'] 		= 'Maintenance Karyawan'; 
		$this->data['o_data'] 				= null;
		$this->data['o_extra']  			= $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_prepayment_karyawan"));
	} 
	public function gf_exec() 
	{ 
		$this->data['o_mode'] = "";
		$this->data['o_data'] = $this->m_prepayment_karyawan->gf_load_data();
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$this->data['o_unitusaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaPosisi, nIdPosisi  from tm_prepayment_posisi where sStatusDelete is null and nUnitId_fk = ".$nUnitId, "sFieldId" => "nIdPosisi", "sFieldValues" => "sNamaPosisi", "sFieldInitValue" => $this->data['o_data'][0]['nIdPosisi_fk']));	
		$this->data['o_posisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaUnitUsaha, nIdUnitUsaha  from tm_prepayment_unit_usaha where sStatusDelete is null and nUnitId_fk = ".$nUnitId, "sFieldId" => "nIdUnitUsaha", "sFieldValues" => "sNamaUnitUsaha", "sFieldInitValue" => $this->data['o_data'][0]['nIdUnitUsaha_fk']));	
		$this->data['o_bank'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaBank, nIdBank  from tm_prepayment_bank where sStatusDelete is null and nUnitId_fk = ".$nUnitId, "sFieldId" => "nIdBank", "sFieldValues" => "sNamaBank", "sFieldInitValue" => $this->data['o_data'][0]['nIdBank_fk']));	
		$this->data['o_divisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaDivisi, nIdDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$nUnitId, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi", "sFieldInitValue" => $this->data['o_data'][0]['nIdDivisi_fk']));	
		$this->data['o_departemen'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaDepartemen, nIdDepartemen  from tm_prepayment_departemen where sStatusDelete is null and nUnitId_fk = ".$nUnitId, "sFieldId" => "nIdDepartemen", "sFieldValues" => "sNamaDepartemen", "sFieldInitValue" => $this->data['o_data'][0]['nIdDepartemen_fk']));	
		$this->data['o_user_group'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => true, "sSQL" => "select nGroupUserId, sGroupUserName from tm_user_groups where sStatusDelete is null and nGroupUserId <> 0", "sFieldId" => "nGroupUserId", "sFieldValues" => "sGroupUserName", "sFieldInitValue" => $this->data['o_data'][0]['nGroupUserId_fk']));
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	public function index() 
	{ 
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$this->data['o_user_group'] = $this->m_core_apps->gf_load_select_option(array("bDisabledUnitId" => true, "sSQL" => "select nGroupUserId, sGroupUserName from tm_user_groups where sStatusDelete is null and nGroupUserId <> 0", "sFieldId" => "nGroupUserId", "sFieldValues" => "sGroupUserName"));
		$this->data['o_unitusaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaPosisi, nIdPosisi  from tm_prepayment_posisi where sStatusDelete is null and nUnitId_fk = ".$nUnitId, "sFieldId" => "nIdPosisi", "sFieldValues" => "sNamaPosisi"));	
		$this->data['o_posisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaUnitUsaha, nIdUnitUsaha  from tm_prepayment_unit_usaha where sStatusDelete is null and nUnitId_fk = ".$nUnitId, "sFieldId" => "nIdUnitUsaha", "sFieldValues" => "sNamaUnitUsaha"));	
		$this->data['o_bank'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaBank, nIdBank  from tm_prepayment_bank where sStatusDelete is null and nUnitId_fk = ".$nUnitId, "sFieldId" => "nIdBank", "sFieldValues" => "sNamaBank"));	
		$this->data['o_divisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaDivisi, nIdDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$nUnitId, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi", ));	
		$this->data['o_departemen'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaDepartemen, nIdDepartemen  from tm_prepayment_departemen where sStatusDelete is null and nUnitId_fk = ".$nUnitId, "sFieldId" => "nIdDepartemen", "sFieldValues" => "sNamaDepartemen"));	
		$this->data['o_mode'] = "I";
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	function gf_begin_import()
	{
		print $this->m_prepayment_karyawan->gf_begin_import();
	} 
	function gf_load_data() 
	{ 
		$c = new libPaging(); 
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$sParam = array( "sSQL" => "select a.sNIK as `NIK`, a.sNamaKaryawan as `Nama Karyawan`, a.sNIKAtasan as `NIK Atasan`, (select p.sNamaKaryawan from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIK = a.sNIKAtasan limit 1) As `Nama Atasan`, e.sNamaPosisi as `Jabatan`, f.sNamaUnitUsaha as `Unit Usaha`, b.sNamaBank as `Bank`, c.sNamaDivisi as `Divisi`, d.sNamaDepartemen as `Departemen`, a.sCabangBank as `Cabang Bank`, a.sNoRekening as `No Rekening`, a.sAtasNamaRekening as `Atas Nama Rekening`, a.sNoHP as `No HP`, a.sEmail as `Email`	 from tm_prepayment_karyawan a inner join tm_prepayment_bank b on b.nIdBank = a.nIdBank_fk inner join tm_prepayment_divisi c on c.nIdDivisi = a.nIdDivisi_fk and c.nUnitId_fk = ".$nUnitId." inner join tm_prepayment_departemen d on d.nIdDepartemen = a.nIdDepartemen_fk and d.nUnitId_fk = ".$nUnitId." inner join tm_prepayment_posisi e on e.nIdPosisi = a.nIdPosisi_fk and e.nUnitId_fk = ".$nUnitId." inner join tm_prepayment_unit_usaha f on f.nIdUnitUsaha = a.nIdUnitUsaha_fk and e.nUnitId_fk = ".$nUnitId." where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and b.sStatusDelete is null and b.nUnitId_fk = ".$nUnitId." and c.sStatusDelete is null and c.nUnitId_fk = ".$nUnitId." and d.sStatusDelete is null and d.nUnitId_fk = ".$nUnitId." and e.sStatusDelete is null and e.nUnitId_fk = ".$nUnitId." and f.sStatusDelete is null and f.nUnitId_fk = ".$nUnitId,"sTitleHeader" => "Karyawan",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_karyawan/gf_load_data",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_karyawan/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("Nama Karyawan"),
										 "sDefaultFieldSearch"  => "Nama Karyawan",
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
	function gf_transact() 
	{ 
		print $this->m_prepayment_karyawan->gf_transact(); 
	} 
	function gf_load_data_karyawan()
	{
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$c = new libPaging();
  	$sParam = array(
  										"sSQL"  				       => "select g.nUserId as `User Id`, a.sNIK as `NIK`, a.sNamaKaryawan as `Nama Karyawan`, a.sCabangBank as `Cabang Bank`, a.sNoRekening as `No Rekening`, a.sAtasNamaRekening as `Atas Nama Rekening` from tm_prepayment_karyawan a inner join tm_prepayment_bank b on b.nIdBank = a.nIdBank_fk left join tm_prepayment_divisi c on c.nIdDivisi = a.nIdDivisi_fk and c.nUnitId_fk = ".$nUnitId." left join tm_prepayment_departemen d on d.nIdDepartemen = a.nIdDepartemen_fk and d.nUnitId_fk = ".$nUnitId." left join tm_prepayment_posisi e on e.nIdPosisi = a.nIdPosisi_fk and e.nUnitId_fk = ".$nUnitId." left join tm_prepayment_unit_usaha f on f.nIdUnitUsaha = a.nIdUnitUsaha_fk and e.nUnitId_fk = ".$nUnitId." inner join tm_user_logins g on g.sUserName = a.sNIK where g.sStatusDelete is null and a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and sNIK <> '".$this->session->userdata('sUserName')."'", 
  										"sTitleHeader" 				 => "Search Atasan",
  										"sCallBackURLPaging"	 => site_url()."c_prepayment_karyawan/gf_load_data_karyawan",
											"sLookupPopup"         => true,
											"sLookupMode"           => "single",
  										"sLookupEditDelete"    => false,
  										"bDebugSQL"            => false,
  										"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
  										"sInitHeaderFields"    => array("Nama Karyawan"),
  										"sDefaultFieldSearch"  => "Nama Karyawan",
  										"sTheme"               => "default",
  										"hideInitRowPage"      => 10 
  								 );		
  	$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
	function gf_load_data_atasan()
	{
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$c = new libPaging();
  	$sParam = array(
  										"sSQL"  				       => "select a.sNIK as `NIK`, a.sNamaKaryawan as `Nama Karyawan`from tm_prepayment_karyawan a where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and sNIK <> '".$this->session->userdata('sUserName')."'", 
  										"sTitleHeader" 				 => "Search Atasan",
  										"sCallBackURLPaging"	 => site_url()."c_prepayment_karyawan/gf_load_data_atasan",
											"sLookupPopup"         => true,
											"sLookupMode"           => "single",
  										"sLookupEditDelete"    => false,
  										"bDebugSQL"            => false,
  										"sLayout"							 => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
  										"sInitHeaderFields"    => array("Nama Karyawan"),
  										"sDefaultFieldSearch"  => "Nama Karyawan",
  										"sTheme"               => "default",
  										"hideInitRowPage"      => 10 
  								 );		
  	$p = $c->gf_render_paging_data($sParam);
		print $p;
	}
	function gf_load_data_karyawan_detail()
	{
		print json_encode(array("oData" => $this->m_prepayment_karyawan->gf_load_data(array("NIK" => $this->input->post('sNIK', TRUE)))));
	}
	function gf_load_divisi_by_unit_usaha()
	{
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$nIdUnitUsaha = $this->input->post('nIdUnitUsaha', TRUE);
		print json_encode(array("oData" => $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDivisi, sNamaDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$nUnitId." and nIdUnitUsaha_fk = ".$nIdUnitUsaha, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi"))));	
	}
	function gf_load_departemen_by_divisi()
	{
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$nIdDivisi = $this->input->post('nIdDivisi', TRUE);
		print json_encode(array("oData" => $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDepartemen, sNamaDepartemen  from tm_prepayment_departemen where sStatusDelete is null and nUnitId_fk = ".$nUnitId." and nIdDivisi_fk = ".$nIdDivisi, "sFieldId" => "nIdDepartemen", "sFieldValues" => "sNamaDepartemen"))));	
	}
}