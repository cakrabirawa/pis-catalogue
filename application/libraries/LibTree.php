<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class LibTree
{
	protected $root = null, $postDir = null, $checkbox = null, $onlyFolders = null, $onlyFiles = null;
	public function __construct()
	{
		$CI = & get_instance();
		$this->root = getcwd();
		$this->postDir = $this->CI->input->post('dir'); 
		$this->postDir = rawurldecode($this->root.(isset($this->postDir) ? $this->postDir : null ));
		$this->checkbox = $this->input->post('multiSelect');
		$this->checkbox = ( isset($this->checkbox) && $this->checkbox == 'true' ) ? "<input type='checkbox' />" : null;
		$this->onlyFolders = $this->input->post('onlyFolders');
		$this->onlyFolders = ( isset($this->onlyFolders) && $this->onlyFolders == 'true' ) ? true : false;
		$this->onlyFiles = $this->input->post('onlyFiles');
		$this->onlyFiles = ( isset($this->onlyFiles) && $this->onlyFiles == 'true' ) ? true : false;
		if( file_exists($postDir) ) {
			$files		= scandir($postDir);
			$returnDir	= substr($postDir, strlen($this->root));
			natcasesort($files);
			if( count($files) > 2 ) { // The 2 accounts for . and ..
				echo "<ul class='jqueryFileTree'>";
				foreach( $files as $file ) {
					$htmlRel	= htmlentities($returnDir . $file);
					$htmlName	= htmlentities($file);
					$ext		= preg_replace('/^.*\./', '', $file);
					if( file_exists($postDir . $file) && $file != '.' && $file != '..' ) {
						if( is_dir($postDir . $file) && (!$onlyFiles || $onlyFolders) )
							echo "<li class='directory collapsed'>{$checkbox}<a rel='" .$htmlRel. "/'>" . $htmlName . "</a></li>";
						else if (!$onlyFolders || $onlyFiles)
							echo "<li class='file ext_{$ext}'>{$checkbox}<a rel='" . $htmlRel . "'>" . $htmlName . "</a></li>";
					}
				}
				echo "</ul>";
			}
		}
	}
}
?>