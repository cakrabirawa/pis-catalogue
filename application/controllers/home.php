<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class home extends CI_Controller { 
	var $data = null;
	public function __construct() 
	{ 
		parent::__construct(); 
    $this->load->model('book');
  }

  public function index() {
    $data['data_latest'] = $this->book->gf_get_latest_book();
    $this->load->view('frontend/home', $data);
  }
}
