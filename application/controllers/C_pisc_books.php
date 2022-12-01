<?php 
/*
------------------------------
Menu Name: Books
File Name: C_pisc_books.php
File Path: D:\projects\php\piscatalogue\application\controllers\C_pisc_books.php
Create Date Time: 2022-12-01 14:11:26
------------------------------
*/
defined('BASEPATH') OR exit('No direct script access allowed');
class c_pisc_books extends CI_Controller { 
	var $data    = null;
	var $nUnitId = null;
	public function __construct() 
	{ 
		parent::__construct(); 
		$a = new libSession(); 
		if($a->gf_check_session()) 
			redirect("c_core_login"); 
		//----------------------------------------------------------------------------------------------------------
		$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_pism_books')); 
		$this->load->library(array('libPaging'));
		//----------------------------------------------------------------------------------------------------------
		$this->data['o_page']       = 'backend/v_pisv_books'; 
		$this->data['o_page_title'] = 'Books'; 
		$this->data['o_page_desc']  = 'Maintenance Books'; 
		$this->data['o_data']       = null; 
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_pisc_books"));
		$this->nUnitId 							= $this->session->userdata('nUnitId_fk');
	} 
	public function index() 
	{ 
		$this->data['o_mode'] = "I"; 
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	public function gf_exec() 
	{ 
		$this->data['o_mode'] = ""; 
		$this->data['o_data'] = $this->m_pism_books->gf_load_data(); 
		$this->load->view($this->data['o_page'] , $this->data); 
	} 
	function gf_transact() 
	{ 
		print $this->m_pism_books->gf_transact(); 
	} 
	function gf_load_data() 
	{ 
		$c = new libPaging(); 
		$sParam = array( "sSQL" => "select sNoProduk as `Id Produk`, sJudulPerubahan as `Judul Terbit`, sDetailPengarang as `Pengarang Asli`, sNamaPengarangCover as `Pengarang Cover`, sISBNLengkap as `ISBN`, sKertasIsi as `Kertas`, sNamaTipeKertasProduk as `Tipe Kertas`, sNamaJenisCetakanCover as `Cover`, sNamaSpekMateri as `Materi`, str_to_date(dTglSTO, '%d-%M-%Y') as `Tgl STO`, sKategorisasiToko as `Kategori Toko`, sKategorisasi as `Kategori Internal` from tm_pisc_book",
										 "sTitleHeader" => "Title Sample",
										 "sCallBackURLPaging"	 => site_url()."c_pisc_books/gf_load_data",
										 "sCallBackURLPageEditDelete" => site_url()."c_pisc_books/gf_exec",
										 "sLookupEditDelete" => false,
										 "bDebugSQL" => false,
										 "sLayout" => ($this->m_core_apps->gf_is_mobile() ? "COL_SYSTEM" : "GRID_SYSTEM"),
										 "sInitHeaderFields" => array("Judul Terbit"),
										 "sDefaultFieldSearch"  => "Judul Terbit",
										 "sTheme" => "default"); 
		$p = $c->gf_render_paging_data($sParam); 
		print $p; 
	} 
}