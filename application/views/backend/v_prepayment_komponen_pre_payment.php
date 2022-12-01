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
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List Komponen Pre Payment</a></li> 
		<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form Komponen Pre Payment</a></li> 
		<li class="pull-right"><a class="text-muted" href=""><i class="fa fa-gear"></i></a></li> 
	</ul> 
	<div class="tab-content"> 
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>"> 
			<div id="div-list-user">	
			</div> 
		</div> 
		<!-- /.tab-pane --> 
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>"> 
			<form id="form_5ca2dcddb1a39" role="form" action="<?php print site_url(); ?>c_prepayment_komponen_pre_payment/gf_transact" method="post">
				<div class="box-body no-padding"> 
					<div class="row">
						<div class="col-sm-12 col-xs-12 col-md-10 col-lg-10" id="div-top">
							<div class="row">
								<div class="col-sm-6 col-xs-12 col-md-6 col-lg-4 form-group hidden"><label>Id Komponen Pre Payment</label><input allow-empty="false" type="text" placeholder="Sample" name="txtIdKomponen" id="txtIdKomponen" class="form-control" maxlength="50" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nIdKomponen']); ?>" readonly>
								</div>
							  <div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Nama Komponen Pre Payment</label><input allow-empty="false" type="text" placeholder="Nama Komponen Pre Payment" name="txtNamaKomponen" id="txtNamaKomponen" class="form-control text-bold input-lg" maxlength="100" value="<?php print trim($o_data[0]['sNamaKomponen']); ?>">
									<input type="hidden" name="txtNamaKomponenOld" id="txtNamaKomponenOld" value="<?php print trim($o_data[0]['sNamaKomponen']); ?>" />
							  </div>
							  <div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 form-group"><label>Nama Label</label><input allow-empty="false" type="text" placeholder="Nama Label" name="txtNamaLabel" id="txtNamaLabel" class="form-control" maxlength="100" value="<?php print trim($o_data[0]['sLabel']); ?>">
									<input type="hidden" name="txtNamaLabelOld" id="txtNamaLabelOld" value="<?php print trim($o_data[0]['sLabel']); ?>" />
							  </div>
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-3 form-group"><label>Tipe Data</label>
									<select name="selTipeData" placeholder="Tipe Data" allow-empty="false" id="selTipeData" class="form-control selectpicker" data-size="8" data-live-search="true">
										<option value="N" <?php print trim($o_data[0]['sTipeDataKomponen']) === "N" ? "selected" : "" ?>>NUMERIC</option>
										<option value="A" <?php print trim($o_data[0]['sTipeDataKomponen']) === "A" ? "selected" : "" ?>>ALPHA NUMERIC</option>
										<option value="D" <?php print trim($o_data[0]['sTipeDataKomponen']) === "D" ? "selected" : "" ?>>DATE</option>
									</select>
							  </div>
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-3 form-group"><label>Allow Summary</label>
									<select name="selAllowSummary" placeholder="Allow Summary" allow-empty="false" id="selAllowSummary" class="form-control selectpicker" data-size="8" data-live-search="true">
										<option value="0" <?php print intval($o_data[0]['sAllowSummary']) === 0 ? "selected" : "" ?>>NO</option>
										<option value="1" <?php print intval($o_data[0]['sAllowSummary']) === 1 ? "selected" : "" ?>>YES</option>
									</select>
							  </div>
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-3 form-group"><label>Allow Multiply</label>
									<select name="selAllowMultiply" placeholder="Allow Multiply" allow-empty="false" id="selAllowMultiply" class="form-control selectpicker" data-size="8" data-live-search="true">
										<option value="0" <?php print intval($o_data[0]['sAllowMultiply']) === 0 ? "selected" : "" ?>>NO</option>
										<option value="1" <?php print intval($o_data[0]['sAllowMultiply']) === 1 ? "selected" : "" ?>>YES</option>
									</select>
							  </div>
							  <div class="col-sm-12 col-xs-12 col-md-6 col-lg-3 form-group"><label>Satuan</label>
									<input allow-empty="false" type="text" placeholder="Satuan" name="txtSatuan" id="txtSatuan" class="form-control" maxlength="20" value="<?php print trim($o_data[0]['sSatuan']); ?>">
							  </div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-3 form-group"><label>Digit (Min=0, Max=20 (Without commas))</label>
									<input allow-empty="false" type="text" content-mode="numeric" placeholder="Digit" name="txtDigit" id="txtDigit" class="form-control" maxlength="100" value="<?php print trim($o_data[0]['nDigit']); ?>">
							  </div>
							  <div class="col-sm-12 col-xs-12 col-md-6 col-lg-3 form-group"><label>Dec. Point (Min=0, Max=2 (Without commas)</label>
									<input allow-empty="false" type="text" content-mode="numeric" placeholder="Dec. Point" name="txtDecPoint" id="txtDecPoint" class="form-control" maxlength="100" value="<?php print trim($o_data[0]['nDecimalPoint']); ?>">
							  </div>
							</div> 
						</div>
						<div class="row"></div>
						<div class="col-sm-12 col-xs-12 col-md-10 col-lg-10">
							<h3>User Group & Komponen Pre Payment Rule</h3>
							<?php
								print $o_detail;
							?>	
							<div class="btn-group form-group">
							  <button type="button" class="btn btn-default" name="cmdAddJabatan" id="cmdAddJabatan"><i class="fa fa-plus"></i> Tambah User Group</button>
							  <button type="button" name="cmdClearAllJabatan" id="cmdClearAllJabatan" class="disable btn btn-danger"><i class="fa fa-trash"></i> Hapus Semua User Group</button>
							</div>						  
							<select id="selGrupUser" name="selGrupUser" class="hidden"><?php print $o_grupuser; ?></select>
						</div>
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
	$("input[content-mode='numeric'][id='txtDecPoint']").autoNumeric('init', {mDec: '0', vMax: 2}).addClass("text-right"); 
	$("input[content-mode='numeric'][id='txtDigit']").autoNumeric('init', {mDec: '0', vMax: 20}).addClass("text-right"); 
	$("input[content-mode='numeric'][id='txtNominal']").autoNumeric('init', {mDec: '0', vMax: 9999999}).addClass("text-right"); 
	$("input[content-mode='numeric'][id='txtQtyPenyesuaian']").autoNumeric('init', {mDec: '0', vMax: 999}).addClass("text-right"); 
	$("input[content-mode='numeric'][id='txtPotongan']").autoNumeric('init', {mDec: '0', vMax: 999}).addClass("text-right"); 
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
			//------------------------------------------ 
			$("input[id='txtPotongan']").each(function(i, n)
			{
				var oObj = $(this);
				if($.trim(oObj.val()) === "")
					oObj.val("0");
				if(parseInt($.trim(oObj.val())) > 100)
				{
					$.gf_custom_notif({oObjDivAlert: $("#div-top"), oAddMarginLR: true, sMessage: "Ada potongan melebih 100 %. Periksa kembali data Anda !"});
					bNext = false;
					oObj.focus().select();
				}
			});
			//------------------------------------------ 
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
	$("#txtNamaKomponen").unbind("keyup").on("keyup", function()
	{
		$("#txtNamaLabel").val($.trim($(this).val()));
	});
	$("#selTipeData").on("change", function()
	{
		if($.trim($(this).val()) === "D" || $.trim($(this).val()) === "A")
		{
			$("#selAllowSummary").addClass("disabled").attr("disabled", "disabled");
			$("#selAllowMultiply").addClass("disabled").attr("disabled", "disabled");
		}	
		else
		{
			$("#selAllowSummary").removeClass("disabled").removeAttr("disabled");
			$("#selAllowMultiply").removeClass("disabled").removeAttr("disabled");
		}	
		$("#selAllowSummary").find("option").removeAttr("selected");
		$("#selAllowSummary").find("option:eq(0)").attr("selected", "selected");
		$("#selAllowSummary").selectpicker('refresh');
		$("#selAllowMultiply").find("option").removeAttr("selected");
		$("#selAllowMultiply").find("option:eq(0)").attr("selected", "selected");
		$("#selAllowMultiply").selectpicker('refresh');
	});	
	$("button[id='cmdAddJabatan']").on("click", function()
	{
		var oTable = $("table[id='tableDetail']");

		if($.trim(oTable.find("tr:last").find("td:eq(1)").find("select").find("option:selected").val()) === "")
			return false;

		var bNext = true;
		var clonedRow = oTable.find("tr:eq(1)").clone();
		oTable.append(clonedRow);
		oTable.find("tr:last").find("td:eq(1)").html("<select id=\"selPosisi\" placeholder=\"Jabatan\" name=\"selPosisi[]\" class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" allow-empty=\"false\">"+$("#selGrupUser").html()+"</select>");
		oTable.find("td:eq(1)").find("select[id='selPosisi']").find("option:eq(0)").prop("selected", true).parent().selectpicker('refresh');
		oTable.find("td:eq(1)").find("input[id='selPosisi']").find("option:eq(0)").prop("selected", true).parent().selectpicker('refresh');
		oTable.find("tr:last").find("td:gt(1)").each(function(i, n)
		{
			$(this).find("input[type='text']").val("0");
		});
		$("select[id='selPosisi']").selectpicker('refresh');
		oTable.find("tr:last").find("td:eq(3)").find("input[type='checkbox']").prop("checked", false);
		oTable.find("tr:last").find("td:eq(4)").find("input[type='checkbox']").prop("checked", false);
		oTable.find("tr:last").find("td:eq(3)").find("input[type='checkbox']").next().val("0");
		oTable.find("tr:last").find("td:eq(4)").find("input[type='checkbox']").next().val("0");
		$.gf_reset_seq_no_table({oObjTable: oTable, oAlignText: "text-right"});
		$("input[content-mode='numeric'][id='txtNominal']").autoNumeric('init', {mDec: '0', vMax: 9999999}).addClass("text-right"); 
		$("input[content-mode='numeric'][id='txtQtyPenyesuaian']").autoNumeric('init', {mDec: '0', vMax: 999}).addClass("text-right"); 
		$("input[content-mode='numeric'][id='txtPotongan']").autoNumeric('init', {mDec: '0', vMax: 999}).addClass("text-right"); 
		gf_bind_event();
	});
	$("button[id='cmdClearAllJabatan']").unbind("click").on("click", function()
	{
		var oTable = $("table[id='tableDetail']");
		oTable.find("tr:gt(1)").remove();
		$("select[id='selPosisi']").find("option:eq(1)").prop("selected", true).parent().selectpicker('refresh');
		$("input[id='txtNominal']").val("");
		$("input[id='txtQtyPenyesuaian']").val("");
		$("input[id='txtPotongan']").val("");
		oTable.find("tr:last").find("td:eq(3)").find("input[type='checkbox']").prop("checked", false);
		oTable.find("tr:last").find("td:eq(4)").find("input[type='checkbox']").prop("checked", false);
		$.gf_reset_seq_no_table({oObjTable: oTable, oAlignText: "text-right"});
	});
	$("i[id='iClearAllRow']").on("click", function() {
		$("button[id='cmdClearAllJabatan']").trigger("click");
	});
	gf_bind_event();
	$("select").selectpicker('refresh');
	$("table tr td").css("vertical-align", "middle");
	$("table").find("tr:gt(0)").find("td:eq(0)").css("text-align", "right");
}); 
function gf_bind_event()
{
	$("a[id='cmdRemoveListJabatan']").unbind("click").on("click", function()
	{
		var oTable = $("table[id='tableDetail']");
		if(oTable.find("tr:gt(0)").length === 1)
		{
			$("select[id='selPosisi']").find("option:eq(1)").prop("selected", true).parent().selectpicker('refresh');
			$("input[id='txtNominal']").val("");
			$("input[id='txtQtyPenyesuaian']").val("");
			$("input[id='txtPotongan']").val("");
			oTable.find("tr:last").find("td:eq(3)").find("input[type='checkbox']").prop("checked", false);
			oTable.find("tr:last").find("td:eq(4)").find("input[type='checkbox']").prop("checked", false);
		}
		else
		$(this).parent().parent().slideUp("fast", function()
		{
			$(this).remove();				
		});
	});
	$("input[id='chkEnabledNominal']").unbind("click").on("click", function()
	{
		var oObj = $(this);
		if(oObj.is(":checked"))			
		{
			oObj.parent().parent().find("td:eq(2)").find("input[id='txtNominal']").attr("readonly", "readonly");
			oObj.parent().find("input[type='hidden']").val("1");
		}	
		else
		{
			oObj.parent().parent().find("td:eq(2)").find("input[id='txtNominal']").removeAttr("readonly");
			oObj.parent().find("input[type='hidden']").val("0");
		}
	});
	$("input[id='chkQtyKegiatan']").unbind("click").on("click", function()
	{
		var oObj = $(this);
		if(oObj.is(":checked"))			
			oObj.parent().find("input[type='hidden']").val("1");
		else
			oObj.parent().find("input[type='hidden']").val("0");
	});
}
function gf_load_data() 
{ 
	$("#div-list-user").ado_load_paging_data({url: "<?php print site_url(); ?>c_prepayment_komponen_pre_payment/gf_load_data/"}); 
} 
</script>