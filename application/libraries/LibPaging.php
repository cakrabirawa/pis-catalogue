<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
Last Update: October 10 2018 10:13
----------------------------------------------------
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
class libPaging
{
	var $dDebugSQL = null;
	public function __construct()
	{
		$this->CI = &get_instance();
	}
	public function gf_render_paging_data($sParams = array())
	{
		$sYMDDateRegex 							= "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/";
		$sDMYDateRegex	 						= "/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/";
		$sYMDHISDateRegex 					= "/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]) \d{2}:\d{2}:\d{2}$/";
		$sDMYHISDateRegex 					= "/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4} \d{2}:\d{2}:\d{2}$/";

		$sReturn 										= $sHeader
			= $sDetail
			= NULL;
		$oConfig                    = $this->CI->m_core_apps->gf_read_config_apps(array("TABLE_CLASS", "DECIMAL_POINT", "COLUMN_FORMAT_PAGING"));
		$sFieldName									= trim($this->CI->input->post('hideFieldName', TRUE));
		$sOperator									= trim($this->CI->input->post('hideOperator', TRUE));
		$nPageActive								= trim($this->CI->input->post('hidePage', TRUE));
		$nRowPerPage								= trim($this->CI->input->post('hideRowPage', TRUE));
		$sSearchWhat								= trim($this->CI->input->post('hideSearchWhat', TRUE));
		$sSearchWhatOriginal  			= trim($this->CI->input->post('hideSearchWhat', TRUE));
		$sFieldType									= trim($this->CI->input->post('hideFieldType', TRUE));
		$sSortField									= trim($this->CI->input->post('hideFieldSort', TRUE));
		$sSortMode									= trim($this->CI->input->post('hideFieldSortMode', TRUE));
		$hideSQL										= trim($this->CI->input->post('hideSQL', TRUE));
		$showPagingNav  						= trim($this->CI->input->post('showPagingNav', TRUE));
		$showFilter 								= trim($this->CI->input->post('showFilter', TRUE));

		$showPagingNav  						= array_key_exists("showPagingNav", $sParams) ? true : false;
		$showFilter 								= array_key_exists("showFilter", $sParams) ? true : false;

		$hideSQL										= empty($hideSQL) ? trim($sParams['sSQL'])  : trim($this->CI->input->post('hideDebugSQL', TRUE));
		$bDebugSQL                  = array_key_exists("bDebugSQL", $sParams) ? "1" : "0";
		$bDebugSQL                  = trim($bDebugSQL) === "1" ? (($sParams['bDebugSQL']) ? "1" : "0") : "0";
		$hideSearchField						= array_key_exists("sDefaultFieldSearch", $sParams) ? trim($sParams['sDefaultFieldSearch']) : "";
		$sCycleParam								= array_key_exists('sCycleParam', $sParams) ? $sParams['sCycleParam'] : "";
		$sCallBackURLPageEditDelete = array_key_exists('sCallBackURLPageEditDelete', $sParams) ? trim($sParams['sCallBackURLPageEditDelete']) : "";
		$sLookupMode                = array_key_exists('sLookupMode', $sParams) ? trim($sParams['sLookupMode']) : ((array_key_exists('sLookupPopup', $sParams) ? "single" : ""));
		$sJSParam                   = array_key_exists('sJSParam', $sParams) ? $sParams['sJSParam'] : "";
		$nInitRowPerPage					  = array_key_exists('hideInitRowPage', $sParams);
		$sTableClass                = $oConfig['TABLE_CLASS'];
		$sButtonViewClass           = "btn btn-primary btn-xs";
		$sHightlighColor            = "#9DFF9D";
		$DECIMAL_POINT 							= intval($oConfig['DECIMAL_POINT']);
		$COL_FORMAT     						= array_key_exists('sColumnFormat', $sParams) ? trim($sParams['sColumnFormat']) : $oConfig['COLUMN_FORMAT_PAGING'];
		$MAX_LENGTH_TITLE 					= 20;


		$oVirtualScrollHeight 			= array_key_exists('nVirtualScrollHeight', $sParams) ? $sParams['nVirtualScrollHeight'] : "570";
		$sCustomActionViewCaption   = array_key_exists('sCustomActionViewCaption', $sParams) ? trim($sParams['sCustomActionViewCaption']) : "View";

		$nPageActive 								= empty($nPageActive) ? 1 : (trim($this->CI->input->post('hidePage')) === "All" ? -1 : trim($this->CI->input->post('hidePage')));
		$nRowPerPage 								= empty($nRowPerPage) ? 20 : $this->CI->input->post('hideRowPage');
		$isFirst    								= $this->CI->input->post('hideFirst');
		$isFirst 		 								= empty($isFirst) ? "" : $this->CI->input->post('hideFirst');

		if (trim($isFirst) === "" && $nInitRowPerPage)
			$nRowPerPage = intval($sParams['hideInitRowPage']);

		$oUUID = $this->CI->input->post('hideUUID', TRUE);
		$sUUID = empty($oUUID) ? md5(uniqid()) : trim($oUUID);
		if (!empty($sParams['sTableDataId']))
			$sUUID = trim($sParams['sTableDataId']);

		if (preg_match($sDMYDateRegex, trim($sSearchWhat)))
			$sSearchWhat = trim(date("Y-m-d", strtotime(trim($sSearchWhat))));
		if (preg_match($sDMYHISDateRegex, trim($sSearchWhat)))
			$sSearchWhat = trim(date("Y-m-d H:i:s", strtotime(trim($sSearchWhat))));

		$sOperator = html_entity_decode($sOperator);
		//---
		$sReturnArray = array();
		$sFieldIgnore = $sReturnString = NULL;
		//--------------------------------------------
		$sSortField = $sSortField;
		$sSortMode = $sSortMode;
		//---------------------------------------------------
		if (array_key_exists("sFieldIgnore", $sParams))
			$sFieldIgnore =  $sParams['sFieldIgnore'];
		//--------------------------------------------

		{
			$sql = $sParams['sSQL'];
			if (trim($sFieldName) !== "" && trim($sOperator) !== "") {
				$sql = "select * from (" . $sql . ") as x ";
				if (trim($sOperator) !== "") {
					$c = explode("|", trim($sSearchWhat));
					if (trim($sSearchWhat) !== "" && count($c) > 0) {
						$sql .= " where ";
						for ($i = 0; $i < count($c); $i++) {
							if (trim($c[$i]) !== "") {
								$sql .= (trim($sOperator) === "Like" ? " lower" : "") . "(`" . trim($sFieldName) . "`) " . trim($sOperator) . " ";
								//-----------------------------------------
								if (trim($sOperator) === "Like")
									$sql .= " lower('%" . trim($c[$i]) . "%') ";
								elseif (trim($sOperator) === "=")
									$sql .= (is_numeric(trim($c[$i]))) ? " (" . str_replace(",", "", trim($c[$i])) . ") " : (trim($sOperator) === "Like" ? " lower" : "") . "('" . trim($c[$i]) . "') ";
								else
									$sql .= " '" . trim($c[$i]) . "' ";
								$sql .= " or ";
							}
						}
						$sql = substr($sql, 0, strlen($sql) - 4);
					}
				}
			}
		}

		$sql .= (trim($sSortField) !== "" && trim($sSortField) !== "null") ? " order by `" . trim($sSortField) . "` " . $sSortMode : "";

		$nLimitStart = ($nPageActive * $nRowPerPage) - $nRowPerPage;
		$nLimitEnd = $nRowPerPage * $nPageActive;
		$sql .= " limit " . $nLimitStart . ", " . $nRowPerPage;

		$sql = "call sp_query('" . str_replace("'", "''", trim(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $sql))) . "')";

		$rs 							= $this->CI->db->query($sql);
		$fields 					= $rs->field_data();
		$NUM_ROWS 				= $rs->num_rows();

		//Layout Grid
		if (trim($sParams['sLayout']) === "GRID_SYSTEM" || !array_key_exists("sLayout", $sParams)) {
			$sHiddenField = "";
			$sReturnString .= "<div class=\"table-responsive\"><table id=\"otable" . $sUUID . "\" class=\"" . $sTableClass . "\"><tr>";
			if ($NUM_ROWS > 0) {
				$i = 0;
				foreach ($fields as $f) {
					$sLinkActive = trim($f->name);
					if (array_key_exists("sFieldIgnore", $sParams) && $sParams['sFieldIgnore'] !== NULL) {
						if (!in_array(trim($f->name), $sFieldIgnore)) {
							$sLinkActive = "<a style=\"font-weight: normal;\" id=\"aLinkSort" . $sUUID . "\" mode=\"" . $sSortMode . "\" title=\"Sort Column " . trim($f->name) . ": " . $sSortMode . "\">" . trim($f->name) . "</a>";
							if (trim($sSortField) === trim($f->name))
								$sLinkActive = "<a style=\"font-weight: bold;\" id=\"aLinkSort" . $sUUID . "\" mode=\"" . $sSortMode . "\" title=\"Sort Column " . trim($f->name) . ": " . $sSortMode . "\">" . trim($f->name) . "</a> " . (trim($sSortMode) === "asc" ? "<i class=\"fa fa-sort\"></i>" : "<i class=\"fa fa-sort\"></i>");
							$sReturnString .= "<td class=\"cursor-pointer\">" . $sLinkActive . "</td>";
						} else {
							$sLinkActive = "<a style=\"font-weight: normal;\" id=\"aLinkSort" . $sUUID . "\" mode=\"" . $sSortMode . "\" title=\"Sort Column " . trim($f->name) . ": " . $sSortMode . "\">" . trim($f->name) . "</a>";
							if (trim($sSortField) === trim($f->name))
								$sLinkActive = "<a id=\"aLinkSort" . $sUUID . "\" mode=\"" . $sSortMode . "\" title=\"Sort Column " . trim($f->name) . ": " . $sSortMode . "\">" . trim($f->name) . "</a> " . (trim($sSortMode) === "asc" ? "<i class=\"fa fa-sort\"></i>" : "<i class=\"fa fa-sort\"></i>");
						}
					} else {
						$sLinkActive = "<a style=\"font-weight: normal;\" id=\"aLinkSort" . $sUUID . "\" mode=\"" . $sSortMode . "\" title=\"Sort Column " . trim($f->name) . ": " . $sSortMode . "\">" . trim($f->name) . "</a>";
						if (trim($sSortField) === trim($f->name))
							$sLinkActive = "<a style=\"font-weight: bold;\" id=\"aLinkSort" . $sUUID . "\" mode=\"" . $sSortMode . "\" title=\"Sort Column " . trim($f->name) . ": " . $sSortMode . "\">" . trim($f->name) . "</a> " . (trim($sSortMode) === "asc" ? "<i class=\"fa fa-sort\"></i>" : "<i class=\"fa fa-sort\"></i>");
						$sReturnString .= "<td class=\"cursor-pointer\">" . $sLinkActive . "</td>";
					}
					$i++;
				}
				$sReturnString .= (array_key_exists("sLookupPopup", $sParams) && $sParams['sLookupPopup'] ? "<td class=\"text-center\">Action</td>" : "") . (array_key_exists("sLookupEditDelete", $sParams) && $sParams['sLookupEditDelete'] ? "<td class=\"text-center\">Action</td>" : "") . "</tr>";
				foreach ($rs->result_array() as $row) {
					$sReturnString .= "<tr class=\"cursor-pointer\">";
					$sHiddenField = "";
					foreach ($fields as $f) {
						$sSpan = trim($row[$f->name]);
						if (preg_match($sYMDDateRegex, trim($row[$f->name])))
							$sSpan = date("d-m-Y", strtotime(trim($row[$f->name])));
						else if (preg_match($sYMDHISDateRegex, trim($row[$f->name])))
							$sSpan = date("d-m-Y H:i:s", strtotime(trim($row[$f->name])));
						if ($sFieldIgnore !== NULL) {
							if (!in_array(trim($f->name), $sFieldIgnore)) {
								if (trim($f->name) === trim($sFieldName) && trim($sSearchWhatOriginal) !== "")
									$sSpan = $this->CI->m_core_apps->gf_highlight(array(
										"sHighlightColor" => $sHightlighColor,
										"sHighlightText" => in_array($f->type, array(3, 246, 5)) && trim($sSearchWhatOriginal) !== "" && is_numeric(doubleval(trim($sSearchWhatOriginal))) ? number_format(trim($sSearchWhatOriginal), 0) : trim($sSearchWhatOriginal),
										"sSearchText" => in_array($f->type, array(3, 246, 5)) && trim($sSearchWhatOriginal) !== "" && is_numeric(doubleval(trim($sSearchWhatOriginal))) ? number_format(trim($sSpan), 0) : trim($sSpan)
									));
								else
									$sSpan = (in_array($f->type, array(3, 246, 5)) && is_numeric(trim($sSpan))) ? number_format(trim($sSpan), 0) : trim($sSpan);
								$sReturnString .= "<td class=\"" . (in_array($f->type, array(3, 246, 5)) ? "text-right" : in_array($f->type, array(5)) ? "text-right" : "text-left") . "\">" . trim($sSpan) . "</td>";
							} else
								$sHiddenField .= "<input type=\"hidden\" name=\"" . trim($f->name) . "\" id=\"" . trim($f->name) . "\" value=\"" . trim($row[$f->name]) . "\" />";
						} else {
							if (trim($f->name) === trim($sFieldName) && trim($sSearchWhatOriginal) !== "" && is_numeric(doubleval(trim($sSearchWhatOriginal))))
								$sSpan = $this->CI->m_core_apps->gf_highlight(array(
									"sHighlightColor" => $sHightlighColor,
									"sHighlightText" => in_array($f->type, array(3, 246, 5)) && trim($sSearchWhatOriginal) !== "" && is_numeric(doubleval(trim($sSearchWhatOriginal))) ? number_format(trim($sSearchWhatOriginal), 0) : trim($sSearchWhatOriginal),
									"sSearchText" => in_array($f->type, array(3, 246, 5)) && trim($sSearchWhatOriginal) !== "" && is_numeric(doubleval(trim($sSearchWhatOriginal))) ? number_format(trim($sSpan), 0) : trim($sSpan)
								));
							else
								$sSpan = (in_array($f->type, array(3, 246, 5)) && is_numeric(trim($sSpan))) ? number_format(trim($sSpan), 0) : trim($sSpan);
							$sReturnString .= "<td class=\"" . (in_array($f->type, array(3, 246, 5)) ? "text-right" : in_array($f->type, array(5)) ? "text-right" : "text-left") . "\">" . trim($sSpan) . "</td>";
						}
					}
					if (array_key_exists("sLookupPopup", $sParams)) {
						if ($sParams['sLookupPopup']) //-- Lookup TRUE / FALSE
							$sReturnString .= "<td class=\"text-center\" style=\"vertical-align: middle;\"><input type=\"checkbox\" name=\"chkSelect\" id=\"chkSelect" . $sUUID . "\" /></td>";
					} else if (array_key_exists("sLookupEditDelete", $sParams)) {
						if ($sParams['sLookupEditDelete']) //-- Lookup TRUE / FALSE
							$sReturnString .= "<td style=\"vertical-align: middle; text-align: center\"><a id=\"aLinkEditDelete" . $sUUID . "\" title=\"" . $sCustomActionViewCaption . " This Row\" class=\"" . $sButtonViewClass . "\">" . $sCustomActionViewCaption . "</a></td>";
					}
					$sReturnString .= $sHiddenField . "</tr>";
				}
				$sReturnString .= "</table></div>";
			} else
				$sReturnString .= "<div class=\"col-md-12 col-lg-12 text-center\" style=\"padding: 15px;\"><span class=\"faile-o\"></span> Data Not Found, Please check your search text.<div>";
			$sReturnString .= "</div>";
		}
		//Layout Columnar
		elseif (trim($sParams['sLayout']) === "COL_SYSTEM") {
			$sHiddenField = "";
			if (!array_key_exists("nColGrid", $sParams))
				$sParams['nColGrid'] = 3;
			foreach ($rs->result_array() as $row) {
				$sTitle         = "";
				$sReturnStringX = "<div class=\"" . $COL_FORMAT . "\" id=\"div-panel" . $sUUID . "\"><div class=\"panel panel-default bootcards-file\"><div class=\"panel-body\">";
				//--Content
				foreach ($fields as $f) {
					if ($sFieldIgnore !== NULL) {
						if (!in_array(trim($f->name), $sFieldIgnore)) {
							$sSpan = (intval($f->type) === 5 ? number_format($row[$f->name], $DECIMAL_POINT) : trim($row[$f->name]));
							if (trim($f->name) === trim($sFieldName))
								$sSpan = $this->CI->m_core_apps->gf_highlight(array(
									"sHighlightColor" => $sHightlighColor,
									"sHighlightText" => in_array($f->type, array(3, 246, 5)) && trim($sSearchWhatOriginal) !== "" && is_numeric(doubleval(trim($sSearchWhatOriginal))) ? number_format(trim($sSearchWhatOriginal), 0) : trim($sSearchWhatOriginal),
									"sSearchText" => in_array($f->type, array(3, 246, 5)) && trim($sSearchWhatOriginal) !== "" && is_numeric(doubleval(trim($sSearchWhatOriginal))) ? number_format(trim($sSpan), 0) : trim($sSpan)
								));
							$sReturnStringX .= "<div>" . trim($f->name) . ": <data key=\"" . trim($f->name) . "\">" . trim($sSpan) . "</data></div>";
						} else
							$sReturnStringX .= "<div class=\"hidden\"><data key=\"" . trim($f->name) . "\">" . trim($row[$f->name]) . "</data></div>";
					} else {
						$sSpan = (intval($f->type) === 5 ? number_format($row[$f->name], $DECIMAL_POINT) : trim($row[$f->name]));
						if (trim($f->name) === trim($sFieldName))
							$sSpan = $this->CI->m_core_apps->gf_highlight(array(
								"sHighlightColor" => $sHightlighColor,
								"sHighlightText" => in_array($f->type, array(3, 246, 5)) && trim($sSearchWhatOriginal) !== "" && is_numeric(doubleval(trim($sSearchWhatOriginal))) ? number_format(trim($sSearchWhatOriginal), 0) : trim($sSearchWhatOriginal),
								"sSearchText" => in_array($f->type, array(3, 246, 5)) && trim($sSearchWhatOriginal) !== "" && is_numeric(doubleval(trim($sSearchWhatOriginal))) ? number_format(trim($sSpan), 0) : trim($sSpan)
							));
						$sReturnStringX .= "<div>" . trim($f->name) . ": <data key=\"" . trim($f->name) . "\">" . trim($sSpan) . "</data></div>";
					}

					if (array_key_exists("sInitHeaderFields", $sParams))
						if (in_array(trim($f->name), $sParams['sInitHeaderFields'])) {
							$sTitle .= trim($row[$f->name]) . ", ";
							$sOriginalTitle = $sTitle;
						}
				}
				$sTitle = strlen(substr($sTitle, 0, strlen($sTitle) - 2)) > $MAX_LENGTH_TITLE ? substr(substr($sTitle, 0, strlen($sTitle) - 2), 0, $MAX_LENGTH_TITLE) . "..." : substr($sTitle, 0, strlen($sTitle) - 2);
				//--End Content
				$sReturnStringX .= "</div>";

				if (array_key_exists("sLookupPopup", $sParams)) 
				{
					if ($sParams['sLookupPopup']) 
						$sReturnStringX .= "<div class=\"panel-footer\"><input type=\"checkbox\" name=\"chkSelect\" id=\"chkSelect" . $sUUID . "\" /></div>";
				} 
				else if (array_key_exists("sLookupEditDelete", $sParams)) 
				{
					if ($sParams['sLookupEditDelete']) 
						$sReturnStringX .= "<div class=\"panel-footer\"><button id=\"aLinkEditDelete" . $sUUID . "\" type=\"button\" class=\"btn btn-danger\">Select</button></div>";
				}

				$sReturnStringX .= "</div></div>";
				$sReturnString .= str_replace(array("OOO", "PPP"), array($sTitle, $sOriginalTitle), $sReturnStringX);
			}
			$sReturnString = "<div class=\"row\">" . $sReturnString . "</div>";
		}

		$sReturnArray['htmldata'] = $sReturnString;
		$sHeaderNav								= null;
		$sFieldName 							= NULL;

		foreach ($fields as $fld) {
			if (array_key_exists('sFieldIgnoreOnSearchField', $sParams)) {
				if (!in_array(trim($fld->name), $sParams['sFieldIgnoreOnSearchField']))
					$sFieldName .= "<li><a field-type=\"" . trim($fld->type) . "\" init=\"" . trim($fld->name) . "\">" . trim($fld->name) . "</a></li>";
			} else
				$sFieldName .= "<li><a field-type=\"" . trim($fld->type) . "\" init=\"" . trim($fld->name) . "\">" . trim($fld->name) . "</a></li>";
		}

		$sHeaderNav .= "<div class=\"form-group\"><div class=\"btn-group " . ($showPagingNav ? "hidden" : "") . "\" style=\"margin-bottom: 10px;\"><button type=\"button\" class=\"btn btn-default btn-md\"><span id=\"spanRowPerPage" . $sUUID . "\">" . $nRowPerPage . "</span></button><button type=\"button\" class=\"btn btn-default dropdown-toggle btn-md\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"caret\"></span><span class=\"sr-only\">Toggle Dropdown</span></button><ul id=\"ulRowPerpage" . $sUUID . "\" class=\"dropdown-menu\"><li><a>20</a></li><li><a>50</a></li><li><a>100</a></li></ul></div> <div class=\"btn-group " . ($showPagingNav ? "hidden" : "") . "\" id=\"divSearchBy" . $sUUID . "\" style=\"margin-bottom: 10px;\"><button id=\"cmdOperator1" . $sUUID . "\" type=\"button\" class=\"btn btn-default btn-md\"><span id=\"spanSearchBy" . $sUUID . "\">" . (!array_key_exists("sDefaultFieldSearch", $sParams) ? "<span class=\"fa fa-asterisk\"></span>" : trim($sParams['sDefaultFieldSearch'])) . "</span></button><button id=\"cmdOperator1" . $sUUID . "\" type=\"button\" class=\"btn btn-default dropdown-toggle btn-md\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"caret\"></span><span class=\"sr-only\">Toggle Dropdown</span></button><ul id=\"ulFieldName" . $sUUID . "\" class=\"dropdown-menu scrollable-menu\">" . trim($sFieldName) . "</ul></div>&nbsp;<div class=\"btn-group " . ($showPagingNav ? "hidden" : "") . "\" id=\"divOperator" . $sUUID . "\" style=\"margin-bottom: 10px;\"><button type=\"button\" class=\"btn btn-default btn-md\"><span id=\"spanOperatorBy" . $sUUID . "\"></span></button>&nbsp;<button type=\"button\" class=\"btn btn-default  btn-md dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"caret\"></span><span class=\"sr-only\">Toggle Dropdown</span></button><ul id=\"ulOperator" . $sUUID . "\" class=\"dropdown-menu\"><li><a>Like</a></li><li class=\"divider\"></li><li><a>=</a></li><li><a>>=</a></li><li><a><=</a></li><li class=\"divider\"></li><li><a>></a></li><li><a><</a></li><li class=\"divider\"></li><li><a><></a></li></ul></div><input type=\"hidden\" name=\"hideCurrentPage" . $sUUID . "\" id=\"hideCurrentPage" . $sUUID . "\" value=\"1\" /><div class=\"input-group\"><!--<span class=\"input-group-addon\" id=\"cmdPrevPage" . $sUUID . "\"><i class=\"fa fa-arrow-circle-left\"></i></span><span class=\"input-group-addon\" id=\"cmdNextPage" . $sUUID . "\"><i class=\"fa fa-arrow-circle-right\"></i></span>--><input id=\"txtSearchWhat" . $sUUID . "\" type=\"text\" field-type=\"\" class=\"form-control input-flat\" placeholder=\"Search What...\"><span class=\"input-group-btn\"><button id=\"cmdSearchData" . $sUUID . "\" class=\"btn btn-danger\" type=\"button\"><span class=\"fa fa-search\"></span> Search</button><button type=\"button\" id=\"cmdPrevPage" . $sUUID . "\" class=\"btn btn-default disabled\" disabled><i class=\"fa fa-arrow-circle-left\"></i></button><button type=\"button\" id=\"cmdNextPage" . $sUUID . "\" class=\"btn btn-default " . ($NUM_ROWS < intval($nRowPerPage) ? "disabled" : "") . "\" " . ($NUM_ROWS < intval($nRowPerPage) ? "disabled" : "") . "><i class=\"fa fa-arrow-circle-right\"></i></button><!--<button id=\"cmdDownload" . $sUUID . "\" class=\"btn btn-default\" type=\"button\"><span class=\"fa fa-download\"></span></button>--></span></div><small class=\"form-text text-muted\"><i class=\"fa fa-info\"></i> Add Pipe | between the words to Search with multiple text</small></div>";

		$sHeader .= $sHeaderNav;
		$sDetail .= "<div id=\"div-wrap-grid" . $sUUID . "\"><div id=\"divResultPaging" . $sUUID . "\">" . trim($sReturnArray['htmldata']) . "</div></div>";
		$sHeader .= $sDetail . "</div></div>";

?>
		<script>
			var sMode = nPageActive = nRowPerPage = sFieldType = sUUID = sFieldNameSort = sFieldNameSortMode = null;
			$(function() {
				window.DATA 											= "";
				window.DATAMULTI 									= "";
				window.SEPARATOR 									= "||";
				window.sFieldNameSort 						= $.trim("<?php print $sSortField; ?>");
				window.sFieldNameSortMode 				= $.trim("<?php print $sSortMode; ?>");
				window.sCallBackURLPageEditDelete = $.trim("<?php print $sCallBackURLPageEditDelete; ?>");
				window.sHideFirst 								= $.trim("<?php print $isFirst; ?>");
				window.sFieldDefaultSearch 				= $.trim("<?php print $hideSearchField; ?>");
				window.sLookupMode 								= $.trim("<?php print $sLookupMode; ?>");
				window.sCycleParamKey 						= $.trim("<?php print is_array($sCycleParam) ? implode(',', array_keys($sCycleParam)) : ""; ?>");
				window.sCycleParamVal 						= $.trim("<?php print is_array($sCycleParam) ? implode(',', $sCycleParam) : ""; ?>");
				window.sJSParam 									=	$.trim("<?php print is_array($sJSParam) ? implode(',', $sJSParam) : ""; ?>");
				window.bDebugSQL 									= $.trim("<?php print $bDebugSQL; ?>");
				sUUID 														= $.trim("<?php print trim($sUUID); ?>");
				sFieldName 												= $.trim($("#spanSearchBy" + sUUID).text());
				sOperator 												= $.trim($("#spanOperatorBy" + sUUID).text());
				sFieldType 												= $.trim("<?php print trim($sFieldType); ?>");
				nPageActive 											= "<?php print $nPageActive; ?>";
				nRowPerPage 											= $.trim($("#spanRowPerPage" + sUUID).text());

				gf_bind_view();
				gf_bind_virtual_scroller();

				if ($.trim(window.sHideFirst) === "") {
					if ($.trim(window.sFieldDefaultSearch) === "")
						$("#ulFieldName" + sUUID).find("a:eq(0)").trigger("click");
					else
						$("#ulFieldName" + sUUID).find("a[init='" + window.sFieldDefaultSearch + "']").trigger("click");
				}
				$("#cmdNextPage" + sUUID).unbind("click").on("click", function() {
					var oTable = $("div[id='divResultPaging" + sUUID + "']").find("table");
					var o = parseInt($("#hideCurrentPage" + sUUID).val());
					$("#hideCurrentPage" + sUUID).val(parseInt($("#hideCurrentPage" + sUUID).val()) + 1);
					gf_execute_();
				});
				$("#cmdPrevPage" + sUUID).unbind("click").on("click", function() {
					var oTable = $("div[id='divResultPaging" + sUUID + "']").find("table");
					var o = parseInt($("#hideCurrentPage" + sUUID).val());
					$("#hideCurrentPage" + sUUID).val(parseInt($("#hideCurrentPage" + sUUID).val()) === 1 ? 1 : parseInt($("#hideCurrentPage" + sUUID).val()) - 1);
					gf_execute_();
				});
				$("#cmdDownload" + sUUID).unbind("click").on("click", function() {
					var oTable = $("div[id='divResultPaging" + sUUID + "']").find("table");
					var oColumnName = "";
					oTable.find("tr:eq(0) td").each(function(i, n) {
						oColumnName += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-3 form-group\"><input type=\"checkbox\"/><span style=\"margin-left: 10px;\">" + $(this).text() + "</span></div>";
					});
					oColumnName += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-3 form-group\"><input type=\"checkbox\"/><span style=\"margin-left: 10px;\" class=\"text-red\">Select All</span></div>";
					BootstrapDialog.show({
						title: 'Pick columns source',
						message: "<div class=\"row	\"><div class=\"col-lg-12 col-xs-12 col-sm-12 col-md-12\"></div>" + oColumnName + "</div>",
						type: BootstrapDialog.TYPE_DEFAULT,
						buttons: [{
							cssClass: 'btn btn-default',
							label: 'Download',
							action: function(dialog) {
								var rows = [],
									csvContent = "";
								csvContent = "data:text/csv;charset=utf-8,";
								oTable.find("tr").each(function(i, n) {
									$(this).find("td").each(function(j, m) {
										csvContent += $(this).text() + ",";
									});
									csvContent += "\r\n";
								});
								var encodedUri = encodeURI(csvContent);
								var link = document.createElement("a");
								link.setAttribute("href", encodedUri);
								link.setAttribute("download", sUUID + ".csv");
								document.body.appendChild(link);
								link.click();
								dialog.close();
							}
						}, {
							cssClass: 'btn btn-danger',
							label: 'Close',
							action: function(dialog) {
								dialog.close();
							}
						}]
					});
				});
				$("#txtSearchWhat" + sUUID).focus();
			});

			function gf_bind_virtual_scroller() {
				if ($.trim("<?php print $oVirtualScrollHeight; ?>") !== "570") {
					$("#divResultPaging" + sUUID).slimScroll({
						position: 'right',
						height: "<?php print $oVirtualScrollHeight; ?>" + "px",
						railVisible: false,
						color: '#7f7f7f',
						distance: '0px',
						wheelStep: 5,
						size: '8px',
						allowPageScroll: false,
						disableFadeOut: false,
						alwaysVisible: false
					});
				}
			}

			function gf_bind_view() {
				var sValue = "";
				$("body").find("form[otf='true']").remove();
				var oForm = $("<form id=\"frm-otf" + sUUID + "\" otf=\"true\" style=\"display:none;\" action=\"" + window.sCallBackURLPageEditDelete + "\" method=\"post\"></form>");
				oForm.appendTo("body");
				if ("<?php print trim($sParams['sLayout']); ?>" === "GRID_SYSTEM") {
					$("div[id='divResultPaging" + sUUID + "']").find("a[id='aLinkEditDelete" + sUUID + "']").unbind("click").on("click", function() {
						$(this).parent().parent().find("td").each(function(i, n) {
							sValue = $.trim($(this).text());
							if ($.isNumeric(sValue.replace(/,/g, "").replace(/' '/g, "")))
								sValue = sValue.replace(/,/g, "").replace(/' '/g, "");
							oForm.append("<input type=\"hidden\" name=\"" + $.trim($(this).parent().parent().find("tr:eq(0)").find("td:eq(" + (i) + ")").text()).replace(/ /g, "_") + "\" id=\"hideData\" value=\"" + sValue + "\" />");
						});

						$(this).parent().parent().find("input[type='hidden']").each(function(i, n) {
							sValue = $.trim($(this).val());
							if ($.isNumeric(sValue.replace(/,/g, "").replace(/' '/g, "")))
								sValue = sValue.replace(/,/g, "").replace(/' '/g, "");
							oForm.append("<input type=\"hidden\" name=\"" + $.trim($(this).attr("name")).replace(/ /g, "_") + "\" id=\"hideData\" value=\"" + sValue + "\" />");
						});
						//oForm.submit();
						$.gf_custom_ajax({
							"oForm": oForm,
							"success": function(r) {
								$.gf_loading_hide();
								$("section[class='content']").html(r.oRespond);
							},
							"validate": true,
							"beforeSend": function(r) {
								$("section[class='content']").empty();
								$.gf_loading_show({
									sMessage: "Loading Data..."
								});
							},
							"beforeSendType": "custom",
							"error": function(r) {}
						});
					});
				} else if ("<?php print trim($sParams['sLayout']); ?>" === "COL_SYSTEM") {
					$("div[id='divResultPaging" + sUUID + "']").find("button[id='aLinkEditDelete" + sUUID + "']").unbind("click").on("click", function() {
						$.each($(this).parent().prev().find("data"), function(i, n) {
							sValue = $.trim($(this).html());
							if ($.isNumeric(sValue.replace(/,/g, "").replace(/' '/g, "")))
								sValue = sValue.replace(/,/g, "").replace(/' '/g, "");
							oForm.append("<input type=\"hidden\" name=\"" + $.trim($(this).attr("key")).replace(/ /g, "_") + "\" id=\"hideData\" value=\"" + sValue + "\" />");
						});
						$.each($(this).parent().prev().find("input[type='hidden']"), function(i, n) {
							sValue = $.trim($(this).val());
							if ($.isNumeric(sValue.replace(/,/g, "").replace(/' '/g, "")))
								sValue = sValue.replace(/,/g, "").replace(/' '/g, "");
							oForm.append("<input type=\"hidden\" name=\"" + $.trim($(this).attr("name")).replace(/ /g, "_") + "\" id=\"hideData\" value=\"" + sValue + "\" />");
						});
						//oForm.submit();
						$.gf_custom_ajax({
							"oForm": oForm,
							"success": function(r) {
								$.gf_loading_hide();
								$("section[class='content']").html(r.oRespond);
							},
							"validate": true,
							"beforeSend": function(r) {
								$("section[class='content']").empty();
								$.gf_loading_show({
									sMessage: "Loading Data..."
								});
							},
							"beforeSendType": "custom",
							"error": function(r) {}
						});
					});
				}
				if ($.trim(window.sJSParam) !== "") {
					var jsparam = $.trim(window.sJSParam);
					$.each(jsparam.split(","), function(i, n) {
						eval(n);
					});
				}
				$("#otable" + sUUID).find("tr:gt(0)").unbind("dblclick").on("dblclick", function() {
					$(this).find("td:last a[id='aLinkEditDelete" + sUUID + "']").trigger("click");
				});
				$("a[id='aLinkSort" + sUUID + "']").unbind("click").on("click", function() {
					sFieldNameSort = $(this).text();
					sFieldNameSortMode = $.trim($(this).attr("mode")) === "" || $.trim($(this).attr("mode")) === "desc" ? "asc" : "desc";
					window.sFieldNameSort = sFieldNameSort;
					window.sFieldNameSortMode = sFieldNameSortMode;
					gf_search();
				});
				$("#ulFieldName" + sUUID + " a").unbind("click").on("click", function() {
					sFieldName = $(this).text();
					sFieldType = $(this).attr("field-type");
					$("#ulFieldName" + sUUID + " a").attr("data-mode", "0");
					$("#spanSearchBy" + sUUID).html(sFieldName);

					$pl = "";
					if (parseInt(sFieldType) === 10)
						$pl = "[Date Format: d-m-Y]";
					else if (parseInt(sFieldType) === 12)
						$pl = "[Date Format: d-m-Y H:m:s]";
					$("#txtSearchWhat" + sUUID).removeAttr("contents-data").css("text-align", "left").attr("placeholder", "Please type: " + sFieldName + $pl).focus();
					if ($.inArray(parseInt($(this).attr("field-type")), [3, 546]) == 0)
						$("#txtSearchWhat" + sUUID).attr("contents-data", "numeric");
					$("#txtSearchWhat" + sUUID).css("text-align", "left").select();
					$("#txtSearchWhat" + sUUID).attr("field-type", sFieldType);
					gf_reset_operator(sFieldType);
				});
				$("#ulOperator" + sUUID + " a").unbind("click").on("click", function() {
					sOperator = $(this).text();
					$("#spanOperatorBy" + sUUID).html(sOperator);
					$("#txtSearchWhat" + sUUID).select();
				});
				$("#ulRowPerpage" + sUUID + " a").unbind("click").on("click", function() {
					nRowPerPage = $(this).text();
					$("#spanRowPerPage" + sUUID).html(nRowPerPage);
					if ($.trim(nPageActive) === "")
						$("#spanPage" + sUUID).html("1");
					gf_search();
				});
				$("#cmdSearchData" + sUUID).unbind("click").on("click", function() {
					gf_grab_data();
					if (gf_check_valid_parameter())
						gf_search();
					else {
						d = new BootstrapDialog({
							id: 'modal-begin-import',
							type: BootstrapDialog.TYPE_WARNING,
							title: "Informasi",
							closable: false,
							message: "Incorrect Parameter, Please Enter Numeric Parameter.",
							buttons: [{
								id: 'btn-cmdCancel',
								label: 'Close',
								action: function(dialogRef) {
									dialogRef.close();
								},
								cssClass: 'btn-default',
								icon: 'fa fa-close'
							}],
							onhidden: function() {
								$("#txtSearchWhat" + sUUID).select();
							}
						});
						d.open();
					}
				});
				$("#txtSearchWhat" + sUUID).unbind("keyup").on("keyup", function(e) {
					if (e.keyCode === 13)
						gf_search();
				}).attr("placeholder", $.trim(sFieldName)).focus();
				$("div[id='divResultPaging" + sUUID + "']").find("input[type='checkbox'][id='chkSelect" + sUUID + "']").unbind("click").on("click", function() {
					if (window.sLookupMode !== "" && window.sLookupMode === "single") {
						$("div[id='divResultPaging" + sUUID + "']").find("input[type='checkbox'][id='chkSelect" + sUUID + "']").prop("checked", false);
						if ($(this).prop("checked"))
							$(this).prop("checked", false);
						else
							$(this).prop("checked", true);
					}
					window.DATA = "";
					sOutput = "";
					sOutput1 = "";
					$("div[id='divResultPaging" + sUUID + "']").find("input[type='checkbox'][id='chkSelect" + sUUID + "']").each(function(i, n) {
						if ($(this).prop("checked")) {
							sOutput1 = "";
							var oPanelBody = $(this).parent().prev();
							$.each(oPanelBody.find("data"), function(i, n) {
								sValue = $.trim($(this).html());
								if ($.isNumeric(sValue.replace(/,/g, "").replace(/' '/g, "")))
									sValue = sValue.replace(/,/g, "").replace(/' '/g, "");
								var Key = $.trim($(this).attr("key")).replace(/ /g, "_");
								var Val = sValue;
								sOutput1 += "\"" + Key.replace(/ /g, "_") + "\":\"" + Val.replace(/"/g, '\\"') + "\",";
							});
							$.each(oPanelBody.find("input[type='hidden']"), function(i, n) {
								sValue = $.trim($(this).val());
								if ($.isNumeric(sValue.replace(/,/g, "").replace(/' '/g, "")))
									sValue = sValue.replace(/,/g, "").replace(/' '/g, "");
								var Key = $.trim($(this).attr("key")).replace(/ /g, "_");
								var Val = sValue;
								sOutput1 += "\"" + Key.replace(/ /g, "_") + "\":\"" + Val.replace(/"/g, '\\"') + "\",";
							});	
							sOutput += "{" + sOutput1.substring(0, sOutput1.length - 1) + "},";
						}
					});
					sOutput = sOutput.substring(0, sOutput.length - 1);
					window.DATA = sOutput;
				});
				$("#otable" + sUUID).find("tr td input[type='checkbox'][id='chkSelect" + sUUID + "']").unbind("click").on("click", function() {
					if (window.sLookupMode !== "" && window.sLookupMode === "single") {
						$("#otable" + sUUID).find("input[type='checkbox'][id='chkSelect" + sUUID + "']").prop("checked", false);
						if ($(this).prop("checked"))
							$(this).prop("checked", false);
						else
							$(this).prop("checked", true);
					}
					window.DATA = "";
					sOutput = "";
					sOutput1 = "";
					$("#otable" + sUUID).find("input[type='checkbox'][id='chkSelect" + sUUID + "']").each(function(i, n) {
						if ($(this).prop("checked")) {
							sOutput1 = "";
							var oTR = $(this).parent().parent();
							oTR.find("td").each(function(i, n) {
								//-- Balikan JSON
								var Key = $("#otable" + sUUID).find("tr:eq(0) td:eq(" + i + ")").text();
								var Val = $(this).text();
								sOutput1 += "\"" + Key.replace(/ /g, "_") + "\":\"" + Val.replace(/"/g, '\\"') + "\",";
							});
							$(this).parent().parent().find("input[type='hidden']").each(function(i, n) {
								//-- Balikan JSON
								var Key = $(this).attr("name");
								var Val = $(this).val();
								sOutput1 += "\"" + Key.replace(/ /g, "_") + "\":\"" + Val.replace(/"/g, '\\"') + "\",";
							});
							sOutput += "{" + sOutput1.substring(0, sOutput1.length - 1) + "},";
						}
					});
					sOutput = sOutput.substring(0, sOutput.length - 1);
					window.DATA = sOutput;
				});
			}

			function gf_grab_data() {
				nRowPerPage = $.trim($("#spanRowPerPage" + sUUID).text());
				nPageActive = $.trim($("#spanPage" + sUUID).text());
				sOperator = $.trim($("#spanOperatorBy" + sUUID).text());
				sFieldName = $.trim($("#spanSearchBy" + sUUID).text());
			}

			function gf_reset_operator(e) {
				var sMode = e;
				sFieldType = sMode;
				if (parseInt(sMode) === 5 || parseInt(sMode) === 3 || parseInt(sMode) === 546) // Int, Double, Float
				{
					$("#ulOperator" + sUUID).empty().append("<li><a>=</a></li><li><a>>=</a></li><li><a><=</a></li><li class=\"divider\"></li><li><a>></a></li><li><a><</a></li><li class=\"divider\"></li><li><a><></a></li>");
					$("#spanOperatorBy" + sUUID).html("=");
					sOperator = "=";
				} else if (parseInt(sMode) === 253 || parseInt(sMode) === 54 || parseInt(sMode) === -9) // Char, Varchar
				{
					$("#ulOperator" + sUUID).empty().append("<li><a>Like</a></li><li class=\"divider\"></li><li><a>=</a></li>");
					$("#spanOperatorBy" + sUUID).html("Like");
					sOperator = "Like";
				} else if (parseInt(sMode) === 10 || parseInt(sMode) === 12) // Date Time
				{
					$("#ulOperator" + sUUID).empty().append("<li><a>=</a></li><li><a>>=</a></li><li><a><=</a></li><li class=\"divider\"></li><li><a>></a></li><li><a><</a></li><li class=\"divider\"></li><li><a><></a></li>");
					$("#spanOperatorBy" + sUUID).html("=");
					sOperator = "=";
				}
				$("#ulOperator" + sUUID + " a").unbind("click").on("click", function() {
					sOperator = $(this).text();
					$("#spanOperatorBy" + sUUID).html(sOperator);
					$("#txtSearchWhat" + sUUID).select();
				});
			}

			function gf_search() {
				if (parseInt($("#txtSearchWhat" + sUUID).attr("field-type")) === 10 || parseInt($("#txtSearchWhat" + sUUID).attr("field-type")) === 12) // Date harus valid dmy
				{
					if (!gf_validate_date($.trim($("#txtSearchWhat" + sUUID).val()))) {
						$("#txtSearchWhat" + sUUID).select();
						return false;
					}
					$("#hideCurrentPage" + sUUID).val("1");
					gf_execute_();
				} else {
					$("#hideCurrentPage" + sUUID).val("1");
					gf_execute_();
				}
			}

			function gf_check_valid_parameter() {
				var bReturn = true,
					sFieldName = null,
					sFieldType = null;
				$("#ulFieldName" + sUUID + " a").each(function(i, n) {
					sFieldName = $.trim($(this).text());
					sFieldType = $.trim($(this).attr("field-type"));
					if (sFieldName === $.trim($("#spanSearchBy" + sUUID).text())) {
						if (parseInt($.inArray($.trim(sFieldType), ["int", "numeric", "money"])) == 0) // "int", "numeric", "money"
						{
							if (!$.isNumeric($.trim($("#txtSearchWhat" + sUUID).val())))
								bReturn = false;
						}
					}
				});
				return bReturn;
			}

			function gf_validate_date(s) {
				var errorMessage = "";
				if (s) {
					//-- Date with time
					var xsplitComponents = $.trim(s).split(' ');
					//alert(xsplitComponents.length)
					if (xsplitComponents.length === 2) {
						//-- Date
						splitComponents = $.trim(xsplitComponents[0]).split('-');
						if ($.trim(splitComponents[0]).length !== 2)
							return false;
						if ($.trim(splitComponents[1]).length !== 2)
							return false;
						if ($.trim(splitComponents[2]).length !== 4)
							return false;
						var day = parseInt(splitComponents[0]);
						var month = parseInt(splitComponents[1]);
						var year = parseInt(splitComponents[2]);
						if (isNaN(day) || isNaN(month) || isNaN(year))
							return false;
						if (day <= 0 || month <= 0 || year <= 0)
							return false;
						if (month > 12)
							return false;
						// assuming no leap year by default
						var daysPerMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
						if (year % 4 == 0)
							daysPerMonth[1] = 29;
						if (day > daysPerMonth[month - 1])
							return false;
						//-- Time
						splitComponents = $.trim(xsplitComponents[1]).split(':');
						if ($.trim(splitComponents[0]).length !== 2)
							return false;
						if ($.trim(splitComponents[1]).length !== 2)
							return false;
						if ($.trim(splitComponents[2]).length !== 2)
							return false;
						var h = parseInt(splitComponents[0]);
						var m = parseInt(splitComponents[1]);
						var s = parseInt(splitComponents[2]);
						if (isNaN(day) || isNaN(month) || isNaN(year))
							return false;
						if (h <= 0 || m <= 0 || s <= 0)
							return false;
						if (h > 25 || m > 61 || s > 61)
							return false;
					}
					//-- Date Only
					if (xsplitComponents.length === 1) {
						var splitComponents = $.trim(s).split('-');
						if (splitComponents.length > 0) {
							if ($.trim(splitComponents[0]).length !== 2)
								return false;
							if ($.trim(splitComponents[1]).length !== 2)
								return false;
							if ($.trim(splitComponents[2]).length !== 4)
								return false;
							var day = parseInt(splitComponents[0]);
							var month = parseInt(splitComponents[1]);
							var year = parseInt(splitComponents[2]);
							if (isNaN(day) || isNaN(month) || isNaN(year))
								return false;
							if (day <= 0 || month <= 0 || year <= 0)
								return false;
							if (month > 12)
								return false;
							// assuming no leap year by default
							var daysPerMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
							if (year % 4 == 0) {
								// current year is a leap year
								daysPerMonth[1] = 29;
							}
							if (day > daysPerMonth[month - 1])
								return false;
						}
					}
				}
				return true;
			}

			function gf_execute_() {
				gf_grab_data();
				var oForm = $.gf_create_form({
					"action": "<?php print $sParams['sCallBackURLPaging']; ?>"
				});
				oForm.append("<input type=\"hidden\" name=\"hideFieldName\" id=\"hideFieldName\" value=\"" + $.trim(sFieldName) + "\" /><input type=\"hidden\" name=\"hideOperator\" id=\"hideOperator\" value=\"" + $.trim(sOperator) + "\" /><input type=\"hidden\" name=\"hideSearchWhat\" id=\"hideSearchWhat\" value=\"" + $("#txtSearchWhat" + sUUID).val().replace(/'/g, "''").replace(/' '/g, "").replace(/\\/g, "\\\\") + "\" /><input type=\"hidden\" name=\"hidePage\" id=\"hidePage\" value=\"" + parseInt($("#hideCurrentPage" + sUUID).val()) + "\" /><input type=\"hidden\" name=\"hideRowPage\" id=\"hideRowPage\" value=\"" + nRowPerPage + "\" /><input type=\"hidden\" name=\"hideFirst\" id=\"hideFirst\" value=\"true\" /><input type=\"hidden\" name=\"hideFieldType\" id=\"hideFieldType\" value=\"" + sFieldType + "\" /><input type=\"hidden\" name=\"hideFieldSort\" id=\"hideFieldSort\" value=\"" + window.sFieldNameSort + "\" /><input type=\"hidden\" name=\"hideFieldSortMode\" id=\"hideFieldSortMode\" value=\"" + window.sFieldNameSortMode + "\" /><input type=\"hidden\" name=\"hideUUID\" id=\"hideUUID\" value=\"" + sUUID + "\" /><input type=\"hidden\" name=\"hideDebugSQL\" id=\"hideDebugSQL\" value=\"<?php print base64_encode(base64_encode($hideSQL)); ?>\" />");

				if ($.trim(window.sCycleParamKey) !== "") {
					$.each($.trim(window.sCycleParamKey).split(","), function(i, n) {
						var oVal = window.sCycleParamVal.split(",");
						oForm.append("<input type=\"hidden\" name=\"" + n + "\" id=\"" + n + "\" value=\"" + oVal[i] + "\" />");
					});
				}
				$.gf_custom_ajax({
					"oForm": oForm,
					"success": function(r) {
						$.gf_loading_hide();
						$("div[id='divResultPaging" + sUUID + "']").removeAttr("style").empty().html(r.oRespond);
						nPageActive = $(this).text();
						gf_bind_view();

						var oTable = $("div[id='divResultPaging" + sUUID + "']").find("table");

						if ($.trim("<?php print trim($sParams['sLayout']); ?>") === "GRID_SYSTEM") {
							if (oTable.find("tr:visible").length === 1) {
								$("#cmdNextPage" + sUUID).addClass("disabled").prop("disabled", true);
								$("#cmdPrevPage" + sUUID).removeClass("disabled").prop("disabled", false);
							} else if (oTable.find("tr:visible").length > 0) {
								$("#cmdPrevPage" + sUUID).removeClass("disabled").prop("disabled", false);
								$("#cmdNextPage" + sUUID).removeClass("disabled").prop("disabled", false);
							}
						}

						if ($.trim("<?php print trim($sParams['sLayout']); ?>") === "COL_SYSTEM") {
							if ($("div[id='divResultPaging" + sUUID + "']").find("div[class='panel-heading']:visible").length === 0) {
								$("#cmdNextPage" + sUUID).addClass("disabled").prop("disabled", true);
								$("#cmdPrevPage" + sUUID).removeClass("disabled").prop("disabled", false);
							} else if ($("div[id='divResultPaging" + sUUID + "']").find("div[class='panel-heading']:visible").length > 0) {
								$("#cmdPrevPage" + sUUID).removeClass("disabled").prop("disabled", false);
								$("#cmdNextPage" + sUUID).removeClass("disabled").prop("disabled", false);
							}
						}

						if (parseInt($("#hideCurrentPage" + sUUID).val()) === 1) {
							$("#cmdNextPage" + sUUID).removeClass("disabled").prop("disabled", false);
							$("#cmdPrevPage" + sUUID).addClass("disabled").prop("disabled", true);
						}

						$("#txtSearchWhat" + sUUID).select().focus();
					},
					"validate": true,
					"beforeSend": function(r) {
						var oBlurSize = "1px";
						//$("div[id='divResultPaging" + sUUID + "']").empty().html("<div class=\"text-center\">"+$.gf_spinner() + "Loading Data...<br /><br /><br /><br /><br /></div>");
						//$("div[id='divResultPaging" + sUUID + "']").empty();
						$.gf_loading_show({
							sMessage: "Loading Data..."
						});
						//$("div[id='divResultPaging" + sUUID + "']").empty().html("<div class=\"text-center\">Loading...</div>");
						//$("div[id='divResultPaging" + sUUID + "']").css({
						//	"-webkit-filter": "blur(" + oBlurSize + ")",
						//	"filter": "blur(" + oBlurSize + ")"
						//});
					},
					"beforeSendType": "custom",
					"error": function(r) {}
				});
			}
		</script>
<?php
		$sReturn = $sHeader;
		if (trim($this->CI->input->post('hideFirst')) === "true")
			$sReturn = $sDetail;
		return $sReturn;
	}
}
?>