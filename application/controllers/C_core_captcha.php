<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_captcha extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library(array('libCaptcha'));
	}
	function gf_generate_captcha()
	{
		$a = new libCaptcha();
		$a->CreateImage();
	}
	function gf_get_captcha_session()
	{
		print $this->session->userdata('captcha');
	}
}
