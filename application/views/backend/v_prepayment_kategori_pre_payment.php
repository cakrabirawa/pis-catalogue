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
		<li class="<?php print $oTab1; ?>"><a id="aListKomponen" data-toggle="tab" href="#tab_1">List Kategori Pre Payment</a></li> 
		<li class="<?php print $oTab2; ?>"><a id="aKomponen" data-toggle="tab" href="#tab_2">Form Kategori Pre Payment</a></li> 
		<li class="pull-right"><a class="text-muted" href=""><i class="fa fa-gear"></i></a></li> 
	</ul> 
	<div class="tab-content"> 
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>"> 
			<div id="div-list-user">	
			</div> 
		</div> 
		<!-- /.tab-pane --> 
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>"> 
			<form id="form_5ca2dcddb1a39" role="form" action="<?php print site_url(); ?>c_prepayment_kategori_pre_payment/gf_transact" method="post"> 
				<div class="box-body no-padding"> 
				<div class="row">
					<div class="col-sm-4 col-xs-12 col-md-4 col-lg-2 form-group hidden" id="div-top"><label>Id Kategori Pre Payment</label><input allow-empty="false" type="text" placeholder="Sample" name="txtIdKategoriPrePayment" id="txtIdKategoriPrePayment" class="form-control" maxlength="50" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nIdKategoriPrePayment']); ?>" readonly>
					</div>
				  <div class="row"></div>
					<div class="col-sm-12 col-xs-12 col-md-8 col-lg-8"><label>Nama Kategori Pre Payment</label><input allow-empty="false" type="text" placeholder="Nama Kategori Pre Payment" name="txtNamaKategoriPrePayment" id="txtNamaKategoriPrePayment" class="form-control input-lg text-bold" maxlength="100" value="<?php print trim($o_data[0]['sNamaKategoriPrePayment']); ?>">
						<input type="hidden" name="txtNamaKategoriPrePaymentOld" id="txtNamaKategoriPrePaymentOld" value="<?php print trim($o_data[0]['sNamaKategoriPrePayment']); ?>" />
				  </div>
				  <div class="row"></div>
				  <div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><h3>Komponen Pre Payment</h3></div>
				  <div id="divKomponen" class="col-sm-12 col-xs-12 col-md-8 col-lg-8 form-group">
						Loading...
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
<!-- /.tab-content --> 
</div> 


<script> 
$(function() 
{ 
	gf_load_data(); 
	$("button[id='button-submit']").click(function() {
		if ($.trim($(this).html()) === "Cancel")
			$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
		else {
			var bNext = true;
			var objForm = $("#form_5ca2dcddb1a39");
			//------------------------------------------ 
			$("input[id='txtSeq']").each(function(i, n)
			{
				if(!$(this).is(":disabled"))
					objForm.append("<input type=\"hidden\" name=\"hideSeqNo[]\" id=\"hideSeqNo\" value=\""+$(this).val()+"\" />");
			});
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
			if (!bNext)
				return false;
			//------------------------------------------ 
			$.gf_custom_ajax({
				"oForm": objForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					$.gf_remove_all_modal();
					if (JSON.status === 1)
						$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
					else {
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
	$("a[id='aKomponen']").on("click", function()
	{
		$("#divKomponen").ado_load_paging_data({url: "<?php print site_url(); ?>c_prepayment_kategori_pre_payment/gf_load_data_komponen_pre_payment/"});
	});	
	$("a[id='aListKomponen']").on("click", function()
	{
		var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_kategori_pre_payment/gf_load_data/"});
		$.gf_custom_ajax({"oForm": objForm,  
		"success": function(r)
		{
			$("#div-list-user").html(r.oRespond);
		}, 
		"validate": true,
		"beforeSend": function(r) {},
		"beforeSendType": "custom", 
		"error": function(r) {} 
		}); 
	});
	if($.trim($("#txtIdKategoriPrePayment").val()) !== "(AUTO)")
	{
		var objForm = $.gf_create_form({action: "<?php print site_url(); ?>c_prepayment_kategori_pre_payment/gf_load_data_komponen_pre_payment/"});
		objForm.append("<input type=\"hidden\" name=\"nIdKategoriPrePayment\" id=\"nIdKategoriPrePayment\" value=\""+$("#txtIdKategoriPrePayment").val()+"\" />");
		$.gf_custom_ajax({"oForm": objForm,  
		"success": function(r)
		{
			$("#divKomponen").html(r.oRespond);
		}, 
		"validate": true,
		"beforeSend": function(r) {},
		"beforeSendType": "custom", 
		"error": function(r) {} 
		}); 
	}	
}); 
function gf_load_data() 
{ 
	$("#div-list-user").ado_load_paging_data({url: "<?php print site_url(); ?>c_prepayment_kategori_pre_payment/gf_load_data/"}); 
} 
function gf_bind_event()
{
	var oTD = $("#divKomponen").find("table").find("tr:gt(0)").find("td:last");
	oTD.addClass("text-center");
	oTD.find("input[type='checkbox']").unbind("click").on("click", function()
	{
		$(this).parent().parent().find("input[id='hideIdKomponenPrePayment']").remove();
		if($(this).is(":checked"))
		{
			$(this).parent().parent().append("<input type=\"hidden\" name=\"hideIdKomponenPrePayment[]\" id=\"hideIdKomponenPrePayment\" value=\""+$(this).parent().parent().find("td:eq(0)").text()+"\" />");	
			$(this).parent().parent().find("td:eq(7)").find("input").removeAttr("disabled").attr("allow-empty", "false");
		}
		else
		{
			$(this).parent().parent().find("td:eq(7)").find("input").attr("disabled", "disabled");
			$(this).parent().parent().find("input[type='hidden']").remove();
		}
	});
	oTD.find("input[type='checkbox']").each(function(i, n)
	{
		if($(this).is(":checked"))
		{	
			$(this).parent().parent().append("<input type=\"hidden\" name=\"hideIdKomponenPrePayment[]\" id=\"hideIdKomponenPrePayment\" value=\""+$(this).parent().parent().find("td:eq(0)").text()+"\" />");	
			$(this).parent().parent().find("td:eq(7)").find("input").removeAttr("disabled").attr("allow-empty", "false");
		}
	});
	$("table tr td").css("vertical-align", "middle");
	$("input[content-mode='numeric']").autoNumeric('init', {mDec: '0', vMax: 99}).addClass("text-right"); 
}
</script>