<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class libIO
{	
	public function __construct()
	{
		$this->CI = & get_instance();
	}
	function gf_remove_dir($sParam=array())
	{
		$sp         = DIRECTORY_SEPARATOR;
		$path       = trim($sParam['oFullPath']);
		if(!file_exists($path)) return true;
		if(!is_dir($path)) return unlink($path);
		foreach (scandir($path) as $item) 
		{
			if ($item == '.' || $item == '..') continue;
			if (!$this->gf_remove_dir(array("oFullPath" => $path.$sp.$item))) return false;
		}
		if(array_key_exists("oRemoveRoot", $sParam) && $sParam['oRemoveRoot']) rmdir($path);
	}
	function gf_create_file($sParam=array())
	{
		$myfile = fopen(trim($sParam['oFullPath']), "w") or die("Unable to open file!");
		fwrite($myfile, trim($sParam['oStringContent']));
		fclose($myfile);
	}
	function gf_count_files_in_dir($sParam=array())
	{
		$i	 = 0; 
		$path = trim($sParam['oFullPath']);
		if(file_exists($path) && $handle = opendir($path))
		{
			while(($file = readdir($handle)) !== false)
			{
				if(!in_array($file, array('.', '..')) && !is_dir($path.$file))
				{
					$fileattr = pathinfo($path.$file);
					if(array_key_exists("oFileExt", $sParam))
					{
						if(trim($sParam['oFileExt']) === "*")
							$i++;
						elseif(trim($sParam['oFileExt']) === trim($fileattr['extension']))
							$i++;
					}
					else
						$i++;
				}
			}
		}
		return json_encode(array("nFileCount" => $i));
	}	
	function gf_read_file($sParam=array())
	{
		$sReturn = null;
		$myfile = fopen($sParam['path'], "r") or die("Unable to open file!");
		$sReturn = fread($myfile, (Filesize($sParam['path']) === 0 ? 1 : Filesize($sParam['path'])));
		fclose($myfile);
		return $sReturn;
	}
}