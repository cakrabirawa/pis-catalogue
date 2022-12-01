<?php /*------------------------------Menu Name: Status TXFile Name: M_apn_status_tx.phpFile Path: D:\Project\PHP\pis\application\models\M_apn_status_tx.phpCreate Date Time: 2020-05-22 12:45:53------------------------------*/class m_apn_status_tx extends CI_Model { 	public function __construct() 	{ 		parent::__construct(); 		$this->load->model(array('m_core_apps')); 	} 	function gf_load_data($sParam=null) 	{ 		$oParam = $_POST; 		$oData = $sParam === null ? $oParam['Id_Status_TX'] : $sParam['Id_Status_TX']; 		$sql = "call sp_query('select nIdStatusTX, sNamaStatusTX from tm_apn_status_tx where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and nIdStatusTX = ''".trim($oData)."'' ')"; 		$rs = $this->db->query($sql); 		return $rs->result_array(); 	} 	function gf_transact() 	{ 		$hideMode 					= $this->input->post('hideMode', TRUE); 		$txtIdStatusTX 			= $this->input->post('txtIdStatusTX', TRUE); 		$txtNamaStatusTX 		= $this->input->post('txtNamaStatusTX', TRUE); 		$txtNamaStatusTXOld = $this->input->post('txtNamaStatusTXOld', TRUE); 		$sReturn = null; 		$UUID = "NULL"; 		if(trim($hideMode) !== "I") 			$UUID = trim($txtIdStatusTX); 		if(in_array(trim($hideMode), array("I", "U"))) 		{ 			if(strtolower(trim($txtNamaStatusTX)) !== strtolower(trim($txtNamaStatusTXOld))) 			{ 				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_apn_status_tx", "sFieldName" => "sNamaStatusTX", "sContent" => trim($txtNamaStatusTX))), TRUE); 				if(intVal($sRet['status']) === 1) 				{ 					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 					return $sReturn; 					exit(0); 				} 			} 		} 		if(in_array(trim($hideMode), array("D"))) 		{ 			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => trim($this->db->database), "sFieldName" => "nIdStatusTX_fk", "sContent" => trim($txtIdStatusTX), "sValueLabel" => "Id StatusTX")), TRUE); 			if(intVal($sRet['status']) === 1) 			{ 				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 				return $sReturn; 				exit(0); 			} 		} 		$sql = "call sp_tm_apn_status_tx('".trim($hideMode)."', ".trim($UUID).", '".trim($txtNamaStatusTX)."', NULL, ".$this->session->userdata('nUnitId_fk').", '".trim($this->session->userdata('sRealName'))."'); "; 		$this->db->trans_begin(); 		$this->db->query($sql); 		if ($this->db->trans_status() === FALSE) 		{ 			$this->db->trans_rollback(); 			$sReturn = json_encode(array("status" => -1, "message" => "Failed")); 		} 		else 		{ 			$this->db->trans_commit(); 			$sReturn = json_encode(array("status" => 1, "message" => "Data has been Submitted.")); 		} 		return $sReturn; 	} }