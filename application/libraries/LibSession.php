<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class libSession
{
	var $CI = null;
	public function __construct()
	{
		$this->CI = & get_instance();		
	}	
	public function gf_check_session()
	{
		return (trim($this->CI->session->userdata('nUserId')) === "");
	}
}