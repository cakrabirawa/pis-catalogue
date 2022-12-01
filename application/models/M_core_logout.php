<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_logout extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
	public function gf_logout()
	{
		$this->session->flashdata();
		$this->session->sess_destroy();
	}
}
