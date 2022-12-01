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
?> 
<div class="nav-tabs-custom"> 
	<ul class="nav nav-tabs"> 
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List Logbook Penerimaan</a></li> 
		<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form Logbook Penerimaan</a></li> 
		<li class="pull-right"><a class="text-muted" href=""><i class="fa fa-gear"></i></a></li> 
	</ul> 
	<div class="tab-content"> 
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>"> 
			<div id="div-list-user">	
			</div> 
		</div> 
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>"> 
			<form id="form_5eec0da064e76" role="form" action="<?php print site_url(); ?>c_apn_logbook_penerimaan/gf_transact" method="post"> 
				<div class="box-body no-padding"> 
					<div class="row">
						<div class="col-sm-4 col-xs-12 col-md-4 col-lg-3 form-group" id="div-top"><label>Id Penerimaan</label><input allow-empty="false" type="text" placeholder="Id Penerimaan" name="txtIdPenerimaan" id="txtIdPenerimaan" class="form-control" maxlength="50" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nIdPenerimaan']); ?>" readonly>
						</div>
						<div class="col-sm-12 col-xs-12 col-md-4 col-lg-3 form-group"><label>Tgl Penerimaan</label><div class="input-group date"><input value="<?php print trim($o_mode) === "I" ? date('d/m/Y') : trim($o_data[0]['dTglPenerimaanX']); ?>" allow-empty="false" placeholder="Tgl Penerimaan" name="txtTglPenerimaan" id="txtTglPenerimaan" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
					  </div>
						<div class="row"></div>	
						<div class="col-sm-12 col-xs-12 col-md-4 col-lg-3 form-group"><label>Status Transaksi</label><select name="selStatusTX" placeholder="Status Transaksi" allow-empty="false" id="selStatusTX" class="form-control selectpicker" data-size="8" data-live-search="true" allow-empty="false">
          	<?php print $o_status_tx; ?></select>
					  </div>
						<div class="col-sm-12 col-xs-12 col-md-4 col-lg-3 form-group"><label>Status Dokumen</label><select name="selStatusDokumen" placeholder="Status Dokumen" allow-empty="false" id="selStatusDokumen" class="form-control selectpicker" data-size="8" data-live-search="true" allow-empty="false">
          	<?php print $o_status_doc; ?></select>
					  </div>
						<div class="row"></div>
						<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 form-group"><label>Id Vendor</label>
							<div class="input-group">
						    <input type="text" class="form-control" value="<?php print trim($o_data[0]['sIdVendor_fk']); ?>" id="txtIdVendor" name="txtIdVendor" placeholder="Masukan Id Vendor" allow-empty="false">
						    <div class="input-group-btn">
						      <button class="btn btn-default" type="button" id="cmdLookupVendor">
						        <i class="glyphicon glyphicon-search"></i>
						      </button>
						    </div>
						  </div>
						</div>
						<div class="row"></div>	
					  <div class="col-sm-4 col-xs-12 col-md-10 col-lg-6 form-group"><label><b><span id="spanInfo"><?php print trim($o_mode) === "I" ? "Nama Vendor: <b>-</b><br />Email: <b>-</b>" : "Nama Vendor: ".$o_data[0]['sNamaVendor']." <br /> Email: ".$o_data[0]['sVendorEmail']; ?></b></label></span>
					  </div>
						<div class="row"></div>	
						<div class="col-sm-12 col-xs-12 col-md-12 col-lg-6 form-group <?php print intval($o_data[0]['nIdStatusTX_fk']) === 1 ? "" : "hidden"; ?>" id="divTglEstimasiPayment"><label>Tgl Estimasi Payment</label><div class="input-group date"><input value="<?php print trim($o_mode) === "I" ? date('d/m/Y') : trim($o_data[0]['dTglEstimasiPaymentX']); ?>" allow-empty="false" placeholder="Tgl Estimasi Payment" name="txtTglEstimasiPayment" id="txtTglEstimasiPayment" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
						</div>
						<div class="col-sm-12 col-xs-12 col-md-4 col-lg-2 form-group <?php print intval($o_data[0]['nIdStatusTX_fk']) === 2 ? "" : "hidden"; ?>" id="divTglReject"><label>Tgl Reject</label><div class="input-group date"><input value="<?php print trim($o_mode) === "I" ? date('d/m/Y') : (trim($o_data[0]['dTglRejectX']) === "" ? date('d/m/Y') : trim($o_data[0]['dTglRejectX'])) ?>" allow-empty="true" placeholder="Tgl Reject" name="txtTglReject" id="txtTglReject" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						</div>
						</div>
						<div class="row"></div>	
					  <div class="col-sm-6 col-xs-12 col-md-4 col-lg-3 form-group"><label>No Tiket</label><br /><input class="form-control" type="text" value="<?php print trim($o_data[0]['sNoTiket']); ?>" name="txtNoTiket" allow-empty="false" maxlength="200" id="txtNoTiket" placeholder="No Tiket"><input type="hidden" name="txtNoTiketOld" id="txtNoTiketOld" value="<?php print trim($o_data[0]['sNoTiket']); ?>"/>
					  </div>
					  <div class="col-sm-6 col-xs-12 col-md-4 col-lg-3 form-group"><label>Qty</label><br /><input class="form-control" content-mode="numeric" value="<?php print trim($o_data[0]['nQty']); ?>" type="text" name="txtQty" allow-empty="false" id="txtQty" placeholder="Qty">
					  </div>
						<div class="row"></div>	
					  <div class="col-sm-12 col-xs-12 col-md-4 col-lg-3 form-group"><label>Nominal</label><br /><input class="form-control" content-mode="numeric" value="<?php print trim($o_data[0]['nNominal']); ?>" type="text" name="txtNominal" allow-empty="false" id="txtNominal" placeholder="Nominal">
					  </div>
					  <div class="col-sm-12 col-xs-12 col-md-4 col-lg-3 form-group"><label>Nama PIC</label><br /><input class="form-control" type="text" name="txtNamaPIC" value="<?php print trim($o_mode) === "I" ? $this->session->userdata('sRealName') : trim($o_data[0]['sNamaPIC']) ?>" readonly  allow-empty="false" id="txtNamaPIC" placeholder="Nama PIC">
					  </div>
						<div class="row"></div>	
					  <div class="row"></div>
						<div class="col-sm-12 col-xs-12 col-md-12 col-lg-6 form-group"><label>Catatan</label><textarea placeholder="Catatan" rows="2" name="txtCatatan" id="txtCatatan" class="form-control" maxlength="200" style="max-height: 200px;"><?php print trim($o_data[0]['sNotes']); ?></textarea>
						</div>
					</div> 
					<div class="box-footer no-padding"> 
					<br /> 
					<?php print $oButton; ?> 
				</div> 
				<input type="hidden" name="hideMode" id="hideMode" value="" /> 
			</form> 
		</div> 
	</div> 
</div> 


<script> 
$(function() 
{ 
	gf_load_data(); 
	$("input[content-mode='numeric']").autoNumeric('init', {mDec: '0'}).addClass("text-right");  
	$('.input-group.date').datepicker({ autoclose: true, format: "dd/mm/yyyy"});
	$("button[id='button-submit']").click(function() 
	{ 
		if($.trim($(this).html()) === "Cancel") 
			$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
		else 
		{ 
			if(parseInt($("#selStatusDokumen").val()) === 1) // Approve
			{
				$("#txtTglEstimasiPayment").attr("allow-empty", "false");
				$("#txtTglReject").attr("allow-empty", "true");
			}
			if(parseInt($("#selStatusDokumen").val()) === 2) // Reject
			{
				$("#txtTglReject").attr("allow-empty", "false");
				$("#txtTglEstimasiPayment").attr("allow-empty", "true");
			}
			//------------------------------------------ 
			var bNext = true; 
			var objForm = $("#form_5eec0da064e76"); 
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
			$.gf_custom_ajax({"oForm": objForm,  
			"success": function(r)
			{
				var JSON = $.parseJSON(r.oRespond); 
				if(JSON.status === 1) 
				{
		  		$.gf_remove_all_modal();
					BootstrapDialog.show({
                type: BootstrapDialog.TYPE_DEFAULT,
                title: 'Informasi',
                closable: false,
                message: 'Id Penerimaan untuk transaksi ini adalah: <br /><div id=\"divIdPenerimaan\" class=\"text-center blinking\"><br /><b><span style=\"font-size: 60px;\">'+JSON.idpenerimaan+'</span></b></div><br />Note:<br />Catat baik-baik Nomor Penerimaan ini untuk kepentingan lebih lanjut !',
                buttons: [{
                    label: 'Close',
                    cssClass: 'btn-default',
                    action: function(d){
	                    d.close();
	                    $(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
		                }
                }]
            });   					
				}
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
	$("#selStatusDokumen").on("change", function()
	{
		//txtTglEstimasiPayment
		//txtTglReject

		$("#divTglEstimasiPayment").addClass("hidden");
		$("#divTglReject").addClass("hidden");
		if($.trim($(this).val()) !== "")
		{
			if($.trim($(this).val()) === "1") //Approve
			{
				$("#divTglEstimasiPayment").removeClass("hidden");
				$("#divTglReject").addClass("hidden");
				$("#txtTglEstimasiPayment").attr("allow-empty", "false");
				$("#txtTglReject").attr("allow-empty", "true");
			}	
			else if($.trim($(this).val()) === "2") //Reject
			{
				$("#divTglEstimasiPayment").addClass("hidden");
				$("#divTglReject").removeClass("hidden");
				$("#txtTglEstimasiPayment").attr("allow-empty", "true");
				$("#txtTglReject").attr("allow-empty", "false");
			}

		}
	});
	$("#txtIdVendor").on("blur", function()
	{
		var oObj = $(this);
		if($.trim($(this).val()) !== "")
		{
			var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_apn_logbook_penerimaan/gf_load_data_vendor_detail"});
			objForm.append("<input type=\"hidden\" id=\"sIdVendor\" name=\"sIdVendor\" value=\""+oObj.val()+"\" />");
			$.gf_custom_ajax({"oForm": objForm,  
			"success": function(r)
			{
				var JSON = $.parseJSON(r.oRespond); 
				if(JSON.oData.length > 0)
					$("#spanInfo").html("Nama Vendor: <b>"+JSON.oData[0].sNamaVendor+"</b><br /><Email: <b>"+JSON.oData[0].sVendorEmail+"</b>");
				else
					$("#spanInfo").html("Nama Vendor: <b>-</b><br /><Email: <b>-</b>");
				oObj.removeClass("disabled").prop("disabled", false);
			}, 
			"validate": true,
			"beforeSend": function(r) {
				$("#spanInfo").html("Nama Vendor: <b>Loading...</b><br /><Email: <b>Loading...</b>");
				oObj.addClass("disabled").prop("disabled", true);
			},
			"beforeSendType": "custom", 
			"error": function(r) {} 
			}); 
		}
	});
	$("#cmdLookupVendor").on("click", function()
	{		
		var oObjPerspective = $(this);
  	$.ajax({
			  type: "POST",
			  url: "<?php print site_url(); ?>c_apn_logbook_penerimaan/gf_load_data_vendor/",
			  beforeSend: function()
			  {
      	  dialog = new BootstrapDialog({
		                title: 'Browse Vendor Name',
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
																	$("#txtIdVendor").val(this.Id_Vendor);
							              			$("#spanInfo").html("Nama Vendor: <b>" + this.Nama_Vendor + "</b><br />Email: <b>" + this.Email + "</b><br />");
							              			sNamaVendor = this.Nama_Vendor;
																});
																if($.trim(sNamaVendor) === "")
																	$("#spanInfo").html("Nama Vendor: <b>-</b><br /><Email: <b>-</b>");
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
	});
	$("a[href='#tab_2']").trigger("click");
	$("select").selectpicker("refresh");
}); 
function gf_load_data() 
{ 
	$("#div-list-user").ado_load_paging_data({url: "<?php print site_url(); ?>c_apn_logbook_penerimaan/gf_load_data/"}); 
} 
</script>