<?php 
class m_prepayment_komponen_pre_payment extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps')); 
	} 
	function gf_load_data($sParam=null) 
	{ 
		$oParam = $_POST; 
		$oData = $sParam === null ? $oParam['Id_Komponen_Pre_Payment'] : $sParam['Id_Komponen_Pre_Payment']; 
		$sql = "call sp_query('select sAllowMultiply, nIdKomponen, nDigit, sSatuan, nDecimalPoint, sLabel, sNamaKomponen, sTipeDataKomponen, sAllowSummary from tm_prepayment_komponen_pre_payment where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and nIdKomponen = ".trim($oData)."')"; 
		$rs = $this->db->query($sql); 
		return $rs->result_array(); 
	} 
	function gf_transact() 
	{ 
		$txtIdKomponen 			= $this->input->post('txtIdKomponen', TRUE); 
		$txtNamaKomponen 		= $this->input->post('txtNamaKomponen', TRUE); 
		$txtNamaKomponenOld = $this->input->post('txtNamaKomponenOld', TRUE); 
		$selTipeData 				= $this->input->post('selTipeData', TRUE); 
		$selAllowSummary 		= $this->input->post('selAllowSummary', TRUE); 
		$txtSatuan 					= $this->input->post('txtSatuan', TRUE); 
		$selAllowMultiply 	= $this->input->post('selAllowMultiply', TRUE); 
	
		$txtNamaLabel 			= $this->input->post('txtNamaLabel', TRUE); 	
		$txtNamaLabelOld 		= $this->input->post('txtNamaLabelOld', TRUE); 

		$txtDigit 					= $this->input->post('txtDigit', TRUE); 
		$txtDecPoint 				= $this->input->post('txtDecPoint', TRUE); 
		$hideMode 					= $this->input->post('hideMode', TRUE); 


		//array
		$selPosisi 					= $this->input->post('selPosisi', TRUE); 
		$txtNominal					= $this->input->post('txtNominal', TRUE); 
		$hideEnabledNominal	= $this->input->post('hideEnabledNominal', TRUE); 
		$hideQtyKegiatan		= $this->input->post('hideQtyKegiatan', TRUE); 
		$txtQtyPenyesuaian	= $this->input->post('txtQtyPenyesuaian', TRUE); 
		$txtPotongan				= $this->input->post('txtPotongan', TRUE); 

		$sReturn = null; 
		$UUID = $this->m_core_apps->gf_max_int_id(array("sFieldName" => "nIdKomponen", "sTableName" => "tm_prepayment_komponen_pre_payment", "sParam" => " where nUnitId_fk	= ".$this->session->userdata('nUnitId_fk')." and sStatusDelete	 is null")); 
		if(trim($hideMode) !== "I") 
			$UUID = trim($txtIdKomponen); 
		if(in_array(trim($hideMode), array("I", "U"))) 
		{ 
			if(strtolower(trim($txtNamaKomponen)) !== strtolower(trim($txtNamaKomponenOld))) 
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_komponen_pre_payment", "sFieldName" => "sNamaKomponen", "sContent" => trim($txtNamaKomponen))), TRUE); 
				if(intVal($sRet['status']) === 1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			} 
			if(strtolower(trim($txtNamaLabel)) !== strtolower(trim($txtNamaLabelOld))) 
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_komponen_pre_payment", "sFieldName" => "sLabel", "sContent" => trim($txtNamaLabel))), TRUE); 
				if(intVal($sRet['status']) === 1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			} 
			for($i=0; $i<count($selPosisi); $i++)
			{
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_user_groups", "sFieldName" => "nGroupUserId", "bDisabledUnitId" => true, "sContent" => trim($selPosisi[$i]))), TRUE); 
				if(intVal($sRet['status']) === -1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			}
		} 
		if(in_array(trim($hideMode), array("D"))) 
		{ 
			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => trim($this->db->database), "sFieldName" => "nIdKomponen_fk", "sContent" => trim($txtIdKomponen), "sValueLabel" => "Id PaymentType")), TRUE); 
			if(intVal($sRet['status']) === 1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
		} 
		$sql = "call sp_tm_prepayment_komponen_pre_payment('".$hideMode."', ".trim($UUID).", '".trim($txtNamaKomponen)."', '".trim($selTipeData)."', '".(trim($selAllowSummary) === "" || empty($selAllowSummary) ? "0" : "1")."', ".trim($txtDigit).", ".trim($txtDecPoint).", '".trim($txtSatuan)."', '".trim($txtNamaLabel)."', NULL, ".$this->session->userdata('nUnitId_fk').", '".trim($this->session->userdata('sRealName'))."', '".(trim($selAllowMultiply) === "" || empty($selAllowMultiply) ? "0" : "1")."');"; 


		if(!in_array(trim($hideMode), array("I"))) 	
			$sql .= "call sp_tm_prepayment_komponen_pre_payment_rule ('D', ".trim($UUID).", null, null, null, null, null, null, null, ".$this->session->userdata('nUnitId_fk').", null, '".$this->session->userdata('sRealName')."');";	

		if(!in_array(trim($hideMode), array("D"))) 	
		{
			$c = count($selPosisi);	
			for($i=0; $i<$c; $i++)	
			{
				if(trim($selPosisi[$i]) !== "")
					$sql .= "call sp_tm_prepayment_komponen_pre_payment_rule ('I', ".trim($UUID).", ".trim($selPosisi[$i]).", ".trim($txtNominal[$i]).", '".trim($hideEnabledNominal[$i])."', '".trim($hideQtyKegiatan[$i])."', ".trim($txtPotongan[$i]).", ".trim($txtQtyPenyesuaian[$i]).", null, ".$this->session->userdata('nUnitId_fk').", ".($i+1).", '".$this->session->userdata('sRealName')."');";	
			}
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
		} 
		return $sReturn; 
	} 
	function gf_load_detail($oParam=array())
	{
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$sJabatan = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nGroupUserId, sGroupUserName  from tm_user_groups where sStatusDelete is null and nGroupUserId > 0", "sFieldId" => "nGroupUserId", "sFieldValues" => "sGroupUserName"));	
		$sReturn = "<table id=\"tableDetail\" class=\"".$oConfig['TABLE_CLASS']."\">";
		$sReturn .= "<tr><td>No</td><td>Jabatan</td><td>Nominal Default</td><td>Enabled Nominal</td><td>Qty Kegiatan</td><td>Qty Penyesuaian (+/-)</td><td>% Potongan</td><td class=\"text-center\"><i id=\"iClearAllRow\" class=\"fa fa-trash fa-2x text-red cursor-pointer\" title=\"Remove all Row\"></i></td></tr>";

		if(count($oParam) > 0)
		{
			$sql = "call sp_query('select nIdKomponen_fk, nGroupUserId_fk, nNominal, sFlagEnabledDisabledNominal, sFlagQtyFromPeriodeTglKegiatan, nPersenPotongan, nQtyPenyesuaianPeriodeTglKegiatan, nSeqNo from tm_prepayment_komponen_pre_payment_rule where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and nIdKomponen_fk = ".trim($oParam['nIdKomponen'])."');";
			$rs = $this->db->query($sql);
			if($rs->num_rows() > 0)
			{
				$oNo = 1;
				foreach($rs->result_array() as $row)
				{
					$sJabatan = $this->m_core_apps->gf_load_select_option(array("sSQL" => "select nGroupUserId, sGroupUserName  from tm_user_groups where sStatusDelete is null and nGroupUserId > 0", "sFieldId" => "nGroupUserId", "sFieldValues" => "sGroupUserName", "sFieldInitValue" => $row['nGroupUserId_fk']));	
					$sReturn .= "<tr><td>".$oNo."</td><td><select name=\"selPosisi[]\" placeholder=\"Jabatan\" title=\"Pilih Komponen Pre Payment ini akan di Masukan ke Grup Karyawan apa ?\" id=\"selPosisi\" class=\"form-control selectpicker\" allow-empty=\"\false\" data-size=\"8\" data-live-search=\"true\">".trim($sJabatan)."</select></td><td><input placeholder=\"Nilai Default\" title=\"Nilai default Nominal pada saat penginputan Pre Payment\" type=\"text\" content-mode=\"numeric\" allow-empty=\"\false\" name=\"txtNominal[]\" value=\"".trim($row['nNominal'])."\" id=\"txtNominal\" class=\"form-control\" /></td><td class=\"text-center\"><input title=\"Jika di ceklis, maka pada saat penginputan Pre Payment Input text Nominal akan Enabled atau sebaliknya.\" type=\"checkbox\" ".(trim($row['sFlagEnabledDisabledNominal']) === "1" ? "checked" : "")." name=\"chkEnabledNominal[]\" placeholder=\"Ceklis Enabled Nominal\" id=\"chkEnabledNominal\" /><input type=\"hidden\" name=\"hideEnabledNominal[]\" id=\"hideEnabledNominal\" value=\"".trim($row['sFlagEnabledDisabledNominal'])."\" /></td><td class=\"text-center\"><input data-toggle=\"tooltip\" ".(trim($row['sFlagQtyFromPeriodeTglKegiatan']) === "1" ? "checked" : "")." data-placement=\"top\" title=\"Jika di ceklis, maka Nilai Qty pada saat input Pre Payment akan di ambil dari Tgl Kegiatan awal - Tgl Kegiatan Akhir.\" type=\"checkbox\" placeholder=\"Ceklis Enabled Kegiatan\" name=\"chkQtyKegiatan[]\" id=\"chkQtyKegiatan\"/><input type=\"hidden\" name=\"hideQtyKegiatan[]\" id=\"hideQtyKegiatan\" value=\"".trim($row['sFlagQtyFromPeriodeTglKegiatan'])."\" /></td><td><input title=\"Input dengan tanda -(minus) atau plus(tidak usah pakai tanda) untuk otomatis Qty akan di tambah atau di kurangkan pada saat input Pre Payment\" type=\"text\" placeholder=\"Qty Penyesuaian\" value=\"".trim($row['nQtyPenyesuaianPeriodeTglKegiatan'])."\" content-mode=\"numeric\" allow-empty=\"\false\" name=\"txtQtyPenyesuaian[]\" id=\"txtQtyPenyesuaian\" class=\"form-control\" /></td><td><input placeholder=\"Potongan\" value=\"".trim($row['nPersenPotongan'])."\" type=\"text\" content-mode=\"numeric\" allow-empty=\"\false\" title=\"Jika nominal ada potongan, isi dengan nilai 1-100 %\" name=\"txtPotongan[]\" id=\"txtPotongan\" class=\"form-control\" /></td><td class=\"text-center\"><a id=\"cmdRemoveListJabatan\" name=\"cmdRemoveListJabatan\" class=\"cursor-pointer\" title=\"Remove this Jabatan\"><i class=\"fa fa-trash fa-2x text-red\"></i></a></td></tr>";
					$oNo++;
				}
			}
			else
			{
				$sReturn .= "<tr><td>1</td><td><select name=\"selPosisi[]\" placeholder=\"Jabatan\" title=\"Pilih Komponen Pre Payment ini akan di Masukan ke Grup Karyawan apa ?\" id=\"selPosisi\" class=\"form-control selectpicker\" allow-empty=\"\false\" data-size=\"8\" data-live-search=\"true\">".trim($sJabatan)."</select></td><td><input placeholder=\"Nilai Default\" title=\"Nilai default Nominal pada saat penginputan Pre Payment\" type=\"text\" content-mode=\"numeric\" allow-empty=\"\false\" value=\"0\" name=\"txtNominal[]\" id=\"txtNominal\" class=\"form-control\" /></td><td class=\"text-center\"><input title=\"Jika di ceklis, maka pada saat penginputan Pre Payment Input text Nominal akan Enabled atau sebaliknya.\" type=\"checkbox\" name=\"chkEnabledNominal[]\" placeholder=\"Ceklis Enabled Nominal\" id=\"chkEnabledNominal\" /><input type=\"hidden\" name=\"hideEnabledNominal[]\" id=\"hideEnabledNominal\" value=\"0\" /></td><td class=\"text-center\"><input title=\"Jika di ceklis, maka Nilai Qty pada saat input Pre Payment akan di ambil dari Tgl Kegiatan awal - Tgl Kegiatan Akhir.\" type=\"checkbox\" placeholder=\"Ceklis Enabled Kegiatan\" name=\"chkQtyKegiatan[]\" id=\"chkQtyKegiatan\"/><input type=\"hidden\" name=\"hideQtyKegiatan[]\" id=\"hideQtyKegiatan\" value=\"0\" /></td><td><input title=\"Input dengan tanda -(minus) atau plus(tidak usah pakai tanda) untuk otomatis Qty akan di tambah atau di kurangkan pada saat input Pre Payment\" type=\"text\" placeholder=\"Qty Penyesuaian\" value=\"0\" content-mode=\"numeric\" allow-empty=\"\false\" name=\"txtQtyPenyesuaian[]\" id=\"txtQtyPenyesuaian\" class=\"form-control\" /></td><td><input placeholder=\"Potongan\" value=\"0\" type=\"text\" content-mode=\"numeric\" allow-empty=\"\false\" title=\"Jika nominal ada potongan, isi dengan nilai 1-100 %\" name=\"txtPotongan[]\" id=\"txtPotongan\" class=\"form-control\" /></td><td class=\"text-center\"><a id=\"cmdRemoveListJabatan\" name=\"cmdRemoveListJabatan\" class=\"cursor-pointer\" title=\"Remove this Jabatan\"><i class=\"fa fa-trash fa-2x text-red\"></i></a></td></tr>";
			}
		}	
		else
		{
			$sReturn .= "<tr><td>1</td><td><select name=\"selPosisi[]\" placeholder=\"Jabatan\" title=\"Pilih Komponen Pre Payment ini akan di Masukan ke Grup Karyawan apa ?\" id=\"selPosisi\" class=\"form-control selectpicker\" allow-empty=\"\false\" data-size=\"8\" data-live-search=\"true\">".trim($sJabatan)."</select></td><td><input placeholder=\"Nilai Default\" title=\"Nilai default Nominal pada saat penginputan Pre Payment\" type=\"text\" content-mode=\"numeric\" allow-empty=\"\false\" value=\"0\" name=\"txtNominal[]\" id=\"txtNominal\" class=\"form-control\" /></td><td class=\"text-center\"><input title=\"Jika di ceklis, maka pada saat penginputan Pre Payment Input text Nominal akan Enabled atau sebaliknya.\" type=\"checkbox\" name=\"chkEnabledNominal[]\" placeholder=\"Ceklis Enabled Nominal\" id=\"chkEnabledNominal\" /><input type=\"hidden\" name=\"hideEnabledNominal[]\" id=\"hideEnabledNominal\" value=\"0\" /></td><td class=\"text-center\"><input title=\"Jika di ceklis, maka Nilai Qty pada saat input Pre Payment akan di ambil dari Tgl Kegiatan awal - Tgl Kegiatan Akhir.\" type=\"checkbox\" placeholder=\"Ceklis Enabled Kegiatan\" name=\"chkQtyKegiatan[]\" id=\"chkQtyKegiatan\"/><input type=\"hidden\" name=\"hideQtyKegiatan[]\" id=\"hideQtyKegiatan\" value=\"0\" /></td><td><input title=\"Input dengan tanda -(minus) atau plus(tidak usah pakai tanda) untuk otomatis Qty akan di tambah atau di kurangkan pada saat input Pre Payment\" type=\"text\" placeholder=\"Qty Penyesuaian\" value=\"0\" content-mode=\"numeric\" allow-empty=\"\false\" name=\"txtQtyPenyesuaian[]\" id=\"txtQtyPenyesuaian\" class=\"form-control\" /></td><td><input placeholder=\"Potongan\" value=\"0\" type=\"text\" content-mode=\"numeric\" allow-empty=\"\false\" title=\"Jika nominal ada potongan, isi dengan nilai 1-100 %\" name=\"txtPotongan[]\" id=\"txtPotongan\" class=\"form-control\" /></td><td class=\"text-center\"><a id=\"cmdRemoveListJabatan\" name=\"cmdRemoveListJabatan\" class=\"cursor-pointer\" title=\"Remove this Jabatan\"><i class=\"fa fa-trash fa-2x text-red\"></i></a></td></tr>";
		}
		$sReturn .= "</table>";
		return $sReturn;
	}
}