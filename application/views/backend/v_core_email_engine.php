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
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List Email Engine</a></li>
		<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form Email Engine</a></li>
	</ul>
	<div class="tab-content">
		<!-- End of Example Tab Email Engine -->
		<!-- List Tab Email Engine List -->
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>">
			<div id="div-list-user" class="table-responsive">
				<table id="table-directory" class="<?php print $oConfig['TABLE_CLASS']; ?>">
					<tbody>
						<tr>
							<td>File No</td>
							<td>File Name</td>
							<td>File Size</td>
							<td>File Modified Date</td>
							<td class="text-center">Action</td>
						</tr>
						<?php
						//$data = json_decode($o_root_dir, TRUE);
						//foreach($data['data'] as $key => $val)
						//	print $val;
						?>
					</tbody>
				</table>
			</div>
		</div>
		<!-- End of List Tab Email Engine List -->
		<!-- List Tab Design Engine List -->
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>">
			<form id="form_58d1e5952fb12" role="form" action="<?php print site_url(); ?>c_core_email_engine/gf_transact" method="post">
				<div class="box-body no-padding">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 form-group" id="div-top">
							<label>Email Template Name</label>
							<input placeholder="Email Engine Name" allow-empty="false" type="text" class="form-control" id="txtReportEngineName" name="txtReportEngineName" value="<?php print trim($o_data[0]['sMenuIcon']); ?>">
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 form-group"><label>Email Engine Description</label>
							<textarea id="txtReportEngineDesc" name="txtReportEngineDesc" class="form-control" style="max-height: 125px;" placeholder="Email Engine Description"></textarea>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-3 form-group"><label>Field Name</label>
							<select name="selFields" id="selFields" class="form-control selectpicker" data-size="8" data-live-search="true" class="disabled">
								<option value="">None</option>
							</select>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-2 col-lg-1 form-group"><label>Run SQL</label> <br />
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Action
									<span class="caret"></span></button>
								<ul class="dropdown-menu">
									<li><a id="cmdTestQuery" href="#"><i class="fa fa-play"></i>Run Query</a></li>
									<li class="divider"></li>
									<li><a id="cmdPreviewQuery" href="#"><i class="fa fa-cog"></i>Preview Email</a></li>
								</ul>
							</div>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-5 col-lg-3 form-group"><label>Markup Field</label>
							<input type="text" id="txtFields" name="txtFields" class="form-control" placeholder="Field Name" />
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<label>Native SQL</label>
									<pre id="txtNativeSQL" style="min-height:400px;"></pre>
								</div>
								<div class="row"></div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
									<label>Native HTML</label>
									<pre id="txtNativeHTML" style="min-height:400px;"></pre>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<label>HTML Preview</label>
							<div id="divEmailPreview">
							</div>
						</div>
					</div>
				</div>
				<!-- End of Tab Design Engine List -->
				<div class="row"></div>
				<div class="box-footer no-padding">
					<br />
					<?php print $oButton; ?>
					<input type="button" name="cmdForceSave" id="cmdForceSave" class="btn btn-danger" value="Force Save" />
				</div>
				<input type="hidden" name="hideMode" id="hideMode" value="" />
				<input type="hidden" name="hideNativeSQL" id="hideNativeSQL" value="" />
				<input type="hidden" name="hideNativeHTML" id="hideNativeHTML" value="" />
			</form>
		</div>
	</div>
	<!-- /.tab-content -->
</div>
<script>
	var sSURL = "<?php print site_url(); ?>c_core_email_engine/gf_upload/"
	var sParam = "";
	var dialog = "";
	var editorSQL = null;
	var editorHTML = null;
	var globalpath = null;
	var globalfile = null;
	var globalfiletemp = null;
	$(function() {
		gf_init_editor();
		gf_bind_click();
		$('textarea').each(function() {
			autosize(this);
		});
		$("input[content-mode='numeric']").autoNumeric('init');
		$("button[id='button-submit']").click(function() {
			if ($.trim($(this).html()) === "Cancel")
				$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
			else {
				var bNext = true;
				$("#div-alert").remove();
				$.each($("#form_58d1e5952fb12").find("input[allow-empty='false'], select[allow-empty='false'], textarea[allow-empty='false']"), function(i, n) {
					if ($.trim($(this).val()) === "") {
						$.gf_custom_notif({
							"oAddMarginLR": true,
							"sMessage": "<p>" + $(this).attr("placeholder") + " can't Empty...</p>",
							"oObjDivAlert": $("#div-top")
						});
						bNext = false;
						return false;
					}
				});
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
				var objForm = $("#form_58d1e5952fb12");
				objForm.attr("action", "<?php print site_url(); ?>c_core_email_engine/gf_transact/");
				objForm.removeAttr("target");

				$("#hideNativeSQL").val(editorSQL.getValue());
				$("#hideNativeHTML").val(editorHTML.getValue());
				$("#txtReportEngineName").val($("#txtReportEngineName").val().replace(/[^A-Za-z0-9.]/gi, "_"));

				$.gf_custom_ajax({
					"oForm": objForm,
					"success": function(r) {
						var JSON = $.parseJSON(r.oRespond);
						if (JSON.status === 1)
							$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
						else if (JSON.status === -1) {
							$.gf_remove_all_modal();
							dialog = new BootstrapDialog({
								title: 'Information',
								message: 'Please wait, saving data...',
								type: BootstrapDialog.TYPE_DEFAULT,
								buttons: [{
									id: 'cmd-loading',
									label: 'Please Wait...',
									cssClass: 'btn-default disabled',
									hotkey: 13
								}]
							});
							dialog.open();
							dialog.getModalBody().html(JSON.message);
							dialog.getModalBody().find("button[id='cmdOverwrite']").on("click", function() {
								dialog.close();
								objForm.append("<input type=\"hidden\" name=\"nOverwrite\" id=\"nOverwrite\" value=\"Yes\" />");
								//$("button[id='button-submit']").trigger("click");
								$.gf_custom_ajax({
									"oForm": objForm,
									"success": function(r) {
										var JSON = $.parseJSON(r.oRespond);
										if (JSON.status === 1)
											$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
									},
									"validate": true,
									"beforeSend": function(r) {
										//$.gf_custom_modal({"sMessage": $.gf_spinner() + "Loading Report..."});	
									},
									"beforeSendType": "standard",
									"error": function(r) {}
								});
							});
							dialog.setType(BootstrapDialog.TYPE_DEFAULT);
							dialog.getModalFooter().find("button[id='cmd-loading']").removeClass("disabled").html("Close").unbind("click").bind("click", function() {
								dialog.close();
							});
						}
					},
					"validate": true,
					"beforeSend": function(r) {
						//$.gf_custom_modal({"sMessage": $.gf_spinner() + "Loading Report..."});	
					},
					"beforeSendType": "standard",
					"error": function(r) {}
				});
				//------------------------------------------ 
			}
		});
		$("#selFields").on("change", function() {
			$("#txtFields").val("[" + $("#selFields").find("option:selected").val() + "]");
		});
		$("#cmdPreviewQuery").unbind("click").on("click", function() {
			var objForm = $("#form_58d1e5952fb12");
			$("#hideNativeSQL").val(editorSQL.getValue());
			$("#hideNativeHTML").val(editorHTML.getValue());
			if ($.trim($("#hideNativeSQL").val()) === "")
				return false;
			else {
				objForm.attr("action", "<?php print site_url(); ?>c_core_email_engine/gf_preview_reports/");
				//objForm.attr("target", "_blank");
				//objForm.submit();
				var oResult = null;
				$.gf_custom_ajax({
					"oForm": objForm,
					"success": function(r) {
						$.gf_remove_all_modal();
						var JSON = $.parseJSON(r.oRespond);
						oResult = JSON.oData;
						oDialog = new BootstrapDialog({
							title: 'Preview Email Query',
							closable: false,
							message: $.gf_spinner(),
							type: BootstrapDialog.TYPE_DEFAULT,
							buttons: [{
								id: 'cmd-close',
								label: 'Close',
								cssClass: 'btn-default',
								hotkey: 13,
								action: function(r) {
									r.close();
								}
							}],
							onshown: function(r) {
								r.getModalBody().empty().html(oResult.replace("<br><br><br><br>", ""));
							}
						});
						oDialog.open();
					},
					"validate": true,
					"beforeSend": function(r) {
						$.gf_custom_modal({
							"sMessage": $.gf_spinner() + "Please wait, Generate preview Email..."
						});
					},
					"beforeSendType": "standard",
					"error": function(r) {}
				});
			}
		});
		$("#cmdPreviewLive").on("click", function() {
			var oObjForm = $("#form_58d1e5952fb13");
			oObjForm.submit();
		});
		globalpath = '<?php print base64_encode(getcwd() . DIRECTORY_SEPARATOR . "emails"); ?>';
		gf_load_dir({
			"globalpath": globalpath,
			"mode": ""
		});
		$("select").selectpicker('refresh');
	});
	function gf_bind_click() {
		$("#table-directory tr td:nth-child(5) a").unbind("click").click(function() {
			if ($(this).attr("mode") === "rename") {
				gf_rename_file_folder({
					"oldname": $(this).parent().parent().find("td:nth-child(2)").text(),
					"path": globalpath
				});
			} else if ($(this).attr("mode") === "delete") {
				gf_delete_file_folder({
					"obj": $(this),
					"type": ($.trim($(this).parent().parent().find("td:nth-child(4)").text()) === "Dir" ? "folder" : "file"),
					"name": $(this).parent().parent().find("td:nth-child(2)").text(),
					"path": globalpath
				});
			} else if ($(this).attr("mode") === "copy") {
				gf_copy_file_folder({
					"oldname": $(this).parent().parent().find("td:nth-child(2)").text(),
					"path": globalpath
				});
			}
		});
		$("#table-directory tr td:nth-child(2) a").unbind("click").click(function() {
			var sMode = $.trim($(this).parent().parent().find("td:nth-child(4)").text());
			globalpath = $(this).attr("path");
			globalfile = $.trim($(this).parent().parent().find("td:nth-child(2)").text());

			if (sMode === "Dir")
				gf_load_dir({
					"globalpath": globalpath,
					"mode": sMode
				});
			else
				gf_load_file({
					"globalpath": globalpath,
					"mode": sMode
				});
		});
		$("#cmdTestQuery").unbind("click").on("click", function() {
			$("form[name='frmOTF']").remove();
			var oForm = $("<form style=\"display: none;\" name=\"frmOTF\" id=\"frmOTF\" method=\"post\" action=\"<?php print site_url(); ?>c_core_email_engine/gf_test_query\" />");
			oForm.appendTo("body");
			oForm.append("<input type=\"hidden\" name=\"sSQL\" id=\"sSQL\" value=\"" + editorSQL.getValue() + "\" />");
			$.gf_custom_ajax({
				"oForm": oForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					$("#selFields").empty().append(JSON.data).selectpicker('refresh');
					$("#cmdTestQuery").removeClass("disabled").find("i").removeClass("fa fa-cog fa-spin fa-fw").addClass("fa fa-play");
					$.gf_remove_all_modal();
				},
				"validate": true,
				"beforeSend": function(r) {
					$.gf_custom_modal({
						sMessage: $.gf_spinner() + "Loading Query..."
					});
				},
				"beforeSendType": "standard",
				"error": function(r) {}
			});
		});
	}
	function gf_init_editor() {
		editorSQL = ace.edit("txtNativeSQL");
		editorSQL.session.setMode("ace/mode/sql");
		editorSQL.setHighlightActiveLine(true);
		$("#txtNativeSQL").css("fontSize", "14px");
		editorSQL.getSession().setUseSoftTabs(true);
		editorSQL.getSession().setTabSize(2);
		editorSQL.getSession().setUseWrapMode(true);
		editorSQL.$blockScrolling = Infinity;
		editorSQL.getSession().setUndoManager(new ace.UndoManager());

		$(".ace_editor").css("border-radius", "0px");

		editorSQL.commands.addCommand({
			name: 'myFindCommand',
			bindKey: {
				win: 'Ctrl-R',
				mac: 'Command-r'
			},
			exec: function(editor) {

			},
			readOnly: true
		});

		editorSQL.commands.addCommand({
			name: 'mySaveCommand',
			bindKey: {
				win: 'Ctrl-S',
				mac: 'Command-S'
			},
			exec: function(editor) {
				$("#cmdForceSave").trigger("click");
			},
			readOnly: true
		});

		editorSQL.commands.addCommand({
			name: 'myNewCommand',
			bindKey: {
				win: 'Ctrl-N',
				mac: 'Command-N'
			},
			exec: function(editor) {

			},
			readOnly: true
		});

		editorHTML = ace.edit("txtNativeHTML");
		editorHTML.session.setMode("ace/mode/html");
		editorHTML.setHighlightActiveLine(true);
		$("#txtNativeHTML").css("fontSize", "14px");
		editorHTML.getSession().setUseSoftTabs(true);
		editorHTML.getSession().setTabSize(2);
		editorHTML.getSession().setUseWrapMode(true);
		editorHTML.$blockScrolling = Infinity;
		editorHTML.getSession().setUndoManager(new ace.UndoManager());

		$(".ace_editor").css("border-radius", "0px");

		editorHTML.commands.addCommand({
			name: 'myFindCommand',
			bindKey: {
				win: 'Ctrl-R',
				mac: 'Command-r'
			},
			exec: function(editor) {

			},
			readOnly: true
		});

		editorHTML.commands.addCommand({
			name: 'mySaveCommand',
			bindKey: {
				win: 'Ctrl-S',
				mac: 'Command-S'
			},
			exec: function(editor) {
				$("#cmdForceSave").trigger("click");
			},
			readOnly: true
		});

		editorHTML.commands.addCommand({
			name: 'myNewCommand',
			bindKey: {
				win: 'Ctrl-N',
				mac: 'Command-N'
			},
			exec: function(editor) {

			},
			readOnly: true
		});

		editorHTML.session.on('change', function() {
			gf_render_preview();
		});
	}
	function gf_render_preview() {
		var objForm = $("#form_58d1e5952fb12");
		$("#hideNativeSQL").val(editorSQL.getValue());
		$("#hideNativeHTML").val(editorHTML.getValue());
		if ($.trim($("#hideNativeSQL").val()) === "")
			return false;
		else {
			objForm.attr("action", "<?php print site_url(); ?>c_core_email_engine/gf_preview_reports/");
			//objForm.attr("target", "_blank");
			//objForm.submit();
			var oResult = null;
			$.gf_custom_ajax({
				"oForm": objForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					oResult = JSON.oData;
					$("#divEmailPreview").html(oResult);
				},
				"validate": true,
				"beforeSend": function(r) {

				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
			//$("#divEmailPreview").html(editorHTML.getValue())
		}
	}
	function gf_rename_file_folder(options) {
		var mHHTML = "<div class=\"box-body no-padding\"><div class=\"row\">";
		mHHTML += "<div class=\"col-sm-12 col-xs-12 form-group\" id=\"div-top-form\">";
		mHHTML += "<label>New File Name</label>";
		mHHTML += "<input class=\"form-control\" name=\"txtName\" id=\"txtName\" placeholder=\"New File Name\" value=\"" + options.oldname + "\" /></div></div></div>";
		dialog = new BootstrapDialog({
			title: 'Rename File',
			message: mHHTML,
			closable: false,
			type: BootstrapDialog.TYPE_DEFAULT,
			onshown: function(dialogRef) {
				$("#txtName").focus();
			},
			buttons: [{
					id: 'cmd-go',
					label: 'Okay',
					cssClass: 'btn-primary',
					action: function(dialogRef) {
						var $button = this;
						if ($.trim($("#txtName").val()) === "") {
							$("#txtName").select().focus();
							return;
						}
						$("#txtName").val($("#txtName").val().replace(/[^A-Za-z0-9.]/gi, "_"));
						var objForm = $.gf_create_form({
							"action": "<?php print site_url(); ?>c_core_email_engine/gf_rename_folder_file"
						});
						objForm.append("<input type=\"hidden\" name=\"path\" id=\"path\" value=\"" + globalpath + "\" />");
						objForm.append("<input type=\"hidden\" name=\"oldname\" id=\"oldname\" value=\"" + options.oldname + "\" />");
						objForm.append("<input type=\"hidden\" name=\"newname\" id=\"newname\" value=\"" + $("#txtName").val() + "\" />");
						$.gf_custom_ajax({
							"oForm": objForm,
							"success": function(r) {
								var JSON = $.parseJSON(r.oRespond);
								if (JSON.status) {
									dialogRef.close();
									gf_load_dir({
										"globalpath": globalpath,
										"mode": "folder"
									});
									$.gf_remove_all_modal();
								} else {
									$.gf_remove_all_modal();
									$.gf_custom_notif({
										"oAddMarginLR": true,
										"sMessage": "<p>File / Folder Name already exists or already remove from system. Please type another File / Folder Name.</p>",
										"oObjDivAlert": $("#div-top-form")
									});
									$button.enable();
									$button.stopSpin();
								}
							},
							"validate": true,
							"beforeSend": function(r) {
								$button.disable();
								$button.spin();
								$.gf_custom_modal({
									"sMessage": $.gf_spinner() + "Saving New File Name..."
								});
							},
							"beforeSendType": "custom",
							"error": function(r) {}
						});
					}
				},
				{
					id: 'cmd-close',
					label: 'Close',
					cssClass: 'btn-default',
					hotkey: 27,
					action: function(dialogRef) {
						dialogRef.close();
					}
				}
			],
			onshown: function() {
				$("#txtName").select();
			}
		});
		dialog.open();
	}
	function gf_copy_file_folder(options) {
		var mHHTML = "<div class=\"box-body no-padding\"><div class=\"row\">";
		mHHTML += "<div class=\"col-sm-12 col-xs-12 form-group\" id=\"div-top-form\">";
		mHHTML += "<label>File Name</label>";
		mHHTML += "<input class=\"form-control\" name=\"txtName\" id=\"txtName\" placeholder=\"New File Name\" value=\"Copy of " + options.oldname + "\" /></div></div></div>";
		dialog = new BootstrapDialog({
			title: 'Copy File',
			message: mHHTML,
			closable: false,
			type: BootstrapDialog.TYPE_DEFAULT,
			onshown: function(dialogRef) {
				$("#txtName").focus();
			},
			buttons: [{
					id: 'cmd-go',
					label: 'Okay',
					cssClass: 'btn-primary',
					action: function(dialogRef) {
						var $button = this;
						if ($.trim($("#txtName").val()) === "") {
							$("#txtName").select().focus();
							return;
						}
						$("#txtName").val($("#txtName").val().replace(/[^A-Za-z0-9.]/gi, "_"));
						var objForm = $.gf_create_form({
							"action": "<?php print site_url(); ?>c_core_email_engine/gf_copy_folder_file"
						});
						objForm.append("<input type=\"hidden\" name=\"path\" id=\"path\" value=\"" + globalpath + "\" />");
						objForm.append("<input type=\"hidden\" name=\"oldname\" id=\"oldname\" value=\"" + options.oldname + "\" />");
						objForm.append("<input type=\"hidden\" name=\"newname\" id=\"newname\" value=\"" + $("#txtName").val() + "\" />");
						$.gf_custom_ajax({
							"oForm": objForm,
							"success": function(r) {
								var JSON = $.parseJSON(r.oRespond);
								if (JSON.status) {
									dialogRef.close();
									gf_load_dir({
										"globalpath": globalpath,
										"mode": "folder"
									});
									$.gf_remove_all_modal();
								} else {
									$.gf_remove_all_modal();
									$.gf_custom_notif({
										"oAddMarginLR": true,
										"sMessage": "<p>File / Folder Name already exists or already remove from system. Please type another File / Folder Name.</p>",
										"oObjDivAlert": $("#div-top-form")
									});
									$button.enable();
									$button.stopSpin();
								}
							},
							"validate": true,
							"beforeSend": function(r) {
								$button.disable();
								$button.spin();
								$.gf_custom_modal({
									"sMessage": $.gf_spinner() + "Saving New File Name..."
								});
							},
							"beforeSendType": "custom",
							"error": function(r) {}
						});
					}
				},
				{
					id: 'cmd-close',
					label: 'Close',
					cssClass: 'btn-default',
					hotkey: 27,
					action: function(dialogRef) {
						dialogRef.close();
					}
				}
			],
			onshown: function() {
				$("#txtName").select();
			}
		});
		dialog.open();
	}
	function gf_delete_file_folder(options) {
		var mHHTML = "<div class=\"box-body no-padding\"><div class=\"row\">";
		mHHTML += "<div class=\"col-sm-12 col-xs-12\" id=\"div-top-form\">";
		mHHTML += "Are you sure want to delete: " + options.name + "</div>";
		mHHTML += "</div></div>";
		dialog = new BootstrapDialog({
			title: 'Delete File / Folder',
			message: mHHTML,
			type: BootstrapDialog.TYPE_DEFAULT,
			closable: false,
			onshown: function(dialogRef) {

			},
			buttons: [{
					id: 'cmd-go',
					label: 'Okay',
					cssClass: 'btn-primary',
					hotkey: 13,
					action: function(dialogRef) {
						var $button = this;
						$.ajax({
							type: "POST",
							url: "<?php print site_url(); ?>c_core_email_engine/gf_delete_folder_file/",
							data: {
								"path": options.obj.attr("path"),
								"type": options.type,
								"name": options.name
							},
							beforeSend: function() {
								$button.disable();
								$button.spin();
							},
							success: function(r) {
								var JSON = $.parseJSON(r);
								if (JSON.status) {
									dialogRef.close();
									gf_load_dir({
										"globalpath": globalpath,
										"mode": "folder"
									});
									options.obj.parent().parent().slideUp("fast", function() {
										var oTable = $(this).parent();;
										$(this).remove();
										$.each(oTable.find("tr:gt(0)"), function(i, n) {
											$(this).find("td:nth-child(1)").text(i + 1);
										});
									});
									$.gf_remove_all_modal();
								} else {
									$.gf_remove_all_modal();
									$.gf_custom_notif({
										"oAddMarginLR": true,
										"sMessage": "<p>File / Folder not already exists</p>",
										"oObjDivAlert": $("#div-top-form")
									});
									$button.enable();
									$button.stopSpin();
								}
							}
						});
					}
				},
				{
					id: 'cmd-close',
					label: 'Close',
					cssClass: 'btn-default',
					hotkey: 27,
					action: function(dialogRef) {
						dialogRef.close();
					}
				}
			]
		});
		dialog.open();
	}
	function gf_load_dir(options) {
		var objForm = $.gf_create_form({
			"action": "<?php print site_url(); ?>c_core_email_engine/gf_load_file_folder"
		});
		objForm.append("<input type=\"hidden\" name=\"path\" id=\"path\" value=\"" + options.globalpath + "\" />");
		objForm.append("<input type=\"hidden\" name=\"mode\" id=\"mode\" value=\"" + options.mode + "\" />");
		$.gf_custom_ajax({
			"oForm": objForm,
			"success": function(r) {
				var JSON = $.parseJSON(r.oRespond);
				$("#table-directory tr:gt(0)").remove();
				$.each(JSON.data, function(i, n) {
					$("#table-directory").append(n);
				});
				$("#olpath").html(JSON.path);
				gf_bind_click();
				$.gf_remove_all_modal();
			},
			"validate": true,
			"beforeSend": function(r) {
				$("#table-directory tr:gt(0)").remove();
				$("#table-directory").append("<tr><td colspan=\"10\" class=\"text-center\">" + $.gf_spinner() + "Loading Directory...<br /><br /><br /><br /><br /><br /></td></tr>");
			},
			"beforeSendType": "custom",
			"error": function(r) {}
		});
	}
	function gf_load_file(options) {
		var objForm = $.gf_create_form({
			"action": "<?php print site_url(); ?>c_core_email_engine/gf_read_file"
		});
		objForm.append("<input type=\"hidden\" name=\"path\" id=\"path\" value=\"" + options.globalpath + "\" />");
		objForm.append("<input type=\"hidden\" name=\"mode\" id=\"mode\" value=\"" + options.mode + "\" />");
		$.gf_custom_ajax({
			"oForm": objForm,
			"success": function(r) {
				var JSON = $.parseJSON(r.oRespond);
				$("#txtReportEngineName").val(JSON.filename);
				var JSON = $.parseJSON(JSON.data);
				editorSQL.setValue(JSON.txtNativeSQL, -1);
				editorHTML.setValue(JSON.txtNativeHTML, -1);
				$("#cmdTestQuery").trigger("click");
				$("#txtMarginTop").val(JSON.txtMarginTop);
				$("#txtMarginLeft").val(JSON.txtMarginLeft);
				$("#txtMarginBottom").val(JSON.txtMarginBottom);
				$("#txtMarginRight").val(JSON.txtMarginRight);
				$("#txtReportEngineDesc").val(JSON.txtReportEngineDesc);
				$("#txthisplayMode").val(JSON.txthisplayMode);
				$("#selPaperSize").find("option[value='" + JSON.selPaperSize + "']").attr("selected", "selected");
				$("#selPaperOrientation").find("option[value='" + JSON.selPaperOrientation + "']").attr("selected", "selected");
				$("#selPaperFontName").find("option[value='" + JSON.selPaperFontName + "']").attr("selected", "selected");
				$("#txtFontSize").find("option[value='" + JSON.txtFontSize + "']").attr("selected", "selected");
				$("a[href='#tab_2']").trigger("click");
				gf_render_preview();
				gf_force_save();
				$.gf_remove_all_modal();
			},
			"validate": false,
			"beforeSend": function(r) {
				$.gf_custom_modal({
					"sMessage": $.gf_spinner() + "Loading File..."
				});
			},
			"loadingMessage": "Loading File...",
			"beforeSendType": "custom",
			"error": function(r) {}
		});
	}
	function gf_force_save() {
		$("#cmdForceSave").unbind("click").on("click", function() {
			var bNext = true;
			$("#div-alert").remove();
			$.each($("#form_58d1e5952fb12").find("input[allow-empty='false'], select[allow-empty='false'], textarea[allow-empty='false']"), function(i, n) {
				if ($.trim($(this).val()) === "") {
					$.gf_custom_notif({
						"oAddMarginLR": true,
						"sMessage": "<p>" + $(this).attr("placeholder") + " can't Empty...</p>",
						"oObjDivAlert": $("#div-top")
					});
					bNext = false;
					return false;
				}
			});
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
			var objForm = $("#form_58d1e5952fb12");
			objForm.attr("action", "<?php print site_url(); ?>c_core_email_engine/gf_transact/");
			objForm.removeAttr("target");

			$("#hideNativeSQL").val(editorSQL.getValue());
			$("#hideNativeHTML").val(editorHTML.getValue());
			$("#txtReportEngineName").val($("#txtReportEngineName").val().replace(/[^A-Za-z0-9.]/gi, "_"));

			$.gf_custom_ajax({
				"oForm": objForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					if (JSON.status === 1) {
						$("#cmdForceSave").removeClass("disabled").val("Force Save");
						gf_force_save();
					} else if (JSON.status === -1) {
						objForm.append("<input type=\"hidden\" name=\"nOverwrite\" id=\"nOverwrite\" value=\"Yes\" />");
						$.gf_custom_ajax({
							"oForm": objForm,
							"success": function(r) {
								var JSON = $.parseJSON(r.oRespond);
								if (JSON.status === 1) {
									$("#cmdForceSave").removeClass("disabled").val("Force Save");
									gf_force_save();
								}
							},
							"validate": true,
							"beforeSend": function(r) {
								$("#cmdForceSave").addClass("disabled").val("Overwriting File...").unbind("click");
							},
							"beforeSendType": "custom",
							"error": function(r) {}
						});
					}
				},
				"validate": true,
				"beforeSend": function(r) {
					$("#cmdForceSave").addClass("disabled").val("Saving Data...").unbind("click");
				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
			//------------------------------------------ 
		});
	}
</script>