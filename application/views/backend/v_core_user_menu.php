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
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List User Menu</a></li>
		<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form User Menu</a></li>
		<li class=""><a data-toggle="tab" href="#tab_3">Font Awesome Cheet Sheet</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab_3" class="tab-pane">
			<?php $this->load->view('backend/v_core_fa_icon'); ?>
		</div>
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>">
			<div id="div-list-user">
			</div>
		</div>
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>">
			<form id="frmCoreUserMenu" role="form" action="<?php print site_url(); ?>c_core_user_menu/gf_transact" method="post">
				<div class="box-body no-padding">
					<div class="row">
						<div class="col-sm-3 col-xs-12 col-md-3 col-lg-2 form-group hidden" id="div-top">
							<label>Menu Id</label>
							<input allow-empty="false" type="text" placeholder="Menu Id" name="txtMenuId" id="txtMenuId" class="form-control" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nMenuId']); ?>" maxlength="50" readonly>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 form-group">
							<label>Parent Menu</label>
							<select name="selParentUserMenu" id="selParentUserMenu" class="form-control selectpicker" data-size="8" data-live-search="true">
								<option value="">--Pilih--</option>
								<?php print $o_parent_menu; ?>
							</select>
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 form-group">
							<label>Menu Name</label>
							<input allow-empty="false" type="text" placeholder="Menu Name" name="txtMenuName" id="txtMenuName" class="form-control" value="<?php print trim($o_data[0]['sMenuName']); ?>" maxlength="100">
							<input type="hidden" value="<?php print trim($o_data[0]['sMenuName']); ?>" name="txtMenuNameOld" id="txtMenuNameOld" />
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3 form-group">
							<label>Menu Controller Name</label>
							<input type="text" placeholder="Menu Controller Name" name="txtMenuCtlName" id="txtMenuCtlName" class="form-control" value="<?php print trim($o_data[0]['sMenuCtlName']); ?>" maxlength="100">
						</div>
						<div class="row"></div>
						<div class="col-xs-4 col-sm-12 col-md-2 col-lg-2 form-group">
							<label>Order</label>
							<input type="text" content-mode="numeric" placeholder="Order" allow-empty="false" name="txtMenuOrder" id="txtMenuOrder" class="form-control" value="<?php print trim($o_mode) === "I" ? $o_max_menu_order : trim($o_data[0]['nMenuOrder']); ?>" maxlength="100">
						</div>
						<div class="col-xs-8 col-sm-12 col-md-6 col-lg-4 form-group">
							<label>Menu Icon</label>
							<div class="input-group">
								<input placeholder="Menu Icon Code" type="text" class="form-control" id="txtMenuIcon" name="txtMenuIcon" value="<?php print trim($o_data[0]['sMenuIcon']); ?>">
							</div>
						</div>
						<div class="row"></div>
						<div class="col-xs-5 col-sm-12 col-md-3 col-lg-2 form-group">
							<label>Generate Menu For</label>
							<select name="selMode" id="selMode" allow-empty="false" class="form-control selectpicker" placeholder="Generate Menu For" data-size="8" data-live-search="true">
								<option value="">--Pilih--</option>
								<option value="1" <?php print trim($o_data[0]['nMenuMode']) === "1" ? "selected" : ""; ?>>Back End</option>
								<option value="2" <?php print trim($o_data[0]['nMenuMode']) === "2" ? "selected" : ""; ?>>Front End</option>
							</select>
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
	var sSURL = "<?php print site_url(); ?>c_core_user_menu/gf_upload/";
	var sParam = "";
	var dialog = "";

	$(function() {
		gf_load_data();
		$("input[content-mode='numeric']").autoNumeric('init', {
			mDec: '0'
		});
		$("button[id='button-submit']").click(function() {
			if ($.trim($(this).html()) === "Cancel")
				$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
			else {
				var bNext = true;
				var objForm = $("#frmCoreUserMenu");
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
		$("#selParentUserMenu").on("change", function() {
			var objForm = $.gf_create_form({
				"action": "<?php print site_url(); ?>c_core_user_menu/gf_get_menu_order"
			});
			objForm.append("<input type=\"hidden\" name=\"nMenuParentId\" id=\"nMenuParentId\" value=\"" + $(this).find("option:selected").val() + "\" />");
			$.gf_custom_ajax({
				"oForm": objForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					$("#txtMenuOrder").val(JSON.nMaxMenuOrder);
				},
				"validate": true,
				"beforeSend": function(r) {},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
		});
		$("select").selectpicker('refresh');
	});

	function gf_load_data() {
		$("#div-list-user").ado_load_paging_data({
			url: "<?php print site_url(); ?>c_core_user_menu/gf_load_data/"
		});
	}
</script>