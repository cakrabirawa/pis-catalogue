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
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List Status Transaksi</a></li> 
		<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form Status Transaksi</a></li> 
		<li class="pull-right"><a class="text-muted" href=""><i class="fa fa-gear"></i></a></li> 
	</ul> 
	<div class="tab-content"> 
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>"> 
			<div id="div-list-user">	
			</div> 
		</div> 
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>"> 
			<form id="form_5ec76711d20ca" role="form" action="<?php print site_url(); ?>c_apn_status_tx/gf_transact" method="post"> 
				<div class="box-body no-padding"> 
					<div class="row">
						<div class="col-sm-4 col-xs-12 col-md-4 col-lg-2 form-group hidden" id="div-top"><label>Id Status TX</label><input allow-empty="false" type="text" placeholder="Id Status TX" name="txtIdStatusTX" id="txtIdStatusTX" class="form-control" maxlength="50" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nIdStatusTX']); ?>" readonly>
						</div>
						<div class="row"></div>
						<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 form-group"><label>Nama Status TX</label><input allow-empty="false" type="text" placeholder="Nama Status TX" name="txtNamaStatusTX" id="txtNamaStatusTX" class="form-control" maxlength="100" value="<?php print trim($o_data[0]['sNamaStatusTX']); ?>">
						<input type="hidden" name="txtNamaStatusTXOld" id="txtNamaStatusTXOld" value="<?php print trim($o_data[0]['sNamaStatusTX']); ?>" />
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
	$("button[id='button-submit']").click(function() {
		if ($.trim($(this).html()) === "Cancel")
			$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
		else {
			var bNext = true;
			var objForm = $("#form_5ec76711d20ca");
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
}); 
function gf_load_data() 
{ 
	$("#div-list-user").ado_load_paging_data({url: "<?php print site_url(); ?>c_apn_status_tx/gf_load_data/"}); 
} 
</script>