<?php
/*
------------------------------
Menu Name: Reports
File Name: V_core_apps_report.php
File Path: D:\Project\PHP\billing\application\views\v_core_apps_report.php
Create Date Time: 2019-06-27 21:19:31
------------------------------
*/
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
		<li class="<?php print $oTab1; ?>"><a data-toggle="tab" href="#tab_1">List Open Reports</a></li>
		<li class="<?php print $oTab2; ?>"><a data-toggle="tab" href="#tab_2">Form Open Reports</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab_1" class="tab-pane <?php print $oTab1; ?>">
			<div id="div-list-user">
			</div>
		</div>
		<div id="tab_2" class="tab-pane <?php print $oTab2; ?>">
			<form id="form_5d14d073d3783" role="form" action="<?php print site_url(); ?>c_core_apps_report/gf_transact" method="post">
				<div class="box-body no-padding">
					<div class="row" id="div-top">
						<div class="col-sm-6 col-xs-12 col-md-6 col-lg-6 form-group">
							<div class="row">
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 form-group hidden"><label>Id Open Reports</label><input allow-empty="false" type="text" placeholder="Id Open Reports" name="txtIdOpenReports" id="txtIdOpenReports" class="form-control" maxlength="50" value="<?php print trim($o_mode) === "I" ? "(AUTO)" : trim($o_data[0]['nIdOpenReport']); ?>" readonly>
								</div>
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 form-group"><label>Id Open Reports Parent</label>
									<select name="selIdOpenReportsParent" placeholder="Id Open Reports Parent" id="selIdOpenReportsParent" class="form-control selectpicker" data-size="8" data-live-search="true">
										<?php print $o_or; ?></select>
								</div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-6 form-group"><label>Open Reports Name</label><input allow-empty="false" type="text" placeholder="Open Reports Name" name="txtOpenReportsName" id="txtOpenReportsName" class="form-control" maxlength="100" value="<?php print trim($o_data[0]['sOpenReportsName']); ?>">
									<input type="hidden" name="txtOpenReportsNameOld" id="txtOpenReportsNameOld" value="<?php print trim($o_data[0]['sOpenReportsName']); ?>" />
								</div>
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-3 form-group"><label>Open Reports Type</label>
									<select name="selOpenReportsType" placeholder="Open Reports Type" id="selOpenReportsType" class="form-control selectpicker" data-size="8" data-live-search="true">
										<option value="">--Pilih--</option>
										<option value="1" <?php print intval($o_data[0]['nOpenReportsType']) === 1 ? "selected" : "" ?>>DYNAMIC</option>
										<option value="2" <?php print intval($o_data[0]['nOpenReportsType']) === 2 ? "selected" : "" ?>>STATIC BY PARAMS</option>
										<option value="3" <?php print intval($o_data[0]['nOpenReportsType']) === 3 ? "selected" : "" ?>>STATIC BY VALUE</option>
									</select>
								</div>
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-3 form-group"><label>Output To</label>
									<select name="selOpenReportsOutput" placeholder="Open Report Ouput" id="selOpenReportsOutput" class="form-control selectpicker" data-size="8" data-live-search="true">
										<option value="1" <?php print intval($o_data[0]['nOpenReportOutput']) === 1 ? "selected" : "" ?>>GRID</option>
										<option value="2" <?php print intval($o_data[0]['nOpenReportOutput']) === 2 ? "selected" : "" ?>>STIMULSOFT</option>
									</select>
								</div>
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 form-group"><label>Open Reports Visible</label>
									<select name="selOpenReportsVisible" placeholder="Visible" id="selOpenReportsVisible" class="form-control selectpicker" data-size="8" data-live-search="true">
										<option value="">--Pilih--</option>
										<option value="1" <?php print intval($o_data[0]['nShowToUser']) === 1 ? "selected" : "" ?>>YES</option>
										<option value="2" <?php print intval($o_data[0]['nShowToUser']) === 2 ? "selected" : "" ?>>NO</option>
									</select>
								</div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6 form-group">
									<button type="button" class="btn btn-primary <?php print trim($o_mode) !== "I" && trim($o_data[0]['sFileName']) !== "" ? "hidden" : "" ?>" id="cmdUpload">Upload MRT File</button>
									<?php
									//print trim($o_data[0]['sFileName']);
									if (trim($o_mode) === "" && trim($o_data[0]['sFileName']) !== "") {
									?>
										<label>File Upload</label>
										<div class="input-group"><input id="txtFileName" name="txtFileName" readonly type="text" class="text-bold form-control" value="<?php print $o_data[0]['sFileName']; ?>" aria-describedby="basic-addon2"><span id="spanDownloadFile" class="input-group-addon cursor-pointer" title="Download File"><i class="fa fa-download"></i></span><span id="spanRemoveUpladFile" class="input-group-addon cursor-pointer" title="Remove File"><i class="fa fa-trash"></i></span></div>
									<?php
									}
									?>
								</div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Open Reports SQL</label>
									<pre id="editorSQL" style="min-height:450px;"><?php print trim($o_data[0]['sOpenReportsSQL']); ?></pre>
									<input type="hidden" name="hideSQL" id="hideSQL" value="" />
								</div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group">
									<a name="aDownloadJSON" id="aDownloadJSON" class="btn btn-danger"><i class="fa fa-download"></i> Download Data as JSON</a>
								</div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Information</label>
									<div class="bg-danger" style="padding: 10px;">Data Type: [3] (NUMERIC), [253, 254] (STRING), [12] (DATE)<br />=============<br />Session Replacement<br />=============
									<br />@nUnitId => $this->session->userdata('nUnitId_fk')<br />@dbname => trim($this->db->database)<br />@siteurl => site_url()<br />@loginrealname => $this->session->userdata('sRealName')<br />@datenow => date('d/m/Y H:i:s')</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-xs-12 col-md-6 col-lg-6 form-group">
							<div class="row">
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Open Reports Desc</label><input type="text" placeholder="Open Reports Desc" name="txtOpenReportsDesc" id="txtOpenReportsDesc" class="form-control" maxlength="200" value="<?php print trim($o_data[0]['sOpenReportsDesc']); ?>">
								</div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Hide Columns</label><input type="text" placeholder="Hide Columns (More than once, please separate by | (pipe))" name="txtHideColumn" id="txtHideColumn" class="form-control" value="<?php print trim($o_data[0]['sHideColumns']); ?>">
								</div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Static JSON Parameters SQL</label>
									<pre id="editorParamsJSONSQL" style="min-height:325px;"><?php print trim($o_data[0]['sOpenReportsStaticParams']); ?></pre>
									<input type="hidden" name="hideStaticParamsJSONSQL" id="hideStaticParamsJSONSQL" value="" />
								</div>
								<div class="row"></div>
								<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Static JSON Header Excel</label>
									<pre id="editorParamsJSONExcel" style="min-height:325px;"><?php print trim($o_data[0]['sOpenReportsStaticParamsExcel']); ?></pre>
									<input type="hidden" name="hideStaticParamsJSONExcel" id="hideStaticParamsJSONExcel" value="" />
								</div>
							</div>
						</div>
					</div>
					<div class="box-footer no-padding">
						<br />
						<?php print $oButton; ?>
					</div>
					<input type="hidden" name="hideMode" id="hideMode" value="" />
					<input type="hidden" name="hideRemoveUpload" id="hideRemoveUpload" value="0" />
					<input type="hidden" name="sUUIDOld" id="sUUIDOld" value="<?php print trim($o_data[0]['sUUID']); ?>" />
					<input type="hidden" name="sFullPathName" id="sFullPathName" value="<?php print trim($o_data[0]['sFullFileName']); ?>" />
			</form>
		</div>
	</div>
</div>
<script>
	var sSURL = "<?php print site_url(); ?>c_core_apps_report/gf_upload/",
		uploader = null,
		sParam = "",
		dialog = "",
		editorSQL = "";
	$(function() {
		gf_init_ediitor();
		gf_load_data();
		gf_init_plupload();
		$("input[content-mode='numeric']").autoNumeric('init', {
			mDec: '0'
		});
		$("button[id='button-submit']").click(function() {
			if ($.trim($(this).html()) === "Cancel")
				$(".sidebar-menu").find("a[class='text-yellow']").trigger("click");
			else {
				var bNext = true;
				var objForm = $("#form_5d14d073d3783");
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
						"oAddMarginLR": false,
						oObjDivAlert: $("#div-top")
					});
					bNext = oRet.oReturnValue;
				}
				if (!bNext)
					return false;
				//------------------------------------------ 
				if ($(this).text() !== "Delete")
					uploader.start();
				else {
					$("#hideRemoveUpload").val("1");
					$("#hideSQL").val(editorSQL.getValue());
					$("#hideStaticParamsJSONSQL").val(editorParamsJSONSQL.getValue());
					$("#hideStaticParamsJSONExcel").val(editorParamsJSONExcel.getValue());
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
			}
		});
		$("#selOpenReportsVisible").selectpicker('refresh');
		$("#selOpenReportsType").selectpicker('refresh');
		$("#aDownloadJSON").on("click", function() {
			var oObj = $(this);
			var oForm = $.gf_create_form({
				action: "<?php print site_url(); ?>c_core_apps_report/gf_parse_sql/"
			});
			oForm.append("<input type=\"hidden\" name=\"hideSQL\" id=\"hideSQL\" value=\"" + $.trim(editorSQL.getValue()) + "\" />");
			$.gf_custom_ajax({
				"oForm": oForm,
				"success": function(r) {
					oObj.removeClass("disabled").prop("disabled", false);
					var element = document.createElement('a')
					element.setAttribute('href', 'data:json/plain;charset=utf-8,' + encodeURIComponent(r.oRespond));
					element.setAttribute('download', $.gf_generate_unique_id({}) + ".json");
					element.style.display = 'none'
					document.body.appendChild(element);
					element.click();
					document.body.removeChild(element);
				},
				"validate": true,
				"beforeSend": function(r) {
					oObj.addClass("disabled").prop("disabled", true);
				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
		});
		$("#spanRemoveUpladFile").on("click", function() {
			$("#spanRemoveUpladFile").parent().remove();
			$("#cmdUpload").next().remove();
			$("#cmdUpload").removeClass("hidden");
			$("#hideRemoveUpload").val("1");
		});
		$("#spanDownloadFile").on("click", function() {
			var oForm = $.gf_create_form({
				action: "<?php print site_url(); ?>c_core_apps_report//gf_download_report/"
			});
			oForm.append("<input type=\"hidden\" name=\"hideUploadId\" id=\"hideUploadId\" value=\"<?php print trim($o_data[0]['sUUID']); ?>\" />");
			oForm.prop("target", "_self");
			oForm.submit();
		});
		$("select").selectpicker("refresh");
	});

	function gf_init_plupload() {
		var sArrayFile = Array(),
			sArraySize = Array(),
			oJSONObj = [],
			oLength = 25,
			oAddPath = "mrt";
		uploader = new plupload.Uploader({
			runtimes: 'html5,flash,silverlight,html4',
			browse_button: 'cmdUpload',
			divUploadContainer: $("#divUploadContainer"),
			url: "<?php print site_url(); ?>c_core_upload/gf_upload/",
			chunk_size: '500kb',
			multiple_queues: true,
			multi_selection: false,
			unique_names: true,
			filters: {
				max_file_size: '50mb',
				mime_types: [{
					title: "MRT Files",
					extensions: "mrt"
				}]
			},
			multipart_params: {
				"oAddPath": oAddPath
			},
			flash_swf_url: '<?php print site_url(); ?>plugins/jPLUpload/plupload/js/Moxie.swf',
			silverlight_xap_url: '<?php print site_url(); ?>plugins/jPLUpload/plupload/js/Moxie.xap',
			init: {
				PostInit: function() {},
				FilesAdded: function(up, files) {
					//uploader.start();
					$("#cmdUpload").addClass("hidden");
					$("<div class=\"input-group\"><input id=\"txtFileName\" name=\"txtFileName\" readonly type=\"text\" class=\"text-bold form-control\" value=\"" + files[0].name + "\" aria-describedby=\"basic-addon2\"><span id=\"spanRemoveUpladFile\" class=\"input-group-addon cursor-pointer\" title=\"Remove File\"><i class=\"fa fa-trash\"></i></span></div>").insertAfter($("#cmdUpload"));
					$("#spanRemoveUpladFile").on("click", function() {
						uploader.removeFile(files[0]);
						$("#cmdUpload").next().remove();
						$("#cmdUpload").removeClass("hidden");
					});
				},
				UploadProgress: function(up, file) {},
				Error: function(up, err) {},
				BeforeUpload: function(up, file) {},
				UploadComplete: function(uploader, files) {
					var objForm = $("#form_5d14d073d3783");
					objForm.find("input[id='hidePath']").remove();
					objForm.find("input[id='hideFileName']").remove();
					objForm.find("input[id='hideFileSize']").remove();
					objForm.find("input[id='hideFileHash']").remove();
					objForm.append("<input type=\"hidden\" name=\"hidePath\" id=\"hidePath\" value=\"uploads\\\\" + $.trim(oAddPath) + "\\\\\"  />");
					var sf = ""
					$.each(oJSONObj, function(i, n) {
						var JSON = $.parseJSON(n.oFile);
						sf = $.trim(JSON.fnameoriginal);
						objForm.append("<input type=\"hidden\" name=\"hideFileName[]\" id=\"hideFileName\" value=\"" + $.trim(JSON.fnameoriginal) + "\" />");
						objForm.append("<input type=\"hidden\" name=\"hideFileSize[]\" id=\"hideFileSize\" value=\"" + $.trim(JSON.ffilesize) + "\" />");
						objForm.append("<input type=\"hidden\" name=\"hideFileHash[]\" id=\"hideFileHash\" value=\"" + $.trim(JSON.fnamehash) + "\" />");
						objForm.append("<input type=\"hidden\" name=\"hideFileExt[]\" id=\"hideFileExt\" value=\"" + $.trim(JSON.fnameoriginal).split(".")[$.trim(JSON.fnamehash).split(".").length] + "\" />");
					});
					//$("button#button-submit:eq(0)").trigger("click")
					$("#hideSQL").val(editorSQL.getValue());
					$("#hideStaticParamsJSONSQL").val(editorParamsJSONSQL.getValue());
					$("#hideStaticParamsJSONExcel").val(editorParamsJSONExcel.getValue());
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
				},
				FileUploaded: function(upldr, file, object) {
					var JSON = $.parseJSON(object.response);
					item = {}
					item["oFile"] = object.response;
					oJSONObj.push(item);
				}
			}
		});
		uploader.init();
	}

	function gf_load_data() {
		$("#div-list-user").ado_load_paging_data({
			url: "<?php print site_url(); ?>c_core_apps_report/gf_load_data/"
		});
	}

	function gf_init_ediitor() {
		editorSQL = ace.edit("editorSQL");
		$("#editorSQL").css("fontSize", "100%");
		editorSQL.session.setMode("ace/mode/sql");
		editorSQL.setHighlightActiveLine(true);
		editorSQL.getSession().setUseSoftTabs(true);
		editorSQL.getSession().setTabSize(2);
		editorSQL.getSession().setUseWrapMode(true);
		editorSQL.$blockScrolling = Infinity;
		editorSQL.getSession().setUndoManager(new ace.UndoManager());
		editorSQL.commands.addCommand({
			name: 'myFindCommand',
			bindKey: {
				win: 'Ctrl-R',
				mac: 'Command-r'
			},
			exec: function(editorSQL) {},
			readOnly: true
		});
		//--------------------------------
		editorParamsJSONSQL = ace.edit("editorParamsJSONSQL");
		$("#editorParamsJSONSQL").css("fontSize", "100%");
		editorParamsJSONSQL.session.setMode("ace/mode/json");
		editorParamsJSONSQL.setHighlightActiveLine(true);
		editorParamsJSONSQL.getSession().setUseSoftTabs(true);
		editorParamsJSONSQL.getSession().setTabSize(2);
		editorParamsJSONSQL.getSession().setUseWrapMode(true);
		editorParamsJSONSQL.$blockScrolling = Infinity;
		editorParamsJSONSQL.getSession().setUndoManager(new ace.UndoManager());
		editorParamsJSONSQL.commands.addCommand({
			name: 'myFindCommand',
			bindKey: {
				win: 'Ctrl-R',
				mac: 'Command-r'
			},
			exec: function(editorSQL) {},
			readOnly: true
		});
		//--------------------------------
		editorParamsJSONExcel = ace.edit("editorParamsJSONExcel");
		$("#editorParamsJSONExcel").css("fontSize", "100%");
		editorParamsJSONExcel.session.setMode("ace/mode/json");
		editorParamsJSONExcel.setHighlightActiveLine(true);
		editorParamsJSONExcel.getSession().setUseSoftTabs(true);
		editorParamsJSONExcel.getSession().setTabSize(2);
		editorParamsJSONExcel.getSession().setUseWrapMode(true);
		editorParamsJSONExcel.$blockScrolling = Infinity;
		editorParamsJSONExcel.getSession().setUndoManager(new ace.UndoManager());
		editorParamsJSONExcel.commands.addCommand({
			name: 'myFindCommand',
			bindKey: {
				win: 'Ctrl-R',
				mac: 'Command-r'
			},
			exec: function(editorSQL) {},
			readOnly: true
		});
	}

	function gf_bind_event() {
		var oTable = $("div[id^='divResultPaging']").find("table");
		oTable.find("tr:gt(0)").find("td:last").append("&nbsp;<a id=\"aCopyData\" title=\"Copy this data !\" class=\"cursor-pointer btn btn-default btn-xs\">Copy</a>");
		$("a[id='aCopyData']").unbind("click").on("click", function(e) {
			e.preventDefault();
			var oObj = $(this);
			var oForm = $.gf_create_form({
				"action": "<?php print site_url(); ?>c_core_apps_report/gf_copy_data/"
			});
			oForm.append("<input type=\"hidden\" name=\"nIdOpenReport\" id=\"nIdOpenReport\" value=\"" + $.trim($(this).parent().parent().find("td:eq(0)").text()) + "\" />");
			$.gf_custom_ajax({
				"oForm": oForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					gf_load_data();
					oObj.html("Copy");
				},
				"validate": true,
				"beforeSend": function(r) {
					oObj.html("<i class=\"fa fa-cog fa-spin fa-fwd\"></i>");
				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
		});
	}
</script>