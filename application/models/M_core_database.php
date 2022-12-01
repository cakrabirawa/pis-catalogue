<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_database extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
	}
	function gf_load_data($sParam = null)
	{
		$oParam = $_POST;
		$oData = $sParam === null ? $oParam['key_value'] : $sParam['key_value'];
		$sql = "call sp_query('select [field_name] from [table_name] where [condition]')";
		$rs = $this->db->query($sql);
		return $rs->result_array();
	}
	function gf_load_database()
	{
		$sReturn = null;
		$sql = "call sp_query('SELECT * FROM `information_schema`.`SCHEMATA`');";
		$rs = $this->db->query($sql);
		$sReturn .= "<ul class=\"nav nav-list\">";
		$a = array("Tables", "Views", "Stored Procedures", "Functions", "Triggers", "Events");
		foreach ($rs->result_array() as $row) {
			$sReturn .= "<li><label class=\"tree-toggle cursor-pointer\" limode=\"database\" title=\"" . trim($row['SCHEMA_NAME']) . "\" id=\"" . str_replace(" ", "_", strtolower(trim($row['SCHEMA_NAME']))) . "\" dbname=\"" . str_replace(" ", "_", strtolower(trim($row['SCHEMA_NAME']))) . "\"><span class=\"fa fa-arrow-right\"></span> " . trim($row['SCHEMA_NAME']) . "</label>";
			$sReturn .= "<ul class=\"nav nav-list tree bullets\" id=\"ul-" . trim($row['SCHEMA_NAME']) . "\">";
			$sReturn .= "</ul>";
		}
		$sReturn .= "</ul>";
		return json_encode(array("oData" => $sReturn, "oDataDetail" => $rs->result_array()));
	}
	function gf_load_attribute()
	{
		$sReturn = null;
		$sDBName = $this->input->post('sDBName', TRUE);
		$a = array("Tables", "Views", "Stored Procedures", "Functions", "Triggers", "Events");
		for ($i = 0; $i < count($a); $i++) {
			$sReturn .= "<li style=\"margin-left: 10px;\"><label class=\"tree-toggle nav-header cursor-pointer\" title=\"" . $a[$i] . "\" dbname=\"" . trim($sDBName) . "\" limode=\"" . strtolower($a[$i]) . "\" id=\"" . trim($sDBName) . "\"><span class=\"fa fa-cog\"></span> " . $a[$i] . "</label>";
			$sReturn .= "<ul class=\"nav nav-list tree\" id=\"ul-place-attribute-" . str_replace(" ", "_", strtolower($a[$i])) . "\">";
			$sReturn .= "</ul>";
			$sReturn .= "</li>";
		}
		return json_encode(array("oData" => $sReturn));
	}
	function gf_load_attribute_content()
	{
		$sReturn = null;
		$sDBName = $this->input->post('sDBName', TRUE);
		$sLiMode = $this->input->post('sLiMode', TRUE);
		$sql = null;
		$sMode = "";
		$sIcon = "";
		if (trim(strtolower($sLiMode)) === "tables") {
			$sql = "call sp_query('SELECT TABLE_NAME, ENGINE FROM information_schema.`TABLES` WHERE TABLE_SCHEMA = ''" . trim($sDBName) . "'' ');";
			$sMode = "table";
			$sIcon = "fa fa-table";
		} elseif (trim(strtolower($sLiMode)) === "views") {
			$sql = "call sp_query('SELECT TABLE_SCHEMA, TABLE_NAME FROM information_schema.`TABLES` WHERE TABLE_TYPE LIKE ''VIEW'' AND TABLE_SCHEMA = ''" . trim($sDBName) . "'' ');";
			$sMode = "view";
			$sIcon = "fa fa-subway";
		} elseif (trim(strtolower($sLiMode)) === "stored procedures") {
			$sql = "call sp_query('SELECT ROUTINE_NAME as TABLE_NAME, DEFINER as ENGINE FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = ''" . trim($sDBName) . "'' AND ROUTINE_TYPE = ''PROCEDURE'' ');";
			$sMode = "storedprocedure";
			$sIcon = "fa fa-slack";
		} elseif (trim(strtolower($sLiMode)) === "functions") {
			$sql = "call sp_query('SELECT ROUTINE_NAME as TABLE_NAME, DEFINER as ENGINE FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = ''" . trim($sDBName) . "'' AND ROUTINE_TYPE = ''FUNCTION'' ');";
			$sMode = "function";
			$sIcon = "fa fa-codepen";
		} elseif (trim(strtolower($sLiMode)) === "triggers") {
			$sql = "call sp_query('SELECT ROUTINE_NAME as TABLE_NAME, DEFINER as ENGINE FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = ''" . trim($sDBName) . "'' AND ROUTINE_TYPE = ''TRIGGER'' ');";
			$sMode = "trigger";
			$sIcon = "fa fa-bolt";
		} elseif (trim(strtolower($sLiMode)) === "events") {
			$sql = "call sp_query('SELECT ROUTINE_NAME as TABLE_NAME, DEFINER as ENGINE FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = ''" . trim($sDBName) . "'' AND ROUTINE_TYPE = ''EVENT'' ');";
			$sMode = "event";
			$sIcon = "fa fa-cube";
		}

		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $row) {
				$sReturn .= "<li style=\"margin-left: 10px;\"><label class=\"tree-toggle nav-header cursor-pointer\" title=\"" . trim($row['TABLE_NAME']) . "\" database=\"" . trim($sDBName) . "\" table=\"" . trim($row['TABLE_NAME']) . "\" mode=\"" . trim($sMode) . "\"><span class=\"" . trim($sIcon) . "\"></span> " . trim($row['TABLE_NAME']) . "<!-- - " . trim($row['ENGINE']) . "--></label>";
				$sReturn .= "<ul class=\"nav nav-list tree\" id=\"ul-place-attribute-" . str_replace(" ", "_", strtolower(trim($row['TABLE_NAME']))) . "\">";
				$sReturn .= "</ul>";
				$sReturn .= "</li>";
			}
		} else
			$sReturn .= "<li style=\"margin-left: 10px;\"><label class=\"tree-toggle nav-header\" database=\"" . trim($sDBName) . "\"><span class=\"fa fa-ban\"></span> Not Found</label></li>";
		return json_encode(array("oData" => $sReturn));
	}
	function gf_server_info()
	{
		$sReturn = null;
		$sql = "SHOW VARIABLES where Variable_name IN ('version', 'version_comment', 'basedir', 'datadir');";
		$rs = $this->db->query($sql);
		$sReturn = "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-2\">";
		$sReturn .= "<table class=\"table-responsive table-striped table-hover table-custom-header table-custom-header-color-text\">";
		if ($rs->num_rows() > 0) {
			foreach ($rs->result_array() as $row) {
				$sReturn .= "<tr><td>" . trim($row['Variable_name']) . "</td><td>" . trim($row['Value']) . "</td></tr>";
			}
		}
		$sReturn .= "</table>";
		$sReturn .= "</div>";
		return json_encode(array("oData" => $sReturn));
	}
	function gf_load_table_content()
	{
		$sReturn = null;
		$sDBName = $this->input->post('sDBName', TRUE);
		$sTableName = $this->input->post('sTableName', TRUE);
		$sql = "call sp_query('SELECT * FROM information_schema.COLUMNS WHERE table_schema = ''" . trim($sDBName) . "'' AND table_name=''" . trim($sTableName) . "'' order by ordinal_position')";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0) {
			$sReturn = "<div class=\"table-responsive\">";
			$sReturn .= "<table class=\"table table-responsive table-striped table-hover table-custom-header table-custom-header-color-text\">";
			$sReturn .= "<tr><td>No</td><td>Column Name</td><td>Data Type</td><td>Length</td><td>Default</td><td class=\"text-center\">PK ?</td><td class=\"text-center\">Not Null ?</td><td class=\"text-center\">Unsigned ?</td><td class=\"text-center\">Auto Incr ?</td><td class=\"text-center\">Zero Fill ?</td><td>Comment</td><td>Action</td></tr>";
			$i = 0;
			foreach ($rs->result_array() as $row) {
				$sReturn .= "<tr>";
				$sReturn .= "<td class=\"text-right\">" . ($i + 1) . "<input type=\"hidden\" name=\"sNo[]\" id=\"sNo\" value=\"" . ($i + 1) . "\" /></td><td>" . trim($row['COLUMN_NAME']) . "<input type=\"hidden\" name=\"sColName[]\" id=\"sColName\" value=\"" . trim($row['COLUMN_NAME']) . "\" /></td>";
				$sReturn .= "<td>" . trim($row['DATA_TYPE']) . "<input type=\"hidden\" name=\"sDatatype[]\" id=\"sDatatype\" value=\"" . trim($row['DATA_TYPE']) . "\" /></td>";
				$sReturn .= "<td class=\"text-right text-red\">" . trim($row['CHARACTER_MAXIMUM_LENGTH']) . "<input type=\"hidden\" name=\"sCharMaxLength[]\" id=\"sCharMaxLength\" value=\"" . trim($row['CHARACTER_MAXIMUM_LENGTH']) . "\" /></td>";
				$sReturn .= "<td>" . trim($row['COLUMN_DEFAULT']) . "<input type=\"hidden\" name=\"sColDefault[]\" id=\"sColDefault\" value=\"" . trim($row['COLUMN_DEFAULT']) . "\" /></td>";
				$sReturn .= "<td class=\"text-center\"><i class=\"fa " . (trim($row['COLUMN_KEY']) === "PRI" ? "fa-check" : "fa-close") . " text-red\"></i><input type=\"hidden\" name=\"sColKey[]\" id=\"sColKey\" value=\"" . trim($row['COLUMN_KEY']) . "\" /></td>";
				$sReturn .= "<td class=\"text-center\"><i class=\"fa " . (trim($row['IS_NULLABLE']) === "NO" ? "fa-check" : "fa-close") . " text-red\"></i><input type=\"hidden\" name=\"sNullAble[]\" id=\"sNullAble\" value=\"" . trim($row['IS_NULLABLE']) . "\" /></td>";

				$x = explode(" ", trim($row['COLUMN_TYPE']));
				if (count($x) > 1) {
					$sReturn .= "<td class=\"text-center\"><i class=\"fa ";
					$sReturn .= (trim($x[1]) === "unsigned" ? "fa-check" : "fa-close") . " text-red\">";
					$sReturn .= "</i><input type=\"hidden\" name=\"sColType[]\" id=\"sColType\" value=\"" . trim($x[1]) . "\" /></td>";
				} else
					$sReturn .= "<td class=\"text-center\"><i class=\"fa fa-close text-red\"></i><input type=\"hidden\" name=\"sColType[]\" id=\"sColType\" value=\"\" /></td>";

				$sReturn .= "<td class=\"text-center\"><i class=\"fa " . (trim($row['EXTRA']) === "auto_increment" ? "fa-check" : "fa-close") . " text-red\"></i><input type=\"hidden\" name=\"sAutoIncr[]\" id=\"sAutoIncr\" value=\"" . trim($row['EXTRA']) . "\" /></td>";

				$x = explode(" ", trim($row['COLUMN_TYPE']));
				if (count($x) > 1) {
					$sReturn .= "<td class=\"text-center\"><i class=\"fa ";
					$sReturn .= (trim($x[1]) === "zerofill" ? "fa-check" : "fa-close") . " text-red\">";
					$sReturn .= "</i><input type=\"hidden\" name=\"sColType[]\" id=\"sColType\" value=\"\" /></td>";
				} else
					$sReturn .= "<td class=\"text-center\"><i class=\"fa fa-close text-red\"></i><input type=\"hidden\" name=\"sColType[]\" id=\"sColType\" value=\"\" /></td>";

				$sReturn .= "<td class=\"text-center\">" . (trim($row['COLUMN_COMMENT'])) . "<input type=\"hidden\" name=\"sColComment[]\" id=\"sColComment\" value=\"" . trim($row['COLUMN_COMMENT']) . "\" /></td>";
				$sReturn .= "<td class=\"text-center\"><i class=\"fa fa-close text-red cursor-pointer\" title=\"Remove Field\"></i></td></tr>";
				$i++;
			}
			$sReturn .= "</table>";
			$sReturn .= "</div>";
		}
		return json_encode(array("oData" => $sReturn, "oDataDetail" => $rs->result_array()));
	}
	function gf_create_database()
	{
		$sReturn = null;
		$sDBName = $this->input->post('sDBName', TRUE);
		$sql = "call sp_query('SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ''" . trim($sDBName) . "'' ')";
		$rs = $this->db->query($sql);
		if ($rs->num_rows() > 0)
			$sReturn = json_encode(array("oData" => $rs, "oStatus" => -1, "sMessage" => "Database " . trim($sDBName) . " Already Exists. Please check your Database Name !"));
		else {
			$sql = "create database " . trim($sDBName);
			$rs = $this->db->query($sql);
			$sReturn = json_encode(array("oData" => $rs, "oStatus" => 1));
		}
		return $sReturn;
	}
	function gf_load_info_core_engine($oParams = array())
	{
		$sReturn = null;
		$sql = "SHOW ENGINES";
		$rs = $this->db->query($sql);
		$sReturn = "<option value=\"[DEFAULT]\">[DEFAULT]</option>";
		foreach ($rs->result_array() as $row) {
			if (array_key_exists("sFieldInitValue", $oParams)) {
				if (trim(strtoupper($row['Engine'])) === trim($oParams['sFieldInitValue']))
					$sReturn .= "<option value=\"" . strtoupper($row['Engine']) . "\" selected>" . strtoupper($row['Engine']) . "</option>";
				else
					$sReturn .= "<option value=\"" . strtoupper($row['Engine']) . "\">" . strtoupper($row['Engine']) . "</option>";
			} else
				$sReturn .= "<option value=\"" . strtoupper($row['Engine']) . "\">" . strtoupper($row['Engine']) . "</option>";
		}
		return $sReturn;
	}
	function gf_load_info_core_charset($oParams = array())
	{
		$sReturn = null;
		$sql = "SHOW CHARACTER SET";
		$rs = $this->db->query($sql);
		$sReturn = "<option value=\"[DEFAULT]\">[DEFAULT]</option>";
		foreach ($rs->result_array() as $row) {
			if (array_key_exists("sFieldInitValue", $oParams)) {
				if (trim(strtoupper($row['Charset'])) === trim($oParams['sFieldInitValue']))
					$sReturn .= "<option value=\"" . strtoupper($row['Charset']) . "\" selected>" . strtoupper($row['Charset']) . "</option>";
				else
					$sReturn .= "<option value=\"" . strtoupper($row['Charset']) . "\">" . strtoupper($row['Charset']) . "</option>";
			} else
				$sReturn .= "<option value=\"" . strtoupper($row['Charset']) . "\">" . strtoupper($row['Charset']) . "</option>";
		}
		return $sReturn;
	}
	function gf_load_info_core_collate($oParams = array())
	{
		$sReturn = null;
		$sql = "SHOW COLLATION";
		$rs = $this->db->query($sql);
		$sReturn = "<option value=\"[DEFAULT]\">[DEFAULT]</option>";
		foreach ($rs->result_array() as $row) {
			if (array_key_exists("sFieldInitValue", $oParams)) {
				if (trim(strtoupper($row['Collation'])) === trim($oParams['sFieldInitValue']))
					$sReturn .= "<option value=\"" . strtoupper($row['Collation']) . "\" selected>" . strtoupper($row['Collation']) . "</option>";
				else
					$sReturn .= "<option value=\"" . strtoupper($row['Collation']) . "\">" . strtoupper($row['Collation']) . "</option>";
			} else
				$sReturn .= "<option value=\"" . strtoupper($row['Collation']) . "\">" . strtoupper($row['Collation']) . "</option>";
		}
		return $sReturn;
	}
	function gf_load_info_core_data_type($oParams = array())
	{
		$sReturn = "";
		$a = array("bigint:1", "binary:0", "bit:0", "blob:1", "bool:1", "boolean:1", "char:0", "date:1", "datetime:1", "decimal:1", "double:1", "enum:0", "float:1", "int:1", "longblob:0", "longtext:0", "mediumblob:0", "mediumint:1", "mediumtext:0", "numeric:1", "real:1", "set:0", "smallint:1", "text:0", "time:0", "timestamp:0", "tinyblob:0", "tinyint:1", "tinytext:0", "varbinary:1", "varchar:0", "year:1");
		for ($i = 0; $i < count($a); $i++) {
			$b = explode(":", $a[$i]);
			$sReturn .= "<option value=\"" . $b[0] . "\" mode=\"" . $b[1] . "\">" . $b[0] . "</option>";
		}
		return $sReturn;
	}
	function gf_create_table()
	{
		$txtTableName = $this->input->post('txtTableName', TRUE);
		$txtDatabaseName = $this->input->post('txtDatabaseName', TRUE);
		$txtTableEngine = $this->input->post('txtTableEngine', TRUE);
		$txtTableCollate = $this->input->post('txtTableCollate', TRUE);
		$txtTableCharset = $this->input->post('txtTableCharset', TRUE);

		//-- Array
		$txtColumnName = $this->input->post('txtColumnName', TRUE);
		$nColumnMode = $this->input->post('nColumnMode', TRUE);
		$selColumnType = $this->input->post('selColumnType', TRUE);
		$txtColumnLength = $this->input->post('txtColumnLength', TRUE);
		$txtDefault = $this->input->post('txtDefault', TRUE);
		$sPK = $this->input->post('sPK', TRUE);
		$sNotNull = $this->input->post('sNotNull', TRUE);
		$sUnsigned = $this->input->post('sUnsigned', TRUE);
		$sAutoIncr = $this->input->post('sAutoIncr', TRUE);
		$sZeroFill = $this->input->post('sZeroFill', TRUE);
		$txtColumnComment = $this->input->post('txtColumnComment', TRUE);

		$sPrimary = "";

		$sql = "DROP TABLE IF EXISTS " . trim($txtDatabaseName) . "." . trim($txtTableName) . "; CREATE TABLE " . trim($txtDatabaseName) . "." . trim($txtTableName) . " ";
		$sql .= "(";
		for ($i = 0; $i < count($txtColumnName); $i++) {
			if (trim($txtColumnName[$i]) !== "") {
				$sql .= trim($txtColumnName[$i]) . " " . trim($selColumnType[$i]);
				//-- Non Numeric
				if (intval($nColumnMode[$i]) === 0) {
					$sql .= "(" . trim(str_replace(",", "", $txtColumnLength[$i])) . ")";
				}
				$sql .= ", ";
				if (intval($sPK[$i]) === 1) {
					$sPrimary .= trim($txtColumnName[$i]) . ", ";
				}
			}
		}
		$sql = substr($sql, 0, strlen($sql) - 2);
		if (trim($sPrimary) !== "")
			$sql .= ", PRIMARY KEY (" . substr($sPrimary, 0, strlen($sPrimary) - 2) . ")";
		$sql .= ")";

		if (trim($txtTableCharset) !== "[DEFAULT]")
			$sql .= " DEFAULT CHARACTER SET " . trim($txtTableCharset);
		if (trim($txtTableCollate) !== "[DEFAULT]")
			$sql .= " COLLATE " . trim($txtTableCollate);
		if (trim($txtTableEngine) !== "[DEFAULT]")
			$sql .= " ENGINE = " . trim($txtTableEngine);


		$rs = $this->db->query($sql);

		return json_encode($rs);
	}
	function gf_drop_database()
	{
		$sReturn = null;
		$sDBName = $this->input->post('sDBName', TRUE);
		$sql = "DROP DATABASE " . trim($sDBName);
		$rs = $this->db->query($sql);
		return json_encode($rs);
	}
	function gf_read_stored_procedure()
	{
		$sReturn = null;
		$sSPName = $this->input->post('sSPName', TRUE);
		$sDBName = $this->input->post('sDBName', TRUE);
		$sql = "SELECT ROUTINE_DEFINITION, " . trim($sDBName) . ".gf_split_string(DEFINER, '@', 1) as DEFINER01, " . trim($sDBName) . ".Gf_split_string(DEFINER, '@', 2) as DEFINER02 FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_SCHEMA = '" . trim($sDBName) . "' AND ROUTINE_TYPE = 'PROCEDURE' AND ROUTINE_NAME = '" . trim($sSPName) . "';";
		$rsHeader = $this->db->query($sql);
		$rowH = $rsHeader->row_array();
		$a = "DELIMITER $$\n";
		$a .= "USE `" . trim($sDBName) . "`$$\n";
		$a .= "DROP PROCEDURE IF EXISTS `" . trim($sSPName) . "`$$\n";
		$a .= "CREATE DEFINER=`" . trim($rowH['DEFINER01']) . "`@`" . trim($rowH['DEFINER02']) . "` PROCEDURE `" . trim($sSPName) . "`\n(\n";
		$sql = "SELECT ORDINAL_POSITION, PARAMETER_MODE, PARAMETER_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, DTD_IDENTIFIER, COLLATION_NAME, NUMERIC_PRECISION FROM information_schema.parameters WHERE SPECIFIC_SCHEMA = '" . trim($sDBName) . "' AND SPECIFIC_NAME = '" . trim($sSPName) . "';";
		$rsDetail = $this->db->query($sql);
		foreach ($rsDetail->result_array() as $rowD)
			$a .= "\t" . trim($rowD['PARAMETER_NAME']) . " " . trim($rowD['DTD_IDENTIFIER']) . ",\n";
		$a = substr($a, 0, strlen($a) - 2);
		$a .= "\n)\n\n\n";
		$a .= trim($rowH['ROUTINE_DEFINITION']) . "\n\n\n";
		$a .= "$$\n";
		$a .= "DELIMITER ;";
		return json_encode(array("oDataHeader" => $a));
	}
	function gf_alter_remove_stored_procedure()
	{
		$sReturn = null;
		$sParam = $this->input->post('sParam', TRUE);
		$sSPName = $this->input->post('sSPName', TRUE);
		$sSQL = $this->input->post('sSQL', TRUE);
		$sDBName = $this->input->post('sDBName', TRUE);
		$sql = null;
		if (trim($sParam) === "ALTER_PROC")
			$sql = $sSQL;
		elseif (trim($sParam) === "DROP_PROC")
			$sql = "DROP PROC " . trim($sDBName) . "." . trim($sSPName);
		$rs = $this->db->query($sql);
		return json_encode($rs);
	}
	function gf_execute_query()
	{
		$sReturn         = null;
		$oConfig         = $this->m_core_apps->gf_read_config_apps();
		//-- Array
		$hideFieldSortBy = $this->input->post('hideFieldSortBy', TRUE);
		$hideModeSortBy  = $this->input->post('hideModeSortBy', TRUE);

		$hidePageLimit   = $this->input->post('hidePageLimit', TRUE);
		$hidePageLimit = !isset($hidePageLimit) ? 20 : $hidePageLimit;
		$hidePageCurrent = $this->input->post('hidePageCurrent', TRUE);
		$hidePageCurrent = !isset($hidePageCurrent) ? 1 : $hidePageCurrent;

		$oPaging = null;

		$hideSQL      = $this->input->post('hideSQL', TRUE);
		if (substr(trim($hideSQL), 0, 6) === "select") {
			$hideSQL      = "select * from (" . trim($hideSQL) . ") as c ";
			$hideSQL = "call sp_query('" . str_replace("'", "''", trim($hideSQL)) . " ";
			if (trim($hideFieldSortBy) !== "" && trim($hideModeSortBy) !== "")
				$hideSQL .= " order by c.`" . trim($hideFieldSortBy) . "` " . trim($hideModeSortBy);
			$hideSQL .= "'); ";
			//exit($hideSQL);		
			$rs = $this->db->query($hideSQL);
			$fields = $rs->field_data();

			$oCoreData = json_decode($this->m_core_apps->gf_render_paging_data(array("oRecordSet" => $rs, "oShow" => $hidePageLimit, "oPage" => $hidePageCurrent)), TRUE);

			$data   = $oCoreData['sData'];
			$fields = $fields;
			$paging = $oCoreData['sPaging'];

			$INIT_PAGE_PER_SHOW = $hidePageLimit;
			$INIT_PAGE_NO       = intval($hidePageCurrent) === -1 ? "All" : intval($hidePageCurrent);

			//-------------------------------
			$sReturn .= "<div class=\"btn-group\" style=\"margin-bottom: 10px;\"><button type=\"button\" class=\"btn btn-default btn-md\"><span id=\"spanRowPerPage\">" . $INIT_PAGE_PER_SHOW . "</span></button><button type=\"button\" class=\"btn btn-default dropdown-toggle btn-md\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"caret\"></span><span class=\"sr-only\">Toggle Dropdown</span></button><ul id=\"ulRowPerPage\" class=\"dropdown-menu\"><li><a href=\"#\">5</a></li><li><a href=\"#\">20</a></li><li><a href=\"#\">50</a></li><li><a href=\"#\">100</a></li><li><a href=\"#\">250</a></li><li><a href=\"#\">500</a></li><li><a href=\"#\">1000</a></li></ul></div>";
			//-------------------------------
			$oPaging = NULL;
			$rsp = ceil((intval($rs->num_rows()) / intval($hidePageLimit)));
			for ($i = 1; $i <= $rsp; $i++)
				$oPaging .= "<li><a href=\"#\" title=\"Goto Page: " . trim($i) . "\">" . trim($i) . "</a></li>";
			$oPaging .= "<li class=\"divider\"></li>";
			$oPaging .= "<li><a href=\"#\" title=\"All Data\">All</a></li>";
			//-------------------------------
			$sReturn .= "<div class=\"btn-group pull-right\" id=\"divPage\" style=\"margin-bottom: 10px;\"><button type=\"button\" class=\"btn btn-default btn-md\"><span id=\"spanPage\">" . $INIT_PAGE_NO . "</span></button><button type=\"button\" class=\"btn btn-default btn-md  dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"caret\"></span><span class=\"sr-only\">Toggle Dropdown</span></button><ul id=\"ulPaging\" class=\"dropdown-menu scrollable-menu\" role=\"menu\">" . trim($oPaging) . "</ul></div>";
			//-------------------------------
			$sReturn .= "<div class=\"table-responsive\"><table id=\"tableData\" class=\"" . $oConfig['TABLE_CLASS'] . "\">";
			$sReturn .= "<tr>";
			foreach ($fields as $f) {
				$sLinkActive = trim($f->name);
				$sReturn .= "<td style=\"cursor: pointer;\" sfieldname=\"" . $sLinkActive . "\">" . $sLinkActive . " " . (trim($hideFieldSortBy) === trim($sLinkActive) ? (trim($hideModeSortBy) === "ASC" ? "<i class=\"fa fa-sort-alpha-asc\"></i>" : "<i class=\"fa fa-sort-alpha-desc\"></i>") : "<!--<i class=\"fa fa-unsorted\"></i>-->") . "</td>";
			}
			$sReturn .= "</tr>";
			if ($rs->num_rows() > 0) {
				foreach ($data as $key => $value) {
					$sReturn .= "<tr class=\"cursor-pointer\">";
					$i = 0;
					foreach ($fields as $f) {
						$sSpan = trim($value[0][$f->name]);
						if (DateTime::createFromFormat('Y-m-d', trim($value[0][$f->name])) !== FALSE)
							$sSpan = $this->m_core_apps->gf_parse_date(array("sFromFormat" => "ymd", "sToFormat" => "dmy", "sDate" => trim($value[0][$f->name]), "sSeparatorFrom" => "-", "sSeparatorTo" => "-"));
						else if (DateTime::createFromFormat('Y-m-d H:m:s', trim($value[0][$f->name])) !== FALSE) {
							$sDate = explode(" ", trim($value[0][$f->name]));
							$sSpan = $this->m_core_apps->gf_parse_date(array("sFromFormat" => "ymd", "sToFormat" => "dmy", "sDate" => trim($sDate[0]), "sSeparatorFrom" => "-", "sSeparatorTo" => "-")) . " " . trim($sDate[1]);
						}
						$sReturn .= "<td>" . trim($sSpan) . "</td>";
						$i++;
					}
					$sReturn .= "</tr>";
				}
			} else
				$sReturn .= "<tr><td class=\"text-center\" colspan=\"" . trim($rs->num_fields()) . "\">No Data, Please check your parameters !</td>";
			$sReturn .= "<table></div>";
		} else {
			$hideSQL = "call sp_query('" . str_replace("'", "''", trim($hideSQL)) . " ";
			$hideSQL .= "'); ";
			$rs = $this->db->query($hideSQL);
			$fields = $rs->field_data();
			$sReturn = $rs;
		}
		return json_encode(array("oResult" => $sReturn, "oSQL" => $hideSQL, "oPaging" => $oPaging, "oPageCurrent" => $hidePageCurrent, "oPagePerRow" => $hidePageLimit));
	}
}
