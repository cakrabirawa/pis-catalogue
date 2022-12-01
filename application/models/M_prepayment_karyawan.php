<?php 
/*
------------------------------
Menu Name: Karyawan
File Name: M_prepayment_karyawan.php
File Path: D:\Project\PHP\prepayment\application\models\M_prepayment_karyawan.php
Create Date Time: 2020-01-16 11:40:20
------------------------------
*/
class m_prepayment_karyawan extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps')); 
	} 
	function gf_begin_import()
	{
		$DS = DIRECTORY_SEPARATOR;
		$hideFileName = $this->input->post('hideFileName', TRUE);
		$s = file_get_contents(getcwd().$DS."uploads".$DS."csv".$DS.$hideFileName);
		//-------------------------------------------------------------------------
		$row = explode("\n", trim($s));
		$this->db->trans_begin(); 
		//$sql = "delete from tm_user_logins where sUserName in (select sNIK from tm_prepayment_karyawan);";
		$sql = "truncate table tm_prepayment_karyawan;";	
		$this->db->query($sql); 
		for($i=1; $i<count($row); $i++)
		{
			$col = explode(",", trim($row[$i]));
			$sql = "call sp_query('insert into tm_prepayment_karyawan (sNIK, sNamaKaryawan, sNamaUnitUsaha, sBagian, sNamaBank, sCabangBank, sNoRekening, sAtasNamaRekening, sCreateBy, dCreateOn, sUUID, nUnitId_fk) values (''".trim($col[0])."'', ''".str_replace("'", "''''", trim($col[1]))."'', ''".trim($col[2])."'', ''".trim($col[3])."'', ''".trim($col[4])."'', ''".trim($col[5])."'', ''".trim($col[6])."'', ''".strtoupper( str_replace("'", "''''", trim($col[7])))."'', ''".$this->session->userdata('sRealName')."'', CURRENT_TIMESTAMP, md5(uuid()), ".$this->session->userdata('nUnitId_fk').")');";
			$this->db->query($sql); 
			$sql = "call sp_query('select count(1) as c from tm_user_logins where sUserName = ''".trim($col[0])."'' and sStatusDelete is null');";
			$rs = $this->db->query($sql);
			if($rs->num_rows() > 0)
			{
				$rows = $rs->row_array();
				if(intval($rows['c']) === 0)
				{
					//-- Insert as Login
					$UUID = $this->m_core_apps->gf_max_int_id(array("sFieldName" => "nUserId", "sTableName" => "tm_user_logins", "sParam" => ""));
					$sql =  "call sp_tm_user_logins ('I', ".trim($UUID).", '".trim($col[0])."', '".trim(str_replace("'", "''''", trim($col[1])))."', '".trim($col[0])."', '".trim($col[0])."#@!', 2, null, null, null, '".trim($this->session->userdata('sRealName'))."');";
					$this->db->query($sql); 
					$sql = "call sp_tm_user_units ('I', ".trim($UUID).", 1, 1, null, '".trim($this->session->userdata('sRealName'))."');";
					$this->db->query($sql); 
				}
			}
		}
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
		//-------------------------------------------------------------------------
		return json_encode(array("sContent" => $s));
	} 
	function gf_load_info_karyawan()
	{
		$sNIK 					= $this->input->post('sNIK', TRUE);
		$nUnitId 				= $this->session->userdata('nUnitId_fk');
		$nIdPengajuanBS = $this->input->post('nIdPengajuanBS', TRUE);
		$nGroupUserId  	= $this->session->userdata('nGroupUserId_fk');		
		$nUserId  			= $this->session->userdata('nUserId');		

		if(trim($nIdPengajuanBS) !== "(AUTO)")
			$sql = "call sp_query('select (select concat(p.sNamaKaryawan, '' ('', p.sNIK, '')'') from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIK = a.sNIKAtasan) as sAtasan, a.sNamaUnitUsaha, b.sNamaDivisi, c.sNamaDepartemen, d.sNamaPosisi as sBagian, e.sNamaBank, a.sCabangBank, f.sEmail, f.sNoHP, a.sNIK, concat(a.sNamaKaryawan, '' ('', a.sNIK, '')'') as sNamaKaryawan, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, (select p.sNamaKaryawan from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIK = a.sNIKAtasan) As `sNamaAtasan`, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.sNIKAtasan, a.nIdBank_fk, a.nIdUnitUsaha_fk, a.nIdPosisi_fk, (select p.sGroupUserName from tm_user_groups p inner join tx_prepayment_pengajuan_pp q on q.nGroupUserId_fk = p.nGroupUserId where p.sStatusDelete is null and q.sStatusDelete is null and q.nIdPengajuanBS = ".$nIdPengajuanBS.") as `sGroupUser`, $nGroupUserId as `nGroupUserId`, (select count(1) from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIKAtasan = ''".trim($this->session->userdata('sUserName'))."'') as `nJmlAnakBuah`  

		from tx_prepayment_pengajuan_pp a inner join tm_prepayment_divisi b on b.nIdDivisi = a.nIdDivisi_fk inner join tm_prepayment_departemen c on c.nIdDepartemen = a.nIdDepartemen_fk inner join tm_prepayment_posisi d on d.nIdPosisi = a.nIdPosisi_fk inner join tm_prepayment_bank e on e.nIdBank = a.nIdBank_fk inner join tm_prepayment_karyawan f on f.sNIK = a.sNIK
		where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.nIdPengajuanBS = ".trim($nIdPengajuanBS)."')"; 
		else
			$sql = "call sp_query('select (select concat(p.sNamaKaryawan, '' ('', p.sNIK, '')'') from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIK = a.sNIKAtasan) as sAtasan, f.sNamaUnitUsaha, c.sNamaDivisi, d.sNamaDepartemen, e.sNamaPosisi as sBagian, b.sNamaBank, a.sCabangBank, a.sEmail, a.sNoHP, a.sNIK, concat(a.sNamaKaryawan, '' ('', a.sNIK, '')'') as sNamaKaryawan, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, (select p.sNamaKaryawan from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIK = a.sNIKAtasan) As `sNamaAtasan`, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.sNIKAtasan, a.nIdBank_fk, a.nIdUnitUsaha_fk, a.nIdPosisi_fk, (select p.sGroupUserName from tm_user_groups p inner join tm_user_logins_groups q on q.nGroupUserId_fk = p.nGroupUserId where p.sStatusDelete is null and q.sStatusDelete is null and q.nGroupUserId_fk = ".$nGroupUserId." AND q.nUserId_fk = ".$nUserId.") as `sGroupUser`, ".$nGroupUserId." as `nGroupUserId`, (select count(1) from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIKAtasan = ''".trim($this->session->userdata('sUserName'))."'') as `nJmlAnakBuah` from tm_prepayment_karyawan a inner join tm_prepayment_bank b on b.nIdBank = a.nIdBank_fk left join tm_prepayment_divisi c on c.nIdDivisi = a.nIdDivisi_fk and c.nUnitId_fk = ".$nUnitId." left join tm_prepayment_departemen d on d.nIdDepartemen = a.nIdDepartemen_fk and d.nUnitId_fk = ".$nUnitId." left join tm_prepayment_posisi e on e.nIdPosisi = a.nIdPosisi_fk and e.nUnitId_fk = ".$nUnitId." left join tm_prepayment_unit_usaha f on f.nIdUnitUsaha = a.nIdUnitUsaha_fk and e.nUnitId_fk = ".$nUnitId." where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.sNIK = ''".trim($sNIK)."''')"; 
		//exit($sql);
		$rs = $this->db->query($sql);
		return json_encode(array("oData" => $rs->row_array(), "oSQL" => $sql));
	}
	function gf_search_karyawan()
	{
		$term = $this->input->post('term', TRUE);
		$sql = "call sp_query('select sNIK, sNamaKaryawan, sNamaUnitUsaha, sBagian, sNamaBank, sCabangBank, sNoRekening, sAtasNamaRekening from tm_prepayment_karyawan where sNIK = ''".trim($term)."'' union all select sNIK, sNamaKaryawan, sNamaUnitUsaha, sBagian, sNamaBank, sCabangBank, sNoRekening, sAtasNamaRekening from tm_prepayment_karyawan where lower(sNamaKaryawan) like lower(''%".trim($term)."%'') ')";
		$rs = $this->db->query($sql);
		foreach($rs->result_array() as $row)
			$data[] = array('id'=>$row['sNIK'],'label'=>$row['sNamaKaryawan'],'value'=>$row['sNIK']);
		return json_encode($data);
	}
	function gf_load_data($sParam=null) 
	{ 
		$oParam = $_POST; 
		$oData = $sParam === null ? $oParam['NIK'] : $sParam['NIK']; 
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$sql = "call sp_query('select ".$this->session->userdata('nGroupUserId_fk')." as nGroupUserId_fk, a.sEmail, a.sNoHP, a.sNIK, a.sNamaKaryawan, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, (select p.sNamaKaryawan from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIK = a.sNIKAtasan) As `sNamaAtasan`, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.sNIKAtasan, a.nIdBank_fk, a.nIdUnitUsaha_fk, a.nIdPosisi_fk from tm_prepayment_karyawan a inner join tm_prepayment_bank b on b.nIdBank = a.nIdBank_fk left join tm_prepayment_divisi c on c.nIdDivisi = a.nIdDivisi_fk and c.nUnitId_fk = ".$nUnitId." left join tm_prepayment_departemen d on d.nIdDepartemen = a.nIdDepartemen_fk and d.nUnitId_fk = ".$nUnitId." left join tm_prepayment_posisi e on e.nIdPosisi = a.nIdPosisi_fk and e.nUnitId_fk = ".$nUnitId." left join tm_prepayment_unit_usaha f on f.nIdUnitUsaha = a.nIdUnitUsaha_fk and e.nUnitId_fk = ".$nUnitId." where a.sStatusDelete is null and a.nUnitId_fk = ".$nUnitId." and a.sNIK = ''".trim($oData)."'' ')"; 
		$rs = $this->db->query($sql); 
		return $rs->result_array(); 
	} 
	function gf_transact() 
	{ 
		$hideMode 				= $this->input->post('hideMode', TRUE); 
		$txtNIK 					= $this->input->post('txtNIK', TRUE); 
		$txtNIKOld 				= $this->input->post('txtNIKOld', TRUE);
		$txtNIKAtasan 		= $this->input->post('txtNIKAtasan', TRUE); 
		$txtNamaKaryawan 	= $this->input->post('txtNamaKaryawan', TRUE); 
		$selPosisi 				= $this->input->post('selPosisi', TRUE);
		$selUnitUsaha 		= $this->input->post('selUnitUsaha', TRUE);
		$selDivisi 				= $this->input->post('selDivisi', TRUE);
		$selDepartemen 		= $this->input->post('selDepartemen', TRUE);
		$selBank 					= $this->input->post('selBank', TRUE);
		$txtCabangBank		= $this->input->post('txtCabangBank', TRUE);
		$txtNoRekening    = $this->input->post('txtNoRekening', TRUE);
		$txtAtasNamaRekening = $this->input->post('txtAtasNamaRekening', TRUE);
		$txtEmail         = $this->input->post('txtEmail', TRUE);
		$txtEmailOld      = $this->input->post('txtEmailOld', TRUE);
		$txtNoHP          = $this->input->post('txtNoHP', TRUE);
		$txtNoHPOld       = $this->input->post('txtNoHPOld', TRUE);
		$selUserGroup  	  = $this->input->post('selUserGroup', TRUE);

		$sReturn = null; 
		$UUID = trim($txtNIK); 
		if(in_array(trim($hideMode), array("I", "U"))) 
		{ 
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_user_groups", 
		  																													 "sFieldName" => "nGroupUserId",
		  																													 "sContent"   => trim($selUserGroup),
		  																													 "bDisabledUnitId" => TRUE	
		  																													)
		  																									  ), TRUE);
		  
		  if(intVal($sRet['status']) === -1)
		  {
				$this->db->trans_rollback();
		  	$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
		  	return $sReturn;
		  	exit(0);	
		  }

			if(strtolower(trim($txtNIK)) !== strtolower(trim($txtNIKOld))) 
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_karyawan", "sFieldName" => "sNIK", "sContent" => trim($txtNIK))), TRUE); 
				if(intVal($sRet['status']) === 1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			} 
			if(strtolower(trim($txtEmail)) !== strtolower(trim($txtEmailOld))) 
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_karyawan", "sFieldName" => "sEmail", "sContent" => trim($txtEmail))), TRUE); 
				if(intVal($sRet['status']) === 1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			} 
			if(strtolower(trim($txtNoHP)) !== strtolower(trim($txtNoHPOld))) 
			{ 
				$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_karyawan", "sFieldName" => "sNoHP", "sContent" => trim($txtNIK))), TRUE); 
				if(intVal($sRet['status']) === 1) 
				{ 
					$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
					return $sReturn; 
					exit(0); 
				} 
			} 
			$sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_prepayment_karyawan", "sFieldName" => "sNIKAtasan", "sContent" => trim($txtNIK))), TRUE); 
			if(intVal($sRet['status']) === -1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
		} 
		if(in_array(trim($hideMode), array("D"))) 
		{ 
			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => trim($this->db->database), "sFieldName" => "sNIK_fk", "sContent" => trim($txtNIK), "sValueLabel" => "NIK")), TRUE); 
			if(intVal($sRet['status']) === 1) 
			{ 
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message']))); 
				return $sReturn; 
				exit(0); 
			} 
		} 

		$sql = "call sp_tm_prepayment_karyawan('".trim($hideMode)."', '".trim($UUID)."', '".trim($txtNamaKaryawan)."', '".trim($txtCabangBank)."', '".trim($txtNoRekening)."', '".trim($txtAtasNamaRekening)."', NULL, ".$this->session->userdata('nUnitId_fk').", ".trim($selDivisi).", ".trim($selDepartemen).", '".trim($txtNIKAtasan)."', ".trim($selBank).", ".trim($selUnitUsaha).", ".trim($selPosisi).", '".trim($txtEmail)."', '".trim($txtNoHP)."', '1', '".trim($this->session->userdata('sRealName'))."', null, '".trim($txtNIKOld)."'); "; 
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
	function gf_login_punya_anak_buah()
	{
		$sReturn = null;
		$nUnitId = $this->session->userdata('nUnitId_fk');
		$sql = "call sp_query('select count(1) as c from tm_prepayment_karyawan p where p.sStatusDelete is null and p.nUnitId_fk = ".$nUnitId." and p.sNIKAtasan = ''".trim($this->session->userdata('sUserName'))."'' ')";
		$rs  = $this->db->query($sql);
		$nCount = 0;
		if($rs->num_rows() > 0)
		{
			$row = $rs->row_array();
			$nCount = intval($row['c']);
		}
		return json_encode(array("oData" => $nCount));
	}
	function gf_get_info_karyawan($sParam=null)
	{
		$sql = "call sp_query('select * from tm_prepayment_karyawan where sNIK = ''".trim($sParam['sNIK'])."'' and sStatusDelete is null and nUnitId_fk = ".$this->session->userdata('nUnitId_fk')."');";
		$rs = $this->db->query($sql);
		return json_encode($rs->row_array());
	}
}