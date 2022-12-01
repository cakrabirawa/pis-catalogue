<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class c_prepayment_penyelesaian_pre_payment extends CI_Controller { 
	var $data = null;
	var $nUnitId = null;
	public function __construct() 
	{ 
		parent::__construct(); 
		$a = new libSession(); 
		if($a->gf_check_session()) 
			redirect("c_core_login?next=".urlencode(site_url().$this->uri->uri_string())); 
		else 
		{ 
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_prepayment_penyelesaian_pre_payment', 'm_prepayment_penyelesaian_pre_payment', 'm_core_report_engine', 'm_prepayment_karyawan')); 
			$this->load->library(array('libPaging')); 
		}	
		$this->data['o_page'] 			= 'backend/v_prepayment_penyelesaian_pre_payment'; 
		$this->data['o_page_title'] = 'Penyelesaian Pre Payment'; 
		$this->data['o_page_desc'] 	= 'Maintenance Penyelesaian Pre Payment'; 
		$this->data['o_data'] 			= null;
		$this->data['o_extra']  		= $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_prepayment_penyelesaian_pre_payment"));
		$this->nUnitId 							= $this->session->userdata('nUnitId_fk');
	} 
	function gf_load_vendor_by_entity()
	{
		print json_encode(array("sOutput" => $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sIdVendor, concat(sIdVendor, ' - ', sNamaVendor) as sNamaVendor from tm_prepayment_kode_vendor where sEntity = '".trim($this->input->post('sEntity'))."' and sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "sIdVendor", "sFieldValues" => "sNamaVendor"))));		
	}
	public function index() 
	{ 
		$this->data['o_punya_anak_buah'] = $this->m_prepayment_karyawan->gf_login_punya_anak_buah();
		$this->nUnitId = $this->session->userdata('nUnitId_fk');
		$this->data['o_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaUnitUsaha, nIdUnitUsaha  from tm_prepayment_unit_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." and trim(sNamaUnitUsaha) <> '' ", "sFieldId" => "nIdUnitUsaha", "sFieldValues" => "sNamaUnitUsaha"));
		$this->data['o_divisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDivisi, sNamaDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi"));
		$this->data['o_kategori_pre_payment'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriPrePayment, sNamaKategoriPrePayment  from tm_prepayment_kategori_pre_payment_h where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriPrePayment", "sFieldValues" => "sNamaKategoriPrePayment"));
		$this->data['o_cara_bayar'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdPaymentType, sNamaPaymentType  from tm_prepayment_payment_type where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdPaymentType", "sFieldValues" => "sNamaPaymentType"));
		$this->data['o_departemen'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDepartemen, sNamaDepartemen  from tm_prepayment_departemen where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDepartemen", "sFieldValues" => "sNamaDepartemen"));
		$this->data['o_nik'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNIK, concat(sNIK, ' - ', sNamaKaryawan) as sNamaKaryawan  from tm_prepayment_karyawan where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." order by sNamaKaryawan", "sFieldId" => "sNIK", "sFieldValues" => "sNamaKaryawan"));
		$this->data['o_kel_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKelompokUsaha, sNamaKelompokUsaha  from tm_prepayment_kelompok_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKelompokUsaha", "sFieldValues" => "sNamaKelompokUsaha"));
		$this->data['o_kategori_trx'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriTRX, sNamaKategoriTRX from tm_prepayment_kategori_trx where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriTRX", "sFieldValues" => "sNamaKategoriTRX"));	
		$this->data['o_pembebanan'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sIdPembebanan, concat(sIdPembebanan, ' - ', sNamaPembebanan) as sNamaPembebanan from tm_prepayment_pembebanan where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "sIdPembebanan", "sFieldValues" => "sNamaPembebanan"));	
		$this->data['o_vendor'] = null;
		$this->data['o_mode'] = "I";
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	public function gf_exec() 
	{ 
		$this->data['o_mode'] = "";
		$this->data['o_data'] = $this->m_prepayment_penyelesaian_pre_payment->gf_load_data(); 
		$this->data['o_punya_anak_buah'] = $this->m_prepayment_karyawan->gf_login_punya_anak_buah();
		$this->data['o_data'] = $this->m_prepayment_penyelesaian_pre_payment->gf_load_data(); 
		$this->data['o_data_detail'] = $this->m_prepayment_penyelesaian_pre_payment->gf_load_komponen_pre_payment(array("nIdPengajuanBS" => $this->data['o_data'][0]['nIdPengajuanBS'])); 
		$this->nUnitId = $this->session->userdata('nUnitId_fk');
		$this->data['o_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaUnitUsaha, nIdUnitUsaha  from tm_prepayment_unit_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." and trim(sNamaUnitUsaha) <> '' ", "sFieldId" => "nIdUnitUsaha", "sFieldValues" => "sNamaUnitUsaha", "sFieldInitValue" => $this->data['o_data'][0]['nIdUnitUsaha_fk']));	
		$this->data['o_divisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDivisi, sNamaDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi", "sFieldInitValue" => $this->data['o_data'][0]['nIdDivisi_fk']));
		$this->data['o_departemen'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDepartemen, sNamaDepartemen  from tm_prepayment_departemen where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDepartemen", "sFieldValues" => "sNamaDepartemen", "sFieldInitValue" => $this->data['o_data'][0]['nIdDepartemen_fk']));
		$this->data['o_kategori_pre_payment'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriPrePayment, sNamaKategoriPrePayment  from tm_prepayment_kategori_pre_payment_h where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriPrePayment", "sFieldValues" => "sNamaKategoriPrePayment", "sFieldInitValue" => $this->data['o_data'][0]['nIdKategoriPrePayment_fk']));	
		$this->data['o_cara_bayar'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdPaymentType, sNamaPaymentType  from tm_prepayment_payment_type where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdPaymentType", "sFieldValues" => "sNamaPaymentType", "sFieldInitValue" => $this->data['o_data'][0]['nIdPaymentType_fk']));	
		$this->data['o_nik'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNIK, concat(sNIK, ' - ', sNamaKaryawan) as sNamaKaryawan  from tm_prepayment_karyawan where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." order by sNamaKaryawan", "sFieldId" => "sNIK", "sFieldValues" => "sNamaKaryawan", "sFieldInitValue" => $this->data['o_data'][0]['sNIK']));	
		$this->data['o_kel_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKelompokUsaha, sNamaKelompokUsaha  from tm_prepayment_kelompok_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKelompokUsaha", "sFieldValues" => "sNamaKelompokUsaha", "sFieldInitValue" => $this->data['o_data'][0]['nIdKelompokUsaha_fk']));		
		$this->data['o_kategori_trx'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriTRX, sNamaKategoriTRX from tm_prepayment_kategori_trx where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriTRX", "sFieldValues" => "sNamaKategoriTRX"));	
		$this->data['o_pembebanan'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sIdPembebanan, concat(sIdPembebanan, ' - ', sNamaPembebanan) as sNamaPembebanan from tm_prepayment_pembebanan where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "sIdPembebanan", "sFieldValues" => "sNamaPembebanan"));	
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	public function gf_exec_from_reff($sUUID) 
	{ 
		$this->data['o_page'] = 'backend/v_prepayment_penyelesaian_pre_payment'; 
		$this->data['o_page_title'] = 'Penyelesaian Pre Payment'; 
		$this->data['o_page_desc'] = 'Maintenance Penyelesaian Pre Payment'; 
		$this->data['o_data'] = null; 
		$this->data['o_mode'] = ""; 
		$this->data['o_punya_anak_buah'] = $this->m_prepayment_karyawan->gf_login_punya_anak_buah();
		$this->data['o_data'] = $this->m_prepayment_penyelesaian_pre_payment->gf_load_data_from_reff(array("sUUID" => trim($sUUID))); 
		if(count($this->data['o_data']) === 0)
		{
			//print "<h2>Invalid Data...</h2>";
			//print "<h4>Please wait to redirect to Main Page !</h4>";
			header('Refresh: 0; URL='.site_url());
			exit(0);
		} 
		$this->data['o_data_detail'] = $this->m_prepayment_penyelesaian_pre_payment->gf_load_komponen_pre_payment(array("nIdPengajuanBS" => $this->data['o_data'][0]['nIdPengajuanBS'])); 
		$this->nUnitId = $this->session->userdata('nUnitId_fk');
		$this->data['o_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaUnitUsaha, nIdUnitUsaha  from tm_prepayment_unit_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." and trim(sNamaUnitUsaha) <> '' ", "sFieldId" => "nIdUnitUsaha", "sFieldValues" => "sNamaUnitUsaha", "sFieldInitValue" => $this->data['o_data'][0]['nIdUnitUsaha_fk']));	
		$this->data['o_divisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDivisi, sNamaDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi", "sFieldInitValue" => $this->data['o_data'][0]['nIdDivisi_fk']));
		$this->data['o_departemen'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDepartemen, sNamaDepartemen  from tm_prepayment_departemen where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDepartemen", "sFieldValues" => "sNamaDepartemen", "sFieldInitValue" => $this->data['o_data'][0]['nIdDepartemen_fk']));
		$this->data['o_kategori_pre_payment'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriPrePayment, sNamaKategoriPrePayment  from tm_prepayment_kategori_pre_payment_h where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriPrePayment", "sFieldValues" => "sNamaKategoriPrePayment", "sFieldInitValue" => $this->data['o_data'][0]['nIdKategoriPrePayment_fk']));	
		$this->data['o_cara_bayar'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdPaymentType, sNamaPaymentType  from tm_prepayment_payment_type where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdPaymentType", "sFieldValues" => "sNamaPaymentType", "sFieldInitValue" => $this->data['o_data'][0]['nIdPaymentType_fk']));	
		$this->data['o_nik'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNIK, concat(sNIK, ' - ', sNamaKaryawan) as sNamaKaryawan  from tm_prepayment_karyawan where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." order by sNamaKaryawan", "sFieldId" => "sNIK", "sFieldValues" => "sNamaKaryawan", "sFieldInitValue" => $this->data['o_data'][0]['sNIK']));	
		$this->data['o_kel_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKelompokUsaha, sNamaKelompokUsaha  from tm_prepayment_kelompok_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKelompokUsaha", "sFieldValues" => "sNamaKelompokUsaha", "sFieldInitValue" => $this->data['o_data'][0]['nIdKelompokUsaha_fk']));		
		$this->data['o_kategori_trx'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriTRX, sNamaKategoriTRX from tm_prepayment_kategori_trx where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriTRX", "sFieldValues" => "sNamaKategoriTRX"));	
		$this->data['o_pembebanan'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sIdPembebanan, concat(sIdPembebanan, ' - ', sNamaPembebanan) as sNamaPembebanan from tm_prepayment_pembebanan where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "sIdPembebanan", "sFieldValues" => "sNamaPembebanan"));	
		$this->data['o_side_bar'] = $this->m_core_user_menu->gf_recursive_side_bar(array("nMenuId" => 0, "nMenuIdInit" => 0));
		$this->data['o_info'] = $this->m_core_user_login->gf_user_info();
		$this->data['o_config'] = $this->m_core_apps->gf_read_config_apps();
		//--Authorized-- 
		$oAuth = json_decode($this->m_core_user_login->gf_load_auth(array("sMenuCtlName" => "c_prepayment_penyelesaian_pre_payment")), TRUE); 
		$this->data['o_save']   = trim($oAuth['sSave']); 
		$this->data['o_update'] = trim($oAuth['sUpdate']); 
		$this->data['o_delete'] = trim($oAuth['sDelete']); 
		$this->data['o_cancel'] = trim($oAuth['sCancel']); 
		//--End Authorized 
		$this->load->view('backend/v_core_main', $data); 
	} 
	function gf_transact() 
	{ 
		print $this->m_prepayment_penyelesaian_pre_payment->gf_transact(); 
	} 
	function gf_load_data_pengajuan_pre_payment_staff() 
	{ 
		$c = new libPaging(); 
		$nGroupUserIdHRD = 7; // Grup use HRD 
		$nGroupUserIdFINANCE = 9; // Grup use FINANCE 
		$oAnakBuah = $this->m_prepayment_karyawan->gf_login_punya_anak_buah();
		$this->nUnitId = $this->session->userdata('nUnitId_fk');
		$sql = "select a.nIdPenyelesaianBS as `Id Penyelesaian Pre Payment`, 
		a.sNoPenyusun as `No Penyusun`, 
		a.dTglPenyusun as `Tgl Penyusun`, 
		a.sNIK as `NIK`, 
		a.sNamaKaryawan as `Nama Karyawan`, 
		a.sNamaUnitUsaha as `Unit Usaha`, 
		a.sBagian as `Bagian`, 
		a.sNamaBank as `Bank`, 
		b.sNamaPaymentType as `Payment Type`, 
		c.sNamaKategoriPrePayment as 	`Kategori Pre Payment`, 
		".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", a.nIdPenyelesaianBS, 'PENYELESAIAN_PRE_PAYMENT', null, null, null) as `Last Status`, 
		a.nTotalBiayaPengajuan as `Total Pengajuan`, 
		a.nTotalBiayaTerpakai as `Jml Dana Terpakai`,
		a.nTotalBiayaSisa as `Kurang/Lebih Dana`,
		a.nIdPengajuanBS_fk as `Id Pengajuan Pre Payment`

		from tx_prepayment_penyelesaian_pp a inner join tm_prepayment_payment_type b 
		on b.nIdPaymentType = a.nIdPaymentType_fk inner join tm_prepayment_kategori_pre_payment_h c 
		on c.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk 

		where a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null and a.sMode = 'PL' ";

		if(intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdHRD || intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdFINANCE)
		{
			//-- Hanya yang di Approve saja status terakhir nya
			$sql .= "and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and  p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) in ('APPROVE')";
			//$sql .= "and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' order by p.dCreateOn desc limit 1) <> ".$nGroupUserIdHRD; 
			$sql .= " and (a.sPosting is null or a.sPosting = '0')"; 
		}
		else
		{
			$oAnakBuah = json_decode($oAnakBuah, TRUE);
			if(intval($oAnakBuah) > 0)
				$sql .= "and a.sNIKAtasan = '".$this->session->userdata('sUserName')."'"; 	
			//-- Hanya yang di Approve saja status terakhir nya
			$sql .= "and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and  p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS and p.nGroupUserId_fk <> ".$this->session->userdata('nGroupUserId_fk')."  order by p.dCreateOn desc limit 1) = 'SUBMIT' and 
			(select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' order by p.dCreateOn desc limit 1) <> ".$this->session->userdata('nGroupUserId_fk'); 
		}

		$sql .= " order by a.dCreateOn desc";

		$sParam = array( "sSQL" => $sql,
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_penyelesaian_pre_payment/gf_load_data_pengajuan_pre_payment_staff",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_penyelesaian_pre_payment/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("No Penyusun"),
										 "sDefaultFieldSearch"  => "No Penyusun",
										 "sFieldIgnore" => array("Id Penyelesaian Pre Payment"),
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
	function gf_load_data_pengajuan_pre_payment_saya() 
	{ 
		$c = new libPaging(); 
		$this->nUnitId = $this->session->userdata('nUnitId_fk');
		$nGroupUserIdHRD = 7; // Grup use HRD 
		$sql = "select `Id Pengajuan Pre Payment`, `No Penyusun`, `Deskripsi`, `Tgl Penyusun`, `NIK`, `Nama Karyawan`, `Unit Usaha`, `Bagian`, `Payment Type`, `Kategori Pre Payment`, 

		case when (select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nIdPengajuanBS_fk = c.`Id Pengajuan Pre Payment`) > 0 then 

		".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", c.`Id Pengajuan Pre Payment`, 'PENYELESAIAN_PRE_PAYMENT', null, null, null)  
		else 
		".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", c.`Id Pengajuan Pre Payment`, 'PENGAJUAN_PRE_PAYMENT', null, null, null) end as `Last Status`, 


		`Total Amount`, `Posting`  from (select a.sDeskripsi as `Deskripsi`, a.nIdPengajuanBS as `Id Pengajuan Pre Payment`, a.sNoPenyusun as `No Penyusun`, a.dTglPenyusun as `Tgl Penyusun`, a.sNIK as `NIK`, a.sNamaKaryawan as `Nama Karyawan`, a.sNamaUnitUsaha as `Unit Usaha`, a.sBagian as `Bagian`, b.sNamaPaymentType as `Payment Type`, c.sNamaKategoriPrePayment as 	`Kategori Pre Payment`, a.nTotalAmount as `Total Amount`, ifnull((select case when p.sPosting = '1' and p.sPosting is not null then concat('<b>DONE</b>', ' by <b>', p.sPostingBy, '</b> at <b>', date_format(p.dPostingDate, '%d/%m/%Y %H:%i:%s'), '</b>') else 'NOT YET' end from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nIdPengajuanBS_fk = a.nIdPengajuanBS), 'NOT YET') as `Posting`

		 from tx_prepayment_pengajuan_pp a inner join tm_prepayment_payment_type b on b.nIdPaymentType = a.nIdPaymentType_fk inner join 
			tm_prepayment_kategori_pre_payment_h c on c.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk where a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null and a.sMode = 'PP' ";

		if(intval($this->session->userdata('nGroupUserId_fk')) !== 0) //-- Admin Group
		{
			//-- Sesuai NIK yang login
			$sql .= " and a.sNIK = '".$this->session->userdata('sUserName')."' ";
			//-- Yang sudah di Approve sama HRD
			$sql .= " and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' order by p.dCreateOn desc limit 1) = 'APPROVE'";
		}

		//-- dan belum di buat penyelesaian
		$sql .= " and a.nIdPengajuanBS and not exists (select p.nIdPengajuanBS_fk from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nIdPengajuanBS_fk = a.nIdPengajuanBS)";

		$sql .= " order by a.dCreateOn desc) as c";
		//print $sql;

		$sParam = array( "sSQL" => $sql,
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_penyelesaian_pre_payment/gf_load_data_pengajuan_pre_payment_saya",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_penyelesaian_pre_payment/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("No Penyusun"),
										 "sFieldIgnore" => array("Id Pengajuan Pre Payment"),
										 "sFieldIgnoreOnSearchField" => array(),
										 "sDefaultFieldSearch"  => "No Penyusun",
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
	function gf_load_data_penyelesaian_pre_payment_saya() 
	{ 
		$c = new libPaging(); 
		$this->nUnitId = $this->session->userdata('nUnitId_fk');
		$sql = "select b.sNoPenyusun as `No Penyusun`, a.nIdPenyelesaianBS as `Id Penyelesaian Pre Payment`, a.dTglPenyelesaianPrePayment as `Tgl Penyelesaian Pre Payment`, a.nIdPengajuanBS_fk as `Id Pengajuan Pre Payment`, b.sNIK as `NIK`, b.sNamaKaryawan as `Nama Karyawan`, b.sNamaUnitUsaha as `Unit Usaha`, c.sNamaDivisi as `Nama Divisi`, d.sNamaDepartemen as `Departemen`, b.sBagian as `Bagian`, b.sNamaBank as `Nama Bank`,a.nTotalBiayaTerpakai as `Jml Dana Terpakai`, a.nTotalBiayaSisa as `Jml Dana Sisa / Lebih`, b.nTotalAmount as `Total Pengajuan`,

		".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", a.nIdPenyelesaianBS, 'PENYELESAIAN_PRE_PAYMENT', null, null, null) as `Last Status`, 

		 case when a.sPosting = '1' then concat('<b>DONE</b>', ' by <b>', a.sPostingBy, '</b> at <b>', date_format(a.dPostingDate, '%d/%m/%Y %H:%i:%s'), '</b>') else 'NOT YET' end  as `Posting`  


		from tx_prepayment_penyelesaian_pp a inner join tx_prepayment_pengajuan_pp b on b.nIdPengajuanBS = a.nIdPengajuanBS_fk inner join tm_prepayment_divisi c on c.nIdDivisi = b.nIdDivisi_fk inner join tm_prepayment_departemen d on d.nIdDepartemen = b.nIdDepartemen_fk where ";


		$sql .= " a.sStatusDelete is null and a.nUnitId_fk = ".$this->nUnitId." and c.sStatusDelete is null and c.nUnitId_fk = ".$this->nUnitId." and d.sStatusDelete is null and d.nUnitId_fk = ".$this->nUnitId." and b.sStatusDelete is null and b.nUnitId_fk = ".$this->nUnitId;


		if(intval($this->session->userdata('nGroupUserId_fk')) !== 0) //-- Admin Group
		{
			/*
			if(intval($this->session->userdata('nGroupUserId_fk')) === 1) //-- Manager Group
				$sql .= " and sNIKAtasan = '".trim($this->session->userdata('sUserName'))."' 
				and (((select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.sStatus = 'SUBMIT' And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nIdPengajuanBS_fk = a.nIdPengajuanBS_fk and p.nGroupUserId_fk not in (1, 5)  order by p.dCreateOn desc limit 1) = 'SUBMIT' 
				))";
 			else if(intval($this->session->userdata('nGroupUserId_fk')) === 5) //-- HRD Group
			{
				$sql .= " and (((select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.sStatus = 'APPROVE' And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nIdPengajuanBS_fk = a.nIdPengajuanBS_fk and p.nGroupUserId_fk in (1)  order by p.dCreateOn desc limit 1) = 'APPROVE' 
				))";
			}
			else 			
				
			*/
			$sql .= " and a.sNIK = '".trim($this->session->userdata('sUserName'))."' order by a.dCreateOn desc"; 
		}

		//exit("Penyelesaian: ".$sql);

		$sParam = array( "sSQL" => $sql,
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_penyelesaian_pre_payment/gf_load_data_penyelesaian_pre_payment_saya",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_penyelesaian_pre_payment/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("Nama Karyawan"),
										 "sJSParam" => array("gf_bind_event()"),
										 "sFieldIgnore" => array("Id Penyelesaian Pre Payment"),
										 "sFieldIgnoreOnSearchField" => array(),
										 "sDefaultFieldSearch"  => "No Penyusun",
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
	function gf_print_pengajuan_bs()
	{
		$this->m_core_report_engine->gf_exec_report();
	}
	function gf_load_komponen_pre_payment()
	{
		print $this->m_prepayment_penyelesaian_pre_payment->gf_load_komponen_pre_payment();
	}
	function gf_load_info_karyawan()
	{
		print $this->m_prepayment_karyawan->gf_load_info_karyawan();  
	}
	function gf_test_auto_complete()
	{		
		print $this->m_prepayment_karyawan->gf_search_karyawan();
	}
	function gf_load_divisi_by_unit_usaha()
	{
		print $this->m_prepayment_penyelesaian_pre_payment->gf_load_divisi_by_unit_usaha();
	}
	function gf_load_departemen_by_divisi()
	{
		print $this->m_prepayment_penyelesaian_pre_payment->gf_load_departemen_by_divisi();
	}
	function gf_operation()
	{
		print $this->m_prepayment_penyelesaian_pre_payment->gf_operation();
	}
	function gf_load_all_data()
	{
		print $this->m_prepayment_penyelesaian_pre_payment->gf_load_all_data();
	}
	function gf_load_data_pick() 
	{ 
		$c = new libPaging(); 

		$nGroupUserIdAktif 	= intval($this->session->userdata('nGroupUserId_fk'));
		$sNIK								= $this->session->userdata('sUserName');
		$nGroupUserIdHRD 		= 7; // Grup use HRD 
		
		$this->nUnitId 			= $this->session->userdata('nUnitId_fk');
		$sTglAwal 					= $this->input->post('sTglAwal', TRUE);
		$sTglAkhir 					= $this->input->post('sTglAkhir', TRUE);
		$sLastStatus				= trim($this->input->post('sLastStatus', TRUE));

		$sql = "select a.nIdPenyelesaianBS as `Id Penyelesaian Pre Payment`, a.sNoPenyusun as `No Penyusun`, a.dTglPenyusun as `Tgl Penyusun`, a.sNIK as `NIK`, a.sNamaKaryawan as `Nama Karyawan`, a.sNamaUnitUsaha as `Unit Usaha`, a.sBagian as `Bagian`, a.sNamaBank as `Bank`, b.sNamaPaymentType as `Payment Type`, c.sNamaKategoriPrePayment as 	`Kategori Pre Payment`, a.sDeskripsi as `Deskripsi`, 

		/*case when (select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nIdPengajuanBS_fk = a.nIdPengajuanBS_fk) > 0 then 

		".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", a.nIdPenyelesaianBS, 'PENYELESAIAN_PRE_PAYMENT', null, null, null)  
		else 
		".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", a.nIdPengajuanBS_fk, 'PENGAJUAN_PRE_PAYMENT', null, null, null) end as `Last Status`,*/

		".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", a.nIdPengajuanBS_fk, 'PENGAJUAN_PRE_PAYMENT', null, null, null)  as `Last Status`,		 

		a.nTotalBiayaPengajuan as `Biaya Pengajuan`, a.nTotalBiayaTerpakai as `Biaya Terpakai`, a.nTotalBiayaSisa as `Biaya Sisa/Lebih` from tx_prepayment_penyelesaian_pp a inner join tm_prepayment_payment_type b on b.nIdPaymentType = a.nIdPaymentType_fk inner join tm_prepayment_kategori_pre_payment_h c on c.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk where a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null and a.sMode = 'PL' ";

		if(intval($nGroupUserIdAktif) !== intval($nGroupUserIdHRD))		
			$sql .= " and (a.sNIK = '".trim($sNIK)."' or a.sNIKAtasan = '".trim($sNIK)."') ";	

		//-- Submit By Me
		if($sLastStatus === "SUBMIT_BY_ME")
		{
			$sql .= " and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) = 'SUBMIT' and (select p.sNIK from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) = a.sNIK";
		}
		//-- Approve Atasan
		else if($sLastStatus === "APPROVE_BY_ATASAN")
		{
			$sql .= " and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) = 'APPROVE' and (select p.sNIK from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) = a.sNIKAtasan";
		}
		//-- Reject Atasan
		else if($sLastStatus === "REJECT_BY_ATASAN")
		{
			$sql .= " and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) = 'REJECT' and (select p.sNIK from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) = a.sNIKAtasan";
		}
		//-- Approve HRD
		else if($sLastStatus === "APPROVE_BY_HRD")
		{
			$sql .= " and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) = 'APPROVE' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) = ".trim($nGroupUserIdHRD);
			$sql .= " and (a.sPosting = '0' or a.sPosting is null) ";
		}
		//-- Reject HRD
		else if($sLastStatus === "REJECT_BY_HRD")
		{
			$sql .= " and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) = 'REJECT' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENYELESAIAN_PRE_PAYMENT' and p.nId_fk = a.nIdPenyelesaianBS order by p.dCreateOn desc limit 1) = ".trim($nGroupUserIdHRD);
		}
		//-- Posting HRD
		else if($sLastStatus === "POSTING_BY_HRD")
		{
			$sql .= " and a.sPosting = '1' ";
		}

		//$sql .= " and (select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nIdPengajuanBS_fk = a.nIdPenyelesaianBS) = 0";
		$sql .= " and b.nUnitId_fk = ".$this->nUnitId." and c.nUnitId_fk = ".$this->nUnitId." and a.nUnitId_fk = ".$this->nUnitId." and a.dTglPenyusun between '".trim($sTglAwal)."' and '".trim($sTglAkhir)."' order by a.dCreateOn desc";

		//print $sql;

		$sParam = array( "sSQL" => $sql,
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_penyelesaian_pre_payment/gf_load_data_pick",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_penyelesaian_pre_payment/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sJSParam" => array("gf_bind_event_1()"),
										 "sCycleParam" => array("selReportName" => $this->input->post('selReportName', TRUE), "sTglAwal" => $this->input->post('sTglAwal', TRUE), "sTglAkhir" => $this->input->post('sTglAkhir', TRUE), "nUserId" => $this->input->post('nUserId', TRUE), "sLastStatus" => $this->input->post('sLastStatus', TRUE)),
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("No Penyusun"),
										 "sDefaultFieldSearch"  => "No Penyusun",
										 "sFieldIgnore" => array("Id Penyelesaian Pre Payment"),
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
}