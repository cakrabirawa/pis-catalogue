<?php 
class book extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps')); 
	} 
  function gf_get_latest_book() {
    $sql = "call sp_query('select * from tm_pisc_book limit 5')";
    return json_encode($this->db->query($sql)->result_array());
  }
}