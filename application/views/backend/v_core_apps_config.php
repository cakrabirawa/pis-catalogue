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
$oConfig = $o_extra['o_config'];
?>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">Form Apps Config</a></li>
	</ul>
	<div class="tab-content">
		<!-- /.tab-pane -->
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>">
			<form id="form_59152e81cb581" role="form" action="<?php print site_url(); ?>c_core_apps_config/gf_transact" method="post">
				<div class="box-body no-padding">
					<div class="row">
						<div class="btn-group" style="margin-left: 15px;">
							<button type="button" class="btn btn-primary" name="cmd-add-row" id="cmd-add-row">Add Row</button>
							<button type="button" name="cmd-clear-all" id="cmd-clear-all" class="disable btn btn-danger">Clear All</button>
						</div>
						<div class="row margin-bottom"></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="div-table-wrapper">
							<div id="slimScrollDiv">
								<table id="table-detail" class="<?php print $oConfig['TABLE_CLASS']; ?>">
									<tbody>
										<tr>
											<td>No</td>
											<td>Config Key</td>
											<td>Config Value</td>
											<td class="text-center">Remove</td>
										</tr>
										<?php
										print $o_data_detail;
										?>
									</tbody>
								</table>
							</div>
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
	var bFromBlur = false;
	$(function() {
		$("button[id='button-submit']").click(function() {
			if ($.trim($(this).html()) === "Cancel")
				$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
			else {
				var bNext = true;
				var objForm = $("#form_59152e81cb581");
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
						if (JSON.status === 1) {
							$("#table-detail").find("input[type='text'][value='']:last").focus();
						} else {
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
		$("button[id='cmd-add-row']").on("click", function() {
			var oObjTable = $("#table-detail");
			if ($.trim(oObjTable.find("tr:last").find("td:eq(1) input[type='text']").val()) !== "") {
				oObjTable.find("tr:nth-child(2)").clone().insertBefore(oObjTable.find("tr:eq(1)"));
				oObjTable.find("tr:eq(1)").find("input[type='text']").val("");
				oObjTable.find("tr:eq(1)").find("td:eq(1)").find("input[type='text']").focus();
				$.gf_reset_seq_no_table({
					oObjTable: oObjTable
				});
				gf_bind_event();
			}
		});
		$("button[id='cmd-clear-all']").on("click", function() {
			var oObjTable = $("#table-detail");
			oObjTable.find("tr:gt(1)").remove();
			oObjTable.find("tr:last").find("input[type='text']").val("");
			$.gf_reset_seq_no_table({
				oObjTable: oObjTable
			});
		});
		$("a[id='cmd-remove-row']").on("click", function() {
			$(this).parent().parent().remove();
			$.gf_reset_seq_no_table({
				oObjTable: $("#table-detail")
			})
		});
		$.gf_reset_seq_no_table({
			oObjTable: $("#table-detail")
		})
		gf_bind_event()
		gf_bind_virtual_scroller();
	});

	function gf_bind_event() {
		$("input[id='txtConfigKey']").on("blur", function() {
			$("button[id='button-submit']:eq(0)").trigger("click");
		});
		$("input[id='txtConfigValue']").on("blur", function() {
			$("button[id='button-submit']:eq(0)").trigger("click");
		});
	}

	function gf_bind_virtual_scroller() {
		$("#slimScrollDiv").slimScroll({
			position: 'right',
			width: '100%',
			height: '550px',
			railVisible: false,
			color: '#000',
			railColor: '#fff',
			alwaysVisible: false,
			distance: '2px',
			wheelStep: "<?php print $oConfig['WHEEL_STEP_BODY_SCROLL']; ?>",
			size: '8px',
			allowPageScroll: true,
			disableFadeOut: false,
		});
	}
</script>