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
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List Report Engine</a></li>
		<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form Report Engine</a></li>
		<li class=""><a data-toggle="tab" href="#tab_3">Form Report Engine Example Use</a></li>
	</ul>
	<div class="tab-content">
		<!-- Example Tab Report Engine -->
		<div id="tab_3" class="tab-pane">
			<div class="box-body no-padding">
				<div class="row">
					<form id="form_58d1e5952fb13" role="form" action="<?php print site_url(); ?>c_core_report_engine/gf_exec_report" method="post">
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 form-group">
							<label>Report Name</label>
							<select allow-empty="false" name="selReportName" id="selReportName" class="form-control selectpicker" data-size="8" data-live-search="true">
								<?php print $o_report_list; ?>
							</select>
						</div>
						<div class="row"></div>
						<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 form-group">
							<label>Contoh Parameter: Masukan Nama Penyusun</label>
							<input allow-empty="false" type="text" name="nama_penyusun" id="nama_penyusun" value="" class="form-control" placeholder="Parameter" />
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2 form-group"><button type="button" name="cmdPreviewLive" id="cmdPreviewLive" class="btn btn-primary"><i class="fa fa-play"></i>&nbsp;Preview Report</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- End of Example Tab Report Engine -->
		<!-- List Tab Report Engine List -->
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>">
			<div id="div-list-user" class="table-responsive">
				<table id="table-directory" class="<?php print $oConfig['TABLE_CLASS']; ?>">
					<tbody>
						<tr>
							<td>File No</td>
							<td>File Name</td>
							<td>File Icon</td>
							<td>File Type</td>
							<td>File Extension</td>
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
		<!-- End of List Tab Report Engine List -->
		<!-- List Tab Design Engine List -->
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>">
			<form id="form_58d1e5952fb12" role="form" action="<?php print site_url(); ?>c_core_report_engine/gf_transact" method="post">
				<div class="box-body no-padding">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group" id="div-top">
							<label>Report Name</label>
							<input placeholder="Report Engine Name" allow-empty="false" type="text" class="form-control" id="txtReportEngineName" name="txtReportEngineName" value="<?php print trim($o_data[0]['sMenuIcon']); ?>">
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group"><label>Report Description</label>
							<textarea id="txtReportEngineDesc" name="txtReportEngineDesc" style="max-height: 70px;" class="form-control" placeholder="Report Engine Description"></textarea>
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#tab_11">Report Native SQL</a></li>
									<li class=""><a data-toggle="tab" href="#tab_22">Report Native HTML</a></li>
									<li class=""><a data-toggle="tab" href="#tab_33">Report Preview HTML</a></li>
								</ul>
								<div class="tab-content">
									<div id="tab_11" class="tab-pane active">
										<pre id="txtNativeSQL" style="min-height:350px;"></pre>
									</div>
									<div id="tab_22" class="tab-pane">
										<pre id="txtNativeHTML" style="min-height:350px;"></pre>
									</div>
									<div id="tab_33" class="tab-pane" style="max-height:350px; overflow: auto;">
										asd
									</div>
								</div>
							</div>
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-3 col-md-2 col-lg-1 form-group"><label>Run SQL</label><br /><button type="button" name="cmdTestQuery" id="cmdTestQuery" class="btn btn-default"><i class="fa fa-play"></i>&nbsp;Run</button>
						</div>
						<div class="col-xs-12 col-sm-5 col-md-5 col-lg-5 form-group"><label>Field Name</label>
							<select name="selFields" id="selFields" class="form-control selectpicker" data-size="8" data-live-search="true" class="disabled">
								<option value="">None</option>
							</select>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-5 col-lg-5 form-group"><label>Markup Field</label>
							<input type="text" id="txtFields" name="txtFields" class="form-control" placeholder="Field Name" />
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 form-group"><label>Margin Top</label>
							<input type="text" allow-empty="false" content-mode="numeric" id="txtMarginTop" name="txtMarginTop" value="0" class="form-control" placeholder="Margin Top" />
						</div>
						<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 form-group"><label>Margin Left</label>
							<input type="text" allow-empty="false" content-mode="numeric" id="txtMarginLeft" name="txtMarginLeft" value="0" class="form-control" placeholder="Margin Left" />
						</div>
						<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 form-group"><label>Margin Bottom</label>
							<input type="text" allow-empty="false" content-mode="numeric" id="txtMarginBottom" name="txtMarginBottom" value="0" class="form-control" placeholder="Margin Bottom" />
						</div>
						<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 form-group"><label>Margin Right</label>
							<input type="text" allow-empty="false" content-mode="numeric" id="txtMarginRight" name="txtMarginRight" value="0" class="form-control" placeholder="Margin Right" />
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-3 col-md-2 col-lg-2 form-group"><label>Display Mode</label>
							<input type="text" allow-empty="false" id="txtDisplayMode" name="txtDisplayMode" value="100" placeholder="Display Mode" class="form-control" />
						</div>
						<div class="col-xs-12 col-sm-9 col-md-4 col-lg-4 form-group"><label>Paper Size</label>
							<select allow-empty="false" class="form-control selectpicker" data-size="8" data-live-search="true" id="selPaperSize" name="selPaperSize" placeholder="Paper Size">
								<option value="A4">A4 (210x297 mm ; 8.27x11.69 in)</option>
								<option value="LETTER">LETTER (216x279 mm ; 8.50x11.00 in)</option>
								<option value="LEGAL">LEGAL (216x356 mm ; 8.50x14.00 in)</option>
							</select>
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 form-group"><label>Paper Orientation</label>
							<select allow-empty="false" class="form-control selectpicker" data-size="8" data-live-search="true" id="selPaperOrientation" name="selPaperOrientation" placeholder="Paper Orientation">
								<option value="P">P (Portrait)</option>
								<option value="L">L (Landscape)</option>
							</select>
						</div>
						<div class="col-xs-12 col-sm-4 col-md-3 col-lg-2 form-group"><label>Paper Font</label>
							<select allow-empty="false" class="form-control selectpicker" data-size="8" data-live-search="true" id="selPaperFontName" name="selPaperFontName" placeholder="Paper Font">
								<?php print $o_font; ?>
							</select>
						</div>
						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2 form-group">
							<label>Font Size</label>
							<input type="text" allow-empty="false" content-mode="numeric" id="txtFontSize" name="txtFontSize" value="8" class="form-control" placeholder="Margin Right" />
						</div>
						<div class="row"></div>
						<!--<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
							<hr/>
							<label>Additional Parameter</label>
							<hr/>
						</div>						
						<div class="row"></div>
						-->
						<div class="col-xs-12 col-sm-3 col-md-3 col-lg-2 form-group"><label>Preview</label><br /><button type="button" name="cmdPreviewDesign" id="cmdPreviewDesign" class="btn btn-default"><i class="fa fa-play"></i>&nbsp;Preview Report</button>
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
	var sSURL = "<?php print site_url(); ?>c_core_report_engine/gf_upload/"
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
				objForm.attr("action", "<?php print site_url(); ?>c_core_report_engine/gf_transact/");
				objForm.removeAttr("target");

				$("#hideNativeSQL").val(editorSQL.getValue());
				$("#hideNativeHTML").val(editorHTML.getValue());
				$("#txtReportEngineName").val($("#txtReportEngineName").val().replace(/[^A-Za-z0-9.]/gi, "_"));

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
					"beforeSend": function(r) {
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
						$.gf_custom_modal({
							"sMessage": $.gf_spinner() + "Loading Report..."
						});
					},
					"beforeSendType": "custom",
					"error": function(r) {}
				});
				//------------------------------------------ 
			}
		});
		$("#selFields").on("change", function() {
			$("#txtFields").val("[" + $("#selFields").find("option:selected").val() + "]");
		});
		$("#cmdPreviewDesign").unbind("click").on("click", function() {
			var objForm = $("#form_58d1e5952fb12");
			$("#hideNativeSQL").val(editorSQL.getValue());
			$("#hideNativeHTML").val(editorHTML.getValue());
			objForm.attr("action", "<?php print site_url(); ?>c_core_report_engine/gf_preview_reports/");
			objForm.attr("target", "_blank");
			objForm.submit();
		});
		$("#cmdPreviewLive").on("click", function() {
			var oObjForm = $("#form_58d1e5952fb13");
			oObjForm.submit();
		});
		globalpath = '<?php print base64_encode(getcwd() . DIRECTORY_SEPARATOR . "reports"); ?>';
		gf_load_dir({
			"globalpath": globalpath,
			"mode": ""
		});
		gf_force_save();
	});

	function gf_bind_click() {
		$("#table-directory tr td:nth-child(8) a").unbind("click").click(function() {
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
			var oForm = $("<form style=\"display: none;\" name=\"frmOTF\" id=\"frmOTF\" method=\"post\" action=\"<?php print site_url(); ?>c_core_report_engine/gf_test_query\" />");
			oForm.appendTo("body");
			oForm.append("<input type=\"hidden\" name=\"sSQL\" id=\"sSQL\" value=\"" + editorSQL.getValue() + "\" />");
			$.gf_custom_ajax({
				"oForm": oForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					$("#selFields").empty().append(JSON.data).selectpicker('refresh');
					$("#cmdTestQuery").removeClass("disabled").find("i").removeClass("fa fa-cog fa-spin fa-fw").addClass("fa fa-play");
				},
				"validate": true,
				"beforeSend": function(r) {
					$("#cmdTestQuery").addClass("disabled").find("i").removeClass("fa fa-play").addClass("fa fa-cog fa-spin fa-fw");
				},
				"beforeSendType": "custom",
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
				gf_preview();
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
				gf_preview();
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
	}

	function gf_rename_file_folder(options) {
		var mHHTML = "<div class=\"box-body no-padding\"><div class=\"row\">";
		mHHTML += "<div class=\"col-sm-12 col-xs-12 form-group\" id=\"div-top-form\">";
		mHHTML += "<label>New Name</label>";
		mHHTML += "<input class=\"form-control\" name=\"txtName\" id=\"txtName\" placeholder=\"New File Name\" value=\"" + options.oldname + "\" /></div></div></div>";
		dialog = new BootstrapDialog({
			title: 'Rename File',
			message: mHHTML,
			type: BootstrapDialog.TYPE_DEFAULT,
			onshown: function(dialogRef) {
				$("#txtName").focus();
			},
			buttons: [{
					id: 'cmd-go',
					label: 'Okay',
					cssClass: 'btn-danger',
					action: function(dialogRef) {
						var $button = this;
						if ($.trim($("#txtName").val()) === "") {
							$("#txtName").select().focus();
							return;
						}
						$("#txtName").val($("#txtName").val().replace(/[^A-Za-z0-9.]/gi, "_"));
						var objForm = $.gf_create_form({
							"action": "<?php print site_url(); ?>c_core_report_engine/gf_rename_folder_file"
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
										"sMessage": "<p>File / Folder Name already exists or already remove from system. Please type anotder File / Folder Name.</p>",
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
			]
		});
		dialog.open();
	}

	function gf_delete_file_folder(options) {
		var mHHTML = "<div class=\"box-body no-padding\">";
		mHHTML += "<div class=\"col-sm-12 col-xs-12\" id=\"div-top-form\"><div class=\"row\">";
		mHHTML += "Are you sure want to delete: <b>" + options.name + "</b></div>";
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
					cssClass: 'btn-danger',
					hotkey: 13,
					action: function(dialogRef) {
						var $button = this;
						$.ajax({
							type: "POST",
							url: "<?php print site_url(); ?>c_core_report_engine/gf_delete_folder_file/",
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
									//gf_load_dir({"globalpath": globalpath, "mode": "folder"});
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
			"action": "<?php print site_url(); ?>c_core_report_engine/gf_load_file_folder"
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
			"action": "<?php print site_url(); ?>c_core_report_engine/gf_read_file"
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
				$("#selPaperOrientation").find("option[value='" + JSON.selPaperOrientation + "']").attr("selected", "selected")
				$("#selPaperFontName").find("option[value='" + JSON.selPaperFontName + "']").attr("selected", "selected")
				$("#selPaperSize").selectpicker('refresh');
				$("#selPaperOrientation").selectpicker('refresh');
				$("#selPaperFontName").selectpicker('refresh');
				$("#txtFontSize").find("option[value='" + JSON.txtFontSize + "']");
				$("a[href='#tab_2']").trigger("click");
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
			objForm.attr("action", "<?php print site_url(); ?>c_core_report_engine/gf_transact/");
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

	function gf_preview() {
		var objForm = $("#form_58d1e5952fb12");
		$("#hideNativeSQL").val(editorSQL.getValue());
		$("#hideNativeHTML").val(editorHTML.getValue());
		objForm.attr("action", "<?php print site_url(); ?>c_core_report_engine/gf_preview_html_report/")
		objForm.append("<input type=\"hidden\" name=\"sExportMode\" id=\"sExportMode\" value=\"HTML\" />");
		objForm.append("<input type=\"hidden\" name=\"selReportName\" id=\"selReportName\" value=\"" + globalfile + "\" />");
		$.gf_custom_ajax({
			"oForm": objForm,
			"success": function(r) {
				objForm.attr("action", "<?php print site_url(); ?>c_core_report_engine/gf_exec_report/");
				$("div[id='tab_33']").html(r.oRespond);
				$("a[href='#tab_33']").html("Report Preview HTML")
			},
			"validate": true,
			"beforeSend": function(r) {
				$("a[href='#tab_33']").html("Loading...")
			},
			"beforeSendType": "custom",
			"error": function(r) {}
		});
	}
</script>