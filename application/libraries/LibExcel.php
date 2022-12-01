<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class libExcel
{	
	public function __construct()
	{
		$this->CI = & get_instance();
	}

	public function gf_create_excel($oParams=array(), $oFormat="xls", $oSep="~")
	{
		$sReturn = NULL;
		$oObjCon = array_key_exists("oObjCon", $oParams) ? $oParams['oObjCon'] : $this->CI->db;
		$oOSQL = trim($oParams['oSQL']);
		$rs = $oObjCon->query($oOSQL);		
		$fields = $rs->field_data(); 
		$sepCol = "";
		$sepRow = "";
		//--
		if(trim($oFormat) === "xls")
		{
			$sepCol = "\t";		
			$sepRow = "\r\n";
		}
		elseif(trim($oFormat) === "csv")
		{
			$sepCol = $oSep;		
			$sepRow = "\r\n";
		}
		//--
		foreach ($fields as $field)
			$sReturn .= trim($field->name).$sepCol;
		$sReturn = substr($sReturn, 0, strlen($sReturn) - 1);
		$sReturn .= $sepRow;
		//--
		foreach($rs->result_array() as $row)
		{
			$oRow = "";
			foreach ($fields as $field)
				$oRow .= trim($row[trim($field->name)]).$sepCol;
			$oRow = substr($oRow, 0, strlen($oRow) - 1);
			$sReturn .= $oRow.$sepRow;
		}
		return $sReturn;
	}
}
