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
<div class="hidden" id="divDBEngine">
	<?php
	print $o_db_engine;
	?>
</div>
<div class="hidden" id="divDBCharset">
	<?php
	print $o_db_charset;
	?>
</div>
<div class="hidden" id="divDBCollate">
	<?php
	print $o_db_collate;
	?>
</div>
<div class="hidden" id="divDBDataType">
	<?php
	print $o_db_data_type;
	?>
</div>
<div class="box-body no-padding">
	<div class="row">
		<!--<div class="col-xs-12 col-sm-12 col-md-5 col-lg-3 form-group" id="div-top">
		<div class="panel panel-default">
			<div class="panel-body no-border" id="divListDatabase" style="max-height: 580px;">
				<?php
				$oData = json_decode($o_list_database, TRUE);
				print $oData['oData'];
				?>
			</div>
		</div>
		<div class="margin-bottom"></div>
		<button type="button" name="cmdRefresh" id="cmdRefresh" class="btn btn-md btn-default btn-block"><i class="fa fa-refresh"></i> Refresh</button>
	</div>-->
		<div class="col-xs-12 col-sm-12 col-md-7 col-lg-12 form-group">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs" id="tabTop">
					<!--<li class="active"><a data-toggle="tab" href="#tabTop0">Server Information</span></a></li>-->
					<li class="active"><a data-toggle="tab" href="#tabTop1">Query</a></li>
				</ul>
				<div class="tab-content" id="tabTopContent">
					<!--<div id="tabTop0" class="tab-pane active"> 
					<div class="row">
						<div id="divInfo" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">Database Selection: <span id="spanDatabaseName" name="spanDatabaseName" class="text-red text-bold">billingdb</span>
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-6 col-md-5 col-lg-3 form-group">
							<input type="text" class="form-control" name="txtDbName" id="txtDbName" placeholder="Database Name..."/>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-5 col-lg-3 form-group">
							<button name="cmdCreateDatabase" id="cmdCreateDatabase" class="btn btn-default col-xs-12 col-sm-12 col-md-12 col-lg-12" type="button">Create New Database</button>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-5 col-lg-3 form-group">
							<button name="cmdCreateTable" id="cmdCreateTable" class="btn btn-default col-xs-12 col-sm-12 col-md-12 col-lg-12" type="button">Create New Table</button>
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-6 col-md-5 col-lg-3 form-group">
							<select name="selDbName" id="selDbName" class="form-control selectpicker" data-size="8" data-live-search="true">
								<?php
								$oData = json_decode($o_list_database, TRUE);
								print "<option value=\"None\">--Select Database--</option>";
								foreach ($oData['oDataDetail'] as $row)
									print "<option value=\"" . trim($row['SCHEMA_NAME']) . "\">" . trim($row['SCHEMA_NAME']) . "</option>";
								?>
							</select>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-5 col-lg-3 form-group">
							<button name="cmdDropDatabase" id="cmdDropDatabase" class="disabled btn btn-default col-xs-12 col-sm-12 col-md-12 col-lg-12" type="button">Drop Database</button>
						</div>
					</div>					
				</div>-->
					<div id="tabTop1" class="tab-pane active">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
								<pre id="editorSQL" style="min-height: 300px;"></pre>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
								<button type="button" name="cmdAction" id="cmdAction" class="btn btn-primary"><i class="fa fa-play"></i> Execute</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group" id="div-top">
					<div class="nav-tabs-custom">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#tab_21">Result</span></a></li>
							<!--<li class=""><a data-toggle="tab" href="#tab_22">Message</a></li>-->
						</ul>
						<div class="tab-content">
							<div id="tab_21" class="tab-pane active">
								Result 1
							</div>
							<!--<div id="tab_22" class="tab-pane"> 
					<pre id="editorMessage" style="min-height: 350px;"></pre>
				</div>-->
						</div>
					</div>
				</div>
			</div>
		</div>


		<script>
			var sSURL = "<?php print site_url(); ?>c_core_database/gf_upload/"
			var sParam = "";
			var dialog = "";
			var editor = null;
			var arrayEditor = [];
			var tabTopIndex = 2;
			var sSortBy = "";
			var sSortMode = "";
			var nRowPerPage, nPageActive, nOpenReportsType;
			var oReff = "button";
			$(function() {
				gf_bind_event();
				gf_load_data();
				gf_bind_editor({
					sPreName: "editorSQL",
					sMode: "sql"
				});
				//gf_bind_editor({sPreName: "editorMessage", sMode: "json"});
				$("input[content-mode='numeric']").autoNumeric('init', {
					mDec: '0'
				});
				$("button[id='button-submit']").click(function() {
					if ($.trim($(this).html()) === "Cancel")
						window.location.href = "<?php print site_url(); ?>c_core_database"
					else {
						var bNext = true;
						var objForm = $("#form_58f9bcd3a68ba");
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
								if (JSON.status === 1)
									window.location.href = "<?php print site_url(); ?>c_core_apps_config/";
								else {
									$.gf_remove_all_modal();
									r.oDialog.open();
									r.oDialog.getModalBody().html(JSON.message);
									r.oDialog.setType(BootstrapDialog.TYPE_WARNING);
									r.oDialog.getModalFooter().find("button[id='cmd-loading']").removeClass("disabled").html("Close").unbind("click").bind("click", function() {
										r.oDialog.close();
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
				gf_bind_virtual_scroll_bar();
			});

			function gf_bind_virtual_scroll_bar() {
				$("#divListDatabase").slimScroll({
					position: 'right',
					width: '100%',
					height: '100%',
					railVisible: false,
					color: '#7f7f7f',
					distance: '2px',
					wheelStep: "<?php print $oConfig['WHEEL_STEP_BODY_SCROLL']; ?>",
					size: '10px',
					allowPageScroll: true,
					disableFadeOut: false,
					alwaysVisible: false
				});
			}

			function gf_bind_editor(options) {
				editor = ace.edit(options.sPreName);
				//editor.setTheme("ace/theme/monokai");
				$("#" + options.sPreName).css("fontSize", "14px");
				editor.session.setMode("ace/mode/" + options.sMode);
				editor.setHighlightActiveLine(true);
				editor.getSession().setUseSoftTabs(true);
				editor.getSession().setTabSize(2);
				editor.getSession().setUseWrapMode(true);
				editor.$blockScrolling = Infinity;
				editor.getSession().setUndoManager(new ace.UndoManager());
				//$(".ace_editor").css("border-radius", "0px");
				editor.blur();
				arrayEditor.push(editor);
				//-----------------------
			}

			function gf_bind_event() {
				//$(window).on("resize", function()
				//{
				//	$("div[id='divListDatabase']").css("min-height", $(this).height()-210+"px");
				//});
				//$(window).trigger("resize");
				$('.tree-toggle').unbind("click").on("click", function() {
					var oObj = $(this);
					var limode = oObj.attr("limode");
					var dbname = oObj.attr("dbname");

					if (limode === "database")
						$("#spanDatabaseName").empty().html(dbname);

					if (limode === "database") {
						if ($.trim(oObj.find("span").attr("class")) === "fa fa-arrow-right" || $.trim(oObj.find("span").attr("class")) === "fa-arrow-right fa")
							oObj.find("span").removeClass("fa fa-arrow-right").addClass("fa fa-arrow-down");
						else if ($.trim(oObj.find("span").attr("class")) === "fa-arrow-down fa fa-arrow-right" || $.trim(oObj.find("span").attr("class")) === "fa fa-arrow-down")
							oObj.find("span").removeClass("fa fa-arrow-down").addClass("fa fa-arrow-right");
					}

					if (oObj.next().find("li").length === 0) {

						var sURL = "<?php print site_url(); ?>c_core_database/gf_load_attribute/";
						if (limode !== "database")
							var sURL = "<?php print site_url(); ?>c_core_database/gf_load_attribute_content/";

						//-- View Table
						if (oObj.find("span").attr("class") === "fa fa-table") {
							var x = Math.floor(Math.random() * (999999 - 1) + 99999);
							var sDatabase = oObj.parent().find("label").attr("database");
							var sTable = oObj.parent().find("label").attr("table");

							$("#tabTop").find("li").removeClass("active");
							$("#tabTopContent").find("div").removeClass("active");

							$("#tabTop").append("<li class=\"active\"><a data-toggle=\"tab\" x=\"" + x + "\" href=\"#tabTop" + x + "\"><span id=\"iClose\" class=\"fa fa-close text-black cursor-pointer\" title=\"Remove this Tab\"></span></button> Detail Table: " + oObj.attr("table") + "</a></li>");

							$("#tabTopContent").append("<div id=\"tabTop" + x + "\" class=\"tab-pane active\"><div class=\"row\"><div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\">" + oObj.attr("table") + "</div></div></div>");
							gf_bind_event();

							sURL = "<?php print site_url(); ?>c_core_database/gf_load_table_content/";
							$.ajax({
								type: "POST",
								url: sURL,
								data: {
									sDBName: sDatabase,
									sTableName: sTable
								},
								beforeSend: function() {
									$("div[id='tabTop" + x + "']").empty().html("Loading Table Information");
								},
								success: function(r) {
									var sToolbar = "<div class=\"row\">";
									sToolbar += "<div class=\"col-xs-12 col-sm-2 col-md-2 col-lg-2\">";
									sToolbar += "<button type=\"button\" name=\"cmdAction\" id=\"cmdAction\" cmd=\"Add Field\" class=\"btn btn-sm btn-default\">Add Field</button>";
									sToolbar += "</div>";
									sToolbar += "</div>";
									sToolbar += "<div class=\"row\"></div>";
									sToolbar += "<div class=\"margin-bottom\"></div>";
									var JSON = $.parseJSON(r);
									$("div[id='tabTop" + x + "']").empty().html(sToolbar + JSON.oData);
								}
							});
							return;
						}
						//-- View Stored Procedure
						else if (oObj.find("span").attr("class") === "fa fa-slack") {
							var sDatabase = oObj.parent().find("label").attr("database");
							var sSPName = oObj.parent().find("label").attr("table");
							sURL = "<?php print site_url(); ?>c_core_database/gf_read_stored_procedure/";
							$.ajax({
								type: "POST",
								url: sURL,
								data: {
									sDBName: sDatabase,
									sSPName: sSPName
								},
								beforeSend: function() {
									oObj.find("span").removeClass("fa fa-slack").addClass("fa fa-circle-o-notch fa-spin fa-fw");
								},
								success: function(r) {
									var x = Math.floor(Math.random() * (999999 - 1) + 99999);
									var JSON = $.parseJSON(r);

									$("#tabTop").find("li").removeClass("active");
									$("#tabTopContent").find("div").removeClass("active");

									$("#tabTop").append("<li index=\"" + arrayEditor.length + "\" class=\"active\"><a data-toggle=\"tab\" x=\"" + x + "\" href=\"#tabTop" + x + "\"><span id=\"iClose\" class=\"fa fa-close text-black cursor-pointer\" title=\"Remove this Tab\"></span></button> " + sSPName + "</a></li>");

									var sForm = "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\" id=\"divCreateSP\">";
									sForm += "<pre x=\"" + x + "\" id=\"preSPEditor" + x + "\" name=\"preSPEditor" + x + "\" style=\"min-height: 450px;\">" + JSON.oDataHeader + "</pre>";
									sForm += "</div>";
									sForm += "<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-4 form-group\">";
									sForm += "<button dbname=\"" + sDatabase + "\" spname=\"" + sSPName + "\" class=\"btn btn-default col-xs-12 col-sm-12 col-md-12 col-lg-12\" name=\"cmdAlterSP\" id=\"cmdAlterSP\">Alter Stored Procedure</button>";
									sForm += "</div>";
									sForm += "<div class=\"col-xs-6 col-sm-6 col-md-6 col-lg-4 form-group\">";
									sForm += "<button dbname=\"" + sDatabase + "\" spname=\"" + sSPName + "\" class=\"btn btn-default col-xs-12 col-sm-12 col-md-12 col-lg-12\" name=\"cmdRemoveSP\" id=\"cmdRemoveSP\">Remove Stored Procedure</button>";
									sForm += "</div>";
									$("#tabTopContent").append("<div id=\"tabTop" + x + "\" class=\"tab-pane active\"><div class=\"row\">" + sForm + "</div></div>");
									gf_bind_event();
									gf_bind_editor({
										sPreName: "preSPEditor" + x
									});
									oObj.find("span").removeClass("fa fa-circle-o-notch fa-spin fa-fw").addClass("fa fa-slack");
								}
							});
							return;
						}

						$.ajax({
							type: "POST",
							url: sURL,
							data: {
								sDBName: dbname,
								sLiMode: limode
							},
							beforeSend: function() {
								if (limode === "database")
									oObj.find("span").removeClass("fa fa-arrow-right").addClass("fa fa-circle-o-notch fa-spin fa-fw");
								else if ($.inArray(limode, Array("tables", "views", "stored procedures", "events", "triggers")))
									oObj.find("span").removeClass("fa fa-cog").addClass("fa fa-circle-o-notch fa-spin fa-fw");
							},
							success: function(r) {
								var JSON = $.parseJSON(r);
								oObj.next().html(JSON.oData);
								gf_bind_event();
								if (limode === "database")
									oObj.find("span").removeClass("fa fa-circle-o-notch fa-spin fa-fw").addClass("fa fa-arrow-right");
								else if ($.inArray(limode, Array("tables", "views", "stored procedures", "events", "triggers")))
									oObj.find("span").removeClass("fa fa-circle-o-notch fa-spin fa-fw").addClass("fa fa-cog");
							}
						});
					} else {
						oObj.parent().children('ul.tree').toggle(200);
					}
				});
				$("span[id='iClose']").unbind("click").on("click", function() {
					var x = $(this).parent().attr("x");
					$("a[href='#tabTop0']").trigger("click");
					$("#tabTop0").addClass("active");
					$(this).parent().parent().remove();
					$("div[id='tabTopContent']").find("div[id='tabTop" + x + "']").remove();
				}).on("mouseover", function() {
					$(this).removeClass("text-black").addClass("text-red");
				}).on("mouseout", function() {
					$(this).removeClass("text-red").addClass("text-black");
				});
				$("button[id='cmdCreateDatabase']").unbind("click").on("click", function() {
					if ($.trim($("#txtDbName").val()) === "") {
						$("div[id='div-alert']").remove();
						$("<div id=\"div-alert\" class=\"alert alert-error alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>Please input Database Name.</p></div>").insertBefore($("#divInfo"));
						return;
					}
					var sURL = "<?php print site_url(); ?>c_core_database/gf_create_database/";
					$.ajax({
						type: "POST",
						url: sURL,
						data: {
							sDBName: $("#txtDbName").val()
						},
						beforeSend: function() {
							$("div[id='div-alert']").remove();
							$("<div id=\"div-alert\" class=\"alert bg-gray alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p><i class=\"fa fa-cog fa-spin fa-1x\"></i>Please wait while creating 	Database <b>" + $("#txtDbName").val() + "</b>.</p></div>").insertBefore($("#divInfo"));
						},
						success: function(r) {
							var JSON = $.parseJSON(r);
							if (parseInt(JSON.oStatus) === 1) {
								$("#cmdRefresh").trigger("click");
								$("div[id='div-alert']").remove();
								$("<div id=\"div-alert\" class=\"alert alert-primary alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>Create Database <b>" + $("#txtDbName").val() + "</b> success.</p></div>").insertBefore($("#divInfo"));
								$("#txtDbName").val("");
							} else if (parseInt(JSON.oStatus) === -1) {
								$("div[id='div-alert']").remove();
								$("<div id=\"div-alert\" class=\"alert alert-error alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>Database " + $("input[id='txtDatabaseName']").val() + " Already Exists.</p></div>").insertBefore($("#divCreateDb"));
							}
						},
						error: function() {
							$("<div id=\"div-alert\" class=\"alert alert-error alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>You don't have permision to Create Databases. Please check your Login Privileges.</p></div>").insertBefore($("#divCreateDb"));
						}
					});
				});
				$("button[id='cmdRefresh']").unbind("click").on("click", function() {
					var sURL = "<?php print site_url(); ?>c_core_database/gf_load_database_lists/";
					$.ajax({
						type: "POST",
						url: sURL,
						beforeSend: function() {
							$(this).removeClass("fa fa-refresh").addClass("fa fa-cog fa-spin fa-1x fa-fw").addClass("disabled");
							$("#divListDatabase").html("Loading Database...");
						},
						success: function(r) {
							var JSON = $.parseJSON(r);
							$("#divListDatabase").html(JSON.oData);
							gf_bind_event();
							$(this).removeClass("fa fa-cog fa-spin fa-1x fa-fw").addClass("fa fa-refresh").removeClass("disabled");
							$("select[id='selDbName']").empty().addClass("disabled").html("<option value=\"None\">Loading...</option>");
							var sOption = "<option value=\"None\">--Select Database--</option>";
							$.each(JSON.oDataDetail, function(i, n) {
								sOption += "<option value=\"" + n.SCHEMA_NAME + "\">" + n.SCHEMA_NAME + "</option>";
							});
							$("select[id='selDbName']").empty().addClass("disabled").html(sOption).removeClass("disabled");
						}
					});
				});
				$("button[id='cmdCreateTable']").unbind("click").on("click", function() {
					if ($.trim($("#spanDatabaseName").html()) === "None") {
						$("div[id='div-alert']").remove();
						$("<div id=\"div-alert\" class=\"alert alert-error alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>You have not selected Database. Please select Database before Create a Table.</p></div>").insertBefore($("#divInfo"));
						return;
					}

					var x = Math.floor(Math.random() * (999999 - 1) + 99999);

					$("#tabTop").find("li").removeClass("active");
					$("#tabTopContent").find("div").removeClass("active");

					$("#tabTop").append("<li class=\"active\"><a data-toggle=\"tab\" x=\"" + x + "\" href=\"#tabTop" + x + "\"><button id=\"iClose\" type=\"button\" title=\"Close this Tab\" class=\"btn btn-xs btn-default\"><span class=\"fa fa-close text-red\"></span></button> Create New Table...</a></li>");

					var sForm = "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4 form-group\" id=\"divCreateTable\"><label for=\"email\">Table Name:</label>";
					sForm += "<input type=\"text\" class=\"form-control\" id=\"txtTableName\" placeholder=\"Table Name\" name=\"txtTableName\" />";
					sForm += "</div>";
					sForm += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4 form-group\"><label for=\"email\">Table Engine:</label>";
					sForm += "<select name=\"selTableEngine\" id=\"selTableEngine\" class=\"form-control\" placeholder=\"Table Engine Name\">" + $("#divDBEngine").html() + "</select>";
					sForm += "</div>";
					sForm += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4 form-group\"><label for=\"email\">Table Charset:</label>";
					sForm += "<select name=\"selTableCharset\" id=\"selTableCharset\" class=\"form-control\" placeholder=\"Table Charset Name\">" + $("#divDBCharset").html() + "</select>";
					sForm += "</div>";
					sForm += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-4 form-group\"><label for=\"email\">Table Collation:</label>";
					sForm += "<select name=\"selTableCollate\" id=\"selTableCollate\" class=\"form-control\" placeholder=\"Table Collation Name\">" + $("#divDBCollate").html() + "</select>";
					sForm += "</div>";
					sForm += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\"><label for=\"email\">Field:</label>";
					sForm += "<div class=\"form-group\"><button type=\"button\" name=\"cmdAddRow\" id=\"cmdAddRow\" class=\"btn btn-default\"><i class=\"fa fa-plus\"></i>Add Row</button>&nbsp;<button type=\"button\" name=\"cmdClearRow\" id=\"cmdClearRow\" class=\"btn btn-default\"><i class=\"fa fa-close\"></i>Clear Row</button></div>";
					sForm += "<div class=\"table-responsive\"><table id=\"tableField\" class=\"table table-responsive table-striped table-hover table-custom-header table-custom-header-color-text\">";
					sForm += "<tr>";
					sForm += "<td class=\"text-right\">No</td><td>Column Name</td><td>Data Type</td><td>Length</td><td>Default</td><td>PK</td><td>Not Null</td><td>Unsigned</td><td>Auto Incr</td><td>Zero Fill</td><td>Comment</td><td>Remove</td>";
					sForm += "<tr><td class=\"text-right\">1</td>";
					sForm += "<td><input type=\"text\" placeholder=\"Column Name\" name=\"txtColumnName[]\" id=\"txtColumnName\" value=\"\" class=\"form-control\"/></td>";
					sForm += "<td><select name=\"selColumnType[]\" id=\"selColumnType\" class=\"form-control\">" + $("#divDBDataType").html() + "</select></td>";
					sForm += "<td><input type=\"text\" placeholder=\"Column Length\" name=\"txtColumnLength[]\" content-mode=\"numeric\" id=\"txtColumnLength\" value=\"\" class=\"form-control\"/></td>";
					sForm += "<td class=\"text-center\"><input type=\"text\" placeholder=\"Default\" name=\"txtDefault[]\" id=\"txtDefault\" value=\"\" class=\"form-control\"/></td>";
					sForm += "<td class=\"text-center\"><span  mode=\"0\" id=\"chkFieldMode\" name=\"chkPK[]\" class=\"fa fa-close cursor-pointer text-red\" title=\"Click here to change Value [PK]\"></span></td>";
					sForm += "<td class=\"text-center\"><span mode=\"0\" id=\"chkFieldMode\" name=\"chkNotNull[]\" class=\"fa fa-close cursor-pointer text-red\" title=\"Click here to change Value [Not Null]\"></span></td>";
					sForm += "<td class=\"text-center\"><span mode=\"0\" numeric=\"true\" id=\"chkFieldMode\" name=\"chkUnsigned[]\" class=\"fa fa-close cursor-pointer text-red\" title=\"Click here to change Value [Unsigned]\"></span></td>";
					sForm += "<td class=\"text-center\"><span mode=\"0\" numeric=\"true\" id=\"chkFieldMode\" name=\"chkAutoIncr[]\" class=\"fa fa-close cursor-pointer text-red\" title=\"Click here to change Value [Auto Incr]\"></span></td>";
					sForm += "<td class=\"text-center\"><span mode=\"0\" numeric=\"true\" id=\"chkFieldMode\" name=\"chkZeroFill[]\" class=\"fa fa-close cursor-pointer text-red\" title=\"Click here to change Value [Zero Fill]\"></span></td>";
					sForm += "<td><input type=\"text\" placeholder=\"Comment\" name=\"txtColumnComment[]\" id=\"txtColumnComment\" value=\"\" class=\"form-control\"/></td>";
					sForm += "<td class=\"text-center\"><span id=\"spanRemoveRow\" class=\"fa fa-close text-red cursor-pointer\" title=\"Remove Field\"></span></td>";
					sForm += "</tr>";
					sForm += "</table>";
					sForm += "</div></div>";
					sForm += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\">";
					sForm += "<button type=\"button\" name=\"cmdActionCreateTable\" id=\"cmdActionCreateTable\" class=\"btn btn-md btn-default\">Create Table</button>&nbsp;<button type=\"button\" name=\"cmdActionClearTable\" id=\"cmdActionClearTable\" class=\"btn btn-md btn-default\">Clear</button>";
					sForm += "</div>";
					$("#tabTopContent").append("<div id=\"tabTop" + x + "\" class=\"tab-pane active\"><div class=\"row\">" + sForm + "</div></div>");
					$("input[content-mode='numeric']").autoNumeric('init', {
						mDec: '0'
					});
					gf_bind_event();
					gf_reset_table({
						oTableName: $("table[id='tableField']")
					});
				});
				$("button[id='cmdActionCreateTable']").unbind("click").on("click", function() {
					if ($.trim($("#txtTableName").val()) === "") {
						$("div[id='div-alert']").remove();
						$("<div id=\"div-alert\" class=\"alert alert-error alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>" + $("#txtTableName").attr("placeholder") + " can't empty !.</p></div>").insertBefore($("#divCreateTable"));
						$("#txtTableName").focus();
					}
				});
				$("span[id='chkFieldMode']").unbind("click").on("click", function() {
					if (parseInt($(this).attr("mode")) === 0) {
						if (parseInt($(this).parent().parent().find("td:eq(2)").find("option:selected").attr("mode")) === 1) {
							$(this).attr("mode", "1");
							$(this).removeClass("fa fa-close text-red").addClass("fa fa-check text-red");
						} else if (!$(this).attr("numeric")) {
							$(this).attr("mode", "1");
							$(this).removeClass("fa fa-close text-red").addClass("fa fa-check text-red");
						}

						if ($(this).attr("name") === "chkPK[]") {
							var oObj = $(this).parent().parent().find("td:eq(6) span");
							oObj.attr("mode", "1").removeClass("fa fa-close text-red").addClass("fa fa-check text-red");
						}

					} else if (parseInt($(this).attr("mode")) === 1) {
						$(this).attr("mode", "0");
						$(this).removeClass("fa fa-check text-red").addClass("fa fa-close text-red");
					}
				});
				$("button[id='cmdAddRow']").unbind("click").on("click", function() {
					var oObjTable = $("table[id='tableField']");
					if ($.trim(oObjTable.find("tr:last").find("td:eq(1) input").val()) !== "") {
						oObjTable.find("tr:nth-child(2)").clone().insertAfter(oObjTable.find("tr:last"));
						oObjTable.find("tr:last").find("input[type='text']").val("");
						oObjTable.find("tr:last").find("select").find("option[value='']").attr("selected", "selected");
						oObjTable.find("tr:last").find("span[id='chkFieldMode']").attr("mode", "0").removeClass("fa fa-check text-red").addClass("fa fa-close text-red");
						gf_reset_table({
							oTableName: oObjTable
						});
						gf_bind_event();
						$("input[content-mode='numeric']").autoNumeric('init', {
							mDec: '0'
						});
						oObjTable.find("tr:last td:eq(1)").find("input[type='text']").focus();
					}
				});
				$("span[id='spanRemoveRow']").unbind("click").on("click", function() {
					var oObjTable = $("table[id='tableField']");
					if (oObjTable.find("tr").length > 2)
						$(this).parent().parent().remove();
					else {
						oObjTable.find("tr:last").find("input[type='text']").val("");
						oObjTable.find("tr:last").find("select option[value='']").attr("selected", "selected");
						oObjTable.find("tr:last").find("span[id='chkFieldMode']").attr("mode", "0").removeClass("fa fa-check text-red").addClass("fa fa-close text-red");
					}
					gf_reset_table({
						oTableName: oObjTable
					});
				});
				$("select[id='selColumnType']").unbind("change").on("change", function() {
					if ($(this).find("option:selected").attr("mode") === "0") {
						$(this).parent().parent().find("td:lt(10):gt(6)").find("span").attr("mode", "0").removeClass("fa fa-check text-red").addClass("fa fa-close text-red");
						gf_bind_event();
					}
				});
				$("button[id='cmdActionCreateTable']").unbind("click").on("click", function() {
					$("form[id='frmOnTheFy']").remove();
					var oForm = $("<form class=\"hidden\" name=\"frmOnTheFy\" id=\"frmOnTheFy\" action=\"<?php print site_url(); ?>c_core_database/gf_create_table/\" method=\"post\"></form>");
					oForm.appendTo("body");
					var oObjTable = $("table[id='tableField']");
					oForm.append("<input type=\"hidden\" name=\"txtTableName\" id=\"txtTableName\" value=\"" + $("#txtTableName").val() + "\" />");
					oForm.append("<input type=\"hidden\" name=\"txtDatabaseName\" id=\"txtDatabaseName\" value=\"" + $("#spanDatabaseName").html() + "\" />");
					oForm.append("<input type=\"hidden\" name=\"txtTableEngine\" id=\"txtTableEngine\" value=\"" + $("#selTableEngine").find("option:selected").val() + "\" />");
					oForm.append("<input type=\"hidden\" name=\"txtTableCollate\" id=\"txtTableCollate\" value=\"" + $("#selTableCollate").find("option:selected").val() + "\" />");
					oForm.append("<input type=\"hidden\" name=\"txtTableCharset\" id=\"txtTableCharset\" value=\"" + $("#selTableCharset").find("option:selected").val() + "\" />");
					$.each(oObjTable.find("tr:gt(0)"), function(i, n) {
						oForm.append("<input type=\"hidden\" name=\"txtColumnName[]\" id=\"txtColumnName\" value=\"" + $(this).find("td:eq(1) input[type='text'][id='txtColumnName']").val() + "\" />");
						oForm.append("<input type=\"hidden\" name=\"selColumnType[]\" id=\"selColumnType\" value=\"" + $(this).find("td:eq(2) select[id='selColumnType']").find("option:selected").val() + "\" />");
						oForm.append("<input type=\"hidden\" name=\"nColumnMode[]\" id=\"nColumnMode\" value=\"" + $(this).find("td:eq(2) select[id='selColumnType']").find("option:selected").attr("mode") + "\" />");
						oForm.append("<input type=\"hidden\" name=\"txtColumnLength[]\" id=\"txtColumnLength\" value=\"" + $(this).find("td:eq(3) input[type='text'][id='txtColumnLength']").val() + "\" />");
						oForm.append("<input type=\"hidden\" name=\"txtDefault[]\" id=\"txtDefault\" value=\"" + $(this).find("td:eq(4) input[type='text'][id='txtDefault']").val() + "\" />");
						oForm.append("<input type=\"hidden\" name=\"sPK[]\" id=\"sPK\" value=\"" + $(this).find("td:eq(5) span").attr("mode") + "\" />");
						oForm.append("<input type=\"hidden\" name=\"sNotNull[]\" id=\"sNotNull\" value=\"" + $(this).find("td:eq(6) span").attr("mode") + "\" />");
						oForm.append("<input type=\"hidden\" name=\"sUnsigned[]\" id=\"sUnsigned\" value=\"" + $(this).find("td:eq(7) span").attr("mode") + "\" />");
						oForm.append("<input type=\"hidden\" name=\"sAutoIncr[]\" id=\"sAutoIncr\" value=\"" + $(this).find("td:eq(8) span").attr("mode") + "\" />");
						oForm.append("<input type=\"hidden\" name=\"sZeroFill[]\" id=\"sZeroFill\" value=\"" + $(this).find("td:eq(9) span").attr("mode") + "\" />");
						oForm.append("<input type=\"hidden\" name=\"txtColumnComment[]\" id=\"txtColumnComment\" value=\"" + $(this).find("td:eq(10) input[type='text'][id='txtColumnComment']").val() + "\" />");
					});
					$.ajax({
						type: "POST",
						url: oForm.attr("action"),
						data: oForm.serialize(),
						beforeSend: function() {
							$("div[id='div-alert']").remove();
							$("<div id=\"div-alert\" class=\"alert alert-primary alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p><i class=\"fa fa-cog fa-spin fa-1x fa-fw\"></i>Please wait while creating table <b>" + $("#txtTableName").val() + "</b> Table.</p></div>").insertBefore($("#divCreateTable"));
						},
						success: function(r) {
							var JSON = $.parseJSON(r);
							if (r) {
								$("div[id='div-alert']").remove();
								$("<div id=\"div-alert\" class=\"alert alert-primary alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>Your was succesfully to Create <b>" + $("#txtTableName").val() + "</b> Table.</p></div>").insertBefore($("#divCreateTable"));
								$("#cmdRefresh").trigger("click");
							}
						},
						error: function() {
							$("div[id='div-alert']").remove();
							$("<div id=\"div-alert\" class=\"alert alert-error alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>You don't have permision to Exclusive Action with Tables. Please check your Login Privileges.</p></div>").insertBefore($("#divCreateTable"));
						}
					});
				});
				$("button[id='cmdDropDatabase']").unbind("click").on("click", function() {
					if ($.trim($("#spanDatabaseName").html()) === "None")
						return;
					BootstrapDialog.show({
						title: 'Drop Database !',
						message: 'Do you realy want to remove Database: <b>' + $("#spanDatabaseName").html() + '</b> from Server ?',
						closable: false,
						buttons: [{
							label: 'Okay',
							cssClass: 'btn-default',
							action: function(dialog) {
								dialog.close();
								$("form[id='frmOnTheFy']").remove();
								var oForm = $("<form class=\"hidden\" name=\"frmOnTheFy\" id=\"frmOnTheFy\" action=\"<?php print site_url(); ?>c_core_database/gf_drop_database/\" method=\"post\"></form>");
								oForm.appendTo("body");
								$.ajax({
									type: "POST",
									url: oForm.attr("action"),
									data: {
										sDBName: $.trim($("#spanDatabaseName").html())
									},
									beforeSend: function() {
										$("div[id='div-alert']").remove();
										$("<div id=\"div-alert\" class=\"alert alert-default alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p><i class=\"fa fa-cog fa-spin fa-1x fa-fw\"></i>Please wait while dropping database <b>" + $("#spanDatabaseName").html() + "</b> Table.</p></div>").insertBefore($("#divInfo"));
									},
									success: function(r) {
										var JSON = $.parseJSON(r);
										if (r) {
											$("div[id='div-alert']").remove();
											$("<div id=\"div-alert\" class=\"alert alert-primary alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>Your was succesfully dropping Database <b>" + $("#spanDatabaseName").html() + "</b> Database.</p></div>").insertBefore($("#divInfo"));
											$("#cmdRefresh").trigger("click");
											$("#spanDatabaseName").html("None")
										}
									},
									error: function() {
										$("div[id='div-alert']").remove();
										$("<div id=\"div-alert\" class=\"alert alert-error alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>You don't have permision to Exclusive Action with Database. Please check your Login Privileges.</p></div>").insertBefore($("#divInfo"));
									}
								});
							}
						}, {
							label: 'Cancel',
							cssClass: 'btn-default',
							action: function(dialog) {
								dialog.close();
							}
						}]
					});
				});
				$("select[id='selDbName']").unbind("change").on("change", function() {
					$("#spanDatabaseName").html($(this).find("option:selected").val());
					$("#cmdDropDatabase").removeClass("disabled");
					gf_bind_event();
				});
				$("button[id='cmdAlterSP']").unbind("click").on("click", function() {
					var sDBName = $(this).attr("dbname");
					var sSPName = $(this).attr("spname	");
					var sContent = arrayEditor[$("#tabTop").find("li[class='active']").attr("index")];
					var sEncoded = encodeURIComponent(sContent.getSession().getValue());
					$("form[id='frmOnTheFy']").remove();
					var oForm = $("<form class=\"hidden\" name=\"frmOnTheFy\" id=\"frmOnTheFy\" action=\"<?php print site_url(); ?>c_core_database/gf_alter_remove_stored_procedure/\" method=\"post\"></form>");
					oForm.appendTo("body");
					$.ajax({
						type: "POST",
						url: oForm.attr("action"),
						data: {
							sParam: "ALTER_PROC",
							sSPName: sSPName,
							sDBName: sDBName,
							sSQL: sContent.getSession().getValue()
						},
						beforeSend: function() {
							$(this).addClass("disabled").html("<i class=\"fa fa-circle-o-notch fa-spin fa-fw\"></i> Please Wait...");
							$("#cmdRemoveSP").addClass("disabled");
							$("div[id='div-alert']").remove();
							$("<div id=\"div-alert\" class=\"alert bg-gray alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p><i class=\"fa fa-cog fa-spin fa-1x fa-fw\"></i>Please wait while dropping Stored Procedure <b>" + sSPName + "</b>.</p></div>").insertBefore($("#divCreateSP"));
						},
						success: function(r) {
							var JSON = $.parseJSON(r);
							if (r) {
								$("div[id='div-alert']").remove();
								$("<div id=\"div-alert\" class=\"alert alert-primary alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>Your was succesfully altering Stored Procedure <b>" + sSPName + "</b>.</p></div>").insertBefore($("#divCreateSP"));
								$(this).removeClass("disabled").html("Alter Strored Procedure");
								$("#cmdRemoveSP").removeClass("disabled");
							}
						},
						error: function() {
							$("div[id='div-alert']").remove();
							$("<div id=\"div-alert\" class=\"alert alert-error alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>You don't have permision to Exclusive Action with Database. Please check your Login Privileges.</p></div>").insertBefore($("#divCreateSP"));
						}
					});

					/*
					
					$("div[id='div-alert']").remove();
					$("<div id=\"div-alert\" class=\"alert alert-default alert-dismissible add-margin-l-r-custom\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>Please wait while altering Stored Procedure.</p></div>").insertBefore($("#divCreateSP"));*/

					gf_bind_event()
				});
				$("button[id='cmdRemoveSP']").unbind("click").on("click", function() {});
				$("button[id='cmdAction']").unbind("click").on("click", function() {
					var oForm = $.gf_create_form({
						action: "<?php print site_url(); ?>C_core_database/gf_execute_query/"
					});
					if (oReff === "button") {
						sSortMode = "";
						nRowPerPage = "20";
						nPageActive = "1";
						sSortBy = "";
					}
					oForm.find("input[id='hidePageLimit']").remove();
					oForm.find("input[id='hidePageCurrent']").remove();
					oForm.find("input[id='hideSQL']").remove();
					oForm.find("input[id='hideFieldSortBy']").remove();
					oForm.find("input[id='hideModeSortBy']").remove();
					oForm.find("input[id='hideOpenReportsType']").remove();
					oForm.append("<input type=\"hidden\" name=\"hideSQL\" id=\"hideSQL\" value=\"" + arrayEditor[0].getValue() + "\" />");
					oForm.append("<input type=\"hidden\" name=\"hideFieldSortBy\" id=\"hideFieldSortBy\" value=\"" + sSortBy + "\">");
					oForm.append("<input type=\"hidden\" name=\"hideModeSortBy\" id=\"hideModeSortBy\" value=\"" + sSortMode + "\">");
					oForm.append("<input type=\"hidden\" name=\"hidePageLimit\" id=\"hidePageLimit\" value=\"" + (nRowPerPage === undefined ? 20 : nRowPerPage) + "\">");
					oForm.append("<input type=\"hidden\" name=\"hidePageCurrent\" id=\"hidePageCurrent\" value=\"" + (nPageActive === undefined ? 1 : (nPageActive === "All" ? -1 : nPageActive)) + "\">");
					$.gf_custom_ajax({
						"oForm": oForm,
						"success": function(r) {
							var JSON = $.parseJSON(r.oRespond);
							//arrayEditor[1].setValue(r.oRespond);
							$("#tab_21").html(JSON.oResult).fadeIn("fast", function() {
								var oTable = $(this).find("table[id='tableData']");
								oTable.find("tr:eq(0) td").on("click", function() {
									sSortBy = $.trim($(this).attr("sfieldname"));
									sSortMode = $.trim(sSortMode) === "" ? "ASC" : ($.trim(sSortMode) === "ASC" ? "DESC" : "ASC");
									oReff = "column";
									$("button[id='cmdAction']").trigger("click");
								});
								//-----------------------------
								$("#ulRowPerPage a").unbind("click").on("click", function() {
									nRowPerPage = $(this).text();
									$("#spanRowPerPage").html(nRowPerPage);
									if ($.trim(nPageActive) === "")
										$("#spanPage").html("1");
									oReff = "paging";
									$("button[id='cmdAction']").trigger("click");
								});
								//-------------------------
								$("#ulPaging").empty().html(JSON.oPaging).find("a").on("click", function() {
									nPageActive = $(this).text();
									$("#spanPage").html(nPageActive);
									oReff = "paging";
									$("button[id='cmdAction']").trigger("click");
								});
							});
							oReff = "button";
						},
						"validate": true,
						"beforeSend": function(r) {},
						"beforeSendType": "custom",
						"error": function(r) {}
					});
				});
			}

			function gf_load_data() {
				$("#div-list-user").ado_load_paging_data({
					url: "<?php print site_url(); ?>c_core_database/gf_load_database/"
				});
			}

			function gf_reset_table(options) {
				if (options.oTableName.find("tr:eq(1) td:eq(1) td").html() !== "No Data") {
					options.oTableName.find("tr:gt(0)").each(function(i, n) {
						$(this).find("td:eq(0)").html(i + 1).css("vertical-align", "middle");
						$(this).find("td:gt(0)").css("vertical-align", "middle");
					});
				}
			}
		</script>