<?php 
/*
------------------------------
Menu Name: Logbook Penerimaan
File Name: M_apn_logbook_penerimaan.php
File Path: D:\Project\PHP\apn\application\models\M_apn_logbook_penerimaan.php
Create Date Time: 2020-06-19 07:58:08
------------------------------
*/
class m_apn_logbook_penerimaan extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps', 'm_core_email_engine')); 
		$this->load->library(array('libIO')); 
	} 
	function gf_load_data($sParam=null) 
	{ 
		$oParam = $_POST; 
		//print_r($oParam);
		$oData = $sParam === null ? $oParam['Id_Penerimaan'] : $sParam['Id_Penerimaan']; 
		$sql = "call sp_query('select b.sVendorEmail, a.nQty, b.sNamaVendor, null as dTglRejectX, a.nIdPenerimaan, a.sIdVendor_fk, a.nIdStatusTX_fk, a.sNoTiket, a.nNominal, date_format(a.dTglPenerimaan, ''%d/%m/%Y'') as dTglPenerimaanX, date_format(a.dTglEstimasiPayment, ''%d/%m/%Y'') as dTglEstimasiPaymentX, a.nIdStatusDokumen_fk, a.dTglEstimasiPayment, a.sNotes, a.sNamaPIC from tx_apn_logbook_penerimaan a inner join tm_apn_vendor b on b.sIdVendor = a.sIdVendor_fk where a.sStatusDelete is null and a.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and b.sStatusDelete is null and b.nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and a.nIdPenerimaan = ".trim($oData)."')"; 
		$rs = $this->db->query($sql); 
		return $rs->result_array(); 
	} 
	function gf_transact() 
	{ 
		$hideMode 						 = $this->input->post('hideMode', TRUE); 
		$txtIdPenerimaan 			 = $this->input->post('txtIdPenerimaan', TRUE); 
		$txtTglPenerimaan 		 = $this->input->post('txtTglPenerimaan', TRUE); 
		$txtIdVendor 					 = $this->input->post('txtIdVendor', TRUE); 		
		$selStatusTX 					 = $this->input->post('selStatusTX', TRUE); 
		$selStatusDokumen 		 = $this->input->post('selStatusDokumen', TRUE); 
		$txtNoTiket 					 = $this->input->post('txtNoTiket', TRUE); 
		$txtNoTiketOld	 			 = $this->input->post('txtNoTiketOld', TRUE);
		$txtNominal 					 = $this->input->post('txtNominal', TRUE); 
		$txtTglEstimasiPayment = $this->input->post('txtTglEstimasiPayment', TRUE); 
		$txtTglReject 				 = $this->input->post('txtTglReject', TRUE); 
		$txtNamaPIC 					 = $this->input->post('txtNamaPIC', TRUE); 
		$txtCatatan 				 	 = $this->input->post('txtCatatan', TRUE); 
		$txtQty 				 	 			= $this->input->post('txtQty', TRUE); 
		$sReturn = null; 
		if(in_array(trim($hideMode), array("I", "U"))) 
		{ 
			/*
			if(strtolower(trim($nama_object_perbandingan_baru)) !== strtolower(trim($nama_object_perbandingan_lama))) 
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "nama_table", "sFieldName" => "nama_field", "sContent" => "nilai_object_perbandingan")), TRUE); 
				if(intVal($sRet['status']) === 1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			}
			*/ 
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_apn_vendor", "sFieldName" => "sIdVendor", "sContent" => trim($txtIdVendor))), TRUE); 
			if(intVal($sRet['status']) === -1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_apn_status_tx", "sFieldName" => "nIdStatusTX", "sContent" => trim($selStatusTX))), TRUE); 
			if(intVal($sRet['status']) === -1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_apn_status_dokumen", "sFieldName" => "nIdStatusDokumen", "sContent" => trim($selStatusDokumen))), TRUE); 
			if(intVal($sRet['status']) === -1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
			if(strtolower(trim($txtNoTiket)) !== strtolower(trim($txtNoTiketOld))) 
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tx_apn_logbook_penerimaan", "sFieldName" => "sNoTiket", "sContent" => trim($txtNoTiket))), TRUE); 
				if(intVal($sRet['status']) === 1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			}
		} 
		if(in_array(trim($hideMode), array("D"))) 
		{ 
			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => trim($this->db->database), "sFieldName" => "nama_field", "sContent" => "nilai_object_perbandingan", "sValueLabel" => "label_object_warning_ke_client")), TRUE); 
			if(intVal($sRet['status']) === 1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
		} 

		$this->db->trans_begin(); 

		$UUID = $this->m_core_apps->gf_max_int_id(array("sFieldName" => "nIdPenerimaan", "sTableName" => "tx_apn_logbook_penerimaan", "sParam" => " where nUnitId_fk = ".$this->session->userdata('nUnitId_fk'))); 
		if(trim($hideMode) !== "I") 
			$UUID = trim($txtIdPenerimaan); 

		$sReceiptNo = $this->m_core_apps->gf_get_max_date_pattern(array("sPrefix" => (intval($selStatusDokumen) === 1 ? "A." : "R."), "nLength" => 4, "sTableName" => "tx_apn_email_log_track", "sFieldName" => "sReceiptNo", "sParams" => " and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')));

		$sTglReject = "null";
		$sTglEstimasiPayment = "null";

		if(intval($selStatusDokumen) === 1) //Approve
			$sTglEstimasiPayment = "'".$this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglEstimasiPayment), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))."'";
		else if(intval($selStatusDokumen) === 2) //Reject
			$sTglReject = "'".$this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglReject), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))."'";

		$sql = "call sp_tx_apn_logbook_penerimaan('".$hideMode."', ".trim($UUID).", '".trim($txtIdVendor)."', ".trim($selStatusTX).", '".trim($txtNoTiket)."', ".str_replace(",", "", trim($txtNominal)).", '".$this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglPenerimaan), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))."', ".trim($selStatusDokumen).", ".trim($sTglEstimasiPayment).", ".trim($sTglReject).", '".trim($txtCatatan)."', '".trim($txtNamaPIC)."', null, ".$this->session->userdata('nUnitId_fk').", '".trim($this->session->userdata('sRealName'))."', ".(trim($txtQty) === "" ? 0 : trim($txtQty)).");"; 
		$this->db->query($sql); 

		$sql = "call sp_query('select sVendorEmail from tm_apn_vendor where sIdVendor = ''".trim($txtIdVendor)."'' and sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')."')";
		$rs = $this->db->query($sql);
		$sVendorEmailX = $this->session->userdata('sUserName');
		$sVendorEmail = "";
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$sVendorEmail = trim($row['sVendorEmail']);
		}

		$sql = "call sp_tx_apn_email_log_track('I', ".trim($UUID).", '".trim($sVendorEmail)."', '".trim($sReceiptNo)."', CURRENT_TIMESTAMP, ".trim($selStatusDokumen).", ".trim($selStatusTX).", ".str_replace(",", "", trim($txtNominal)).", '".$this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtTglPenerimaan), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))."', ".trim($sTglEstimasiPayment).", ".trim($sTglReject).", '".trim($sReceiptNo)."', '".trim($txtNamaPIC)."', null, ".$this->session->userdata('nUnitId_fk').", '".trim($this->session->userdata('sRealName'))."');"; 

		$this->db->query($sql); 
		if ($this->db->trans_status() === FALSE) 
		{ 
			$this->db->trans_rollback(); 
			$sReturn = json_encode(array("status" => -1, "message" => "Failed")); 
		} 
		else 
		{ 
			$this->db->trans_commit(); 
			//-- Load Email Template
			$SP 					 = DIRECTORY_SEPARATOR;
			$oPath 				 = getcwd().$SP."emails".$SP."send_email_to_vendor.eml";
			$libIO 				 = new libIO();
			$sData 				 = $libIO->gf_read_file(array("path" => $oPath));
			$sData 				 = json_decode($sData, TRUE);
			$oSQL     		 = trim($sData['txtNativeSQL']);
			$oSQL 				 = str_replace("@nIdPenerimaan", $UUID, $oSQL);
			$oConvert 		 = $this->m_core_email_engine->gf_convert_rpt_engine(array("content" => trim($sData['txtNativeHTML']), "sql" => $oSQL));
			//--
			$sEmailMessage = $oConvert;
			$sEmailSubject = "Tanda terima faktur-Receipt: ".trim($sReceiptNo). " (do not reply)"; 
			$this->m_core_apps->gf_send_email_x(array("sFromName" => "Account Payable PT GRAMEDIA ASRI MEDIA", "sEmail" => "labirin69@gmail.com", "sEmailSubject" => trim($sEmailSubject), "sEmailMessage" => trim($sEmailMessage)));
			$sReturn = json_encode(array("status" => 1, "message" => "Data has been Submitted.", "idpenerimaan" => $UUID)); 
		} 

		return $sReturn; 
	} 
}