<?php 
class book extends CI_Model 
{ 
	var $sPathCover = null;
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps')); 
		$this->sPathCover = "https://apps.gramedia.id/piscatalogue/";//$this->m_core_apps->gf_read_config_apps(array('PATH_COVER'));
	}

  function gf_get_latest_book($sISBN=null) {
    $sql = "call sp_query('select a.*, concat(''".$this->sPathCover."cover'', ''/'', a.sIdNaskah, ''/thumbnail/'', a.sFileName) as sNewPathCoverThumbnail, concat(''".$this->sPathCover."cover'', ''/'', a.sIdNaskah, ''/original/'', a.sFileName) as sNewPathCoverOriginal, b.nCount as nViews from tm_pisc_book a left join tx_pisc_view_count b on b.sISBN = a.sISBN where a.sPathCover is not null ";
		if($sISBN !== null) {
			$sql .= " and a.sISBN = ''".trim($sISBN)."''";
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
		$row = $this->db->query("call sp_query('select a.nCount as nViews from tx_pisc_view_count a where a.sISBN = ''".trim($sISBN)."'' ');")->row_array();
		return json_encode($row);
	}

	function gf_related_book_by_category($sISBN) {
		$sql = "call sp_query('select a.*, concat(''".$this->sPathCover."cover'', ''/'', a.sIdNaskah, ''/original/'', a.sFileName) as sNewPathCoverOriginal, concat(''".$this->sPathCover."cover'', ''/'', a.sIdNaskah, ''/thumbnail/'', a.sFileName) as sNewPathCoverThumbnail, b.nCount as nViews from tm_pisc_book a left join tx_pisc_view_count b on b.sISBN = a.sISBN where a.sKategorisasi in (select p.sKategorisasi from tm_pisc_book p where p.sISBN = ''".trim($sISBN)."'') and sPathCover is not null ORDER BY RAND() limit 4');";
		return json_encode($this->db->query($sql)->result_array());
	}

	function gf_related_book_by_sto($sISBN) {
		$sql = "call sp_query('select a.*, concat(''".$this->sPathCover."cover'', ''/'', a.sIdNaskah, ''/original/'', a.sFileName) as sNewPathCoverOriginal, concat(''".$this->sPathCover."cover'', ''/'', a.sIdNaskah, ''/thumbnail/'', a.sFileName) as sNewPathCoverThumbnail, b.nCount as nViews from tm_pisc_book a left join tx_pisc_view_count b on b.sISBN = a.sISBN where a.dTglSTO in (select p.dTglSTO from tm_pisc_book p where p.sISBN = ''".trim($sISBN)."'') and sPathCover is not null ORDER BY RAND() limit 4');";
		return json_encode($this->db->query($sql)->result_array());
	}

	function gf_this_week_sto_carousel() {
		$sql = "call sp_query('select a.*, concat(''".$this->sPathCover."cover'', ''/'', a.sIdNaskah, ''/original/'', a.sFileName) as sNewPathCoverOriginal, concat(''".$this->sPathCover."cover'', ''/'', a.sIdNaskah, ''/thumbnail/'', a.sFileName) as sNewPathCoverThumbnail, str_to_date(a.dTglSTO, ''%d-%M-%Y'') as dTglSTOX, b.nCount as nViews from tm_pisc_book a left join tx_pisc_view_count b on b.sISBN = a.sISBN where /*YEARWEEK(str_to_date(a.dTglSTO, ''%d-%M-%Y''), 1) = YEARWEEK(CURDATE(), 1)  and*/ sPathCover is not null ORDER BY RAND() limit 6');";
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

	function gf_search($sParams=null) {
		$sql = "call sp_query('select a.*, concat(''".$this->sPathCover."cover'', ''/'', a.sIdNaskah, ''/original/'', a.sFileName) as sNewPathCoverOriginal, concat(''".$this->sPathCover."cover'', ''/'', a.sIdNaskah, ''/thumbnail/'', a.sFileName) as sNewPathCoverThumbnail, b.nCount as nViews from tm_pisc_book a left join tx_pisc_view_count b on b.sISBN = a.sISBN where a.sJudulPerubahan like ''%".str_replace("'", "`", urldecode(trim($sParams)))."%'' and (a.sISBN is not null and trim(a.sISBN) <> '''' and trim(a.sISBN) <> ''-'') ');";
		//--------------------------------------------------------
		$sqlx = "call sp_query('insert into tx_pisc_search_keyword (sKeywordName, nUserId_fk, sRealName, dKeywordSearchDate) values (''". urldecode(trim($sParams))."'', ".trim($this->session->userdata('nUserId')).", ''".trim($this->session->userdata('sRealName'))."'', CURRENT_TIMESTAMP)');";
		//--------------------------------------------------------
		$this->db->trans_begin(); 
		$this->db->query($sqlx);
		if ($this->db->trans_status() === FALSE) 
			$this->db->trans_rollback(); 
		else 
			$this->db->trans_commit(); 
		//--------------------------------------------------------
		return json_encode($this->db->query($sql)->result_array());
	}

	function gf_get_keyword() {
		$nLimit = 10;
		$sql = "call sp_query('select a.* from tx_pisc_keyword_count a ORDER BY a.nCount desc limit ".$nLimit."');";
		return json_encode($this->db->query($sql)->result_array());
	}
}