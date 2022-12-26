<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class search extends CI_Controller { 
	var $data = null;
	public function __construct() 
	{ 
		parent::__construct(); 
    $a = new libSession();
		if ($a->gf_check_session())
			redirect("c_core_login");
		else
      $this->load->model('book');
  }

  public function index() {
    $this->data['data_latest']                  = $this->book->gf_get_latest_book();
    $this->data['data_sto_this_week_carousel']  = $this->book->gf_this_week_sto_carousel();
    $this->data['data_keyword']                 = $this->book->gf_get_keyword();
    $this->data['data_search']                  = null;
    $this->load->view('frontend/search', $this->data);   
  }

  function gf_search($sParams=null) {
    $this->data['data_latest']                  = $this->book->gf_get_latest_book();
    $this->data['data_sto_this_week_carousel']  = $this->book->gf_this_week_sto_carousel();
    $this->data['data_search']                  = trim($sParams);
    $this->data['data_keyword']                 = $this->book->gf_get_keyword();
    $this->data['data_search_list']             = $this->book->gf_search($sParams);
    $this->load->view('frontend/search', $this->data);
  }
}
