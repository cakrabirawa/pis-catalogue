<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class book_detail extends CI_Controller { 
	var $data = null;
	public function __construct() 
	{ 
		parent::__construct(); 
    $this->load->model('book');
  }

  public function gf_view_book_detail($sISBN) {
    $data['data']                 = $this->book->gf_get_latest_book($sISBN);
    $data['view']                 = $this->book->gf_get_view_count($sISBN);
    $data['related_by_category']  = $this->book->gf_related_book_by_category($sISBN);
    $data['related_by_sto']       = $this->book->gf_related_book_by_sto($sISBN);
    $this->load->view('frontend/book-detail', $data);
  }
}
