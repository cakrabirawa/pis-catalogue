<?php 
/*
------------------------------
Menu Name: Users Map
File Name: m_core_umap.php
File Path: D:\projects\php\odf\application\models\m_core_umap.php
Create Date Time: 2022-01-26 10:14:31
------------------------------
*/
class m_core_umap extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps')); 
	} 
	function gf_transact() 
	{ 
		$hideMode = $this->input->post('hideMode', TRUE); 
		$selGroupUser = $this->input->post('selGroupUser', TRUE); 
		$selUserName = $this->input->post('selUserName', TRUE); 
		$hideUserChildId = $this->input->post('hideUserChildId', TRUE); 
		$hideChkAllowChild = $this->input->post('hideChkAllowChild', TRUE); 
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$sReturn = null; 
		if(in_array(trim($hideMode), array("D"))) 
		{ 
			/*$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => trim($this->db->database), "sFieldName" => "nama_field", "sContent" => "nilai_object_perbandingan", "sValueLabel" => "label_object_warning_ke_client")), TRUE); 
			if(intVal($sRet['status']) === 1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			}*/ 
		} 
		$sql = "";
		for($i=0; $i<count($hideUserChildId); $i++)		
		{	
			$sql .= "call sp_tm_user_logins_child('E', ".trim($selUserName).", ".trim($selGroupUser).", ".($i+1).", ".trim($hideUserChildId[$i]).", null, ".trim($nUnitId).", '".trim($this->session->userdata('sRealName'))."');";
		}
		for($i=0; $i<count($hideUserChildId); $i++)		
		{	
			if(intval($hideChkAllowChild[$i]) === 1)
				$sql .= "call sp_tm_user_logins_child('I', ".trim($selUserName).", ".trim($selGroupUser).", ".($i+1).", ".trim($hideUserChildId[$i]).", null, ".trim($nUnitId).", '".trim($this->session->userdata('sRealName'))."');";
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
}