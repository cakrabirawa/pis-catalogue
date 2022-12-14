<?php 
class book extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps')); 
	}

  function gf_get_latest_book($sISBN=null) {
    $sql = "call sp_query('select a.*, concat(''".site_url()."cover'', ''/'', a.sIdNaskah, ''/thumbnail/'', a.sFileName) as sNewPathCoverThumbnail, concat(''".site_url()."cover'', ''/'', a.sIdNaskah, ''/original/'', a.sFileName) as sNewPathCoverOriginal, (select sum(p.nViews) as nViews from tx_pisc_view p where p.sISBN = a.sISBN) as nViews from tm_pisc_book a where a.sPathCover is not null ";
		if($sISBN !== null) {
			$sql .= " and sISBN = ''".trim($sISBN)."''";
			//-- Insert view
		}
		$sql .= " ORDER BY RAND() limit ".(($sISBN !== null) ? 1 : 10)."');";
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
		$sql = "call sp_query('select a.*, concat(''".site_url()."cover'', ''/'', a.sIdNaskah, ''/original/'', a.sFileName) as sNewPathCoverOriginal, concat(''".site_url()."cover'', ''/'', a.sIdNaskah, ''/thumbnail/'', a.sFileName) as sNewPathCoverThumbnail, (select sum(p.nViews) as nViews from tx_pisc_view p where p.sISBN = a.sISBN) as nViews from tm_pisc_book a where a.sKategorisasi in (select p.sKategorisasi from tm_pisc_book p where p.sISBN = ''".trim($sISBN)."'') and sPathCover is not null ORDER BY RAND() limit 4');";
		return json_encode($this->db->query($sql)->result_array());
	}

	function gf_related_book_by_sto($sISBN) {
		$sql = "call sp_query('select a.*, concat(''".site_url()."cover'', ''/'', a.sIdNaskah, ''/original/'', a.sFileName) as sNewPathCoverOriginal, concat(''".site_url()."cover'', ''/'', a.sIdNaskah, ''/thumbnail/'', a.sFileName) as sNewPathCoverThumbnail, (select sum(p.nViews) as nViews from tx_pisc_view p where p.sISBN = a.sISBN) as nViews from tm_pisc_book a where a.dTglSTO in (select p.dTglSTO from tm_pisc_book p where p.sISBN = ''".trim($sISBN)."'') and sPathCover is not null ORDER BY RAND() limit 4');";
		return json_encode($this->db->query($sql)->result_array());
	}

	function gf_this_week_sto_carousel() {
		$sql = "call sp_query('select a.*, concat(''".site_url()."cover'', ''/'', a.sIdNaskah, ''/original/'', a.sFileName) as sNewPathCoverOriginal, concat(''".site_url()."cover'', ''/'', a.sIdNaskah, ''/thumbnail/'', a.sFileName) as sNewPathCoverThumbnail, str_to_date(a.dTglSTO, ''%d-%M-%Y'') as dTglSTOX, (select sum(p.nViews) as nViews from tx_pisc_view p where p.sISBN = a.sISBN) as nViews from tm_pisc_book a where /*YEARWEEK(str_to_date(a.dTglSTO, ''%d-%M-%Y''), 1) = YEARWEEK(CURDATE(), 1)  and*/ sPathCover is not null ORDER BY RAND() limit 6');";
		return json_encode($this->db->query($sql)->result_array());
	}

	function gf_load_cover_by_suuid($sUUID) {
		$DS = DIRECTORY_SEPARATOR;
		$sql = "call sp_query('select sFileName, sIdNaskah from tm_pisc_book where sUUID = ''".trim($sUUID)."'' ');";
		$row = $this->db->query($sql)->row_array();
    $sPath = getcwd().$DS."cover".$DS.$row['sIdNaskah'].$DS."original".$DS.$row['sFileName'];
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="'.basename($sPath).'"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($sPath));
		flush(); 
		readfile($sPath);
		die();
  }
}