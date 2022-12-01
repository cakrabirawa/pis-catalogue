<?php 
class m_prepayment_custom_rpt extends CI_Model 
{ 
	public function __construct() 
	{ 
		parent::__construct(); 
		$this->load->model(array('m_core_apps')); 
	}
	function gf_report_custom_report($oParams=array())
	{
		$oFontDir = $this->config->item('ConFontsReportDir');
		$this->load->library('pdf');
		//print_r($oParams);
		//$this->pdf = new pdf();
		$this->pdf->setPrintHeader(false);
		$this->pdf->setPrintFooter(false);
		$this->pdf->SetCreator("Edwar Rinaldo Report Engine V 1.0");
		$this->pdf->SetAuthor('Edwar Rinaldo');
		$this->pdf->SetTitle((array_key_exists('sReportName', $oParams)) ? trim($oParams['sReportName']) : 'Report Engine Name');
		$this->pdf->SetSubject('This Report Was Generate From Report Engine (c) Edwar Rinaldo');	
		$this->pdf->SetMargins(((array_key_exists('nMarginLeft', $oParams)) ? intval($oParams['nMarginLeft']) : 10), (array_key_exists('nMarginTop', $oParams)) ? intval($oParams['nMarginTop']) : 10);
		$oFontName = TCPDF_FONTS::addTTFfont($oFontDir."tahoma.ttf", 'TrueTypeUnicode', '', 96);		
		$this->pdf->SetFont($oFontName, '', (array_key_exists('nFontSize', $oParams)) ? intval($oParams['nFontSize']) : 12, '', true);
		$this->pdf->SetAutoPageBreak(true, 0);		
	  $this->pdf->SetDisplayMode((array_key_exists('nDisplayMode', $oParams)) ? intval($oParams['nDisplayMode']) : 100);
	  $oConfig = $this->m_core_apps->gf_read_config_apps();
	  //-----------------------
	  $SP = DIRECTORY_SEPARATOR;
	  $oFile = date('d.m.Y.H.i.s'); //strtoupper(substr(md5(uniqid()), 0, 5));
	  $oPDFPath = getcwd().$SP."reports".$SP."pdf".$SP;
	  $oWebPath = site_url()."reports/pdf";
	  if(!file_exists($oPDFPath))
	  {
	  	mkdir($oPDFPath);
		  chmod($oPDFPath, 0777);
	  }
	  //-----------------------
	  $oDel = 10;
  	$this->m_core_apps->gf_delete_files_in_directory(array("sPath" => $oPDFPath, "oDel" => $oDel));
	  //-----------------------
	  $SQL = NULL;
	  $sHTML = "<!doctype html>";
		$sNamaPenyusunCustom = $this->input->post('sNamaPenyusunCustom', TRUE);
		$sNamaAtasanCustom = $this->input->post('sNamaAtasanCustom', TRUE);
	  if(trim($oParams['sReportType']) === "Report.Pengajuan.Pre.Payment")
	  {
	  	$nIdTransaksi = trim($oParams['nIdTransaksi']);
	  	$SQL = "call sp_query('select a.nIdPengajuanBS, a.sDeskripsi, c.sNamaKelompokUsaha, a.sNoPenyusun, date_format(a.dTglPenyusun, ''%d/%m/%Y'') as dTglPenyusun, a.sNIK, a.sNamaKaryawan, a.sNamaUnitUsaha, a.sBagian, a.sNamaBank, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, date_format(a.dTglKegiatanAwal, ''%d/%m/%Y'') as dTglKegiatanAwal, date_format(a.dTglKegiatanAkhir, ''%d/%m/%Y'') as dTglKegiatanAkhir, a.sNIKAtasan, a.sNamaAtasan, a.sNamaPenyusun, date_format(a.dTglPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglPenyelesaianPrePayment, a.nIdKelompokUsaha_fk, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.nTotalAmount, a.sTotalAmountTerbilang, d.sNamaUnitUsaha, 

	  	".$this->db->database.".gf_global_function(''GetLastStatusPrePayment'', @unit, a.nIdPengajuanBS, ''PENGAJUAN_PRE_PAYMENT'', null, null, null) as `sLastStatus`,


	  	 e.sNamaKategoriPrePayment, f.sNamaDivisi, g.sNamaDepartemen, h.sNamaPaymentType

	  	from tx_prepayment_pengajuan_pp a inner join tm_prepayment_kelompok_usaha c on c.nIdKelompokUsaha = a.nIdKelompokUsaha_fk inner join tm_prepayment_unit_usaha d on d.nIdUnitUsaha = a.nIdUnitUsaha_fk inner join tm_prepayment_kategori_pre_payment_h e on e.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk inner join tm_prepayment_divisi f on f.nIdDivisi = a.nIdDivisi_fk inner join tm_prepayment_departemen g on g.nIdDepartemen = a.nIdDepartemen_fk inner join tm_prepayment_payment_type h on h.nIdPaymentType = a.nIdPaymentType_fk

	  	where h.nUnitId_fk = @unit and h.sStatusDelete is null and g.nUnitId_fk = @unit and g.sStatusDelete is null and f.nUnitId_fk = @unit and f.sStatusDelete is null and a.nUnitId_fk = @unit and a.sStatusDelete is null and c.nUnitId_fk = @unit and c.sStatusDelete is null and e.nUnitId_fk = @unit and e.sStatusDelete is null and 

	  	/*(select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = @unit and p.sPosting = ''1'' and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) = 0 and (select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = @unit and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) = 0

	  	";
	  	$SQL .= " and*/ a.nIdPengajuanBS = ".trim($nIdTransaksi)." ";
	  	$SQL .= "');";
	  	$SQL = str_replace("@unit", $this->session->userdata('nUnitId_fk'), $SQL);

	  	print $SQL;

	  	$rs = $this->db->query($SQL);
	  	foreach($rs->result_array() as $row)
	  	{
			  $sHTML .= "<table cellpadding=\"2\" style=\"width: 430px; font-size: 9pt;\">";
			  $sHTML .= "<tr><td style=\"font-weight: bold; font-size: 12pt; width: 200px;\" colspan=\"3\">Report Pengajuan Pre Payment</td><td style=\"text-align: right; font-size: 8pt; width: 340x;\">Tgl: ".date('d/M/Y')."</td></tr>";
			  $sHTML .= "</table>";
			  $sHTML .= "<table cellpadding=\"2\" style=\"width: 430px; font-size: 8pt;\">";
			  $sHTML .= "<tr><td style=\"width: 100px;\">No Penyusun</td><td style=\"width: 10px;\">:</td><td style=\"width: 170px;\">".trim($row['sNoPenyusun'])."</td><td style=\"width: 115px;\">Di Bebankan pada Unit Usaha</td><td style=\"width: 10px;\">:</td><td style=\"width: 115px;\">".trim($row['sNamaUnitUsaha'])."</td></tr>";
			  $sHTML .= "<tr><td>Tgl Penyusun</td><td>:</td><td>".trim($row['dTglPenyusun'])."</td><td style=\"width: 115px;\">Divisi Pembebanan</td><td style=\"width: 10px;\">:</td><td>".trim($row['sNamaDivisi'])."</td></tr>";
			  $sHTML .= "<tr><td>NIK</td><td>:</td><td>".trim($row['sNIK'])."</td><td style=\"width: 115px;\">Departemen Pembebanan</td><td style=\"width: 10px;\">:</td><td>".trim($row['sNamaDepartemen'])."</td></tr>";
			  $sHTML .= "<tr><td>Nama</td><td>:</td><td>".trim($row['sNamaKaryawan'])."</td><td style=\"width: 115px;\">Tgl Kegiatan Mulai</td><td style=\"width: 10px;\">:</td><td>".trim($row['dTglKegiatanAwal'])."</td></tr>";
			  $sHTML .= "<tr><td>Kelompok Usaha Pemesan</td><td>:</td><td>".trim($row['sNamaKelompokUsaha'])."</td><td style=\"width: 115px;\">Tgl Kegiatan Selesai</td><td style=\"width: 10px;\">:</td><td>".trim($row['dTglKegiatanAkhir'])."</td></tr>";
			  $sHTML .= "<tr><td>Unit Usaha</td><td>:</td><td>".trim($row['sNamaUnitUsaha'])."</td><td style=\"width: 115px;\">Tgl Penyelesaian Pre Payment</td><td style=\"width: 10px;\">:</td><td>".trim($row['dTglPenyelesaianPrePayment'])."</td></tr>";
			  $sHTML .= "<tr><td>Bagian / Seksi</td><td>:</td><td>".trim($row['sBagian'])."</td><td style=\"width: 115px;\">Cara Bayar</td><td style=\"width: 10px;\">:</td><td>".trim($row['sNamaPaymentType'])."</td></tr>";
			  $sHTML .= "<tr><td>Nama Bank</td><td>:</td><td>".trim($row['sNamaBank'])."</td><td style=\"width: 115px;\">Keterangan</td><td style=\"width: 10px;\">:</td><td>".trim($row['sDeskripsi'])."</td></tr>";
			  $sHTML .= "<tr><td>Cabang Bank</td><td>:</td><td>".trim($row['sCabangBank'])."</td><td style=\"width: 115px;\">Nama TTD Atasan</td><td style=\"width: 10px;\">:</td><td>".trim($row['sNamaAtasan'])." (".trim($row['sNIKAtasan']).")</td></tr>";
			  $sHTML .= "<tr><td>No Rekening</td><td>:</td><td>".trim($row['sNoRekening'])."</td><td style=\"width: 115px;\">Nama TTD Penyusun</td><td style=\"width: 10px;\">:</td><td>".trim($row['sNamaPenyusun'])."</td></tr>";
			  $sHTML .= "<tr><td>Nama Pemilik Rekening</td><td>:</td><td>".trim($row['sAtasNamaRekening'])."</td></tr>";
			  $sHTML .= "<tr><td>Last Status Pre Payment</td><td>:</td><td colspan=\"6\">".trim($row['sLastStatus'])."</td></tr>";
			  $sHTML .= "<tr><td>Kategori Pre Payment</td><td>:</td><td><b>".trim($row['sNamaKategoriPrePayment'])."</b></td></tr>";
			  $sHTML .= "</table>";
			  //---------------------------------------------------
			  $sHTML .= "<p>Komponen Pre Payment (Calculated)</p>";			 
			  $SQL = "call sp_query('select b.sNamaKomponen, a.nIdPengajuanBS_fk, a.nIdKomponen_fk, a.sKeterangan, a.sTipeDataKomponen, a.sAllowSummary, a.nDigit, a.nDecimalPoint, a.sValue, a.nValue, date_format(a.dValue, ''%d/%m/%Y'') as dValue, a.nSeqNo, a.sLabel, a.sSatuan, a.sAllowMultiply, a.nQty, a.nSubTotal from tx_prepayment_pengajuan_pp_komponen a inner join tm_prepayment_komponen_pre_payment b on b.nIdKomponen = a.nIdKomponen_fk where a.nIdPengajuanBS_fk = ".trim($row['nIdPengajuanBS'])." and a.sStatusDelete is null and b.sStatusDelete is null and a.nUnitId_fk = @unit and b.nUnitId_fk = @unit and  a.sTipeDataKomponen = ''N'' ');";
			  $SQL = str_replace("@unit", $this->session->userdata('nUnitId_fk'), $SQL);
		  	$rs1 = $this->db->query($SQL);
	  		$sHTML .= "<table cellpadding=\"2\" style=\"border-bottom: solid 1px #ccc; width: 430px; font-size: 8pt;\">";
				$sHTML .= "<tr style=\"background-color: #ddd;\"><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 20px;\"><b>No</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 200px;\"><b>Komponen</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 80px;\"><b>Satuan</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc;\"><b>Nilai</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 20px;\"><b>Qty</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc;\"><b>Sub Total</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; border-right: solid 1px #ccc; width: 90px;\"><b>Keterangan</b></td></tr>";
				$i = 1;
		  	foreach($rs1->result_array() as $row1)
		  	{
					$sHTML .= "<tr style=\"background-color: ".($i % 2 === 0 ? "#f5f5f5" : "#fff")."\"><td style=\"border-left: solid 1px #ccc; text-align: right;\">".$i."</td><td>".trim($row1['sNamaKomponen'])."</td><td>".trim($row1['sSatuan'])."</td><td style=\"".(trim($row1['sTipeDataKomponen']) === "N" ? "text-align: right;" : "")."\">".(trim($row1['sTipeDataKomponen']) === "N" ? number_format(trim($row1['nValue']), 0) : trim($row1['dValue']))."</td><td style=\"text-align: right;\">".$row1['nQty']."</td><td style=\"".(trim($row1['sTipeDataKomponen']) === "N" ? "text-align: right;" : "")."\">".(trim($row1['sTipeDataKomponen']) === "N" ? number_format(trim($row1['nSubTotal']), 0) : "")."</td><td style=\"border-right: solid 1px #ccc; \">".trim($row1['sKeterangan'])."</td></tr>";
					$i++;
		  	}
		  	$sHTML .= "<tr style=\"background-color: #ffcc99;\"><td style=\"text-align: right; border-left: solid 1px #ccc;\" colspan=\"5\"><b>Grand Total</b></td><td style=\"text-align: right; border-top: solid 1px #ccc;\">".number_format($row['nTotalAmount'])."</td><td style=\"border-right: solid 1px #ccc;\"></td></tr>";
		  	$sHTML .= "<tr><td style=\"border-right: solid 1px #ccc; border-left: solid 1px #ccc; border-top: solid 1px #ccc;\" colspan=\"7\">Terbilang: <b>".($row['sTotalAmountTerbilang'])."</b> Rupiah</td></tr>";
				$sHTML .= "</table>";
			  //---------------------------------------------------
			  $sHTML .= "<p>Komponen Pre Payment (Non Calculated)</p>";			 
			  $SQL = "call sp_query('select b.sNamaKomponen, a.nIdPengajuanBS_fk, a.nIdKomponen_fk, a.sKeterangan, a.sTipeDataKomponen, a.sAllowSummary, a.nDigit, a.nDecimalPoint, a.sValue, a.nValue, date_format(a.dValue, ''%d/%m/%Y'') as dValue, a.nSeqNo, a.sLabel, a.sSatuan, a.sAllowMultiply, a.nQty, a.nSubTotal from tx_prepayment_pengajuan_pp_komponen a inner join tm_prepayment_komponen_pre_payment b on b.nIdKomponen = a.nIdKomponen_fk where a.nIdPengajuanBS_fk = ".trim($row['nIdPengajuanBS'])." and a.sStatusDelete is null and b.sStatusDelete is null and a.nUnitId_fk = @unit and b.nUnitId_fk = @unit and  a.sTipeDataKomponen <> ''N'' ');";
			  $SQL = str_replace("@unit", $this->session->userdata('nUnitId_fk'), $SQL);
		  	$rs1 = $this->db->query($SQL);
	  		$sHTML .= "<table cellpadding=\"2\" style=\"border-bottom: solid 1px #ccc; width: 430px; font-size: 8pt;\">";
				$sHTML .= "<tr style=\"background-color: #ddd;\"><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 20px;\"><b>No</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 200px;\"><b>Komponen</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 80px;\"><b>Satuan</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc;\"><b>Nilai</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; border-right: solid 1px #ccc; width: 147px;\"><b>Keterangan</b></td></tr>";
				$i = 1;
		  	foreach($rs1->result_array() as $row1)
		  	{
					$sHTML .= "<tr style=\"background-color: ".($i % 2 === 0 ? "#f5f5f5" : "#fff")."\"><td style=\"border-left: solid 1px #ccc; text-align: right;\">".$i."</td><td>".trim($row1['sNamaKomponen'])."</td><td>".trim($row1['sSatuan'])."</td>

					<td style=\"".(trim($row1['sTipeDataKomponen']) === "N" ? "text-align: right;" : "")."\">".(trim($row1['sTipeDataKomponen']) === "N" ? number_format(trim($row1['nValue']), 0) : (trim($row1['sTipeDataKomponen']) === "A" ? trim($row1['sValue']) : trim($row1['dValue'])))."</td>



					<td style=\"border-right: solid 1px #ccc; \">".trim($row1['sKeterangan'])."</td></tr>";
					$i++;
		  	}
				$sHTML .= "</table>";
			  //---------------------------------------------------
			}	  
		}
		else if(trim($oParams['sReportType']) === "Report.Pengajuan.Pre.Payment.BS")
	  {
	  	$nIdTransaksi = trim($oParams['nIdTransaksi']);
	  	$SQL = "call sp_query('select a.nIdPengajuanBS, a.sDeskripsi, upper(c.sNamaKelompokUsaha) as sNamaKelompokUsaha, a.sNoPenyusun, date_format(a.dTglPenyusun, ''%d/%m/%Y'') as dTglPenyusun, a.sNIK, upper(a.sNamaKaryawan) as sNamaKaryawan, upper(a.sNamaUnitUsaha) as sNamaUnitUsaha, upper(a.sBagian) as sBagian, a.sNamaBank, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, date_format(a.dTglKegiatanAwal, ''%d/%m/%Y'') as dTglKegiatanAwal, date_format(a.dTglKegiatanAkhir, ''%d/%m/%Y'') as dTglKegiatanAkhir, a.sNIKAtasan, a.sNamaAtasan, a.sNamaPenyusun, date_format(a.dTglPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglPenyelesaianPrePayment, a.nIdKelompokUsaha_fk, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.nTotalAmount, a.sTotalAmountTerbilang, d.sNamaUnitUsaha, 

	  	".$this->db->database.".gf_global_function(''GetLastStatusPrePayment'', @unit, a.nIdPengajuanBS, ''PENGAJUAN_PRE_PAYMENT'', null, null, null) as `sLastStatus`,

	  	 e.sNamaKategoriPrePayment, f.sNamaDivisi, g.sNamaDepartemen, upper(h.sNamaPaymentType) as sNamaPaymentType, upper(d.sNamaUnitUsaha) as sDesc, upper(a.sTotalAmountTerbilang) as sTotalAmountTerbilang, (select group_concat(q.sNamaKomponen SEPARATOR '' - '') from tx_prepayment_pengajuan_pp_komponen p inner join tm_prepayment_komponen_pre_payment q on q.nIdKomponen = p.nIdKomponen_fk and p.sStatusDelete is null and q.sStatusDelete is null and p.nUnitId_fk = @unit and q.nUnitId_fk = @unit and p.nIdPengajuanBS_fk = ".trim($nIdTransaksi)." /*and p.sTipeDataKomponen = ''N'' and p.sAllowSummary = ''1''*/) as sNamaKomponenPrePayment, 

	  	(select group_concat(
	  	(
	  		case when p.sTipeDataKomponen = ''N'' then cast(format(p.nSubTotal, 0) as char) else 
	  			case when p.sTipeDataKomponen = ''A'' then cast(p.sValue as char) else 
  					case when p.sTipeDataKomponen = ''D'' then cast(date_format(p.dValue, ''%d/%m/%Y'') as char) end 
  				end 
	  		end
	  	) 
	  	SEPARATOR '' - '') 

	  	from tx_prepayment_pengajuan_pp_komponen p inner join tm_prepayment_komponen_pre_payment q on q.nIdKomponen = p.nIdKomponen_fk and p.sStatusDelete is null and q.sStatusDelete is null and p.nUnitId_fk = @unit and q.nUnitId_fk = @unit and p.nIdPengajuanBS_fk = ".trim($nIdTransaksi)." /*and p.sTipeDataKomponen = ''N'' and p.sAllowSummary = ''1''*/) as sNamaKomponenPrePaymentRupiah  

	  	from tx_prepayment_pengajuan_pp a 
	  	inner join tm_prepayment_kelompok_usaha c on c.nIdKelompokUsaha = a.nIdKelompokUsaha_fk 
	  	inner join tm_prepayment_unit_usaha d on d.nIdUnitUsaha = a.nIdUnitUsaha_fk 
	  	inner join tm_prepayment_kategori_pre_payment_h e on e.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk 
	  	inner join tm_prepayment_divisi f on f.nIdDivisi = a.nIdDivisi_fk 
	  	inner join tm_prepayment_departemen g on g.nIdDepartemen = a.nIdDepartemen_fk 
	  	inner join tm_prepayment_payment_type h on h.nIdPaymentType = a.nIdPaymentType_fk

	  	where h.nUnitId_fk = @unit and h.sStatusDelete is null and g.nUnitId_fk = @unit and g.sStatusDelete is null and f.nUnitId_fk = @unit and f.sStatusDelete is null and a.nUnitId_fk = @unit and a.sStatusDelete is null and c.nUnitId_fk = @unit and c.sStatusDelete is null and e.nUnitId_fk = @unit and e.sStatusDelete is null and 

	  	/* Kalau sudah buat penyelesaian tidak di tampilkan */
	  	/*(select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = @unit and p.sPosting = ''1'' and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) = 0 and (select count(p.nIdPengajuanBS_fk) from tx_prepayment_penyelesaian_pp p where p.sStatusDelete is null and p.nUnitId_fk = @unit and p.nIdPengajuanBS_fk = a.nIdPengajuanBS) = 0 and */";

	  	$SQL .= " a.nIdPengajuanBS = ".trim($nIdTransaksi)." ";
	  	$SQL .= "');";
	  	$SQL = str_replace("@unit", $this->session->userdata('nUnitId_fk'), $SQL);
	  	$rs = $this->db->query($SQL);
	  	$row = $rs->row_array();
	  	//----------------------
	  	$oParams['sPaperSize'] = 'BS_PREPAYMENT';
	  	$oParams['sOrientation'] = 'P';
	  	//----------------------
	  	$this->pdf->SetFont($oFontName, '', 8, '', true);
		  $this->pdf->AddPage($oParams['sOrientation'], $oParams['sPaperSize']);
	  	//----------------------
	  	
	  	$sBorderCSS = "border: solid 1px #000;";
	  	$sBorderBottomCSS = "border-bottom: solid 1px #000;";
	  	$sBorderTopCSS = "border-top: solid 1px #000;";
	  	$sBorderLeftCSS = "border-left: solid 1px #000;";
	  	$sBorderRightCSS = "border-right: solid 1px #000;";
	  	$sTextRightCSS = "text-align: right;";
	  	$sTextLeftCSS = "text-align: left;";
	  	$sTextCenterCSS = "text-align: center;";
	  	$sTextBoldCSS = "text-weight: bold;";
	  	$sFontSize6CSS = "font-size: 6pt;";
	  	$sFontSize8CSS = "font-size: 8pt;";
	  	$sFontSize10CSS = "font-size: 10pt;";
	  	$sFontSize16CSS = "font-size: 16pt;";

	  	//$sHTML = "<table cellpadding=\"2\" style=\"width: 425px; ".$sFontSize8CSS."\"><tr><td style=\"width: 380px; ".$sTextRightCSS."\">Tanggal ".date('d/m/Y')."</td><td style=\"".$sTextRightCSS."\">No. Kas  ......................</td></tr></table>";

	  	$sHTML = "<table cellpadding=\"2\" style=\"width: 425px; ".$sFontSize8CSS."\"><tr><td style=\"width: 380px; ".$sTextRightCSS."\">Tanggal ....</td><td style=\"".$sTextRightCSS."\">No. Kas  ......................</td></tr></table>";
	  	
	  	$sHTML .= "<table style=\"".$sTextCenterCSS." ".$sFontSize16CSS." font-weight: bold; \"><tr><td>BON SEMENTARA</td></tr></table>";

	  	$sHTML .= "<table cellpadding=\"4\" style=\"".$sBorderCSS." width: 590px; ".$sFontSize8CSS."\">";
	  	$sHTML .= "<tr><td style=\"".$sTextCenterCSS.$sBorderBottomCSS.$sBorderRightCSS."\">Kelompok Pemesan</td><td style=\"".$sTextCenterCSS.$sBorderBottomCSS.$sBorderRightCSS."\">Unit Usaha</td><td style=\"".$sTextCenterCSS.$sBorderBottomCSS.$sBorderRightCSS."\">Bagian/Seksi</td><td>No Penyusun: ".trim($row['sNoPenyusun'])."</td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sTextCenterCSS.$sBorderRightCSS."\">".trim($row['sNamaKelompokUsaha'])."</td><td style=\"".$sTextCenterCSS.$sBorderRightCSS."\">".trim($row['sNamaUnitUsaha'])."</td><td style=\"".$sTextCenterCSS.$sBorderRightCSS."\">".trim($row['sNamaDepartemen'])."</td><td>Tanggal: ".trim($row['dTglPenyusun'])."</td></tr>";
	  	$sHTML .= "</table>";

	  	$sHTML .= "<table cellpadding=\"4\" style=\"width: 590px; ".$sBorderBottomCSS.$sBorderRightCSS.$sBorderLeftCSS.$sTextLeftCSS." ".$sFontSize8CSS."\"><tr><td>Dibebankan pada Unit Usaha: ".trim($row['sDesc'])."</td></tr>";
	  	$sHTML .= "</table>";

	  	$sHTML .= "<table cellpadding=\"4\" style=\"width: 590px; ".$sBorderBottomCSS.$sBorderRightCSS.$sBorderLeftCSS.$sTextLeftCSS." ".$sFontSize8CSS."\"><tr><td style=\"width: 200px; ".$sBorderRightCSS."\">Keperluan: ".trim($row['sNamaKategoriPrePayment'])."</td><td style=\"width: 390px; ".$sFontSize8CSS." font-weight: bold;\">Perhatian: </td></tr><tr><td style=\"".$sBorderRightCSS."\">Nama: ".trim($row['sNamaKaryawan'])."<br />NIK Karyawan: ".trim($row['sNIK'])."</td><td rowspan=\"4\" style=\"".$sFontSize8CSS."\">1. Isilah dengan jelas (Sebaiknya diketik) <b>putih</b> untuk kasir; <b>kuning</b> untuk penyusun.<br />2. BS ini harus dipertanggung jawabkan, <b>selambat-lambatnya 7 (tujuh) hari setelah diuangkan</b>. Bila lewat waktu, pengambilan BS berikutnya akan ditolak, kecuali ada penjelasan dari kepala Unit ybs.<br />3. Untuk dinas luar kota dan luar negeri harus diberikan laporan pertanggung jawaban yang sudah diotorisasi oleh Ka. Unit ybs yang berwenang untuk itu, kepada Div. PSDM untuk dinas luar kota dan kepada Div. Dana untuk dinas luar negeri selambat-lambatnya 7 (tujuh) hari setelah masuk kerja.<br />4. Bila butir 2 dan 3 tidak ditepati, maka gaji, bonus dan gratifikasi ditahan sampai BS diselesaikan.<br />5. Jika nama pemakai dana tidak dicantumkan, maka penyusun bertanggung jawab atas pemakaian dana tsb. </td></tr><tr><td style=\"".$sBorderRightCSS."\">Kelompok: ".trim($row['sNamaKelompokUsaha'])."</td></tr><tr><td style=\"".$sBorderRightCSS."\">Unit Usaha: ".trim($row['sNamaUnitUsaha'])."</td></tr><tr><td style=\"".$sBorderRightCSS."\">Bagian/Sie: ".trim($row['sNamaDepartemen'])."</td></tr>";
	  	$sHTML .= "</table>";

	  	$sHTML .= "<table style=\"width: 0px; ".$sBorderBottomCSS.$sBorderRightCSS.$sBorderLeftCSS.$sTextLeftCSS." ".$sFontSize8CSS."\"><tr><td style=\"width: 200px; ".$sBorderRightCSS."\">Sebutkan BS yang telah lewat waktu: </td><td style=\"width: 390px; ".$sFontSize10CSS."\" rowspan=\"15\">";
	  	$sHTML .= "<table cellpadding=\"2\" cellspacing=\"0\" style=\"width: 385px; ".$sFontSize8CSS."\">";
	  	$sHTML .= "<tr><td>Jumlah: Rp. <b>".number_format(trim(doubleval($row['nTotalAmount'])), 0)."</b> ".str_repeat("&nbsp;", 100 - (strlen(number_format(trim(doubleval($row['nTotalAmount'])), 0))))."*(".trim($row['sNamaPaymentType']).")</td></tr>";
	  	$sHTML .= "<tr><td style=\"width: 60px;\" style=\"".$sFontSize8CSS." background-color: #ddd;\">".trim($row['sTotalAmountTerbilang'])."</td></tr>";
	  	//$sHTML .= "<tr><td style=\"".$sFontSize8CSS."\">* Coret yang tidak perlu</td></tr>";
	  	//$sHTML .= "<tr><td  style=\"".$sBorderBottomCSS." width: 290px;\">Pembayaran untuk: ".trim($row['sNamaKategoriPrePayment'])."</td><td style=\"".$sBorderBottomCSS." width: 100px;\">Jumlah</td></tr>";
	  	//$sHTML .= "<tr><td  style=\"width: 273px;".$sFontSize8CSS.$sBorderBottomCSS.$sBorderRightCSS."\">".trim($row['sNamaKomponenPrePayment'])."</td><td style=\"".$sFontSize8CSS.$sBorderBottomCSS." width: 119px;\">".trim($row['sNamaKomponenPrePaymentRupiah'])."</td></tr>";

	  	$sHTML .= "<tr><td  style=\"height: 63px; width: 390px;\">Pembayaran untuk: <br /><b>".trim($row['sNamaKategoriPrePayment'])."</b>, <b>".trim($row['dTglKegiatanAwal'])."</b> s/d <b>".trim($row['dTglKegiatanAkhir'])."</b><br />".trim($row['sDeskripsi'])."</td><td style=\"width: 100px;\"></td></tr>";

	  	$sHTML .= "<tr><td style=\" width: 385px; background-color: #ddd;".$sFontSize10CSS."\">TOTAL Rp. <b>".number_format(trim(doubleval($row['nTotalAmount'])), 0)."</b></td></tr>";

	  	$sHTML .= "</table>";
	  	$sHTML .= "</td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS." \">No BS.......................................................................</td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS." \">Tanggal....................................................................</td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS."\">Jumlah.....................................................................</td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS."\">Penjelasanan dari Dir Kel...........................................</td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS."\"><br /><br /></td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS."\">BS ini diselesaikan di kasir:</td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS."\">[ ] Gajah Mada [ ] Redaksi Kompas</td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS."\">[ ] Palmerah   [ ] ......................</td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS."\"><br /></td></tr>";
	  	$sHTML .= "</table>";

	  	$sHTML .= "<table cellpadding=\"2\" style=\"width: 590px; ".$sBorderBottomCSS.$sBorderRightCSS.$sBorderLeftCSS.$sTextLeftCSS." ".$sFontSize8CSS."\">";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS.$sTextCenterCSS."\">Dir Keuangan</td><td style=\"".$sBorderRightCSS.$sTextCenterCSS."\">Dir Kel/............</td><td style=\"".$sBorderRightCSS.$sTextCenterCSS."\">Penyusun</td><td style=\"".$sBorderRightCSS.$sTextCenterCSS."\">Kasir Pembayar</td><td style=\"".$sTextCenterCSS."\">Tanda Terima</td></tr>";
	  	//$sHTML .= "<tr><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td></tr>";
	  	$sHTML .= "<tr><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td><td style=\"".$sBorderRightCSS."\"><br /></td></tr>";
	  	//$sHTML .= "<tr><td style=\"".$sTextCenterCSS.$sBorderRightCSS."\">(...........................................)</td><td style=\"".$sTextCenterCSS.$sBorderRightCSS."\">".trim($row['sNamaAtasan'])." (".trim($row['sNIKAtasan']).")</td><td style=\"".$sBorderRightCSS.$sTextCenterCSS."\">".trim($row['sNamaPenyusun'])."</td><td style=\"".$sBorderRightCSS."\">(...........................................)</td><td>(...........................................)</td></tr>";
	  	//$sHTML .= "<tr><td style=\"".$sTextCenterCSS.$sBorderRightCSS."\">(...........................................)</td><td style=\"".$sTextCenterCSS.////$sBorderRightCSS."\">".trim($row['sNamaAtasan'])."</td><td style=\"".$sBorderRightCSS.$sTextCenterCSS."\">".trim($row['sNamaKaryawan'])."</td><td style=\"".$sBorderRightCSS."\">(...........................................)</td><td>(...........................................)</td></tr>";
			$sHTML .= "<tr><td style=\"".$sTextCenterCSS.$sBorderRightCSS."\">(...........................................)</td><td style=\"".$sTextCenterCSS.$sBorderRightCSS."\">".(trim($sNamaAtasanCustom) === "" ? trim($row['sNamaAtasan']) : trim($sNamaAtasanCustom))."</td><td style=\"".$sBorderRightCSS.$sTextCenterCSS."\">".(trim($sNamaPenyusunCustom) === "" ? trim($row['sNamaPenyusun']) : trim($sNamaPenyusunCustom))."</td><td style=\"".$sBorderRightCSS."\">(...........................................)</td><td>(...........................................)</td></tr>";

	  	$sHTML .= "</table>";

	  	$this->pdf->writeHTML($sHTML, false, false, false, '');	 	  
	  	//-----------------------------------------
		  $this->pdf->Output($oPDFPath.$oFile.'.pdf', 'F');
		  $this->pdf->Output($oFile.'.pdf', 'I');
		  //return json_encode(array("sPath" => $oWebPath.$oFile.'.pdf'));
		  return false;
		}
		else if(trim($oParams['sReportType']) === "Report.Penyelesaian.Pre.Payment")
	  {
	  	$nIdTransaksi = trim($oParams['nIdTransaksi']);
	  	$SQL = "call sp_query('select date_format(a.dTglBuatPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglBuatPenyelesaianPrePaymentX, a.nIdPengajuanBS_fk, a.sKeterangan, a.sNamaUnitUsaha, c.sNamaKelompokUsaha, a.sNoPenyusun, date_format(a.dTglPenyusun, ''%d/%m/%Y'') as dTglPenyusun, a.sNIK, a.sNamaKaryawan, a.sNamaUnitUsaha, a.sBagian, a.sNamaBank, a.sCabangBank, a.sNoRekening, a.sAtasNamaRekening, date_format(a.dTglKegiatanAwal, ''%d/%m/%Y'') as dTglKegiatanAwal, date_format(a.dTglKegiatanAkhir, ''%d/%m/%Y'') as dTglKegiatanAkhir, a.sNIKAtasan, a.sNamaAtasan, a.sNamaPenyusun, date_format(a.dTglPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglPenyelesaianPrePayment, a.nIdKelompokUsaha_fk, a.nIdDivisi_fk, a.nIdDepartemen_fk, a.nTotalAmount, a.sTotalAmountTerbilang, d.sNamaUnitUsaha, 

	  	".$this->db->database.".gf_global_function(''GetLastStatusPrePayment'', @unit, a.nIdPengajuanBS_fk, ''PENGAJUAN_PRE_PAYMENT'', null, null, null) as `sLastStatus`, a.sTotalBiayaTerpakaiTerbilang


	  	, e.sNamaKategoriPrePayment, f.sNamaDivisi, g.sNamaDepartemen, h.sNamaPaymentType, a.nTotalBiayaTerpakai, a.nTotalBiayaSisa, a.sKeterangan, date_format(a.dTglPenyelesaianPrePayment, ''%d/%m/%Y'') as dTglPenyelesaian

	  	from tx_prepayment_penyelesaian_pp a inner join tm_prepayment_kelompok_usaha c on c.nIdKelompokUsaha = a.nIdKelompokUsaha_fk inner join tm_prepayment_unit_usaha d on d.nIdUnitUsaha = a.nIdUnitUsaha_fk inner join tm_prepayment_kategori_pre_payment_h e on e.nIdKategoriPrePayment = a.nIdKategoriPrePayment_fk inner join tm_prepayment_divisi f on f.nIdDivisi = a.nIdDivisi_fk inner join tm_prepayment_departemen g on g.nIdDepartemen = a.nIdDepartemen_fk inner join tm_prepayment_payment_type h on h.nIdPaymentType = a.nIdPaymentType_fk 

	  	where h.nUnitId_fk = @unit and h.sStatusDelete is null and g.nUnitId_fk = @unit and g.sStatusDelete is null and f.nUnitId_fk = @unit and f.sStatusDelete is null and a.nUnitId_fk = @unit and a.sStatusDelete is null and c.nUnitId_fk = @unit and c.sStatusDelete is null and e.nUnitId_fk = @unit and e.sStatusDelete is null ";
	  	$SQL .= " and a.nIdPenyelesaianBS = ".trim($nIdTransaksi)." ";
	  	$SQL .= "');";
	  	$SQL = str_replace("@unit", $this->session->userdata('nUnitId_fk'), $SQL);
	  	//print $SQL;
	  	//exit(0);
	  	$rs = $this->db->query($SQL);
	  	foreach($rs->result_array() as $row)
	  	{
			  $sHTML .= "<table cellpadding=\"2\" style=\"width: 430px; font-size: 9pt;\">";
			  $sHTML .= "<tr><td style=\"font-weight: bold; font-size: 12pt; width: 220px;\" colspan=\"3\">Report Penyelesaian Pre Payment</td><td style=\"text-align: right; font-size: 8pt; width: 310x;\">Tgl: ".date('d/M/Y')."</td></tr>";
			  $sHTML .= "</table>";
			  $sHTML .= "<table cellpadding=\"2\" style=\"width: 430px; font-size: 8pt;\">";
			  $sHTML .= "<tr><td style=\"width: 100px;\">No Penyusun</td><td style=\"width: 10px;\">:</td><td style=\"width: 170px;\">".trim($row['sNoPenyusun'])."</td><td style=\"width: 115px;\">Di Bebankan pada Unit Usaha</td><td style=\"width: 10px;\">:</td><td style=\"width: 115px;\">".trim($row['sNamaUnitUsaha'])."</td></tr>";
			  $sHTML .= "<tr><td>Tgl Penyusun</td><td>:</td><td>".trim($row['dTglPenyusun'])."</td><td style=\"width: 115px;\">Divisi Pembebanan</td><td style=\"width: 10px;\">:</td><td>".trim($row['sNamaDivisi'])."</td></tr>";
			  $sHTML .= "<tr><td>NIK</td><td>:</td><td>".trim($row['sNIK'])."</td><td style=\"width: 115px;\">Departemen Pembebanan</td><td style=\"width: 10px;\">:</td><td>".trim($row['sNamaDepartemen'])."</td></tr>";
			  $sHTML .= "<tr><td>Nama</td><td>:</td><td>".trim($row['sNamaKaryawan'])."</td><td style=\"width: 115px;\">Tgl Kegiatan Mulai</td><td style=\"width: 10px;\">:</td><td>".trim($row['dTglKegiatanAwal'])."</td></tr>";
			  $sHTML .= "<tr><td>Kelompok Usaha Pemesan</td><td>:</td><td>".trim($row['sNamaKelompokUsaha'])."</td><td style=\"width: 115px;\">Tgl Kegiatan Selesai</td><td style=\"width: 10px;\">:</td><td>".trim($row['dTglKegiatanAkhir'])."</td></tr>";
			  $sHTML .= "<tr><td>Unit Usaha</td><td>:</td><td>".trim($row['sNamaUnitUsaha'])."</td><td style=\"width: 115px;\">Tgl Penyelesaian Pre Payment</td><td style=\"width: 10px;\">:</td><td>".trim($row['dTglPenyelesaianPrePayment'])."</td></tr>";
			  $sHTML .= "<tr><td>Bagian / Seksi</td><td>:</td><td>".trim($row['sBagian'])."</td><td style=\"width: 115px;\">Cara Bayar</td><td style=\"width: 10px;\">:</td><td>".trim($row['sNamaPaymentType'])."</td></tr>";
			  $sHTML .= "<tr><td>Nama Bank</td><td>:</td><td>".trim($row['sNamaBank'])."</td><td style=\"width: 115px;\">Keterangan</td><td style=\"width: 10px;\">:</td><td>".trim($row['sKeterangan'])."</td></tr>";
			  $sHTML .= "<tr><td>Cabang Bank</td><td>:</td><td>".trim($row['sCabangBank'])."</td><td style=\"width: 115px;\">Nama TTD Atasan</td><td style=\"width: 10px;\">:</td><td>".trim($row['sNamaAtasan'])." (".trim($row['sNIKAtasan']).")</td></tr>";
			  $sHTML .= "<tr><td>No Rekening</td><td>:</td><td>".trim($row['sNoRekening'])."</td><td style=\"width: 115px;\">Nama TTD Penyusun</td><td style=\"width: 10px;\">:</td><td>".trim($row['sNamaPenyusun'])."</td></tr>";
			  $sHTML .= "<tr><td>Nama Pemilik Rekening</td><td>:</td><td>".trim($row['sAtasNamaRekening'])."</td></tr>";
			  $sHTML .= "<tr><td>Last Status Pre Payment</td><td>:</td><td colspan=\"6\">".trim($row['sLastStatus'])."</td></tr>";
			  $sHTML .= "<tr><td>Kategori Pre Payment</td><td>:</td><td><b>".trim($row['sNamaKategoriPrePayment'])."</b></td></tr>";
			  $sHTML .= "</table>";
			  //---------------------------------------------------
			  $sHTML .= "<p>Komponen Pre Payment (Calculated)</p>";			 
			  $SQL = "call sp_query('select b.sNamaKomponen, a.nIdPenyelesaianBS_fk, a.nIdKomponen_fk, a.sKeterangan, a.sTipeDataKomponen, a.sAllowSummary, a.nDigit, a.nDecimalPoint, a.sValue, a.nValue, date_format(a.dValue, ''%d/%m/%Y'') as dValue, a.nSeqNo, a.sLabel, a.sSatuan, a.sAllowMultiply, a.nQty, a.nSubTotal from tx_prepayment_penyelesaian_pp_komponen a inner join tm_prepayment_komponen_pre_payment b on b.nIdKomponen = a.nIdKomponen_fk where a.nIdPenyelesaianBS_fk = ".trim($nIdTransaksi)." and a.sStatusDelete is null and b.sStatusDelete is null and a.nUnitId_fk = @unit and b.nUnitId_fk = @unit and  a.sTipeDataKomponen = ''N'' ');";
			  $SQL = str_replace("@unit", $this->session->userdata('nUnitId_fk'), $SQL);
		  	$rs1 = $this->db->query($SQL);
	  		$sHTML .= "<table cellpadding=\"2\" style=\"border-bottom: solid 1px #ccc; width: 430px; font-size: 8pt;\">";
				$sHTML .= "<tr style=\"background-color: #ddd;\"><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 20px;\"><b>No</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 200px;\"><b>Komponen</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 80px;\"><b>Satuan</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc;\"><b>Nilai</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 20px;\"><b>Qty</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc;\"><b>Sub Total</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; border-right: solid 1px #ccc; width: 90px;\"><b>Keterangan</b></td></tr>";
				$i = 1;
		  	foreach($rs1->result_array() as $row1)
		  	{
					$sHTML .= "<tr style=\"background-color: ".($i % 2 === 0 ? "#f5f5f5" : "#fff")."\"><td style=\"border-left: solid 1px #ccc; text-align: right;\">".$i."</td><td>".trim($row1['sNamaKomponen'])."</td><td>".trim($row1['sSatuan'])."</td><td style=\"".(trim($row1['sTipeDataKomponen']) === "N" ? "text-align: right;" : "")."\">".(trim($row1['sTipeDataKomponen']) === "N" ? number_format(trim($row1['nValue']), 0) : trim($row1['dValue']))."</td><td style=\"text-align: right;\">".$row1['nQty']."</td><td style=\"".(trim($row1['sTipeDataKomponen']) === "N" ? "text-align: right;" : "")."\">".(trim($row1['sTipeDataKomponen']) === "N" ? number_format(trim($row1['nSubTotal']), 0) : "")."</td><td style=\"border-right: solid 1px #ccc; \">".trim($row1['sKeterangan'])."</td></tr>";
					$i++;
		  	}
		  	$sHTML .= "<tr style=\"background-color: #ffcc99;\"><td style=\"text-align: right; border-left: solid 1px #ccc;\" colspan=\"5\"><b>Grand Total</b></td><td style=\"text-align: right; border-top: solid 1px #ccc;\">".number_format($row['nTotalBiayaTerpakai'])."</td><td style=\"border-right: solid 1px #ccc;\"></td></tr>";
		  	$sHTML .= "<tr><td style=\"border-right: solid 1px #ccc; border-left: solid 1px #ccc; border-top: solid 1px #ccc;\" colspan=\"7\">Terbilang: <b>".($row['sTotalBiayaTerpakaiTerbilang'])."</b> Rupiah</td></tr>";
				$sHTML .= "</table>";
			  //---------------------------------------------------
			  $sHTML .= "<p>Komponen Pre Payment (Non Calculated)</p>";			 
			  $SQL = "call sp_query('select b.sNamaKomponen, a.nIdPenyelesaianBS_fk, a.nIdKomponen_fk, a.sKeterangan, a.sTipeDataKomponen, a.sAllowSummary, a.nDigit, a.nDecimalPoint, a.sValue, a.nValue, date_format(a.dValue, ''%d/%m/%Y'') as dValue, a.nSeqNo, a.sLabel, a.sSatuan, a.sAllowMultiply, a.nQty, a.nSubTotal from tx_prepayment_penyelesaian_pp_komponen a inner join tm_prepayment_komponen_pre_payment b on b.nIdKomponen = a.nIdKomponen_fk where a.nIdPenyelesaianBS_fk = ".trim($nIdTransaksi)." and a.sStatusDelete is null and b.sStatusDelete is null and a.nUnitId_fk = @unit and b.nUnitId_fk = @unit and  a.sTipeDataKomponen <> ''N'' ');";
			  $SQL = str_replace("@unit", $this->session->userdata('nUnitId_fk'), $SQL);
		  	$rs1 = $this->db->query($SQL);
	  		$sHTML .= "<table cellpadding=\"2\" style=\"border-bottom: solid 1px #ccc; width: 430px; font-size: 8pt;\">";
				$sHTML .= "<tr style=\"background-color: #ddd;\"><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 20px;\"><b>No</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 200px;\"><b>Komponen</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; width: 80px;\"><b>Satuan</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc;\"><b>Nilai</b></td><td style=\"border-left: solid 1px #ccc; border-top: solid 1px #ccc; border-bottom: solid 1px #ccc; border-right: solid 1px #ccc; width: 147px;\"><b>Keterangan</b></td></tr>";
				$i = 1;
				if($rs1->num_rows() > 0)
				{
			  	foreach($rs1->result_array() as $row1)
			  	{
						$sHTML .= "<tr style=\"background-color: ".($i % 2 === 0 ? "#f5f5f5" : "#fff")."\"><td style=\"border-left: solid 1px #ccc; text-align: right;\">".$i."</td><td>".trim($row1['sNamaKomponen'])."</td><td>".trim($row1['sSatuan'])."</td><td style=\"".(trim($row1['sTipeDataKomponen']) === "N" ? "text-align: right;" : "")."\">".(trim($row1['sTipeDataKomponen']) === "N" ? number_format(trim($row1['nValue']), 0) : trim($row1['dValue']))."</td><td style=\"border-right: solid 1px #ccc; \">".trim($row1['sKeterangan'])."</td></tr>";
						$i++;
			  	}
			  }
			  else
			  {
			  	$sHTML .= "<tr style=\"background-color: ".($i % 2 === 0 ? "#f5f5f5" : "#fff")."\"><td coslpan=\"5\" style=\"border-bottom: solid 1px #ccc; border-left: solid 1px #ccc; border-right: solid 1px #ccc; text-align: center; width: 533px;\">Nothing</td></tr>";
			  }
				$sHTML .= "</table>";
				 $sHTML .= "<p>Informasi Penyelesaian Pre Payment</p>";			 
				$sHTML .= "<table cellpadding=\"2\" style=\"width: 430px; font-size: 8pt;\">";
				$sHTML .= "<tr><td style=\"width: 90px;\">Tgl Buat Penyelesaian</td><td style=\"width: 10px;\">:</td><td>".trim($row['dTglBuatPenyelesaianPrePaymentX'])."</td></tr>";
				$sHTML .= "<tr><td>Jml Dana Pengajuan</td><td>:</td><td>Rp. ".number_format(trim($row['nTotalAmount']), 0)."</td></tr>";
				$sHTML .= "<tr><td>Jml Dana Terpakai</td><td>:</td><td>Rp. ".number_format(trim($row['nTotalBiayaTerpakai']), 0)."</td></tr>";
				$sHTML .= "<tr><td>Sisa / Lebih Dana</td><td>:</td><td>Rp. ".number_format(trim($row['nTotalBiayaSisa']), 0)."</td></tr>";
				$sHTML .= "<tr><td>Keterangan</td><td>:</td><td>".trim($row['sKeterangan'])."</td></tr>";
				$sHTML .= "</table>";
			  //---------------------------------------------------
			}	  
		}
	  $this->pdf->AddPage((array_key_exists('sOrientation', $oParams)) ? trim($oParams['sOrientation']) : "P", (array_key_exists('sPaperSize', $oParams)) ? trim($oParams['sPaperSize']) : "A4");
	  $this->pdf->writeHTML($sHTML, true, false, false, false, '');
	  //------------------------------
	  $this->pdf->Output($oPDFPath.$oFile.'.pdf', 'F');
	  $this->pdf->Output($oFile.'.pdf', 'I');
	  //------------------------------
	}
}