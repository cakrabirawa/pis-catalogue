<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class book_detail extends CI_Controller { 
	var $data = null;
	public function __construct() 
	{ 
		parent::__construct(); 
  }

  public function index() {
    $this->load->view('frontend/book-detail');
  }
}
