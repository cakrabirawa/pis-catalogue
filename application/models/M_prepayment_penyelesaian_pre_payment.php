<?php 
class m_prepayment_penyelesaian_pre_payment extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps', 'm_core_email_engine')); 
		$this->load->library(array('libTerbilang', 'libIO'));
	} 
	function gf_load_data($sParam=null) 
	{ 
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$oParam = $_POST; 
		$sql = null;
		//---------------------------------------------
		if(array_key_exists('Id_Penyelesaian_Pre_Payment', $oParam))
		{
			$oData = $oParam['Id_Penyelesaian_Pre_Payment']; 
			$sql = "call sp_query('select a.sPosting, date_format(a.dPostingDate, ''%d-%m-%Y %H:%i:%s'') as dPostingDate, a.sPostingBy, a.nIdPenyelesaianBS, a.nIdUnitUsaha_fk, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.nIdKategoriPrePayment_fk, a.nIdPaymentType_fk, a.sNIK, a.nIdKelompokUsaha_fk, a.nIdPengajuanBS_fk as nIdPengajuanBS, h.sNoPenyusun, date_format(h.dTglPenyusun, ''%d/%m/%Y'') as dTglPenyusunX, a.sNIK, a.sNamaUnitUsaha, a.sBagian, a.sNamaBank, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, date_format(a.dTglKegiatanAwal, ''%d/%m/%Y'') as dTglKegiatanAwalX, date_format(a.dTglKegiatanAkhir, ''%d/%m/%Y'') as dTglKegiatanAkhirX, a.nIdPaymentType_fk, a.sNIKAtasan, concat(a.sNamaAtasan, '' ('', a.sNIKAtasan, '')'') as sNamaAtasan, concat(a.sNamaPenyusun) as sNamaPenyusun, a.nIdKategoriPrePayment_fk, a.dTglPenyelesaianPrePayment, date_format(a.dTglBuatPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglBuatPenyelesaianPrePaymentX, date_format(a.dTglPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglPenyelesaianPrePaymentX, a.nTotalAmount as nJumlahDanaPengajuanPrePayment, b.sNamaKelompokUsaha, d.sNamaDivisi, e.sNamaDepartemen, f.sNamaPaymentType, g.sNamaKategoriPrePayment, a.sCreateBy, h.sDeskripsi, a.sNamaKaryawan, ".$this->db->database.".gf_global_function(''GetLastStatusPrePayment'', ".$nUnitId.", a.nIdPenyelesaianBS, ''PENYELESAIAN_PRE_PAYMENT'', null, null, null) as sLastStatus, null as dCreateOnX, (select p.sGroupUserName from tm_user_groups p inner join tm_user_logins q on q.nGroupUserId_fk = p.nGroupUserId where q.sUserName = a.sNIK) as `sGroupUser`, a.nTotalBiayaTerpakai as nJumlahDanaTerpakai, a.nTotalBiayaSisa as nSisaLebihDanaTerpakai, a.sKeterangan, 

			(select q.sOriginalFileName from tm_user_uploads q where q.sGlobalReffId1 = a.sUUID and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk) as sUploadName, 

			(select q.sEncryptedFileName from  tx_prepayment_penyelesaian_pp p inner join tm_user_uploads q on q.sGlobalReffId1 = p.sUUID where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk and p.nIdPenyelesaianBS = a.nIdPenyelesaianBS) as sEncryptedFileName, 

			(select q.sUploadId from  tx_prepayment_penyelesaian_pp p inner join tm_user_uploads q on q.sGlobalReffId1 = p.sUUID where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk and p.nIdPenyelesaianBS = a.nIdPenyelesaianBS) as sUploadId, 

			(select q.sPathFile from  tx_prepayment_penyelesaian_pp p inner join tm_user_uploads q on q.sGlobalReffId1 = p.sUUID where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk and p.nIdPenyelesaianBS = a.nIdPenyelesaianBS) as sPathFile, 

			a.sUUID, a.sUUID as sUUIDPenyelesaian

		 from tx_prepayment_penyelesaian_pp a inner join tm_prepayment_kelompok_usaha b on b.nIdKelompokUsaha = a.nIdKelompokUsaha_fk inner join tm_prepayment_unit_usaha c on c.nIdUnitUsaha = a.nIdUnitUsaha_fk inner join tm_prepayment_divisi d on d.nIdDivisi = a.nIdDivisi_fk inner join tm_prepayment_departemen e on e.nIdDepartemen = a.nIdDepartemen_fk inner join tm_prepayment_payment_type f on f.nIdPaymentType = a.nIdPaymentType_fk inner join tm_prepayment_kategori_pre_payment_h g on g.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk inner join tx_prepayment_pengajuan_pp h on h.nIdPengajuanBS = a.nIdPengajuanBS_fk where h.sStatusDelete is null and h.nUnitId_fk = ".$nUnitId." and g.sStatusDelete is null and g.nUnitId_fk = ".$nUnitId." and f.sStatusDelete is null and f.nUnitId_fk = ".$nUnitId." and e.sStatusDelete is null and e.nUnitId_fk = ".$nUnitId." and d.sStatusDelete is null and d.nUnitId_fk = ".$nUnitId." and a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and c.sStatusDelete is null and c.nUnitId_fk = ".$nUnitId." and b.sStatusDelete is null and b.nUnitId_fk = ".$nUnitId." and a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.nIdPenyelesaianBS = ".trim($oData)." and a.sMode = ''PL'' ')"; 
		}
		else if(array_key_exists('Id_Pengajuan_Pre_Payment', $oParam)) 
		{
			$oData = $oParam['Id_Pengajuan_Pre_Payment']; 
			$sql = "call sp_query('select null as sPosting, a.nIdPengajuanBS, (select p.sGroupUserName from tm_user_groups p inner join tm_user_logins q on q.nGroupUserId_fk = p.nGroupUserId where q.sUserName = a.sNIK) as `sGroupUser`, a.nIdUnitUsaha_fk, ".$this->db->database.".gf_global_function(''GetLastStatusPrePayment'', ".$nUnitId.", a.nIdPengajuanBS, ''PENGAJUAN_PRE_PAYMENT'', null, null, null) as sLastStatus, a.sUUID, concat(a.sNIK, '' - '', a.sNamaKaryawan) as sNamaKaryawan, g.sNamaKategoriPrePayment, a.sNamaAtasan, f.sNamaPaymentType, e.sNamaDepartemen, d.sNamaDivisi, b.sNamaKelompokUsaha, a.sDeskripsi, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.nIdKelompokUsaha_fk, a.nIdPengajuanBS, a.sNoPenyusun, a.dTglPenyusun, date_format(a.dTglPenyusun, ''%d/%m/%Y'') as dTglPenyusunX, a.sNIK, a.sNamaUnitUsaha, a.sBagian, a.sNamaBank, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, date_format(a.dTglKegiatanAwal, ''%d/%m/%Y'') as dTglKegiatanAwalX, date_format(a.dTglKegiatanAkhir, ''%d/%m/%Y'') as dTglKegiatanAkhirX, a.nIdPaymentType_fk, a.sNIKAtasan, concat(a.sNamaAtasan, '' ('', a.sNIKAtasan, '')'') as sNamaAtasan, concat(a.sNamaPenyusun) as sNamaPenyusun, a.nIdKategoriPrePayment_fk, a.dTglPenyelesaianPrePayment, date_format(a.dTglPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglPenyelesaianPrePaymentX,a.nTotalAmount as nJumlahDanaPengajuanPrePayment, ''(AUTO)'' as nIdPenyelesaianBS, (select date_format(p.dTglPenyelesaianPrePayment, ''%d/%m/%Y'') from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) as dTglPenyelesaianPrePayment, (select p.nTotalBiayaTerpakai from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) as nJumlahDanaTerpakai, (select p.nTotalBiayaSisa from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) as nSisaLebihDanaTerpakai, (select p.sDeskripsi from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) as sKeterangan, (select q.sOriginalFileName from  tx_prepayment_penyelesaian_pp p inner join tm_user_uploads q on q.sGlobalReffId1 = p.sUUID where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) as sUploadName, (select q.sEncryptedFileName from  tx_prepayment_penyelesaian_pp p inner join tm_user_uploads q on q.sGlobalReffId1 = p.sUUID where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) as sEncryptedFileName, (select q.sUploadId from  tx_prepayment_penyelesaian_pp p inner join tm_user_uploads q on q.sGlobalReffId1 = p.sUUID where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) as sUploadId, (select q.sPathFile from  tx_prepayment_penyelesaian_pp p inner join tm_user_uploads q on q.sGlobalReffId1 = p.sUUID where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) as sPathFile, null as sUUIDPenyelesaian, (select p.sCreateBy from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) as sCreateBy, (select date_format(p.dCreateOn, ''%d/%m/%Y %H:%i:%s'') from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) as dCreateOnX

			from tx_prepayment_pengajuan_pp a inner join tm_prepayment_kelompok_usaha b on b.nIdKelompokUsaha = a.nIdKelompokUsaha_fk inner join tm_prepayment_unit_usaha c on c.nIdUnitUsaha = a.nIdUnitUsaha_fk inner join tm_prepayment_divisi d on d.nIdDivisi = a.nIdDivisi_fk inner join tm_prepayment_departemen e on e.nIdDepartemen = a.nIdDepartemen_fk inner join tm_prepayment_payment_type f on f.nIdPaymentType = a.nIdPaymentType_fk inner join tm_prepayment_kategori_pre_payment_h g on g.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk where g.sStatusDelete is null and g.nUnitId_fk = ".$nUnitId." and f.sStatusDelete is null and f.nUnitId_fk = ".$nUnitId." and e.sStatusDelete is null and e.nUnitId_fk = ".$nUnitId." and d.sStatusDelete is null and d.nUnitId_fk = ".$nUnitId." and a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and c.sStatusDelete is null and c.nUnitId_fk = ".$nUnitId." and b.sStatusDelete is null and b.nUnitId_fk = ".$nUnitId." and a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.nIdPengajuanBS = ".trim($oData)." and a.sMode = ''PP'' and a.nIdPengajuanBS not in (select p.nIdPengajuanBS_fk from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk)')"; 
		}
		//print_r($_REQUEST);
		//print "<br /><br /><br /><br /><br />";
		//print $sql;
		//exit(0);
		$rs = $this->db->query($sql); 
		return ($sParam !== null && array_key_exists("sOuputMode", $sParam) && trim($sParam['sOuputMode']) === "JSON" ? json_encode($rs->result_array()) : $rs->result_array()); 
	}
	function gf_load_data_from_reff($sParam=null) 
	{
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$oParam = $_POST; 
		$oData = $sParam === null ? $oParam['sUUID'] : $sParam['sUUID']; 
		$sql = null;
		//---------------------------------------------
		$sql = "call sp_query('select a.sPosting, date_format(a.dPostingDate, ''%d-%m-%Y %H:%i:%s'') as dPostingDate, a.sPostingBy, a.nIdPenyelesaianBS, a.nIdUnitUsaha_fk, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.nIdKategoriPrePayment_fk, a.nIdPaymentType_fk, a.sNIK, a.nIdKelompokUsaha_fk, a.nIdPengajuanBS_fk as nIdPengajuanBS, h.sNoPenyusun, date_format(h.dTglPenyusun, ''%d/%m/%Y'') as dTglPenyusunX, a.sNIK, a.sNamaUnitUsaha, a.sBagian, a.sNamaBank, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, date_format(a.dTglKegiatanAwal, ''%d/%m/%Y'') as dTglKegiatanAwalX, date_format(a.dTglKegiatanAkhir, ''%d/%m/%Y'') as dTglKegiatanAkhirX, a.nIdPaymentType_fk, a.sNIKAtasan, concat(a.sNamaAtasan, '' ('', a.sNIKAtasan, '')'') as sNamaAtasan, concat(a.sNamaPenyusun) as sNamaPenyusun, a.nIdKategoriPrePayment_fk, a.dTglPenyelesaianPrePayment, date_format(a.dTglBuatPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglBuatPenyelesaianPrePaymentX, date_format(a.dTglPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglPenyelesaianPrePaymentX, a.nTotalAmount as nJumlahDanaPengajuanPrePayment, b.sNamaKelompokUsaha, d.sNamaDivisi, e.sNamaDepartemen, f.sNamaPaymentType, g.sNamaKategoriPrePayment, a.sCreateBy, h.sDeskripsi, a.sNamaKaryawan, ".$this->db->database.".gf_global_function(''GetLastStatusPrePayment'', ".$nUnitId.", a.nIdPenyelesaianBS, ''PENYELESAIAN_PRE_PAYMENT'', null, null, null) as sLastStatus, null as dCreateOnX, (select p.sGroupUserName from tm_user_groups p inner join tm_user_logins q on q.nGroupUserId_fk = p.nGroupUserId where q.sUserName = a.sNIK) as `sGroupUser`, a.nTotalBiayaTerpakai as nJumlahDanaTerpakai, a.nTotalBiayaSisa as nSisaLebihDanaTerpakai, a.sKeterangan, 

		(select q.sOriginalFileName from tm_user_uploads q where q.sGlobalReffId1 = a.sUUID and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk) as sUploadName, 

		(select q.sEncryptedFileName from  tx_prepayment_penyelesaian_pp p inner join tm_user_uploads q on q.sGlobalReffId1 = p.sUUID where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk and p.nIdPenyelesaianBS = a.nIdPenyelesaianBS) as sEncryptedFileName, 

		(select q.sUploadId from  tx_prepayment_penyelesaian_pp p inner join tm_user_uploads q on q.sGlobalReffId1 = p.sUUID where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk and p.nIdPenyelesaianBS = a.nIdPenyelesaianBS) as sUploadId, 

		(select q.sPathFile from  tx_prepayment_penyelesaian_pp p inner join tm_user_uploads q on q.sGlobalReffId1 = p.sUUID where p.sStatusDelete is null and p.nUnitId_fk = a.nUnitId_fk and q.sStatusDelete is null and q.nUnitId_fk = a.nUnitId_fk and p.nIdPenyelesaianBS = a.nIdPenyelesaianBS) as sPathFile, 

		a.sUUID, a.sUUID as sUUIDPenyelesaian

	 from tx_prepayment_penyelesaian_pp a inner join tm_prepayment_kelompok_usaha b on b.nIdKelompokUsaha = a.nIdKelompokUsaha_fk inner join tm_prepayment_unit_usaha c on c.nIdUnitUsaha = a.nIdUnitUsaha_fk inner join tm_prepayment_divisi d on d.nIdDivisi = a.nIdDivisi_fk inner join tm_prepayment_departemen e on e.nIdDepartemen = a.nIdDepartemen_fk inner join tm_prepayment_payment_type f on f.nIdPaymentType = a.nIdPaymentType_fk inner join tm_prepayment_kategori_pre_payment_h g on g.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk inner join tx_prepayment_pengajuan_pp h on h.nIdPengajuanBS = a.nIdPengajuanBS_fk where h.sStatusDelete is null and h.nUnitId_fk = ".$nUnitId." and g.sStatusDelete is null and g.nUnitId_fk = ".$nUnitId." and f.sStatusDelete is null and f.nUnitId_fk = ".$nUnitId." and e.sStatusDelete is null and e.nUnitId_fk = ".$nUnitId." and d.sStatusDelete is null and d.nUnitId_fk = ".$nUnitId." and a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and c.sStatusDelete is null and c.nUnitId_fk = ".$nUnitId." and b.sStatusDelete is null and b.nUnitId_fk = ".$nUnitId." and a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.sUUID = ''".trim($oData)."'' and a.sMode = ''PL'' ')"; 
		$rs = $this->db->query($sql); 
		return ($sParam !== null && array_key_exists("sOuputMode", $sParam) && trim($sParam['sOuputMode']) === "JSON" ? json_encode($rs->result_array()) : $rs->result_array()); 
	}
	function gf_load_komponen_pre_payment($oParam=array())
	{
		$sReturn = null;
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$config = $this->m_core_apps->gf_read_config_apps();
		$nIdPengajuanBS = count($oParam) === 0 ? $this->input->post('nIdPengajuanBS', TRUE) : $oParam['nIdPengajuanBS'];

		//---------------------------------------------
		$sql = "call sp_query('select count(1) as c from tx_prepayment_penyelesaian_pp where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and nIdPengajuanBS_fk = ".$nIdPengajuanBS."')";
		$rs = $this->db->query($sql);
		$oCount = 0;
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$oCount = intval($row['c']);	
		}
		//---------------------------------------------

		if($oCount === 0)
		{
			$sql = "call sp_query('select null as sPosting, a.sTotalAmountTerbilang, a.nTotalAmount from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.nIdPengajuanBS = ".trim($nIdPengajuanBS)."')";
		}
		else
		{
			$sql = "call sp_query('select a.sPosting, a.sTotalBiayaTerpakaiTerbilang as sTotalAmountTerbilang, a.nTotalBiayaTerpakai as nTotalAmount from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.nIdPengajuanBS_fk = ".trim($nIdPengajuanBS)."')";
		}
		$rs = $this->db->query($sql);
		$oAmount = 0;
		$oTotalAmountTerbilang = "";
		$oPosting = null;
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$oAmount = number_format($row['nTotalAmount'], 0);
			$oTotalAmountTerbilang = trim($row['sTotalAmountTerbilang']);
			$oPosting = trim($row['sPosting']);
		}

		$sql = "call sp_query('select nIdKategoriPrePayment_fk as nIdKategoriPrePayment, nGroupUserId_fk from tx_prepayment_pengajuan_pp where sStatusDelete is null and nUnitId_fk = ".$nUnitId."');";
		$rs = $this->db->query($sql);
		$row = $rs->row_array();
		$nIdKategoriPrePayment = trim($row['nIdKategoriPrePayment']);

		/* CALCULATED KOMPONEN */
		{
			if($oCount === 0)
			{
				$sql = "call sp_query('SELECT b.nNominalDefault, b.sEditNominal as sFlagEnabledDisabledNominal, b.sQtyFromTglKegiatan as sFlagQtyFromPeriodeTglKegiatan, b.nQtyPenyesuaian, b.nPersenPotongan, b.nSubTotal, b.nQty, b.sAllowMultiply, b.sValue, b.nValue, date_format(b.dValue, ''%d/%m/%Y'') as dValue, b.sKeterangan, b.sSatuan, b.nIdKomponen_fk, b.nSeqNo, b.sTipeDataKomponen, b.sAllowSummary, a.sNamaKomponen, b.nDigit, b.nDecimalPoint, b.sLabel FROM tm_prepayment_komponen_pre_payment a INNER JOIN tx_prepayment_pengajuan_pp_komponen b ON b.nIdKomponen_fk = a.nIdKomponen WHERE b.nIdPengajuanBS_fk = ".trim($nIdPengajuanBS)." AND a.sStatusDelete IS NULL and b.sStatusDelete is null AND b.sTipeDataKomponen = ''N'' and a.nUnitId_fk = ".$nUnitId." AND b.nUnitId_fk = ".$nUnitId." ORDER BY b.nSeqNo, b.sTipeDataKomponen');";
			}
			else
				$sql = "call sp_query('SELECT b.sValue, b.nValue, date_format(b.dValue, ''%d/%m/%Y'') as dValue, b.nQty, b.nSubTotal, b.sKeterangan, b.sSatuan, b.nIdKomponen_fk, b.nSeqNo, b.sAllowMultiply, b.sTipeDataKomponen, b.sAllowSummary, a.sNamaKomponen, b.nDigit, b.nDecimalPoint, b.sLabel, b.sEditNominal as sFlagEnabledDisabledNominal, b.sQtyFromTglKegiatan as sFlagQtyFromPeriodeTglKegiatan, b.nQtyPenyesuaian, b.nPersenPotongan, b.nNominalDefault FROM 
			tm_prepayment_komponen_pre_payment a INNER JOIN tx_prepayment_penyelesaian_pp_komponen b 
			ON b.nIdKomponen_fk = a.nIdKomponen INNER JOIN tx_prepayment_penyelesaian_pp c on c.nIdPenyelesaianBS = b.nIdPenyelesaianBS_fk
			WHERE c.nIdPengajuanBS_fk = ".trim($nIdPengajuanBS)." AND a.sStatusDelete IS NULL and 
			b.sStatusDelete is null AND a.nUnitId_fk = ".$nUnitId." AND c.sStatusDelete is null AND c.nUnitId_fk = ".$nUnitId." AND 
			b.nUnitId_fk = ".$nUnitId." and b.sTipeDataKomponen = ''N''  ORDER BY b.nSeqNo, b.sTipeDataKomponen ');";			
			
			$rs = $this->db->query($sql);
			if($rs->num_rows() > 0)
			{
				$i = 1;
				$sReturn = "<table class=\"".trim($config['TABLE_CLASS'])." table-striped\">";
				$sReturn .= "<tr><td colspan=\"7\"><i class=\"fa fa-slack\"></i> Calculated Component !</td></tr>";
				$sReturn .= "<tr><td class=\"bg-danger\">No</td><td class=\"bg-danger\">Nama Komponen</td><td class=\"bg-danger\">Nilai Komponen</td><td class=\"bg-danger\">Qty</td><td class=\"bg-danger\">Sub Total</td><td class=\"bg-danger\">Keterangan</td></tr>";
				$sTipeDataKomponen = null;
				$i = 1;
				foreach($rs->result_array() as $row) 
				{
					$sReturn .= "<tr>";
					$sReturn .= "<td class=\"text-right\">".$i."</td>";
					$sReturn .= "<td>".trim($row['sNamaKomponen'])." (".$row['sSatuan'].")</td>";

					$sEnabledDisabledNominal = (trim($row['sFlagEnabledDisabledNominal']) === "0" ? "readonly" : "");
					$sQtyFromKegiatan 			 = trim($row['sFlagQtyFromPeriodeTglKegiatan']);

					if(trim($oPosting) !== "" && intval($oPosting) === 1)
					{
						if(trim($row['sTipeDataKomponen']) === "A")					
							$sReturn .= "<td>".trim($row['sValue'])."</td>";		
						else if(trim($row['sTipeDataKomponen']) === "N")		
							$sReturn .= "<td class=\"text-right\">".number_format($row['nValue'], intval($row['nDecimalPoint']))."</td>";		
						else if(trim($row['sTipeDataKomponen']) === "D")		
							$sReturn .= "<td>".trim($row['dValue'])."</td>";		
					}	
					else
					{
						$sReturn .= "<td>";
						if(trim($row['sTipeDataKomponen']) === "A")					
							$sReturn .= "<input data-toggle=\"tooltip\" data-placement=\"right\" persen-potongan=\"".$row['nPersenPotongan']."\" ".$sEnabledDisabledNominal." allow-empty=\"false\" title=\"Nilai Komponen: ".trim($row['sNamaKomponen'])."\" type=\"text\" class=\"form-control\" name=\"txtKomponen[]\" id=\"txtKomponen\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" placeholder=\"".trim($row['sNamaKomponen'])."\" value=\"".trim($row['sValue'])."\" maxlength=\"".trim($row['nDigit'])."\"/>";
						else if(trim($row['sTipeDataKomponen']) === "N")	
							$sReturn .= "<input title=\"Nilai Komponen: ".trim($row['sNamaKomponen'])."\" data-toggle=\"tooltip\" data-placement=\"right\" persen-potongan=\"".$row['nPersenPotongan']."\" ".$sEnabledDisabledNominal." allow-empty=\"false\" title=\"".trim($row['sNamaKomponen'])."\" type=\"text\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" decimalpoint=\"".trim($row['nDecimalPoint'])."\" class=\"form-control\" name=\"txtKomponen[]\" id=\"txtKomponen\" placeholder=\"".trim($row['sNamaKomponen'])."\" value=\"".trim($row['nValue'])."\" maxlength=\"".trim($row['nDigit'])."\"/>";
						else if(trim($row['sTipeDataKomponen']) === "D")		
							$sReturn .= "<div class=\"input-group date\"><input data-toggle=\"tooltip\" data-placement=\"right\" allow-empty=\"false\" title=\"Nilai Komponen: ".trim($row['sNamaKomponen'])."\" placeholder=\"".trim($row['sNamaKomponen'])."\" name=\"txtKomponen[]\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" value=\"".trim($row['dValue'])."\" id=\"txtKomponen\" type=\"text\" class=\"form-control\"><span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>
								</div>";
						$sReturn .= "</td>";
					}
					$oVisible = "";
					if(trim($row['sTipeDataKomponen']) === "D" || trim($row['sTipeDataKomponen']) === "A")
						$oVisible = "hidden";

					if(trim($oPosting) !== "" && intval($oPosting) === 1)
						$sReturn .= "<td class=\"text-right\">".number_format($row['nQty'], 0)."</td>";		
					else
					{
						$sReturn .= "<td class=\"".trim($oVisible)."\"><input qty-penyesuaian=\"".trim($row['nQtyPenyesuaian'])."\" data-toggle=\"tooltip\" data-placement=\"right\" title=\"Qty: ".trim($row['sNamaKomponen'])."\" ".(trim($sQtyFromKegiatan) === "1" ? "readonly" : "")." qty-from-kegiatan=\"".trim($sQtyFromKegiatan)."\" name=\"txtQty[]\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" decimalpoint=\"0\" maxlength=\"".trim($row['nDigit'])."\" id=\"txtQty\" placeholder=\"Qty\" value=\"".trim($row['nQty'])."\" class=\"form-control text-right ".trim($oVisible)."\">";
						$sReturn .= "</td>";
					}

					if(trim($oPosting) !== "" && intval($oPosting) === 1)
						$sReturn .= "<td class=\"text-right\">".number_format($row['nSubTotal'], 0)."</td>";		
					else
					{
						$sReturn .= "<td class=\"".trim($oVisible)."\"><input data-toggle=\"tooltip\" data-placement=\"top\" type=\"text\" class=\"form-control ".trim($oVisible)."\" disabled title=\"Sub Total ".trim($row['sNamaKomponen'])."\" name=\"txtSubTotal[]\" value=\"".trim($row['nSubTotal'])."\" id=\"txtSubTotal\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" placeholder=\"Sub Total ".trim($row['sNamaKomponen'])."\"/><input type=\"hidden\" name=\"hideSubTotal[]\" id=\"hideSubTotal\" value=\"".trim($row['nSubTotal'])."\" /></td>";
					}

					if(trim($oPosting) !== "" && intval($oPosting) === 1)
						$sReturn .= "<td>".trim($row['sKeterangan'])."</td>";		
					else
					{
						$sReturn .= "<td><input title=\"Keterangan: ".trim($row['sNamaKomponen'])."\" data-toggle=\"tooltip\" data-placement=\"right\" type=\"text\" class=\"form-control\" title=\"".trim($row['sNamaKomponen'])."\" name=\"txtKeterangan[]\" id=\"txtKeterangan\" value=\"".trim($row['sKeterangan'])."\" placeholder=\"Keterangan ".trim($row['sNamaKomponen'])."\"/></td>";
					}
					$sReturn .= "</tr><input type=\"hidden\" name=\"hideIdKomponen[]\" id=\"hideIdKomponen\" value=\"".trim($row['nIdKomponen_fk'])."\" /><input type=\"hidden\" name=\"hideTipeKomponen[]\" id=\"hideTipeKomponen\" value=\"".trim($row['sTipeDataKomponen'])."\" /><input type=\"hidden\" name=\"hidesAllowMultiply[]\" id=\"hidesAllowMultiply\" value=\"".trim($row['sAllowMultiply'])."\" /><input type=\"hidden\" name=\"hidesAllowSummary[]\" id=\"hidesAllowSummary\" value=\"".trim($row['sAllowSummary'])."\" />";
					//--------------------------------------------------------------------------------------------------------------------------------------------
					$sReturn .= "<input type=\"hidden\" name=\"hidenNominalDefault[]\" id=\"hidenNominalDefault\" value=\"".trim($row['nNominalDefault'])."\" />";
					$sReturn .= "<input type=\"hidden\" name=\"hidenEnabledDisabledNominal[]\" id=\"hidenEnabledDisabledNominal\" value=\"".trim($row['sFlagEnabledDisabledNominal'])."\" />";
					$sReturn .= "<input type=\"hidden\" name=\"hidenEnabledDisabledtyFromKegiatan[]\" id=\"hidenEnabledDisabledtyFromKegiatan\" value=\"".trim($row['sFlagQtyFromPeriodeTglKegiatan'])."\" />";
					$sReturn .= "<input type=\"hidden\" name=\"hidenQtyPenyesuaian[]\" id=\"hidenQtyPenyesuaian\" value=\"".trim($row['nQtyPenyesuaian'])."\" />";
					$sReturn .= "<input type=\"hidden\" name=\"hidenPersenPotongan[]\" id=\"hidenPersenPotongan\" value=\"".trim($row['nPersenPotongan'])."\" />";
					//--------------------------------------------------------------------------------------------------------------------------------------------
					$i++;
				}				
				$sReturn .= "<tr><td colspan=\"4\" class=\"text-right bg-danger\" style=\"text-transform: capitalize;\" id=\"tdTerbilang\">Grand Total (<b>".trim($oTotalAmountTerbilang)."</b> Rupiah)</td><td class=\"text-right bg-red\"><b><span id=\"spanGrandTotal\">".trim($oAmount)."</span></b></td><input type=\"hidden\" name=\"hideTotalAmount\" id=\"hideTotalAmount\" value=\"".trim($oAmount)."\" /><td class=\"bg-danger\"></td></tr>";
				$sReturn .= "</table>";
			}
		}

		/* NON CALCULATED KOMPONEN */
		{
			if($oCount === 0)
			{
					$sql = "call sp_query('SELECT b.nNominalDefault, b.sEditNominal as sFlagEnabledDisabledNominal, b.sQtyFromTglKegiatan as sFlagQtyFromPeriodeTglKegiatan, b.nQtyPenyesuaian, b.nPersenPotongan, b.nSubTotal, b.nQty, b.sAllowMultiply, b.sValue, b.nValue, date_format(b.dValue, ''%d/%m/%Y'') as dValue, b.sKeterangan, b.sSatuan, b.nIdKomponen_fk, b.nSeqNo, b.sTipeDataKomponen, b.sAllowSummary, a.sNamaKomponen, b.nDigit, b.nDecimalPoint, b.sLabel FROM tm_prepayment_komponen_pre_payment a INNER JOIN tx_prepayment_pengajuan_pp_komponen b ON b.nIdKomponen_fk = a.nIdKomponen WHERE b.nIdPengajuanBS_fk = ".trim($nIdPengajuanBS)." AND a.sStatusDelete IS NULL and b.sStatusDelete is null AND b.sTipeDataKomponen <> ''N'' and a.nUnitId_fk = ".$nUnitId." AND b.nUnitId_fk = ".$nUnitId." ORDER BY b.nSeqNo, b.sTipeDataKomponen');";
			}
			else
				$sql = "call sp_query('SELECT b.sValue, b.nValue, date_format(b.dValue, ''%d/%m/%Y'') as dValue, b.sKeterangan, b.sSatuan, b.nIdKomponen_fk, b.sEditNominal as sFlagEnabledDisabledNominal, b.sQtyFromTglKegiatan as sFlagQtyFromPeriodeTglKegiatan, b.nQtyPenyesuaian, b.nPersenPotongan, b.nNominalDefault, b.nSeqNo, b.sTipeDataKomponen, b.sAllowSummary, a.sNamaKomponen, b.nDigit, b.nDecimalPoint, b.sAllowMultiply, b.sTipeDataKomponen, b.sAllowSummary, b.nQty, b.nSubTotal, 
					b.sLabel 

					FROM tm_prepayment_komponen_pre_payment a INNER JOIN tx_prepayment_penyelesaian_pp_komponen b 
					ON b.nIdKomponen_fk = a.nIdKomponen INNER JOIN tx_prepayment_penyelesaian_pp c on c.nIdPenyelesaianBS = b.nIdPenyelesaianBS_fk
					WHERE c.nIdPengajuanBS_fk = ".trim($nIdPengajuanBS)." AND a.sStatusDelete IS NULL and b.sStatusDelete is null AND a.nUnitId_fk = ".$nUnitId." and c.sStatusDelete is null AND c.nUnitId_fk = ".$nUnitId." AND b.nUnitId_fk = ".$nUnitId." and b.sTipeDataKomponen <> ''N''  ORDER BY b.nSeqNo, b.sTipeDataKomponen ');";
			$rs = $this->db->query($sql);
			if($rs->num_rows() > 0)
			{
				$i = 1;
				$sReturn .= "<table class=\"".trim($config['TABLE_CLASS'])." table-striped\">";
				$sReturn .= "<tr><td colspan=\"6\"><i class=\"fa fa-automobile\"></i> Non Calculated Component !</td></tr>";
				$sReturn .= "<tr><td class=\"bg-success\">No</td><td class=\"bg-success\">Nama Komponen</td><!--<td>Tipe Data</td><td class=\"bg-success\">Satuan</td>--><td class=\"bg-success\">Nilai Komponen</td><td class=\"bg-success\">Keterangan</td></tr>";
				$sTipeDataKomponen = null;
				foreach($rs->result_array() as $row) 
				{
					$sReturn .= "<tr>";
					$sReturn .= "<td class=\"text-right\">".$i."</td>";
					$sReturn .= "<td>".trim($row['sNamaKomponen'])." (".$row['sSatuan'].")</td>";					

					$sEnabledDisabledNominal = (trim($row['sFlagEnabledDisabledNominal']) === "0" ? "readonly" : "");
					$sQtyFromKegiatan 			 = trim($row['sFlagQtyFromPeriodeTglKegiatan']);

					if(trim($oPosting) !== "" && intval($oPosting) === 1)
					{
						if(trim($row['sTipeDataKomponen']) === "A")					
							$sReturn .= "<td>".trim($row['sValue'])."</td>";		
						else if(trim($row['sTipeDataKomponen']) === "N")		
							$sReturn .= "<td class=\"text-right\">".number_format($row['nValue'], intval($row['nDecimalPoint']))."</td>";		
						else if(trim($row['sTipeDataKomponen']) === "D")		
							$sReturn .= "<td>".trim($row['dValue'])."</td>";		
					}
					else
					{
						$sReturn .= "<td>";
						if(trim($row['sTipeDataKomponen']) === "A")					
							$sReturn .= "<input persen-potongan=\"".$row['nPersenPotongan']."\" ".$sEnabledDisabledNominal." allow-empty=\"false\" title=\"".trim($row['sNamaKomponen'])."\" type=\"text\" class=\"form-control\" name=\"txtKomponen[]\" id=\"txtKomponen\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" placeholder=\"".trim($row['sNamaKomponen'])."\" value=\"".trim($row['sValue'])."\" maxlength=\"".trim($row['nDigit'])."\"/>";
						else if(trim($row['sTipeDataKomponen']) === "N")	
							$sReturn .= "<input persen-potongan=\"".$row['nPersenPotongan']."\" ".$sEnabledDisabledNominal." allow-empty=\"false\" title=\"".trim($row['sNamaKomponen'])."\" type=\"text\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" decimalpoint=\"".trim($row['nDecimalPoint'])."\" class=\"form-control\" name=\"txtKomponen[]\" id=\"txtKomponen\" placeholder=\"".trim($row['sNamaKomponen'])."\" value=\"".trim($row['nValue'])."\" maxlength=\"".trim($row['nDigit'])."\"/>";
						else if(trim($row['sTipeDataKomponen']) === "D")		
							$sReturn .= "<div class=\"input-group date\"><input allow-empty=\"false\" title=\"".trim($row['sNamaKomponen'])."\" placeholder=\"".trim($row['sNamaKomponen'])."\" name=\"txtKomponen[]\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" value=\"".trim($row['dValue'])."\" id=\"txtKomponen\" type=\"text\" class=\"form-control\"><span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>
								</div>";
						$sReturn .= "</td>";
					}
					$oVisible = "";
					if(trim($row['sTipeDataKomponen']) === "D" || trim($row['sTipeDataKomponen']) === "A")
						$oVisible = "hidden";

					if(trim($oPosting) !== "" && intval($oPosting) === 1)
					{
						$sReturn .= "<td class=\"".trim($oVisible)."\">".number_format($row['nQty'], 0)."</td>";		
					}
					else
					{
						$sReturn .= "<td class=\"".trim($oVisible)."\"><input ".(trim($sQtyFromKegiatan) === "1" ? "readonly" : "")." qty-from-kegiatan=\"".trim($sQtyFromKegiatan)."\"  qty-penyesuaian=\"".trim($row['nQtyPenyesuaian'])."\" name=\"txtQty[]\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" decimalpoint=\"0\" maxlength=\"".trim($row['nDigit'])."\" id=\"txtQty\" placeholder=\"Qty\" value=\"".trim($row['nQty'])."\" class=\"form-control text-right ".trim($oVisible)."\">";
						$sReturn .= "</td>";
					}
					if(trim($oPosting) !== "" && intval($oPosting) === 1)
					{
						$sReturn .= "<td class=\"".trim($oVisible)."\">".number_format($row['nSubTotal'], 0)."</td>";		
					}
					else
					{
						$sReturn .= "<td class=\"".trim($oVisible)."\"><input type=\"text\" class=\"form-control ".trim($oVisible)."\" disabled title=\"Sub Total ".trim($row['sNamaKomponen'])."\" name=\"txtSubTotal[]\" value=\"".trim($row['nSubTotal'])."\" id=\"txtSubTotal\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" placeholder=\"Sub Total ".trim($row['sNamaKomponen'])."\"/><input type=\"hidden\" name=\"hideSubTotal[]\" id=\"hideSubTotal\" value=\"".trim($row['nSubTotal'])."\" /></td>";
					}
					if(trim($oPosting) !== "" && intval($oPosting) === 1)
						$sReturn .= "<td>".trim($row['sKeterangan'])."</td>";		
					else
					{
						$sReturn .= "<td><input type=\"text\" class=\"form-control\" title=\"".trim($row['sNamaKomponen'])."\" name=\"txtKeterangan[]\" id=\"txtKeterangan\" value=\"".trim($row['sKeterangan'])."\" placeholder=\"Keterangan ".trim($row['sNamaKomponen'])."\"/></td>";
					}
					$sReturn .= "</tr><input type=\"hidden\" name=\"hideIdKomponen[]\" id=\"hideIdKomponen\" value=\"".trim($row['nIdKomponen_fk'])."\" /><input type=\"hidden\" name=\"hideTipeKomponen[]\" id=\"hideTipeKomponen\" value=\"".trim($row['sTipeDataKomponen'])."\" /><input type=\"hidden\" name=\"hidesAllowMultiply[]\" id=\"hidesAllowMultiply\" value=\"".trim($row['sAllowMultiply'])."\" /><input type=\"hidden\" name=\"hidesAllowSummary[]\" id=\"hidesAllowSummary\" value=\"".trim($row['sAllowSummary'])."\" />";
					//--------------------------------------------------------------------------------------------------------------------------------------------
					$sReturn .= "<input type=\"hidden\" name=\"hidenNominalDefault[]\" id=\"hidenNominalDefault\" value=\"".trim($row['nNominalDefault'])."\" />";
					$sReturn .= "<input type=\"hidden\" name=\"hidenEnabledDisabledNominal[]\" id=\"hidenEnabledDisabledNominal\" value=\"".trim($row['sFlagEnabledDisabledNominal'])."\" />";
					$sReturn .= "<input type=\"hidden\" name=\"hidenEnabledDisabledtyFromKegiatan[]\" id=\"hidenEnabledDisabledtyFromKegiatan\" value=\"".trim($row['sFlagQtyFromPeriodeTglKegiatan'])."\" />";
					$sReturn .= "<input type=\"hidden\" name=\"hidenQtyPenyesuaian[]\" id=\"hidenQtyPenyesuaian\" value=\"".trim($row['nQtyPenyesuaian'])."\" />";
					$sReturn .= "<input type=\"hidden\" name=\"hidenPersenPotongan[]\" id=\"hidenPersenPotongan\" value=\"".trim($row['nPersenPotongan'])."\" />";
					//--------------------------------------------------------------------------------------------------------------------------------------------
					$i++;
				}
				$sReturn .= "</table>";
			}
		}
		return json_encode(array("oData" => $sReturn));
	}
	function gf_transact() 
	{ 
		$hideIdPengajuanBS 									= $this->input->post('hideIdPengajuanBS', TRUE); 
		$txtIdPenyelesaianPP 								= $this->input->post('txtIdPenyelesaianPP', TRUE); 
		$txtJmlDanaTerpakai 								= $this->input->post('txtJmlDanaTerpakai', TRUE); 
		$txtJmlSisa 												= $this->input->post('txtJmlSisa', TRUE); 
		$txtKeteranganPenyelesaian 					= $this->input->post('txtKeteranganPenyelesaian', TRUE); 

		$hideMode 													= $this->input->post('hideMode', TRUE); 
		$sReturn 														= null; 
		$UUID 															= "NULL";
		$txtKeterangan        							= $this->input->post('txtKeterangan', TRUE);  
		$hideStatusRemoveFile 							= $this->input->post('hideStatusRemoveFile', TRUE);  

		$hideGlobalReffId     							= $this->input->post('hideGlobalReffId', TRUE);
		$hideNIKAtasan 											= $this->input->post('hideNIKAtasan', TRUE); 

		//--Array
		$hideFileName         							= $this->input->post('hideFileName', TRUE); 
		$hideRealFileName     							= $this->input->post('hideRealFileName', TRUE); 
		$hideFileSize     									= $this->input->post('hideFileSize', TRUE); 
		$hideFileHash         							= $this->input->post('hideFileHash', TRUE);
		$hidePath             							= $this->input->post('hidePath', TRUE); 

		//--Array
		$txtKomponen 												= $this->input->post('txtKomponen', TRUE); 
		$txtQty															= $this->input->post('txtQty', TRUE); 
		$hideSubTotal												= $this->input->post('hideSubTotal', TRUE); 		
		$txtKeterangan	        						= $this->input->post('txtKeterangan', TRUE);					
		$hideIdKomponen	                    = $this->input->post('hideIdKomponen', TRUE);
		$hideTipeKomponen                   = $this->input->post('hideTipeKomponen', TRUE);

		$hidenNominalDefault                = $this->input->post('hidenNominalDefault', TRUE);
		$hidenEnabledDisabledNominal        = $this->input->post('hidenEnabledDisabledNominal', TRUE);
		$hidenEnabledDisabledtyFromKegiatan = $this->input->post('hidenEnabledDisabledtyFromKegiatan', TRUE);
		$hidenQtyPenyesuaian                = $this->input->post('hidenQtyPenyesuaian', TRUE);
		$hidenPersenPotongan                = $this->input->post('hidenPersenPotongan', TRUE);

		$hideModeAR 												= $this->input->post('hideModeAR', TRUE);
		
		$txtTglPenyelesaiPrePayment         = $this->input->post('txtTglPenyelesaiPrePayment', TRUE);
		$txtTglKegSelesai                   = $this->input->post('txtTglKegSelesai', TRUE);
		$txtTglKegMulai                			= $this->input->post('txtTglKegMulai', TRUE);		
		
		$hidesAllowMultiply                 = $this->input->post('hidesAllowMultiply', TRUE);
		$hidesAllowSummary                  = $this->input->post('hidesAllowSummary', TRUE);
		$hideUploadId         							= $this->input->post('hideUploadId', TRUE);  
		$hideEncryptFileName  							= $this->input->post('hideEncryptFileName', TRUE);  
		$hidePathFile	 											= $this->input->post('hidePathFile', TRUE);
		$hideUUID             							= $this->input->post('hideUUID', TRUE);
		$txtTglPenyelesaianPP 							= $this->input->post('txtTglPenyelesaianPP', TRUE); 

		$sql = "call sp_query('select a.*, b.sRealName from tx_prepayment_pengajuan_pp a inner join tm_user_logins b on b.nUserId = a.nUserId_fk where a.sStatusDelete is null and b.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and a.nIdPengajuanBS = ".trim($hideIdPengajuanBS)."');";
		$rs = $this->db->query($sql);
		$row = null;
		if($rs->num_rows() > 0)
			$rowPengajuan = $rs->row_array();

		//--Kalau sudah di approve sama atasannya maka ga bisa update atau delete
		{
			$nGroupUserId = intval($this->session->userdata('nGroupUserId_fk'));
			$sql = "call sp_query('select p.nGroupUserId_fk from tm_user_logins p where sStatusDelete is null and sUserName = ''".trim($rowPengajuan['sNIK'])."'' ')";
			$rs = $this->db->query($sql);
			if($rs->num_rows() > 0)
			{
				$row = $rs->row_array();
				$nGroupUserId = trim($row['nGroupUserId_fk']);
			}
			
			$nGroupUserIdHRD = 7; // Grup use HRD 

			if(trim($txtIdPenyelesaianPP) !== "(AUTO)")
			{
				$row = json_decode($this->gf_get_latest_status_penyelesaian_pre_payment(array("IdTransaksi" => trim($txtIdPenyelesaianPP))), TRUE);
				//-- Kalau sudah di Approve sama atasannya ATAU sudah di approve sama HRD, send warning...
				//-- Yang BUAT DAN YANG APPROVE SELAIN HRD
				if(trim($hideModeAR) !== "Reject")
				{
					if(intval($this->session->userdata('nGroupUserId_fk')) !== $nGroupUserIdHRD)
					{
						if(((trim($row['sNIK']) === trim($hideNIKAtasan)) || (intval($row['nGroupUserId_fk']) === $nGroupUserIdHRD)) && trim($row['sStatus']) === "APPROVE")
						{
							$sReturn = json_encode(array("status" => -1, "message" => "No Penyusun <b>".trim($rowPengajuan['sNoPenyusun'])."</b> sudah di <b>APPROVE</b> oleh <b>".trim($row['sNama'])."</b> (".trim($row['sGroupName']).") pada <b>".trim($row['dCreateOnX'])."</b>!. <br /><br />Perubahan atau Penghapusan data tidak di izinkan. <br />Periksa kembali data Anda !")); 
							return $sReturn; 
							exit(0); 
						}
					}
					//--HRD
					else if(intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdHRD)
					{
						if(intval($row['nGroupUserId_fk']) === intval($nGroupUserIdHRD))
						{
							//-- Klo sudah Posting ga boleh di Approve lagi
							$sql = "call sp_query('select c.sGroupUserName, a.sPosting, date_format(a.dPostingDate, ''%d-%m-%Y'') as dPostingDate, a.sPostingBy from tx_prepayment_penyelesaian_pp a inner join tm_user_logins b on b.nUserId = a.nUserId_fk inner join tm_user_groups c on c.nGroupUserId = a.nGroupUserId_fk where a.sStatusDelete is null and c.sStatusDelete is null and b.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and a.nIdPenyelesaianBS = ".trim($hideIdPengajuanBS)."');";
							$rs = $this->db->query($sql);
							$row = null;
							if($rs->num_rows() > 0)
							{
								$rowPenyelesaian = $rs->row_array();
								if(intval($rowPenyelesaian['sPosting']) === 1)
								{
									$sReturn = json_encode(array("status" => -1, "message" => "No Penyusun <b>".trim($rowPengajuan['sNoPenyusun'])."</b> sudah di <b>POSTING</b> oleh <b>".trim($rowPenyelesaian['sPostingBy'])."</b> (".trim($rowPenyelesaian['sGroupUserName']).") pada <b>".trim($rowPenyelesaian['dPostingDate'])."</b>!. <br /><br />Perubahan atau Penghapusan data tidak di izinkan. <br />Periksa kembali data Anda !")); 
									return $sReturn; 
									exit(0); 
								}
							}
						}
					}
				}
				else if(trim($hideModeAR) === "Reject")
				{
					//--Klo sudah di posting ga boleh reject 
					/*
					$sql = "call sp_query('select a.nIdPenyelesaianBS, a.nIdPengajuanBS_fk, b.sRealName, date_format(a.dCreateOn, ''%d/%m/%Y %H:%i:%s'') as dCreateOn from tx_prepayment_penyelesaian_pp a inner join tm_user_logins b on b.nUserId = a.nUserId_fk where a.sStatusDelete is null and b.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and a.nIdPengajuanBS_fk = ".$UUID."');";
					$rs = $this->db->query($sql);
					if($rs->num_rows() > 0)
					{
						$row = $rs->row_array();
						if(trim($row['nIdPenebusanBS']) !== "")//HRD
						{ 
							$sReturn = json_encode(array("status" => -1, "message" => "No Penyusun <b>".trim($txtNoPenyusun)."</b> sudah di buat <b>PENYELESAIAN PRE PAYMENT</b> oleh <b>".trim($row['sRealName'])."</b> pada <b>".trim($row['dCreateOn'])."</b>!. <br /><br />Perubahan atau Penghapusan data tidak di izinkan. <br />Periksa kembali data Anda !")); 
							return $sReturn; 
							exit(0); 
						}
					}
					*/
				}	
			}
		}

		$UUID = trim($txtIdPenyelesaianPP);
		if(trim($txtIdPenyelesaianPP) === "(AUTO)") 
			$UUID	= $this->m_core_apps->gf_max_int_id(array("sFieldName" => "nIdPenyelesaianBS", "sTableName" => "tx_prepayment_penyelesaian_pp", "sParam" => " where nUnitId_fk = ".$this->session->userdata('nUnitId_fk')));

		$oUnique = md5(uniqid());
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$DS      = DIRECTORY_SEPARATOR;
		$sql     = "";

		$sql = "call sp_query('select count(1) as c from tx_prepayment_penyelesaian_pp where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and nIdPenyelesaianBS = ".trim($UUID)."');";
		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
		{
			$row1 = $rs->row_array();
			$hideMode = intval($row1['c']) > 0 ? "U" : "I";
		}

		$libTerbilang = new libTerbilang();

		$sql = "call sp_tx_prepayment_penyelesaian_pp('".trim($hideMode)."', ".trim($UUID).", '".trim($rowPengajuan['sDeskripsi'])."', '".trim($txtKeteranganPenyelesaian)."', '".trim($rowPengajuan['nIdUnitUsaha_fk'])."', 'PL', '".trim($rowPengajuan['sNoPenyusun'])."', '".trim($rowPengajuan['dTglPenyusun'])."', '".trim($rowPengajuan['sNIK'])."', '".trim($this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglKegMulai), "sSeparatorFrom" => "/", "sSeparatorTo" => "-")))."', '".trim($this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglKegSelesai), "sSeparatorFrom" => "/", "sSeparatorTo" => "-")))."', ".trim($rowPengajuan['nIdPaymentType_fk']).", '".trim($rowPengajuan['sNIKAtasan'])."', '".trim($rowPengajuan['sNamaPenyusun'])."', ".trim($rowPengajuan['nIdKategoriPrePayment_fk']).", '".trim($this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglPenyelesaiPrePayment), "sSeparatorFrom" => "/", "sSeparatorTo" => "-")))."', ".trim($rowPengajuan['nIdKelompokUsaha_fk']).", ".trim($rowPengajuan['nIdDivisi_fk']).", ".trim($rowPengajuan['nIdDepartemen_fk']).", '".(trim($hideGlobalReffId) !== "" ? trim($hideGlobalReffId) : trim($oUnique))."', ".trim($rowPengajuan['nUnitId_fk']).", '".$this->session->userdata('sRealName')."', ".trim($rowPengajuan['nUserId_fk']).", ".trim($rowPengajuan['nTotalAmount']).", '".trim($rowPengajuan['sTotalAmountTerbilang'])."', ".trim($rowPengajuan['nGroupUserId_fk']).", ".trim($rowPengajuan['nIdPengajuanBS']).", CURRENT_DATE, ".str_replace(",", "", trim($rowPengajuan['nTotalAmount'])).", ".str_replace(",", "", trim($txtJmlDanaTerpakai)).", ".str_replace(",", "", trim($txtJmlSisa)).", '".str_replace("  ", " ", trim($libTerbilang->gfRenderTerbilang(str_replace(",", "", trim($txtJmlDanaTerpakai)))))."', '".str_replace("  ", " ", trim($libTerbilang->gfRenderTerbilang(str_replace(",", "", trim($txtJmlSisa)))))."', CURRENT_DATE);";

		$sql .= "call sp_tx_prepayment_penyelesaian_pp_komponen('D', ".$UUID.", NULL, NULL, NULL, NULL, NULL, NULL, ".$this->session->userdata('nUnitId_fk').", NULL, '".trim($this->session->userdata('sRealName'))."', NULL, NULL, NULL, NULL, NULL, NULL, NULL);";


		if(trim($hideMode) !== "D")
		{
			for($i=0; $i<count($hideIdKomponen); $i++)
			{
				$sql .= "call sp_tx_prepayment_penyelesaian_pp_komponen('I', 
				".$UUID.", 
				'".trim($hideIdKomponen[$i])."', 
				'".trim($txtKeterangan[$i])."', 
				".(trim($hideTipeKomponen[$i]) === "A" ? "'".trim($txtKomponen[$i])."'" : "NULL").", 
				".(trim($hideTipeKomponen[$i]) === "N" ? str_replace(",", "", $txtKomponen[$i]) : "NULL").", 
				".(trim($hideTipeKomponen[$i]) === "D" ? "'".$this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtKomponen[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))."'" : "NULL").", 
				null, 
				".$this->session->userdata('nUnitId_fk').", 
				".($i+1).", 
				'".trim($this->session->userdata('sRealName'))."', 
				".str_replace(",", "", (in_array(trim($hideTipeKomponen[$i]), array("A", "D")) ? "null" : trim($txtQty[$i]))).", 
				".str_replace(",", "", (in_array(trim($hideTipeKomponen[$i]), array("A", "D")) ? "null" : (trim($hideSubTotal[$i]) === "" ? "null" : trim($hideSubTotal[$i])))).", 
				".str_replace(",", "", trim($hidenNominalDefault[$i])).", 
				'".trim($hidenEnabledDisabledNominal[$i])."', 
				'".trim($hidenEnabledDisabledtyFromKegiatan[$i])."', 
				".str_replace(",", "", trim($hidenQtyPenyesuaian[$i])).", 
				".str_replace(",", "", trim($hidenPersenPotongan[$i])).");";
			}
		}

		if(!empty($hideStatusRemoveFile) && intval($hideStatusRemoveFile) === 1)
		{
			$s = "call sp_query('select * from tm_user_uploads where sUploadId = ''".trim($hideGlobalReffId)."'' and sStatusDelete is null');";
			$r = $this->db->query($s)->row_array();
			$sFileName = getcwd().$DS."uploads".$DS."evidence".$DS.trim($r['sEncryptedFileName']);
			if(file_exists($sFileName))
				unlink($sFileName);

			$sql .= "call sp_query('update tm_user_uploads set sStatusDelete= ''V'', sDeleteBy = ''".trim($this->session->userdata('sRealName'))."'', dDeleteOn = CURRENT_TIMESTAMP where sStatusDelete is null and sUploadId = ''".trim($hideGlobalReffId)."'' ');";
		}

		if(count($hideFileName) > 0)
		{
			for($i=0; $i<count($hideFileName); $i++)
			{
				$ext = explode(".", trim($hideFileName[$i]));
				$ext = $ext[count(explode(".", trim($hideFileName[$i]))) - 1];
				$sql .= "call sp_tm_user_uploads('I', '".(trim($txtIdPenyelesaianPP) === "(AUTO)" ? trim($oUnique) : trim($hideGlobalReffId))."', '".trim($hideRealFileName[$i])."', '".trim($hideFileName[$i])."', '".trim($ext)."', '".trim($oConfig['UPLOAD_DIR'])."/".trim($hidePath)."', ".trim($hideFileSize[$i]).", ".$this->session->userdata('nUserId').", '".(trim($txtIdPenyelesaianPP) === "(AUTO)" ? trim($oUnique) : trim($hideGlobalReffId))."', null, null, null, ".$this->session->userdata('nUnitId_fk').", null, '".trim($this->session->userdata('sRealName'))."');";
			}
		}

		if(trim($hideModeAR) === "")
			$sql .= "call sp_tx_prepayment_tracking('I', ".trim($UUID).", '".trim($rowPengajuan['sNIK'])."', '".trim($rowPengajuan['sRealName'])."', 'PENYELESAIAN_PRE_PAYMENT', ".trim($rowPengajuan['nGroupUserId_fk']).", 'AUTO SUBMIT', 'SUBMIT', null, ".$this->session->userdata('nUnitId_fk').", '".$this->session->userdata('sRealName')."')";

		//exit($sql);

		$this->db->trans_begin(); 
		$this->db->query($sql); 
		if ($this->db->trans_status() === FALSE) 
		{ 
			$this->db->trans_rollback(); 
			$sReturn = json_encode(array("status" => -1, "message" => "Failed")); 
		} 
		else 
		{ 
			$this->db->trans_commit(); 			
			$sReturn = json_encode(array("status" => 1, "message" => "Data has been Submitted.")); 
			//return ($sReturn);
			//exit(0);
			if(trim($hideModeAR) !== "Approve" && trim($hideModeAR) !== "Reject")
			{
				//-- Send Notification via Email //------------------------------------------------------------------------------------
				$oDataKaryawan = json_decode($this->m_prepayment_karyawan->gf_get_info_karyawan(array("sNIK" => trim($rowPengajuan['sNIKAtasan']))), TRUE);
				$sEmailTo = trim($oDataKaryawan['sEmail']);
				$sNoHPTo = trim($oDataKaryawan['sNoHP']);
				//$sEmailTo = "labirin69@gmail.com";
				//$sNoHPTo = "081382322951";
				//-- Load Email Template
				$SP 					 = DIRECTORY_SEPARATOR;
				$oPath 				 = getcwd().$SP."emails".$SP."penyelesaian_pre_payment.eml";
				$libIO 				 = new libIO();
				$sData 				 = $libIO->gf_read_file(array("path" => $oPath));
				$sData 				 = json_decode($sData, TRUE);
	  		$oSQL     		 = trim($sData['txtNativeSQL']);
				$oSQL 				 = str_replace("@nIdPenyelesaianBS", $UUID, $oSQL);
	  		$oConvert 		 = $this->m_core_email_engine->gf_convert_rpt_engine(array("content" => trim($sData['txtNativeHTML']), "sql" => $oSQL));
				//--
				$sEmailMessage = $oConvert;
				$sEmailSubject = date('d-m-Y H:i:s')." | Pre Payment Notification | Penyelesaian Pre Payment | Approval Needed";		
				//--
				$oConfig = $this->m_core_apps->gf_read_config_apps();
				if(trim($oConfig['NOTIF_TO_EMAIL']) === "TRUE")
					$this->m_core_apps->gf_send_email_x(array("sFromName" => "Gramedia Prepayment Application", "sEmail" => trim($sEmailTo), "sEmailSubject" => trim($sEmailSubject), "sEmailMessage" => trim($sEmailMessage)));
		  	//---------------------------------------------------------------------------------------------------------------------
		  	// Send Whatsapp
				if(trim($oConfig['NOTIF_TO_WHATSAPP']) === "TRUE")
			  {
			  	$SQL = "call sp_query('SELECT a.sUUID as sUUIDX, c.sEmail as sEmailPengirim, d.sEmail as sEmailPenerima, a.*, concat(''@siteurl'', ''c_prepayment_pengajuan_pre_payment'') as host, format(nTotalAmount, 0) as nTotalAmountX, date_format(dTglPenyusun, ''%d-%m-%Y'') as dTglPenyusunX, date_format(current_timestamp, ''%d-%m-%Y %H:%i:%s'') as c, b.sNamaKategoriPrePayment, date_format(a.dTglKegiatanAwal, ''%d-%m-%Y'') as dTglKegiatanAwalX, date_format(a.dTglKegiatanAkhir, ''%d-%m-%Y'') as dTglKegiatanAkhirX, __dbname__.gf_global_function(''GetLastStatusPrePayment'', @unit, a.nIdPengajuanBS_fk, ''PENGAJUAN_PRE_PAYMENT'', null, null, null) as sLastStatus, a.nTotalBiayaPengajuan, a.nTotalBiayaTerpakai, a.nTotalBiayaSisa FROM tx_prepayment_penyelesaian_pp a inner join tm_prepayment_kategori_pre_payment_h b on b.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk inner join tm_prepayment_karyawan c on c.sNIK = a.sNIK inner join tm_prepayment_karyawan d on d.sNIK = a.sNIKAtasan where a.sStatusDelete is null and a.nUnitId_fk = @unit and c.sStatusDelete is null and c.nUnitId_fk = @unit and b.sStatusDelete is null and b.nUnitId_fk = @unit and nIdPenyelesaianBS = ".trim($UUID)."')";
			  	$SQL = str_replace("@unit", $this->session->userdata('nUnitId_fk'), $SQL);
			  	$SQL = str_replace("@siteurl", site_url(), $SQL);
			  	$SQL = str_replace("__dbname__", $this->db->database, $SQL);
			  	$rs = $this->db->query($SQL);
			  	$row = $rs->row_array();
					$NEWLINE = "\\r\\n";
			  	//------------------------------------------------
			  	$BASE_URL = trim($oConfig['WHATSAPP_BASE_URL_CRUD_PENYELESAIAN']);
			  	//------------------------------------------------
			  	$sWAMessage = "YTH *".trim($row['sNamaAtasan'])."*, ".trim($NEWLINE).trim($NEWLINE)."Ada Penyelesaian Pre Payment yang membutuhkan Approval Bapak/Ibu. Sebagai informasi, *".trim($row['sNamaKaryawan'])."* telah menyelesaikan Pre Payment, berikut informasinya: ".trim($NEWLINE).trim($NEWLINE)."No. Penyusun: *".trim($row['sNoPenyusun'])."*".trim($NEWLINE)."Kategori Pre Payment: *".trim($row['sNamaKategoriPrePayment'])."* ".trim($NEWLINE)."Tgl Kegiatan: *".trim($row['dTglKegiatanAwalX'])."* s/d *".trim($row['dTglKegiatanAkhirX'])."* ".trim($NEWLINE)."Keperluan: *".trim($row['sDeskripsi'])."*".trim($NEWLINE)."Nominal Pengajuan: Rp. *".number_format($row['nTotalBiayaPengajuan'], 0)."* ".trim($NEWLINE)."Nominal Terpakai: Rp. *".number_format($row['nTotalBiayaTerpakai'], 0)."*".trim($NEWLINE)."Sisa/Lebih Nominal: Rp. *".number_format($row['nTotalBiayaSisa'], 0)."* ".trim($NEWLINE).trim($NEWLINE)."Mohon segera ditindaklanjuti dengan memberikan keputusan baik itu *Approve* atau *Reject* di Aplikasi Pre Payment. Untuk masuk ke Aplikasi silahkan klik link berikut: ".trim($NEWLINE).trim($NEWLINE).trim($BASE_URL).trim($row['sUUIDX']);
			  	//------------------------------------------------
					$this->m_core_apps->gf_send_wa(array("sNoHP" => trim($sNoHPTo), "sWAMessage" => trim($sWAMessage)));
				}
		  }
		} 
		return $sReturn; 
	}
	function gf_operation()
	{
		$sReturn 							= null;
		$hideStatus 					= $this->input->post('hideStatus', TRUE);
		$hideIdPenyelesaianBS = $this->input->post('hideIdPenyelesaianBS', TRUE);
		$hideNotes 						= $this->input->post('hideNotes', TRUE);
		$hideNIKAtasan 				= $this->session->userdata('sUserName'); //$this->input->post('hideNIKAtasan', TRUE);
		$hideTrackingMode 		= $this->input->post('hideTrackingMode', TRUE);		
		$hideStatusLock       = $this->input->post('hideStatusLock', TRUE);		

		//-- Ambil grup user yang bikin pre payment
		$nGroupUserId = intval($this->session->userdata('nGroupUserId_fk'));
		$sql = "call sp_query('select p.nGroupUserId_fk from tm_user_logins p inner join tx_prepayment_penyelesaian_pp q on q.sNIK = p.sUserName where p.sStatusDelete is null and q.nIdPenyelesaianBS = ".trim($hideIdPenyelesaianBS)."')";
		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$nGroupUserId = trim($row['nGroupUserId_fk']);
		}
		
		$nGroupUserIdAtasan = $nGroupUserId - 1; // Semakin kecil, semakin besar jabatan, 0 = Administrator, 7 = HRD
		$nGroupUserIdHRD = 7; // Grup use HRD 

		$sNoPenyusun = null;
		$sql = "call sp_query('select sNoPenyusun from tx_prepayment_penyelesaian_pp where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and nIdPenyelesaianBS = ".trim($hideIdPenyelesaianBS)."')";
		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$sNoPenyusun = $row['sNoPenyusun'];
		}

		$row = json_decode($this->gf_get_latest_status_penyelesaian_pre_payment(array("IdTransaksi" => trim($hideIdPenyelesaianBS))), TRUE);
		if($hideTrackingMode === "Approve")
		{
			//-- Kalau sudah di Approve sama atasannya ATAU sudah di approve sama HRD, send warning...
			//-- Yang BUAT DAN YANG APPROVE SELAIN HRD
			if(intval($this->session->userdata('nGroupUserId_fk')) !== $nGroupUserIdHRD)
			{
				//-- Klo sudah di Approve HRD ga bisa ubah
				if(intval($row['nGroupUserId_fk']) === $nGroupUserIdHRD && trim($row['sStatus']) === "APPROVE")
				{
					$sReturn = json_encode(array("status" => -1, "message" => "No Penyusun <b>".trim($sNoPenyusun)."</b> sudah di <b>APPROVE</b> oleh <b>".trim($row['sNama'])."</b> (".trim($row['sGroupName']).") pada <b>".trim($row['dCreateOnX'])."</b>!. <br /><br />Perubahan atau Penghapusan data tidak di izinkan. <br />Periksa kembali data Anda !")); 
					return $sReturn; 
					exit(0); 
				}
			}
			//--HRD
			else if(intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdHRD)
			{
				if(intval($row['nGroupUserId_fk']) === intval($nGroupUserIdHRD) && trim($row['sStatus']) === "APPROVE")
				{
					$sReturn = json_encode(array("status" => -1, "message" => "No Penyusun <b>".trim($sNoPenyusun)."</b> sudah di <b>APPROVE</b> oleh <b>".trim($row['sNama'])."</b> (".trim($row['sGroupName']).") pada <b>".trim($row['dCreateOnX'])."</b>!. <br /><br />Perubahan atau Penghapusan data tidak di izinkan. <br />Periksa kembali data Anda !")); 
					return $sReturn; 
					exit(0); 
				}
			}
		}

		//--End
		$sql = "call sp_tx_prepayment_tracking('I', ".trim($hideIdPenyelesaianBS).", '".trim($hideNIKAtasan)."', '".$this->session->userdata('sRealName')."', '".trim($hideTrackingMode)."', ".$this->session->userdata('nGroupUserId_fk').", '".str_replace("'", "''", trim($hideNotes))."', '".trim($hideStatus)."', null, ".$this->session->userdata('nUnitId_fk').", '".$this->session->userdata('sRealName')."');";
		if(trim($hideStatusLock) !== "" && intval($hideStatusLock) === 1)
		{
			$sql .= "call sp_query('update tx_prepayment_penyelesaian_pp set sPosting = ''1'', dPostingDate = CURRENT_TIMESTAMP, sPostingBy = ''".$this->session->userdata('sRealName')."'' where nIdPenyelesaianBS = ".trim($hideIdPenyelesaianBS)." and (sPosting is null or sPosting = ''0'') ');";
		}
		$this->db->trans_begin(); 
		$this->db->query($sql); 
		if ($this->db->trans_status() === FALSE) 
		{ 
			$this->db->trans_rollback(); 
			$sReturn = json_encode(array("status" => -1, "message" => "Failed")); 
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			$sReturn = json_encode(array("status" => 1, "message" => "Data has been Submitted.")); 
			$oConfig = $this->m_core_apps->gf_read_config_apps();
			//-- Send Notification via Email //------------------------------------------------------------------------------------
			$sql = "call sp_query('select sNIK, sNIKAtasan from tx_prepayment_penyelesaian_pp where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and nIdPenyelesaianBS = ".trim($hideIdPenyelesaianBS)."')";
			$rs = $this->db->query($sql);
			$row = $rs->row_array();

			$oDataKaryawan = json_decode($this->m_prepayment_karyawan->gf_get_info_karyawan(array("sNIK" => trim($row['sNIK']))), TRUE);
			$sEmailFrom = trim($oDataKaryawan['sEmail']);
			$sNoHPFrom = trim($oDataKaryawan['sNoHP']);
			//$sEmailFrom = "labirin69@gmail.com";
			//$sNoHPFrom = "081382322951";
			$oDataKaryawan = json_decode($this->m_prepayment_karyawan->gf_get_info_karyawan(array("sNIK" => trim($row['sNIKAtasan']))), TRUE);
			$sEmailTo = trim($oDataKaryawan['sEmail']);
			$sNoHPTo = trim($oDataKaryawan['sNoHP']);
			//$sEmailTo = "labirin69@gmail.com";
			//$sNoHPTo = "081382322951";

			//-- Load Email Template
			$SP 					 = DIRECTORY_SEPARATOR;
			$oPath 				 = getcwd().$SP."emails".$SP."approval_penyelesaian_pre_payment.eml";
			$libIO 				 = new libIO();
			$sData 				 = $libIO->gf_read_file(array("path" => $oPath));
			$sData 				 = json_decode($sData, TRUE);
  		$oSQL     		 = trim($sData['txtNativeSQL']);
			$oSQL 				 = str_replace("@nIdPenyelesaianBS", trim($hideIdPenyelesaianBS), $oSQL);
  		$oConvert 		 = $this->m_core_email_engine->gf_convert_rpt_engine(array("content" => trim($sData['txtNativeHTML']), "sql" => $oSQL));
			//--
			$sEmailMessage = $oConvert;
			$sEmailSubject = date('d-m-Y H:i:s')." | Pre Payment Notification | Penyelesaian Pre Payment | Approval Needed";		
			//--
			if(trim($oConfig['NOTIF_TO_EMAIL']) === "TRUE")
			{
		  	/*$this->m_core_apps->gf_send_email(
		  		array(
		  			"sTO" => array(trim($sEmailFrom)), 
		  			"sSenderName" => "GRAMEDIA Prepayment Application", 
		  			"sMessage" => $sEmailMessage, 
		  			"sSubject" => $sEmailSubject));*/
				$this->m_core_apps->gf_send_email_x(array("sFromName" => "Gramedia Prepayment Application", "sEmail" => trim($sEmailFrom), "sEmailSubject" => trim($sEmailSubject), "sEmailMessage" => trim($sEmailMessage)));
		  	//-- Kirim Email ke Atasan kalau Reject dari HRD
		  	if(intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdHRD)
		  	{
		  		$oPath 				 = getcwd().$SP."emails".$SP."approval_penyelesaian_pre_payment_for_atasan.eml";
					$libIO 				 = new libIO();
					$sData 				 = $libIO->gf_read_file(array("path" => $oPath));
					$sData 				 = json_decode($sData, TRUE);
		  		$oSQL     		 = trim($sData['txtNativeSQL']);
					$oSQL 				 = str_replace("@nIdPenyelesaianBS", trim($hideIdPenyelesaianBS), $oSQL);
		  		$oConvert 		 = $this->m_core_email_engine->gf_convert_rpt_engine(array("content" => trim($sData['txtNativeHTML']), "sql" => $oSQL));
					$sEmailMessage = $oConvert;
			  	/*$this->m_core_apps->gf_send_email(
			  		array(
			  			"sTO" => array(trim($sEmailTo)), 
			  			"sSenderName" => "GRAMEDIA Prepayment Application", 
			  			"sMessage" => $sEmailMessage, 
			  			"sSubject" => $sEmailSubject));*/
					$this->m_core_apps->gf_send_email_x(array("sFromName" => "Gramedia Prepayment Application", "sEmail" => trim($sEmailTo), "sEmailSubject" => trim($sEmailSubject), "sEmailMessage" => trim($sEmailMessage)));
		  	}
		  	//-- Kirim Email ke Semua Orang HRD kalau Approve dari atasan, email nya dari Master Karyawan..
		  	if(strtoupper(trim($hideStatus)) === "APPROVE" && intval($this->session->userdata('nGroupUserId_fk')) <> $nGroupUserIdHRD)
		  	{
		  		//-- Load Email Template
					$oPath 				 = getcwd().$SP."emails".$SP."approval_penyelesaian_pre_payment_for_hrd.eml";
					$libIO 				 = new libIO();
					$sData 				 = $libIO->gf_read_file(array("path" => $oPath));
					$sData 				 = json_decode($sData, TRUE);
		  		$oSQL     		 = trim($sData['txtNativeSQL']);
					$oSQL 				 = str_replace("@nIdPenyelesaianBS", trim($hideIdPenyelesaianBS), $oSQL);
		  		$oConvert 		 = $this->m_core_email_engine->gf_convert_rpt_engine(array("content" => trim($sData['txtNativeHTML']), "sql" => $oSQL));
					//--
					$sEmailMessage = $oConvert;
			  	$SQL = "call sp_query('select a.sNamaKaryawan, a.sEmail from tm_prepayment_karyawan a inner join tm_user_logins b on b.sUserName = a.sNIK where a.sStatusDelete is null and b.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and b.nGroupUserId_fk = ".$nGroupUserIdHRD."');";			
			  	$rs1 = $this->db->query($SQL);
			  	if($rs1->num_rows() > 0)
			  	{
			  		foreach($rs1->result_array() as $row1)
			  		{
					  	/*$this->m_core_apps->gf_send_email(
				  		array(
				  			"sTO" => array(trim($row1['sEmail'])), 
				  			"sSenderName" => "GRAMEDIA Prepayment Application", 
				  			"sMessage" => str_replace("[sNamaKaryawanHRD]", trim($row1['sNamaKaryawan']), $sEmailMessage), 
				  			"sSubject" => $sEmailSubject));*/
							$this->m_core_apps->gf_send_email_x(array("sFromName" => "Gramedia Prepayment Application", "sEmail" => trim($row1['sEmail']), "sEmailSubject" => trim($sEmailSubject), "sEmailMessage" => str_replace("[sNamaKaryawanHRD]", trim($row1['sNamaKaryawan']), $sEmailMessage)));
			  		}
			  	}
			  }
			}
	  	//---------------------------------------------------------------------------------------------------------------------
	  	// Send Whatsapp
			if(trim($oConfig['NOTIF_TO_WHATSAPP']) === "TRUE")
		  {
		  	$SQL = "call sp_query('SELECT a.sUUID as sUUIDX, c.sEmail as sEmailPengirim, d.sEmail as sEmailPenerima, a.*, concat(''@siteurl'', ''c_prepayment_pengajuan_pre_payment'') as host, format(nTotalAmount, 0) as nTotalAmountX, date_format(dTglPenyusun, ''%d-%m-%Y'') as dTglPenyusunX, date_format(current_timestamp, ''%d-%m-%Y %H:%i:%s'') as c, b.sNamaKategoriPrePayment, date_format(a.dTglKegiatanAwal, ''%d-%m-%Y'') as dTglKegiatanAwalX, date_format(a.dTglKegiatanAkhir, ''%d-%m-%Y'') as dTglKegiatanAkhirX, __dbname__.gf_global_function(''GetLastStatusPrePayment'', @unit, a.nIdPenyelesaianBS, ''PENYELESAIAN_PRE_PAYMENT'', null, null, null) as sLastStatus FROM tx_prepayment_penyelesaian_pp a inner join tm_prepayment_kategori_pre_payment_h b on b.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk inner join tm_prepayment_karyawan c on c.sNIK = a.sNIK inner join tm_prepayment_karyawan d on d.sNIK = a.sNIKAtasan where a.sStatusDelete is null and a.nUnitId_fk = @unit and c.sStatusDelete is null and c.nUnitId_fk = @unit and b.sStatusDelete is null and b.nUnitId_fk = @unit and a.nIdPenyelesaianBS = ".trim($hideIdPenyelesaianBS)."')";
		  	$SQL = str_replace("@unit", $this->session->userdata('nUnitId_fk'), $SQL);
		  	$SQL = str_replace("@siteurl", site_url(), $SQL);
		  	$SQL = str_replace("__dbname__", $this->db->database, $SQL);
		  	$rs = $this->db->query($SQL);
		  	$row = $rs->row_array();
		  	$NEWLINE = "\\r\\n";
		  	//------------------------------------------------
		  	$BASE_URL = trim($oConfig['WHATSAPP_BASE_URL_CRUD_PENGAJUAN']);
		  	//------------------------------------------------
		  	$s = str_replace(array("<b><u>", "</u></b>"), array("*", "*"), $row['sLastStatus']);
		  	$s = str_replace(array("<b>", "</b>", "<br />"), array("*", "*", $NEWLINE), $s);
		  	$sWAMessage = "YTH *".trim($row['sNamaKaryawan'])."*, ".trim($NEWLINE).trim($NEWLINE)."Penyelesaian Pre Payment Bapak/Ibu sbb:".trim($NEWLINE).trim($NEWLINE)."No. Penyusun: *".trim($row['sNoPenyusun'])."*".trim($NEWLINE)."Kategori Pre Payment: *".trim($row['sNamaKategoriPrePayment'])."* ".trim($NEWLINE)."Tgl Kegiatan: *".trim($row['dTglKegiatanAwalX'])."* s/d *".trim($row['dTglKegiatanAkhirX'])."* ".trim($NEWLINE)."Keperluan: *".trim($row['sDeskripsi'])."*".trim($NEWLINE)."Nominal Pengajuan: Rp. *".number_format($row['nTotalBiayaPengajuan'], 0)."* ".trim($NEWLINE)."Nominal Terpakai: Rp. *".number_format($row['nTotalBiayaTerpakai'], 0)."* ".trim($NEWLINE)."Nominal Kurang/Lebih: Rp. *".number_format($row['nTotalBiayaSisa'], 0)."* ".trim($NEWLINE).trim($NEWLINE)."sudah di *".strtoupper(trim($hideStatus))."*. berikut detail nya:".trim($NEWLINE).$s.trim($NEWLINE).trim($NEWLINE)."Untuk masuk ke Aplikasi silahkan klik link berikut: ".trim($NEWLINE).trim($NEWLINE).trim($BASE_URL).trim($row['sUUIDX']);
		  	//------------------------------------------------
				$this->m_core_apps->gf_send_wa(array("sNoHP" => trim($sNoHPFrom), "sWAMessage" => trim($sWAMessage)));
			  //-- Kirim Email ke Atasan kalau Reject dari HRD
		  	if(intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdHRD)
		  	{
		  		$sWAMessage = "YTH *".trim($row['sNamaAtasan'])."*, ".trim($NEWLINE).trim($NEWLINE)."Penyelesaian Pre Payment Bapak/Ibu *".trim($row['sNamaKaryawan'])."* sbb:".trim($NEWLINE).trim($NEWLINE)."No. Penyusun: *".trim($row['sNoPenyusun'])."*".trim($NEWLINE)."Kategori Pre Payment: *".trim($row['sNamaKategoriPrePayment'])."* ".trim($NEWLINE)."Tgl Kegiatan: *".trim($row['dTglKegiatanAwalX'])."* s/d *".trim($row['dTglKegiatanAkhirX'])."* ".trim($NEWLINE)."Keperluan: *".trim($row['sDeskripsi'])."*".trim($NEWLINE)."Nominal Pengajuan: Rp. *".number_format($row['nTotalBiayaPengajuan'], 0)."* ".trim($NEWLINE)."Nominal Terpakai: Rp. *".number_format($row['nTotalBiayaTerpakai'], 0)."* ".trim($NEWLINE)."Nominal Kurang/Lebih: Rp. *".number_format($row['nTotalBiayaSisa'], 0)."* ".trim($NEWLINE).trim($NEWLINE)."sudah di *".strtoupper(trim($hideStatus))."*. berikut detail nya:".trim($NEWLINE).$s.trim($NEWLINE).trim($NEWLINE)."Untuk masuk ke Aplikasi silahkan klik link berikut: ".trim($NEWLINE).trim($NEWLINE).trim($BASE_URL).trim($row['sUUIDX']);
					$this->m_core_apps->gf_send_wa(array("sNoHP" => trim($sNoHPTo), "sWAMessage" => trim($sWAMessage)));
		  	}
		  	//-- Kirim Email ke Semua Orang HRD kalau Approve dari atasan, email nya dari Master Karyawan..
		  	if(strtoupper(trim($hideStatus)) === "APPROVE" && intval($this->session->userdata('nGroupUserId_fk')) <> $nGroupUserIdHRD)
		  	{
			  	//-- Kirim Email ke Semua Orang HRD kalau Approve dari atasan, email nya dari Master Karyawan..
			  	$SQL = "call sp_query('select a.sNoHP, a.sNamaKaryawan, a.sEmail from tm_prepayment_karyawan a inner join tm_user_logins b on b.sUserName = a.sNIK where a.sStatusDelete is null and b.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and b.nGroupUserId_fk = ".$nGroupUserIdHRD."');";			
			  	$rs1 = $this->db->query($SQL);
			  	if($rs1->num_rows() > 0)
			  	{
			  		foreach($rs1->result_array() as $row1)
			  		{
			  			$sWAMessage = "YTH *".trim($row1['sNamaKaryawan'])."*, ".trim($NEWLINE).trim($NEWLINE)."Penyelesaian Pre Payment *".trim($row['sNamaKaryawan'])."* sbb:".trim($NEWLINE).trim($NEWLINE)."No. Penyusun: *".trim($row['sNoPenyusun'])."*".trim($NEWLINE)."Kategori Pre Payment: *".trim($row['sNamaKategoriPrePayment'])."* ".trim($NEWLINE)."Tgl Kegiatan: *".trim($row['dTglKegiatanAwalX'])."* s/d *".trim($row['dTglKegiatanAkhirX'])."* ".trim($NEWLINE)."Keperluan: *".trim($row['sDeskripsi'])."*".trim($NEWLINE)."Nominal Pengajuan: Rp. *".number_format($row['nTotalBiayaPengajuan'], 0)."* ".trim($NEWLINE)."Nominal Terpakai: Rp. *".number_format($row['nTotalBiayaTerpakai'], 0)."* ".trim($NEWLINE)."Nominal Kurang/Lebih: Rp. *".number_format($row['nTotalBiayaSisa'], 0)."* ".trim($NEWLINE).trim($NEWLINE)."sudah di *".strtoupper(trim($hideStatus))."*. berikut detail nya:".trim($NEWLINE).$s.trim($NEWLINE).trim($NEWLINE)."Mohon segera ditindaklanjuti dengan memberikan keputusan baik itu Approve atau Reject di Aplikasi Pre Payment. Untuk masuk ke Aplikasi silahkan klik link berikut: ".trim($NEWLINE).trim($NEWLINE).trim($BASE_URL).trim($row['sUUIDX']);
							$this->m_core_apps->gf_send_wa(array("sNoHP" => trim($row1['sNoHP']), "sWAMessage" => trim($sWAMessage)));
			  		}
			  	}
			  }
			}
		} 
		return json_encode(array("status" => 1, "message" => $sReturn));
	}
	function gf_get_latest_status_penyelesaian_pre_payment($oParam=null)
	{
		$sql = "call sp_query('select a.nGroupUserId_fk, a.sStatus, a.sNIK, a.sNama, (select p.sGroupUserName from tm_user_groups p where p.nGroupUserId = a.nGroupUserId_fk and p.sStatusDelete is null) as sGroupName, date_format(a.dCreateOn, ''%d/%m/%Y %H:%i:%s'') as dCreateOnX from tx_prepayment_tracking a where a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and a.sStatusDelete is null and a.nId_fk = ".trim($oParam['IdTransaksi'])." and a.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by a.dCreateOn desc limit 1');";
		$rs = $this->db->query($sql);
		return json_encode($rs->row_array()	);
	}
}