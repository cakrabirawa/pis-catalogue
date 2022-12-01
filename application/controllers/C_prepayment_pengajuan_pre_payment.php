<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class c_prepayment_pengajuan_pre_payment extends CI_Controller { 
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
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_prepayment_pengajuan_pre_payment', 'm_prepayment_pengajuan_pre_payment', 'm_core_report_engine', 'm_prepayment_karyawan', 'm_prepayment_custom_rpt')); 
			$this->load->library(array('libPaging')); 
		}	
		$this->nUnitId 							= $this->session->userdata('nUnitId_fk');
		$this->data['o_page'] 			= 'backend/v_prepayment_pengajuan_pre_payment'; 
		$this->data['o_page_title'] = 'Pengajuan Pre Payment'; 
		$this->data['o_page_desc'] 	= 'Maintenance Pengajuan Pre Payment'; 
		$this->data['o_data'] 			= null;
		$this->data['o_extra']  		= $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_prepayment_pengajuan_pre_payment"));
	} 
	function gf_load_vendor_by_entity()
	{
		print json_encode(array("sOutput" => $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sIdVendor, concat(sIdVendor, ' - ', sNamaVendor) as sNamaVendor from tm_prepayment_kode_vendor where sEntity = '".trim($this->input->post('sEntity'))."' and sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "sIdVendor", "sFieldValues" => "sNamaVendor"))));		
	}
	public function index() 
	{ 
		$this->data['o_punya_anak_buah'] = $this->m_prepayment_karyawan->gf_login_punya_anak_buah();
		$this->data['o_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaUnitUsaha, nIdUnitUsaha  from tm_prepayment_unit_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." and trim(sNamaUnitUsaha) <> '' ", "sFieldId" => "nIdUnitUsaha", "sFieldValues" => "sNamaUnitUsaha"));
		$this->data['o_divisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDivisi, sNamaDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi"));
		$this->data['o_kategori_pre_payment'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriPrePayment, sNamaKategoriPrePayment  from tm_prepayment_kategori_pre_payment_h where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriPrePayment", "sFieldValues" => "sNamaKategoriPrePayment"));
		$this->data['o_ttd'] = null;
		$this->data['o_cara_bayar'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdPaymentType, sNamaPaymentType  from tm_prepayment_payment_type where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdPaymentType", "sFieldValues" => "sNamaPaymentType"));
		$this->data['o_departemen'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDepartemen, sNamaDepartemen  from tm_prepayment_departemen where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDepartemen", "sFieldValues" => "sNamaDepartemen"));
		$this->data['o_nik'] = null;
		$this->data['o_kel_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKelompokUsaha, sNamaKelompokUsaha  from tm_prepayment_kelompok_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKelompokUsaha", "sFieldValues" => "sNamaKelompokUsaha"));
		$this->data['o_kategori_trx'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriTRX, sNamaKategoriTRX from tm_prepayment_kategori_trx where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriTRX", "sFieldValues" => "sNamaKategoriTRX"));	
		$this->data['o_pembebanan'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sIdPembebanan, concat(sIdPembebanan, ' - ', sNamaPembebanan) as sNamaPembebanan from tm_prepayment_pembebanan where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "sIdPembebanan", "sFieldValues" => "sNamaPembebanan"));	
		$this->data['o_vendor'] = null;
		$this->data['o_mode'] = "I";
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	public function gf_exec() 
	{ 
		$this->data['o_data'] = $this->m_prepayment_pengajuan_pre_payment->gf_load_data(); 
		$this->data['o_punya_anak_buah'] = $this->m_prepayment_karyawan->gf_login_punya_anak_buah();
		$this->data['o_data_detail'] = $this->m_prepayment_pengajuan_pre_payment->gf_load_komponen_pre_payment(array("nIdTransaksiPrePayment" => $this->data['o_data'][0]['nIdPengajuanBS'], "nGroupUserId" => $this->data['o_data'][0]['nGroupUserId_fk'])); 
		$this->data['o_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaUnitUsaha, nIdUnitUsaha  from tm_prepayment_unit_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." and trim(sNamaUnitUsaha) <> '' ", "sFieldId" => "nIdUnitUsaha", "sFieldValues" => "sNamaUnitUsaha", "sFieldInitValue" => $this->data['o_data'][0]['nIdUnitUsaha_fk']));	
		$this->data['o_divisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDivisi, sNamaDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi", "sFieldInitValue" => $this->data['o_data'][0]['nIdDivisi_fk']));
		$this->data['o_departemen'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDepartemen, sNamaDepartemen  from tm_prepayment_departemen where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDepartemen", "sFieldValues" => "sNamaDepartemen", "sFieldInitValue" => $this->data['o_data'][0]['nIdDepartemen_fk']));
		$this->data['o_kategori_pre_payment'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriPrePayment, sNamaKategoriPrePayment  from tm_prepayment_kategori_pre_payment_h where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriPrePayment", "sFieldValues" => "sNamaKategoriPrePayment", "sFieldInitValue" => $this->data['o_data'][0]['nIdKategoriPrePayment_fk']));	
		$this->data['o_cara_bayar'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdPaymentType, sNamaPaymentType  from tm_prepayment_payment_type where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdPaymentType", "sFieldValues" => "sNamaPaymentType", "sFieldInitValue" => $this->data['o_data'][0]['nIdPaymentType_fk']));	
		$this->data['o_nik'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNIK, concat(sNIK, ' - ', sNamaKaryawan) as sNamaKaryawan  from tm_prepayment_karyawan where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." order by sNamaKaryawan", "sFieldId" => "sNIK", "sFieldValues" => "sNamaKaryawan", "sFieldInitValue" => $this->data['o_data'][0]['sNIK']));	
		$this->data['o_kel_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKelompokUsaha, sNamaKelompokUsaha  from tm_prepayment_kelompok_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKelompokUsaha", "sFieldValues" => "sNamaKelompokUsaha", "sFieldInitValue" => $this->data['o_data'][0]['nIdKelompokUsaha_fk']));		
		$this->data['o_kategori_trx'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriTRX, sNamaKategoriTRX from tm_prepayment_kategori_trx where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriTRX", "sFieldValues" => "sNamaKategoriTRX"));	
		$this->data['o_mode'] = "";
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	public function gf_exec_from_reff($sUUID) 
	{ 
		$this->data['o_data'] = $this->m_prepayment_pengajuan_pre_payment->gf_load_data_from_reff(array("sUUID" => trim($sUUID))); 
		if(count($this->data['o_data']) === 0)
		{
			//print "<h2>Invalid Data...</h2>";
			//print "<h4>Please wait to redirect to Main Page !</h4>";
			header('Refresh: 0; URL='.site_url());
			exit(0);
		} 
		$this->data['o_punya_anak_buah'] = $this->m_prepayment_karyawan->gf_login_punya_anak_buah();
		$this->data['o_data_detail'] = $this->m_prepayment_pengajuan_pre_payment->gf_load_komponen_pre_payment(array("nIdTransaksiPrePayment" => $this->data['o_data'][0]['nIdPengajuanBS'], "nGroupUserId" => $this->data['o_data'][0]['nGroupUserId_fk'])); 
		$this->data['o_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNamaUnitUsaha, nIdUnitUsaha  from tm_prepayment_unit_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." and trim(sNamaUnitUsaha) <> '' ", "sFieldId" => "nIdUnitUsaha", "sFieldValues" => "sNamaUnitUsaha", "sFieldInitValue" => $this->data['o_data'][0]['nIdUnitUsaha_fk']));	
		$this->data['o_divisi'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDivisi, sNamaDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi", "sFieldInitValue" => $this->data['o_data'][0]['nIdDivisi_fk']));
		$this->data['o_departemen'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDepartemen, sNamaDepartemen  from tm_prepayment_departemen where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdDepartemen", "sFieldValues" => "sNamaDepartemen", "sFieldInitValue" => $this->data['o_data'][0]['nIdDepartemen_fk']));
		$this->data['o_kategori_pre_payment'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriPrePayment, sNamaKategoriPrePayment  from tm_prepayment_kategori_pre_payment_h where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriPrePayment", "sFieldValues" => "sNamaKategoriPrePayment", "sFieldInitValue" => $this->data['o_data'][0]['nIdKategoriPrePayment_fk']));	
		$this->data['o_cara_bayar'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdPaymentType, sNamaPaymentType  from tm_prepayment_payment_type where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdPaymentType", "sFieldValues" => "sNamaPaymentType", "sFieldInitValue" => $this->data['o_data'][0]['nIdPaymentType_fk']));	
		$this->data['o_nik'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select sNIK, concat(sNIK, ' - ', sNamaKaryawan) as sNamaKaryawan  from tm_prepayment_karyawan where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId." order by sNamaKaryawan", "sFieldId" => "sNIK", "sFieldValues" => "sNamaKaryawan", "sFieldInitValue" => $this->data['o_data'][0]['sNIK']));	
		$this->data['o_kel_unit_usaha'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKelompokUsaha, sNamaKelompokUsaha  from tm_prepayment_kelompok_usaha where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKelompokUsaha", "sFieldValues" => "sNamaKelompokUsaha", "sFieldInitValue" => $this->data['o_data'][0]['nIdKelompokUsaha_fk']));		
		$this->data['o_kategori_trx'] = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdKategoriTRX, sNamaKategoriTRX from tm_prepayment_kategori_trx where sStatusDelete is null and nUnitId_fk = ".$this->nUnitId, "sFieldId" => "nIdKategoriTRX", "sFieldValues" => "sNamaKategoriTRX"));	
		$this->data['o_mode'] = "";
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	function gf_transact() 
	{ 
		print $this->m_prepayment_pengajuan_pre_payment->gf_transact(); 
	} 
	function gf_load_data_list_pengajuan_pre_payment_saya() 
	{ 
		$c = new libPaging(); 
		$sql = "select a.nIdPengajuanBS as `Id Transaksi Pre Payment`, a.sNoPenyusun as `No Penyusun`, a.sDeskripsi as `Deskripsi`, a.dTglPenyusun as `Tgl Penyusun`, a.sNIK as `NIK`, a.sNamaKaryawan as `Nama Karyawan`, a.sNamaUnitUsaha as `Unit Usaha`, a.sBagian as `Bagian`, a.sNamaBank as `Bank`, b.sNamaPaymentType as `Payment Type`, c.sNamaKategoriPrePayment as 	`Kategori Pre Payment`, ".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", a.nIdPengajuanBS, 'PENGAJUAN_PRE_PAYMENT', null, null, null) as `Last Status`, a.nTotalAmount as `Total Amount`  from tx_prepayment_pengajuan_pp a inner join tm_prepayment_payment_type b on b.nIdPaymentType = a.nIdPaymentType_fk inner join tm_prepayment_kategori_pre_payment_h c on c.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk where a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null and a.sMode = 'PP' ";

		if(intval($this->session->userdata('nGroupUserId_fk')) !== 0) //-- Admin Group
			$sql .= " and a.sNIK = '".$this->session->userdata('sUserName')."' ";

		$sql .= " AND (select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".trim($this->nUnitId)." and p.sPosting = '1' and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) = 0 and b.nUnitId_fk = ".$this->nUnitId." and c.nUnitId_fk = ".$this->nUnitId." and a.nUnitId_fk = ".$this->nUnitId." order by a.dCreateOn desc";
		//exit($sql);
		$sParam = array( "sSQL" => $sql,
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_pengajuan_pre_payment/gf_load_data_list_pengajuan_pre_payment_saya",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_pengajuan_pre_payment/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("No Penyusun"),
										 "sDefaultFieldSearch"  => "No Penyusun",
										 "sFieldIgnore" => array("Id Transaksi Pre Payment"),
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
	function gf_load_data_list_pengajuan_pre_payment_staff() 
	{ 
		$c = new libPaging(); 
		$nGroupUserIdAktif 	= intval($this->session->userdata('nGroupUserId_fk'));
		$sNIK 							= $this->session->userdata('sUserName');
		$sql 								= "call sp_query('select p.nGroupUserId_fk from tm_user_logins p where sStatusDelete is null and sUserName = ''".trim($sNIK)."'' ')";
		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$nGroupUserIdAktif = trim($row['nGroupUserId_fk']);
		}
		
		$nGroupUserIdAtasan 	= $nGroupUserIdAktif - 1; // Semakin kecil, semakin besar jabatan, 0 = Administrator, 7 = HRD
		$nGroupUserIdBawahan 	= $nGroupUserIdAktif + 1; // Semakin besar, semakin kecil jabatan, 0 = Administrator, 7 = HRD
		$nGroupUserIdHRD 			= 7; // Grup use HRD 
		$this->nUnitId 				= $this->session->userdata('nUnitId_fk');


		$sql = "select a.nIdPengajuanBS as `Id Transaksi Pre Payment`, a.sNoPenyusun as `No Penyusun`, a.sDeskripsi as `Deskripsi`, a.dTglPenyusun as `Tgl Penyusun`, a.sNIK as `NIK`, a.sNamaKaryawan as `Nama Karyawan`, a.sNamaUnitUsaha as `Unit Usaha`, a.sBagian as `Bagian`, a.sNamaBank as `Bank`, b.sNamaPaymentType as `Payment Type`, c.sNamaKategoriPrePayment as 	`Kategori Pre Payment`, ".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", a.nIdPengajuanBS, 'PENGAJUAN_PRE_PAYMENT', null, null, null) as `Last Status`, a.nTotalAmount as `Total Amount` from tx_prepayment_pengajuan_pp a inner join tm_prepayment_payment_type b on b.nIdPaymentType = a.nIdPaymentType_fk inner join tm_prepayment_kategori_pre_payment_h c on c.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk where a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null and a.sMode = 'PP' ";

		if(intval($this->session->userdata('nGroupUserId_fk')) !== 0) //-- Admin Group
			$sql .= " and sNIKAtasan = '".trim($this->session->userdata('sUserName'))."' ";

		$sql .= " AND (select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".trim($this->nUnitId)." and p.sPosting = '1' and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) = 0 and b.nUnitId_fk = ".$this->nUnitId." and c.nUnitId_fk = ".$this->nUnitId." and a.nUnitId_fk = ".$this->nUnitId." ";

		//-- Yang belum di Approve sama HR tetep muncul -------------------------
		//$sql .= " and (((select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = 'APPROVE' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) <> ".$nGroupUserIdHRD.") ";

		//-- Yang Sudah di submit sama bawahan ----------------------------
		//$sql .= " OR ((select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = 'SUBMIT' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = ".$nGroupUserIdBawahan.")) ";

		//-- Yang sudah di Approve sama Atasan ga muncul lagi di grid Approval atasan
		//$sql .= " and ((select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = 'SUBMIT' or (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = 'REJECT') ";

		$sql .= " order by a.dCreateOn desc";
		//print $sql;
		$sParam = array( "sSQL" => $sql,
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_pengajuan_pre_payment/gf_load_data_list_pengajuan_pre_payment_staff",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_pengajuan_pre_payment/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("No Penyusun"),
										 "sDefaultFieldSearch"  => "No Penyusun",
										 "sFieldIgnore" => array("Id Transaksi Pre Payment"),
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
	function gf_load_data_list_pengajuan_pre_payment_approval_hrd() 
	{ 
		$c = new libPaging(); 
		$this->nUnitId = $this->session->userdata('nUnitId_fk');
		$nGroupUserIdHRD = 7; // Grup use HRD 
		$nGroupUserIdFINANCE = 9; // Grup use FINANCE 
		$sql = "select a.nIdPengajuanBS as `Id Transaksi Pre Payment`, a.sNoPenyusun as `No Penyusun`, a.sDeskripsi as `Deskripsi`,  a.dTglPenyusun as `Tgl Penyusun`, a.sNIK as `NIK`, a.sNamaKaryawan as `Nama Karyawan`, a.sNamaUnitUsaha as `Unit Usaha`, a.sBagian as `Bagian`, a.sNamaBank as `Bank`, b.sNamaPaymentType as `Payment Type`, c.sNamaKategoriPrePayment as 	`Kategori Pre Payment`, ".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", a.nIdPengajuanBS, 'PENGAJUAN_PRE_PAYMENT', null, null, null) as `Last Status`, a.nTotalAmount as `Total Amount`  

			from tx_prepayment_pengajuan_pp a inner join tm_prepayment_payment_type b on b.nIdPaymentType = a.nIdPaymentType_fk inner join 
			tm_prepayment_kategori_pre_payment_h c on c.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk 

			where a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null and a.sMode = 'PP' ";


		if(intval($this->session->userdata('nGroupUserId_fk')) !== 0) //-- Admin Group
		{
			if($nGroupUserIdHRD === intval($this->session->userdata('nGroupUserId_fk')))
			{
				//-- Ambil Pre Payment yang sudah di Approve bukan oleh HR --> 7
				//$sql .= " and sNIKAtasan = '".trim($this->session->userdata('sUserName'))."' ";
				$sql .= "	and (((select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS and p.nGroupUserId_fk <> ".$nGroupUserIdHRD."  order by p.dCreateOn desc limit 1) = 'APPROVE' 
					))";
			}
			else if($nGroupUserIdFINANCE === intval($this->session->userdata('nGroupUserId_fk')))
			{
				//-- Ambil Pre Payment yang sudah di Approve oleh HR --> 7
				//$sql .= " and sNIKAtasan = '".trim($this->session->userdata('sUserName'))."' ";
				$sql .= "	and (((select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS and p.nGroupUserId_fk = ".$nGroupUserIdHRD."  order by p.dCreateOn desc limit 1) = 'APPROVE' 
					))";
			}
		}

		$sql .= " AND (select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".trim($this->nUnitId)." and p.sPosting = '1' and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) = 0 and (select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".trim($this->nUnitId)." and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) = 0 and b.nUnitId_fk = ".$this->nUnitId." and c.nUnitId_fk = ".$this->nUnitId." and a.nUnitId_fk = ".$this->nUnitId." /*and not exists (select p.nIdPengajuanBS_fk from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nIdPengajuanBS_fk = a.nIdPengajuanBS)*/
			order by a.dCreateOn desc";
		//print $sql;
		$sParam = array( "sSQL" => $sql,
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_pengajuan_pre_payment/gf_load_data_list_pengajuan_pre_payment_approval_hrd",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_pengajuan_pre_payment/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("No Penyusun"),
										 "sDefaultFieldSearch"  => "No Penyusun",
										 "sFieldIgnore" => array("Id Transaksi Pre Payment"),
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	}
	function gf_print_pengajuan_pre_payment()
	{
		$this->m_prepayment_custom_rpt->gf_report_custom_report($_REQUEST);
	}
	function gf_print_pengajuan_pre_payment_bs()
	{
		$this->m_prepayment_custom_rpt->gf_report_custom_report($_REQUEST);
	}
	function gf_load_komponen_pre_payment()
	{
		print $this->m_prepayment_pengajuan_pre_payment->gf_load_komponen_pre_payment();
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
		print $this->m_prepayment_pengajuan_pre_payment->gf_load_divisi_by_unit_usaha();
	}
	function gf_load_departemen_by_divisi()
	{
		print $this->m_prepayment_pengajuan_pre_payment->gf_load_departemen_by_divisi();
	}
	function gf_operation()
	{
		print $this->m_prepayment_pengajuan_pre_payment->gf_operation();
	}
	function gf_load_data_pick() 
	{ 
		$c = new libPaging(); 

		$nGroupUserIdAktif = intval($this->session->userdata('nGroupUserId_fk'));
		$sNIK = $this->session->userdata('sUserName');
		$nGroupUserIdHRD = 7; // Grup use HRD 
		
		$this->nUnitId = $this->session->userdata('nUnitId_fk');
		$sTglAwal = $this->input->post('sTglAwal', TRUE);
		$sTglAkhir = $this->input->post('sTglAkhir', TRUE);
		$sLastStatus = trim($this->input->post('sLastStatus', TRUE));

		$sql = "select a.nIdPengajuanBS as `Id Transaksi Pre Payment`, a.sNoPenyusun as `No Penyusun`, a.dTglPenyusun as `Tgl Penyusun`, a.sNIK as `NIK`, a.sNamaKaryawan as `Nama Karyawan`, a.sNamaUnitUsaha as `Unit Usaha`, a.sBagian as `Bagian`, a.sNamaBank as `Bank`, b.sNamaPaymentType as `Payment Type`, c.sNamaKategoriPrePayment as 	`Kategori Pre Payment`, ".$this->db->database.".gf_global_function('GetLastStatusPrePayment', ".$this->nUnitId.", a.nIdPengajuanBS, 'PENGAJUAN_PRE_PAYMENT', null, null, null) as `Last Status`, a.nTotalAmount as `Total Amount` from tx_prepayment_pengajuan_pp a inner join tm_prepayment_payment_type b on b.nIdPaymentType = a.nIdPaymentType_fk inner join tm_prepayment_kategori_pre_payment_h c on c.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk 
		where a.sStatusDelete is null and b.sStatusDelete is null and c.sStatusDelete is null and a.sMode = 'PP' ";

		if(intval($nGroupUserIdAktif) !== intval($nGroupUserIdHRD))		
			$sql .= " and (a.sNIK = '".trim($sNIK)."' or a.sNIKAtasan = '".trim($sNIK)."') ";	

		//-- Submit By Me
		if($sLastStatus === "SUBMIT_BY_ME")
		{
			$sql .= " and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = 'SUBMIT' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = ".trim($nGroupUserIdAktif);
		}
		//-- Approve Atasan
		else if($sLastStatus === "APPROVE_BY_ATASAN")
		{
			$sql .= " and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = 'APPROVE' and (select p.sNIK from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = a.sNIKAtasan ";
		}
		//-- Reject Atasan
		else if($sLastStatus === "REJECT_BY_ATASAN")
		{
			$sql .= " and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = 'REJECT' and (select p.sNIK from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = a.sNIKAtasan";
		}
		//-- Approve HRD
		else if($sLastStatus === "APPROVE_BY_HRD")
		{
			$sql .= " and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = 'APPROVE' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = ".trim($nGroupUserIdHRD);
		}
		//-- Reject HRD
		else if($sLastStatus === "REJECT_BY_HRD")
		{
			$sql .= " and (select p.sStatus from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = 'REJECT' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." And p.sTrackingMode = 'PENGAJUAN_PRE_PAYMENT' and p.nId_fk = a.nIdPengajuanBS order by p.dCreateOn desc limit 1) = ".trim($nGroupUserIdHRD);
		}

		$sql .= " and 

		/* Kalau sudah buat penyelesaian tidak di tampilkan */
		/*(select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$this->nUnitId." and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) = 0 and*/ 

		b.nUnitId_fk = ".$this->nUnitId." and c.nUnitId_fk = ".$this->nUnitId." and a.nUnitId_fk = ".$this->nUnitId." and a.dTglPenyusun between '".trim($sTglAwal)."' and '".trim($sTglAkhir)."' order by a.dCreateOn desc";

		//print $sql;

		$sParam = array( "sSQL" => $sql,
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_prepayment_pengajuan_pre_payment/gf_load_data_pick",
										 "sCallBackURLPageEditDelete" => site_url()."c_prepayment_pengajuan_pre_payment/gf_exec",
										 "sLookupEditDelete" => true,
										 "bDebugSQL" => false,
										 "sJSParam" => array("gf_bind_event()"),
										 "sCycleParam" => array("selReportName" => $this->input->post('selReportName', TRUE), "sTglAwal" => $this->input->post('sTglAwal', TRUE), "sTglAkhir" => $this->input->post('sTglAkhir', TRUE), "nUserId" => $this->input->post('nUserId', TRUE), "sLastStatus" => $this->input->post('sLastStatus', TRUE)),
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("No Penyusun"),
										 "sDefaultFieldSearch"  => "No Penyusun",
										 "sFieldIgnore" => array("Id Transaksi Pre Payment"),
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
}