<?php 
class book extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps')); 
	}

  function gf_get_latest_book($sISBN=null) {
    $sql = "call sp_query('select a.*, (select sum(p.nViews) as nViews from tx_pisc_view p where p.sISBN = a.sISBN) as nViews from tm_pisc_book a where a.sPathCover is not null ";
		if($sISBN !== null) {
			$sql .= " and sISBN = ''".trim($sISBN)."''";
			//-- Insert view
		}
		$sql .= " limit ".(($sISBN !== null) ? 1 : 10)."');";
		if($sISBN !== null) {
			$row = $this->db->query($sql)->row_array();
			$sqlx = "call sp_query('insert into tx_pisc_view (sISBN, sNoProduk, nViews, nUserId_fk, sRealName, dDateView) values (''".trim($sISBN)."'', ''".trim($row['sNoProduk'])."'', 1, ".trim($this->session->userdata('nUserId')).", ''".trim($this->session->userdata('sRealName'))."'', CURRENT_TIMESTAMP)');";
			$this->db->trans_begin(); 
			$this->db->query($sqlx);
			if ($this->db->trans_status() === FALSE) 
				$this->db->trans_rollback(); 
			else
				$this->db->trans_commit(); 
		}
    return json_encode($this->db->query($sql)->result_array());
  }

	function gf_get_view_count($sISBN) {
		$row = $this->db->query("call sp_query('select sum(nViews) as nViews from tx_pisc_view where sISBN = ''".trim($sISBN)."'' ');")->row_array();
		return json_encode($row);
	}

	function gf_related_book_by_category($sISBN) {
		$sql = "call sp_query('select * from tm_pisc_book where sKategorisasi in (select sKategorisasi from tm_pisc_book where sISBN = ''".trim($sISBN)."'') limit 4');";
		return json_encode($this->db->query($sql)->result_array());
	}

}