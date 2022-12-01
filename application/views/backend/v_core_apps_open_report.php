<?php
/*
------------------------------
Menu Name: Report
File Name: V_core_apps_open_report.php
File Path: D:\Project\PHP\billing\application\views\v_core_apps_open_report.php
Create Date Time: 2019-08-25 19:07:59
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
?>
<form name="frmParams" id="frmParams" action="<?php print site_url(); ?>c_core_apps_open_report/gf_execute_query/" method="post">
	<div class="row" id="div-top">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="min-height: 170px;">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<?php
					$oData = json_decode($o_listor, TRUE);
					?>
					<div class="box">
						<div class="box-header with-border">
							<span id="divHeading"><b>Report List</b></span>
							<?php
	          		if(intval($this->session->userdata('nGroupUserId_fk')) === 0)
	          		{
	          			?>
	          			| <span class="" style="margin-right: 30px;"><a class="text-blue cursor-pointer" id="aEditCurrentReport">Edit Current Report</a></span>
	          		<?php
	          		}
	          	?>							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12">
								<div class="row">
									<select name="selReport" allow-empty="false" placeholder="Report Name" id="selReport" class="form-control selectpicker" data-size="8" data-live-search="true"><?php print $oData['oOption']; ?></select>
								</div>
							</div>
							<div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 row" style="margin-top: 10px;" id="divDesc">
							</div>
						</div>
					</div>

					<div class="box">
						<div class="box-header with-border">
							<b>Report Parameters</b> | 
							<span class="" style="margin-right: 30px;"><a class="text-blue cursor-pointer" id="aCleanParameter">Clean</a></span>
							<div class="box-tools pull-right">
								<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
								</button>
							</div>
						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div id="divReportParams"></div>
						</div>
						<div class="box-footer">
							<div id="divReportControl" class="hidden">
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 hidden">
										<div class="btn-group"><button type="button" class="btn btn-default" name="cmdAdd" id="cmdAdd"><i class="fa fa-plus"></i> Add Params</button><button type="button" name="cmdClear" id="cmdClear" class="disable btn btn-danger"><i class="fa fa-close"></i> Clear Params</button>
										</div>
									</div>
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<button type="button" name="cmdExec" id="cmdExec" class="disable btn btn-danger btn-block"><i class="fa fa-cog"></i> Execute Report</button>
										<button type="button" name="cmdDownload" id="cmdDownload" class="disable btn btn-default btn-block hidden"><i class="fa fa-download"></i> Download Excel Report</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-9">
					<div class="box box-default">
						<div class="box-header with-border">
							<b>Report Output Area !</b>
						</div>
						<div class="box-body">
							<div id="divReportOuput"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" name="nIdOpenReport" id="nIdOpenReport" value="" />
</form>
<script>
	var sSURL = "<?php print site_url(); ?>c_core_apps_open_report/gf_upload/",
			sParam 													= "",
			dialog 													= "",
			sql 														= "",
			sSortBy 												= "",
			sSortMode 											= "",
			nRowPerPage											= 0, 
			nPageActive                     = 0, 
			nOpenReportsType                = 0,
			bTimer 													= null,
			offset 													= 0,
			paused 													= true,
			nOpenReportOutput 							= null,
			sMRTFilePath 										= null,
			nOpenReportsType 								= null;
			Stimulsoft.Base.StiLicense.key = $.gf_stimulsoft_license();		
	$(function() {
		$("#divReportList a").on("click", function() {
			gf_load_report({
				oObj: $(this),
				oReportName: $(this).html(),
				oReportId: $(this).attr("id"),
				oReportDesc: $(this).attr("desc")
			});
		});
		$("#selReport").on("change", function() {
			gf_load_report({
				oObj: $(this),
				oReportName: $(this).find("option:selected").val(),
				oReportId: $(this).find("option:selected").attr("id"),
				oReportDesc: $(this).find("option:selected").attr("desc")
			});
		});
		$("#cmdExec").on("click", function() {
			var oObj = $(this),
					oForm = $("#frmParams");
			$("#nIdOpenReport").val($("#selReport").find("option:selected").attr("id"));

			if(parseInt(nOpenReportOutput) === 1) // GRID
			{
				oForm.attr("action", "<?php print site_url(); ?>c_core_apps_open_report/gf_execute_query_to_grid/");
				//------------------------------
				$("button[class='close']").trigger("click");
				//------------------------------
				var c = 0;
				$("input[id='txtValue'][mandatory='yes']").each(function(i, n) {
					if ($.trim($(this).val()) === "")
						c++;
				});
				if (c > 0) {
					$.gf_custom_notif({
						oObjDivAlert: $("#divReportParams"),
						"oAddMarginLR": false,
						sMessage: "Found <b>" + c + "</b> empty Prameters. Please fill it !"
					});
					return false;
				}
				c = 0;
				$("select[id='txtValue'][mandatory='yes']").each(function(i, n) {
					if ($.trim($(this).val()) === "")
						c++;
				});
				if (c > 0) {
					$.gf_custom_notif({
						oObjDivAlert: $("#divReportParams"),
						"oAddMarginLR": false,
						sMessage: "Found <b>" + c + "</b> empty Prameters. Please fill it !"
					});
					return false;
				}
				//------------------------------
				$.gf_custom_ajax({
					"oForm": oForm,
					"success": function(r) {
						$("#divReportOuput").fadeIn("fast", function() {
							$(this).html(r.oRespond);
							$(this).removeClass("hidden");
							//-----------------------------
							oObj.removeClass("disabled").html("<i class=\"fa fa-cog\"></i> Execute Report");
							oObj.prev().removeClass("disabled");
							oObj.prev().prev().removeClass("disabled");
							oObj.prev().prev().prev().removeClass("disabled");
							gf_stop_stop_stopwatch();
						});
					},
					"validate": true,
					"beforeSend": function(r) {
						$("#divReportOuput").removeClass("hidden");
						oObj.addClass("disabled").html("<i class=\"fa fa-cog fa-spin fa-fw\"></i> Loading...");
						oObj.prev().addClass("disabled");
						oObj.prev().prev().addClass("disabled");
						oObj.prev().prev().prev().addClass("disabled");
						$("#divReportOuput").html("<br /><br /><br /><br /><center><i class=\"fa fa-cog fa-spin text-red fa-fw fa-3x\" style=\"margin-top: 5px;\"></i><br /> Please wait, Loading Data...<br />&nbsp;<b><span id=\"s_minutes\" style=\"font-size: 22px;\">00</span>:<span id=\"s_seconds\" style=\"font-size: 22px;\">00</span>:<span id=\"s_ms\" style=\"font-size: 22px;\">000</span></b></center><br /><br /><br /><br />&nbsp;");
						gf_start_stop_stopwatch();
					},
					"beforeSendType": "custom",
					"error": function(r) {}
				});
			}
			else if(parseInt(nOpenReportOutput) === 2) //STIMULSOFT
			{
				oForm.attr("action", "<?php print site_url(); ?>c_core_apps_open_report/gf_execute_query_to_mrt/");
				var c = 0;
				$("input[id='txtValue'][mandatory='yes'], select[id='txtValue'][mandatory='yes']").each(function(i, n) {
					if ($.trim($(this).val()) === "")
						c++;
				});
				if (c > 0) {
					$.gf_custom_notif({
						oObjDivAlert: $("#divReportParams"),
						"oAddMarginLR": false,
						sMessage: "Found <b>" + c + "</b> empty Prameters. Please fill it !"
					});
					return false;
				}
				//------------------------------
				$.gf_custom_ajax({
					"oForm": oForm,
					"success": function(r) {
						$("#divReportOuput").fadeIn("fast", function() {
							oObj.removeClass("disabled").html("<i class=\"fa fa-cog\"></i> Execute Report");
							oObj.prev().removeClass("disabled");
							oObj.prev().prev().removeClass("disabled");
							oObj.prev().prev().prev().removeClass("disabled");
							gf_stop_stop_stopwatch();

							var report = Stimulsoft.Report.StiReport.createNewReport();
							var dataset = new Stimulsoft.System.Data.DataSet("data");
							var options = new Stimulsoft.Viewer.StiViewerOptions();

							report.loadFile("<?php print site_url(); ?>"+sMRTFilePath+"?t="+ new Date());
							var u = r.oRespond;
							//console.log(u);
							dataset.readJson(u);
							report.dictionary.databases.clear();
							report.regData(dataset.dataSetName, "data", dataset)
							report.dictionary.synchronize();

							//-- Convert Form Param and Send To Report as a Variable

							//report.setVariable(paramName, paramValue);
							$("label[id='labelParam']").each(function(i, n) {
								var sParamName, sParamValue = "";
								sParamName = $.trim($(this).html());
								if($.trim($.trim(sParamName).substring($.trim(sParamName).length - 2)) === "*")
									sParamName = sParamName.substring(0, $.trim(sParamName).length - 2);
								if($(this).next().hasClass("input-group date")) {
									//-- Date Picker
									sParamValue = $.trim($(this).next().find("input[type='text']").val());
								}
								report.setVariable(sParamName.replace(" ", ""), sParamValue.replace(" ", ""));
							});
						
							options.appearance.scrollbarsMode = false;
							options.toolbar.showOpenButton = false;
							options.toolbar.zoom = 100;
							options.toolbar.autoHide = true;
							options.toolbar.showAboutButton = false;

							//-- Direct print when user click Print toolbar button
							options.toolbar.printDestination = Stimulsoft.Viewer.StiPrintDestination.Direct;

							var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);
							viewer.report = report;
							viewer.renderHtml("divReportOuput");
							$(this).removeClass("hidden");
						});
					},
					"validate": true,
					"beforeSend": function(r) {
						$("#divReportOuput").removeClass("hidden");
						oObj.addClass("disabled").html("<i class=\"fa fa-cog fa-spin fa-fw\"></i> Loading...");
						oObj.prev().addClass("disabled");
						oObj.prev().prev().addClass("disabled");
						oObj.prev().prev().prev().addClass("disabled");
						$("#divReportOuput").html("<br /><br /><br /><br /><center><i class=\"fa fa-cog fa-spin text-red fa-fw fa-3x\" style=\"margin-top: 5px;\"></i><br /> Please wait, Loading Data...<br />&nbsp;<b><span id=\"s_minutes\" style=\"font-size: 22px;\">00</span>:<span id=\"s_seconds\" style=\"font-size: 22px;\">00</span>:<span id=\"s_ms\" style=\"font-size: 22px;\">000</span></b></center><br /><br /><br /><br />&nbsp;");
						gf_start_stop_stopwatch();
					},
					"beforeSendType": "custom",
					"error": function(r) {}
				});
			}
		});
		$("#cmdDownload").on("click", function() {
			var oForm = $("#frmParams");
			oForm.attr("action", "<?php print site_url(); ?>c_core_apps_open_report/gf_export_excel/");
			oForm.find("input[id='hidePageLimit']").remove();
			oForm.find("input[id='hidePageCurrent']").remove();
			oForm.find("input[id='hideSQL']").remove();
			oForm.find("input[id='hideOpenReportsType']").remove();
			oForm.find("input[id='hideReportName']").remove();
			oForm.find("input[id='hideIdReport']").remove();
			//------------------------------
			oForm.append("<input type=\"hidden\" name=\"hideReportName\" id=\"hideReportName\" value=\"" + $("#selReport").find("option:selected").text() + "\">");
			oForm.append("<input type=\"hidden\" name=\"hideIdReport\" id=\"hideIdReport\" value=\"" + $("#selReport").find("option:selected").attr("id") + "\">");
			oForm.append("<input type=\"hidden\" name=\"hideSQL\" id=\"hideSQL\" value=\"" + sql + "\">");
			oForm.append("<input type=\"hidden\" name=\"hidePageLimit\" id=\"hidePageLimit\" value=\"" + (nRowPerPage === undefined ? 20 : nRowPerPage) + "\">");
			oForm.append("<input type=\"hidden\" name=\"hidePageCurrent\" id=\"hidePageCurrent\" value=\"" + (nPageActive === undefined ? 1 : (nPageActive === "All" ? -1 : nPageActive)) + "\">");
			oForm.append("<input type=\"hidden\" name=\"hideOpenReportsType\" id=\"hideOpenReportsType\" value=\"" + nOpenReportsType + "\">");
			//------------------------------
			var c = 0;
			$("input[id='txtValue'][mandatory='yes']").each(function(i, n) {
				if ($.trim($(this).val()) === "")
					c++;
			});
			if (c > 0) {
				$.gf_custom_notif({
					oObjDivAlert: $("#divReportParams"),
					"oAddMarginLR": false,
					sMessage: "Found <b>" + c + "</b> empty Prameters. Please fill it !"
				});
				return false;
			}
			c = 0;
			$("select[id='txtValue'][mandatory='yes']").each(function(i, n) {
				if ($.trim($(this).val()) === "")
					c++;
			});
			if (c > 0) {
				$.gf_custom_notif({
					oObjDivAlert: $("#divReportParams"),
					"oAddMarginLR": false,
					sMessage: "Found <b>" + c + "</b> empty Prameters. Please fill it !"
				});
				return false;
			}
			//------------------------------
			oForm.submit();
		});
		$("a[id='aEditCurrentReport']").on("click", function()
		{			
			$(".sidebar-menu").find("a").removeClass("text-yellow");
			$(".sidebar-menu").
			find("li > a[segment='c_core_apps_report']").
			addClass("text-yellow").
			parent().
			parent().
			parent().
			addClass("active");
			oForm = $.gf_create_form({action: "<?php print site_url(); ?>c_core_apps_report/gf_exec/"});
			oForm.append("<input type=\"hidden\" name=\"Id Open Reports\" id=\"Id Open Reports\" value=\""+$("#selReport").find("option:selected").attr("id")+"\" />");
			$.gf_custom_ajax({"oForm": oForm, 
			"success": function(r)
			{
				$("section[class='content']").html(r.oRespond);
			},
			"validate": true,
			"beforeSend": function(r) 
			{
				$("section[class='content']").html("Loading Data...");
			}, 
			"beforeSendType": "custom", 
			"error": function(r) {} 
			});
		});
		$("a[id='aCleanParameter']").on("click", function()
		{
			$("#divReportParams").find("input[type='text']").val("");
			$("#divReportParams").find("select").find("option:eq(0)").prop("selected", "selected");
			$("#divReportParams").find("select").selectpicker('refresh');
			$("#divReportParams").find("input[type='text']:first").focus();
			$("#divReportParams").find("select:first").focus();
		});
		$("#selReport").trigger("change");
		gf_render_stop_stopwatch();
		$("select").selectpicker('refresh');
	});
	function gf_start_stop_stopwatch(evt) 
	{
		if (paused) {
			paused = false;
			offset -= Date.now();
			gf_render_stop_stopwatch();
		}
	}
	function gf_stop_stop_stopwatch(evt) 
	{
		if (!paused) {
			paused = true;
			offset = 0;
		}
	}
	function gf_reset_stop_stopwatch(evt) 
	{
		if (paused) {
			offset = 0;
			gf_render_stop_stopwatch();
		} else {
			offset = -Date.now();
		}
	}
	function gf_format_stop_stopwatch(value, scale, modulo, padding) 
	{
		value = Math.floor(value / scale) % modulo;
		return value.toString().padStart(padding, 0);
	}
	function gf_render_stop_stopwatch() 
	{
		var value = paused ? offset : Date.now() + offset;
		$('#s_ms').html(gf_format_stop_stopwatch(value, 1, 1000, 3));
		$('#s_seconds').html(gf_format_stop_stopwatch(value, 1000, 60, 2));
		$('#s_minutes').html(gf_format_stop_stopwatch(value, 60000, 60, 2));
		if (!paused) {
			requestAnimationFrame(gf_render_stop_stopwatch);
		}
	}
	function gf_load_report(options) 
	{
		var oObj 						= options.oObj,
				nIdOpenReport 	= options.oReportId,
				sDescOpenReport = options.oReportDesc,
				sReportName 		= options.oReportName;
		$("#div-top").prev().find("button").trigger("click");
		$("#divDesc").html("Report Description:<br /> <b>" + sDescOpenReport + "</b>");
		//$("#divHeading").html("<b>" + sReportName + "</b>");
		if ($.trim(nIdOpenReport) !== "") {
			var objForm = $.gf_create_form({
				"action": "<?php print site_url(); ?>c_core_apps_open_report/gf_read_open_reports/"
			});
			objForm.append("<input type=\"hidden\" name=\"nIdOpenReport\" id=\"nIdOpenReport\" value=\"" + $.trim(nIdOpenReport) + "\" />");
			$.gf_custom_ajax({
				"oForm": objForm,
				"success": function(r) {
					if ($.trim(r.oRespond) !== "") {
						var JSON = $.parseJSON(r.oRespond);
						sql = JSON.oSQL;
						nOpenReportsType = JSON.oData.nOpenReportsType;
						nOpenReportOutput = JSON.oData.nOpenReportOutput; // 1: GRID, 2: STIMULSOFT
						sMRTFilePath = JSON.oData.sFullFileName;
						if(parseInt(nOpenReportOutput) === 1)
							$("#cmdDownload").removeClass("hidden");
						else
						$("#cmdDownload").addClass("hidden");
						if (parseInt(nOpenReportsType) === 2) //-- Static By Params
						{
							var sOpenReportsStaticParams = $.parseJSON(JSON.oData.sOpenReportsStaticParams);
							var s = "<form name=\"frmParams\" id=\"frmParams\" action=\"<?php print site_url(); ?>c_core_apps_open_report/gf_execute_query/\" method=\"post\">";
							$.each(sOpenReportsStaticParams, function(i, n) {
								s += "<div id=\"divWrap\" class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 \"><div class=\"row\">";
								s += "<div class=\"col-xs-12 colpsm-12 col-md-5 col-lg-5 form-group\">";
								s += "<label id=\"labelParam\">Field Name</label><br />" + n.sFieldName + "";
								s += "<input type=\"hidden\" name=\"selFieldName[]\" id=\"selFieldName\" value=\"" + n.sFieldName + "\" /><input type=\"hidden\" name=\"selFieldLabelName[]\" id=\"selFieldLabelName\" value=\"" + n.sFieldName + "\" /></div>";
								//---------------
								s += "<div class=\"col-xs-12 col-sm-12 col-md-4 col-lg-4 form-group\">";
								s += "<label>Value</label>";
								if (parseInt(n.sFieldType) === 12) //-- Date
								{
									s += "<div class=\"input-group date\"><input mandatory=\"" + $.trim(n.sMandatory) + "\" value=\"\" allow-empty=\"false\" name=\"txtValue[]\" id=\"txtValue\" type=\"text\" class=\"form-control\"><span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span></div>";
								} else {
									s += "<input mandatory=\"" + $.trim(n.sMandatory) + "\" type=\"text\" name=\"txtValue[]\" id=\"txtValue\" ";
									if ($.inArray(parseInt(n.sFieldType), [3, 5]) !== -1) //-- Date, Numeric
									{
										s += "content-mode=\"numeric\" ";
									}
									s += "class=\"form-control\">";
								}
								s += "</div>";
								//---------------
								s += "<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3 form-group\">";
								s += "<label>Operand</label>";
								s += "<select disabled placeholder=\"Operand\" id=\"selOperand\" class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" name=\"selOperand[]\" class=\"form-control\"><option value=\"AND\">AND</option><option value=\"OR\">OR</option>";
								s += "</select>";
								s += "</div>";
								//---------------
								s += "</div><input type=\"hidden\" name=\"hideType[]\" id=\"hideType\" value=\"" + n.sFieldType + "\" />";
								s += "</div>";
							});
							s += "</form>";
							$("#divReportControl").removeClass("hidden").find("button:eq(0), button:eq(1)").addClass("hidden");
							$("div[id='divReportParams']").html(s);
							$("select[id='selOperand']").selectpicker('refresh');
							$('.input-group.date').datepicker({
								autoclose: true,
								gf_format_stop_stopwatch: "dd/mm/yyyy",
							});
							$("input[content-mode='numeric']").addClass("text-right").autoNumeric('init', {
								mDec: '0',
								aSep: ''
							});
						} else if (parseInt(nOpenReportsType) === 3) //-- Static By Value
						{
							var sOpenReportsStaticParams = $.parseJSON(JSON.oData.sOpenReportsStaticParams);
							var s = "<form name=\"frmParams\" id=\"frmParams\" action=\"<?php print site_url(); ?>c_core_apps_open_report/gf_execute_query/\" method=\"post\">";
							$.each(sOpenReportsStaticParams, function(i, n) {
								s += "<div id=\"divWrap\" class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 no-padding\"><div class=\"row\">";
								s += "<input type=\"hidden\" name=\"selFieldName[]\" id=\"selFieldName\" value=\"" + n.sFieldName + "\" /><input type=\"hidden\" name=\"selFieldLabelName[]\" id=\"selFieldLabelName\" value=\"" + n.sLabel + "\" />";
								s += "<input type=\"hidden\" name=\"selOperator[]\" id=\"selOperator\" value=\"" + n.sOperator + "\" />";
								s += "<input type=\"hidden\" name=\"selOperand[]\" id=\"selOperand\" value=\"AND\" />";
								//---------------
								s += "<div class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group\">";
								s += "<label id=\"labelParam\">" + n.sLabel + " " + ($.trim(n.sMandatory) === "yes" ? "*" : "") + "</label>";
								if (n.sDataSource === undefined) {
									if (parseInt(n.sFieldType) === 12) //-- Date
									{
										s += "<div class=\"input-group date\"><input placeholder=\"" + n.sLabel + "\" mandatory=\"" + $.trim(n.sMandatory) + "\" value=\""+(n.sDefaultToday ? dmy() : "")+"\" allow-empty=\"false\" name=\"txtValue[]\" id=\"txtValue\" type=\"text\" class=\"form-control\"><span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span></div>";
									} else {
										s += "<input type=\"text\" placeholder=\"" + n.sLabel + "\" mandatory=\"" + $.trim(n.sMandatory) + "\" name=\"txtValue[]\" id=\"txtValue\" ";
										if ($.inArray(parseInt(n.sFieldType), [3, 5]) !== -1) //-- Date, Numeric
											s += "content-mode=\"numeric\" ";
										s += "class=\"form-control\">";
									}
								} else {
									//-- Klo Pake Query, tapi masih blm bisa nih, async problem
									var sSQL = n.sDataSource;
									var sChoiceValue = null; //n.sDataSource.sChoiceValue;
									var sChoiceLabel = null; //n.sDataSource.sChoiceLabel;

									s += "<select placeholder=\"" + n.sLabel + "\"  mandatory=\"" + $.trim(n.sMandatory) + "\" mode=\"selParam\" sql=\"" + sSQL + "\" allow-empty=\"false\" id=\"txtValue\" class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" name=\"txtValue[]\"></select>";
								}
								s += "</div>";
								//---------------
								s += "<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3 form-group hidden\">";
								s += "<label>Operand</label>";
								s += "<select disabled placeholder=\"Operand\" id=\"selOperand\" class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" name=\"selOperand[]\" class=\"form-control\"><option value=\"AND\">AND</option><option value=\"OR\">OR</option>";
								s += "</select>";
								s += "</div>";
								//---------------
								s += "</div><input type=\"hidden\" name=\"hideType[]\" id=\"hideType\" value=\"" + n.sFieldType + "\" />";
								s += "</div>";
							});
							s += "</form>";
							$("#divReportControl").removeClass("hidden").find("button:eq(0), button:eq(1)").addClass("hidden");
							$("div[id='divReportParams']").html(s).fadeIn("fast", function() {
								$("select[id='selOperand'], select[id='txtValue']").selectpicker('refresh');
								$('.input-group.date').datepicker({
									autoclose: true,
									format: "dd/mm/yyyy"
								});
								$("input[content-mode='numeric']").addClass("text-right").autoNumeric('init', {
									mDec: '0',
									aSep: ''
								});
								$("select[mode='selParam']").each(function(i, n) {
									//alert($(this).attr("sql"));
									var oObj = $(this);
									var objForm = $.gf_create_form({
										"action": "<?php print site_url(); ?>c_core_apps_open_report/gf_query/"
									});
									objForm.append("<input type=\"hidden\" name=\"sSQL\" id=\"sSQL\" value=\"" + $.trim($(this).attr("sql")) + "\" />");
									$.gf_custom_ajax({
										"oForm": objForm,
										asyns: true,
										"success": function(r) {
											var JSON = $.parseJSON(r.oRespond);
											var oVal = "";
											oVal += "<option value=\"\">All</option>";
											$.each(JSON, function(i, n) {
												oVal += "<option value=\"" + n.choicevalue + "\">" + n.choicelabel + "</option>";
											});
											oObj.removeClass("disabled").prop("disabled", false).selectpicker('refresh');
											oObj.html(oVal);
											oObj.selectpicker('refresh');
										},
										"beforeSendType": "custom",
										"beforeSend": function() {
											oObj.html("<option>Loading...</option>");
											oObj.find("option:eq(0)").prop("selected", true);
											oObj.addClass("disabled").prop("disabled", true).selectpicker('refresh');
										}
									});
								});
							});
						} else if (parseInt(nOpenReportsType) === 1) //-- Dynamic	
						{
							var sOption = "";
							$.each(JSON.oFieldName, function(i, n) {
								sOption += "<option type=\"" + n.type + "\"value=\"" + n.name + "\">" + n.name /*+" ["+n.type+"]*/ + "</option>";
							});
							//---------------
							var s = "<div id=\"divWrap\" class=\"col-xs-12 col-sm-12 col-md-12 col-lg-12 row\"><div class=\"row\">";
							s += "<div class=\"col-xs-12 colpsm-12 col-md-3 col-lg-3 form-group\">";
							s += "<label>Field Name</label>";
							s += "<select placeholder=\"Field Name\" id=\"selFieldName\" class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" name=\"selFieldName[]\" class=\"form-control\">" + sOption;
							s += "</select>";
							s += "</div>";
							//---------------
							s += "<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3 form-group\">";
							s += "<label>Operator</label>";
							s += "<select placeholder=\"Operator\" id=\"selOperator\" class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" name=\"selOperator[]\" class=\"form-control\">";
							s += "</select>";
							s += "</div>";
							//---------------
							s += "<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3 form-group\">";
							s += "<label>Value</label>";
							s += "<div id=\"divTxt\"><input type=\"text\" name=\"txtValue[]\" id=\"txtValue\" ";
							s += "content-mode=\"\" ";
							s += "class=\"form-control\"></div>";
							s += "</div>";
							//---------------
							s += "<div class=\"col-xs-12 col-sm-12 col-md-3 col-lg-3 form-group\">";
							s += "<label>Operand - <a id=\"aRemoveParams\" class=\"cursor-pointer\">Remove</a></label>";
							s += "<select placeholder=\"Operand\" id=\"selOperand\" class=\"form-control selectpicker\" data-size=\"8\" data-live-search=\"true\" name=\"selOperand[]\" class=\"form-control\"><option value=\"AND\">AND</option><option value=\"OR\">OR</option>";
							s += "</select>";
							s += "</div>";
							//---------------
							s += "</div>";
							s += "</div>";
							$("#divReportControl").removeClass("hidden").find("button:eq(0), button:eq(1)").removeClass("hidden");
							$("div[id='divReportParams']").html(s);
							$("select[id='selFieldName'], select[id='selOperator'], select[id='selOperand']").selectpicker('refresh');
							//---------------
							$("button[id='cmdAdd']").unbind("click").on("click", function() {
								$("div[id='divReportParams']").append(s).show("fast", function() {
									$("select[id='selFieldName'], select[id='selOperator'], select[id='selOperand']").selectpicker('refresh');
									$("a[id='aRemoveParams']").unbind("click").on("click", function() {
										if ($("div[id='divWrap']").length > 1)
											$(this).parent().parent().parent().parent().slideUp("fast", function() {
												$(this).remove();
											});
										else {
											$("select[id='selFieldName']").find("option:eq(0)").attr("selected", "selected");
											$("select[id='selOperator']").empty();
											$("select[id='selFieldName'], select[id='selOperator'], select[id='selOperand']").selectpicker('refresh');
											$("input[id='txtValue']").val("");
										}
									});
									$("select[id='selFieldName']").on("change", function() {
										var oObjTxtValue = $(this).parent().parent().next().next().find("input[type='text']");
										var divWrap = $(this).parent().parent().parent().parent();
										//---------------------------------------------------------------			
										if (divWrap.find("input[id='hideType']").length === 1)
											divWrap.find("input[id='hideType']").remove();
										divWrap.append("<input type=\"hidden\" name=\"hideType[]\" id=\"hideType\" value=\"" + $(this).find("option:selected").attr("type") + "\" />")
										//---------------------------------------------------------------			
										var selOperator = $(this).parent().parent().next().find("select");
										selOperator.empty();
										selOperator.selectpicker('refresh');
										console.log($(this).parent().parent().next().next().find("input[type='text']").attr("id"));
										//---------------------------------------------------------------------------------------------
										oObjTxtValue.removeClass("text-right").removeClass("text-left").attr("content-mode", "").autoNumeric('destroy'); //destroy	
										//---------------------------------------------------------------------------------------------
										if ($.inArray(parseInt($(this).find("option:selected").attr("type")), [3, 5, 12, 10]) !== -1) //-- Date, Numeric
										{
											if ($.inArray(parseInt($(this).find("option:selected").attr("type")), [3, 5]) !== -1) //-- Numeric
												oObjTxtValue.attr("content-mode", "numeric");
											else
												oObjTxtValue.attr("content-mode", "").addClass("text-left");
											var o = "<option value=\">\">></option>";
											o += "<option value=\"<\"><</option>";
											o += "<option value=\">=\">>=</option>";
											o += "<option value=\"<=\"><=</option>";
											o += "<option value=\"!=\">!=</option>";
											selOperator.empty().append(o);
											selOperator.selectpicker('refresh');
										} else if ($.inArray(parseInt($(this).find("option:selected").attr("type")), [253, 254]) !== -1) //-- String
										{
											var o = "<option value=\"LIKE\">LIKE</option>";
											o += "<option value=\"=\">=</option>";
											o += "<option value=\"!=\">!=</option>";
											selOperator.empty().append(o);
											selOperator.selectpicker('refresh');
										}
										//oObjTxtValue.parent().empty();
										if ($.inArray(parseInt($(this).find("option:selected").attr("type")), [12, 10]) !== -1) //Date
										{
											oObjTxtValue.parent().html("<div class=\"input-group date\"><input value=\"\" allow-empty=\"false\" name=\"txtValue[]\" id=\"txtValue\" type=\"text\" class=\"form-control\"><span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span></div>");
											//oObjTxtValue.datepicker({ autoclose: true, gf_format_stop_stopwatch: "dd/mm/yyyy", });
											$('.input-group.date').datepicker({
												autoclose: true,
												gf_format_stop_stopwatch: "dd/mm/yyyy",
											});
										}
										if ($.inArray(parseInt($(this).find("option:selected").attr("type")), [3, 5]) !== -1) //Date
										{
											oObjTxtValue.parent().html("<div><input type=\"text\" name=\"txtValue[]\" id=\"txtValue\" content-mode=\"numeric\" class=\"form-control\"></div>");
											//oObjTxtValue.addClass("text-right").autoNumeric('init', {mDec: '0', aSep : ''});  //destroy
											$("input[content-mode='numeric']").addClass("text-right").autoNumeric('init', {
												mDec: '0',
												aSep: ''
											});
										}
										oObjTxtValue.val("");
									});
									$("select[id='selFieldName']:last").trigger("change");
								});
							});
							$("button[id='cmdClear']").unbind("click").on("click", function() {
								$("div[id='divWrap']:gt(0)").slideUp("fast", function() {
									$(this).remove();
								});
								$("select[id='selFieldName']").find("option:eq(0)").attr("selected", "selected");
								$("select[id='selOperator']").find("option:eq(0)").attr("selected", "selected");
								$("select[id='selOperand']").find("option:eq(0)").attr("selected", "selected");
								$("select[id='selFieldName'], select[id='selOperator'], select[id='selOperand']").selectpicker('refresh');
								$("").selectpicker('refresh');
								$("input[id='txtValue']").val("");
							});
							$("a[id='aRemoveParams']").unbind("click").on("click", function() {
								if ($("div[id='divWrap']").length > 1)
									$(this).parent().parent().parent().parent().slideUp("fast", function() {
										$(this).remove();
									});
								else {
									$("select[id='selFieldName']").find("option:eq(0)").attr("selected", "selected");
									$("select[id='selOperator']").find("option:eq(0)").attr("selected", "selected");
									$("select[id='selOperand']").find("option:eq(0)").attr("selected", "selected");
									$("select[id='selFieldName'], select[id='selOperator'], select[id='selOperand']").selectpicker('refresh');
									$("input[id='txtValue']").val("");
								}
							});
							$("select[id='selFieldName']").on("change", function() {
								var oObjTxtValue = $(this).parent().parent().next().next().find("input[type='text']");
								var divWrap = $(this).parent().parent().parent().parent();
								//---------------------------------------------------------------			
								if (divWrap.find("input[id='hideType']").length === 1)
									divWrap.find("input[id='hideType']").remove();
								divWrap.append("<input type=\"hidden\" name=\"hideType[]\" id=\"hideType\" value=\"" + $(this).find("option:selected").attr("type") + "\" />")
								//---------------------------------------------------------------			
								var selOperator = $(this).parent().parent().next().find("select");
								selOperator.empty();
								selOperator.selectpicker('refresh');
								console.log($(this).parent().parent().next().next().find("input[type='text']").attr("id"));
								//---------------------------------------------------------------------------------------------
								oObjTxtValue.removeClass("text-right").removeClass("text-left").attr("content-mode", "").autoNumeric('destroy'); //destroy	
								//---------------------------------------------------------------------------------------------
								if ($.inArray(parseInt($(this).find("option:selected").attr("type")), [3, 5, 12, 10]) !== -1) //-- Date, Numeric
								{
									if ($.inArray(parseInt($(this).find("option:selected").attr("type")), [3, 5]) !== -1) //-- Numeric
										oObjTxtValue.attr("content-mode", "numeric");
									else
										oObjTxtValue.attr("content-mode", "").addClass("text-left");
									var o = "<option value=\">\">></option>";
									o += "<option value=\"<\"><</option>";
									o += "<option value=\">=\">>=</option>";
									o += "<option value=\"<=\"><=</option>";
									o += "<option value=\"!=\">!=</option>";
									selOperator.empty().append(o);
									selOperator.selectpicker('refresh');
								} else if ($.inArray(parseInt($(this).find("option:selected").attr("type")), [253, 254]) !== -1) //-- String
								{
									var o = "<option value=\"LIKE\">LIKE</option>";
									o += "<option value=\"=\">=</option>";
									o += "<option value=\"!=\">!=</option>";
									selOperator.empty().append(o);
									selOperator.selectpicker('refresh');
								}
								//oObjTxtValue.parent().empty();
								if ($.inArray(parseInt($(this).find("option:selected").attr("type")), [12, 10]) !== -1) //Date
								{
									oObjTxtValue.parent().html("<div class=\"input-group date\"><input value=\"\" allow-empty=\"false\" name=\"txtValue[]\" id=\"txtValue\" type=\"text\" class=\"form-control\"><span class=\"input-group-addon\"><i class=\"fa fa-calendar\"></i></span></div>");
									//oObjTxtValue.datepicker({ autoclose: true, gf_format_stop_stopwatch: "dd/mm/yyyy", });
									$('.input-group.date').datepicker({
										autoclose: true,
										gf_format_stop_stopwatch: "dd/mm/yyyy",
									});
								}
								if ($.inArray(parseInt($(this).find("option:selected").attr("type")), [3, 5]) !== -1) //Date
								{
									oObjTxtValue.parent().html("<div><input type=\"text\" name=\"txtValue[]\" id=\"txtValue\" content-mode=\"numeric\" class=\"form-control\"></div>");
									//oObjTxtValue.addClass("text-right").autoNumeric('init', {mDec: '0', aSep : ''});  //destroy
									$("input[content-mode='numeric']").addClass("text-right").autoNumeric('init', {
										mDec: '0',
										aSep: ''
									});
								}
								oObjTxtValue.val("");
							});
							$("select[id='selFieldName']:last").trigger("change");
						}
					} else
						$("#divReportParams").html("No Reports has been Querying. Please check your Table !");
				},
				"validate": true,
				"beforeSend": function(r) {
					$("#divReportParams").html("<center><i class=\"fa fa-cog fa-spin text-red fa-fw fa-3x\" style=\"margin-top: 5px;\"></i><br /> Please wait...<br />Loading Parameters...<br />&nbsp;</center>")
					$("#divReportOuput").empty().html("Please select Report !");
				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
		}
	}
	function dmy() {
		const today = new Date();
		const yyyy = today.getFullYear();
		let mm = today.getMonth() + 1; // Months start at 0!
		let dd = today.getDate();

		if (dd < 10) dd = '0' + dd;
		if (mm < 10) mm = '0' + mm;

		const formattedToday = dd + '/' + mm + '/' + yyyy;
		return formattedToday;
	}
</script>