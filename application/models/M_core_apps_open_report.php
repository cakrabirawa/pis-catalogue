<?php
/*
------------------------------
Menu Name: Report
File Name: M_core_apps_open_report.php
File Path: D:\Project\PHP\billing\application\models\M_core_apps_open_report.php
Create Date Time: 2019-08-25 19:07:59
------------------------------
*/
class m_core_apps_open_report extends CI_Model
{
	var $o = 1;
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps', 'm_core_apps_report'));
	}
	function gf_load_open_reports()
	{
		$sReturnListItem = null;
		$sReturnListOption = null;
		$sql = "call sp_query('select sOpenReportsStaticParamsExcel, sOpenReportsDesc, nIdOpenReport, sOpenReportsName, sOpenReportsStaticParams from tm_user_open_reports where sStatusDelete is null ');";
		$rs = $this->db->query($sql);
		$sReturnListItem .= "<ul class=\"list-group\">";
		if ($rs->num_rows() > 0) {
			$i = 1;
			foreach ($rs->result_array() as $row) {
				if (intval($this->session->userdata('nGroupUserId_fk')) !== 0) {
					$sql = "call sp_query('select p.sVisible from tm_user_menu_auth p where p.sStatusDelete is null and p.sFlag = ''MENU_OPEN_REPORTS'' and p.nGroupUserId_fk = " . $this->session->userdata('nGroupUserId_fk') . " and p.nMenuId_fk = " . $row['nIdOpenReport'] . " limit 1')";
					$rs1 = $this->db->query($sql);
					if ($rs1->num_rows() > 0) {
						$row1 = $rs1->row_array();
						if (intval($row1['sVisible']) === 1) {
							$sReturnListItem .= "<li style=\"padding: 4px;\" class=\"list-group-item cursor-pointer\">" ./*str_repeat("0", 2 - strlen($i)).$i.*/ " <a class=\"text-primary\" id=\"" . trim($row['nIdOpenReport']) . "\"  desc=\"" . trim($row['sOpenReportsDesc']) . "\" title=\"" . trim($row['sOpenReportsName']) . "\">" . intval($row1['sVisible']) . ":" . trim($row['sOpenReportsName']) . "</a>";
							$sReturnListOption .= "<option id=\"" . trim($row['nIdOpenReport']) . "\" desc=\"" . trim($row['sOpenReportsDesc']) . "\">" . trim($row['sOpenReportsName']) . "</option>";
						}
					}
					$i++;
				} else {
					$sReturnListItem .= "<li style=\"padding: 4px;\" class=\"list-group-item cursor-pointer\">" ./*str_repeat("0", 2 - strlen($i)).$i.*/ " <a class=\"text-primary\" id=\"" . trim($row['nIdOpenReport']) . "\"  desc=\"" . trim($row['sOpenReportsDesc']) . "\" title=\"" . trim($row['sOpenReportsName']) . "\">" . trim($row['sOpenReportsName']) . "</a>";
					$sReturnListOption .= "<option id=\"" . trim($row['nIdOpenReport']) . "\" desc=\"" . trim($row['sOpenReportsDesc']) . "\">" . trim($row['sOpenReportsName']) . "</option>";
				}
			}
		} else {
			$sReturnListItem .= "<li style=\"padding: 4px;\" class=\"list-group-item cursor-pointer\">No Reports</li>";
			$sReturnListOption .= "<option id=\"\">No Report !</option>";
		}
		$sReturnListItem .= "</ul>";
		return json_encode(array("oListItem" => $sReturnListItem, "oOption" => $sReturnListOption));
	}
	function gf_read_open_reports()
	{
		$sReturn = null;
		$nIdOpenReport = $this->input->post('nIdOpenReport', TRUE);
		$sql = "call sp_query('select a.*, (select concat(p.sPathFile, p.sEncryptedFileName) from tm_user_uploads p where p.sStatusDelete is null and p.sUploadId = a.sUUID) as sFullFileName from tm_user_open_reports a where a.nIdOpenReport = " . $nIdOpenReport . " and a.sStatusDelete is null');";
		$rs = $this->db->query($sql);
		$row = $rs->row_array();
		$sql = str_replace("@nUnitId", $this->session->userdata('nUnitId_fk'), trim($row['sOpenReportsSQL']));
		//$sql = str_replace("'", "''", trim($sql));
		//$sql = "call sp_query('" . trim($sql) . " limit 1');";
		//$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0)
			$sReturn = json_encode(array("oSQL" => $sql, "oData" => $rs->row_array()));
		return $sReturn;
	}
	function gf_execute_query_to_grid()
	{
		$selFieldName    = $this->input->post('selFieldName', TRUE);
		$selOperator     = $this->input->post('selOperator', TRUE);
		$txtValue        = $this->input->post('txtValue', TRUE);
		$selOperand      = $this->input->post('selOperand', TRUE);
		$hideType        = $this->input->post('hideType', TRUE);
		$nIdOpenReport 	 = $this->input->post('nIdOpenReport', TRUE);
		//----------------------------------------------------------------------
		$sql 									= "call sp_query('select a.*, (select concat(p.sPathFile, p.sEncryptedFileName) from tm_user_uploads p where p.sStatusDelete is null and p.sUploadId = a.sUUID) as sFullFileName from tm_user_open_reports a where a.nIdOpenReport = " . trim($nIdOpenReport) . " and a.sStatusDelete is null');";
		$rs 									= $this->db->query($sql);
		$row            			= $rs->row_array();
		//----------------------------------------------------------------------
		$hideSQL = $this->m_core_apps_report->gf_parse_sql_x(array("hideSQL" => trim($row['sOpenReportsSQL'])));
		//----------------------------------------------------------------------
		$hideOpenReportsType 	= intval($row['nOpenReportsType']);
		$hideColumns 					= trim($row['sHideColumns']);
		$hideColumns 					= explode("|", trim($hideColumns));
		//----------------------------------------------------------------------
		$hideSQL       				= explode("~", trim($hideSQL));
		$nCountHideSQL 				= count($hideSQL);
		for($x=0; $x<$nCountHideSQL; $x++)
		{
			$hideSQLX      = "select * from (" . trim($hideSQL[$x]) . ") as c ";
			$c = 0;
			for ($k = 0; $k < count($txtValue); $k++) {
				if (trim($txtValue[$k]) !== "")
					$c++;
			}
			if ($c > 0)
				$hideSQLX .= " where ";
			$hideParam = "";
			if (intval($hideOpenReportsType) === 1) //-- Dynamic
			{
				for ($i = 0; $i < count($selFieldName); $i++) {
					if (trim($selFieldName[$i]) !== "" && trim($selOperator[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($selOperand[$i]) !== "") {
						$hideParam .= "c.`" . trim($selFieldName[$i]) . "` " . trim($selOperator[$i]);
						if (in_array(trim($selOperator[$i]), array("LIKE", "=")) && in_array(intval($hideType[$i]), array(253, 12))) // String, Date
						{
							if (in_array(trim($selOperator[$i]), array("LIKE")))
								$hideParam .= " '%" . str_replace("'", "''", trim($txtValue[$i])) . "%' ";
							else
								$hideParam .= " '" . trim($txtValue[$i]) . "' ";
						} elseif (!in_array(trim($selOperator[$i]), array("LIKE", "="))) // Numeric dan Date
						{
							if (in_array(intval($hideType[$i]), array(12, 10))) //-- Date Convert dulu jadi ymd
								$hideParam .= " '" . str_replace("'", "''", $this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtValue[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))) . "' ";
							else
								$hideParam .= " " . str_replace("'", "''", trim($txtValue[$i])) . " ";
						}
						$hideParam .= " " . trim($selOperand[$i]) . " ";
					}
				}
			} else if (intval($hideOpenReportsType) === 2) //-- Static By Params
			{
				for ($i = 0; $i < count($selFieldName); $i++) {
					if (trim($selFieldName[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($hideType[$i]) !== "") {
						$hideParam .= "c.`" . trim($selFieldName[$i]) . "` = ";
						if (in_array(intval($hideType[$i]), array(253))) // String, Date
							$hideParam .= " '" . (trim($selOperator[$i]) === "LIKE" ? "%" : "") . "" . trim($txtValue[$i]) . "" . (trim($selOperator[$i]) === "LIKE" ? "%" : "") . "' ";
						else // Numeric dan Date
						{
							if (in_array(intval($hideType[$i]), array(12, 10))) //-- Date Convert dulu jadi ymd
								$hideParam .= " '" . str_replace("'", "''", $this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtValue[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))) . "' ";
							else
								$hideParam .= " " . str_replace("'", "''", trim($txtValue[$i])) . " ";
						}
						$hideParam .= " " . trim($selOperand[$i]) . " ";
					}
				}
			} else if (intval($hideOpenReportsType) === 3) //-- Static By Value
			{
				for ($i = 0; $i < count($selFieldName); $i++) {
					if (trim($txtValue[$i]) !== "") {
						if (trim($selFieldName[$i]) !== "" && trim($selOperator[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($selOperand[$i]) !== "" && count(explode(",", trim($txtValue[$i]))) === 1) {
							$hideParam .= "c.`" . trim($selFieldName[$i]) . "` " . trim($selOperator[$i]) . " ";
							if (in_array(intval($hideType[$i]), array(253))) // String, Date
								$hideParam .= " '" . (trim($selOperator[$i]) === "LIKE" ? "%" : "") . "" . trim($txtValue[$i]) . "" . (trim($selOperator[$i]) === "LIKE" ? "%" : "") . "' ";
							else // Numeric dan Date
							{
								if (in_array(intval($hideType[$i]), array(12, 10))) //-- Date Convert dulu jadi ymd
									$hideParam .= " '" . str_replace("'", "''", $this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtValue[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))) . "' ";
								else
									$hideParam .= " " . str_replace("'", "''", trim($txtValue[$i])) . " ";
							}
						} else if (trim($selFieldName[$i]) !== "" && trim($selOperator[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($selOperand[$i]) !== "" && count(explode(",", trim($txtValue[$i]))) > 1) {
							$a = explode("|", trim($txtValue[$i]));
							if (count($a) > 0) {
								if (substr(trim($a[0]), strlen(trim($a[0])) - 1, strlen(trim($a[0]))) === ",")
									$hideParam .= "c.`" . trim($selFieldName[$i]) . "` in " . substr(trim($a[0]), 0, strlen(trim($a[0])) - 1) . " ";
								else
									$hideParam .= "c.`" . trim($selFieldName[$i]) . "` in " . trim($a[0]) . " ";
							} else
								$hideParam .= "c.`" . trim($selFieldName[$i]) . "` in " . trim($txtValue[$i]) . " ";
						}
						$hideParam .= " " . trim($selOperand[$i]) . " ";
					}
				}
			}
			$hideSQLX .= $hideParam;
			//-------------------------------------------------------------------------
			if (substr(trim($hideParam), strlen(trim($hideParam)) - 2, 2) === "ND")
				$hideSQLX = substr(trim($hideSQLX), 0, strlen(trim($hideSQLX)) - 3);
			else if (substr(trim($hideParam), strlen(trim($hideParam)) - 2, 2) === "OR")
				$hideSQLX = substr(trim($hideSQLX), 0, strlen(trim($hideSQLX)) - 2);
			$c = new libPaging();
			$hideSQLX = str_replace(array("&lt;", "&gt;"), array("<", ">"), $hideSQLX);
			$sParam = array(
				"sSQL" => trim($hideSQLX),
				"sTitleHeader" => "Title Sample",
				"sCallBackURLPaging"	 => site_url() . "c_core_apps_open_report/gf_execute_query_to_grid",
				"sLookupEditDelete" => false,
				"bDebugSQL" => false,
				"sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
				//"sInitHeaderFields" => array(trim($oColInit)),
				//"sDefaultFieldSearch"  => trim($oColInit),
				"sCycleParam" => array("nIdOpenReport" => $nIdOpenReport),
				"sFieldIgnore" => explode("|", trim($row['sHideColumns'])),
				"sFieldIgnoreOnSearch" => explode("|", trim($row['sHideColumns'])),
				"sTheme" => "default"
			);
			$p = $c->gf_render_paging_data($sParam);
		}
		return $p;
	}
	function gf_load_report_list($nIdOpenReport = 0)
	{
		$sReturn = null;
		$sql = "call sp_query('select sHideColumns, sOpenReportsDesc, nIdOpenReport, sOpenReportsName, sOpenReportsStaticParams from tm_user_open_reports where sStatusDelete is null and nIdOpenReportParent_fk " . (intval($nIdOpenReport) === 0 ? " IS NULL " : " = " . trim($nIdOpenReport)) . " order by nIdOpenReportParent_fk')";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $row) {
				$this->o++;
				$sReturn .= "<li><a id=\"" . trim($row['nIdOpenReport']) . "\">" . trim($row['sOpenReportsName']) . "</a>";
				if ($rs->num_rows() > 0)
					$sReturn .= "<ul>" . $this->gf_load_report_list(trim($row['nIdOpenReport'])) . "</ul>";
				$sReturn .= "</li>";
				$this->o--;
			}
		}
		return $sReturn;
	}
	function gf_export_excel()
	{
		$sReturn         = null;
		//-- Array
		$selFieldName    = $this->input->post('selFieldName', TRUE);
		$selOperator     = $this->input->post('selOperator', TRUE);
		$txtValue        = $this->input->post('txtValue', TRUE);
		$selOperand      = $this->input->post('selOperand', TRUE);
		$hideType        = $this->input->post('hideType', TRUE);
		$nIdOpenReport 	 = $this->input->post('hideIdReport', TRUE);
		//----------------------------------------------------------------------
		$sql 									= "call sp_query('select a.*, (select concat(p.sPathFile, p.sEncryptedFileName) from tm_user_uploads p where p.sStatusDelete is null and p.sUploadId = a.sUUID) as sFullFileName from tm_user_open_reports a where a.nIdOpenReport = " . trim($nIdOpenReport) . " and a.sStatusDelete is null');";
		$rs 									= $this->db->query($sql);
		$row            			= $rs->row_array();
		//----------------------------------------------------------------------
		$hideSQL = $this->m_core_apps_report->gf_parse_sql_x(array("hideSQL" => trim($row['sOpenReportsSQL'])));
		//----------------------------------------------------------------------
		$hideOpenReportsType 	= intval($row['nOpenReportsType']);
		$hideHeaderExcel 			= trim($row['sOpenReportsStaticParamsExcel']);
		$hideColumns 					= explode("|", trim($row['sHideColumns']));
		$selFieldLabelName 		= $this->input->post('selFieldLabelName', TRUE);
		//----------------------------------------------------------------------
		$hideSQL       				= explode("~", trim($hideSQL));
		$nCountHideSQL 				= count($hideSQL);
		for($x=0; $x<$nCountHideSQL; $x++)
		{
			$hideSQLX = "select * from (" . trim($hideSQL[$x]) . ") as c ";
			$c = 0;
			for ($k = 0; $k < count($txtValue); $k++) {
				if (trim($txtValue[$k]) !== "")
					$c++;
			}
			if ($c > 0)
				$hideSQLX .= " where ";
			$hideParam = "";
			if (intval($hideOpenReportsType) === 1) //-- Dynamic
			{
				for ($i = 0; $i < count($selFieldName); $i++) {
					if (trim($selFieldName[$i]) !== "" && trim($selOperator[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($selOperand[$i]) !== "") {
						$hideParam .= "c.`" . trim($selFieldName[$i]) . "` " . trim($selOperator[$i]);
						if (in_array(trim($selOperator[$i]), array("LIKE", "=")) && in_array(intval($hideType[$i]), array(253, 12))) // String, Date
						{
							if (in_array(trim($selOperator[$i]), array("LIKE")))
								$hideParam .= " '%" . str_replace("'", "''", trim($txtValue[$i])) . "%' ";
							else
								$hideParam .= " '" . trim($txtValue[$i]) . "' ";
						} elseif (!in_array(trim($selOperator[$i]), array("LIKE", "="))) // Numeric dan Date
						{
							if (in_array(intval($hideType[$i]), array(12, 10))) //-- Date Convert dulu jadi ymd
								$hideParam .= " '" . str_replace("'", "''", $this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtValue[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))) . "' ";
							else
								$hideParam .= " " . str_replace("'", "''", trim($txtValue[$i])) . " ";
						}
						$hideParam .= " " . trim($selOperand[$i]) . " ";
					}
				}
			} else if (intval($hideOpenReportsType) === 2) //-- Static By Params
			{
				for ($i = 0; $i < count($selFieldName); $i++) {
					if (trim($selFieldName[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($hideType[$i]) !== "") {
						$hideParam .= "c.`" . trim($selFieldName[$i]) . "` = ";
						if (in_array(intval($hideType[$i]), array(253))) // String, Date
							$hideParam .= " '" . (trim($selOperator[$i]) === "LIKE" ? "%" : "") . "" . trim($txtValue[$i]) . "" . (trim($selOperator[$i]) === "LIKE" ? "%" : "") . "' ";
						else // Numeric dan Date
						{
							if (in_array(intval($hideType[$i]), array(12, 10))) //-- Date Convert dulu jadi ymd
								$hideParam .= " '" . str_replace("'", "''", $this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtValue[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))) . "' ";
							else
								$hideParam .= " " . str_replace("'", "''", trim($txtValue[$i])) . " ";
						}
						$hideParam .= " " . trim($selOperand[$i]) . " ";
					}
				}
			} else if (intval($hideOpenReportsType) === 3) //-- Static By Value
			{
				for ($i = 0; $i < count($selFieldName); $i++) {
					if (trim($txtValue[$i]) !== "") {
						if (trim($selFieldName[$i]) !== "" && trim($selOperator[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($selOperand[$i]) !== "" && count(explode(",", trim($txtValue[$i]))) === 1) {
							$hideParam .= "c.`" . trim($selFieldName[$i]) . "` " . trim($selOperator[$i]) . " ";
							if (in_array(intval($hideType[$i]), array(253))) // String, Date
								$hideParam .= " '" . (trim($selOperator[$i]) === "LIKE" ? "%" : "") . "" . trim($txtValue[$i]) . "" . (trim($selOperator[$i]) === "LIKE" ? "%" : "") . "' ";
							else // Numeric dan Date
							{
								if (in_array(intval($hideType[$i]), array(12, 10))) //-- Date Convert dulu jadi ymd
									$hideParam .= " '" . str_replace("'", "''", $this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtValue[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))) . "' ";
								else
									$hideParam .= " " . str_replace("'", "''", trim($txtValue[$i])) . " ";
							}
						} else if (trim($selFieldName[$i]) !== "" && trim($selOperator[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($selOperand[$i]) !== "" && count(explode(",", trim($txtValue[$i]))) > 1) {
							$a = explode("|", trim($txtValue[$i]));
							if (count($a) > 0) {
								if (substr(trim($a[0]), strlen(trim($a[0])) - 1, strlen(trim($a[0]))) === ",")
									$hideParam .= "c.`" . trim($selFieldName[$i]) . "` in " . substr(trim($a[0]), 0, strlen(trim($a[0])) - 1) . " ";
								else
									$hideParam .= "c.`" . trim($selFieldName[$i]) . "` in " . trim($a[0]) . " ";
							} else
								$hideParam .= "c.`" . trim($selFieldName[$i]) . "` in " . trim($txtValue[$i]) . " ";
						}
						$hideParam .= " " . trim($selOperand[$i]) . " ";
					}
				}
			}
			$hideSQLX .= $hideParam;
			//-------------------------------------------------------------------------
			if (substr(trim($hideParam), strlen(trim($hideParam)) - 2, 2) === "ND")
				$hideSQLX = substr(trim($hideSQLX), 0, strlen(trim($hideSQLX)) - 3);
			else if (substr(trim($hideParam), strlen(trim($hideParam)) - 2, 2) === "OR")
				$hideSQLX = substr(trim($hideSQLX), 0, strlen(trim($hideSQLX)) - 2);
			//-------------------------------------------------------------------------
			$hideSQLX = "call sp_query('" . str_replace("'", "''", trim($hideSQLX)) . " ');";
			$hideSQLX = str_replace("''''", "''", $hideSQLX);
			//-------------------------------------------------------------------------
			$hideSQLX = str_replace(array("&lt;", "&gt;"), array("<", ">"), $hideSQLX);
			$rs = $this->db->query($hideSQLX);
			$fields = $rs->field_data();
			$numfield = $rs->num_fields();
			$sReturn .= "<table>";
			//-------------------------------
			$a = array();
			for ($i = 0; $i < count($selFieldLabelName); $i++) {
				$b = explode("|", trim($txtValue[$i]));
				if (count($b) > 1) {
					if(trim($b[$i]) !== "")
					{
						if (substr(trim($b[1]), strlen(trim($b[1])) - 1, strlen(trim($b[1]))) === ",")
							$a["[" . $selFieldLabelName[$i] . "]"] = substr($b[1], 0, strlen($b[1]) - 1);
						else
							$a["[" . $selFieldLabelName[$i] . "]"] = trim($txtValue[$i]) === "" ? "All" : trim($txtValue[$i]);
					}
				} else
					$a["[" . $selFieldLabelName[$i] . "]"] = trim($txtValue[$i]) === "" ? "All" : trim($txtValue[$i]);
			}
			//-------------------------------
			$sExcelParams = strtr($hideHeaderExcel, $a);
			$sExcelParams = json_decode($sExcelParams, true);
			foreach ($sExcelParams as $row)
				$sReturn .= "<tr><td style=\"text-align: center;\" colspan=\"" . $numfield . "\">" . trim($row['sHeaderDesc']) . "</td></tr>";
			//-------------------------------
			$sReturn .= "<tr>";
			foreach ($fields as $f) {
				$sLinkActive = trim($f->name);
				if (!in_array(trim($f->name), $hideColumns))
					$sReturn .= "<td>" . $sLinkActive . "</td>";
			}
			$sReturn .= "</tr>";
			if ($rs->num_rows() > 0) {
				foreach ($rs->result_array() as $row) {
					$sReturn .= "<tr class=\"cursor-pointer\">";
					foreach ($fields as $f) {
						if (!in_array(trim($f->name), $hideColumns))
							$sReturn .= "<td>" . ((in_array($f->type, array(5)) && !$f->primary_key && is_numeric(trim($row[$f->name]))) ? number_format(trim($row[$f->name]), 0) : trim($row[$f->name])) . "</td>";
					}
					$sReturn .= "</tr>";
				}
			} else
				$sReturn .= "<tr><td class=\"text-center\" colspan=\"" . trim($rs->num_fields()) . "\">No Data, Please check your parameters !</td>";
			$sReturn .= "<table></div>";
		}
		print $sReturn;
	}
	function gf_query()
	{
		$sSQL = $this->input->post('sSQL', TRUE);
		$sSQL = html_entity_decode($sSQL);
		$rs = $this->db->query("call sp_query('" . str_replace("@nUnitId", $this->session->userdata('nUnitId_fk'), str_replace("'", "''", trim($sSQL))) . "')");
		return json_encode($rs->result_array());
	}
	function gf_execute_query_to_mrt()
	{
		$sReturn              = null;
		$selFieldName    			= $this->input->post('selFieldName', TRUE);
		$selOperator     			= $this->input->post('selOperator', TRUE);
		$txtValue        			= $this->input->post('txtValue', TRUE);
		$selOperand      			= $this->input->post('selOperand', TRUE);
		$hideType       	 		= $this->input->post('hideType', TRUE);
		$hideFieldSortBy 			= $this->input->post('hideFieldSortBy', TRUE);
		$hideModeSortBy  			= $this->input->post('hideModeSortBy', TRUE);
		$nIdOpenReport 				= $this->input->post('nIdOpenReport', TRUE);
		//----------------------------------------------------------------------
		$sql 									= "call sp_query('select a.*, (select concat(p.sPathFile, p.sEncryptedFileName) from tm_user_uploads p where p.sStatusDelete is null and p.sUploadId = a.sUUID) as sFullFileName from tm_user_open_reports a where a.nIdOpenReport = " . trim($nIdOpenReport) . " and a.sStatusDelete is null');";
		$rs 									= $this->db->query($sql);
		$row            			= $rs->row_array();
		//----------------------------------------------------------------------
		$hideSQL = $this->m_core_apps_report->gf_parse_sql_x(array("hideSQL" => trim($row['sOpenReportsSQL'])));
		//----------------------------------------------------------------------
		$hideOpenReportsType 	= intval($row['nOpenReportsType']);
		//----------------------------------------------------------------------
		$hideSQL       				= explode("~", $hideSQL);
		$nCountHideSQL 				= count($hideSQL);
		for($x=0; $x<$nCountHideSQL; $x++)
		{
			$hideSQLX      = "select * from (" . trim($hideSQL[$x]) . ") as c ";
			$c = 0;
			for ($k = 0; $k < count($txtValue); $k++) {
				if (trim($txtValue[$k]) !== "")
					$c++;
			}
			if ($c > 0)
				$hideSQLX .= " where ";
			$hideParam = "";
			if (intval($hideOpenReportsType) === 1) //-- Dynamic
			{
				for ($i = 0; $i < count($selFieldName); $i++) {
					if (trim($txtValue[$i]) !== "") {
						if (trim($selFieldName[$i]) !== "" && trim($selOperator[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($selOperand[$i]) !== "") {
							$hideParam .= "c.`" . trim($selFieldName[$i]) . "` " . trim($selOperator[$i]);
							if (in_array(trim($selOperator[$i]), array("like", "=")) && in_array(intval($hideType[$i]), array(253, 12))) // String, Date
							{
								if (in_array(trim($selOperator[$i]), array("like")))
									$hideParam .= " '%" . str_replace("'", "''", trim($txtValue[$i])) . "%' ";
								else
									$hideParam .= " '" . trim($txtValue[$i]) . "' ";
							} elseif (!in_array(trim($selOperator[$i]), array("like", "="))) // Numeric dan Date
							{
								if (in_array(intval($hideType[$i]), array(12, 10))) //-- Date Convert dulu jadi ymd
									$hideParam .= " '" . str_replace("'", "''", $this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtValue[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))) . "' ";
								else
									$hideParam .= " " . str_replace("'", "''", trim($txtValue[$i])) . " ";
							}
							$hideParam .= " " . trim($selOperand[$i]) . " ";
						}
					}
				}
			} else if (intval($hideOpenReportsType) === 2) //-- Static By Params
			{
				for ($i = 0; $i < count($selFieldName); $i++) {
					if (trim($txtValue[$i]) !== "") {
						if (trim($selFieldName[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($hideType[$i]) !== "") {
							$hideParam .= "c.`" . trim($selFieldName[$i]) . "` = ";
							if (in_array(intval($hideType[$i]), array(253))) // String, Date
								$hideParam .= " '" . (trim($selOperator[$i]) === "like" ? "%" : "") . "" . trim($txtValue[$i]) . "" . (trim($selOperator[$i]) === "like" ? "%" : "") . "' ";
							else // Numeric dan Date
							{
								if (in_array(intval($hideType[$i]), array(12, 10))) //-- Date Convert dulu jadi ymd
									$hideParam .= " '" . str_replace("'", "''", $this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtValue[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))) . "' ";
								else
									$hideParam .= " " . str_replace("'", "''", trim($txtValue[$i])) . " ";
							}
							$hideParam .= " " . trim($selOperand[$i]) . " ";
						}
					}
				}
			} else if (intval($hideOpenReportsType) === 3) //-- Static By Value
			{
				for ($i = 0; $i < count($selFieldName); $i++) {
					if (trim($txtValue[$i]) !== "") {
						if (trim($selFieldName[$i]) !== "" && trim($selOperator[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($selOperand[$i]) !== "" && count(explode(",", trim($txtValue[$i]))) === 1) {
							$hideParam .= "c.`" . trim($selFieldName[$i]) . "` " . trim($selOperator[$i]) . " ";
							if (in_array(intval($hideType[$i]), array(253))) // String, Date
								$hideParam .= " '" . (trim($selOperator[$i]) === "like" ? "%" : "") . "" . trim($txtValue[$i]) . "" . (trim($selOperator[$i]) === "like" ? "%" : "") . "' ";
							else // Numeric dan Date
							{
								if (in_array(intval($hideType[$i]), array(12, 10))) //-- Date Convert dulu jadi ymd
									$hideParam .= " '" . str_replace("'", "''", $this->m_core_apps->gf_parse_date(array("sFromFormat" => "dmy", "sToFormat" => "ymd", "sDate" => trim($txtValue[$i]), "sSeparatorFrom" => "/", "sSeparatorTo" => "-"))) . "' ";
								else
									$hideParam .= " " . str_replace("'", "''", trim($txtValue[$i])) . " ";
							}
						} else if (trim($selFieldName[$i]) !== "" && trim($selOperator[$i]) !== "" && trim($txtValue[$i]) !== "" && trim($selOperand[$i]) !== "" && count(explode(",", trim($txtValue[$i]))) > 1) {
							$a = explode("|", trim($txtValue[$i]));
							if (count($a) > 0) {
								if (substr(trim($a[0]), strlen(trim($a[0])) - 1, strlen(trim($a[0]))) === ",")
									$hideParam .= "c.`" . trim($selFieldName[$i]) . "` in " . substr(trim($a[0]), 0, strlen(trim($a[0])) - 1) . " ";
								else
									$hideParam .= "c.`" . trim($selFieldName[$i]) . "` in " . trim($a[0]) . " ";
							} else
								$hideParam .= "c.`" . trim($selFieldName[$i]) . "` in " . trim($txtValue[$i]) . " ";
						}
						$hideParam .= " " . trim($selOperand[$i]) . " ";
					}
				}
			}
			$hideSQLX .= $hideParam;
			//-------------------------------------------------------------------------
			if (substr(trim($hideParam), strlen(trim($hideParam)) - 2, 2) === "ND")
				$hideSQLX = substr(trim($hideSQLX), 0, strlen(trim($hideSQLX)) - 3);
			else if (substr(trim($hideParam), strlen(trim($hideParam)) - 2, 2) === "OR")
				$hideSQLX = substr(trim($hideSQLX), 0, strlen(trim($hideSQLX)) - 2);
			//-------------------------------------------------------------------------
			$hideSQLX = "call sp_query('" . str_replace("'", "''", trim($hideSQLX)) . " ";
			$hideSQLX = str_replace("''''", "''", $hideSQLX);
			//-------------------------------------------------------------------------
			if (trim($hideFieldSortBy) !== "" && trim($hideModeSortBy) !== "")
				$hideSQLX .= " order by c.`" . trim($hideFieldSortBy) . "` " . trim($hideModeSortBy);
			$hideSQLX .= "'); ";
			$hideSQLX = html_entity_decode($hideSQLX);
			$rs = $this->db->query($hideSQLX);
			$sReturn[$x] = array("data" . $x => $rs->result_array());
		}
		return json_encode(array("oData" => $sReturn, "oReportInfo" => $row['sFullFileName'], "oParams" => array("oFieldName" => $selFieldName, "oOperator" => $selOperator, "oValue" => $txtValue), "session" => array("login" => $this->session->userdata(), "datetime" => date('d/m/Y H:i:s'))));
	}
}
