<?php 
class m_prepayment_pengajuan_pre_payment extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps', 'm_prepayment_karyawan', 'm_core_email_engine')); 
		$this->load->library(array('libTerbilang', 'libIO'));
	} 
	function gf_load_data($sParam=null) 
	{ 
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$oParam = $_POST; 
		$oData = $sParam === null ? $oParam['Id_Transaksi_Pre_Payment'] : $sParam['Id_Transaksi_Pre_Payment']; 
		$sql = "call sp_query('select (select concat(p.sNamaKaryawan, '' ('', p.sNIK, '')'') from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIK = a.sNIKAtasan) as sAtasan, a.sNamaUnitUsaha, a.nIdUnitUsaha_fk, a.nGroupUserId_fk, a.sCreateBy, ".$this->db->database.".gf_global_function(''GetLastStatusPrePayment'', ".$nUnitId.", a.nIdPengajuanBS, ''PENGAJUAN_PRE_PAYMENT'', null, null, null) as sLastStatus, a.nTotalAmount, a.sDeskripsi, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.nIdKelompokUsaha_fk, a.nIdPengajuanBS, a.sNoPenyusun, a.dTglPenyusun, date_format(a.dTglPenyusun, ''%d/%m/%Y'') as dTglPenyusunX, a.sNIK, a.sNamaKaryawan, a.sBagian, a.sNamaBank, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, date_format(a.dTglKegiatanAwal, ''%d/%m/%Y'') as dTglKegiatanAwalX, date_format(a.dTglKegiatanAkhir, ''%d/%m/%Y'') as dTglKegiatanAkhirX, a.nIdPaymentType_fk, a.sNIKAtasan, a.sNamaAtasan, a.sNamaPenyusun, a.nIdKategoriPrePayment_fk, a.dTglPenyelesaianPrePayment, date_format(a.dTglPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglPenyelesaianPrePaymentX, date_format(a.dCreateOn, ''%d/%m/%Y %H:%i:%s'') as dCreateOnX, (select p.sGroupUserName from tm_user_groups p inner join tm_user_logins q on q.nGroupUserId_fk = p.nGroupUserId where q.sUserName = a.sNIK) as `sGroupUser`, b.sNamaDivisi, c.sNamaDepartemen from tx_prepayment_pengajuan_pp a inner join tm_prepayment_divisi b on b.nIdDivisi = a.nIdDivisi_fk inner join tm_prepayment_departemen c on c.nIdDepartemen = a.nIdDepartemen_fk where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.nIdPengajuanBS = ''".trim($oData)."'' and a.sMode = ''PP'' ')"; 
		//exit($sql);
		$rs = $this->db->query($sql); 
		return ($sParam !== null && array_key_exists("sOuputMode", $sParam) && trim($sParam['sOuputMode']) === "JSON" ? json_encode($rs->result_array()) : $rs->result_array()); 
	} 
	function gf_load_data_from_reff($sParam=null) 
	{ 
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$oParam = $_POST; 
		$oData = $sParam === null ? $oParam['sUUID'] : $sParam['sUUID']; 
		$sql = "call sp_query('select (select concat(p.sNamaKaryawan, '' ('', p.sNIK, '')'') from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIK = a.sNIKAtasan) as sAtasan, a.sNamaUnitUsaha, a.nIdUnitUsaha_fk, a.nGroupUserId_fk, a.sCreateBy, ".$this->db->database.".gf_global_function(''GetLastStatusPrePayment'', ".$nUnitId.", a.nIdPengajuanBS, ''PENGAJUAN_PRE_PAYMENT'', null, null, null) as sLastStatus, a.nTotalAmount, a.sDeskripsi, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.nIdKelompokUsaha_fk, a.nIdPengajuanBS, a.sNoPenyusun, a.dTglPenyusun, date_format(a.dTglPenyusun, ''%d/%m/%Y'') as dTglPenyusunX, a.sNIK, a.sNamaKaryawan, a.sBagian, a.sNamaBank, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, date_format(a.dTglKegiatanAwal, ''%d/%m/%Y'') as dTglKegiatanAwalX, date_format(a.dTglKegiatanAkhir, ''%d/%m/%Y'') as dTglKegiatanAkhirX, a.nIdPaymentType_fk, a.sNIKAtasan, a.sNamaAtasan, a.sNamaPenyusun, a.nIdKategoriPrePayment_fk, a.dTglPenyelesaianPrePayment, date_format(a.dTglPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglPenyelesaianPrePaymentX, date_format(a.dCreateOn, ''%d/%m/%Y %H:%i:%s'') as dCreateOnX, (select p.sGroupUserName from tm_user_groups p inner join tm_user_logins q on q.nGroupUserId_fk = p.nGroupUserId where q.sUserName = a.sNIK) as `sGroupUser`, b.sNamaDivisi, c.sNamaDepartemen from tx_prepayment_pengajuan_pp a inner join tm_prepayment_divisi b on b.nIdDivisi = a.nIdDivisi_fk inner join tm_prepayment_departemen c on c.nIdDepartemen = a.nIdDepartemen_fk where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.sUUID = ''".trim($oData)."'' and a.sMode = ''PP'' ')"; 
		//exit($sql);
		$rs = $this->db->query($sql); 
		return ($sParam !== null && array_key_exists("sOuputMode", $sParam) && trim($sParam['sOuputMode']) === "JSON" ? json_encode($rs->result_array()) : $rs->result_array()); 
	} 
	function gf_transact() 
	{ 
		$txtnIdTransaksiPrePayment 	= $this->input->post('txtnIdTransaksiPrePayment', TRUE); 
		$txtNoPenyusun 						 	= $this->input->post('txtNoPenyusun', TRUE); 
		$txtNoPenyusunlOld 					= $this->input->post('txtNoPenyusunlOld', TRUE); 
		$txtTglPenyusun 					 	= $this->input->post('txtTglPenyusun', TRUE); 
		$txtTglKegMulai 					 	= $this->input->post('txtTglKegMulai', TRUE); 
		$txtTglKegSelesai 				 	= $this->input->post('txtTglKegSelesai', TRUE); 
		$txtTglPenyelesaiPrePayment = $this->input->post('txtTglPenyelesaiPrePayment', TRUE); 
		$txtNIK 										= $this->input->post('txtNIK', TRUE); 
		$selKelompokUsahaPenyusun 	= $this->input->post('selKelompokUsahaPenyusun', TRUE); 
		$selPembebananUnitUsaha     = $this->input->post('selPembebananUnitUsaha', TRUE); 
		$selDivisiPembebanan        = $this->input->post('selDivisiPembebanan', TRUE); 
		$selDepartemenPembebanan    = $this->input->post('selDepartemenPembebanan', TRUE); 
		$selCaraBayar 							= $this->input->post('selCaraBayar', TRUE); 
		$hideNIKAtasan 							= $this->input->post('hideNIKAtasan', TRUE); 
		$txtNamaPenyusun 						= $this->input->post('txtNamaPenyusun', TRUE); 
		$txtDeskripsi 							= $this->input->post('txtDeskripsi', TRUE); 
		$selKategoriPrePayment 			= $this->input->post('selKategoriPrePayment', TRUE); 
		$txtTglPenyelesaiPrePayment = $this->input->post('txtTglPenyelesaiPrePayment', TRUE); 
		$hideMode 									= $this->input->post('hideMode', TRUE); 
		$sReturn 										= null; 
		$hideTotalAmount            = $this->input->post('hideTotalAmount', TRUE); 
		$hideGroupUserId						= $this->input->post('hideGroupUserId', TRUE);
		$UUID 											= $this->m_core_apps->gf_max_int_id(array("sFieldName" => "nIdPengajuanBS", "sTableName" => "tx_prepayment_pengajuan_pp", "sParam" => " where /*sMode = 'PP' and*/ nUnitId_fk = ".$this->session->userdata('nUnitId_fk')));

		//--Array
		$txtKomponen                = $this->input->post('txtKomponen', TRUE); 
		$txtKeterangan              = $this->input->post('txtKeterangan', TRUE); 
		$hideIdKomponen             = $this->input->post('hideIdKomponen', TRUE); 
		$hideTipeKomponen           = $this->input->post('hideTipeKomponen', TRUE); 
		$hideSubTotal               = $this->input->post('hideSubTotal', TRUE);
		$txtQty 										= $this->input->post('txtQty', TRUE);
		
		$hidenNominalDefault 			  				= $this->input->post('hidenNominalDefault', TRUE);
		$hidenEnabledDisabledNominal 			  = $this->input->post('hidenEnabledDisabledNominal', TRUE);
		$hidenEnabledDisabledtyFromKegiatan = $this->input->post('hidenEnabledDisabledtyFromKegiatan', TRUE);
		$hidenQtyPenyesuaian 			  				= $this->input->post('hidenQtyPenyesuaian', TRUE);
		$hidenPersenPotongan 			  				= $this->input->post('hidenPersenPotongan', TRUE);

		$hideModeAR 												= $this->input->post('hideModeAR', TRUE);

		if(trim($hideMode) !== "I") 
			$UUID = trim($txtnIdTransaksiPrePayment); 
		if(in_array(trim($hideMode), array("I", "U"))) 
		{ 
			if(strtolower(trim($txtNoPenyusun)) !== strtolower(trim($txtNoPenyusunlOld)))
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tx_prepayment_pengajuan_pp", "sFieldName" => "sNoPenyusun", "sContent" => trim($txtNoPenyusun))), TRUE); 
				if(intVal($sRet['status']) === 1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			}  
			//-- Nama Kelompok Usaha
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_kelompok_usaha", "sFieldName" => "nIdKelompokUsaha", "sContent" => trim($selKelompokUsahaPenyusun))), TRUE); 
			if(intVal($sRet['status']) === -1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
			//-- Pembebanan
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_pembebanan", "sFieldName" => "sIdPembebanan", "sContent" => trim($selPembebananUnitUsaha))), TRUE); 
			if(intVal($sRet['status']) === -1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
			//-- Divisi
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_divisi", "sFieldName" => "nIdDivisi", "sContent" => trim($selDivisiPembebanan))), TRUE); 
			if(intVal($sRet['status']) === -1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
			//-- Departemen
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_departemen", "sFieldName" => "nIdDepartemen", "sContent" => trim($selDepartemenPembebanan))), TRUE); 
			if(intVal($sRet['status']) === -1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 			
			//-- Cara Bayar
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_payment_type", "sFieldName" => "nIdPaymentType", "sContent" => trim($selCaraBayar))), TRUE); 
			if(intVal($sRet['status']) === -1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 			
			//-- NIK Atasan
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_karyawan", "sFieldName" => "sNIK", "sContent" => trim($hideNIKAtasan))), TRUE); 
			if(intVal($sRet['status']) === -1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 		
		}

		//-- Ambil grup user yang bikin pre payment
		$nGroupUserId = intval($this->session->userdata('nGroupUserId_fk'));
		if(trim($hideMode) !== "I") {
			$sql = "call sp_query('select p.nGroupUserId_fk from tm_user_logins p where sStatusDelete is null and sUserName = ''".trim($txtNIK)."'' ')";
			$rs = $this->db->query($sql);
			if($rs->num_rows() > 0)
			{
				$row = $rs->row_array();
				$nGroupUserId = trim($row['nGroupUserId_fk']);
			}
		}
		
		$nGroupUserIdHRD = 7; // Grup use HRD 

		if(in_array(trim($hideMode), array("U", "D"))) 
		{
			$row = json_decode($this->gf_get_latest_status_pengajuan_pre_payment(array("IdTransaksi" => trim($UUID))), TRUE);
			//-- Kalau sudah di Approve sama atasannya ATAU sudah di approve sama HRD, send warning...
			//-- Yang BUAT DAN YANG APPROVE SELAIN HRD
			if(trim($hideModeAR) !== "Reject")
			{
				if(intval($this->session->userdata('nGroupUserId_fk')) !== $nGroupUserIdHRD)
				{					

					if(((trim($row['sNIK']) === trim($hideNIKAtasan)) || (intval($row['nGroupUserId_fk']) === $nGroupUserIdHRD)) && trim($row['sStatus']) === "APPROVE")
					{
						$sReturn = json_encode(array("status" => -1, "message" => "No Penyusun <b>".trim($txtNoPenyusun)."</b> sudah di <b>APPROVE</b> oleh <b>".trim($row['sNama'])."</b> (".trim($row['sGroupName']).") pada <b>".trim($row['dCreateOnX'])."</b>!. <br /><br />Perubahan atau Penghapusan data tidak di izinkan. <br />Periksa kembali data Anda !")); 
						return $sReturn; 
						exit(0); 
					}
				}
				//--HRD
				else if(intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdHRD)
				{
					if(intval($row['nGroupUserId_fk']) === intval($nGroupUserIdHRD) && trim($row['sStatus']) === "APPROVE")
					{
						$sReturn = json_encode(array("status" => -1, "message" => "No Penyusun <b>".trim($txtNoPenyusun)."</b> sudah di <b>APPROVE</b> oleh <b>".trim($row['sNama'])."</b> (".trim($row['sGroupName']).") pada <b>".trim($row['dCreateOnX'])."</b>!. <br /><br />Perubahan atau Penghapusan data tidak di izinkan. <br />Periksa kembali data Anda !")); 
						return $sReturn; 
						exit(0); 
					}
				}
			}
			else if(trim($hideModeAR) === "Reject")
			{
				//--Klo sudah di buat penyelesaian pre payment nya maka ga bisa di ubah  oleh HRD
				$sql = "call sp_query('select a.nIdPengajuanBS_fk, b.sRealName, date_format(a.dCreateOn, ''%d/%m/%Y %H:%i:%s'') as dCreateOn from tx_prepayment_penyelesaian_pp a inner join tm_user_logins b on b.nUserId = a.nUserId_fk where a.sStatusDelete is null and b.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and a.nIdPengajuanBS_fk = ".$UUID."');";
				$rs = $this->db->query($sql);
				if($rs->num_rows() > 0)
				{
					$row = $rs->row_array();
					if(trim($row['nIdPengajuanBS_fk']) !== "")//HRD
					{ 
						$sReturn = json_encode(array("status" => -1, "message" => "No Penyusun <b>".trim($txtNoPenyusun)."</b> sudah di buat <b>PENYELESAIAN PRE PAYMENT</b> oleh <b>".trim($row['sRealName'])."</b> pada <b>".trim($row['dCreateOn'])."</b>!. <br /><br />Perubahan atau Penghapusan data tidak di izinkan. <br />Periksa kembali data Anda !")); 
						return $sReturn; 
						exit(0); 
					}
				}
			}	
			//------------------------------------------------------------------------------------------------------------------------
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tx_prepayment_penyelesaian_pp", "sFieldName" => "nIdPengajuanBS_fk", "sContent" => trim($txtnIdTransaksiPrePayment))), TRUE); 						
			if(intVal($sRet['status']) === 1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => "Id Transaksi Pre Payment sudah dibuat Penyelesaian Pre Payment !. Perubahan atau Penghapusan data tidak di izinkan. Cek kembali data Anda !")); 
				return $sReturn; 
				exit(0); 
			}
		}
		if(in_array(trim($hideMode), array("D"))) 
		{ 
			$sql = "call sp_tx_prepayment_pengajuan_pp_komponen('D', ".$UUID.", NULL, NULL, NULL, NULL, NULL, NULL, ".$this->session->userdata('nUnitId_fk').", NULL, '".trim($this->session->userdata('sRealName'))."', null, null, null, null, null, null, null);";
			$sql .= "call sp_query('update tx_prepayment_tracking set sStatusDelete = ''V'' where nId_fk = ".$UUID." and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and sStatusDelete is null');";
			$this->db->query($sql);
			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => $this->db->database, "sFieldName" => "nIdPengajuanBS_fk", "sContent" => trim($txtnIdTransaksiPrePayment), "sValueLabel" => "Id Transaksi BS")), TRUE); 
			if(intVal($sRet['status']) === 1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
			$this->db->trans_rollback();
		} 

		$libTerbilang = new libTerbilang();

		$sql = "call sp_tx_prepayment_pengajuan_pp('".$hideMode."', ".$UUID.", '".trim(nl2br($txtDeskripsi))."', ".trim($selPembebananUnitUsaha).", 'PP', '".$UUID."', '".$this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglPenyusun), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))."', '".trim($txtNIK)."', '".$this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglKegMulai), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))."', '".$this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglKegSelesai), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))."', ".trim($selCaraBayar).", '".trim($hideNIKAtasan)."', '".trim($txtNamaPenyusun)."', ".trim($selKategoriPrePayment).", '".$this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglPenyelesaiPrePayment), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))."', ".trim($selKelompokUsahaPenyusun).", ".trim($selDivisiPembebanan).", ".trim($selDepartemenPembebanan).", NULL, ".$this->session->userdata('nUnitId_fk').", '".trim($this->session->userdata('sRealName'))."', ".trim($this->session->userdata('nUserId')).", ".str_replace(",", "", trim($hideTotalAmount)).", '".str_replace("  ", " ", trim($libTerbilang->gfRenderTerbilang(str_replace(",", "", trim($hideTotalAmount)))))."', ".$nGroupUserId.");"; 

		if(trim($hideMode) !== "I")
		{
			$sql .= "call sp_tx_prepayment_pengajuan_pp_komponen('D', ".$UUID.", NULL, NULL, NULL, NULL, NULL, NULL, ".$this->session->userdata('nUnitId_fk').", NULL, '".trim($this->session->userdata('sRealName'))."', NULL, NULL, NULL, NULL, NULL, NULL, NULL);";
		}

		if(trim($hideMode) !== "D")
		{
			for($i=0; $i<count($hideIdKomponen); $i++)
			{
				$sql .= "call sp_tx_prepayment_pengajuan_pp_komponen('I', ".$UUID.", '".trim($hideIdKomponen[$i])."', '".trim($txtKeterangan[$i])."', ".(trim($hideTipeKomponen[$i]) === "A" ? "'".trim($txtKomponen[$i])."'" : "NULL").", ".(trim($hideTipeKomponen[$i]) === "N" ? str_replace(",", "", $txtKomponen[$i]) : "NULL").", ".(trim($hideTipeKomponen[$i]) === "D" ? "'".$this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtKomponen[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))."'" : "NULL").", NULL, ".$this->session->userdata('nUnitId_fk').", ".($i+1).", '".trim($this->session->userdata('sRealName'))."', ".str_replace(",", "", (in_array(trim($hideTipeKomponen[$i]), array("A", "D")) ? "null" : trim($txtQty[$i]))).", ".str_replace(",", "", (in_array(trim($hideTipeKomponen[$i]), array("A", "D")) ? "null" : (trim($hideSubTotal[$i]) === "" ? "null" : trim(str_replace(",", "", $hideSubTotal[$i]))))).", ".trim(str_replace(",", "", $hidenNominalDefault[$i])).", '".trim($hidenEnabledDisabledNominal[$i])."', '".trim($hidenEnabledDisabledtyFromKegiatan[$i])."', ".trim($hidenQtyPenyesuaian[$i]).", ".trim($hidenPersenPotongan[$i]).");";
			}
		}

		if(!in_array(trim($hideMode), array("D")) && intval($this->session->userdata('nGroupUserId_fk')) !== 0 && intval($this->session->userdata('nGroupUserId_fk')) !== $nGroupUserIdHRD && trim($hideModeAR) === "") 
		{ 
			$sql .= "call sp_tx_prepayment_tracking('I', ".trim($UUID).", '".trim($txtNIK)."', '".$this->session->userdata('sRealName')."', 'PENGAJUAN_PRE_PAYMENT', ".$this->session->userdata('nGroupUserId_fk').", 'AUTO SUBMIT', 'SUBMIT', null, ".$this->session->userdata('nUnitId_fk').", '".$this->session->userdata('sRealName')."')";
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
			if(!in_array(trim($hideMode), array("D"))) 
			{ 
				if(trim($hideModeAR) !== "Approve" && trim($hideModeAR) !== "Reject")
				{
					//-- Send Notification via Email //------------------------------------------------------------------------------------
					$oDataKaryawan = json_decode($this->m_prepayment_karyawan->gf_get_info_karyawan(array("sNIK" => trim($hideNIKAtasan))), TRUE);
					$sEmailTo = trim($oDataKaryawan['sEmail']);
					$sNoHPTo = trim($oDataKaryawan['sNoHP']);
					//$sEmailTo = "labirin69@gmail.com";
					//$sNoHPTo = "081382322951";
					//-- Load Email Template
					$SP 					 = DIRECTORY_SEPARATOR;
					$oPath 				 = getcwd().$SP."emails".$SP."pengajuan_pre_payment.eml";
					$libIO 				 = new libIO();
					$sData 				 = $libIO->gf_read_file(array("path" => $oPath));
					$sData 				 = json_decode($sData, TRUE);
		  		$oSQL     		 = trim($sData['txtNativeSQL']);
					$oSQL 				 = str_replace("@nIdPengajuanBS", $UUID, $oSQL);
		  		$oConvert 		 = $this->m_core_email_engine->gf_convert_rpt_engine(array("content" => trim($sData['txtNativeHTML']), "sql" => $oSQL));
					//--
					$sEmailMessage = $oConvert;
					$sEmailSubject = date('d-m-Y H:i:s')." | Pre Payment Notification | Pengajuan Pre Payment | Approval Needed";		
					//--
					$oConfig = $this->m_core_apps->gf_read_config_apps();
					if(trim($oConfig['NOTIF_TO_EMAIL']) === "TRUE")
						$this->m_core_apps->gf_send_email_x(array("sFromName" => "Gramedia Prepayment Application", "sEmail" => trim($sEmailTo), "sEmailSubject" => trim($sEmailSubject), "sEmailMessage" => trim($sEmailMessage)));
				  //---------------------------------------------------------------------------------------------------------------------
				  // Send Whatsapp
					if(trim($oConfig['NOTIF_TO_WHATSAPP']) === "TRUE")
				  {
				  	$SQL = "call sp_query('SELECT a.sUUID as sUUIDX, c.sEmail as sEmailPengirim, d.sEmail as sEmailPenerima, a.*, concat(''@siteurl'', ''c_prepayment_pengajuan_pre_payment'') as host, format(nTotalAmount, 0) as nTotalAmountX, date_format(dTglPenyusun, ''%d-%m-%Y'') as dTglPenyusunX, date_format(current_timestamp, ''%d-%m-%Y %H:%i:%s'') as c, b.sNamaKategoriPrePayment, date_format(a.dTglKegiatanAwal, ''%d-%m-%Y'') as dTglKegiatanAwalX, date_format(a.dTglKegiatanAkhir, ''%d-%m-%Y'') as dTglKegiatanAkhirX, __dbname__.gf_global_function(''GetLastStatusPrePayment'', @unit, a.nIdPengajuanBS, ''PENGAJUAN_PRE_PAYMENT'', null, null, null) as sLastStatus FROM tx_prepayment_pengajuan_pp a inner join tm_prepayment_kategori_pre_payment_h b on b.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk inner join tm_prepayment_karyawan c on c.sNIK = a.sNIK inner join tm_prepayment_karyawan d on d.sNIK = a.sNIKAtasan where a.sStatusDelete is null and a.nUnitId_fk = @unit and c.sStatusDelete is null and c.nUnitId_fk = @unit and b.sStatusDelete is null and b.nUnitId_fk = @unit and nIdPengajuanBS = ".trim($UUID)."')";
				  	$SQL = str_replace("@unit", $this->session->userdata('nUnitId_fk'), $SQL);
				  	$SQL = str_replace("@siteurl", site_url(), $SQL);
				  	$SQL = str_replace("__dbname__", $this->db->database, $SQL);
				  	$rs = $this->db->query($SQL);
				  	$row = $rs->row_array();
				  	$NEWLINE = "\\r\\n";
				  	//------------------------------------------------
				  	$BASE_URL = trim($oConfig['WHATSAPP_BASE_URL_CRUD_PENGAJUAN']);
				  	//------------------------------------------------
				  	$sWAMessage = urlencode("YTH *".trim($row['sNamaAtasan'])."*, ".trim($NEWLINE).trim($NEWLINE)."Ada Pengajuan Pre Payment yang membutuhkan Approval Bapak/Ibu. Sebagai informasi, *".trim($row['sNamaKaryawan'])."* telah mengajukan Pre Payment, berikut informasinya:  ".trim($NEWLINE).trim($NEWLINE)."No. Penyusun: *".trim($row['sNoPenyusun'])."*".trim($NEWLINE)."Kategori Pre Payment: *".trim($row['sNamaKategoriPrePayment'])."* ".trim($NEWLINE)."Tgl Kegiatan: *".trim($row['dTglKegiatanAwalX'])."* s/d *".trim($row['dTglKegiatanAkhirX'])."* ".trim($NEWLINE)."Keperluan: *".trim($row['sDeskripsi'])."*".trim($NEWLINE)."Nominal: Rp. *".number_format($row['nTotalAmount'], 0)."* ".trim($NEWLINE).trim($NEWLINE)."Mohon segera ditindaklanjuti dengan memberikan keputusan baik itu *Approve* atau *Reject* di Aplikasi Pre Payment. Untuk masuk ke Aplikasi silahkan klik link berikut: ".trim($NEWLINE).trim($NEWLINE).trim($BASE_URL).trim($row['sUUIDX']));
				  	//------------------------------------------------
						$this->m_core_apps->gf_send_wa(array("sNoHP" => trim($sNoHPTo), "sWAMessage" => trim($sWAMessage)));
					}
			  }
			} 
		}
		return $sReturn; 
	}
	function gf_encode_URI($uri)
	{
			return preg_replace_callback("{[^0-9a-z_.!~*'();,/?:@&=+$#-]}i", function ($m) {
					return sprintf('%%%02X', ord($m[0]));
			}, $uri);
	}
	function gf_load_komponen_pre_payment($oParam=array())
	{
		$sReturn = null;
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$nIdTransaksiPrePayment = count($oParam) === 0 ? $this->input->post('nIdTransaksiPrePayment', TRUE) : $oParam['nIdTransaksiPrePayment'];
		$nGroupUserId = count($oParam) === 0 ? $this->input->post('nGroupUserId', TRUE) : $oParam['nGroupUserId'];

		$nUnitId = $this->session->userdata('nUnitId_fk');

		$sOption = null;
		for($o=1; $o<=20; $o++)	
			$sOption .= "<option value=\"".$o."\">".$o."</option>";	

		if(trim($nIdTransaksiPrePayment) === "")
			$sql = "call sp_query('select null as nSubTotal, null as nQty, null as sKeterangan, b.sAllowMultiply, null as sValue, null as dValue, (select p.nNominal from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk) as nValue, a.nIdKategoriPrePayment_fk, b.sSatuan, a.nIdKomponen_fk, a.nSeqNo, b.sTipeDataKomponen, b.sAllowSummary, b.sNamaKomponen, b.nDigit, b.nDecimalPoint, b.sLabel, 

		(select p.sFlagEnabledDisabledNominal from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk) as `sFlagEnabledDisabledNominal`, 
		(select p.sFlagQtyFromPeriodeTglKegiatan from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk) as `sFlagQtyFromPeriodeTglKegiatan`, 
		ifnull((select p.nQtyPenyesuaianPeriodeTglKegiatan from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk), 0) as `nQtyPenyesuaian`, 
		ifnull((select p.nPersenPotongan from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk), 0) as `nPersenPotongan`, 
		ifnull((select p.nNominal from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk), 0) as `nNominalDefault` 


		from tm_prepayment_kategori_pre_payment_d a inner join tm_prepayment_komponen_pre_payment b on b.nIdKomponen = a.nIdKomponen_fk where a.sStatusDelete is null and b.sStatusDelete is null and b.sTipeDataKomponen = ''N'' and a.nUnitId_fk = ".$nUnitId." and b.nUnitId_fk = ".$nUnitId." and nIdKategoriPrePayment_fk = ".$this->input->post('nIdKategoriPrePayment', TRUE)." order by a.nSeqNoCustom');";			
		else
			$sql = "call sp_query('SELECT b.nNominalDefault, b.sEditNominal as sFlagEnabledDisabledNominal, b.sQtyFromTglKegiatan as sFlagQtyFromPeriodeTglKegiatan, b.nQtyPenyesuaian, b.nPersenPotongan, b.nSubTotal, b.nQty, b.sAllowMultiply, b.sValue, b.nValue, date_format(b.dValue, ''%d/%m/%Y'') as dValue, b.sKeterangan, b.sSatuan, b.nIdKomponen_fk, b.nSeqNo, b.sTipeDataKomponen, b.sAllowSummary, a.sNamaKomponen, b.nDigit, b.nDecimalPoint, b.sLabel FROM tm_prepayment_komponen_pre_payment a INNER JOIN tx_prepayment_pengajuan_pp_komponen b ON b.nIdKomponen_fk = a.nIdKomponen WHERE b.nIdPengajuanBS_fk = ".trim($nIdTransaksiPrePayment)." AND a.sStatusDelete IS NULL and b.sStatusDelete is null AND b.sTipeDataKomponen = ''N'' and a.nUnitId_fk = ".$nUnitId." AND b.nUnitId_fk = ".$nUnitId." ORDER BY b.nSeqNo, b.sTipeDataKomponen');";
		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
		{
			$sReturn .= "<div class=\"col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group\">";
			$sReturn .= "<table class=\"".trim($oConfig['TABLE_CLASS'])." table-striped\">";
			$sReturn .= "<tr><td colspan=\"6\"><i class=\"fa fa-slack\"></i> Calculated Component !</td></tr>";
			$sReturn .= "<tr><td class=\"bg-danger text-bold\">No</td><td class=\"bg-danger text-bold\">Nama Komponen</td><td class=\"bg-danger text-bold\">Nilai Komponen</td><td class=\"bg-danger text-bold\">Qty</td><td class=\"bg-danger text-bold\">Sub Total</td><td class=\"bg-danger text-bold\">Keterangan</td></tr>";
			$i = 1;
			foreach($rs->result_array() as $row) 
			{
				$sReturn .= "<tr>";
				$sReturn .= "<td class=\"text-right\">".$i."</td>";
				$sReturn .= "<td>".trim($row['sNamaKomponen'])." (".$row['sSatuan'].")</td>";
				$sReturn .= "<td>";

				$sEnabledDisabledNominal = (trim($row['sFlagEnabledDisabledNominal']) === "0" ? "readonly" : "");
				$sQtyFromKegiatan 			 = trim($row['sFlagQtyFromPeriodeTglKegiatan']);

				if(trim($row['sTipeDataKomponen']) === "A")					
					$sReturn .= "<input data-toggle=\"tooltip\" data-placement=\"top\" title=\"Nilai Komponen\" persen-potongan=\"".$row['nPersenPotongan']."\" ".$sEnabledDisabledNominal." allow-empty=\"false\" title=\"".trim($row['sNamaKomponen'])."\" type=\"text\" class=\"form-control\" name=\"txtKomponen[]\" id=\"txtKomponen\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" placeholder=\"".trim($row['sNamaKomponen'])."\" value=\"".trim($row['sValue'])."\" maxlength=\"".trim($row['nDigit'])."\"/>";
				else if(trim($row['sTipeDataKomponen']) === "N")	
					$sReturn .= "<input data-toggle=\"tooltip\" data-placement=\"top\" title=\"Nilai Komponen\"  persen-potongan=\"".$row['nPersenPotongan']."\" ".$sEnabledDisabledNominal." allow-empty=\"false\" title=\"".trim($row['sNamaKomponen'])."\" type=\"text\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" decimalpoint=\"".trim($row['nDecimalPoint'])."\" class=\"form-control\" name=\"txtKomponen[]\" id=\"txtKomponen\" placeholder=\"".trim($row['sNamaKomponen'])."\" value=\"".trim($row['nValue'])."\" maxlength=\"".trim($row['nDigit'])."\"/>";
				else if(trim($row['sTipeDataKomponen']) === "D")		
					$sReturn .= "<div data-toggle=\"tooltip\" data-placement=\"top\" title=\"Nilai Komponen\"  class=\"input-group date\"><input allow-empty=\"false\" title=\"".trim($row['sNamaKomponen'])."\" placeholder=\"".trim($row['sNamaKomponen'])."\" name=\"txtKomponen[]\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" value=\"".trim($row['dValue'])."\" id=\"txtKomponen\" type=\"text\" class=\"form-control\"><span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>
						</div>";
				$sReturn .= "</td>";
				$oVisible = "";
				if(trim($row['sTipeDataKomponen']) === "D" || trim($row['sTipeDataKomponen']) === "A")
					$oVisible = "hidden";
				$sReturn .= "<td><input data-toggle=\"tooltip\" data-placement=\"top\" title=\"Qty Komponen\"  qty-penyesuaian=\"".trim($row['nQtyPenyesuaian'])."\" ".(trim($sQtyFromKegiatan) === "1" ? "readonly" : "")." qty-from-kegiatan=\"".trim($sQtyFromKegiatan)."\" name=\"txtQty[]\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" decimalpoint=\"0\" maxlength=\"".trim($row['nDigit'])."\" id=\"txtQty\" placeholder=\"Qty\" value=\"".trim($row['nQty'])."\" class=\"form-control text-right ".trim($oVisible)."\">";
				//$sReturn .= $sOption;	
				$sReturn .= "</td>";
				$sReturn .= "<td><input data-toggle=\"tooltip\" data-placement=\"top\" title=\"Sub Total\"  type=\"text\" class=\"form-control ".trim($oVisible)."\" disabled title=\"Sub Total ".trim($row['sNamaKomponen'])."\" name=\"txtSubTotal[]\" value=\"".trim($row['nSubTotal'])."\" id=\"txtSubTotal\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" placeholder=\"Sub Total ".trim($row['sNamaKomponen'])."\"/>

				<input type=\"hidden\" name=\"hideSubTotal[]\" id=\"hideSubTotal\" value=\"".trim($row['nSubTotal'])."\" /></td>";
				$sReturn .= "<td><input data-toggle=\"tooltip\" data-placement=\"top\" title=\"Keterangan Komponen\"  type=\"text\" class=\"form-control\" title=\"".trim($row['sNamaKomponen'])."\" name=\"txtKeterangan[]\" id=\"txtKeterangan\" value=\"".trim($row['sKeterangan'])."\" placeholder=\"Keterangan ".trim($row['sNamaKomponen'])."\"/></td>";
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
			$sReturn .= "<tr><td class=\"bg-danger text-right\" colspan=\"4\" id=\"tdTerbilang\" class=\"bg-danger\">Grand Total</td><td class=\"bg-red text-right\"><span id=\"spanTotal\" class=\"text-bold\"></span></td><td class=\"bg-danger\"></td></tr>";
			$sReturn .= "</table>";
			$sReturn .= "</div>";
		}

		if(trim($nIdTransaksiPrePayment) === "")
			$sql = "call sp_query('select null as nSubTotal, null as nQty, null as sKeterangan, b.sAllowMultiply, null as sValue, null as dValue, (select p.nNominal from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk) as nValue, a.nIdKategoriPrePayment_fk, b.sSatuan, a.nIdKomponen_fk, a.nSeqNo, b.sTipeDataKomponen, b.sAllowSummary, b.sNamaKomponen, b.nDigit, b.nDecimalPoint, b.sLabel, 

		(select p.sFlagEnabledDisabledNominal from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk) as `sFlagEnabledDisabledNominal`, (select p.sFlagQtyFromPeriodeTglKegiatan from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk) as `sFlagQtyFromPeriodeTglKegiatan`, ifnull((select p.nQtyPenyesuaianPeriodeTglKegiatan from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk), 0) as `nQtyPenyesuaian`, ifnull((select p.nPersenPotongan from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk), 0) as `nPersenPotongan`, ifnull((select p.nNominal from tm_prepayment_komponen_pre_payment_rule p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.nGroupUserId_fk = ".trim($nGroupUserId)." and p.nIdKomponen_fk = a.nIdKomponen_fk), 0) as `nNominalDefault` 

		from tm_prepayment_kategori_pre_payment_d a inner join tm_prepayment_komponen_pre_payment b on b.nIdKomponen = a.nIdKomponen_fk where a.sStatusDelete is null and b.sStatusDelete is null and b.sTipeDataKomponen <> ''N'' and a.nUnitId_fk = ".$nUnitId." and b.nUnitId_fk = ".$nUnitId." and nIdKategoriPrePayment_fk = ".$this->input->post('nIdKategoriPrePayment', TRUE)." order by a.nSeqNoCustom');";
		else
			$sql = "call sp_query('SELECT b.nNominalDefault, b.sEditNominal as sFlagEnabledDisabledNominal, b.sQtyFromTglKegiatan as sFlagQtyFromPeriodeTglKegiatan, b.nQtyPenyesuaian, b.nPersenPotongan, b.nSubTotal, b.nQty, b.sAllowMultiply, b.sValue, b.nValue, date_format(b.dValue, ''%d/%m/%Y'') as dValue, b.sKeterangan, b.sSatuan, b.nIdKomponen_fk, b.nSeqNo, b.sTipeDataKomponen, b.sAllowSummary, a.sNamaKomponen, b.nDigit, b.nDecimalPoint, 
				b.sLabel FROM tm_prepayment_komponen_pre_payment a INNER JOIN tx_prepayment_pengajuan_pp_komponen b ON b.nIdKomponen_fk = a.nIdKomponen WHERE b.nIdPengajuanBS_fk = ".trim($nIdTransaksiPrePayment)." AND a.sStatusDelete IS NULL and b.sStatusDelete is null AND b.sTipeDataKomponen <> ''N'' and a.nUnitId_fk = ".$nUnitId." AND b.nUnitId_fk = ".$nUnitId." ORDER BY b.nSeqNo, b.sTipeDataKomponen');";
		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
		{
			$sReturn .= "<div class=\"col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group\">";
			$sReturn .= "<table class=\"".trim($oConfig['TABLE_CLASS'])." table-striped\">";
			$sReturn .= "<tr><td colspan=\"6\"><i class=\"fa fa-automobile\"></i> Non Calculated Component !</td></tr>";
			$sReturn .= "<tr><td class=\"bg-danger text-bold\">No</td><td class=\"bg-danger text-bold\">Nama Komponen</td><td class=\"bg-danger text-bold\">Nilai Komponen</td><td class=\"bg-danger text-bold\">Qty</td><td class=\"bg-danger text-bold\">Sub Total</td><td class=\"bg-danger text-bold\">Keterangan</td></tr>";
			$i = 1;
			foreach($rs->result_array() as $row) 
			{
				$sReturn .= "<tr>";
				$sReturn .= "<td class=\"text-right\">".$i."</td>";
				$sReturn .= "<td>".trim($row['sNamaKomponen'])." (".$row['sSatuan'].")</td>";
				$sReturn .= "<td>";

				$sEnabledDisabledNominal = (trim($row['sFlagEnabledDisabledNominal']) === "0" ? "readonly" : "");
				$sQtyFromKegiatan 			 = trim($row['sFlagQtyFromPeriodeTglKegiatan']);

				if(trim($row['sTipeDataKomponen']) === "A")					
					$sReturn .= "<input persen-potongan=\"".$row['nPersenPotongan']."\" ".$sEnabledDisabledNominal." allow-empty=\"false\" title=\"".trim($row['sNamaKomponen'])."\" type=\"text\" class=\"form-control\" name=\"txtKomponen[]\" id=\"txtKomponen\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" placeholder=\"".trim($row['sNamaKomponen'])."\" value=\"".trim($row['sValue'])."\" maxlength=\"".trim($row['nDigit'])."\"/>";
				else if(trim($row['sTipeDataKomponen']) === "N")	
					$sReturn .= "<input persen-potongan=\"".$row['nPersenPotongan']."\" ".$sEnabledDisabledNominal." allow-empty=\"false\" title=\"".trim($row['sNamaKomponen'])."\" type=\"text\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" decimalpoint=\"".trim($row['nDecimalPoint'])."\" class=\"form-control\" name=\"txtKomponen[]\" id=\"txtKomponen\" placeholder=\"".trim($row['sNamaKomponen'])."\" value=\"".trim($row['nValue'])."\" maxlength=\"".trim($row['nDigit'])."\"/>";
				else if(trim($row['sTipeDataKomponen']) === "D")		
					$sReturn .= "<div class=\"input-group date\"><input allow-empty=\"false\" title=\"".trim($row['sNamaKomponen'])."\" placeholder=\"".trim($row['sNamaKomponen'])."\" name=\"txtKomponen[]\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" value=\"".trim($row['dValue'])."\" id=\"txtKomponen\" type=\"text\" class=\"form-control\"><span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span>
						</div>";
				$sReturn .= "</td>";
				$oVisible = "";
				if(trim($row['sTipeDataKomponen']) === "D" || trim($row['sTipeDataKomponen']) === "A")
					$oVisible = "hidden";
				$sReturn .= "<td qty-penyesuaian=\"".trim($row['nQtyPenyesuaian'])."\" class=\"".trim($oVisible)."\"><input ".(trim($sQtyFromKegiatan) === "1" ? "readonly" : "")." qty-from-kegiatan=\"".trim($sQtyFromKegiatan)."\" name=\"txtQty[]\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" decimalpoint=\"0\" maxlength=\"".trim($row['nDigit'])."\" id=\"txtQty\" placeholder=\"Qty\" value=\"".trim($row['nQty'])."\" class=\"form-control text-right ".trim($oVisible)."\">";
				//$sReturn .= $sOption;	
				$sReturn .= "</td>";
				$sReturn .= "<td class=\"".trim($oVisible)."\"><input type=\"text\" class=\"form-control ".trim($oVisible)."\" disabled title=\"Sub Total ".trim($row['sNamaKomponen'])."\" name=\"txtSubTotal[]\" value=\"".trim($row['nSubTotal'])."\" id=\"txtSubTotal\" allow-summary=\"".trim($row['sAllowSummary'])."\" allow-multiply=\"".trim($row['sAllowMultiply'])."\" content-mode=\"numeric\" placeholder=\"Sub Total ".trim($row['sNamaKomponen'])."\"/>

				<input type=\"hidden\" name=\"hideSubTotal[]\" id=\"hideSubTotal\" value=\"".trim($row['nSubTotal'])."\" /></td>";
				$sReturn .= "<td><input type=\"text\" class=\"form-control\" title=\"".trim($row['sNamaKomponen'])."\" name=\"txtKeterangan[]\" id=\"txtKeterangan\" value=\"".trim($row['sKeterangan'])."\" placeholder=\"Keterangan ".trim($row['sNamaKomponen'])."\"/></td>";
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
			$sReturn .= "</div>";
		}

		$sReturn = "<div class=\"row\">".$sReturn."</div>";

		return json_encode(array("oData" => $sReturn));
	}
	function gf_load_divisi_by_unit_usaha()
	{
		$sUnitUsaha = $this->input->post('sUnitUsaha', TRUE);
		$nUnitId = $this->session->userdata('nUnitId_fk');
		return json_encode(array("oData" => $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDivisi, sNamaDivisi  from tm_prepayment_divisi where sStatusDelete is null and nUnitId_fk = ".$nUnitId." and sEntity = '".$sUnitUsaha."'", "sFieldId" => "nIdDivisi", "sFieldValues" => "sNamaDivisi"))));
	}
	function gf_load_departemen_by_divisi()
	{
		$nIdDivisi = $this->input->post('nIdDivisi', TRUE);
		$nUnitId = $this->session->userdata('nUnitId_fk');
		return json_encode(array("oData" => $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nIdDepartemen, sNamaDepartemen  from tm_prepayment_departemen where sStatusDelete is null and nUnitId_fk = ".$nUnitId." and nIdDivisi_fk = ".$nIdDivisi, "sFieldId" => "nIdDepartemen", "sFieldValues" => "sNamaDepartemen"))));
	}
	function gf_operation()
	{
		$sReturn 					= null;
		$hideStatus 			= $this->input->post('hideStatus', TRUE);
		$hideIdTransaksi 	= $this->input->post('hideIdTransaksi', TRUE);
		$hideNotes 				= $this->input->post('hideNotes', TRUE);
		$hideNIKAtasan 		= $this->session->userdata('sUserName'); //$this->input->post('hideNIKAtasan', TRUE);
		$hideTrackingMode = $this->input->post('hideTrackingMode', TRUE);		

		//-- Ambil grup user yang bikin pre payment
		$nGroupUserId = intval($this->session->userdata('nGroupUserId_fk'));
		$sql = "call sp_query('select p.nGroupUserId_fk from tm_user_logins p inner join tx_prepayment_pengajuan_pp q on q.sNIK = p.sUserName where p.sStatusDelete is null and q.nIdPengajuanBS = ".trim($hideIdTransaksi)."')";
		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$nGroupUserId = trim($row['nGroupUserId_fk']);
		}
		
		$nGroupUserIdAtasan = $nGroupUserId - 1; // Semakin kecil, semakin besar jabatan, 0 = Administrator, 7 = HRD
		$nGroupUserIdHRD = 7; // Grup use HRD 

		$sNoPenyusun = null;
		$sql = "call sp_query('select sNoPenyusun from tx_prepayment_pengajuan_pp where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and nIdPengajuanBS = ".trim($hideIdTransaksi)."')";
		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$sNoPenyusun = $row['sNoPenyusun'];
		}

		$row = json_decode($this->gf_get_latest_status_pengajuan_pre_payment(array("IdTransaksi" => trim($hideIdTransaksi))), TRUE);
		if($hideTrackingMode === "Approve")
		{
			//-- Klo sudah di Approve HRD ga bisa ubah
			if(intval($row['nGroupUserId_fk']) === $nGroupUserIdHRD && trim($row['sStatus']) === "APPROVE")
			{
				$sReturn = json_encode(array("status" => -1, "message" => "No Penyusun <b>".trim($sNoPenyusun)."</b> sudah di <b>APPROVE</b> oleh <b>".trim($row['sNama'])."</b> (".trim($row['sGroupName']).") pada <b>".trim($row['dCreateOnX'])."</b>!. <br /><br />Perubahan atau Penghapusan data tidak di izinkan. <br />Periksa kembali data Anda !")); 
				return $sReturn; 
				exit(0); 
			}
		}

		//--End
		$sql = "call sp_tx_prepayment_tracking('I', ".trim($hideIdTransaksi).", '".trim($hideNIKAtasan)."', '".$this->session->userdata('sRealName')."', '".trim($hideTrackingMode)."', ".$this->session->userdata('nGroupUserId_fk').", '".str_replace("'", "''", trim($hideNotes))."', '".trim($hideStatus)."', null, ".$this->session->userdata('nUnitId_fk').", '".$this->session->userdata('sRealName')."')";
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
			//-- Send Notification via Email //------------------------------------------------------------------------------------
			$sql = "call sp_query('select sNIK, sNIKAtasan from tx_prepayment_pengajuan_pp where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and nIdPengajuanBS = ".trim($hideIdTransaksi)."')";
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
			$oPath 				 = getcwd().$SP."emails".$SP."approval_pengajuan_pre_payment.eml";
			$libIO 				 = new libIO();
			$sData 				 = $libIO->gf_read_file(array("path" => $oPath));
			$sData 				 = json_decode($sData, TRUE);
  		$oSQL     		 = trim($sData['txtNativeSQL']);
			$oSQL 				 = str_replace("@nIdPengajuanBS", trim($hideIdTransaksi), $oSQL);
  		$oConvert 		 = $this->m_core_email_engine->gf_convert_rpt_engine(array("content" => trim($sData['txtNativeHTML']), "sql" => $oSQL));
			$sEmailMessage = $oConvert;
			$sEmailSubject = date('d-m-Y H:i:s')." | Pre Payment Notification | Pengajuan Pre Payment | Approval Needed";		
			//--
			$oConfig = $this->m_core_apps->gf_read_config_apps();
			if(trim($oConfig['NOTIF_TO_EMAIL']) === "TRUE")
		  {
		  	/*$this->m_core_apps->gf_send_email(
		  		array(
		  			"sTO" => array(trim($sEmailFrom)), 
		  			"sSenderName" => "GRAMEDIA Prepayment Application", 
		  			"sMessage" => $sEmailMessage, 
		  			"sSubject" => $sEmailSubject));*/
				$this->m_core_apps->gf_send_email_x(array("sFromName" => "Gramedia Prepayment Application", "sEmail" => trim($sEmailFrom), "sEmailSubject" => trim($sEmailSubject), "sEmailMessage" => trim($sEmailMessage)));

		  	//-- Kirim Email ke Atasan dan Bawahan kalau Reject / Approve dari HRD
		  	if(intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdHRD)
		  	{
					$oPath 				 = getcwd().$SP."emails".$SP."approval_pengajuan_pre_payment_for_atasan.eml";
					$libIO 				 = new libIO();
					$sData 				 = $libIO->gf_read_file(array("path" => $oPath));
					$sData 				 = json_decode($sData, TRUE);
		  		$oSQL     		 = trim($sData['txtNativeSQL']);
					$oSQL 				 = str_replace("@nIdPengajuanBS", trim($hideIdTransaksi), $oSQL);
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
					$oPath 				 = getcwd().$SP."emails".$SP."approval_pengajuan_pre_payment_for_hrd.eml";
					$libIO 				 = new libIO();
					$sData 				 = $libIO->gf_read_file(array("path" => $oPath));
					$sData 				 = json_decode($sData, TRUE);
		  		$oSQL     		 = trim($sData['txtNativeSQL']);
					$oSQL 				 = str_replace("@nIdPengajuanBS", trim($hideIdTransaksi), $oSQL);
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
		  	$SQL = "call sp_query('SELECT a.sUUID as sUUIDX, c.sEmail as sEmailPengirim, d.sEmail as sEmailPenerima, a.*, concat(''@siteurl'', ''c_prepayment_pengajuan_pre_payment'') as host, format(nTotalAmount, 0) as nTotalAmountX, date_format(dTglPenyusun, ''%d-%m-%Y'') as dTglPenyusunX, date_format(current_timestamp, ''%d-%m-%Y %H:%i:%s'') as c, b.sNamaKategoriPrePayment, date_format(a.dTglKegiatanAwal, ''%d-%m-%Y'') as dTglKegiatanAwalX, date_format(a.dTglKegiatanAkhir, ''%d-%m-%Y'') as dTglKegiatanAkhirX, __dbname__.gf_global_function(''GetLastStatusPrePayment'', @unit, a.nIdPengajuanBS, ''PENGAJUAN_PRE_PAYMENT'', null, null, null) as sLastStatus FROM tx_prepayment_pengajuan_pp a inner join tm_prepayment_kategori_pre_payment_h b on b.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk inner join tm_prepayment_karyawan c on c.sNIK = a.sNIK inner join tm_prepayment_karyawan d on d.sNIK = a.sNIKAtasan where a.sStatusDelete is null and a.nUnitId_fk = @unit and c.sStatusDelete is null and c.nUnitId_fk = @unit and b.sStatusDelete is null and b.nUnitId_fk = @unit and a.nIdPengajuanBS = ".trim($hideIdTransaksi)."')";
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
		  	$sWAMessage = "YTH *".trim($row['sNamaKaryawan'])."*, ".trim($NEWLINE).trim($NEWLINE)."Pengajuan Pre Payment Bpk/Ibu sbb:".trim($NEWLINE).trim($NEWLINE)."No. Penyusun: *".trim($row['sNoPenyusun'])."*".trim($NEWLINE)."Kategori Pre Payment: *".trim($row['sNamaKategoriPrePayment'])."* ".trim($NEWLINE)."Tgl Kegiatan: *".trim($row['dTglKegiatanAwalX'])."* s/d *".trim($row['dTglKegiatanAkhirX'])."* ".trim($NEWLINE)."Keperluan: *".trim($row['sDeskripsi'])."*".trim($NEWLINE)."Nominal: Rp. *".number_format($row['nTotalAmount'], 0)."* ".trim($NEWLINE).trim($NEWLINE)."Sudah di *".strtoupper(trim($hideStatus))."*. Berikut detail nya:".trim($NEWLINE).$s.trim($NEWLINE).trim($NEWLINE)."Untuk masuk ke Aplikasi silahkan klik link berikut: ".trim($NEWLINE).trim($NEWLINE).trim($BASE_URL).trim($row['sUUIDX']);
		  	//------------------------------------------------
				$this->m_core_apps->gf_send_wa(array("sNoHP" => trim($sNoHPFrom), "sWAMessage" => trim($sWAMessage)));
			  //-- Kirim Email ke Atasan kalau Reject atau APPROVE dari HRD
		  	if(intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdHRD)
		  	{
	  			$sWAMessage = "YTH *".trim($row['sNamaAtasan'])."*, ".trim($NEWLINE).trim($NEWLINE)."Pengajuan Pre Payment *".trim($row['sNamaKaryawan'])."* sbb:".trim($NEWLINE).trim($NEWLINE)."No. Penyusun: *".trim($row['sNoPenyusun'])."*".trim($NEWLINE)."Kategori Pre Payment: *".trim($row['sNamaKategoriPrePayment'])."* ".trim($NEWLINE)."Tgl Kegiatan: *".trim($row['dTglKegiatanAwalX'])."* s/d *".trim($row['dTglKegiatanAkhirX'])."* ".trim($NEWLINE)."Keperluan: *".trim($row['sDeskripsi'])."*".trim($NEWLINE)."Nominal: Rp. *".number_format($row['nTotalAmount'], 0)."* ".trim($NEWLINE).trim($NEWLINE)."Sudah di *".strtoupper(trim($hideStatus))."*. Berikut detail nya:".trim($NEWLINE).$s.trim($NEWLINE).trim($NEWLINE)."Untuk masuk ke Aplikasi silahkan klik link berikut: ".trim($NEWLINE).trim($NEWLINE).trim($BASE_URL).trim($row['sUUIDX']);
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
			  			$sWAMessage = "YTH *".trim($row1['sNamaKaryawan'])."*, ".trim($NEWLINE).trim($NEWLINE)."Pengajuan Pre Payment *".trim($row['sNamaKaryawan'])."* sbb:".trim($NEWLINE).trim($NEWLINE)."No. Penyusun: *".trim($row['sNoPenyusun'])."*".trim($NEWLINE)."Kategori Pre Payment: *".trim($row['sNamaKategoriPrePayment'])."* ".trim($NEWLINE)."Tgl Kegiatan: *".trim($row['dTglKegiatanAwalX'])."* s/d *".trim($row['dTglKegiatanAkhirX'])."* ".trim($NEWLINE)."Keperluan: *".trim($row['sDeskripsi'])."*".trim($NEWLINE)."Nominal: Rp. *".number_format($row['nTotalAmount'], 0)."* ".trim($NEWLINE).trim($NEWLINE)."Sudah di *".strtoupper(trim($hideStatus))."*. Berikut detail nya:".trim($NEWLINE).$s.trim($NEWLINE).trim($NEWLINE)."Mohon segera ditindaklanjuti dengan memberikan keputusan baik itu Approve atau Reject di Aplikasi Pre Payment. Untuk masuk ke Aplikasi silahkan klik link berikut: ".trim($NEWLINE).trim($NEWLINE).trim($BASE_URL).trim($row['sUUIDX']);
							$this->m_core_apps->gf_send_wa(array("sNoHP" => trim($row1['sNoHP']), "sWAMessage" => trim($sWAMessage)));
			  		}
			  	}
			  }
			}
		} 
		return json_encode(array("status" => 1, "message" => $sReturn));
	}
	function gf_get_latest_status_pengajuan_pre_payment($oParam=null)
	{
		$sql = "call sp_query('select a.nGroupUserId_fk, a.sStatus, a.sNIK, a.sNama, (select p.sGroupUserName from tm_user_groups p where p.nGroupUserId = a.nGroupUserId_fk and p.sStatusDelete is null) as sGroupName, date_format(a.dCreateOn, ''%d/%m/%Y %H:%i:%s'') as dCreateOnX from tx_prepayment_tracking a where a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and a.sStatusDelete is null and a.nId_fk = ".trim($oParam['IdTransaksi'])." and a.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by a.dCreateOn desc limit 1');";
		$rs = $this->db->query($sql);
		return json_encode($rs->row_array()	);
	}
	function gf_load_dashboard()
	{
		$sReturn = array();
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$nUserId = $this->session->userdata('nUserId');
		$sNIK = $this->session->userdata('sUserName');
		$nGroupUserOffice = 6;
		$nTigaBulan = 90;

		$nGroupUserIdAktif = intval($this->session->userdata('nGroupUserId_fk'));
		$sql = "call sp_query('select q.nGroupUserId_fk from tm_user_logins p inner join tm_user_logins_groups q on q.nUserId_fk = p.nUserId where p.sStatusDelete is null and q.sStatusDelete is null and p.sUserName = ''".trim($sNIK)."'' limit 1')";
		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$nGroupUserIdAktif = trim($row['nGroupUserId_fk']);
		}
		
		$nGroupUserIdAtasan = $nGroupUserIdAktif - 1; // Semakin kecil, semakin besar jabatan, 0 = Administrator, 7 = HRD
		$nGroupUserIdBawahan = $nGroupUserIdAktif + 1; // Semakin besar, semakin kecil jabatan, 0 = Administrator, 7 = HRD
		$nGroupUserIdHRD = 7; // Grup use HRD 

		$sql = "call sp_query('select 

		/*--------------------------------- OFFICER PENGAJUAN --------------------------*/
		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserOffice." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''SUBMIT'') as cTotalPengajuanPrePaymentX, 

		(select sum(a.nTotalAmount) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserOffice." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''SUBMIT'' /*User*/ ) as cTotalNominalPengajuanPrePaymentX,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) <> ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' /*Manager*/) as cTotalPengajuanPrePaymentApproveByAtasanX,

		(select sum(a.nTotalAmount) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdAtasan." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' /*Manager*/) as cTotalNominalPengajuanPrePaymentApproveByAtasanX,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdAtasan." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'') as cTotalPengajuanPrePaymentRejectByAtasanX,

		(select sum(a.nTotalAmount) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdAtasan." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'') as cTotalNominalPengajuanPrePaymentRejectByAtasanX,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and a.nIdPengajuanBS not in (select p.nIdPengajuanBS_fk from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId.")) as cTotalPengajuanPrePaymentApproveByHRDX,

		(select sum(a.nTotalAmount) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and a.nIdPengajuanBS not in (select p.nIdPengajuanBS_fk from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId.")) as cTotalNominalPengajuanPrePaymentApproveByHRDX,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'') as cTotalPengajuanPrePaymentRejectByHRDX,

		(select  sum(a.nTotalAmount) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'') as cTotalNominalPengajuanPrePaymentRejectByHRDX,

		/*--------------------------------- OFFICER PENYELESAIAN --------------------------*/

		(select count(a.nIdPenyelesaianBS) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdAktif." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''SUBMIT'') as cTotalPenyelesaianPrePaymentX, 

		(select sum(a.nTotalBiayaTerpakai) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdAktif." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''SUBMIT'') as cTotalNominalPenyelesaianPrePaymentX,

		(select count(a.nIdPenyelesaianBS) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)."  and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) <> ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'') as cTotalPenyelesaianPrePaymentApproveByAtasanX,

		(select count(a.nIdPenyelesaianBS) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdAtasan." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'') as cTotalPenyelesaianPrePaymentRejectByAtasanX,

		(select count(a.nIdPenyelesaianBS) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and (select count(a.nIdPenyelesaianBS) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sPosting = ''1'') = 0) as cTotalPenyelesaianPrePaymentApproveByHRDX,

		(select count(a.nIdPenyelesaianBS) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.nUserId_fk = ".trim($nUserId)." and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'') as cTotalPenyelesaianPrePaymentRejectByHRDX,

		(select count(a.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp a inner join tx_prepayment_pengajuan_pp b on b.nIdPengajuanBS = a.nIdPengajuanBS_fk where a.sStatusDelete is null and b.nUserId_fk = ''".trim($nUserId)."'' and a.nUnitId_fk = ".trim($nUnitId)." and b.sStatusDelete is null and b.nUnitId_fk = ".trim($nUnitId)." and a.sPosting = ''1'') as cTotalPenyelesaianPrePaymentPostingByHRDX,

		/*--------------------------------- MANAGER PENGAJUAN ---------------------------*/
		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIKAtasan = ''".trim($sNIK)."''  and /*(select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdBawahan." and*/ (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''SUBMIT'') as cTotalPengajuanPrePaymentButuhApproveAtasanY,

		(select ifnull(sum(a.nTotalAmount), 0) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIKAtasan = ''".trim($sNIK)."'' and /*(select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdBawahan." and*/ (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''SUBMIT'') as cTotalNominalPengajuanPrePaymentButuhApproveAtasanY,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIKAtasan = ''".trim($sNIK)."''  and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = 1 and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'') as cTotalPengajuanPrePaymentSudahApproveAtasanY,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIKAtasan = ''".trim($sNIK)."''  and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = 1 and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'') as cTotalPengajuanPrePaymentRejectByAtasanY,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIKAtasan = ''".trim($sNIK)."'' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = 5 and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and a.nIdPengajuanBS not in (select p.nIdPengajuanBS_fk from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId.")) as cTotalPengajuanPrePaymentApproveByHRDY,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIKAtasan = ''".trim($sNIK)."''  and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = 5 and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'') as cTotalPengajuanPrePaymentRejectByHRDY,

		/*--------------------------------- MANAGER PENYELESAIAN ---------------------------*/
		(select count(a.nIdPenyelesaianBS) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIKAtasan = ''".trim($sNIK)."'' and  (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''SUBMIT'') as cTotalPenyelesaianPrePaymentButuhApproveAtasanY,

		(select sum(a.nTotalBiayaTerpakai) from tx_prepayment_penyelesaian_pp a inner join tx_prepayment_pengajuan_pp b on b.nIdPengajuanBS = a.nIdPengajuanBS_fk where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and b.sStatusDelete is null and b.nUnitId_fk = ".trim($nUnitId)." and b.sNIKAtasan = ''".trim($sNIK)."'' and  (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''SUBMIT'') as cTotalNominalPenyelesaianPrePaymentButuhApproveAtasanY,	

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIKAtasan = ''".trim($sNIK)."'' and  (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = 1 and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'') as cTotalPenyelesaianPrePaymentSudahApproveAtasanY,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIKAtasan = ''".trim($sNIK)."'' and  (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = 1 and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'') as cTotalPenyelesaianPrePaymentRejectByAtasanY,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIK = ''".trim($sNIK)."'' and  (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and (select count(a.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sPosting = ''1'') = 0) as cTotalPenyelesaianPrePaymentApproveByHRDY,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sNIK = ''".trim($sNIK)."'' and  (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'') as cTotalPenyelesaianPrePaymentRejectByHRDY,

		(select count(a.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp a inner join tx_prepayment_pengajuan_pp b on b.nIdPengajuanBS = a.nIdPengajuanBS_fk where a.sStatusDelete is null and b.nUserId_fk = ''".trim($nUserId)."'' and a.nUnitId_fk = ".trim($nUnitId)." and b.sStatusDelete is null and b.nUnitId_fk = ".trim($nUnitId)." and a.sPosting = ''1'') as cTotalPenyelesaianPrePaymentPostingByHRDY,

		/*--------------------------------- HRD PENGAJUAN ---------------------------*/
		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) <> ".$nGroupUserIdHRD.") as cTotalPengajuanPrePaymentButuhApproveHRDZ,

		(select ifnull(sum(a.nTotalAmount), 0) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) <> ".$nGroupUserIdHRD.") as cTotalNominalPengajuanPrePaymentButuhApproveHRDZ,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and  (select p.sStatus from tx_prepayment_tracking p where p.nGroupUserId_fk =  ".$nGroupUserIdHRD." and p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and a.nIdPengajuanBS not in (select p.nIdPengajuanBS_fk from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId.")) as cTotalPengajuanPrePaymentSudahApproveHRDZ,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)."  and  (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENGAJUAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) =  ".$nGroupUserIdHRD.")as cTotalPengajuanPrePaymentRejectByHRDZ,

		/*--------------------------------- HRD PENYELESAIAN ---------------------------*/
		(select count(a.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS_fk and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS_fk and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) <> ".$nGroupUserIdHRD.") as cTotalPenyelesaianPrePaymentButuhApproveHRDZ,

		(select ifnull(sum(a.nTotalBiayaTerpakai), 0) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)."  and  (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nGroupUserId_fk <> ".$nGroupUserIdHRD." AND p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPenyelesaianBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) <> ".$nGroupUserIdHRD.") as cTotalNominalPenyelesaianPrePaymentButuhApproveHRDZ,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and  (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nGroupUserId_fk = ".$nGroupUserIdHRD." AND p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''APPROVE'' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD." and (select count(a.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sPosting = ''1'') = 0) as cTotalPenyelesaianPrePaymentSudahApproveHRDZ,

		(select count(a.nIdPengajuanBS) from tx_prepayment_pengajuan_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and (select p.sStatus from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ''REJECT'' and (select p.nGroupUserId_fk from tx_prepayment_tracking p where p.nId_fk = a.nIdPengajuanBS and p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sTrackingMode = ''PENYELESAIAN_PRE_PAYMENT'' order by p.dCreateOn desc limit 1) = ".$nGroupUserIdHRD.") as cTotalPenyelesaianPrePaymentRejectByHRDZ,

		(select count(a.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp a where a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." and a.sPosting = ''1'') as cTotalPenyelesaianPrePaymentPostingByHRDZ 

		');";

		//print $sql;

		$rs = $this->db->query($sql);
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$sReturn[0] = $row;
		}
		$sql = "call sp_query('select a.*, ".$this->db->database.".gf_global_function(''GetLastStatusPrePayment'', ".trim($nUnitId).", a.nIdPengajuanBS, ''PENGAJUAN_PRE_PAYMENT'', null, null, null) as `sLastStatus` from tx_prepayment_pengajuan_pp a where a.sNIK = ''".trim($sNIK)."'' and a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." order by a.dCreateOn desc limit 5');";
		$row = $this->db->query($sql)->result_array();
		$sReturn[1] = $row;

		$sql = "call sp_query('select a.*, ".$this->db->database.".gf_global_function(''GetLastStatusPrePayment'', ".trim($nUnitId).", a.nIdPenyelesaianBS, ''PENYELESAIAN_PRE_PAYMENT'', null, null, null) as `sLastStatus` from tx_prepayment_penyelesaian_pp a where a.sNIK = ''".trim($sNIK)."'' and a.sStatusDelete is null and a.nUnitId_fk = ".trim($nUnitId)." order by a.dCreateOn desc limit 5');";
		$row = $this->db->query($sql)->result_array();
		$sReturn[2] = $row;

		return json_encode($sReturn);
	}	
	function gf_get_user_approval($oParam=array())
	{
		//Ambil nik atasan berdasarkan user group approval yang sudah di define di user login
		$sql = "call sp_query('select p.sNIK from tm_prepayment_karyawan p inner join tm_user_logins q on q.sUserName = p.sNIK where p.sStatusDelete is null and q.sStatusDelete is null and q.nUserId = ".trim($oParam['nUserId'])." and a.sStatusDelete is null and a.nGroupUserId_fk = ".trim($oParam['nGroupUserId_fk']).")');";
		return $this->db->query($sql)->row_array();
	}
}