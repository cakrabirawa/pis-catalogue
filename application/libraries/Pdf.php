<?php 
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tcpdf.6.2.13'.DIRECTORY_SEPARATOR.'tcpdf.php';
class Pdf extends TCPDF
{
  function __construct()
  {
    parent::__construct();
  }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */