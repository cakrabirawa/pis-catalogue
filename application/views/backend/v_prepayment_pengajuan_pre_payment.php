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

?> 
<div class="nav-tabs-custom"> 
	<ul class="nav nav-tabs" id="navLink"> 
		<?php
			$oData = json_decode($o_punya_anak_buah, true);			
			$nGroupUserIdSession = intval($this->session->userdata('nGroupUserId_fk'));
			if($nGroupUserIdSession !== 0)
			{
				if($nGroupUserIdSession !== $nGroupUserIdHRD && $nGroupUserIdSession !== $nGroupUserIdFINANCE)
				{
					if(intval($oData['oData']) > 0) //--Punya anak buah
					{
						?>
							<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_4"><b class="text-red">List Pengajuan Pre Payment | STAFF</b></a></li> 
						<?php
					}
					?>
					<li class=""><a data-toggle="tab" href="#tab_1"><b class="text-green">List Pengajuan Pre Payment | SAYA</b></a></li> 
					<?php
				}
				else
				{
					?>
					<li class=""><a data-toggle="tab" href="#tab_5"><b class="text-green">List Pengajuan Pre Payment | HRD Approval</b></a></li> 
					<?php
				}
			}
		?>
		<li class="<?php print count($o_data[0]) > 0 ? "active" : "" ?>"><a data-toggle="tab" href="#tab_2">Form Pengajuan Pre Payment</a></li> 
		<li class=""><a data-toggle="tab" href="#tab_3">Report Pengajuan Pre Payment</a></li>
	</ul> 
	<div class="tab-content"> 
		<div id="tab_5" class="tab-pane"> 
			<div id="divListPengajuanPrePaymentApprovalHRD">	
			</div> 
		</div> 
		<div id="tab_1" class="tab-pane"> 
			<div id="divListPengajuanPrePaymentSaya">	
			</div> 
		</div> 
		<div id="tab_4" class="tab-pane <?php print intval($oData['oData']) > 0 && $nGroupUserIdSession !== $nGroupUserIdHRD ? "active" : "" ?>"> 
			<div id="divListPengajuanPrePaymentStaff">	
			</div> 
		</div> 
		<div id="tab_2" class="tab-pane <?php print trim($o_mode) === "" ? "active" : "" ?>"> 
			<form id="form_5ca2dcddb1a39" role="form" action="<?php print site_url(); ?>c_prepayment_pengajuan_pre_payment/gf_transact" method="post"> 
				<div class="box-body no-padding"> 
					<div class="row">
						<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12" id="div-top">
							<p class="bg-warning" style="border: solid 2px #ffcc99; padding: 8px; margin-bottom: 10px;">
								<b>Perhatian  !</b><br />
								1. Isilah dengan jelas, asli untuk cash bank copy untuk penyusun.<br />
								2. BS ini harus dipertanggung jawabkan, selambat-lambatnya 7(tujuh) hari setelah diuangkan. Bila lewat waktu, pengambilan BS berikutnya akan ditolak, kecuali ada penjelasan dari kepala unit bersangkutan.<br />
								3. Untuk dinas luar kota dan luar negeri harus diberikan laporan pertanggung jawaban yang sudah diotorisasi oleh Ka Luar Negeri selambat-lambatnya 7(tujuh) hari setelah masuk kerja.<br />
								4. Bila butir 2 dan 3 tidak ditepati, maka gaji, bonus dan gratifikasi ditahan sampaiBS diselesaikan.<br />
								5. Jika nama pemakai dana tidak dicantumkan, maka penyusun bertanggung jawab atas pemakaian dana tersebut.<br />
								6. <b>Periksa kembali NIK Atasan Anda sebelum menyimpan Transaksi pengajuan pre payment ini. Jika NIK Atasan tidak sesuai, Anda dapat mengganti nya dengan mengklik tombol <i class="fa fa-search text-red"></i> pada bagian Nama TTD Atasan (Approval User)</b>

								<?php //print_r($this->session->userdata()); ?>
							</p>
						</div>
						<div class="col-sm-12 col-xs-12 col-md-8 col-lg-8">
							<div class="row">
								<div class="hidden"><label>Id Transaksi Pre Payment</label><input allow-empty="false" type="text" placeholder="Id Transaksi Pre Payment" name="txtnIdTransaksiPrePayment" id="txtnIdTransaksiPrePayment" class="form-control" maxlength="10" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nIdPengajuanBS']); ?>" readonly>
								</div>
								<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 form-group"><label>No Penyusun</label><input allow-empty="false" type="text" placeholder="No Penyusun" name="txtNoPenyusun" id="txtNoPenyusun" class="form-control" maxlength="20" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nIdPengajuanBS']); ?>" readonly>
									<input type="hidden" name="txtNoPenyusunlOld" id="txtNoPenyusunlOld" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nIdPengajuanBS']); ?>"/>
							  </div>
								<div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Tgl Penyusun</label><input readonly value="<?php print trim($o_mode) === "I" ? date('d/m/Y') : trim($o_data[0]['dTglPenyusunX']); ?>" allow-empty="false" placeholder="Tgl Penyusun" name="txtTglPenyusun" id="txtTglPenyusun" type="text" class="form-control">
							  </div>
							  <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 form-group"><label>Cara Bayar</label><select name="selCaraBayar" placeholder="Cara Bayar" allow-empty="false" id="selCaraBayar" class="form-control selectpicker" data-size="8" data-live-search="true">
			            	<?php print $o_cara_bayar; ?></select>
							  </div>
								<div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Tgl Keg. Mulai</label><div class="input-group date"><input value="<?php print trim($o_mode) === "I" ? date('d/m/Y') : trim($o_data[0]['dTglKegiatanAwalX']); ?>" allow-empty="false" placeholder="Tgl Keg. Mulai" name="txtTglKegMulai" id="txtTglKegMulai" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
							  </div>
								<div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Tgl Keg. Selesai</label><div class="input-group date"><input value="<?php print trim($o_mode) === "I" ? date('d/m/Y') : trim($o_data[0]['dTglKegiatanAkhirX']); ?>" allow-empty="false" placeholder="Tgl Keg. Selesai" name="txtTglKegSelesai" id="txtTglKegSelesai" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									</div>
							  </div>
								<div class="col-sm-12 col-xs-12 col-md-5 col-lg-4 form-group"><label>Tgl Penyelesaian Pre Payment</label><input allow-empty="false" type="text" placeholder="Tgl Penyelesaian Pre Payment" name="txtTglPenyelesaiPrePayment" id="txtTglPenyelesaiPrePayment" class="form-control" readonly maxlength="20" value="<?php print trim($o_data[0]['dTglPenyelesaianPrePaymentX']); ?>">
							  </div>
							  <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 form-group"><label>Kelompok Usaha Pemesan</label><select name="selKelompokUsahaPenyusun" placeholder="Kelompok Usaha Pemesan" allow-empty="false" id="selKelompokUsahaPenyusun" class="form-control selectpicker" data-size="8" data-live-search="true">
			            	<?php print $o_kel_unit_usaha; ?></select>
							  </div>
							  <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 form-group"><label>Di Bebankan pada Unit Usaha</label><select name="selPembebananUnitUsaha" placeholder="Pembebanan Unit Usaha" allow-empty="false" id="selPembebananUnitUsaha" class="form-control selectpicker" data-size="8" data-live-search="true">
			            	<?php print $o_unit_usaha; ?></select>
							  </div>
							  <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 form-group"><label>Divisi Pembebanan</label><select name="selDivisiPembebanan" placeholder="Divisi Pembebanan" allow-empty="false" id="selDivisiPembebanan" class="form-control selectpicker" data-size="8" data-live-search="true">
							  	<?php
							  			print $o_divisi;
							  	?>
			           </select>
							  </div>
							  <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 form-group"><label>Departmen Pembebanan</label><select name="selDepartemenPembebanan" placeholder="Departmen Pembebanan" allow-empty="false" id="selDepartemenPembebanan" class="form-control selectpicker" data-size="8" data-live-search="true">
							  	<?php
							  			print $o_departemen;
							  	?>
			            	</select>
							  </div>
							  <div class="col-sm-8 col-xs-12 col-md-4 col-lg-4"><label class="text-red">Nama TTD Penyusun</label><input allow-empty="false" type="text" placeholder="Nama Penyusun" name="txtNamaPenyusun" id="txtNamaPenyusun" readonly class="form-control" maxlength="20" value="<?php print strtoupper(trim($o_mode) === "I" ? $this->session->userdata('sRealName')." (".$this->session->userdata('sUserName').")" : $o_data[0]['sNamaPenyusun']); ?>">
							  </div>
							  <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 form-group"><label class="text-red">Nama TTD Atasan (Approval User)</label>
										<?php
											if(trim($this->session->userdata('sUserName')) !== trim($o_data[0]['sNIKAtasan'])) {
												?>
												<div class="input-group">
													<input type="text" name="txtNamaAtasan" readonly id="txtNamaAtasan" class="form-control" value="<?php print trim($o_data[0]['sNamaAtasan']); ?>"/>
													<span id="spanBrowseAtasan" class="input-group-addon cursor-pointer" id="basic-addon2" title="Klik disini jika ingin mengganti atasan untuk Approval !"><i class="fa fa-search"></i></span>
												</div>
												<?php
											}
											else {
												?>
													<input type="text" name="txtNamaAtasan" readonly id="txtNamaAtasan" class="form-control" value="<?php print trim($o_data[0]['sNamaAtasan']); ?>"/>
												<?php
											}
										?>
								</div>
							  <div class="row"></div>
			          <input type="hidden" name="hideNIKAtasan" id="hideNIKAtasan" value="<?php print trim($o_data[0]['sNIKAtasan']); ?>"/>
								<!--<div class="col-sm-4 col-xs-12 col-md-4 col-lg-4 form-group"><label>Status Pre Payment</label><br /><input class="form-control text-center" type="text" name="txtStatusDokumen" id="txtStatusDokumen" value="DRAFT" readonly="">
							  </div>-->
							  <?php
							  	if(trim($o_data[0]['sCreateBy']) !== "")
							  	{
							  		?>
											<div class="row"></div>
										  <div class="col-sm-8 col-xs-12 col-md-8 col-lg-12"><br /><label>Informasi Transfer</label><br />Nama Bank: <b><?php print trim($o_data[0]['sNamaBank']); ?></b>, Cabang Bank: <b><?php print trim($o_data[0]['sCabangBank']); ?></b>, No Rekening: <b><?php print trim($o_data[0]['sNoRekening']); ?></b>, Atas Nama Rekening: <b><?php print trim($o_data[0]['sAtasNamaRekening']); ?></b><br />&nbsp;
											</div>
										  <div class="row"></div>
										  <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12"><div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group bg-success" style="border: solid 1px rgb(117, 190, 86);"><br /><label>Last Status Pre Payment</label><br /><?php print trim($o_data[0]['sLastStatus']) === "" ? "Created By <b>".trim($o_data[0]['sCreateBy'])."</b> at <b>".trim($o_data[0]['dCreateOnX'])."</b>" : trim($o_data[0]['sLastStatus']); ?><br />&nbsp;
										  </div></div>
								<?php
									}
								?>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Kategori Pre Payment</label><select name="selKategoriPrePayment" placeholder="Kategori Pre Payment" allow-empty="false" id="selKategoriPrePayment" class="form-control selectpicker" data-size="8" data-live-search="true">
			            	<?php print $o_kategori_pre_payment; ?></select>
							  </div>
							  <div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Pembayaran Untuk</label><textarea placeholder="Pembayaran Untuk" rows="2" name="txtDeskripsi" allow-empty="false" id="txtDeskripsi" class="form-control" maxlength="200" style="max-height: 200px;"><?php print preg_replace('/<br\\s*?\/??>/i', '', trim($o_data[0]['sDeskripsi'])); ?></textarea>
								</div>
							</div> 
						</div>
						<div class="col-sm-12 col-xs-12 col-md-4 col-lg-4">
							<div class="row">
								<!--
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>NIK</label><select name="txtNIK" placeholder="NIK" allow-empty="false" id="txtNIK" class="form-control selectpicker" data-size="8" data-live-search="true">
			            	<?php print $o_nik; ?></select>
							  </div>
								-->
								<div class="col-sm-12 col-xs-12 col-md-10 col-lg-12 form-group hidden">
									<center>
										<img src="<?php print site_url(); ?>img/img-user.png" class="img-responsive" style="max-width: 100px" />
									</center>
								</div>
								<div class="col-sm-12 col-xs-12 col-md-10 col-lg-12 form-group hidden"><label>NIK Karyawan</label>
		              <?php
		              	if(intval($this->session->userdata('nGroupUserId_fk')) === 0)
		              	{
		              		?>
					              <div class="input-group">
					                <input type="text" class="form-control" value="<?php print trim($o_data[0]['sNIK']); ?>" id="txtNIK" name="txtNIK" placeholder="NIK" allow-empty="false">
					                <div class="input-group-btn">
					                  <button class="btn btn-default" type="button" id="cmdLookupKaryawan">
					                    <i class="glyphicon glyphicon-search"></i>
					                  </button>
					                </div>
					              </div>
					          <?php
					        }
					        else
					        {
					        	?>
					        		<input type="text" readonly class="form-control" value="<?php print trim($o_mode) === "I" && $nGroupUserIdSession !== $nGroupUserIdHRD ? trim($this->session->userdata('sUserName')) : trim($o_data[0]['sNIK']); ?>" id="txtNIK" name="txtNIK" placeholder="NIK" allow-empty="false">
					        	<?php
					        }
					      ?>
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
											$s = "<div class=\"row table-responsive\"><table class=\"table table-striped\"> id=\"tableInfoKaryawan\">";
											$s .= "<tr><td class=\"text-left\"><b>Nama</b></td><td>:</td><td>".trim($o_data[0]['sNamaKaryawan'])." (".trim($o_data[0]['sNIK']).")</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Atasan</b></td><td>:</td><td>".trim($o_data[0]['sAtasan'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Unit Usaha</b></td><td>:</td><td>".trim($o_data[0]['sNamaUnitUsaha'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Jabatan</b></td><td>:</td><td>".trim($o_data[0]['sBagian'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Divisi</b></td><td>:</td><td>".trim($o_data[0]['sNamaDivisi'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Departemen</b></td><td>:</td><td>".trim($o_data[0]['sNamaDepartemen'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Bank</b></td><td>:</td><td>".trim($o_data[0]['sNamaBank'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Cabang</b></td><td>:</td><td>".trim($o_data[0]['sCabangBank'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>No Rekening</b></td><td>:</td><td>".trim($o_data[0]['sNoRekening'])."</td></tr>";
											$s .= "<tr><td class=\"text-left\"><b>Atas Nama Rekening</b></td><td>:</td><td>".trim($o_data[0]['sAtasNamaRekening'])."</td></tr>";
											$s .= "<tr><td><b>Apps Group User</b></td><td>:</td><td class=\"text-red\">".trim($o_data[0]['sGroupUser'])."</td></tr>";
											$s .= "</table></div>	";
											print $s;
										}				
										?>
									</div>
								</div>	
							</div>
						</div>	
					</div>
					<div class="row"></div>
					<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12" id="divKomponen">
						<div class="row">
							<?php
								if(trim($o_mode) === "")
								{
									$a = json_decode($o_data_detail, TRUE);
									print $a['oData'];
								}
							?>
						</div>
					</div>
					<!--<div class="row"></div>
					<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
						<div class="row">
							<h2 class="bg-success" style="border-left: solid 10px rgb(117, 190, 86); padding: 10px; margin-bottom: 10px;  margin-top: -15px;"><i class="fa fa-money"></i> Total Biaya: Rp. <b><span id="spanTotal" style="text-decoration: underline;">0</span></b></h2>
						</div>
					</div>-->
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
										if(trim($o_data[0]['sNIKAtasan']) === $this->session->userdata('sUserName') || intval($this->session->userdata('nGroupUserId_fk')) === 7 /*HRD*/)
										{
											print "<button type=\"button\" name=\"cmdApprove\" id=\"cmdApprove\" class=\"btn btn-success\">Approve</button> ";
											print "<button type=\"button\" name=\"cmdReject\" id=\"cmdReject\" class=\"btn btn-danger\">Reject</button> ";
											print "<button type=\"button\" name=\"button-submit\" id=\"button-submit\" class=\"btn btn-default\">Cancel</button>";
										}
										else
											print $oButton; 	
										if(trim($o_mode) === "") {
											?>
											<div class="btn-group dropup">
												<button type="button" class="btn btn-default"><i class="fa fa-print"></i> Print Pengajuan Pre Payment ?</button>
												<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<span class="caret"></span>
													<span class="sr-only">Toggle Dropdown</span>
												</button>
												<ul class="dropdown-menu"> 
													<li><a class="cursor-pointer" id="aPrintPengajuanNormal">Normal Template</a></li> 
													<li role="separator" class="divider"></li> 
													<li><a class="cursor-pointer" id="aPrintPengajuanBS">BS Template</a></li> 
												</ul>
											</div>
											<?php
										}	
									}
									else
										print $oButton; 
								?> 
							</div> 
				<?php
					}
				?>
				<input type="hidden" name="hideMode" id="hideMode" value="" /> 
				<input type="hidden" name="hideModeAR" id="hideModeAR" value="" /> 
				<input type="hidden" name="hideGroupUserId" id="hideGroupUserId" value="<?php print $o_data[0]['nGroupUserId_fk']; ?>" /> 
				<input type="hidden" name="hideTotalAmount" id="hideTotalAmount" value="<?php print trim($o_data[0]['nTotalAmount']) !== "" ? number_format(trim($o_data[0]['nTotalAmount']), 0) : ""; ?>"/>
			</form> 
		</div> 
		<div id="tab_3" class="tab-pane"> 
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
						</select>
				  </div>	
					<!--			  
					<?php
						if(intval($this->session->userdata('nGroupUserId')) === intval($o_extra['o_config']['HRD_GROUP_ID']) || intval($this->session->userdata('nGroupUserId')) === intval($o_extra['o_config']['ADMIN_GROUP_ID']))
						{
							?>
								<div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 form-group"><label>Nama Penyusun</label>
								<input placeholder="Nama Penyusun" name="txtNamaPenyusunCustom" value="<?php print $o_extra['o_config']['DEFAULT_PENYUSUN']; ?>" id="txtNamaPenyusunCustom" type="text" class="form-control">
								</div>
								<div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 form-group"><label>Nama Atasan</label>
								<input placeholder="Nama Atasan" name="txtNamaAtasanCustom" value="<?php print $o_extra['o_config']['DEFAULT_DIRKEL']; ?>" id="txtNamaAtasanCustom" type="text" class="form-control">
								</div>
							<?php
						}
					?>-->
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
	</div> 
</div> 
<script> 
$(function() 
{ 
	$('.input-group.date').datepicker({ autoclose: true, format: "dd/mm/yyyy", }).on("hide", function()
	{
		if($(this).find("input").attr("id") === "txtTglKegSelesai")
			gf_calculate_tgl_penyelesaian_pre_payment();
		gf_calculate_date_diff();
	});
	$("button[id='button-submit']").click(function() 
	{ 
		if($.trim($(this).html()) === "Cancel") 
			$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
		else 
		{ 
			var bNext = true; 
			var objForm = $("#form_5ca2dcddb1a39"); 
			//------------------------------------------ 
			if($.trim($(this).html()) === "Save") 
				$("#hideMode").val("I"); 
			else if($.trim($(this).html()) === "Update") 
				$("#hideMode").val("U"); 
			else if($.trim($(this).html()) === "Delete") 
				$("#hideMode").val("D"); 
			//------------------------------------------ 
			if(parseInt($.inArray($.trim($("#hideMode").val()), ["I", "U"])) !== -1) 
			{ 
				var oRet = $.gf_valid_form({"oForm": objForm, "oAddMarginLR": true, oObjDivAlert: $("#div-top")}); 
				bNext = oRet.oReturnValue; 
				} 
			if(!bNext) 
				return false; 
			//------------------------------------------ 
			gf_generate_total();
			//------------------------------------------ 
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
		} 
	}); 
	$("#cmdSearch").on("click", function()
	{
		var oForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_pengajuan_pre_payment/gf_load_data_pick/"});

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
	$("#selKategoriPrePayment").on("change", function()
	{
		if($.trim($("#txtNIK").val()) === "")
		{
			$.gf_custom_notif({oObjDivAlert: $("#div-top"), sMessage: "NIK belum dimasukan !", oAddMarginLR: true});
			$(this).find("option:eq(0)").prop("selected", true);
			$(this).selectpicker('refresh');
			return false;
		}

		$("#divKomponen").empty();
		$("#spanTotal").html("0");

		$("#nIdKategoriPrePayment").remove();
		$("#nGroupUserId").remove();

		if($.trim($(this).val()) !== "")
		{
			var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_pengajuan_pre_payment/gf_load_komponen_pre_payment"});
			objForm.append("<input type=\"hidden\" name=\"nIdKategoriPrePayment\" id=\"nIdKategoriPrePayment\" value=\""+$.trim($(this).val())+"\" />");
			objForm.append("<input type=\"hidden\" name=\"nGroupUserId\" id=\"nGroupUserId\" value=\""+$.trim($("#hideGroupUserId").val())+"\" />");
			$.gf_custom_ajax({"oForm": objForm,  
			"success": function(r)
			{
				var JSON = $.parseJSON(r.oRespond); 
				$("#divKomponen").html("<div class=\"row\">" + JSON.oData + "</div>").fadeIn("fast", function()
				{
					$("select").selectpicker('refresh');
					$("#divKomponen").find("table").find("tr td").css("vertical-align", "middle");
					$("input[content-mode='numeric']").each(function(i, n)
					{
						$(this).autoNumeric('init', {mDec: '0', vMax: "9".repeat($(this).attr("maxlength"))}).addClass("text-right"); 
					});
					$('.input-group.date').datepicker({ autoclose: true, format: "dd/mm/yyyy", });
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
							{
								$(this).val("1");
								gf_generate_total();
							}
						}	
					});
					gf_calculate_date_diff();
				});
			}, 
			"validate": true,
			"beforeSend": function(r) {
				$("#divKomponen").html("<div class=\"text-center\"><i class=\"fa fa-cog fa-spin\"></i> Loading...</div>");
			},
			"beforeSendType": "custom", 
			"error": function(r) {} 
			}); 
		}
	});	
	$("#txtTglKegSelesai").on("blur", function()
	{
		gf_calculate_tgl_penyelesaian_pre_payment();
	});	
	gf_calculate_tgl_penyelesaian_pre_payment();
	$('.input-group.date').datepicker({ autoclose: true, format: "dd/mm/yyyy"});
	$("button[id='cmdApprove'], button[id='cmdReject']").on("click", function()
	{
		var sModeAR = $.trim($(this).text());
		if($.trim($("#txtnIdTransaksiPrePayment").val()) === "(AUTO)")
		{
			$.gf_msg_info({oAddMarginLR: true, oMessage: "Id Transaksi Pre Payment tidak ditemukan. Pilih Id Transaksi Pre Payment melalui List !", oObjDivAlert: $("#div-top")});
			return false;
		}

		var oButton = $(this);
		var oDialog = BootstrapDialog.show({
			type: BootstrapDialog.TYPE_DEFAULT,
            title: 'Information',
            closable: false,
            message: "<p id=\"pInfo\" class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\"><p>Do you really want to <span class=\'text-green\'><b>"+$.trim($(this).html())+"</b></span> this Pre Payment ?. Click Confirm to "+$.trim($(this).html())+" button to continue this Process and click Cancel to return to Form.<br /><div class=\"row\"><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\"><label>Notes:</label><textarea class=\"form-control\" name=\"txtReason\" id=\"txtReason\" maxlength=\"100\"></textarea></div></div><b>Warning: </b><br />After this operation you can\'t modified anythings in this Pre Payment !</p></p>",            
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
						            var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_pengajuan_pre_payment/gf_operation/"});
						            objForm.append("<input type=\"hidden\" name=\"hideStatus\" id=\"hideStatus\" value=\""+$.trim(oButton.text()).toString().toUpperCase()+"\" />");
						            objForm.append("<input type=\"hidden\" name=\"hideNotes\" id=\"hideNotes\" value=\""+$.trim($("#txtReason").val())+"\" />");
						            objForm.append("<input type=\"hidden\" name=\"hideIdTransaksi\" id=\"hideIdTransaksi\" value=\""+$.trim($("#txtnIdTransaksiPrePayment").val())+"\" />");
						            objForm.append("<input type=\"hidden\" name=\"hideNIKAtasan\" id=\"hideNIKAtasan\" value=\""+$.trim($("#hideNIKAtasan").val())+"\" />");
						            objForm.append("<input type=\"hidden\" name=\"hideTrackingMode\" id=\"hideTrackingMode\" value=\"PENGAJUAN_PRE_PAYMENT\" />");

						            $.gf_custom_ajax({"oForm": objForm,  
												"success": function(r)
												{
													var JSON = $.parseJSON(r.oRespond); 
													if(JSON.status === 1) {
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
            }
        });
		oDialog.open();
	});
	$("input[content-mode='numeric']").each(function(i, n)
	{
		$(this).autoNumeric('init',
		{
			vMin: 1,
			mDec: $(this).attr("decimalpoint"), 
			vMax: "9".repeat($(this).attr("maxlength"))
		}).addClass("text-right")
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
	if(("<?php print intval($this->session->userdata('nGroupUserId_fk')); ?>" === "1" || "<?php print intval($this->session->userdata('nGroupUserId_fk')); ?>" === "5") && "<?php print trim($o_mode); ?>" === "")
	{
		$("#txtNIKAtasan").addClass("disabled").attr("disabled", "disabled");
		$("#txtNIKAtasan").selectpicker("refresh");
		$("#form_5ca2dcddb1a39").append("<input type=\"hidden\" name=\"txtNIKAtasan\" id=\"txtNIKAtasan\" value=\""+$("#txtNIKAtasan").val()+"\" />");
	}
	gf_generate_total();
	$("a[href='#tab_1']").on("click", function()
	{
		gf_load_data_list_pengajuan_pre_payment_saya();
	});
	$("a[href='#tab_4']").on("click", function()
	{
		gf_load_data_list_pengajuan_pre_payment_staff();
	});
	$("a[href='#tab_5']").on("click", function()
	{
		gf_load_data_list_pengajuan_pre_payment_approval_hrd();
	});
	$("#cmdLookupKaryawan").on("click", function()
  {   
    gf_lookup_karyawan();
  });
  $("input[id='txtNIK']").on("blur", function(e)
  {
  	if($.trim($(this).val()) !== "")
	  	gf_load_data_karyawan($.trim($(this).val()));
  });
  if(parseInt("<?php print $nGroupUserIdSession; ?>") !== parseInt("<?php print $nGroupUserIdHRD; ?>"))
	  $("#txtNIK").trigger("blur");
  if($.trim("<?php print $o_mode; ?>") === "I")
  	$("#selKelompokUsahaPenyusun").find("option:eq(1)").prop("selected", true);
	$("#tableInfoKaryawan").find("tr:gt(0)").find("td:eq(0)").removeAttr("style");
	if("<?php print trim($o_mode); ?>" !== "")
		$("#navLink").find("li:eq(0)").find("a").trigger("click");

	$("select").selectpicker('refresh');
	$("#spanBrowseAtasan").unbind("click").on("click", function() 
	{
		var d = null,
			oObj = $(this),
			oForm = $.gf_create_form({
				"action": "<?php print site_url(); ?>c_prepayment_karyawan/gf_load_data_atasan/"
			});
		$.gf_custom_ajax({
			"oForm": oForm,
			"success": function(r) {
				d.getModalBody().html(r.oRespond);
			},
			"validate": true,
			"beforeSendType": "custom",
			"error": function(r) {},
			"beforeSend": function(r) {
				d = BootstrapDialog.show({
					title: 'Browse Nama Atasan',
					message: 'Loading...',
					size: BootstrapDialog.SIZE_WIDE,
					type: BootstrapDialog.TYPE_DEFAULT,
					buttons: [{
							label: 'Okay',
							cssClass: 'btn btn-danger',
							action: function(dialog) {
								var JSON = $.parseJSON("["+window.DATA+"]");
								$("#hideNIKAtasan").val(JSON[0].NIK);
								$("#txtNamaAtasan").val(JSON[0].Nama_Karyawan);
								dialog.close();
							}
						},
						{
							label: 'Close',
							action: function(dialog) {
								dialog.close();
							}
						}
					],
					onshown: function(r) {
						r.getModalBody().find("input[id^='txtSearch']").focus();
					}
				});
			}
		});
	});
	$("#aPrintPengajuanNormal").on("click", function() {
		var nPengajuanId = parseInt($("#txtnIdTransaksiPrePayment").val());
		var nIdReport = 1;
		$.gf_print_using_stimulsoft({sURL: $.trim("<?php print site_url(); ?>"), sFieldName: "nIdPengajuanBS", sFieldNameValue: nPengajuanId, nIdReport: nIdReport, sFieldNameLabel: "Id Pengajuan Pre Payment", sTitleDialog: "Print Pengajuan Pre Payment: <b>"+nPengajuanId+"</b>"});	
	});
	$("#aPrintPengajuanBS").on("click", function() {
		var nPengajuanId = parseInt($("#txtnIdTransaksiPrePayment").val());
		var nIdReport = 2;
		$.gf_print_using_stimulsoft({sURL: $.trim("<?php print site_url(); ?>"), sFieldName: "nIdPengajuanBS", sFieldNameValue: nPengajuanId, nIdReport: nIdReport, sFieldNameLabel: "Id Pengajuan Pre Payment", sTitleDialog: "Print Pengajuan Pre Payment: <b>"+nPengajuanId+"</b>"});	
	});
});
function gf_lookup_karyawan()
{
	var sNamaKaryawan = "";
  var oObjPerspective = $(this);
  $.ajax({
      type: "POST",
      url: "<?php print site_url(); ?>c_prepayment_karyawan/gf_load_data_karyawan/",
      beforeSend: function()
      {
        dialog = new BootstrapDialog({
                  title: 'Browse Atasan',
                  message: $.gf_spinner() + " <center>Loading Data...</center><br /><br /><br /><br />",
                  type : BootstrapDialog.TYPE_DEFAULT,
                  buttons: [{
                            id:'cmdOkay',
                            label: 'Okay',
                            cssClass: 'btn-primary',
                            action: function(d)
                            {
                              var JSON = '{\"oData\": ['+window.DATA+']}';
                              var JSON = $.parseJSON(JSON);
                              var sNamaVendor = "";
                              $.each(JSON.oData, function(i, n)
                              {
                                $("#txtNIK").val(this.NIK);
                                gf_load_data_karyawan(this.NIK);
                              });
                              d.close();
                            },
                          },{
                            id:'cmdClose',
                            label: 'Close',
                            cssClass: 'btn-default',
                            action: function(d)
                            {
                              d.close();
                            },
                          }
                          ]
                  });   
        dialog.setSize(BootstrapDialog.SIZE_WIDE);
        dialog.setClosable(false);
        dialog.open();
      },
      success: function(r)
      {
        dialog.getModalBody().html(r);
      }
   });
}
function gf_load_data_karyawan(sNIK)
{
	if($.trim(sNIK) !== "")
	{
		var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_pengajuan_pre_payment/gf_load_info_karyawan"});
		objForm.append("<input type=\"hidden\" name=\"sNIK\" id=\"sNIK\" value=\""+$.trim(sNIK)+"\" />");
		objForm.append("<input type=\"hidden\" name=\"nIdPengajuanBS\" id=\"nIdPengajuanBS\" value=\"<?php print trim($o_mode) === "I" ? "(AUTO)" : $o_data[0]['nIdPengajuanBS']; ?>\" />");
		$.gf_custom_ajax({"oForm": objForm,  
		"success": function(r)
		{
			var JSON = $.parseJSON(r.oRespond); 
			if(JSON.oData !== null)
			{
				$("#divInfoKaryawan").html("<div class=\"row table-responsive\"><table class=\"table table-striped\"><tr><td><b>Nama</b></td><td>:</td><td>"+JSON.oData.sNamaKaryawan+"</td></tr><tr><td><b>Atasan</b></td><td>:</td><td>"+JSON.oData.sAtasan+"</td></tr><tr><td><b>Unit Usaha</b></td><td>:</td><td>"+JSON.oData.sNamaUnitUsaha+"</td></tr><tr><td><b>Jabatan</b></td><td>:</td><td>"+JSON.oData.sBagian+"</td></tr><tr><td><b>Divisi</b></td><td>:</td><td>"+JSON.oData.sNamaDivisi+"</td></tr><tr><td><b>Departemen</b></td><td>:</td><td>"+JSON.oData.sNamaDepartemen+"</td></tr><tr><td><b>Bank</b></td><td>:</td><td>"+JSON.oData.sNamaBank+"</td></tr><tr><td><b>Cabang</b></td><td>:</td><td>"+JSON.oData.sCabangBank+"</td></tr><tr><td><b>No Rekening</b></td><td>:</td><td>"+JSON.oData.sNoRekening+"</td></tr><tr><td><b>Atas Nama Rekening</b></td><td>:</td><td>"+JSON.oData.sAtasNamaRekening+"</td></tr><tr><td><b>Apps Group User</b></td><td>:</td><td class=\"text-red\">"+JSON.oData.sGroupUser+"</td></tr></table>");

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
	else
		$("#divInfoKaryawan").html("Pilih NIK untuk menampilkan Informasi Karyawan.").addClass("bg-default");
}
function gf_load_data_list_pengajuan_pre_payment_saya() 
{ 
	$("#divListPengajuanPrePaymentSaya").ado_load_paging_data({url: "<?php print site_url(); ?>c_prepayment_pengajuan_pre_payment/gf_load_data_list_pengajuan_pre_payment_saya/"}); 
} 
function gf_load_data_list_pengajuan_pre_payment_staff()
{
	$("#divListPengajuanPrePaymentStaff").ado_load_paging_data({url: "<?php print site_url(); ?>c_prepayment_pengajuan_pre_payment/gf_load_data_list_pengajuan_pre_payment_staff/"}); 
}
function gf_load_data_list_pengajuan_pre_payment_approval_hrd()
{
	$("#divListPengajuanPrePaymentApprovalHRD").ado_load_paging_data({url: "<?php print site_url(); ?>c_prepayment_pengajuan_pre_payment/gf_load_data_list_pengajuan_pre_payment_approval_hrd/"}); 
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

  $("#txtTglPenyelesaiPrePayment").val((dd.toString().length === 1 ? "0" + dd : dd) + '/' + (mm.toString().length === 1 ? "0" + mm : mm) + '/' + y);
}
function gf_generate_total()
{
	$("#spanTotal").html("0");
	$("#hideTotalAmount").html("0");
	if($.trim($("#selKategoriPrePayment").val()) !== "")
	{
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

				var nQty = parseInt($(this).parent().parent().find("td:eq(3)").find("input[id='txtQty']").val().replace(/,/g,"")) < 0 ? parseInt($(this).parent().parent().find("td:eq(3)").find("input[id='txtQty']").val().replace(/,/g,"")) * -1 : parseInt($(this).parent().parent().find("td:eq(3)").find("input[id='txtQty']").val().replace(/,/g,""));
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
				$("#tdTerbilang").html("Grand Total (<b>" + $.gf_angka_terbilang({angka: oTot.toString()}) + "</b> Rupiah)");
				
				$("#hideTotalAmount").val(oTot);
			}
		});
	}
}
function gf_bind_event()
{
	var oTable = $("#divPick").find("table");
	oTable.find("tr:eq(0)").find("td:last").html("Print").prop("colspan", 2);
	oTable.find("tr:gt(0)").find("td:gt(10)").remove();
	oTable.find("tr:gt(0)").append("<td style=\"vertical-align: middle;\"><a class=\"btn btn-xs btn-primary\">Normal</a></td>");
	oTable.find("tr:gt(0)").append("<td style=\"vertical-align: middle;\"><a class=\"btn btn-xs btn-danger\">BS</a></td>");
	oTable.find("tr:gt(0)").find("td:eq(11)").find("a").unbind("click").on("click", function()
	{
		var nPengajuanId = parseInt($.trim($(this).parent().parent().find("td:eq(0)").text()));
		$.gf_print_using_stimulsoft({sURL: $.trim("<?php print site_url(); ?>"), sFieldName: "nIdPengajuanBS", sFieldNameValue: nPengajuanId, nIdReport: 1, sFieldNameLabel: "Id Pengajuan Pre Payment", sTitleDialog: "Print Pengajuan Pre Payment: <b>"+nPengajuanId+"</b>"});	
	});
	oTable.find("tr:gt(0)").find("td:eq(12)").find("a").unbind("click").on("click", function()
	{
		var nPengajuanId = parseInt($.trim($(this).parent().parent().find("td:eq(0)").text()));
		$.gf_print_using_stimulsoft({sURL: $.trim("<?php print site_url(); ?>"), sFieldName: "nIdPengajuanBS", sFieldNameValue: nPengajuanId, nIdReport: 2, sFieldNameLabel: "Id Pengajuan Pre Payment", sTitleDialog: "Print Pengajuan Pre Payment: <b>"+nPengajuanId+"</b>"});	
	});
}
function gf_calculate_date_diff()
{
	var d1 = $("#txtTglKegSelesai").val().split("/")[1] + "/" + $("#txtTglKegSelesai").val().split("/")[0] + "/" + $("#txtTglKegSelesai").val().split("/")[2];
	var d2 = $("#txtTglKegMulai").val().split("/")[1] + "/" + $("#txtTglKegMulai").val().split("/")[0] + "/" + $("#txtTglKegMulai").val().split("/")[2];
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