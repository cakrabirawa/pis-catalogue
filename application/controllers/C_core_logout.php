<?php
/*
----------------------------------------------------
Apps Framework: Cakrabiarawa Framework
Apps Author: Edwar Rinaldo
----------------------------------------------------
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class c_core_logout extends CI_Controller {	
	public function __construct()
  {
    parent::__construct();   
  }  
	public function index()
	{
		$this->session->flashdata();
		$this->session->set_userdata("nUserId", NULL);
		$user_data = $this->session->all_userdata();
    foreach ($user_data as $key => $value) 
      $this->session->unset_userdata($key);
    $this->session->sess_destroy();
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
    $this->output->set_header("Pragma: no-cache");
    redirect('/', 'refresh');
	}
}
