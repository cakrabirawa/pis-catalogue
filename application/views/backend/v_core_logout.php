<?php
$oTab1 = "";
$oTab2 = "";
$oButton = "";
if (trim($o_mode) === "I") {
	$oTab1 = "active";
	$oButton = $o_save;
} else {
	$oTab2 = "active";
	$oButton = " " . $o_update . " " . $o_delete;
}
$oButton .= " " . $o_cancel;
?>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List c logout</a></li>
		<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form c logout</a></li>
		<li class="pull-right"><a class="text-muted" href=""><i class="fa fa-gear"></i></a></li>
	</ul>
	<div class="tab-content">
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>">
			<div id="div-list-user">
			</div>
		</div>
		<!-- /.tab-pane -->
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>">
			<form id="form_58e5cbe7ddb15" role="form" action="<?php print site_url(); ?>c_logout/gf_transact" method="post">
				<div class="box-body no-padding">
					<div class="col-sm-1 col-xs-12 form-group" id="div-top"><label>Sample</label><input allow-empty="false" type="text" placeholder="Sample" name="txtMenuId" id="txtSampleId" class="form-control" maxlength="50" readonly></div>
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
	var sSURL = "<?php print site_url(); ?>c_logout/gf_upload/"
	var sParam = "";
	var dialog = "";
	$(function() {
		gf_load_data();
		$("input[content-mode='numeric']").autoNumeric('init');
		$("button[id='button-submit']").click(function() {
			if ($.trim($(this).html()) === "Cancel")
				window.location.href = "<?php print site_url(); ?>c_logout"
			else {
				var bNext = true;
				//------------------------------------------ 
				if (parseInt($.inArray($.trim($("#hideMode").val()), ["I", "U"])) === 0) {
					$("#div-alert").remove();
					$.each($("input[allow-empty='false'], select[allow-empty='false'], textarea[allow-empty='false']"), function(i, n) {
						if ($.trim($(this).val()) === "") {
							$("<div id='div-alert' class='alert alert-error alert-dismissible'><button class='close' aria-hidden='true' data-dismiss='alert' type='button'><i class='fa fa-close'></i></button><p>" + $(this).attr("placeholder") + " can't Empty...</p></div>").insertBefore($("#div-top"));
							bNext = false;
							return false;
						}
					});
				}
				if (!bNext)
					return false;
				//------------------------------------------ 
				if ($.trim($(this).html()) === "Save")
					$("#hideMode").val("I");
				else if ($.trim($(this).html()) === "Update")
					$("#hideMode").val("U");
				else if ($.trim($(this).html()) === "Delete")
					$("#hideMode").val("D");
				//------------------------------------------ 
				var objForm = $("#form_58e5cbe7ddb15");
				objForm.find("input[type='text']:not(:disabled), textarea:not(:disabled)").each(function() {
					$(this).val($(this).val().replace(/'/g, "''").replace(/' '/g, ""));
				});
				objForm.find("input[content-mode='numeric']").each(function() {
					$(this).val($(this).val().replace(/,/g, "").replace(/' '/g, ""));
				});
				$.ajax({
					type: "POST",
					url: objForm.attr("action"),
					data: objForm.serialize(),
					beforeSend: function() {
						dialog = new BootstrapDialog({
							title: 'Information',
							message: 'Please wait, saving data...',
							type: BootstrapDialog.TYPE_PRIMARY,
							buttons: [{
								id: 'cmd-loading',
								label: 'Please Wait...',
								cssClass: 'btn-default disabled',
								hotkey: 13
							}]
						});
						dialog.open();
					},
					success: function(r) {
						var JSON = $.parseJSON(r);
						if (JSON.status === 1)
							window.location.href = "<?php print site_url(); ?>c_user_menu/";
						else {
							dialog.getModalBody().html(JSON.message);
							dialog.setType(BootstrapDialog.TYPE_PRIMARY);
							dialog.getModalFooter().find("button[id='cmd-loading']").removeClass("disabled").html("Close").unbind("click").bind("click", function() {
								dialog.close();
							});
						}
					}
				});
			}
		});
	});

	function gf_load_data() {
		$("#div-list-user").ado_load_paging_data({
			url: "<?php print site_url(); ?>c_logout/gf_load_data/"
		});
	}
</script>