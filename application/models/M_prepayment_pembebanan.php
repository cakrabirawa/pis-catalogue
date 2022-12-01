<?php class m_prepayment_pembebanan extends CI_Model { 	public function __construct() 	{ 		parent::__construct(); 		$this->load->model(array('m_core_apps')); 	} 	function gf_load_data($sParam=null) 	{ 		$oParam = $_POST; 		$oData = $sParam === null ? $oParam['Id_Pembebanan'] : $sParam['Id_Pembebanan']; 		$sql = "call sp_query('select sEntity, sIdPembebanan, sNamaPembebanan from tm_prepayment_pembebanan where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and sIdPembebanan = ''".trim($oData)."'' and sEntity = ''".trim($oParam['Entity'])."'' ')"; 		$rs = $this->db->query($sql); 		return $rs->result_array(); 	} 	function gf_transact() 	{ 		$txtIdPembebanan = $this->input->post('txtIdPembebanan', TRUE); 		$txtIdPembebananOld = $this->input->post('txtIdPembebananOld', TRUE); 		$txtEntity = $this->input->post('txtEntity', TRUE); 		$txtNamaPembebanan = $this->input->post('txtNamaPembebanan', TRUE); 		$txtNamaPembebananOld = $this->input->post('txtNamaPembebananOld', TRUE); 		$hideMode = $this->input->post('hideMode', TRUE); 		$sReturn = null; 		$UUID = "NULL"; 		if(trim($hideMode) !== "I") 			$UUID = trim($txtIdPembebanan); 		if(in_array(trim($hideMode), array("I", "U"))) 		{ 			if(strtolower(trim($txtIdPembebanan)) !== strtolower(trim($txtIdPembebananOld))) 			{ 				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_pembebanan", "sFieldName" => "sIdPembebanan", "sContent" => trim($txtIdPembebanan))), TRUE); 				if(intVal($sRet['status']) === 1) 				{ 					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 					return $sReturn; 					exit(0); 				} 			} 			if(strtolower(trim($txtNamaPembebanan)) !== strtolower(trim($txtNamaPembebananOld))) 			{ 				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_pembebanan", "sFieldName" => "sNamaPembebanan", "sContent" => trim($txtNamaPembebanan))), TRUE); 				if(intVal($sRet['status']) === 1) 				{ 					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 					return $sReturn; 					exit(0); 				} 			} 		} 		if(in_array(trim($hideMode), array("D"))) 		{ 			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => "prepaymentdb", "sFieldName" => "nIdPembebanan_fk", "sContent" => trim($txtIdPembebanan), "sValueLabel" => "Id Pembebanan")), TRUE); 			if(intVal($sRet['status']) === 1) 			{ 				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 				return $sReturn; 				exit(0); 			} 		} 		$sql = "call sp_tm_prepayment_pembebanan('".$hideMode."', ".trim($txtIdPembebanan).", '".trim($txtNamaPembebanan)."', '".trim($txtIdPembebananOld)."', '".trim($txtEntity)."', NULL, ".$this->session->userdata('nUnitId_fk').", '".trim($this->session->userdata('sRealName'))."')"; 		$this->db->trans_begin(); 		$this->db->query($sql); 		if ($this->db->trans_status() === FALSE) 		{ 			$this->db->trans_rollback(); 			$sReturn = json_encode(array("status" => -1, "message" => "Failed")); 		} 		else 		{ 			$this->db->trans_commit(); 			$sReturn = json_encode(array("status" => 1, "message" => "Data has been Submitted.")); 		} 		return $sReturn; 	} }