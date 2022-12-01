<?php 
$oTab1 = $oTab2 = $oButton = "";
if (trim($o_mode) === "I") {
	$oTab1 = "active";
	$oButton = $o_extra['o_save'];
} else {
	$oTab2 = "active";
	$oButton = $o_extra['o_update'] . " " . $o_extra['o_delete'];
}
$oButton .= " " . $o_extra['o_cancel'];

$nGroupUserIdHRD = 7; // Grup use HRD 
$nGroupUserIdFINANCE = 9; // Grup use FINANCE 
$oData = json_decode($o_punya_anak_buah, true);			

?> 
<div class="nav-tabs-custom"> 
	<ul class="nav nav-tabs"> 
		<?php
		$oData = json_decode($o_punya_anak_buah, TRUE);
		$nGroupUserIdSession = intval($this->session->userdata('nGroupUserId_fk'));
		if(intval($oData['oData']) > 0 || (intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdHRD) || intval($this->session->userdata('nGroupUserId_fk')) === $nGroupUserIdFINANCE)
		{
			if($nGroupUserIdSession !== 0)
			{
				if($nGroupUserIdSession !== $nGroupUserIdHRD && $nGroupUserIdSession !== $nGroupUserIdFINANCE)
				{
					if(intval($oData['oData']) > 0) //--Punya anak buah
					{
					?>
						<li class="<?php print trim($o_data[0]['nIdPenyelesaianBS']) === "(AUTO)" ? "active" : ""; ?>"><a data-toggle="tab" href="#tab_5"><b class="text-yellow">List Pengajuan Pre Payment | STAFF</b></a></li>
				<?php
					}
				}
				else
				{
					?>
						<li class=""><a data-toggle="tab" href="#tab_5"><b class="text-yellow">List Pengajuan Pre Payment | HRD Approval</b></a></li> 
					<?php
				}
			}
		}
		?>
		<li class=""><a data-toggle="tab" href="#tab_1"><b class="text-green">List Pengajuan Pre Payment | SAYA</b></a></li>
		<li class=""><a data-toggle="tab" href="#tab_2"><b class="text-red">List Penyelesaian Pre Payment | SAYA</b></a></li>
		<li class="<?php print trim($o_data[0]['nIdPenyelesaianBS']) <> "" ? "active" : ""; ?>"><a data-toggle="tab" href="#tab_3">Form Penyelesaian Pre Payment</a></li> 
		<li class=""><a data-toggle="tab" href="#tab_4">Report Penyelesaian Pre Payment</a></li>
	</ul> 
	<div class="tab-content"> 
		<div id="tab_1" class="tab-pane"> 
			<div id="divListPengajuanPrePaymentSaya">	
			</div> 
		</div> 
		<div id="tab_2" class="tab-pane"> 
			<div id="divListPenyelesaianPrePayment">	
			</div> 
		</div> 
		<div id="tab_3" class="tab-pane <?php print trim($o_data[0]['nIdPenyelesaianBS']) !== "" ? "active" : "" ?>"> 
			<div id="divInfo" class="<?php print trim($o_data[0]['nIdPengajuanBS']) === "" ? "" : "hidden" ?>">Please select Pre Payment List before !</div>
			<form id="form_5ca2dcddb1a39" class="<?php print trim($o_data[0]['nIdPengajuanBS']) === "" ? "hidden" : "" ?>" role="form" action="<?php print site_url(); ?>c_prepayment_penyelesaian_pre_payment/gf_transact" method="post"> 
				<div class="box-body no-padding"> 
					<div class="row" id="div-top">
						<?php
							if(trim($o_data[0]['sPosting']) !== "" && intval($o_data[0]['sPosting']) === 1)
							print "<div class=\"col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group\"><div class=\"bg-warning\" style=\"border: solid 1px #ffcc99; padding: 2px; font-size: 22px;\"><div class=\"user-panel\"><div class=\"pull-left image\"><i class=\"fa fa-lock fa-4x\"></i></div><div class=\"pull-left info\"><p style=\"color: #000; margin-left: 10px;\"><b>POSTED</b> by <b>".trim($o_data[0]['sPostingBy'])."</b> at <b>".trim($o_data[0]['dPostingDate'])."</b><br /><span style=\"font-size: 14px;\">For you information, all data can't change because has been Posting. For any information please contact Human Resources Departement for detail.<br />Or contact System & Information Helpdesk for Technical problem.</span></p></div></div></div></div>";	
						?>
						<div class="col-sm-12 col-xs-12 col-md-8 col-lg-7">
							<div class="row">
								<!--<div class="col-sm-4 col-xs-12 col-md-6 col-lg-4 form-group" id="div-top"><label>Id Penyelesaian Pre Payment</label><input allow-empty="false" type="text" placeholder="Sample" name="txtIdDivisi" id="txtIdDivisi" class="form-control" maxlength="50" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nIdPengajuanBS']); ?>" readonly>
								</div>-->
								<input type="hidden" name="hideIdPengajuanBS" id="hideIdPengajuanBS" value="<?php print trim($o_data[0]['nIdPengajuanBS']); ?>" />
								<div class="row"></div>
								<div class="hidden"><label>Id Transaksi Pre Payment</label><br /><?php print trim($o_data[0]['nIdPengajuanBS']); ?>
								</div>
								<div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>No Penyusun</label><br /><?php print trim($o_data[0]['sNoPenyusun']); ?>
							  </div>
								<div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Tgl Penyusun</label>
									<br /><?php print trim($o_data[0]['dTglPenyusunX']); ?>
							  </div>
								<div class="col-sm-12 col-xs-12 col-md-5 col-lg-4 form-group"><label>Tgl Penyelesaian Pre Payment</label><br />
									<span id="spanTglPenyelesaianPrepayment"><?php print trim($o_data[0]['dTglPenyelesaianPrePaymentX']); ?></span>
									<input type="hidden" name="txtTglPenyelesaiPrePayment" id="txtTglPenyelesaiPrePayment" class="form-control" value="<?php print trim($o_data[0]['dTglPenyelesaianPrePaymentX']); ?>">
							  </div>
								<div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label class="text-red">Tgl Keg. Mulai (Realisasi)</label><br />
									<!--<?php print trim($o_data[0]['dTglKegiatanAwalX']); ?>-->
									<div class="input-group date">
									  <input allow-empty="false" placeholder="Tgl Keg Akhir" name="txtTglKegMulai" value="<?php print trim($o_data[0]['dTglKegiatanAwalX']); ?>" id="txtTglKegMulai" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
									<!--<input name="txtTglKegMulai" value="<?php print trim($o_data[0]['dTglKegiatanAwalX']); ?>" id="txtTglKegMulai" type="hidden">-->
							  </div>
								<div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label class="text-red">Tgl Keg. Selesai (Realisasi)</label>
									<!--<br /><?php print trim($o_data[0]['dTglKegiatanAkhirX']); ?>-->
									<div class="input-group date">
									  <input allow-empty="false" placeholder="Tgl Keg Akhir" name="txtTglKegSelesai" value="<?php print trim($o_data[0]['dTglKegiatanAkhirX']); ?>" id="txtTglKegSelesai" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
							  </div>
							  <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Kelompok Usaha Pemesan</label><br /><?php print trim($o_data[0]['sNamaKelompokUsaha']); ?>
							  </div>
							  <div class="row"></div>
							  <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Di Bebankan pada Unit Usaha</label><br /><?php print trim($o_data[0]['sNamaUnitUsaha']); ?>
							  </div>
							  <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Divisi Pembebanan</label><br /><?php print trim($o_data[0]['sNamaDivisi']); ?>
							  </div>
							  <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Departmen Pembebanan</label><br /><?php print trim($o_data[0]['sNamaDepartemen']); ?>
							  </div>
							  <div class="row"></div>
							  <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Cara Bayar</label><br /><?php print trim($o_data[0]['sNamaPaymentType']); ?>
							  </div>
							  <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Nama TTD Atasan</label><br /><?php print trim($o_data[0]['sNamaAtasan']); ?>
			          <input type="hidden" name="hideNIKAtasan" id="hideNIKAtasan" value="<?php print trim($o_data[0]['sNIKAtasan']); ?>"/>
							  </div>
							  <div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Nama TTD Penyusun</label><br /><?php print trim($o_data[0]['sNamaPenyusun']); ?>
							  </div>
							  <div class="row"></div>
								<div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Kategori Pre Payment</label><br /><?php print trim($o_data[0]['sNamaKategoriPrePayment']); ?>
							  </div>
								<div class="col-sm-8 col-xs-12 col-md-8 col-lg-8 form-group"><label>Keterangan</label><br /><?php print trim($o_data[0]['sDeskripsi']) === "" ? "-" : preg_replace('/<br\\s*?\/??>/i', '', trim($o_data[0]['sDeskripsi'])); ?>
								</div>
								<div class="row"></div>
								  <div class="col-sm-8 col-xs-12 col-md-8 col-lg-12"><br /><label>Informasi Transfer</label><br />Nama Bank: <b><?php print trim($o_data[0]['sNamaBank']); ?></b>, Cabang Bank: <b><?php print trim($o_data[0]['sCabangBank']); ?></b>, No Rekening: <b><?php print trim($o_data[0]['sNoRekening']); ?></b>, Atas Nama Rekening: <b><?php print trim($o_data[0]['sAtasNamaRekening']); ?></b><br />&nbsp;
									</div>
							  <div class="row"></div>
							  <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Last Status</label>
								  <p class="bg-warning" style="border: solid 1px #ffcc99; padding: 8px; margin-bottom: 10px;">					  	
							  	<?php 
							  		if(trim($o_data[0]['sCreateBy']) !== "")
							  			print trim($o_data[0]['sLastStatus']) === "" ? "Created By <b>".trim($o_data[0]['sCreateBy'])."</b> at <b>".trim($o_data[0]['dCreateOnX'])."</b>" : trim($o_data[0]['sLastStatus']); 
							  		else
							  			print "New";
							  	?>
							  	</p>
							  </div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Keterangan</label>
								<?php
								if(trim($o_data[0]['sPosting']) !== "" && intval($o_data[0]['sPosting']) === 1)
									print "<br /><label>".trim($o_data[0]['sKeterangan'])."</label>";
								else
								{
									?>		
									<textarea placeholder="Keterangan" rows="2" name="txtKeteranganPenyelesaian" id="txtKeteranganPenyelesaian" class="form-control" maxlength="200"><?php print trim($o_data[0]['sKeterangan']); ?></textarea>
								<?php
									}
								?>
								</div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12">
								<p class="bg-warning" style="border: solid 1px #ffcc99; padding: 8px;">					  	
									<b>Pastikan file yang di upload sudah benar dan bisa dipertanggungjawabkan</b>
								</p>
								</div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group <?php print trim($o_data[0]['sUploadName']) !== "" ? "hidden" : ""; ?>">					
									<a class="cursor-pointer btn btn-danger" title="Click here to Change Profile Picture" id="aUploadImage">Upload Bukti Konfirmasi Pre Payment</a>
									<span id="spanProgress"></span>
								</div>
								<div class="row"></div>	
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 <?php print trim($o_data[0]['sUploadName']) !== "" ? "" : "hidden"; ?>" id="divUpload">
									<?php 
										if(trim($o_data[0]['sUploadName']) !== "")
										{
											print "<div class=\"col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group\"><div class=\"row\"><a suuid=\"".trim($o_data[0]['sUUID'])."\" pathfile=\"".$o_data[0]['sPathFile']."\" title=\"Click here to Download File !\" id=\"aRealFileName\" uploadid=\"".trim($o_data[0]['sUploadId'])."\" encfilename=\"".trim($o_data[0]['sEncryptedFileName'])."\" class=\"btn btn-success\">".trim($o_data[0]['sUploadName'])."</a></div></div>";
											if(trim($o_data[0]['sPosting']) === "" && intval($o_data[0]['sPosting']) === 0)
											{
												if($nGroupUserIdSession !== $nGroupUserIdHRD)
												{
													if(trim($o_data[0]['sNIK']) === trim($this->session->userdata('sUserName')))
													{
														print "<div class=\"col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group\"><div class=\"row\"><a id=\"aRemove\" class=\"btn btn-danger\"><i class=\"fa fa-trash\"></i> Remove File</a></div></div>"; 
													}
												}
											}
										}
									?>
								</div>
							</div> 
						</div>
						<div class="col-sm-12 col-xs-12 col-md-12 col-lg-5">
							<div class="row">
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group hidden"><label>NIK & Nama Karyawan</label><p class="bg-warning" style="border: solid 1px #ffcc99; padding: 8px;">		<?php print trim($o_data[0]['sNamaKaryawan']); ?></p>
								</div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label class="bg-success" style="padding: 4px;">Informasi Karyawan Yang Mengajukan Pre Payment</label>
								<br />
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12" id="divInfoKaryawan">
									<?php
										if(trim($o_mode) === "I")
											print "Pilih NIK untuk menampilkan Informasi Karyawan.";
										else
										{
											$s = "<div class=\"row table-responsive\"><table class=\"table table-stripped text-left\" id=\"tableInfoKaryawan\">";
											$s .= "<tr><td class=\"text-left\"><b>Nama</b></td><td>:</td><td>".trim($o_data[0]['sNamaKaryawan'])." (".trim($o_data[0]['sNIK']).")</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Atasan</b></td><td>:</td><td>".trim($o_data[0]['sNamaAtasan'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Unit Usaha</b></td><td>:</td><td>".trim($o_data[0]['sNamaUnitUsaha'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Bagian</b></td><td>:</td><td>".trim($o_data[0]['sBagian'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Divisi</b></td><td>:</td><td>".trim($o_data[0]['sNamaDivisi'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Departemen</b></td><td>:</td><td>".trim($o_data[0]['sNamaDepartemen'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Bank</b></td><td>:</td><td>".trim($o_data[0]['sNamaBank'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Cabang</b></td><td>:</td><td>".trim($o_data[0]['sCabangBank'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>No Rekening</b></td><td>:</td><td>".trim($o_data[0]['sNoRekening'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Atas Nama Rekening</b></td><td>:</td><td>".trim($o_data[0]['sAtasNamaRekening'])."</td></tr>";
											$s .= "<tr><td><b>Apps Group User</b></td><td>:</td><td class=\"text-red\">".trim($o_data[0]['sGroupUser'])."</td></tr>";
											$s .= "</table></div>";
											print $s;
										}				
										?>
									</div>
								</div>	
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-6 form-group"><label>Id Penyelesaian Pre Payment</label>
									<?php
										if(trim($o_data[0]['sPosting']) !== "" && intval($o_data[0]['sPosting']) === 1)
											print "<br /><label>".trim($o_data[0]['nIdPenyelesaianBS'])."</label>";
										else
										{
											?>
									<input type="text" name="txtIdPenyelesaianPP" content-mode="<?php print trim($o_data[0]['nIdPenyelesaianBS']) !== "(AUTO)" ? "numeric" : "" ?>" readonly id="txtIdPenyelesaianPP" value="<?php print trim($o_data[0]['nIdPenyelesaianBS']) !== "(AUTO)" ? trim($o_data[0]['nIdPenyelesaianBS']) : "(AUTO)"; ?>" class="form-control" />
									<?php
									}
								?>
								</div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-6 form-group"><label>Tgl Penyelesaian Pre Payment</label>
								<?php
								if(trim($o_data[0]['sPosting']) !== "" && intval($o_data[0]['sPosting']) === 1)
									print "<br /><label>".trim($o_data[0]['dTglBuatPenyelesaianPrePaymentX'])."</label>";
								else
								{
									?>
									<input type="text" name="txtTglPenyelesaianPP" readonly id="txtTglPenyelesaianPP" value="<?php print trim($o_data[0]['nIdPenyelesaianBS']) !== "(AUTO)" ? trim($o_data[0]['dTglBuatPenyelesaianPrePaymentX']) : date('d/m/Y'); ?>" class="form-control" />
									<?php
									}
								?>
								</div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Jumlah Dana Pengajuan Pre Payment ! (Tgl Pengajuan: <?php print $o_data[0]['dTglPenyusunX'];?>)</label>
								<?php
								if(trim($o_data[0]['sPosting']) !== "" && intval($o_data[0]['sPosting']) === 1)
									print "<br /><label class=\"text-blue\" style=\"font-size: 22px;\">Rp. ".number_format($o_data[0]['nJumlahDanaPengajuanPrePayment'], 0)."</label>";
								else
								{
									?>
									<input type="text" name="txtJmlDanaPengajuanPrePayment" id="txtJmlDanaPengajuanPrePayment" value="<?php print trim($o_data[0]['nJumlahDanaPengajuanPrePayment']) !== "" ? trim($o_data[0]['nJumlahDanaPengajuanPrePayment']) : "0"; ?>" content-mode="numeric" class="form-control text-bold input-lg" style="font-size: 20px;" readonly/>
									<?php
									}
								?>
								</div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-6 form-group"><label>Jumlah Dana yang terpakai</label>
								<?php
								if(trim($o_data[0]['sPosting']) !== "" && intval($o_data[0]['sPosting']) === 1)
									print "<br /><label class=\"text-red\" style=\"font-size: 22px;\">Rp. ".number_format($o_data[0]['nJumlahDanaTerpakai'], 0)."</label>";
								else
								{
									?>	
									<input type="text" name="txtJmlDanaTerpakai" id="txtJmlDanaTerpakai" value="<?php print trim($o_data[0]['nJumlahDanaTerpakai']) !== "" ? trim($o_data[0]['nJumlahDanaTerpakai']) : "0"; ?>" style="font-size: 20px;" content-mode="numeric" class="form-control bg-red text-bold" readonly/>
								<?php
									}
								?>
								</div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-6 form-group"><label>Kurang/Lebih Dana</label>
								<?php
								if(trim($o_data[0]['sPosting']) !== "" && intval($o_data[0]['sPosting']) === 1)
									print "<br /><label class=\"".(doubleval($o_data[0]['nSisaLebihDanaTerpakai']) < 0 ? "text-warning" : "text-green")."\" style=\"font-size: 22px;\">Rp. ".number_format($o_data[0]['nSisaLebihDanaTerpakai'], 0)."</label>";
								else
								{
									?>	
									<input type="text" name="txtJmlSisa" id="txtJmlSisa" style="font-size: 20px;" value="<?php print trim($o_data[0]['nSisaLebihDanaTerpakai']) !== "" ? trim($o_data[0]['nSisaLebihDanaTerpakai']) : "0"; ?>" content-mode="numeric" class="form-control bg-green text-bold" readonly />
								<?php
									}
								?>
								</div>
							</div>
						</div>
						<div class="row"></div>
							  <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group" id="divKomponen">
							  	<?php
							  		if(trim($o_mode) === "")
							  		{
							  			$a = json_decode($o_data_detail, TRUE);
							  			print $a['oData'];
							  		}
							  	?>
							  </div>
					</div>
				</div>
				<?php
				if($nGroupUserIdSession !== $nGroupUserIdFINANCE)
				{
					?>
						<div class="box-footer no-padding"> 
							<br /> 

							<?php
								if(intval($this->session->userdata('nGroupUserId_fk')) !== 0) //--Admin
								{
									if(trim($o_data[0]['sNIKAtasan']) === trim($this->session->userdata('sUserName')) || intval($this->session->userdata('nGroupUserId_fk')) === 7 /*HRD*/)
									{
										if(intval($o_data[0]['sPosting']) === 0 || trim($o_data[0]['sPosting']) === "")
										{
											print "<button type=\"button\" name=\"cmdApprove\" id=\"cmdApprove\" class=\"btn btn-success\">Approve</button> ";
											print "<button type=\"button\" name=\"cmdReject\" id=\"cmdReject\" class=\"btn btn-danger\">Reject</button> ";
											print "<button type=\"button\" name=\"button-submit\" id=\"button-submit\" class=\"btn btn-default\">Cancel</button>";
										}
									}
									else
									{
										if(intval($o_data[0]['sPosting']) === 0 || trim($o_data[0]['sPosting']) === "")
											print $oButton; 		
										if(trim($o_mode) === "") {
											?>
											<div class="btn-group dropup">
												<button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print Penyelesaian Pre Payment ?</button>
												<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<ul class="dropdown-menu"> 
													<li><a class="cursor-pointer" id="aPrintPenyelesaianNormal">Normal Template</a></li> 
												</ul>
											</div>
											<?php
										}
									}
								}
								else
								{
									if(intval($o_data[0]['sPosting']) === 0 || trim($o_data[0]['sPosting']) === "")
										print $oButton; 
									if(trim($o_mode) === "") {
										?>
										<div class="btn-group dropup">
											<button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print Penyelesaian Pre Payment ?</button>
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
												<span class="caret"></span>
												<span class="sr-only">Toggle Dropdown</span>
											</button>
											<ul class="dropdown-menu"> 
												<li><a class="cursor-pointer" id="aPrintPenyelesaianNormal">Normal Template</a></li> 
											</ul>
										</div>
										<?php
									}
								}
							?> 
						</div> 
				<?php
				}
				?>
				<input type="hidden" name="hideMode" id="hideMode" value="" /> 
				<input type="hidden" name="hideModeAR" id="hideModeAR" value="" /> 
				<input type="hidden" name="hideGlobalReffId" id="hideGlobalReffId" value="<?php print $o_data[0]['sUUIDPenyelesaian']; ?>" /> 
			</form> 
		</div> 
		<div id="tab_4" class="tab-pane"> 
			<div id="div-cetak-ope">	
				<div class="row">
					<div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 form-group"><label>Tgl Penyusun Awal</label>
						<div class="input-group date">
						  <input placeholder="Tgl Terima BS Awal" name="txtTgl1" value="<?php print date('d/m/Y'); ?>" id="txtTgl1" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
				  </div>
				  <div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 form-group"><label>Tgl Penyusun Akhir</label>
						<div class="input-group date">
						  <input placeholder="Tgl Terima BS Akhir" name="txtTgl2" value="<?php print date('d/m/Y'); ?>" id="txtTgl2" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
				  </div>
					<div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 form-group"><label>Last Status</label>
						<select name="selReportStatus" id="selReportStatus" placeholder="Report Mode" allow-empty="false" class="form-control selectpicker" data-size="8" data-live-search="true">
							<option value="SUBMIT_BY_ME">SUBMIT BY ME</option>
							<option value="APPROVE_BY_ATASAN">APPROVE BY ATASAN</option>
							<option value="REJECT_BY_ATASAN">REJECT BY ATASAN</option>
							<option value="APPROVE_BY_HRD">APPROVE BY HRD</option>
							<option value="REJECT_BY_HRD">REJECT BY HRD</option>
							<option value="POSTING_BY_HRD">POSTING BY HRD</option>					
						</select>
				  </div>				  
					<div class="row"></div>
					<div class="col-sm-4 col-xs-12 col-md-3 col-lg-2">
						<div clas="row">
					    <button type="button" class="btn btn-primary" name="cmdSearch" id="cmdSearch">Search</button>
						</div>
					</div>				 
					<div class="row"></div> 	
			    <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12" id="divPick" style="margin-top: 10px;">
			    </div>
				</div>
			</div> 
		</div> 
		<div id="tab_5" class="tab-pane <?php print intval($oData['oData']) > 0 && trim($o_data[0]['nIdPenyelesaianBS']) === "" ? "active" : ""; ?>"> 
			<div id="divListPengajuanPrePaymentStaff">	
			</div> 
		</div> 
	</div> 
</div> 

<script> 
var uploader = null;
$(function() 
{ 
	$("input[content-mode='numeric']").autoNumeric('init', {mDec: '0'}).addClass("text-right"); 
	$('.input-group.date').datepicker({ autoclose: true, format: "dd/mm/yyyy", }).on("hide", function()
	{
		if($(this).find("input").attr("id") === "txtTglKegSelesai")
			gf_calculate_tgl_penyelesaian_pre_payment();
		gf_calculate_date_diff();
	});
	$("button[id='button-submit']").click(function() {
		if ($.trim($(this).html()) === "Cancel")
			$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
		else {
			var bNext = true;
			var objForm = $("#form_5ca2dcddb1a39");
			//------------------------------------------ 
			if ($.trim($(this).html()) === "Save")
				$("#hideMode").val("I");
			else if ($.trim($(this).html()) === "Update")
				$("#hideMode").val("U");
			else if ($.trim($(this).html()) === "Delete")
				$("#hideMode").val("D");
			//------------------------------------------ 
			if (parseInt($.inArray($.trim($("#hideMode").val()), ["I", "U"])) !== -1) {
				var oRet = $.gf_valid_form({
					"oForm": objForm,
					"oAddMarginLR": true,
					oObjDivAlert: $("#div-top")
				});
				bNext = oRet.oReturnValue;
			}
			//--Check attachment klo belum ada maka tidak boleh submit data
			if($("a[id='aRealFileName']").length === 0) {
				$.gf_msg_info({oAddMarginLR: false, oMessage: "<b>Bukti konfirmasi Penyelesaian Prepayment belum di Upload !. Silahkan Upload bukti Penyelesaian Prepayment untuk melanjutkan Proses selanjutnya dan pastikan file yang di upload sudah benar serta bisa dipertanggungjawabkan.</b>", oObjDivAlert: $("#div-top")});
				$("input[type='text']").trigger("blur");
				bNext = false;
				return false;
			}
			if (!bNext)
				return false;
			//------------------------------------------ 
			uploader.start();
		}
	}); 
	$("#cmdSearch").on("click", function()
	{
		var oForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_penyelesaian_pre_payment/gf_load_data_pick/"});

		var sTgl1 = $.trim($("#txtTgl1").val()).split("/");
		sTgl1 = sTgl1[2]+"-"+sTgl1[1]+"-"+sTgl1[0];
		var sTgl2 = $.trim($("#txtTgl2").val()).split("/");
		sTgl2 = sTgl2[2]+"-"+sTgl2[1]+"-"+sTgl2[0];

		oForm.append("<input type=\"hidden\" name=\"selReportName\" id=\"selReportName\" value=\"PengajuanPrePayment.wrpt\" />");
		oForm.append("<input type=\"hidden\" name=\"sTglAwal\" id=\"@sTglAwal\" value=\""+$.trim(sTgl1)+"\" />");
		oForm.append("<input type=\"hidden\" name=\"sTglAkhir\" id=\"@sTglAkhir\" value=\""+$.trim(sTgl2)+"\" />");
		oForm.append("<input type=\"hidden\" name=\"sExportMode\" id=\"sExportMode\" value=\""+$("#selReportMode").find("option:selected").val()+"\" />");
		oForm.append("<input type=\"hidden\" name=\"nUserId\" id=\"nUserId\" value=\""+$.trim("<?php print $this->session->userdata('nUserId'); ?>")+"\" />");
		oForm.append("<input type=\"hidden\" name=\"sLastStatus\" id=\"sLastStatus\" value=\""+($.trim($("#selReportStatus").find("option:selected").val()))+"\" />");

		$.gf_custom_ajax({"oForm": oForm,  
		"success": function(r)
		{
			$("#divPick").html(r.oRespond);
			$.gf_remove_all_modal(); 
		}, 
		"validate": true,
		"beforeSend": function(r) {
			$("#divPick").html("<center><i class=\"fa fa-cog fa-spin fa-3x fa-fw text-blue\" /></i><br />Loading Data...</center>")
		},
		"beforeSendType": "custom", 
		"error": function(r) {} 
		}); 
	});
	$('.input-group.date').datepicker({ autoclose: true, format: "dd/mm/yyyy", });
	$("button[id='cmdApprove'], button[id='cmdReject']").on("click", function()
	{
		var sModeAR = $.trim($(this).text());
		if($.trim($("#txtIdPenyelesaianPP").val()) === "(AUTO)")
		{
			$.gf_msg_info({oAddMarginLR: true, oMessage: "Id Transaksi Penyelesaian tidak ditemukan. Pilih Id Penyelesaian melalui List !", oObjDivAlert: $("#div-top")});
			return false;
		}

		var oButton = $(this);
		var oMsg = "<p id=\"pInfo\" class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><p>Do you really want to <span class=\'text-green\'><b>"+$(this).text()+"</b></span> this Pre Payment ?. Click Confirm to Approve button to continue this Process and click Cancel to return to Form.<br /><div class=\"row\"><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\"><label>Notes:</label><textarea class=\"form-control\" name=\"txtReason\" id=\"txtReason\" maxlength=\"100\"></textarea></div></div><b>Warning: </b><br />After this operation you can\'t modified anythings in this Pre Payment !</p></p>";
		if(parseInt("<?php print intval($this->session->userdata('nGroupUserId_fk')); ?>") === parseInt("<?php print $nGroupUserIdHRD; ?>") && $.trim($(this).text()) === "Approve") //-- HR
		{
			oMsg += "<button type=\"button\" name=\"cmdPosting\" id=\"cmdPosting\" class=\"btn-lg btn btn-block btn-danger\">Posting Pre Payment !</button><br /><div id=\"pInfo\" class=\"form-group bg-warning text-center\" style=\"padding: 6px;\"><b>If you click Posting Pre Payment button, next you can't change anythings !</b></div>";
		}

		var oDialog = BootstrapDialog.show({
			type: BootstrapDialog.TYPE_DEFAULT,
            title: 'Information',
            closable: false,
            message: oMsg,            
            buttons: [{
            		id: 'cmdOkay',
                label: 'Submit',
                cssClass: 'btn-primary',
                action: function(dialog) {
									if($.trim($("textarea[id='txtReason']").val()) === "")
                	{
                		$.gf_msg_info({oAddMarginLR: false, oMessage: "<b>Notes</b> can't empty !", oObjDivAlert: $("#pInfo")});
                		return false;
                	}
                	else
                	{
		              	var $button = this; 
		              	$button.disable();
	                  $button.spin();
				            dialog.getModalFooter().find("button[id='cmdCancel']").addClass("disabled").unbind("click");
				            //------------------------------------------------------------------------------------------
				            var objForm = $("#form_5ca2dcddb1a39"); 
										//------------------------------------------ 
										$("#hideMode").val("U"); 
										$("#hideModeAR").val(sModeAR); 
										//------------------------------------------ 
				            $.gf_custom_ajax({"oForm": objForm,  
										"success": function(r)
										{
											var JSON = $.parseJSON(r.oRespond); 
											if(JSON.status === 1) 
											{
											  var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_penyelesaian_pre_payment/gf_operation/"});
											  objForm.append("<input type=\"hidden\" name=\"hideStatus\" id=\"hideStatus\" value=\""+$.trim(oButton.html()).toString().toUpperCase()+"\" />");
											  objForm.append("<input type=\"hidden\" name=\"hideNotes\" id=\"hideNotes\" value=\""+$.trim($("#txtReason").val())+"\" />");
											  objForm.append("<input type=\"hidden\" name=\"hideIdPenyelesaianBS\" id=\"hideIdPenyelesaianBS\" value=\""+$.trim($("#txtIdPenyelesaianPP").val())+"\" />");
											  objForm.append("<input type=\"hidden\" name=\"hideIdPengajuanBS\" id=\"hideIdPengajuanBS\" value=\""+$.trim($("#hideIdPengajuanBS ").val())+"\" />");
											  objForm.append("<input type=\"hidden\" name=\"hideNIKAtasan\" id=\"hideNIKAtasan\" value=\""+$.trim($("#selAtasan").val())+"\" />");
											  objForm.append("<input type=\"hidden\" name=\"hideTrackingMode\" id=\"hideTrackingMode\" value=\"PENYELESAIAN_PRE_PAYMENT\" />");

											  if($("button[id='cmdPosting']").hasClass("btn-success"))
													objForm.append("<input type=\"hidden\" name=\"hideStatusLock\" id=\"hideStatusLock\" value=\"1\" />");					
												else
													objForm.append("<input type=\"hidden\" name=\"hideStatusLock\" id=\"hideStatusLock\" value=\"0\" />");					

											  $.gf_custom_ajax({"oForm": objForm,  
												"success": function(r)
												{
													var JSON = $.parseJSON(r.oRespond); 
													if(JSON.status === 1) {
														$.gf_remove_all_modal(); 
														oDialog.close();
														$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
													}
													else
													{
														$.gf_remove_all_modal(); 
														$.gf_msg_info({oObjDivAlert: $("#pInfo"), oMessage: JSON.message});
														$button.enable();
											      $button.stopSpin();
											      oDialog.getModalFooter().find("button[id='cmdCancel']").removeClass("disabled").on("click", function()
											      {
											      	oDialog.close();
											      });
													}
												}, 
												"validate": true,
												"beforeSend": function(r) {},
												"beforeSendType": "custom", 
												"error": function(r) {} 
												}); 
											}
											else
											{
												$.gf_remove_all_modal(); 
												$.gf_msg_info({oObjDivAlert: $("#pInfo"), oMessage: JSON.message});
												$button.enable();
			                  $button.stopSpin();
						            oDialog.getModalFooter().find("button[id='cmdCancel']").removeClass("disabled").on("click", function()
						            {
						            	oDialog.close();
						            });
											}
										}, 
										"validate": true,
										"beforeSend": function(r) {},
										"beforeSendType": "custom", 
										"error": function(r) {} 
										}); 
									}
			            //------------------------------------------------------------------------------------------
                }
            }, {
            		id: 'cmdCancel',
                label: 'Cancel',
                hotkey: 27,
                action: function(dialog) {
                    dialog.close();
                }
            }],
            onshown: function(dialog)
            {
            	$("#txtReason").focus();
            	$("button[id='cmdPosting']").on("click", function()
            	{
            		$(this).effect( "bounce", "slow", function()
								{
	            		if($(this).hasClass("btn-danger"))
	            			$(this).removeClass("btn-danger").addClass("btn-success").html("<i class=\"fa fa-lock\"></i> Posting Pre Payment !");
	            		else
	            			$(this).removeClass("btn-success").addClass("btn-danger").html("Posting Pre Payment !");
	            	});
            	});
            }
        });
		oDialog.open();
	});
	$("#divInfoKaryawan").find("table").find("tr:gt(0)").find("td:eq(0)").removeAttr("style");
	gf_init_plupload();
	$("a[href='#tab_2']").on("click", function()
	{
		gf_load_data_penyelesaian_pre_payment_saya();
	});
	$("a[href='#tab_1']").on("click", function()
	{
		gf_load_data_pengajuan_pre_payment_saya();
	});
	$("a[href='#tab_5']").on("click", function()
	{
		gf_load_data_pengajuan_pre_payment_staff();
	});
	if("<?php print trim($o_data[0]['nJumlahDanaTerpakai']); ?>" === "")
		$("#txtJmlDanaTerpakai").val($("input[id='hideTotalAmount']").val());
	$("#txtJmlDanaTerpakai").on("keyup", function()
	{
		gf_generate_sisa();
	});
	$("a[id='aRemove']").on("click", function()
	{
		$("#form_5ca2dcddb1a39").append("<input type=\"hidden\" name=\"hideStatusRemoveFile\" id=\"hideStatusRemoveFile\" value=\"1\" />");
		$("#form_5ca2dcddb1a39").append("<input type=\"hidden\" name=\"hideUploadId\" id=\"hideUploadId\" value=\""+$("#aFileUploadName").attr("uploadid")+"\" />");
		$("#form_5ca2dcddb1a39").append("<input type=\"hidden\" name=\"hideEncryptFileName\" id=\"hideEncryptFileName\" value=\""+$("#aFileUploadName").attr("encfilename")+"\" />");
		$("#form_5ca2dcddb1a39").append("<input type=\"hidden\" name=\"hidePathFile\" id=\"hidePathFile\" value=\""+$("#aFileUploadName").attr("pathfile")+"\" />");
		$("#form_5ca2dcddb1a39").append("<input type=\"hidden\" name=\"hideUUID\" id=\"hideUUID\" value=\""+$("#aFileUploadName").attr("suuid")+"\" />");
		$("#divUpload").empty();
		$("#aUploadImage").parent().removeClass("hidden");
	});
	$("#aFileUploadName").on("click", function()
	{
		var oForm = $.gf_create_form({action: "<?php print site_url(); ?>c_core_upload/gf_download_file_by_file_name/"});		
		oForm.append("<input type=\"hidden\" name=\"sFileName\" id=\"sFileName\" value=\""+$(this).attr("encfilename")+"\" />");
		oForm.append("<input type=\"hidden\" name=\"sFolder\" id=\"sFolder\" value=\"evidence\" />");		
		oForm.submit();
	});
	$("input[content-mode='numeric']").each(function(i, n)
	{
		$(this).autoNumeric('init',
		{
			mDec: $(this).attr("decimalpoint"), 
			vMax: "9".repeat($(this).attr("maxlength"))}).addClass("text-right"); 
	});
	$("input[id='txtKomponen'], input[id='txtQty']").unbind("keyup").on("keyup", function()
	{
		gf_generate_total();
	});
	$("input[id='txtQty']").unbind("blur").on("blur", function()
	{
		if($.trim($(this).val()) === "")
			$(this).val("1");
		if(parseInt($(this).attr("allow-summary")) === 0)
		{
			if($.trim($(this).val()) !== "" && parseInt($.trim($(this).val())) > 1)
				$(this).val("1");
		}	
		gf_generate_total();
	});
	if("<?php print trim($o_data[0]['nIdPengajuanBS']) === "";?>")
		$("a[data-toggle='tab']:eq(0)").trigger("click");
	if(parseInt("<?php print $o_data[0]['sPosting']; ?>") === 1)
	{
		$("input[id^='txt'], textarea").addClass("disabled").prop("disabled", true);
	}
	gf_load_data_karyawan("<?php print $o_data[0]['sNIK']; ?>");
	$("#tableInfoKaryawan").find("tr:gt(0)").find("td:eq(0)").removeAttr("style");
	$("a[id='aRealFileName']").on("click", function() {
		window.location.href = "<?php print site_url(); ?>" + $(this).attr("pathfile") + "/" + $(this).attr("encfilename")
	});
	$("select").selectpicker('refresh');
	$("#aPrintPenyelesaianNormal").on("click", function() {
		var nPenyelesaianId = parseInt($("#txtIdPenyelesaianPP").val());
		var nIdReport = 3;
		$.gf_print_using_stimulsoft({sURL: $.trim("<?php print site_url(); ?>"), sFieldName: "nIdPenyelesaianBS", sFieldNameValue: nPenyelesaianId, nIdReport: nIdReport, sFieldNameLabel: "Id Penyelesaian Pre Payment", sTitleDialog: "Print Penyelesaian Pre Payment: <b>"+nPenyelesaianId+"</b>"});	
	});
});
function gf_generate_total()
{
	$("#spanTotal").html("0");
	$("#hideTotalAmount").html("0");
	var oSum = 0;
	var oMul = 1;
	var oTot = 0;
	var oTemp1 = 0;
	var oPersenPotongan = 0;
	$.each($("input[id='txtKomponen'][allow-multiply='1']"), function(index, val) 
	{
		if($.trim($(this).val()) !== "")
		{
			if(parseInt($(this).val()) < 0) $(this).val(parseInt($(this).val()) * -1); 
			if(parseInt($(this).parent().parent().find("td:eq(3)").find("input[id='txtQty']").val().replace(/,/g,"")) < 0) $(this).parent().parent().find("td:eq(3)").find("input[id='txtQty']").val(parseInt($(this).parent().parent().find("td:eq(3)").find("input[id='txtQty']").val()) * -1);

			var nQty = parseInt($(this).parent().parent().find("td:eq(3)").find("input[id='txtQty']").val().replace(/,/g,""));
			oPersenPotongan = $.trim($(this).attr("persen-potongan")) === "" ? 0 : (100 - parseFloat($(this).attr("persen-potongan"))) / 100;

			oPersenPotongan = isNaN(oPersenPotongan) || parseFloat(oPersenPotongan) === 0  ? 1 : oPersenPotongan;

			//alert("Qty: " + nQty);
			//alert("Persen Potongan: " + oPersenPotongan);
			//alert("Nominal: " + parseFloat($.trim($(this).val().replace(/,/g,""))));

			var o = (parseFloat($.trim($(this).val().replace(/,/g,""))) * nQty) * oPersenPotongan;
			//alert("Sub Total: " + o);
			$(this).parent().parent().find("td:eq(4)").find("input[id='txtSubTotal']").val(o.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
			$(this).parent().parent().find("td:eq(4)").find("input[id='hideSubTotal']").val(o.toString().replace(/,/g,""));
		}
	});
	$.each($("input[id='txtSubTotal'][allow-summary='1']"), function(index, val) 
	{
		if($.trim($(this).val()) !== "")
		{
			var o = ($.trim($(this).val()) === "" ? 0 : $.trim($(this).val()));
			o = o.replace(/,/g,"");
			oTot += parseFloat(o);
			$("#spanTotal").html(oTot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
			$("#hideTotalAmount").val(oTot);
			$("#txtJmlDanaTerpakai").val(oTot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
			$("#spanGrandTotal").html(oTot.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));

			$("#tdTerbilang").html("Grand Total (<b>" + $.gf_angka_terbilang({angka: oTot.toString()}) + "</b> Rupiah)");
		}
	});
	var nJmlDanaTerpakai = parseFloat($("#txtJmlDanaTerpakai").val().replace(/,/g,""));
	var nJmlDanaPengajuanPrePayment = parseFloat($("#txtJmlDanaPengajuanPrePayment").val().replace(/,/g,""));
	$("#txtJmlSisa").val((nJmlDanaPengajuanPrePayment - nJmlDanaTerpakai).toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
}
function gf_generate_sisa()
{
	if($.trim($("#txtJmlDanaTerpakai").val()) === "" || $.trim($("#txtJmlDanaTerpakai").val()) === "0.00")
		$("#txtJmlSisa").val("0");
	var a = parseFloat($.trim($("#txtJmlDanaTerpakai").val().replace(/,/g,"")));
	var b = parseFloat($.trim($("input[id='hideTotalAmount']").val().replace(/,/g,"")));
	var c = b - a;
	$("#txtJmlSisa").val(c).trigger("blur");
}
function gf_load_data_pengajuan_pre_payment_saya() 
{ 
	$("#divListPengajuanPrePaymentSaya").ado_load_paging_data({url: "<?php print site_url(); ?>c_prepayment_penyelesaian_pre_payment/gf_load_data_pengajuan_pre_payment_saya/"}); 
} 
function gf_load_data_penyelesaian_pre_payment_saya() 
{ 
	$("#divListPenyelesaianPrePayment").ado_load_paging_data({url: "<?php print site_url(); ?>c_prepayment_penyelesaian_pre_payment/gf_load_data_penyelesaian_pre_payment_saya/"}); 
}
function gf_load_data_pengajuan_pre_payment_staff() 
{ 
	$("#divListPengajuanPrePaymentStaff").ado_load_paging_data({url: "<?php print site_url(); ?>c_prepayment_penyelesaian_pre_payment/gf_load_data_pengajuan_pre_payment_staff/"}); 
}
function gf_init_plupload()
{
  var sArrayFile = Array(), sArraySize = Array(), oJSONObj = [], oLength = 25, oAddPath = "evidence";
  var nTextLimit = 80;
	uploader = new plupload.Uploader({
    runtimes : 'html5,flash,silverlight,html4',
    browse_button : 'aUploadImage', 
    divUploadContainer: $("#divUploadContainer"), 
    url : "<?php print site_url(); ?>c_core_upload/gf_upload/",
    chunk_size: '500kb',
    multiple_queues:true,
    multi_selection: false,
    unique_names: true,
    filters : {
        max_file_size : '50mb',
        mime_types: [
            {title : "Compressed files", extensions : "zip,7z,rar"}
        ]
    },
    multipart_params : {
        "oAddPath" : oAddPath
    },
    flash_swf_url : '<?php print site_url(); ?>plugins/jPLUpload/plupload/js/Moxie.swf',
    silverlight_xap_url : '<?php print site_url(); ?>plugins/jPLUpload/plupload/js/Moxie.xap',
    init: 
    {
      PostInit: function() {},
      FilesAdded: function(up, files) 
      {
      	$("#divUpload").removeClass("hidden");
      	$("#divUpload").append("<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><div class=\"row\"><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\"><div class=\"row btn btn-success\"><a style=\"color: #fff;\" id=\"aRealFileName\">File Name: "+$.trim(files[0].name)+"</a></div></div><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\"><div class=\"row\"><a id=\"aRemove\" class=\"btn btn-danger\" href=\"#\" title=\"Remove Attachment\"><i class=\"fa fa-trash\" /> Remove File</a></div></div></div>");
      	$("#divUpload").find("a[id='aRemove']").on("click", function()
      	{
      		$("#aUploadImage").removeClass("hidden");
      		$("#divUpload").empty().addClass("hidden");
      		uploader.removeFile(files[0]);
      		$("#hideRealFileName").remove();
      	});
      	$("#aUploadImage").addClass("hidden");
      }, 
      UploadProgress: function(up, file) 
      {
      	$("#spanProgress").html('<span><b>' + file.percent + "</b>%</span>");
      }, 
      Error: function(up, err) 
      {
      	$("<p>Error: " + err.code + ": " + err.message+"</p>").insertAfter($("#aUploadImage").prev());
      },
      BeforeUpload: function(up, file)
      {
				$.gf_loading_show({sMessage: "Sedang mengupload bukti Konfirmasi Penyelesaian PrePayment. Mohon tunggu beberapa saat.<br /><div class=\"text-center\"><span id=\"spanProgress\"></span></div>"});
      },
      UploadComplete: function(uploader, files)
      {
        var objForm = $("#form_5ca2dcddb1a39"); 
        var sSingleFileName = "";
        objForm.append("<input type=\"hidden\" name=\"hidePath\" id=\"hidePath\" value=\""+$.trim(oAddPath)+"\" />");
        objForm.find("input[id='hideFileName']").remove();
        objForm.find("input[id='hideFileSize']").remove();
        objForm.find("input[id='hideFileHash']").remove();
        $.each(oJSONObj, function(i, n)
				{
					var JSON = $.parseJSON(n.oFile);
      		objForm.append("<input type=\"hidden\" name=\"hideFileName[]\" id=\"hideFileName\" value=\""+$.trim(JSON.fnameoriginal)+"\" />");
      		objForm.append("<input type=\"hidden\" name=\"hideFileSize[]\" id=\"hideFileSize\" value=\""+$.trim(JSON.ffilesize)+"\" />");
      		objForm.append("<input type=\"hidden\" name=\"hideFileHash[]\" id=\"hideFileHash\" value=\""+$.trim(JSON.fnamehash)+"\" />");
      		sSingleFileName = $.trim(JSON.fnameoriginal);
      	});
      	objForm.append("<input type=\"hidden\" name=\"hideRealFileName[]\" id=\"hideRealFileName\" value=\""+$.trim($("#aRealFileName").html())+"\" />");
      	$.gf_custom_ajax({"oForm": objForm,  
				"success": function(r)
				{
					var JSON = $.parseJSON(r.oRespond); 
					if(JSON.status === 1) 
						$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
					else 
					{ 
						$.gf_msg_info({
							oObjDivAlert: $("#div-top"),
							oAddMarginLR: true,
							oMessage: JSON.message
						});
					} 
				}, 
				"validate": true,
				"beforeSend": function(r) {},
				"beforeSendType": "standard", 
				"error": function(r) {} 
				}); 
      },
      FileUploaded: function(upldr, file, object) 
      {
      	var JSON = $.parseJSON(object.response);
      	item = {}
        item["oFile"] = object.response;
        oJSONObj.push(item);
      }
    }
	}); 
	uploader.init();
}
function gf_bind_event()
{
	var oTable = $("#divListPengajuanPrePaymentSaya").find("table");
	oTable.find("tr:gt(0)").find("td:last").find("a").unbind("click").on("click", function()
	{
		var oForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_penyelesaian_pre_payment/gf_exec"});
		oForm.append("<input type=\"hidden\" name=\"Id_Transaksi_Pre_Payment\" id=\"Id_Transaksi_Pre_Payment\" value=\""+$(this).parent().parent().find("td:eq(0)").text()+"\" />");
		oForm.submit();
		//-------------------------------------------------------
	});
}
function gf_bind_event_1()
{
	$("#divPick").find("table").find("tr:gt(0)").find("td:last").find("a").html("Print").unbind("click").on("click", function()
	{
		var nIdReport = 3;
		var nPenyelesaianId = parseInt($.trim($(this).parent().parent().find("input[id='Id Penyelesaian Pre Payment']").val()));
		$.gf_print_using_stimulsoft({sURL: $.trim("<?php print site_url(); ?>"), sFieldName: "nIdPenyelesaianBS", sFieldNameValue: nPenyelesaianId, nIdReport: nIdReport, sFieldNameLabel: "Id Penyelesaian Pre Payment", sTitleDialog: "Print Penyelesaian Pre Payment: <b>"+nPenyelesaianId+"</b>"});	
	});
}
function gf_load_data_karyawan(sNIK)
{
	var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_pengajuan_pre_payment/gf_load_info_karyawan"});
	objForm.append("<input type=\"hidden\" name=\"sNIK\" id=\"sNIK\" value=\""+$.trim(sNIK)+"\" />");
	objForm.append("<input type=\"hidden\" name=\"nIdPengajuanBS\" id=\"nIdPengajuanBS\" value=\"(AUTO)\" />");
	$.gf_custom_ajax({"oForm": objForm,  
	"success": function(r)
	{
		var JSON = $.parseJSON(r.oRespond); 
		if(JSON.oData !== null)
		{
			$("#divInfoKaryawan").html("<div class=\"row table-responsive\"><table class=\"table table-striped\"><tr><td><b>Nama</b></td><td>:</td><td>"+JSON.oData.sNamaKaryawan+"</td></tr><tr><td><b>Atasan</b></td><td>:</td><td>"+JSON.oData.sAtasan+"</td></tr><tr><td><b>Unit Usaha</b></td><td>:</td><td>"+JSON.oData.sNamaUnitUsaha+"</td></tr><tr><td><b>Bagian</b></td><td>:</td><td>"+JSON.oData.sBagian+"</td></tr><tr><td><b>Divisi</b></td><td>:</td><td>"+JSON.oData.sNamaDivisi+"</td></tr><tr><td><b>Departemen</b></td><td>:</td><td>"+JSON.oData.sNamaDepartemen+"</td></tr><tr><td><b>Bank</b></td><td>:</td><td>"+JSON.oData.sNamaBank+"</td></tr><tr><td><b>Cabang</b></td><td>:</td><td>"+JSON.oData.sCabangBank+"</td></tr><tr><td><b>No Rekening</b></td><td>:</td><td>"+JSON.oData.sNoRekening+"</td></tr><tr><td><b>Atas Nama Rekening</b></td><td>:</td><td>"+JSON.oData.sAtasNamaRekening+"</td></tr><tr><td><b>Apps Group User</b></td><td>:</td><td class=\"text-red\">"+JSON.oData.sGroupUser+"</td></tr></table></div>");

			$("#hideGroupUserId").val(JSON.oData.nGroupUserId);

			if("<?php print trim($o_mode); ?>" !== "")
			{
				$("#selPembebananUnitUsaha").find("option[value='"+JSON.oData.nIdUnitUsaha_fk+"']").attr("selected", "selected");
				$("#selPembebananUnitUsaha").selectpicker('refresh');
				$("#selDivisiPembebanan").find("option[value='"+JSON.oData.nIdDivisi_fk+"']").attr("selected", "selected");
				$("#selDivisiPembebanan").selectpicker('refresh');
				$("#selDepartemenPembebanan").find("option[value='"+JSON.oData.nIdDepartemen_fk+"']").attr("selected", "selected");
				$("#selDepartemenPembebanan").selectpicker('refresh');
			}

			$("#txtNamaAtasan").val(JSON.oData.sNamaAtasan);
			$("#hideNIKAtasan").val(JSON.oData.sNIKAtasan);
		}
		else
		{	
			$("#divInfoKaryawan").html("Karyawan tidak ditemukan !.");	
			$("#txtNIK").select().focus();
		}
	}, 
	"validate": true,
	"beforeSend": function(r) {
		$("#divInfoKaryawan").html("Loading...");
	},
	"beforeSendType": "custom", 
	"error": function(r) {} 
	}); 			
}
function gf_calculate_tgl_penyelesaian_pre_payment()
{
	var d1 = $("#txtTglKegSelesai").val().split("/")[1] + "/" + $("#txtTglKegSelesai").val().split("/")[0] + "/" + $("#txtTglKegSelesai").val().split("/")[2];
	var d2 = 7;
	var date = new Date(d1);
  var newdate = new Date(date); 
  newdate.setDate(newdate.getDate() + d2);
  
  var dd = newdate.getDate();
  var mm = newdate.getMonth() + 1;
  var y = newdate.getFullYear();

	console.log((dd.toString().length === 1 ? "0" + dd : dd) + '/' + (mm.toString().length === 1 ? "0" + mm : mm) + '/' + y)

  $("#spanTglPenyelesaianPrepayment").html((dd.toString().length === 1 ? "0" + dd : dd) + '/' + (mm.toString().length === 1 ? "0" + mm : mm) + '/' + y);
  $("#txtTglPenyelesaiPrePayment").val((dd.toString().length === 1 ? "0" + dd : dd) + '/' + (mm.toString().length === 1 ? "0" + mm : mm) + '/' + y)
}
function gf_calculate_date_diff()
{
	var d1 = $("#txtTglKegSelesai").val().split("/")[1] + "/" + $("#txtTglKegSelesai").val().split("/")[0] + "/" + $("#txtTglKegSelesai").val().split("/")[2];
	var d2 = $("#txtTglKegMulai").val().split("/")[1] + "/" + $("#txtTglKegMulai").val().split("/")[0] + "/" + $("#txtTglKegMulai").val().split("/")[2];

	if(d2 > d1)
	{
		$.gf_msg_info({oAddMarginLR: false, oMessage: "<b>Tgl Keg. Selesai (Realisasi)</b> tidak boleh lebih kecil dari <b>Tgl Keg. Mulai</b> !, Periksa kembali Tanggal tersebut !", oObjDivAlert: $("#div-top")});
		$("#txtTglKegSelesai").val($("#txtTglKegMulai").val())
		return false;
	}

	$("input[id='txtQty'][qty-from-kegiatan='1']").each(function(i, n)
	{
		var nCountOfDays = $.gf_date_diff({d1: d2, d2: d1, mode: "d"});
		$(this).val(nCountOfDays);
	});
	$("input[id='txtQty']").each(function(i, n)
	{
		$(this).val($.trim($(this).val()) === "" ? 0 : parseInt($.trim($(this).val())) + parseInt($(this).attr("qty-penyesuaian")))
	});
	gf_generate_total();
}
</script>