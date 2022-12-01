<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'phpmailer5.2.10'.DIRECTORY_SEPARATOR.'class.phpmailer.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'phpmailer5.2.10'.DIRECTORY_SEPARATOR.'class.pop3.php';
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'phpmailer5.2.10'.DIRECTORY_SEPARATOR.'class.smtp.php';

class libMail extends PHPMailer
{
  function __construct()
  {
    parent::__construct();
  }
}

/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */