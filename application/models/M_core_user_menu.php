<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_user_menu extends CI_Model
{
	var $o = 1;
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}
	function gf_load_data($sParam = null)
	{
		$oParam = $_POST;
		$oData = $sParam === null ? $oParam['Menu_Id'] : $sParam['Menu_Id'];
		$sql = "call sp_query('select * from tm_user_menu where nMenuId= ''" . trim($oData) . "'' and sStatusDelete is null')";
		$rs = $this->db->query($sql);
		return $rs->result_array();
	}
	function gf_transact()
	{
		$txtMenuId = $this->input->post('txtMenuId', TRUE);
		$txtMenuName = $this->input->post('txtMenuName', TRUE);
		$txtMenuNameOld = $this->input->post('txtMenuNameOld', TRUE);
		$txtMenuCtlName = $this->input->post('txtMenuCtlName', TRUE);
		$selParentUserMenu = $this->input->post('selParentUserMenu', TRUE);
		$txtMenuOrder = $this->input->post('txtMenuOrder', TRUE);
		$txtMenuIcon = $this->input->post('txtMenuIcon', TRUE);
		$hideMode = $this->input->post('hideMode', TRUE);
		$selMode = $this->input->post('selMode', TRUE);

		$sReturn = null;

		$UUID = "NULL";
		if (trim($hideMode) !== "I")
			$UUID = trim($txtMenuId);

		if (in_array(trim($hideMode), array("I", "U"))) {
			if (strtolower(trim($txtMenuNameOld)) !== strtolower(trim($txtMenuName)) && strtolower(trim($txtMenuName)) !== "-") {
				/*
			  $sRet = json_decode($this->m_core_apps->gf_check_double_data_in_table(array("sTableName" => "tm_user_menu", 
			  																													 "sFieldName" => "sMenuName",
			  																													 "sContent"   => trim($txtMenuName),
			  																													 "bDisabledUnitId" => false
			  																													)
			  																									  ), TRUE);
			  */
				//-- Klo Menu Sama tapi Parent nya Beda Boleh
				if (trim($selParentUserMenu) !== "") {
					$sql = "call sp_query('select count(1) as c from tm_user_menu where lower(sMenuName) = lower(''" . trim($txtMenuName) . "'') and nMenuParentId_fk = " . trim($selParentUserMenu) . "  and sStatusDelete is null');";
					$rs = $this->db->query($sql);
					if ($rs->num_rows() > 0) {
						$row = $rs->row_array();
						if (intVal($row['c']) > 0) {
							$sReturn = json_encode(array("status" => -1, "message" => "Menu Name has Already Exist in this Section, Please entry another Menu Name."));
							return $sReturn;
							exit(0);
						}
					}
				}
			}
		}

		if (in_array(trim($hideMode), array("D"))) {
			$this->db->trans_begin();
			//$sql = "call sp_tm_user_units ('D', ".trim($txtMenuId).", null, null, null, '".trim($this->session->userdata('sRealName'))."');";
			//$sql = "call sp_tm_user_menu_auth ('E', null, ".trim($txtMenuId).", null, null, null, null, null, null, null, null, '".trim($this->session->userdata('sRealName'))."');";			
			$sql = "call sp_query('delete from tm_user_menu_auth where nMenuId_fk = " . trim($txtMenuId) . " and sStatusDelete is null')";
			$this->db->query($sql);
			$sRet = json_decode($this->m_core_apps->gf_check_foreign_key_use(array("sDatabaseName" => $this->db->database, "sFieldName" => "nMenuId_fk", "sContent" => trim($txtMenuId), "sValueLabel" => "Menu Id Already use in other Table. Delete process failed...")), TRUE);
			if (intVal($sRet['status']) === 1) {
				$this->db->trans_rollback();
				$sReturn = json_encode(array("status" => -1, "message" => trim($sRet['message'])));
				return $sReturn;
				exit(0);
			}
			$this->db->trans_rollback();
		}

		$sql = "call sp_tm_user_menu ('" . trim($hideMode) . "', " . trim($UUID) . ", '" . trim($txtMenuName) . "', '" . trim($txtMenuCtlName) . "', " . (trim($selParentUserMenu) === "" ? "0" : trim($selParentUserMenu)) . ", " . (trim($txtMenuOrder) === "" ? "0" : trim($txtMenuOrder)) . ",  " . trim($selMode) . ", '" . trim($txtMenuIcon) . "', null, '" . trim($this->session->userdata('sRealName')) . "')";

		$this->db->trans_begin();
		$this->db->query($sql);

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$sReturn = json_encode(array("status" => -1, "message" => "Failed"));
		} else {
			$this->db->trans_commit();
			$sReturn = json_encode(array("status" => 1, "message" => "Data has been Submitted."));
			//-- Buat File
			if (in_array(trim($hideMode), array("I", "U"))) {
				if (trim($txtMenuCtlName) <> "") {
					//-- Buat file Controller, Model, View otomatis
					$this->load->library('libIO');
					$libIO = new libIO();
					$sRoot = getcwd();
					$SP    = DIRECTORY_SEPARATOR;

					$sCTL = trim($txtMenuCtlName);
					$sMDL = str_replace("c_", "m_", $sCTL);
					$sVIEW = str_replace("c_", "v_", $sCTL);
					$sDESC = str_replace("c_", "", $sCTL);
					$sDESC = str_replace("_", " ", $sCTL);

					$sAppPath = $sRoot . $SP . "application";
					$sCtlPath = $sAppPath . $SP . "controllers" . $SP . ucfirst(trim($sCTL)) . ".php";
					$sModelPath = $sAppPath . $SP . "models" . $SP . ucfirst(trim($sMDL)) . ".php";
					$sViewPath = $sAppPath . $SP . "views" . $SP . "backend" . $SP . trim($sVIEW) . ".php";

					$sUUID = uniqid();

					if (!file_exists($sCtlPath)) {
						$sContent = "<?php " . chr(13);
						$sContent .= "/*" . chr(13) . str_repeat("-", 30) . chr(13);
						$sContent .= "Menu Name: " . trim($txtMenuName) . chr(13);
						$sContent .= "File Name: " . ucfirst(trim($sCTL)) . ".php" . chr(13);
						$sContent .= "File Path: " . $sCtlPath . chr(13);
						$sContent .= "Create Date Time: " . date('Y-m-d H:i:s') . chr(13);
						$sContent .= str_repeat("-", 30) . chr(13) . "*/" . chr(13);
						$sContent .= "defined('BASEPATH') OR exit('No direct script access allowed');" . chr(13);
						$sContent .= "class " . trim($sCTL) . " extends CI_Controller { " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "var #data    = null;" . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "var #nUnitId = null;" . chr(13);	
						$sContent .= str_repeat(chr(9), 1) . "public function __construct() " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "parent::__construct(); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#a = new libSession(); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "if(#a->gf_check_session()) " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "redirect(\"c_core_login\"); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "//----------------------------------------------------------------------------------------------------------" . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', '" . trim($sMDL) . "')); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->load->library(array('libPaging'));" . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "//----------------------------------------------------------------------------------------------------------" . chr(13);
						//$sContent .= str_repeat(chr(9), 2) . "#data                       = null;" . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->data['o_page']       = 'backend/" . trim($sVIEW) . "'; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->data['o_page_title'] = '" . trim($txtMenuName) . "'; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->data['o_page_desc']  = 'Maintenance " . trim($txtMenuName) . "'; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->data['o_data']       = null; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->data['o_extra']      = #this->m_core_apps->gf_load_additional_data(array(\"sMenuCtlName\" => \"" . trim($sCTL) . "\"));" . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->nUnitId 							= #this->session->userdata('nUnitId_fk');" . chr(13);
						//----------------------------------------------------------------------------------------------------------
						$sContent .= str_repeat(chr(9), 1) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "public function index() " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->data['o_mode'] = \"I\"; " . chr(13);
						//$sContent .= str_repeat(chr(9), 2)."#this->load->view(#this->data['o_page'] , #this->data); ".chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->load->view(#this->data['o_page'] , #this->data); " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "public function gf_exec() " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->data['o_mode'] = \"\"; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->data['o_data'] = #this->" . trim($sMDL) . "->gf_load_data(); " . chr(13);
						//$sContent .= str_repeat(chr(9), 2)."#this->load->view(#this->data['o_page'] , #this->data); ".chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->load->view(#this->data['o_page'] , #this->data); " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "function gf_transact() " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "print #this->" . trim($sMDL) . "->gf_transact(); " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "function gf_load_data() " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#c = new libPaging(); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#sParam = array( ";
						$sContent .= "\"sSQL\" => \"select '' as Column1, '' as Column2, '' as Column3, '' as Column4, '' as Column5, '' as Column6, '' as Column7\"," . chr(13) . str_repeat(chr(9), 10) . " \"sTitleHeader\" => \"Title Sample\"," . chr(13) . str_repeat(chr(9), 10) . " \"sCallBackURLPaging\"	 => site_url().\"" . trim($sCTL) . "/gf_load_data\"," . chr(13) . str_repeat(chr(9), 10) . " \"sCallBackURLPageEditDelete\" => site_url().\"" . trim($sCTL) . "/gf_exec\"," . chr(13) . str_repeat(chr(9), 10) . " \"sLookupEditDelete\" => true," . chr(13) . str_repeat(chr(9), 10) . " \"bDebugSQL\" => false," . chr(13) . str_repeat(chr(9), 10) . " \"sLayout\" => (#this->m_core_apps->gf_is_mobile() ? \"COL_SYSTEM\" : \"GRID_SYSTEM\")," . chr(13) . str_repeat(chr(9), 10) . " \"sInitHeaderFields\" => array(\"Column1\")," . chr(13) . str_repeat(chr(9), 10) . " \"sDefaultFieldSearch\"  => \"Column1\"," . chr(13) . str_repeat(chr(9), 10) . " \"sTheme\" => \"default\"); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#p = #c->gf_render_paging_data(#sParam); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "print #p; " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "} " . chr(13);
						$sContent .= "} " . chr(13);

						$libIO->gf_create_file(array("oFullPath" => $sCtlPath, "oStringContent" => str_replace("#", "$", $sContent)));
					}
					if (!file_exists($sModelPath)) {
						$sContent = "<?php " . chr(13);
						$sContent .= "/*" . chr(13) . str_repeat("-", 30) . chr(13);
						$sContent .= "Menu Name: " . trim($txtMenuName) . chr(13);
						$sContent .= "File Name: " . ucfirst(trim($sMDL)) . ".php" . chr(13);
						$sContent .= "File Path: " . $sModelPath . chr(13);
						$sContent .= "Create Date Time: " . date('Y-m-d H:i:s') . chr(13);
						$sContent .= str_repeat("-", 30) . chr(13) . "*/" . chr(13);
						$sContent .= "class " . trim($sMDL) . " extends CI_Model " . chr(13);
						$sContent .= "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "public function __construct() " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "parent::__construct(); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->load->model(array('m_core_apps')); " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "function gf_load_data(#sParam=null) " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#oParam = #_POST; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#oData = #sParam === null ? #oParam['key_value'] : #sParam['key_value']; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#sql = \"call sp_query('select * from [table_name] where sStatusDelete is null and nUnitId_fk = " . $this->session->userdata('nUnitId_fk') . " and and [primary_key] = \".trim(#oData).\"')\"; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#rs = #this->db->query(#sql); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "return #rs->result_array(); " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "function gf_transact() " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#hideMode = #this->input->post('hideMode', TRUE); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#txt1 = #this->input->post('txt1', TRUE); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#txt2 = #this->input->post('txt2', TRUE); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#txt3 = #this->input->post('txt3', TRUE); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#txt4 = #this->input->post('txt4', TRUE); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#txt5 = #this->input->post('txt5', TRUE); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#txt6 = #this->input->post('txt6', TRUE); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#sReturn = null; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#UUID = \"NULL\"; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "if(trim(#hideMode) !== \"I\") " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "#UUID = trim(#txt1); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "if(in_array(trim(#hideMode), array(\"I\", \"U\"))) " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "if(strtolower(trim(#nama_object_perbandingan_baru)) !== strtolower(trim(#nama_object_perbandingan_lama))) " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "#sRet = json_decode(#this->m_core_apps->gf_check_double_data_in_table(array(\"sTableName\" => \"nama_table\", \"sFieldName\" => \"nama_field\", \"sContent\" => \"nilai_object_perbandingan\")), TRUE); " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "if(intVal(#sRet['status']) === 1) " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 5) . "#sReturn = json_encode(array(\"status\" => -1, \"message\" => trim(#sRet['message']))); " . chr(13);
						$sContent .= str_repeat(chr(9), 5) . "return #sReturn; " . chr(13);
						$sContent .= str_repeat(chr(9), 5) . "exit(0); " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "if(in_array(trim(#hideMode), array(\"D\"))) " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "#sRet = json_decode(#this->m_core_apps->gf_check_foreign_key_use(array(\"sDatabaseName\" => trim(#this->db->database), \"sFieldName\" => \"nama_field\", \"sContent\" => \"nilai_object_perbandingan\", \"sValueLabel\" => \"label_object_warning_ke_client\")), TRUE); " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "if(intVal(#sRet['status']) === 1) " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "#sReturn = json_encode(array(\"status\" => -1, \"message\" => trim(#sRet['message']))); " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "return #sReturn; " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "exit(0); " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#sql = \"call sp_(); \"; " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->db->trans_begin(); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "#this->db->query(#sql); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "if (#this->db->trans_status() === FALSE) " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "#this->db->trans_rollback(); " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "#sReturn = json_encode(array(\"status\" => -1, \"message\" => \"Failed\")); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "else " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "#this->db->trans_commit(); " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "#sReturn = json_encode(array(\"status\" => 1, \"message\" => \"Data has been Submitted.\")); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "return #sReturn; " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "} " . chr(13);
						$sContent .= "} " . chr(13);
						$libIO->gf_create_file(array("oFullPath" => $sModelPath, "oStringContent" => str_replace("#", "$", $sContent)));
					}
					if (!file_exists($sViewPath)) {
						$sContent = "<?php " . chr(13);
						$sContent .= "/*" . chr(13) . str_repeat("-", 30) . chr(13);
						$sContent .= "Menu Name: " . trim($txtMenuName) . chr(13);
						$sContent .= "File Name: " . ucfirst(trim($sVIEW)) . ".php" . chr(13);
						$sContent .= "File Path: " . $sViewPath . chr(13);
						$sContent .= "Create Date Time: " . date('Y-m-d H:i:s') . chr(13);
						$sContent .= str_repeat("-", 30) . chr(13) . "*/" . chr(13);

						$sContent .= "#oTab1 = #oTab2 = #oButton = \"\"; " . chr(13);
						$sContent .= "if(trim(#o_mode) === \"I\") { #oTab1 = \"active\"; #oButton = #o_extra['o_save']; } " . chr(13);
						$sContent .= "else { #oTab2 = \"active\"; #oButton = #o_extra['o_update'].\" \".#o_extra['o_delete'];} " . chr(13);
						$sContent .= "#oButton .= \" \".#o_extra['o_cancel']; " . chr(13);

						$sContent .= "?> " . chr(13);
						$sContent .= "<div class=\"nav-tabs-custom\"> " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "<ul class=\"nav nav-tabs\"> " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "<li class=\"<?php print #oTab1; ?>\"><a data-toggle=\"tab\" href=\"##tab_1\">List " . trim($txtMenuName) . "</a></li> " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "<li class=\"<?php print #oTab2; ?>\"><a data-toggle=\"tab\" href=\"##tab_2\">Form " . trim($txtMenuName) . "</a></li> " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "<li class=\"pull-right\"><a class=\"text-muted\" href=\"\"><i class=\"fa fa-gear\"></i></a></li> " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "</ul> " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "<div class=\"tab-content\"> " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "<div id=\"tab_1\" class=\"tab-pane <?php print #oTab1; ?>\"> " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "<div id=\"div-list-user\">	" . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "</div> " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "</div> " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "<div id=\"tab_2\" class=\"tab-pane <?php print #oTab2; ?>\"> " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "<form id=\"form_" . trim($sUUID) . "\" role=\"form\" action=\"<?php print site_url(); ?>" . trim($sCTL) . "/gf_transact\" method=\"post\"> " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "<div class=\"box-body no-padding\"> " . chr(13);
						$sContent .= str_repeat(chr(9), 5) . "<div class=\"row\">" . chr(13);
						//---------------------------------------------------------------
						$sContent .= str_repeat(chr(9), 6) . "<div class=\"col-sm-4 col-xs-12 col-md-4 col-lg-2 form-group\" id=\"div-top\"><label>Id 1</label><input allow-empty=\"false\" type=\"text\" placeholder=\"Id 1\" name=\"txtId1\" id=\"txtId1\" class=\"form-control\" maxlength=\"50\" value=\"<?php print trim(#o_mode) === \"I\" ? \"(AUTO)\" : trim(#o_data[0]['nId1']); ?>\" readonly>" . chr(13);
						$sContent .= str_repeat(chr(9), 6) . "</div>" . chr(13);
						$sContent .= str_repeat(chr(9), 6) . "<div class=\"row\"></div>" . chr(13);
						$sContent .= str_repeat(chr(9), 6) . "<div class=\"col-sm-12 col-xs-12 col-md-4 col-lg-4 form-group\"><label>Nama 1</label><input allow-empty=\"false\" type=\"text\" placeholder=\"Nama 1\" name=\"txtNama1\" id=\"txtNama1\" class=\"form-control\" maxlength=\"100\" value=\"<?php print trim(#o_data[0]['sName']); ?>\">
						<input type=\"hidden\" name=\"txtNama1Old\" id=\"txtNama1Old\" value=\"<?php print trim(#o_data[0]['sNama1']); ?>\" />" . chr(13);
						$sContent .= str_repeat(chr(9), 6) . "</div>" . chr(13);
						//---------------------------------------------------------------
						$sContent .= str_repeat(chr(9), 5) . "</div> " . chr(13);
						$sContent .= str_repeat(chr(9), 5) . "<div class=\"box-footer no-padding\"> " . chr(13);
						$sContent .= str_repeat(chr(9), 5) . "<br /> " . chr(13);
						$sContent .= str_repeat(chr(9), 5) . "<?php print #oButton; ?> " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "</div> " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "<input type=\"hidden\" name=\"hideMode\" id=\"hideMode\" value=\"\" /> " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "</form> " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "</div> " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "</div> " . chr(13);
						$sContent .= "</div> " . chr(13) . chr(13) . chr(13);
						$sContent .= "<script> " . chr(13);
						$sContent .= "var sSURL  = \"<?php print site_url(); ?>" . trim($sCTL) . "/gf_upload/\" " . chr(13);
						$sContent .= "var sParam = \"\"; " . chr(13);
						$sContent .= "var dialog = \"\"; " . chr(13);
						$sContent .= "$(function() " . chr(13);
						$sContent .= "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "gf_load_data(); " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "$(\"input[content-mode='numeric']\").autoNumeric('init', {mDec: '0'}); " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "$(\"button[id='button-submit']\").click(function() " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "{ " . chr(13);

						$sContent .= str_repeat(chr(9), 2) . "if(#.trim(#(this).html()) === \"Cancel\") " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "#(\".sidebar-menu\").find(\"a[class='text-yellow']\").trigger(\"click\");" . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "else " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "var bNext = true; " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "var objForm = $(\"##form_" . trim($sUUID) . "\"); " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "//------------------------------------------ " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "if(#.trim($(this).html()) === \"Save\") " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "#(\"##hideMode\").val(\"I\"); " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "else if(#.trim(#(this).html()) === \"Update\") " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "#(\"##hideMode\").val(\"U\"); " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "else if(#.trim(#(this).html()) === \"Delete\") " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "#(\"##hideMode\").val(\"D\"); " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "//------------------------------------------ " . chr(13);

						$sContent .= str_repeat(chr(9), 3) . "if(parseInt(#.inArray(#.trim($(\"##hideMode\").val()), [\"I\", \"U\"])) !== -1) " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "var oRet = #.gf_valid_form({\"oForm\": objForm, \"oAddMarginLR\": true, oObjDivAlert: #(\"##div-top\")}); " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "bNext = oRet.oReturnValue; " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "} " . chr(13);

						$sContent .= str_repeat(chr(9), 3) . "if(!bNext) " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "return false; " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "//------------------------------------------ " . chr(13);

						$sContent .= str_repeat(chr(9), 3) . "$.gf_custom_ajax({\"oForm\": objForm,  " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "\"success\": function(r)" . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "{" . chr(13);

						$sContent .= str_repeat(chr(9), 4) . "var JSON = #.parseJSON(r.oRespond); " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "$.gf_remove_all_modal(); " . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "if(JSON.status === 1) " . chr(13);
						$sContent .= str_repeat(chr(9), 5) . "$(\".sidebar-menu\").find(\"a[class='text-yellow']\").trigger(\"click\");" . chr(13);
						$sContent .= str_repeat(chr(9), 4) . "else " . chr(13);
						$sContent .= str_repeat(chr(9), 5) . "#.gf_msg_info({oObjDivAlert: #(\"#div-top\"), oAddMarginLR: true, oMessage: JSON.message});	" . chr(13);

						$sContent .= str_repeat(chr(9), 3) . "}, " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "\"validate\": true," . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "\"beforeSend\": function(r) {}," . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "\"beforeSendType\": \"standard\", " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "\"error\": function(r) {} " . chr(13);
						$sContent .= str_repeat(chr(9), 3) . "}); " . chr(13);
						$sContent .= str_repeat(chr(9), 2) . "} " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "}); " . chr(13);

						$sContent .= "}); " . chr(13);
						$sContent .= "function gf_load_data() " . chr(13);
						$sContent .= "{ " . chr(13);
						$sContent .= str_repeat(chr(9), 1) . "#(\"##div-list-user\").ado_load_paging_data({url: \"<?php print site_url(); ?>" . trim($sCTL) . "/gf_load_data/\"}); " . chr(13);
						$sContent .= "} " . chr(13);
						$sContent .= "</script> " . chr(13);

						$sContent = str_replace("#", "$", $sContent);
						$sContent = str_replace("$$", "#", $sContent);
						$libIO->gf_create_file(array("oFullPath" => $sViewPath, "oStringContent" => $sContent));
					}
				}
			}
		}
		return $sReturn;
	}
	function gf_recursive_menu($sParam = null)
	{
		$sReturn = null;
		$sql = "call sp_query('select nMenuId, sMenuName from tm_user_menu where sStatusDelete is null and nMenuParentId_fk = " . trim($sParam['nMenuId']) . " order by nMenuOrder')";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $row) {
				$this->o++;
				$sReturn .= "<option " . (intval($sParam['nMenuIdInit']) === intval($row['nMenuId']) ? "selected" : "") . " value=\"" . $row['nMenuId'] . "\">" . substr(str_repeat("--", $this->o) . trim($row['sMenuName']), 4) . "</option>";
				if ($rs->num_rows() > 0)
					$sReturn .= $this->gf_recursive_menu(array("nMenuId" => trim($row['nMenuId']), "nMenuIdInit" => $sParam['nMenuIdInit']));
				$this->o--;
			}
		}
		return $sReturn;
	}
	function gf_get_menu_order($sParam = null)
	{
		$sReturn = null;
		$sql = "call sp_query('select nMenuId, case when count(nMenuOrder) = 0 then 1 else (max(nMenuOrder) + 1) end as nMaxMenuOrder from tm_user_menu where nMenuParentId_fk = " . trim($sParam['nMenuParentId']) . " and sStatusDelete is null')";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$row = $rs->row_array();
			$sReturn = array("nMenuId" => $row['nMenuId'], "nMaxMenuOrder" => $row['nMaxMenuOrder']);
		}
		return json_encode($sReturn);
	}
	function gf_recursive_side_bar($sParam = null)
	{
		$sReturn = null;
		$sql = "call sp_query('select sMenuIcon, nMenuId, sMenuName, sMenuCtlName from tm_user_menu where sStatusDelete is null and nMenuParentId_fk = " . trim($sParam['nMenuId']) . " and nMenuMode = 1 order by nMenuOrder')";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $row) {
				$oAuth = json_decode($this->gf_load_auth(array("nMenuId" => trim($row['nMenuId']))), TRUE);
				if (trim($row['sMenuName']) !== "-" && intval($oAuth['sVisible']) === 1 && $this->gf_have_child(array("nMenuId" => $row['nMenuId']))) {
					$sReturn .= "<li>";
					$sReturn .= anchor("", (trim($row['sMenuIcon']) !== "" ? "<i class=\"fa " . trim($row['sMenuIcon']) . "\"></i>" : "") . "<span>" . trim($row['sMenuName']) . "</span><span class=\"pull-right-container\"><i class=\"fa fa-angle-left pull-right\"></i></span>", array("title" => trim($row['sMenuName'])));
					$sReturn .= "<ul class=\"treeview-menu\">";
					$sReturn .= $this->gf_recursive_side_bar(array("nMenuId" => trim($row['nMenuId'])));
					$sReturn .= "</ul>";
					$sReturn .= "</li>";
				} else {
					if (trim($row['sMenuName']) !== "-" && intval($oAuth['sVisible']) === 1)
						$sReturn .= "<li>" . anchor("", (trim($row['sMenuIcon']) !== "" ? "<i class=\"fa " . trim($row['sMenuIcon']) . "\"></i>" : "") . "<span>" . trim($row['sMenuName']) . "</span>", array("page" => "0", "segment" => trim($row['sMenuCtlName']), "title" => trim($row['sMenuName']))) . "</li>";
				}
			}
		}
		return $sReturn;
	}
	function gf_have_child($sParam = array())
	{
		$sReturn = false;
		$sql = "call sp_query('select nMenuId, sMenuName, sMenuCtlName from tm_user_menu where sStatusDelete is null and nMenuParentId_fk = " . trim($sParam['nMenuId']) . " order by nMenuOrder')";
		return $this->db->query($sql)->num_rows() > 0 ? true: false;
	}
	function gf_load_auth($sParam = array())
	{
		$sReturn = null;
		$nGroupUserId = $this->session->userdata('nGroupUserId_fk');
		$sql = "call sp_query('select a.nGroupUserId_fk, a.nMenuId_fk, a.nSeqNo, a.sVisible, a.sSave, a.sUpdate, a.sDelete from tm_user_menu_auth a inner join tm_user_menu b on b.nMenuId = a.nMenuId_fk where a.sStatusDelete is null and b.sStatusDelete is null and a.nGroupUserId_fk = " . trim($nGroupUserId) . " and a.sFlag = ''MENU_APPS'' and a.nMenuId_fk = " . intval($sParam['nMenuId']) . " and a.nUnitId_fk = " . $this->session->userdata('nUnitId_fk') . "');";
		//print trim($sql);
		$rs = $this->db->query($sql);
		$sReturn = json_encode(array("sVisible" => "0", "sSave" => "0", "sUpdate" => "0", "sDelete" => "0"));
		if ($rs->num_rows() > 0) {
			$row = $rs->row_array();
			$sVisible = $row['sVisible'];
			$oSave = $row['sSave'];
			$oUpdate = $row['sUpdate'];
			$oDelete = $row['sDelete'];
			$sReturn = json_encode(array("sVisible" => $sVisible, "sSave" => $oSave, "sUpdate" => $oUpdate, "sDelete" => $oDelete));
		}
		//-- If Admin, Open All Menu access
		$oConfig = $this->m_core_apps->gf_read_config_apps();
		if (intval($this->session->userdata('nGroupUserId_fk')) === intval($oConfig['ADMIN_GROUP_ID'])) //-- Administrator
			$sReturn = json_encode(array("sVisible" => 1, "sSave" => 1, "sUpdate" => 1, "sDelete" => 1));
		//--
		return $sReturn;
	}
	function gf_change_database($UnitId = null)
	{
		$sReturn = null;
		$sInfo = json_decode($this->m_core_user_login->gf_user_info(), TRUE);
		$sDb = $sInfo['sDb'];
		$sReturn = array("status" => 0);
		if ($UnitId !== null) {
			foreach ($sDb as $row) {
				if (intval($row['nUnitId_fk']) === intval($UnitId)) {
					$this->session->set_userdata('nUnitId_fk', $UnitId);
					$sql = "call sp_query('select sUnitName from tm_user_groups_units where sStatusDelete is null and nUnitId = " . $UnitId . "')";
					$rs = $this->db->query($sql);
					if ($rs->num_rows() > 0) {
						$row = $rs->row_array();
						$this->session->set_userdata('sUnitName', trim($row['sUnitName']));
					}
					$sReturn = array("status" => 1);
					return json_encode($sReturn);
					exit(0);
				}
			}
		}
		return json_encode($sReturn);
	}
	function gf_change_group($GroupId = null)
	{
		$sReturn = null;
		$sInfo = json_decode($this->m_core_user_login->gf_user_info(), TRUE);
		$sDb = $sInfo['sGroupList'];
		$sReturn = array("status" => 0);
		if ($GroupId !== null) {
			foreach ($sDb as $row) {
				if (intval($row['nGroupUserId_fk']) === intval($GroupId)) {
					$this->session->set_userdata('nGroupUserId_fk', $GroupId);
					$sql = "call sp_query('select sGroupUserName from tm_user_groups where sStatusDelete is null and nGroupUserId = " . $GroupId . "')";
					$rs = $this->db->query($sql);
					if ($rs->num_rows() > 0) {
						$row = $rs->row_array();
						$this->session->set_userdata('sGroupUserName', trim($row['sGroupUserName']));
					}
					$sReturn = array("status" => 1);
					return json_encode($sReturn);
					exit(0);
				}
			}
		}
		return json_encode($sReturn);
	}
	function gf_change_profile($nGroupUserId = null)
	{
		$sReturn = null;
		$sInfo = json_decode($this->m_core_user_login->gf_user_info(), TRUE);
		$sProfile = $sInfo['sProfile'];
		$sReturn = array("status" => 0);
		if ($nGroupUserId !== null) {
			foreach ($sProfile as $row) {
				if (intval($row['nGroupUserId_fk']) === intval($nGroupUserId)) {
					$this->session->set_userdata('nGroupUserId_fk', $nGroupUserId);
					$sql = "call sp_query('select sGroupUserName from tm_user_groups where sStatusDelete is null and nGroupUserId = " . $nGroupUserId . "')";
					$rs = $this->db->query($sql);
					if ($rs->num_rows() > 0) {
						$row = $rs->row_array();
						$this->session->set_userdata('sGroupUserName', trim($row['sGroupUserName']));
					}
					$sReturn = array("status" => 1);
					return json_encode($sReturn);
					exit(0);
				}
			}
		}
		return json_encode($sReturn);
	}
}
