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
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List Dev Logs</a></li>
		<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form Dev Logs</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>">
			<div id="div-list-user">
			</div>
		</div>
		<!-- /.tab-pane -->
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>">
			<form id="frmCoreUserGroup" role="form" action="<?php print site_url(); ?>c_core_dev_logs/gf_transact" method="post">
				<div class="box-body no-padding">
					<div class="row">
						<div class="col-sm-3 col-xs-12 col-md-3 col-lg-2 form-group" id="div-top">
							<label>Dev Logs Id</label>
							<input allow-empty="false" type="text" placeholder="Dev Logs Id" name="txtDevLogId" id="txtDevLogId" class="form-control" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['sDevLogId']); ?>" maxlength="50" readonly>
						</div>
						<div class="col-sm-4 col-xs-12 col-md-3 col-lg-3 form-group"><label>Dev Log Date</label>
							<div class="input-group date">
								<input value="<?php print trim($o_mode) === "I" ? date('d/m/Y') : trim($o_data[0]['dDevLogDate']); ?>" allow-empty="false" placeholder="Dev Log Date" name="txtDevLogDate" id="txtDevLogDate" type="text" class="form-control"><span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							</div>
						</div>
						<div class="col-sm-4 col-xs-12 col-md-3 col-lg-2 form-group"><label>Percentage</label>
							<select name="selDevLogPercentage" allow-empty="false" placeholder="Dev Log Percentage" id="selDevLogPercentage" class="form-control selectpicker" data-size="8" data-live-search="true">
								<option value="">--Pilih--</option>
								<?php
								for ($i = 100; $i >= 10; $i -= 10) {
								?>
									<option value="<?php print $i; ?>" <?php print intval($o_data[0]['nPercentage']) === $i ? "selected" : "" ?>><?php print $i; ?> %</option>
								<?php
								}
								?>
							</select>
						</div>
						<div class="row"></div>
						<div class="col-sm-7 col-xs-12 col-md-6 col-lg-5 form-group"><label>Dev Log Subject Parent</label>
							<select name="selDevLogSubjectParent" placeholder="Dev Log Subject Parent" id="selDevLogSubjectParent" class="form-control selectpicker" data-size="8" data-live-search="true">
								<?php print $o_devlogsubject; ?></select>
						</div>
						<div class="row"></div>
						<div class="col-sm-7 col-xs-12 col-md-6 col-lg-5 form-group"><label>Dev Log Subject</label>
							<input allow-empty="false" type="text" placeholder="Dev Log Subject" name="txtDevLogSubject" id="txtDevLogSubject" class="form-control" maxlength="100" value="<?php print trim($o_data[0]['sDevLogName']); ?>">
						</div>
						<div class="row"></div>
						<div class="col-sm-7 col-xs-12 col-md-6 col-lg-5 form-group"><label>Dev Log Desc</label><textarea placeholder="Dev Log Desc" rows="4" name="txtDevLogDesc" id="txtDevLogDesc" class="form-control" maxlength="200" style="max-height: 200px;"><?php print trim($o_data[0]['sDevLogDesc']); ?></textarea>
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
	var sSURL = "<?php print site_url(); ?>c_core_dev_logs/gf_upload/";
	var sParam = "";
	var dialog = "";

	$(function() {
		gf_load_data();
		$("button[id='button-submit']").click(function() {
			if ($.trim($(this).html()) === "Cancel")
				$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
			else {
				var bNext = true;
				var objForm = $("#frmCoreUserGroup");
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
						"oObjDivAlert": $("#div-top")
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
				//------------------------------------------ 
			}
		});
		$("#txtDevLogSubject").on("keyup", function() {
			$("#txtDevLogDesc").val("Description: " + $.trim($(this).val()));
		});
		$('.input-group.date').datepicker({
			autoclose: true,
			format: "dd/mm/yyyy",
		});
		$("select").selectpicker("refresh");
	});

	function gf_bind_event() {
		//var oTable = $("#div-list-user").find("table");
		//oTable.find("tr:gt(0)").find("td:last").addClass("text-center");
	}

	function gf_load_data() {
		$("#div-list-user").ado_load_paging_data({
			url: "<?php print site_url(); ?>c_core_dev_logs/gf_load_data/"
		});
	}
</script>