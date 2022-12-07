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
    $this->data['data_latest']                  = $this->book->gf_get_latest_book();
    $this->data['data_sto_this_week_carousel']  = $this->book->gf_this_week_sto_carousel();
    $this->load->view('frontend/home', $this->data);
  }
}
