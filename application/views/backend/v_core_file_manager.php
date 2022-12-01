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
	<ul class="nav nav-tabs" id="tab-files">
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List File Manager</a></li>
		<li class="pull-right"><a id="aAction" mode="Folder" class="text-muted" href="#" title="Create Folder"><i class="fa fa-asterisk"></i></a></li>
	</ul>
	<div class="tab-content" id="tab-content">
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>">
			<div class="box-body no-padding table-responsive">
				<div class="box-body no-padding">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<div class="row">
							<ol class="breadcrumb" id="olPath">
								<li><a href="#" class="active">root</a></li>
							</ol>
							<div id="slimScrollDiv">
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
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script>
	var sSURL = "<?php print site_url(); ?>c_core_file_manager/gf_upload/"
	var sParam = "";
	var dialog = "";
	var editor = null;
	var dialog = null;
	var globalpath = null;
	var globalfile = null;
	var globalfiletemp = null;
	var arrayEditor = [];
	$(function() {
		$("input[content-mode='numeric']").autoNumeric('init');
		$("button[id='button-submit']").click(function() {
			if ($.trim($(this).html()) === "Cancel") {
				$("a[href='#tab_1']").trigger("click");
				editor.setValue("");
				globalfile = "";
				$("a[href='#tab_2']").html("Text Editor");
			} else
				gf_save_data({
					"globalpath": globalpath
				});
		});
		gf_bind_click();
		globalpath = "<?php print base64_encode(getcwd()); ?>";
		gf_load_dir({
			"globalpath": globalpath,
			"mode": ""
		});
	});

	function gf_bind_click() {
		$("#table-directory").find("tr td:nth-child(2) a").unbind("click").click(function() {
			var sMode = $.trim($(this).parent().parent().find("td:nth-child(4)").text());
			//$(this).parent().find("li").removeClass("active");
			//$(this).addClass("active");
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
		$("#cmdRefresh").unbind("click").on("click", function() {
			$("#ul-nav-folder").find("li a[path='" + globalpath + "']").trigger("click");
		});
		$("#table-directory").find("tr td:nth-child(8) a").unbind("click").click(function() {
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

		/*$("#slimScrollDiv").slimScroll({
    position: 'right',
    height: "550px",
    railVisible: false,
    color: '#7f7f7f',
    distance: '0px',
    wheelStep: 5,
    size: '2px',
    allowPageScroll: false,
    disableFadeOut: false,
    alwaysVisible: false
	});*/

		$("#olPath li a").unbind("click").on("click", function() {
			globalpath = $(this).attr("path");
			var sMode = "Dir";
			gf_load_dir({
				"globalpath": globalpath,
				"mode": sMode
			});
		});
		$("a[id='aAction']").unbind("click").on("click", function() {
			var sMode = $(this).attr("mode");
			var mHHTML = "<div class=\"box-body no-padding\"><div class=\"row\">";
			mHHTML += "<div class=\"col-sm-3 col-xs-12 form-group\" id=\"div-top-form\">";
			mHHTML += "<label>Create What</label>";
			mHHTML += "<select class=\"form-control\" name=\"selMode\" id=\"selMode\"><option value=\"file\">File</option><option value=\"folder\">Folder</option></select></div>";
			mHHTML += "<div class=\"row\"></div><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\">";
			mHHTML += "<label>Name</label>";
			mHHTML += "<input class=\"form-control\" name=\"txtName\" id=\"txtName\" placeholder=\"Name\" value=\"\" /></div>";
			mHHTML += "</div></div>";
			dialog = new BootstrapDialog({
				title: 'Create File / Folder',
				message: mHHTML,
				type: BootstrapDialog.TYPE_PRIMARY,
				closable: false,
				onshown: function(dialogRef) {
					$("#txtName").focus();
				},
				buttons: [{
						id: 'cmd-go',
						label: 'Okay',
						cssClass: 'btn-primary',
						hotkey: 13,
						action: function(dialogRef) {
							var $button = this;
							if ($.trim($("#txtName").val()) === "") {
								$("#txtName").focus();
								return;
							}
							$("#txtName").val($("#txtName").val().replace(/[^A-Za-z0-9.]/gi, "_"));
							var objForm = $.gf_create_form({
								"action": "<?php print site_url(); ?>c_core_file_manager/gf_create_folder_file"
							});
							objForm.append("<input type=\"hidden\" name=\"path\" id=\"path\" value=\"" + globalpath + "\" />");
							objForm.append("<input type=\"hidden\" name=\"mode\" id=\"mode\" value=\"" + sMode + "\" />");
							objForm.append("<input type=\"hidden\" name=\"name\" id=\"name\" value=\"" + $("#txtName").val() + "\" />");
							objForm.append("<input type=\"hidden\" name=\"type\" id=\"type\" value=\"" + $("#selMode").find("option:selected").val() + "\" />");
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
									} else {
										$("<div id=\"div-alert\" class=\"alert alert-warning alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>Folder already exists. Please type another folder name.</p></div>").insertBefore($("#div-top-form"));
										$button.enable();
										$button.stopSpin();
									}
								},
								"validate": true,
								"beforeSend": function(r) {
									$button.disable();
									$button.spin();
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
		});
		$("a[id='aToolbar']").unbind("click").on("click", function() {
			sMode = $.trim($(this).html());
			if (sMode === "New...") {
				editor.setValue("");
				globalfile = "";
				$("a[href='#tab_2']").html("Text Editor");
			} else if (sMode === "Exit...") {
				$("a[href='#tab_1']").trigger("click");
				editor.setValue("");
				globalfile = "";
				$("a[href='#tab_2']").html("Text Editor");
			} else if (sMode === "Save As...") {
				globalfile = "";
				gf_save_data({
					"globalpath": globalpath
				});
			} else if (sMode === "Save...") {
				if ($.trim($("a[href='#tab_2']").html()) === "Text Editor")
					globalfile = "";
				gf_save_data({
					"globalpath": globalpath
				});
			} else if (sMode === "Find...") {
				$("#txtFind").focus();
			} else if (sMode === "Undo...") {

			} else if (sMode === "Redo...") {
				editor.getSession().setRedoManager(new ace.RedoManager())
			}
		});
		$("#cmdFind").unbind("click").on("click", function() {
			if ($.trim($("#txtFind").val()) === "") {
				$("#txtFind").focus();
				return;
			}
			editor.find($.trim($("#txtFind").val()), {
				backwards: false,
				wrap: false,
				caseSensitive: false,
				wholeWord: false,
				regExp: false
			});
			editor.findNext();
		});
		$("#txtFind").unbind("keyup").on("keyup", function(e) {
			if (e.keyCode === 13)
				$("#cmdFind").trigger("click");
		});
	}

	function gf_delete_file_folder(options) {
		var mHHTML = "<div class=\"box-body no-padding\">";
		mHHTML += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12\" id=\"div-top-form\"><div class=\"row\">";
		mHHTML += "Are you sure want to delete: " + options.name + "</div>";
		mHHTML += "</div></div>";
		dialog = new BootstrapDialog({
			title: 'Delete File / Folder',
			message: mHHTML,
			type: BootstrapDialog.TYPE_PRIMARY,
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
						var objForm = $.gf_create_form({
							"action": "<?php print site_url(); ?>c_core_file_manager/gf_delete_folder_file"
						});
						objForm.append("<input type=\"hidden\" name=\"path\" id=\"path\" value=\"" + globalpath + "\" />");
						objForm.append("<input type=\"hidden\" name=\"type\" id=\"type\" value=\"" + options.type + "\" />");
						objForm.append("<input type=\"hidden\" name=\"name\" id=\"name\" value=\"" + options.name + "\" />");
						$.gf_custom_ajax({
							"oForm": objForm,
							"success": function(r) {
								var JSON = $.parseJSON(r.oRespond);
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
								} else {
									$("<div id=\"div-alert\" class=\"alert alert-warning alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>File / Folder not already exists</p></div>").insertBefore($("#div-top-form"));
									$button.enable();
									$button.stopSpin();
								}
								$.gf_remove_all_modal();
							},
							"validate": true,
							"beforeSend": function(r) {
								$button.disable();
								$button.spin();
								$.gf_custom_modal({
									"sMessage": $.gf_spinner() + "Saving Data..."
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

	function gf_load_dir(options) {
		var objForm = $.gf_create_form({
			"action": "<?php print site_url(); ?>c_core_file_manager/gf_load_file_folder"
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
				$("#olPath").html(JSON.path);
				gf_bind_click();
			},
			"validate": true,
			"beforeSend": function(r) {
				$("#table-directory tr:gt(0)").remove();
				$("#table-directory").append("<tr><td colspan=\"10\" class=\"text-center\">" + $.gf_spinner() + "Loading Directory...<br /><br /><br /><br /><br /><br /><br /><br /></td></tr>");
			},
			"beforeSendType": "custom",
			"error": function(r) {}
		});
	}

	function gf_load_file(options) {
		var objForm = $.gf_create_form({
			"action": "<?php print site_url(); ?>c_core_file_manager/gf_read_file"
		});
		objForm.append("<input type=\"hidden\" name=\"path\" id=\"path\" value=\"" + options.globalpath + "\" />");
		objForm.append("<input type=\"hidden\" name=\"mode\" id=\"mode\" value=\"" + options.mode + "\" />");
		$.gf_custom_ajax({
			"oForm": objForm,
			"success": function(r) {
				var JSON = $.parseJSON(r.oRespond);
				//-- Buat tab
				var x = Math.floor(Math.random() * (100 - 1) + 100);
				var filename = JSON.path.split("\\")[JSON.path.split("\\").length - 1];
				var filext = (JSON.path.split("\\")[JSON.path.split("\\").length - 1]).split(".");
				filext = filext[filext.length - 1];

				//-- Cari tab yangn globalpath ama globalfile nya udah ada, klo udah ada fokus aja, kosonging editor nya
				if ($("#tab-files").find("li[globalpath='" + globalpath + "'][globalfile='" + globalfile + "']").length > 0) {
					$("#tab-files").find("li[globalpath='" + globalpath + "'][globalfile='" + globalfile + "']").find("a").trigger("click");
					editor.setValue(JSON.data);
					dialog.close();
					return;
				}

				$("#tab-files").append("<li index=\"" + arrayEditor.length + "\" x=\"" + x + "\" globalpath=\"" + globalpath + "\" globalfile=\"" + globalfile + "\"><a data-toggle=\"tab\" href=\"#tab_" + x + "\"><i id=\"i_" + x + "\" class=\"fa fa-close cursor-pointer\" title=\"Close this tab\"></i>&nbsp; " + filename + "</a></li>");
				var mHTML = "<div id=\"tab_" + x + "\" globalpath=\"" + globalpath + "\" globalfile=\"" + globalfile + "\" class=\"tab-pane\"> ";
				mHTML += "<div class=\"box-body no-padding\"><div class=\"row\"> ";
				mHTML += "<div class=\"col-md-12 col-sm-12 col-xs-12 col-lg-12\"><pre id=\"editor_" + x + "\" style=\"min-height:550px;\"></pre></div>";
				mHTML += "<div class=\"col-md-12 col-sm-12 col-xs-12 col-lg-12\" id=\"divfooter_" + x + "\"><button id=\"cmdSave_" + x + "\" class=\"btn btn-primary\"><i class=\"fa fa-save\"></i>&nbsp;Save</button>&nbsp;<span id=\"spanInfo_" + x + "\"></span><br /></div>";
				mHTML += "</div></div> ";
				$("#tab-content").append(mHTML);

				$("i[id='i_" + x + "']").unbind("click").on("click", function() {
					$("a[href='#tab_1']").trigger("click");
					$(this).parent().parent().remove();
					$("#tab-content").find("div[id='tab_" + x + "']").remove();
				});

				$("button[id='cmdSave_" + x + "']").unbind("click").on("click", function() {
					$("span[id='spanInfo_" + x + "']").html("<i class=\"fa fa-circle-o-notch fa-spin fa-1x fa-fw\"></i> Please wait, Saving File...").fadeIn("fast");

					//ambil globalpath tab yang class nya active
					globalpath = $("#tab-files").find("li[class='active']").attr("globalpath");
					globalfile = $("#tab-files").find("li[class='active']").attr("globalfile");

					if ($.trim($("a[href='#tab_2']").html()) === "Text Editor")
						globalfile = "";
					gf_save_data({
						"globalpath": globalpath
					});

					$("span[id='spanInfo_" + x + "']").fadeOut("fast", function() {
						$(this).empty().html("<i class=\"fa fa-check\"></i> Saving file OK").fadeIn("fast", function() {
							setTimeout(function() {}, 5000);
							$(this).fadeOut("slow", function() {
								$(this).empty();
							});
						});
					});
				});

				editor = ace.edit("editor_" + x);
				$("#editor_" + x).css("fontSize", "14px");
				arrayEditor.push(editor);
				gf_init_editor({
					ext: filext
				});
				editor.getSession().setValue(JSON.data);
				editor.blur();
				$("a[href='#tab_" + x + "']").trigger("click");
				$.gf_remove_all_modal();
			},
			"validate": true,
			"beforeSend": function(r) {
				$.gf_custom_modal({
					"sMessage": $.gf_spinner() + "Loading File..."
				});
			},
			"beforeSendType": "custom",
			"error": function(r) {}
		});
	}

	function gf_reset_array_editor() {

	}

	function gf_rename_file_folder(options) {
		var mHHTML = "<div class=\"box-body no-padding\">";
		mHHTML += "<div class=\"col-sm-12 col-xs-12 form-group\" id=\"div-top-form\">";
		mHHTML += "<label>New Name</label>";
		mHHTML += "<input class=\"form-control\" name=\"txtName\" id=\"txtName\" placeholder=\"New File Name\" value=\"" + options.oldname + "\" /></div></div>";
		dialog = new BootstrapDialog({
			title: 'Rename File',
			message: mHHTML,
			type: BootstrapDialog.TYPE_PRIMARY,
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
							"action": "<?php print site_url(); ?>c_core_file_manager/gf_rename_folder_file"
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
								} else {
									$("<div id=\"div-alert\" class=\"alert alert-error alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>File / Folder Name already exists or already remove from system. Please type another File / Folder Name.</p></div>").insertBefore($("#div-top-form"));
									$button.enable();
									$button.stopSpin();
								}
								$.gf_remove_all_modal();
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

	function gf_init_editor(options) {
		//editor.setTheme("ace/theme/monokai");
		editor.session.setMode("ace/mode/" + options.ext);
		editor.setHighlightActiveLine(true);
		editor.getSession().setUseSoftTabs(true);
		editor.getSession().setTabSize(2);
		editor.getSession().setUseWrapMode(true);
		editor.$blockScrolling = Infinity;
		editor.getSession().setUndoManager(new ace.UndoManager());

		$(".ace_editor").css("border-radius", "0px");

		editor.commands.addCommand({
			name: 'myFindCommand',
			bindKey: {
				win: 'Ctrl-R',
				mac: 'Command-r'
			},
			exec: function(editor) {
				/*var mHHTML = "<div class=\"box-body no-padding\">";
								mHHTML += "<div class=\"col-sm-12 col-xs-12 form-group\" id=\"div-top-form\">";
								mHHTML += "<label>Search What.</label>";
								mHHTML += "<input class=\"form-control\" name=\"txtFindWhat\" id=\"txtFindWhat\" placeholder=\"Search What. Please type word to Searching the Syntax.\" value=\"\" /></div></div>";
       dialog = new BootstrapDialog({
							title: 'Find',
							message: mHHTML,
							type : BootstrapDialog.TYPE_PRIMARY,
							onshown: function(dialogRef){
								$("#txtFindWhat").focus();
							},
							buttons: [{
												id:'cmd-go',
												label: 'Go',
												cssClass: 'btn-primary',
												action: function(dialogRef)
												{
													editor.find($("#txtFindWhat").val(),{
													    backwards: false,
													    wrap: false,
													    caseSensitive: false,
													    wholeWord: false,
													    regExp: false
													});
													editor.findNext();
													editor.findPrevious();
												}
											},
											{
												id:'cmd-close',
												label: 'Close',
												cssClass: 'btn-default',
												hotkey: 27,
												action: function(dialogRef)
												{
													dialogRef.close();
												}
											}]
							});
							dialog.open();*/
			},
			readOnly: true // false if this command should not apply in readOnly mode
		});

		editor.commands.addCommand({
			name: 'mySaveCommand',
			bindKey: {
				win: 'Ctrl-S',
				mac: 'Command-S'
			},
			exec: function(editor) {

				//ambil globalpath tab yang class nya active
				globalpath = $("#tab-files").find("li[class='active']").attr("globalpath");
				globalfile = $("#tab-files").find("li[class='active']").attr("globalfile");


				if ($.trim($("a[href='#tab_2']").html()) === "Text Editor")
					globalfile = "";
				gf_save_data({
					"globalpath": globalpath
				});
			},
			readOnly: true // false if this command should not apply in readOnly mode
		});

		editor.commands.addCommand({
			name: 'myNewCommand',
			bindKey: {
				win: 'Ctrl-N',
				mac: 'Command-N'
			},
			exec: function(editor) {
				/*editor.setValue("");
			globalfile = "";
			$("a[href='#tab_2']").html("Text Editor");*/
			},
			readOnly: true // false if this command should not apply in readOnly mode
		});
	}

	function gf_save_data(options) {
		var mHHTML = "<div class=\"box-body no-padding\">";
		mHHTML += "<div class=\"col-sm-12 col-xs-12 form-group\" id=\"div-top-form\">";
		mHHTML += "<label>File Name</label>";
		mHHTML += "<input class=\"form-control\" name=\"txtName\" id=\"txtName\" placeholder=\"New File Name\" value=\"\" /></div></div>";
		dialog = new BootstrapDialog({
			title: 'Create File',
			message: mHHTML,
			type: BootstrapDialog.TYPE_PRIMARY,
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
						globalfile = $("#txtName").val();
						var objForm = $.gf_create_form({
							"action": "<?php print site_url(); ?>c_core_file_manager/gf_save_file"
						});
						objForm.append("<input type=\"hidden\" name=\"path\" id=\"path\" value=\"" + options.globalpath + "\" />");
						objForm.append("<input type=\"hidden\" name=\"name\" id=\"name\" value=\"" + globalfile + "\" />");
						objForm.append("<input type=\"hidden\" name=\"content\" id=\"content\" value=\"" + editor.getValue() + "\" />");
						objForm.append("<input type=\"hidden\" name=\"type\" id=\"type\" value=\"file\" />");
						objForm.append("<input type=\"hidden\" name=\"x\" id=\"x\" value=\"0\" />");
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
									$("a[href='#tab_2']").html("Path: " + (globalpath === null ? "root\\" + globalfile : globalpath + globalfile));
								} else {
									$("<div id=\"div-alert\" class=\"alert alert-error alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>File / Folder Name already exists or already remove from system. Please type another File / Folder Name.</p></div>").insertBefore($("#div-top-form"));
									$button.enable();
									$button.stopSpin();
								}
								$.gf_remove_all_modal();
							},
							"validate": true,
							"beforeSend": function(r) {
								$button.disable();
								$button.spin();
								$.gf_custom_modal({
									"sMessage": $.gf_spinner() + "Saving Data..."
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
		if ($.trim(globalfile) !== "" && globalfile !== null) {
			var sContent = arrayEditor[$("#tab-files").find("li[class='active']").attr("index")];
			var sEncoded = encodeURIComponent(sContent.getSession().getValue());
			//alert(sEncoded);
			var oForm = $("<form style=\"display: none;\" id=\"oForm\" enctype=\"multipart/form-data\" method=\"post\" action=\"<?php print site_url(); ?>c_core_file_manager/gf_save_file/\"><input type=\"hidden\" name=\"path\" id=\"path\" value=\"" + options.globalpath + "\" /><input type=\"hidden\" name=\"name\" id=\"name\" value=\"" + globalfile + "\" /><input type=\"hidden\" name=\"content\" id=\"content\" value=\"" + sEncoded + "\"><input type=\"hidden\" name=\"type\" id=\"type\" value=\"file\" /><input type=\"hidden\" name=\"x\" id=\"x\" value=\"1\" />");
			oForm.appendTo("body");
			$.gf_custom_ajax({
				"oForm": oForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					if (JSON.status) {
						$("#spanInfo").fadeOut("fast", function() {
							$(this).empty().html("<i class=\"fa fa-check\"></i> Saving file OK").fadeIn("fast", function() {
								setTimeout(function() {}, 5000);
								$(this).fadeOut("slow", function() {
									$(this).empty();
									oForm.remove();
								});
							});
						});
					} else {
						$("#spanInfo").html("Something Wrong.").fadeIn("fast");
						$button.enable();
						$button.stopSpin();
					}
					$.gf_remove_all_modal();
				},
				"validate": true,
				"beforeSend": function(r) {
					$("#spanInfo").html("<i class=\"fa fa-circle-o-notch fa-spin fa-1x fa-fw\"></i> Please wait, Saving File...").fadeIn("fast");
					$.gf_custom_modal({
						"sMessage": $.gf_spinner() + "Saving Data..."
					});
				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
		} else
			dialog.open();
	}
</script>