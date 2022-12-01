<?php
$oConfig = $o_extra['o_config'];
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
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List User</a></li>
		<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form User</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>">
			<div id="div-list-user">
			</div>
		</div>
		<!-- /.tab-pane -->
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>">
			<form id="frmCoreUserLogin" role="form" action="<?php print site_url(); ?>c_core_user_login/gf_transact" method="post">
				<div class="box-body no-padding">
					<div class="row">
						<div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 form-group" id="div-top">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group hidden">
									<label>User Id</label>
									<input allow-empty="false" type="text" placeholder="User Id" name="txtUserId" id="txtUserId" class="form-control" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nUserId']); ?>" maxlength="50" readonly>
								</div>
								<div class="row"></div>
								<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
									<label>User Name</label>
									<input allow-empty="false" type="text" placeholder="User Name" name="txtUserName" id="txtUserName" class="text-bold form-control" value="<?php print trim($o_data[0]['sUserName']); ?>" maxlength="100">
									<input type="hidden" value="<?php print trim($o_data[0]['sUserName']); ?>" name="txtUserNameOld" id="txtUserNameOld" />
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 form-group">
									<label>Password</label>
									<input allow-empty="false" type="password" placeholder="Password" name="txtPassword" id="txtPassword" class="form-control" value="<?php print trim($o_data[0]['sPassword']); ?>" maxlength="100">
									<input type="hidden" name="txtPasswordOld" id="txtPasswordOld" value="<?php print trim($o_data[0]['sPassword']); ?>" />
								</div>
								<div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 form-group">
									<label>Re-Type Password</label>
									<input allow-empty="false" type="password" placeholder="Password" name="txtPasswordAgain" id="txtPasswordAgain" class="form-control" value="<?php print trim($o_data[0]['sPassword']); ?>" maxlength="100">
								</div>
								<div class="row"></div>
								<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
									<label>Real Name</label>
									<input allow-empty="false" type="text" placeholder="Real Name" name="txtRealName" id="txtRealName" class="text-bold form-control" value="<?php print trim($o_data[0]['sRealName']); ?>" maxlength="200">
								</div>
								<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
									<label>Email</label>
									<input allow-empty="false" type="text" placeholder="Email" name="txtEmail" id="txtEmail" class="form-control" value="<?php print trim($o_data[0]['sEmail']); ?>" maxlength="100">
									<input type="hidden" value="<?php print trim($o_data[0]['sEmail']); ?>" name="txtEmailOld" id="txtEmailOld" />
								</div>
								<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
									<label>Allow User Access Unit</label>
									<table class="<?php print $oConfig['TABLE_CLASS']; ?>" id="tableDetailUserGroupUnit">
										<tr>
											<td>No</td>
											<td>Unit Name</td>
											<td class="text-center">
												<input type="checkbox" name="chkSelecAllUserGroupUnitUserGroupUnit" id="chkSelecAllUserGroupUnit" />
											</td>
										</tr>
										<?php
										$oUnit = json_decode($o_unit, TRUE);
										print $oUnit['data'];
										?>
									</table>
								</div>
								<div class="row"></div>
								<div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 form-group">
									<label>Allow User Group Access</label>
									<br />
									<div class="btn-group">
										<button type="button" name="cmdAddRow" id="cmdAddRow" class="btn btn-default"><i class="fa fa-plus"></i> Tambah User Group</button>
										<button type="button" name="cmdClearRow" id="cmdClearRow" class="btn btn-danger"><i class="fa fa-trash"></i> Hapus Semua User Group</button>
									</div>
									<table class="<?php print $oConfig['TABLE_CLASS']; ?>" id="tableDetailUserGroup" style="margin-top: 15px;">
										<tr>
											<td>No</td>
											<td>User Group</td>
											<!--<td>Division</td>
											<td>Departemen</td>
											<td>Approval User</td>-->
											<td class="text-center">
												<i id="iClearAllRow" class="fa fa-trash fa-2x text-red cursor-pointer" title="Remove all Row"></i>
											</td>
										</tr>
										<?php
										$oUnit = json_decode($o_group, TRUE);
										print $oUnit['data'];
										?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<select id="selUserGroupList" class="hidden">
					<?php print $o_user_group; ?>
				</select>
				<select id="selUserDivisiList" class="hidden">
					<?php print $o_divisi; ?>
				</select>
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
	var oObjTabelUserGroup = $("#tableDetailUserGroup");
	$(function() {
		gf_load_data();
		$("button[id='button-submit']").click(function() {
			if ($.trim($(this).html()) === "Cancel")
				$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
			else {
				var bNext = true;
				var objForm = $("#frmCoreUserLogin");
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
				if (bNext) {
					if ($.trim($("#txtPassword").val()) !== $.trim($("#txtPasswordAgain").val())) {
						$("<div id=\"div-alert\" style='margin: 15px;' class=\"alert alert-error alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>Password not match...	</p></div>").insertBefore($("#div-top"));
						bNext = false;
						return false;
					}
				}
				//------------------------------
				if($("#hideMode").val() !== "D") {
					var o = gf_check_data();
					if(o > 0) {
						$.gf_msg_info({
							oObjDivAlert: $("#div-top"),
							oAddMarginLR: true,
							oMessage: "Sistem menemukan User Group GANDA. Periksa kembali data detail User Group Anda !"
						});
						bNext = false;
						return false;
					}
				}
				//------------------------------
				if (!bNext)
					return false;
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
		$("#chkSelecAllUserGroupUnit").on("click", function() {
			if ($(this).prop("checked"))
				$("#tableDetailUserGroupUnit").find("input[type='checkbox']").prop("checked", true);
			else
				$("#tableDetailUserGroupUnit").find("input[type='checkbox']").prop("checked", false);
		});
		$("#chkSelecAllUserGroupAccess").on("click", function() {
			if ($(this).prop("checked"))
				$("#tableDetailUserGroup").find("input[type='checkbox']").prop("checked", true);
			else
				$("#tableDetailUserGroup").find("input[type='checkbox']").prop("checked", false);
		});
		$("#txtUserName").on("keyup", function()
		{
			$("#txtEmail").val($(this).val());
		});
		$("table tr td").css("vertical-align", "middle");
		$("table").find("tr:gt(0)").find("td:eq(0)").css("text-align", "right");
		$("#tableDetailUserGroup").find("tr:gt(0)").find("td:last input[type='checkbox']").on("click", function() {
			if($(this).is(":checked")) {
				$(this).parent().prev().find("select").addClass("disabled");
				$(this).parent().prev().prev().find("select").addClass("disabled");
				$(this).parent().prev().find("select").prop("disabled", false);
				$(this).parent().prev().prev().find("select").prop("disabled", false);
			}
			else {
				$(this).parent().prev().find("select").removeClass("disabled");
				$(this).parent().prev().prev().find("select").removeClass("disabled");
				$(this).parent().prev().find("select").prop("disabled", true);
				$(this).parent().prev().prev().find("select").prop("disabled", true);
			}
			$("select").selectpicker('refresh');
		});
		$("i[id='iClearAllRow']").on("click", function() {
			$("i[id='iRemoveRow']").trigger("click");
			$.gf_reset_seq_no_table({oObjTable: oObjTabelUserGroup, oAlignText: "text-right"});
		});
		$("button[id='cmdAddRow']").on("click", function() {
			var oTable = oObjTabelUserGroup;
			if($.trim(oTable.find("tr:last").find("td:eq(1)").find("select").find("option:selected").val()) === "")
				return false;
			var bNext = true;
			var clonedRow = oTable.find("tr:eq(1)").clone();
			oTable.append(clonedRow);
			oTable.find("tr:last").find("td:eq(1)").html("<select class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" id=\"selUserGroups\" placeholder=\"User Group\" allow-empty=\"false\" name=\"selUserGroups[]\" init=\"0\">"+$("select[id='selUserGroupList']").html()+"</select>");
			$.gf_reset_seq_no_table({oObjTable: oTable, oAlignText: "text-right"});
			oTable.find("tr:last").find("td:eq(1)").find("select[id='selUserGroups']").find("option:eq(0)").prop("selected", true);
			oTable.find("tr:last").find("td:eq(1)").find("select[id='selUserGroups']").selectpicker('refresh');
			gf_bind_event();
		});
		gf_bind_event();
		/*$("select[id='selUserGroupsApproval']").on("change", function() {
			var oObj = $(this);
			var oObjUserName = oObj.parent().parent().next().find("select");
			var nGropuUserId = oObj.val();
			if(nGropuUserId !== "") {
				//--Load Karyawan By User Groups
				$.ajax({
					type: "POST",
					url: "<?php print site_url(); ?>c_core_user_login/gf_load_user_by_group_user/",
					data: {
						nGropUserId: $.trim(nGropuUserId),
					},
					beforeSend: function() {
						oObjUserName.empty().html("<option>Loading...</option>").addClass("disabled").prop("disabled", true).selectpicker("refresh");
					},
					success: function(r) {
						oObjUserName.empty().removeClass("disabled").prop("disabled", false).html(r);
						oObjUserName.find("option[value='"+oObj.attr("init")+"']").attr("selected", "selected");
						oObjUserName.selectpicker("refresh");
					}
				});
			}
		});
		$("a[href='#tab_1']").on("click", function()
		{
			gf_load_data();
		});
		$("a[href='#tab_2']").on("click", function()
		{
			gf_load_store();
		});
		$("select").selectpicker("refresh");
		gf_load_store();*/
		if($.trim("<?php print $o_mode; ?>") !== "I") {
			$("select[id='selUserGroups']").each(function(i, n) {
				$(this).find("option[value='"+$(this).attr("init")+"']").prop("selected", true);			
			});
			$("select[id='selDivision']").each(function(i, n) {
				$(this).find("option[value='"+$(this).attr("init")+"']").prop("selected", true);			
			});
			$.gf_reset_seq_no_table({oObjTable: oObjTabelUserGroup, oAlignText: "text-right"});
		}
		$("select").selectpicker('refresh');
	});

	function gf_load_data() {
		$("#div-list-user").ado_load_paging_data({
			url: "<?php print site_url(); ?>c_core_user_login/gf_load_data/"
		});
	}

	function gf_load_store() {
		$.ajax({
			type: "POST",
			url: "<?php print site_url(); ?>c_core_user_login/gf_load_store/",
			data: {
				nUserId: $.trim($("#txtUserId").val()),
			},
			beforeSend: function() {
				$("#divUserStore").fadeOut("fast", function() {
					$(this).empty().html($.gf_spinner() + "<div class=\"text-center\">Loading Menus...</div>").fadeIn("fast");
				});
			},
			success: function(r) {
				$("#divUserStore").fadeOut("fast", function() {
					$(this).empty().html(r).fadeIn("fast");
				});
			}
		});
	}

	function gf_bind_event() {
		$("span[id='spanSearchApprovalName']").on("click", function() {
			var oObj = $(this);
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
																		oObj.parent().find("input[type='hidden']").val(this.User_Id);
																		oObj.parent().find("input[type='text']").val(this.Nama_Karyawan);
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
															],
														onshown: function(d) {
															$("input[type='text'][id^='txtSearchWhat']").focus()
														}
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
		$("i[id='iRemoveRow']").on("click", function() {
			if(oObjTabelUserGroup.find("tr").length === 2) {
				console.log("a");
				$(this).parent().parent().find("select").find("option[value='']").prop("selected", "selected")
				$(this).parent().parent().find("input[type='text']").val("");
				$("select").selectpicker('refresh');
			}
			else {
				console.log("b");
				$(this).parent().parent().remove()
			}
		});
	}

	function gf_check_data() {
		var nReturn = 0;
		oObjTabelUserGroup.find("tr:gt(0)").each(function(i, n) {
			var nUserGroupIdLast = $(this).prev().find("td:eq(1)").find("select").find("option:selected").val();
			var nUserGroupId = $(this).find("td:eq(1)").find("select").find("option:selected").val();
			if(parseInt(nUserGroupId) === parseInt(nUserGroupIdLast)) {
				nReturn = 1;
			}		
		});
		if(nReturn > 0)	
			return nReturn;	
		return nReturn;	
	}

</script>