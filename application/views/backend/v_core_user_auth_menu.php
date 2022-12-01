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
		<li class="active"><a data-toggle="tab" href="#tab_1">Form Auth Menu</a></li>
	</ul>
	<div class="tab-content">
		<form id="frmCoreUserAuth" name="frmCoreUserAuth" action="<?php print site_url(); ?>c_core_user_auth_menu/gf_transact/" method="post">
			<div id="tab_1" class="tab-pane active ?>">
				<div class="box-body no-padding">
					<div class="row" id="div-top">
						<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 form-group">
							<label>Group User Name</label>
							<select name="selGroupUserAuth" id="selGroupUserAuth" class="form-control selectpicker" data-size="8" data-live-search="true" allow-empty="false" placeholder="User Group">
								<?php print $o_user_group; ?>
							</select>
						</div>
						<div class="col-xs-6 col-sm-6 col-md-4 col-lg-3 form-group">
							<label>Unit Name</label>
							<select name="selUnit" id="selUnit" class="form-control selectpicker" data-size="8" data-live-search="true" placeholder="Unit Name">
								<?php print $o_user_unit; ?>
							</select>
						</div>
						<!--<div class="col-sm-3 col-xs-12 form-group" id="div-top">
			        <label>User Count</label>
			        <span class="form-control" id="spanUser" name="spanUser">0 Users</span>
			      </div>-->
						<div class="row"></div>
						<div class="col-xs-4 col-sm-5 col-md-4 col-lg-3 form-group hidden" id="div-shortcut">
							<div class="btn-group">
								<button type="button" class="btn btn-default" id="btn-upload-mode">Option Mode</button>
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<span class="caret"></span>
									<span class="sr-only">Toggle Dropdown</span>
								</button>
								<ul class="dropdown-menu" role="menu" id="select-mode">
									<li><a href="#">Visible All</a></li>
									<li class="divider"></li>
									<li><a href="#">Save All</a></li>
									<li><a href="#">Update All</a></li>
									<li><a href="#">Delete All</a></li>
									<li class="divider"></li>
									<li><a href="#">Select All</a></li>
									<li class="divider"></li>
									<li><a href="#">Clear All</a></li>
								</ul>
							</div>
						</div>
						<div class="row"></div>
						<div class="col-sm-12 col-xs-12 col-lg-12 col-md-12">
							<div id="div-auth-content">
							</div>
						</div>
					</div>
				</div>
				<div class="box-footer no-padding">
					<br />
					<?php print $oButton; ?>
					<input type="hidden" name="hideMode" id="hideMode" value="" />
				</div>
			</div>
		</form>
	</div>
</div>
<script>
	$(function() {
		$("#selGroupUserAuth").on("change", function() {
			if ($.trim($(this).find("option:selected").val()) === "")
				return false;

			if ($.trim($("#selUnit").find("option:selected").val()) === "" && parseInt($(this).find("option:selected").val()) !== 0) {
				$("#selUnit").focus();
				return false;
			}
			gf_load_data_auth();
		});
		$("#selUnit").on("change", function() {
			if ($.trim($(this).find("option:selected").val()) === "" && parseInt($(this).find("option:selected").val()) !== 0)
				return false;

			if ($.trim($("#selGroupUserAuth").find("option:selected").val()) === "") {
				$("#selGroupUserAuth").focus();
				return false;
			}
			gf_load_data_auth();
		});
		$("#select-mode li a").on("click", function() {
			var sMode = $(this).html();
			var oObjDivResult = $("#div-auth-content");
			if (sMode === "Visible All") {
				oObjDivResult.find("input[type='checkbox'][id='chkVisible']").prop("checked", true);
			} else if (sMode === "Save All") {
				oObjDivResult.find("input[type='checkbox'][id='chkSave']").prop("checked", true);
			} else if (sMode === "Update All") {
				oObjDivResult.find("input[type='checkbox'][id='chkUpdate']").prop("checked", true);
			} else if (sMode === "Delete All") {
				oObjDivResult.find("input[type='checkbox'][id='chkDelete']").prop("checked", true);
			} else if (sMode === "Select All") {
				oObjDivResult.find("input[type='checkbox'][id='chkDelete'], input[type='checkbox'][id='chkUpdate'], input[type='checkbox'][id='chkSave'], input[type='checkbox'][id='chkVisible']").prop("checked", true);
			} else if (sMode === "Clear All") {
				oObjDivResult.find("input[type='checkbox'][id='chkDelete'], input[type='checkbox'][id='chkUpdate'], input[type='checkbox'][id='chkSave'], input[type='checkbox'][id='chkVisible']").prop("checked", false);
			}
		});
		$("button[id='button-submit']").click(function() {
			if ($.trim($(this).html()) === "Cancel")
				$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
			else {
				var bNext = true;
				var objForm = $("#frmCoreUserAuth");
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
						"oObjDivAlert": $("#div-top")
					});
					bNext = oRet.oReturnValue;
				}
				//------------------------------------------     		
				if (!bNext)
					return false;

				var oObjDivResult = $("#div-auth-content");

				objForm.append("<input type=\"hidden\" name=\"nGroupUserId\" id=\"nGroupUserId\" value=\"" + $("#selGroupUserAuth").find("option:selected").val() + "\" />");
				objForm.append("<input type=\"hidden\" name=\"nUnitId\" id=\"nUnitId\" value=\"" + $("#selUnit").find("option:selected").val() + "\" />");
				oObjDivResult.find("table tr:gt(0)").each(function(i, n) {
					var nMenuId = $(this).find("td:eq(0)").html();
					var nVisible = ($(this).find("td:eq(3)").find("input[type='checkbox']").prop("checked") ? "1" : "0");
					var nSave = ($(this).find("td:eq(4)").find("input[type='checkbox']").prop("checked") ? "1" : "0");
					var nUpdate = ($(this).find("td:eq(5)").find("input[type='checkbox']").prop("checked") ? "1" : "0");
					var nDelete = ($(this).find("td:eq(6)").find("input[type='checkbox']").prop("checked") ? "1" : "0");

					objForm.append("<input type=\"hidden\" name=\"nMenuId[]\" id=\"nMenuId\" value=\"" + nMenuId + "\" />");
					objForm.append("<input type=\"hidden\" name=\"sVisible[]\" id=\"sVisible\" value=\"" + nVisible + "\" />");
					objForm.append("<input type=\"hidden\" name=\"sSave[]\" id=\"sSave\" value=\"" + nSave + "\" />");
					objForm.append("<input type=\"hidden\" name=\"sUpdate[]\" id=\"sUpdate\" value=\"" + nUpdate + "\" />");
					objForm.append("<input type=\"hidden\" name=\"sDelete[]\" id=\"sDelete\" value=\"" + nDelete + "\" />");
				});
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
		$("select").selectpicker("refresh");
	});

	function gf_load_data_auth() {
		$.ajax({
			type: "POST",
			url: "<?php print site_url(); ?>c_core_user_auth_menu/gf_load_auth_menu/",
			data: {
				nGroupUserId: $.trim($("#selGroupUserAuth").val()),
				nUnitId: $.trim($("#selUnit").val())
			},
			beforeSend: function() {
				$("#div-auth-content").fadeOut("fast", function() {
					$(this).empty().html($.gf_spinner() + "<div class=\"text-center\">Loading Menus...</div>").fadeIn("fast");
				});
			},
			success: function(r) {
				$("#div-auth-content").fadeOut("fast", function() {
					$(this).empty().html(r).fadeIn("fast");
				});
				$("#div-shortcut").removeClass("hidden");
			}
		});
	}

	function gf_bind_click() {
		$("#div-auth-content").find("table tr:gt(0)").find("td:gt(2):lt(7)").addClass("text-center");
		$("#div-auth-content").find("table tr:gt(0)").find("td:eq(3) input[type='checkbox']").unbind("click").on("click", function() {
			if ($(this).prop("checked")) {
				$(this).parent().next().find("input[type='checkbox']").prop("checked", true);
				$(this).parent().next().next().find("input[type='checkbox']").prop("checked", true);
				$(this).parent().next().next().next().find("input[type='checkbox']").prop("checked", true);
			} else {
				$(this).parent().next().find("input[type='checkbox']").prop("checked", false);
				$(this).parent().next().next().find("input[type='checkbox']").prop("checked", false);
				$(this).parent().next().next().next().find("input[type='checkbox']").prop("checked", false);
			}
		});
	}
</script>