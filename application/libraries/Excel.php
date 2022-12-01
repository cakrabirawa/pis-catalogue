<?php 
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');  
 
require_once APPPATH.DIRECTORY_SEPARATOR."third_party".DIRECTORY_SEPARATOR."PHPExcel-1.8".DIRECTORY_SEPARATOR."PHPExcel.php";
 
class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}