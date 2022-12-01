<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/class libUpload
{
	function gfUpload($oParams=array())
	{
		$sReturn = null;
		$fFileSize = 0;
		$DS = DIRECTORY_SEPARATOR;
		$targetDir = trim($oParams['oPath']);
		if (empty($_FILES) || $_FILES['file']['error'])
		  $sReturn = array("OK"=> 0, "info"=> "Failed to move uploaded file.");
		$chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
		$chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 0;
		$fileName = str_replace(" ", "_", isset($_REQUEST["name"]) ? $_REQUEST["name"] : $_FILES["file"]["name"]);
		
		$fNameOriginal = $fileName;
		$fNameHash = md5($fileName.date('dmYhis'));
		
		$filePath = $targetDir.$fNameOriginal;
		
		$out = @fopen("{$filePath}.part", $chunk == 0 ? "wb" : "ab");
		if($out) 
		{
		  $in = @fopen($_FILES['file']['tmp_name'], "rb");
		  if ($in) 
		  {
		    while ($buff = fread($in, 4096))
		      fwrite($out, $buff);
		  } 
		  else
		    $sReturn = array("OK"=> 0, "info"=> "Failed to open input stream.");
		  @fclose($in);
		  @fclose($out);
		  @unlink($_FILES['file']['tmp_name']);
		} 
		else
		  $sReturn = array("OK"=> 0, "info"=> "Failed to open output stream.");
		if (!$chunks || $chunk == $chunks - 1) 
		{
		  rename("{$filePath}.part", $filePath);
			$fFileSize = filesize($filePath);
		 }
		$sReturn = array("OK"=> 1, "info"=> "Upload successful.", "fnameoriginal"=>trim($fNameOriginal), "fnamehash"=>trim($fNameHash), "ffilesize" => $fFileSize, "fnameclient"=>trim($fileName));
		return json_encode($sReturn);
  }
}