<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class libORM
{	
	public function __construct()
	{
		$this->CI = & get_instance();
	}

	function gf_orm_generate_db_table($oParams=array())
	{
		$sql = null;
		if(array_key_exists("orm_upgrade_mode", $oParams))
		{
			if($oParams['orm_table_name'])
				$sql .= "drop table if exists `".trim($oParams['orm_table_name'])."`;";	
		}
		$sql .= "create table ";
		$sql .= "`".trim($oParams['orm_table_name'])."`";
		$sql .= " ( ";
		foreach($oParams['orm_fields'] as $row)
			$sql .= " `".trim($row['orm_fields_name'])."` ".trim($row['orm_fields_type'])."(".trim($row['orm_fields_length']).") ".(($row['orm_fields_pk']) ? "NOT NULL" : "").", ";
		$sql = substr(trim($sql), 0, trim($sql) - 1);
		$sql .= " , `sUUID` varchar(32) NOT NULL, sCreateBy VARCHAR(50), dCreateOn DATETIME, sLastEditBy VARCHAR(50), dLastEditOn DATETIME, sDeleteBy VARCHAR(50), dDeleteOn DATETIME, sStatusDelete CHAR(1) ";
		$sql .= " , PRIMARY KEY (`sUUID`) ";
		$sql .= " ); ";
		$r = $this->CI->db->query($sql);	
		return json_encode(array("oResultORM" => $r, "oResultView" => $this->gf_generate_view()));
	}

	function gf_generate_view()
	{
		$s = null;
		$s = "<?php ";
		$s .= "print 'asd';";
		$s .= "?>";
		return $s;
	}
}