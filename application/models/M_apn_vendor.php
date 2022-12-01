<?php 
/*
------------------------------
Menu Name: Vendor
File Name: M_apn_vendor.php
File Path: D:\Project\PHP\pis\application\models\M_apn_vendor.php
Create Date Time: 2020-05-22 12:45:53
------------------------------
*/
class m_apn_vendor extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps')); 
	} 
	function gf_load_data($sParam=null) 
	{ 
		$oParam = $_POST; 
		$oData = $sParam === null ? $oParam['Id_Vendor'] : $sParam['Id_Vendor']; 
		$sql = "call sp_query('select sIdVendor, sNamaVendor, sAliasVendor, sVendorEmail, ''Yes'' as sIsPrimary from tm_apn_vendor where sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')." and sIdVendor = ''".trim($oData)."'' ')"; 
		$rs = $this->db->query($sql); 
		return $rs->result_array(); 
	} 
	function gf_transact() 
	{ 
		$hideMode 				= $this->input->post('hideMode', TRUE); 
		$txtIdVendor 			= $this->input->post('txtIdVendor', TRUE); 
		$txtIdVendorOld	 	= $this->input->post('txtIdVendorOld', TRUE);
		$txtNamaVendor 		= $this->input->post('txtNamaVendor', TRUE); 
		$txtNamaVendorOld = $this->input->post('txtNamaVendorOld', TRUE); 
		$txtAliasVendor 	= $this->input->post('txtAliasVendor', TRUE); 
		$txtGroupVendor 	= $this->input->post('txtGroupVendor', TRUE); 
		$txtDataAreaId 		= $this->input->post('txtDataAreaId', TRUE); 
		$txtLocationName 	= $this->input->post('txtLocationName', TRUE); 
		$txtEmail 				= $this->input->post('txtEmail', TRUE); 
		$txtEmailOld			= $this->input->post('txtEmailOld', TRUE); 
		$txtIdLocation 		= $this->input->post('txtIdLocation', TRUE); 
		$sReturn 		      = null; 
		//$UUID = "NULL"; 
		//if(trim($hideMode) !== "I") 
		$UUID = trim($txtIdVendor); 
		if(in_array(trim($hideMode), array("I", "U"))) 
		{ 
			if(strtolower(trim($txtIdVendor)) !== strtolower(trim($txtIdVendorOld))) 
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_apn_vendor", "sFieldName" => "sIdVendor", "sContent" => trim($txtIdVendor))), TRUE); 
				if(intVal($sRet['status']) === 1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			} 
			if(strtolower(trim($txtNamaVendor)) !== strtolower(trim($txtNamaVendorOld))) 
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_apn_vendor", "sFieldName" => "sNamaVendor", "sContent" => trim($txtNamaVendor))), TRUE); 
				if(intVal($sRet['status']) === 1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			} 
			if(strtolower(trim($txtEmail)) !== strtolower(trim($txtEmailOld))) 
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_apn_vendor", "sFieldName" => "sVendorEmail", "sContent" => trim($txtEmail))), TRUE); 
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
			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => trim($this->db->database), "sFieldName" => "nIdVendor_fk", "sContent" => trim($txtIdVendor), "sValueLabel" => "Id Vendor")), TRUE); 
			if(intVal($sRet['status']) === 1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
		} 

		$sql = "call sp_tm_apn_vendor('".trim($hideMode)."', '".trim($UUID)."', '".trim($txtNamaVendor)."', '".trim($txtAliasVendor)."', '".trim($txtEmail)."', NULL, ".$this->session->userdata('nUnitId_fk').", '".trim($this->session->userdata('sRealName'))."'); "; 
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
}