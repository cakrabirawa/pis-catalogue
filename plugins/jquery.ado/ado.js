var oThemes = BootstrapDialog.TYPE_PRIMARY;
var oBGAlert = "bg-danger";
var oSpinnerThemesColor = "text-red";
var oBlurEffect = !true;
var oBlurSize = "2px";

(function ( $ ) {
	$.fn.ado_numeric_only = function() {	
	  // This is the easiest way to have default options.
	  /*var settings = $.extend({
	      // These are the defaults.
	      color: "#556b2f",
	      backgroundColor: "white"
	  }, options );*/

	  this.keydown(function (e) 
	  {
	    // Allow: backspace, delete, tab, escape, enter and .
	    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	         // Allow: Ctrl+A, Command+A
	        (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
	         // Allow: home, end, left, right, down, up
	        (e.keyCode >= 35 && e.keyCode <= 40)) {
	             // let it happen, don't do anything
	             return;
	    }
	    // Ensure that it is a number and stop the keypress
	    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	        e.preventDefault();
	    }
	  }).addClass("text-right");
	  return this;
	}	
	$.fn.ado_load_paging_data = function(options) {
		var oObj = this;
		 var oForm = $.gf_create_form({"action": options.url});
		 $.gf_custom_ajax_o({"oForm": oForm, 
			"callback": function(r)
			{
				$.gf_loading_hide();
				oObj.css("display", "none").html(r.oRespond).fadeIn("fast", function()
				{
					if(options.callback)
						options.callback();
				});
			},
			"validate": true,
			"beforeSend": function(r) {
				oObj.html("<div class=\"text-center\">"+$.gf_spinner()+"Loading Data...<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;<br />&nbsp;</div>");
				$.gf_loading_show();
				}, 
			"beforeSendType": "custom", 
			"error": function(r) {
				oObj.html(r.oData);
				} 
		});
		return this;
	}	
	$.fn.ado_combo_add_item = function(options) {
		var oObjSelect01 = this;
		var oObjSelect02 = $(this);
		oObjSelect01.append("<option value=\"--Add New--\">--Add New--</option>").on("change", function()
		{
			if($.trim(oObjSelect02.find("option:selected").val()) == "--Add New--")
			{
				var mForm = "<div class=\"col-sm-12\">";
				$.each(options.sObjType, function(i, n)
				{
					if(n.oType != "hidden")
						mForm += "<label>"+n.oPlaceHolder+"</label><input type=\""+n.oType+"\" name=\""+n.oId+"\" id=\""+n.oType+"\" placeholder=\""+n.oPlaceHolder+"\" value=\""+n.oInitVal+"\" class=\"form-control\" />";
					else
						mForm += "<label></label><input type=\""+n.oType+"\" name=\""+n.oId+"\" id=\""+n.oType+"\" placeholder=\""+n.oPlaceHolder+"\" value=\""+n.oInitVal+"\" class=\"form-control\" />";
				});
				mForm += "</div>";
				
				var opt = options;
					BootstrapDialog.show({
					type: oThemes,
		 		  title: options.sHeaderInfo,
          message: "<form id=\"form-add-new\" role=\"form\" method=\"post\" action=\""+options.sUrlSave+"\">"+mForm+"</form><br /><br /><br />",            
          buttons: [{
              label: 'Save',
              cssClass: 'btn-danger',
              action: function(dialogRef) {
              		var $button = this;
              		var objForm = $("#form-add-new");
                  $.ajax({
													  type: "POST",
													  url: objForm.attr("action"),
													  data: objForm.serialize(),	
													  beforeSend: function()
													  {
													  	$button.spin(); 
													  	$button.disable();
									          },
													  success: function(r)
													  {
													  	var JSON = $.parseJSON(r);
													  	if(JSON.status === 1)
							                {
							                	oObjSelect02.empty();
							                	$.ajax({
																  type: "GET",
																  url: options.sURLReload,
																  success: function(r)
																  {
																  	oObjSelect02.append(r);
																  	oObjSelect02.append("<option value=\"--Add New--\">--Add New--</option>");
																  	oObjSelect02.find("option").length;
																  	oObjSelect02.find("option:nth-child("+(oObjSelect02.find("option").length - 1)+")").attr("selected", "selected");
																  }
																});							                	
							                	
							                	dialogRef.close();
							                }
													  	else
													  	{
													      $("<div id=\"div-alert\" class=\"alert "+oBGAlert+" alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p><b>"+JSON.message+"</b> can't Empty...</p></div>").insertBefore($("#form-add-new"));
													      $button.stopSpin(); 
													  		$button.enable();
													  	}
													  }
													});
              }},{
              label: 'Close',
              cssClass: 'btn-default',
              hotkey: 27,
              action: function(dialogRef) {
              	dialogRef.close();   
              }                
          }],
          onshown: function(dialogRef)
          {
          	dialogRef.getModalBody().find("input[type='text']:first").focus();
        	}
        });
      }
		});
	}
	$.fn.ado_checkbox = function(options)
	{
		var oCheck = this;
		var oWrap = $("<div id=\"divCheckBox_"+oCheck.attr("id")+"\" class=\"checkbox checkbox-slider--b-flat\"></div>");
		oWrap.html("<label><input type=\"checkbox\" class=\"hidden\" id=\""+oCheck.attr("id")+"\" name=\""+oCheck.attr("name")+"\">"+(oCheck.attr("label") !== undefined ? "<span>" + oCheck.attr("label") + "</span>" : "")+"</label>");
		oWrap.insertAfter(oCheck);
		oCheck.remove();
		if(options.onclick !== "undefined")
		{
			oWrap.unbind("click").on("click", function(e)
			{
				var oInnerCheckBox = $(this).find("input[type='checkbox']");
				if(oInnerCheckBox.prop("checked"))
				{
					oInnerCheckBox.prop("checked", false);
					options.onclick({state: false});
				}
				else
				{
					oInnerCheckBox.prop("checked", true);
					options.onclick({state: true});
				}
			});		
		}
		return this;
	}
	$.fn.ado_image = function(src, f) {
		return this.each(function() {
			var i = new Image();
			i.src = src;
			i.onload = f;
			this.appendChild(i);
		});
	}
}( jQuery ));

//-- Function Call
jQuery.extend
({
	gf_msg_info_on_top: function(options)
	{
		$("div[id^='divAlert']").remove();
		var oDivAlertId = $.gf_generate_unique_id({});
		var d = $("<div id=\"divAlert"+oDivAlertId+"\" style=\"display: none; "+(options.oAddMarginLR !== undefined && options.oAddMarginLR ? "margin-left: 15px; margin-right: 15px; display: none;" : "")+"\" class=\"alert bg-"+ (options.oThemes === undefined ? "danger" : options.oThemes) +" alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>"+ options.oMessage +" </p></div>");
		d.insertBefore(options.oObjDivAlert);	
		d.slideDown("fast", function()
		{
			$("#divAlert"+oDivAlertId).find("button[class='close']").unbind("click").on("click", function()
		  {
				$("section[class='content']").scrollTo($("div[id='divAlert"+oDivAlertId+"']"), 2500);
		    $("#divAlert"+oDivAlertId).slideUp("fast", function()
		    {
		      $(this).remove();
		      if(options.oFocusObject)
			      options.oFocusObject.focus();
		    });
		  });
		});
	},
	gf_msg_info: function(options)
	{
		/*$("div[id^='divAlert']").remove();
		var oDivAlertId = $.gf_generate_unique_id({});
		var d = $("<div id=\"divAlert"+oDivAlertId+"\" style=\"display: none; "+(options.oAddMarginLR !== undefined && options.oAddMarginLR ? "margin-left: 15px; margin-right: 15px; display: none;" : "")+"\" class=\"alert bg-"+ (options.oThemes === undefined ? "danger" : options.oThemes) +" alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>"+ options.oMessage +" </p></div>");
		d.insertBefore(options.oObjDivAlert);	
		d.slideDown("fast", function()
		{
			$("#divAlert"+oDivAlertId).find("button[class='close']").unbind("click").on("click", function()
		  {
				$("section[class='content']").scrollTo($("div[id='divAlert"+oDivAlertId+"']"), 2500);
		    $("#divAlert"+oDivAlertId).slideUp("fast", function()
		    {
		      $(this).remove();
		      if(options.oFocusObject)
			      options.oFocusObject.focus();
		    });
		  });
		});*/	
		$.gf_msg_box({oMessage: options.oMessage});	
	},
	gf_msg_box: function(options)
	{
		var oDialog = new BootstrapDialog({ 
							title: (options.oTitle === undefined ? "Information" : options.oTitle), 
							closable: false,
							message: options.oMessage, 
							type : options.oThemes === undefined ? BootstrapDialog.TYPE_DEFAULT : options.oThemes, 
							buttons: [{ 
								id:'cmdClose', 
								label: options.oCmdLabel === undefined ? "Close" : options.oCmdLabel, 
								cssClass: 'btn-default', 
								hotkey: 13,
								action: function(d)
								{
									d.close();
									if(options.oFocusObject)
										options.oFocusObject.focus();
								} 
								}] 
							});	
		oDialog.open();
	},
	gf_create_form: function(options)
	{
		var oForm = null;
		var x = $.gf_generate_unique_id({"oLength": 10});
		$("form[id^='frmOTF']").remove();
		$("<form id=\"frmOTF"+x.toString()+"\" style=\"display:none;\" action=\""+options.action+"\" method=\"post\"></form>").appendTo("body");
  	oForm = $("form[id='frmOTF"+x.toString()+"']");
  	if(options.params !== undefined)
  	{
  		$.each(options.params, function(i, n)
  		{
  			oForm.append("<input type=\"hidden\" name=\""+n.name+"\" id=\""+n.name+"\" value=\""+n.value+"\" />")
  		});	
  	}
		return oForm;
	},
	gf_custom_ajax: function(options)
	{
		var oForm = null;
		var oDialog = null;
		oForm = options.oForm;
		if(options.validate !== undefined)
		{
			if(options.validate)
			{
				//-- Clear Single Quote
				/*
				oForm.find("input[type='text']:not(:disabled), textarea:not(:disabled)").each(function() 
				{ 
					var s = $(this).val();
					s = s.replace(/'/g,"''");
					s = s.replace(/' '/g,"");
					s = s.replace(/\\/g, "\\");
					$(this).val(s); 
				}); 
				oForm.find("input[content-mode='numeric']").each(function() 
				{ 
					var s = $(this).val();
					s = s.replace(/,/g,"");
					s = s.replace(/' '/g,"");
					$(this).val(s); 
				}); 
				*/
			}
		}
		$.ajax({
			type: oForm.attr("method"),
			url: oForm.attr("action"),
			data: oForm.serialize(),
			async: true,	
			success: function(r)
			{
				$.gf_loading_hide();
				if(options.success !== undefined)
				{
					var t = options.loadingMessage !== undefined ? options.loadingMessage : "Please wait, saving data...";
					var m = "<div class=\"text-center\">"+$.gf_spinner()+t+"</div>";
					oDialog = new BootstrapDialog({ 
					title: 'Information', 
					closable: false,
					message: m, 
					type : oThemes, 
					buttons: [{ 
						id:'cmd-loading', 
						label: 'Please Wait...', 
						cssClass: 'btn-default disabled', 
						hotkey: 13 
						}] 
					});	
					options.success({"oForm": oForm, "oRespond": r, "oDialog": oDialog});
				}
			},
			complete: function() {
				if(oForm.find("button[id='button-submit']").length > 0) 
					$.gf_unblock_window();
			},
			error: function(oRespondHTTP, oTextStatus, oErrorThrown)
			{
				$.gf_loading_hide();
				if(options.error !== undefined)
				{
					$.gf_remove_all_modal();
					if(options.beforeSend !== undefined)
					{
						if(options.beforeSendType === "standard")
						{
							var t = options.loadingMessage !== undefined ? options.loadingMessage : "Please wait, saving data...";
							var m = "<div class=\"text-center\">"+$.gf_spinner()+t+"</div>";
							oDialog = new BootstrapDialog({ 
							title: 'Information', 
							closable: false,
							message: m, 
							type : oThemes, 
							buttons: [{ 
								id:'cmd-loading', 
								label: 'Please Wait...', 
								cssClass: 'btn-default disabled', 
								hotkey: 13 
								}] 
							});	
							options.error({"oRespondHTTP": oRespondHTTP, "oDialog": oDialog});					
							if(oDialog !== null)
							{
								oDialog.open()
								oDialog.getModalBody().html(oRespondHTTP.responseText); 
								oDialog.setType(BootstrapDialog.TYPE_DEFAULT); 
								oDialog.getModalFooter().find("button[id='cmd-loading']").removeClass("disabled").html("Close").bind("click", function() 
								{ 
									oDialog.close(); 
									$("div[id='divContenLoading']").remove();
									$("div[class='plainoverlay']").fadeOut("fast", function()
									{
										$(this).remove();
									});
								});	
							}
						}
					}
				}
				if(oForm.find("button[id='button-submit']").length > 0) 
					$.gf_unblock_window();
			},
			beforeSend: function(oJqXHR, oSettings)
			{
				if(oForm.find("button[id='button-submit']").length > 0) 
					$.gf_block_window();

					if(options.beforeSend !== undefined)
				{
					if(options.beforeSendType === "standard")
					{
						/*var t = options.loadingMessage !== undefined ? options.loadingMessage : "Please wait, saving data...";
						var m = "<div class=\"text-center\">"+$.gf_spinner()+t+"</div>";
						m = "<div class=\"text-center\">"+$.gf_spinner()+t+"</div>";
						var x = $.gf_custom_modal({"sMessage": m});
						options.beforeSend({oCustomModal: x});*/
						$.gf_loading_show({sMessage: options.loadingMessage !== undefined ? options.loadingMessage : "Please wait, saving data..."});
					}
					else if(options.beforeSendType === "custom")
						options.beforeSend({});	
				}
			}					  		  
		});
	},
	gf_block_window: function(options)
	{
		$("body").append("<div class=\"modal bootstrap-dialog\" role=\"dialog\" aria-hidden=\"true\" tabindex=\"-1\" style=\"cursor: wait; z-index: 10299; display: block;\"></div>");
	},
	gf_unblock_window: function(options)
	{
		$("body").find("div[class='modal bootstrap-dialog']").fadeOut("fast");
	},
	gf_custom_ajax_o: function(options)
	{
		var oForm = null;
		oForm = options.oForm;
		$.ajax({
				  type: oForm.attr("method"),
				  url: oForm.attr("action"),
				  data: oForm.serialize(),
				  async: true,
				  success: function(r)
				  {
				  	options.callback({"oRespond": r});
				  },
				  error: function(oRespondHTTP, oTextStatus, oErrorThrown)
				  {
	          options.callback({"oRespond": oRespondHTTP});
				  },
				  beforeSend: function(oJqXHR, oSettings)
				  {
				  	if(options.beforeSend !== undefined)
				  	{
				  		if(options.beforeSendType === "standard")
				  		{
				  			var t = options.loadingMessage !== undefined ? options.loadingMessage : "Please wait, saving data...";
				  			var m = "<div class=\"text-center\">"+$.gf_spinner()+t+"</div>";
						  	var x = $.gf_custom_modal({"sMessage": m});
								options.beforeSend({oCustomModal: x});	
							}
							else if(options.beforeSendType === "custom")
				  			options.beforeSend({});	
				  	}
				  }					  		  
				});
	},
	gf_custom_modal: function(options)
	{		
		var nHeight = options.oObj !== undefined ? options.oObj.css("height") : 0;
		var nWidth = options.oObj !== undefined ? options.oObj.css("width") : 0;
		var sMessage = options.sMessage !== undefined ? $.trim(options.sMessage) : "<i class=\"fa fa-cog fa-spin fa-4x fa-fw \"></i><h2 class=\"\">Uploading File, please be patient...</h2>";		
		if(oBlurEffect)
			$("#divWrapper").css({"-webkit-filter": "blur("+oBlurSize+")", "filter": "blur("+oBlurSize+")"});
		$("div[id^='divCustomModal']").remove();		
		var x = $("<div id=\"divCustomModal"+ $.gf_generate_unique_id({"oLength": 10}) +"\" class=\"modal-static\" style=\"display: none;\"><div class=\"modal-static-content\" id=\"divCustommodalContent"+ $.gf_generate_unique_id({"oLength": 10}) +"\">"+sMessage+"</div></div>");
		x.appendTo("body");
		x.fadeIn("fast")
		return x;		
	},
	gf_remove_all_modal: function()
	{
		$("div[id^='divCustomModal']").fadeOut("fast", function()
		{
			$(this).remove();
		});
	},
	gf_spinner: function(options)
	{
		var a = ["<div class=\"spinner\"><div class=\"bounce1\"></div><div class=\"bounce2\"></div><div class=\"bounce3\"></div></div>", 
								 "<div class=\"lds-facebook\"><div></div><div></div><div></div></div>",
								 "<div class=\"lds-ring\"><div></div><div></div><div></div><div></div></div>",
								 "<div class=\"lds-dual-ring\"></div>",
								 "<div class=\"lds-roller\"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>",
								 "<div class=\"lds-ellipsis\"><div></div><div></div><div></div><div></div></div>",
								 "<div class=\"lds-ripple\"><div></div><div></div></div>"];
		return "<center><div><br /><br /><br /><i class=\"fa fa-cog fa-spin fa-4x "+oSpinnerThemesColor+"\"></i><br /></div></center>";
		//return "<center><div><br /><br /><br />"+a[5]+"<br /></div></center>";
	},
	gf_generate_unique_id: function(options)
	{
		var text = "";
	  var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  	for(var i = 0; i < (options.oLength !== undefined ? options.oLength : 5); i++)
	    text += possible.charAt(Math.floor(Math.random() * possible.length));
	  return text;
	},
	gf_check_email: function(options)
	{
		var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
		return pattern.test(options.sEmail);
	},	
	gf_clear_form: function(options)
	{
		options.oForm.find("input[type='text'], input[type='password']").val("");
		options.oForm.find("select").find("option[value='']").attr("selected", "selected");
		options.oForm.find("input[type='checkbox']").attr("checked", "");
		options.oForm.find("input[type='radio']").attr("checked", "");
		options.oForm.find("input:eq(0)").focus();
	},
	gf_init_form: function(options)
	{
		var oForm = options.oForm;
		oForm.find("input[content-mode='numeric']").autoNumeric('init', {mDec: options.oDecimalPointLength !== undefined ? options.oDecimalPointLength : '0'}); 
	},
	gf_clean_string(options)
	{
		var s = options.sString;
		s.replace(/'/gi, "\\'");
		s.replace(/' '/gi,"");
		s.replace(/\\/gi, '&#92;');
		return s;
	},
	gf_valid_form: function(options)
	{
		var oReturn = true;
		var oForm = options.oForm;
		var oDivAlertId = $.gf_generate_unique_id({});
		$("div[id^='divAlert']").remove();
		//--------------------------------------------
		oForm.find("input[type='text']:visible:not(:disabled), textarea:visible:not(:disabled)").each(function() 
		{ 			
			var s = $(this).val();
			s = s.replace(/'/gi, "''");
			s = s.replace(/' '/gi,"");
			s = s.replace(/\\/gi, '&#92;')
			
			$(this).val(s);
		}); 
		oForm.find("input[content-mode='numeric']").each(function() 
		{ 
			var s = $(this).val();
			s = s.replace(/,/g,"");
			s = s.replace(/' '/g,"");
			$(this).val(s); 
		}); 
		//--------------------------------------------		
		$.each(oForm.find("div[custom-control^='div_CustomSelect_'][allow-empty='false']"), function(i, n)
		{
			if(!$(this).parent().hasClass("hidden") && $(this).find("button:eq(0)").text() === "--Pilih--")
			{	
				var d = $("<div id=\"divAlert"+oDivAlertId+"\" style=\"display: none; "+(options.oAddMarginLR !== undefined && options.oAddMarginLR ? "margin-left: 15px; margin-right: 15px;" : "")+"\" class=\"alert "+oBGAlert+" alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" type=\"button\"><i class=\"fa fa-close \"></i></button><p><b>"+ $(this).attr("placeholder") +"</b> can't Empty...</p></div>");
	  		d.insertBefore(options.oObjDivAlert);	
	  		d.slideDown("fast", function()
    		{
    		  $("#divAlert"+oDivAlertId).find("button[class='close']").unbind("click").on("click", function()
    		  {
    		    $("#divAlert"+oDivAlertId).slideUp("fast", function()
    		    {
    		      $(this).remove();
    		    });
    		  });
    		});		
				oReturn = false;	
	  		return false;
			}
		});
		//--------------------------------------------		
		if(oReturn)
		{
			$.each(oForm.find("div[custom-control^='div_CustomList_'][allow-empty='false']"), function(i, n)
			{
				if(!$(this).parent().hasClass("hidden") && $.trim($(this).find("input[type='hidden']").val()) === "")
				{	
					var d = $("<div id=\"divAlert"+oDivAlertId+"\" style=\"display: none; "+(options.oAddMarginLR !== undefined && options.oAddMarginLR ? "margin-left: 15px; margin-right: 15px;" : "")+"\" class=\"alert "+oBGAlert+" alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" type=\"button\"><i class=\"fa fa-close \"></i></button><p><b>"+ $(this).attr("placeholder") +"</b> can't Empty...</p></div>");
		  		d.insertBefore(options.oObjDivAlert);	
		  		d.slideDown("fast", function()
      		{
      		  $("#divAlert"+oDivAlertId).find("button[class='close']").unbind("click").on("click", function()
      		  {
      		    $("#divAlert"+oDivAlertId).slideUp("fast", function()
      		    {
      		      $(this).remove();
      		    });
      		  });
      		});		
					oReturn = false;	
		  		return false;
				}
			});
		}
		//--------------------------------------------		
		if(oReturn)
		{
			$.each(oForm.find("input[allow-empty='false']:visible:not(:disabled), select[allow-empty='false']:visible:not(:disabled), textarea[allow-empty='false']:visible:not(:disabled)"), function(i, n)
			{
	  		if($.trim($(this).val()) === "")
		  	{
		  		var d = $("<div id=\"divAlert"+oDivAlertId+"\" style=\"display: none; "+(options.oAddMarginLR !== undefined && options.oAddMarginLR ? "margin-left: 15px; margin-right: 15px;" : "")+"\" class=\"alert "+oBGAlert+" alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" type=\"button\"><i class=\"fa fa-close \"></i></button><p><b>"+ $(this).attr("placeholder") +"</b> can't Empty...</p></div>");
		  		d.insertBefore(options.oObjDivAlert);	
		  		d.slideDown("fast", function()
      		{
      		  $("#divAlert"+oDivAlertId).find("button[class='close']").unbind("click").on("click", function()
      		  {
      		    $("#divAlert"+oDivAlertId).slideUp("fast", function()
      		    {
      		      $(this).remove();
      		    });
      		  });
      		});		
		  		  		
		  		$(this).effect("highlight", { times:10 }, 500, function()
					{
						$(this).css("border", "solid 1px #DD4B39");
					}).on("blur", function()
					{
						$(this).css("border", "solid 1px #d2d6de");	
					}).on("focus", function()
					{
						$(this).css("border", "solid 1px #3C8DBC");
					}).focus();
		  		oReturn = false;	
		  		return false;
		  	}	  
		  	else if($(this).attr("content-mode") === "numeric")
		  	{
		  		if(!$.isNumeric($(this).val()))
		  		{
		  			var d = $("<div id=\"divAlert"+oDivAlertId+"\" style=\"display: none; "+(options.oAddMarginLR !== undefined && options.oAddMarginLR ? "margin-left: 15px; margin-right: 15px;" : "")+"\" class=\"alert "+oBGAlert+" alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>"+ $(this).attr("placeholder") +" must be numeric...</p></div>");
		  			d.insertBefore(options.oObjDivAlert);	
		  			d.slideDown("fast", function()
        		{
        		  $("#divAlert"+oDivAlertId).find("button[class='close']").unbind("click").on("click", function()
        		  {
        		    $("#divAlert"+oDivAlertId).slideUp("fast", function()
        		    {
        		      $(this).remove();
        		    });
        		  });
        		});				  	
		  		
			  		$(this).effect("highlight", { times:10 }, 500, function()
						{
							$(this).css("border", "solid 1px #DD4B39");
						}).on("blur", function()
						{
							$(this).css("border", "solid 1px #d2d6de");	
						}).on("focus", function()
						{
							$(this).css("border", "solid 1px #3C8DBC");
						}).focus();
			  		oReturn = false;	
			  		return false;
		  		}
		  	}	
		  	else if($(this).attr("content-mode") === "email")
		  	{
		  		if(!$.gf_check_email({"sEmail": $(this).val()}))
		  		{
		  		  var d = $("<div id=\"divAlert"+oDivAlertId+"\" style=\"display: none; "+(options.oAddMarginLR !== undefined && options.oAddMarginLR ? "margin-left: 15px; margin-right: 15px;" : "")+"\" class=\"alert "+oBGAlert+" alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>"+ $(this).attr("placeholder") +" invalid email format...</p></div>");
		  			d.insertBefore(options.oObjDivAlert);	
		  			d.slideDown("fast", function()
        		{
        		  $("#divAlert"+oDivAlertId).find("button[class='close']").unbind("click").on("click", function()
        		  {
        		    $("#divAlert"+oDivAlertId).slideUp("fast", function()
        		    {
        		      $(this).remove();
        		    });
        		  });
        		});				  	
        		
			  		$(this).effect("highlight", { times:10 }, 500, function()
						{
							$(this).css("border", "solid 1px #DD4B39");
						}).on("blur", function()
						{
							$(this).css("border", "solid 1px #d2d6de");	
						}).on("focus", function()
						{
							$(this).css("border", "solid 1px #3C8DBC");
						}).focus();
			  		oReturn = false;	
			  		return false;
		  		}
		  	}	
		  });
		}
		return {"oReturnValue": oReturn, "oObjDivAlert": oDivAlertId};
	},
	gf_custom_notif(options)
	{
		var oAlertMode = options.oAlertMode === undefined ? oBGAlert : "alert-" + options.oAlertMode;
		var oDivAlertId = $.gf_generate_unique_id({});
		$("div[id^='divAlert']").remove();
		var d = $("<div id=\"divAlert"+oDivAlertId+"\" style=\"display: none; "+(options.oAddMarginLR !== undefined && options.oAddMarginLR ? "margin-left: 15px; margin-right: 15px;" : "")+"\" class=\"alert "+oAlertMode+" alert-dismissible\"><button class=\"close\" aria-hidden=\"true\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>"+options.sMessage+"</p></div>");
		d.insertBefore(options.oObjDivAlert);	  	
		d.slideDown("fast", function()
		{
		  $("#divAlert"+oDivAlertId).find("button[class='close']").unbind("click").on("click", function()
		  {
		    $("#divAlert"+oDivAlertId).slideUp("fast", function()
		    {
		      $(this).remove();
		    });
		  });
			//$(document).scrollTo(oObjDivAlert, 800, {easing:'elasout'});
		});		
	},
	gf_custom_notif_floating(options)
	{
		var oAlertMode = options.oAlertMode === undefined ? oBGAlert : "alert-" + options.oAlertMode;
		var oDivAlertId = $.gf_generate_unique_id({});
		$("div[id^='divAlert']").remove();
		var d = $("<div id=\"divAlert"+oDivAlertId+"\" style=\"position: absolute; z-index=\"999999\" height: 100px; background-color: #000; top: "+$("body").scrollTop() + "px; display: none; width: 100%;\" class=\"alert "+oAlertMode+" alert-dismissible\"><button class=\"close\" data-dismiss=\"alert\" type=\"button\"><i class=\"fa fa-close \"></i></button><p>"+options.sMessage+"</p></div>");
		$("body").append(d);	  	
		d.slideDown("fast", function()
		{
		  $("#divAlert"+oDivAlertId).find("button[class='close']").unbind("click").on("click", function()
		  {
		    $("#divAlert"+oDivAlertId).slideUp("fast", function()
		    {
		      $(this).remove();
		    });
		  });
		});				
	},
	gf_convert_select_to_dropdown: function(options)
	{
		var u = Array();
		$.each(options.oObjSelectArray, function(i, n)
		{
			var oSelectObj = this.oObj;
			var oCallback = this.callback;
			var oTheme = this.oTheme === undefined ? "default" : this.oTheme;
			oSelectObj.addClass("hidden");
			var ul = $("<br /><div placeholder=\""+this.oObj.attr("placeholder")+"\" custom-control=\"div_CustomSelect_"+oSelectObj.attr("id")+"\" allow-empty=\""+(this.oObj.attr("allow-empty") === undefined ? "" : this.oObj.attr("allow-empty"))+"\" id=\"div_"+oSelectObj.attr("id")+"\" class=\"btn-group\"><button class=\"btn btn-"+oTheme+"\" type=\"button\" >Priority</button><button type=\"button\" class=\"btn btn-"+oTheme+" dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\"><span class=\"caret\"></span><span class=\"sr-only\">Toggle Dropdown</span></button><ul class=\"dropdown-menu scrollable-menu\"></ul></div><br />");
			oSelectObj.find("option").each(function() 
			{
				var oObjOption = $(this);
				var sAttr = "";
				$(this).each(function() 
				{
			  	$.each(this.attributes, function() 
				  {
				    if(this.specified) 
				    {
				    	if($.trim(this.name) === "selected" && $.trim(oObjOption.val()) !== "")
								sAttr += " selected=\"true\" ";
							else
								sAttr += " selected=\"\" ";
				    	sAttr += " " + $.trim(this.name)+"=\""+$.trim(this.value)+"\" ";
				    }
				  });
				});		
		    $('<li/>').val(this.value).html("<a title=\"" + $.trim(this.text) + "\" class=\"cursor-pointer\" "+sAttr+">" + $.trim(this.text) + "</a>").appendTo(ul.find("ul"));
		  });
			$("<input type=\"hidden\" name=\""+oSelectObj.attr("id")+"\" id=\""+oSelectObj.attr("id")+"\" value=\"\" />").insertAfter(ul.find("button:eq(0)"));
			oSelectObj.replaceWith(ul);
			ul.find("ul li a").on("click", function()
			{
				$(this).parent().parent().parent().find("button:eq(0)").html($(this).text());	
				ul.find("input[type='hidden']").val($(this).attr("value"));
				if(oCallback !== undefined)
					oCallback({oData: $(this).parent().parent().parent(), oObj: $(this), oValue: $(this).attr("value"), oText: $(this).text()});
			});
			ul.find("button:eq(0)").html(ul.find("ul li:eq(0) a").text());
			//--
			if(options.oEditMode !== undefined && options.oEditMode)
			{
				ul.find("button:eq(0)").html(ul.find("ul").find("li a[selected='true']").html());		
				ul.find("input[type='hidden']").val(ul.find("ul li").find("a[selected='true']").attr("value"));
			}
			u.push(ul);
		});
	},	
	gf_convert_select_to_list_groups: function(options)
	{
		var u = Array();
		var oSelectValue = Array();
		$.each(options.oObjSelectArray, function(i, n)
		{
			var oSelectObj = this.oObj;
			var oCallback = this.callback;
			var oTheme = this.oTheme === undefined ? "default" : this.oTheme;
			oSelectObj.addClass("hidden");
			var ul = $("<div placeholder=\""+this.oObj.attr("placeholder")+"\" custom-control=\"div_CustomList_"+oSelectObj.attr("id")+"\" allow-empty=\""+(this.oObj.attr("allow-empty") === undefined ? "" : this.oObj.attr("allow-empty"))+"\" id=\"div_"+oSelectObj.attr("id")+"\"><ul class=\"list-group\"></ul></div>");
			var s = "";
			oSelectObj.find("option").each(function() 
			{
				if($.trim(this.value) !== "")
				{
					var oObjOption = $(this);
					var sAttr = "";
					$(this).each(function() 
					{
				  	$.each(this.attributes, function() 
					  {
					    if(this.specified) 
					    {
					    	if($.trim(this.name) === "selected" && $.trim(oObjOption.val()) !== "")
									sAttr += " selected=\"true\" ";
								else
									sAttr += " selected=\"\" ";
					    	sAttr += " " + $.trim(this.name)+"=\""+$.trim(this.value)+"\" ";
					    }
					  });
					});		
			    s += "<li class=\"list-group-item\" "+sAttr+">" + this.text + "<a "+sAttr+" class=\"cursor-pointer\"><i id=\"check_"+oSelectObj.attr("id")+"\" name=\"check_"+oSelectObj.attr("id")+"\" class=\"cursor-pointer text-red fa fa-close pull-right\" title=\"Click here to Assign.\"></i></a><!--<br /><small class=\"form-text text-muted\">Count of Handling Project: <b>0</b></small>--></li>";
			  }
		  });
	    ul.find("ul").html(s);
	    ul.find("a").on("click", function()
			{
				var a = $(this);
				var i = a.find("i");				
				var aValue = a.attr("value");
				if(i.hasClass("fa fa-close"))
				{
	    		var oResult = $.gf_find_value_in_array({sValue: $(this).attr("value"), oArray: oSelectValue});
	    		if(oResult === -1)
	    		{
	    			oSelectValue.push(a.attr("value"));
						var uResult = "";
						$.each(oSelectValue, function(i, n)
						{
							uResult += n + ",";
						});
						$("#" + oSelectObj.attr("id")).val("").val(uResult);
	    		}
					i.fadeOut("fast", function()
					{
						$(this).removeClass("fa fa-close text-red").addClass("fa fa-check text-danger").attr("title", "Click here to Un-Assign.").fadeIn("fast");
					});
					if(oCallback !== undefined)
						oCallback({oData: $(this).parent().parent().parent(), oObj: $(this), oValue: $(this).attr("value"), oText: $(this).text()});
				}	
				else
				{
					i.fadeOut("fast", function()
					{
						$(this).removeClass("fa fa-check text-danger").addClass("fa fa-close text-red").attr("title", "Click here to Assign.").fadeIn("fast");
		    		var oResult = $.gf_find_value_in_array({sValue: a.attr("value"), oArray: oSelectValue});
		    		if(oResult !== -1)
		    		{
		    			oSelectValue = $.grep(oSelectValue, function(value) {
							  return value != $.trim(a.attr("value"));
							});
							var uResult = "";
							$.each(oSelectValue, function(i, n)
							{
								uResult += n + ",";
							});
							$("#" + oSelectObj.attr("id")).val("").val(uResult);
		    		}
					});
					if(oCallback !== undefined)
						oCallback({oData: $(this).parent().parent().parent(), oObj: $(this), oValue: $(this).attr("value"), oText: $(this).text()});
				}
			});
			$("<input type=\"hidden\" name=\""+oSelectObj.attr("id")+"\" id=\""+oSelectObj.attr("id")+"\" value=\"\" />").insertAfter(ul.find("ul"));
			oSelectObj.replaceWith(ul);
		});
		if(options.callback)
			options.callback({oObj: u});
	},
	gf_find_value_in_array: function(options)
	{
		return parseInt($.inArray($.trim(options.sValue), options.oArray));
	},
	gf_reset_seq_no_table: function(options)
	{
		var nNo = 1;
		$.each(options.oObjTable.find("tr:gt(0)"), function(i, n)
		{
			var oObj = $(this).find("td:eq(0)");
			oObj.html(nNo).
			css("vertical-align", "middle").
			addClass(options.oAlignText);
			nNo++;
		});
	},
	gf_init_table: function(options)
	{
		var nNo = 1;
		$.each(options.oObjTable.find("tr:gt(0)"), function(i, n)
		{
			$.each($(this).find("td"), function(j, m)
			{
				var oObj = $(this);
				oObj.css("vertical-align", "middle");
				if(j === 0)
					oObj.text(nNo);
			});
			nNo++;
		});
		
		if(options.oAddMoreElem !== undefined)
		{
			options.oAddMoreElem.unbind("click").on("click", function()
			{
				var oTable = options.oObjTable;
				oTable = oTable.find("tr:nth-child(2)").clone().insertAfter(oTable.find("tr:last"));
				$.gf_reset_seq_no_table({oObjTable: options.oObjTable, oAlignText: "text-right"});
				//-- Clear
				$.gf_clear_element_last_row_table({oObjTable: options.oObjTable});
				//-- End Clear
				if(options.oRemoveRowElem !== undefined)
				{
					$("a[id='"+options.oRemoveRowElem.attr("id")+"']").unbind("click").on("click", function()
					{
						var oTable = options.oObjTable;
						if(oTable.find("tr").length > 2)
							$(this).parent().parent().fadeOut("fast", function()
							{
								$(this).remove()
							});
						else 				
							$.gf_clear_element_row_table({oObjTable: oTable});
						$.gf_reset_seq_no_table({oObjTable: oTable, oAlignText: "text-right"});
					});
				}
			});
		}
		
		if(options.oClearAllRowElem !== undefined)
		{
			options.oClearAllRowElem.unbind("click").on("click", function()
			{
				options.oObjTable.find("tr:gt(1)").fadeOut("fast", function()
				{
					$(this).remove();
				});
				$.gf_clear_element_row_table({oObjTable: options.oObjTable});
			});
		}
	},
	gf_clear_element_row_table: function(options)
	{
		options.oObjTable.find("tr:gt(0) td select").prop('selectedIndex', 0);
		options.oObjTable.find("tr:gt(0) td input[type='text']").val("");
		options.oObjTable.find("tr:gt(0) td input[type='hidden']").val("");
	},
	gf_clear_element_last_row_table: function(options)
	{
		$.each(options.oObjTable.find("tr:last").find("td"), function(j, m)
		{
			$(this).find("select").prop('selectedIndex', 0);
			$(this).find("tr:last").find("td").find("input[type='text']").val("");
			$(this).find("tr:last").find("td").find("input[type='hidden']").val("")
		});
	},
	gf_set_middle_text_table: function(options)
	{
		options.oObjTable.find("tr").find("td").css("vertical-align", "middle");
	},
	gf_group_table: function(options)
	{
		if (options.total === 0)
			return;
		var i , currentIndex = options.startIndex, count=1, lst=[];
		var tds = options.rows.find('td:eq('+ currentIndex +')');
		var ctrl = $(tds[0]);
		lst.push(options.rows[0]);
		for (i=1;i<=tds.length;i++)
		{
			if (ctrl.text() ==  $(tds[i]).text())
			{
				count++;
				$(tds[i]).addClass('deleted');
				lst.push(options.rows[i]);
			}
			else
			{
				if (count>1)
				{
					ctrl.attr('rowspan',count);
					$.gf_group_table({rows: $(lst), startIndex: options.startIndex+1, total: options.total-1})
				}
				count=1;
				lst = [];
				ctrl=$(tds[i]);
				lst.push(options.rows[i]);
			}
		}
	},
	gf_blur_container: function(options)
	{
		var oBlurSizer = options.oBlurSize === undefined ? oBlurSize : options.oBlurSize;
		options.oObj.css({"-webkit-filter": "blur("+oBlurSizer+")", "filter": "blur("+oBlurSizer+")"});
		//alert(options.oObj.attr("id"));
	},
	gf_blur_clear(options)
	{
		options.oObj.removeAttr("style");
	},
	gf_date_diff: function(options)
	{
		var d1 = new Date(options.d1);
		var d2 = new Date(options.d2);

		if(options.mode === "d")
		{
		 	var t2 = d2.getTime();
      var t1 = d1.getTime();
      return parseInt((t2-t1)/(24*3600*1000));
		}
		else if(options.mode === "w")
		{
			var t2 = d2.getTime();
      var t1 = d1.getTime();
      return parseInt((t2-t1)/(24*3600*1000*7));
		}
		else if(options.mode === "m")
		{
			var d1Y = d1.getFullYear();
      var d2Y = d2.getFullYear();
      var d1M = d1.getMonth();
      var d2M = d2.getMonth();
      return (d2M+12*d2Y)-(d1M+12*d1Y);
		}
		else if(options.mode === "y")
		{
			return d2.getFullYear()-d1.getFullYear();
		}
	},
	gf_convert_to_unit(options)
	{
		var digit = options.digit;
	  if (digit >= 63) return 'vigintiliun'
		  else if (digit >= 60) return 'novemdesiliun'
		  else if (digit >= 57) return 'oktodesiliun'
		  else if (digit >= 54) return 'septendesiliun'
		  else if (digit >= 51) return 'sexdesiliun'
		  else if (digit >= 48) return 'quindesiliun'
		  else if (digit >= 45) return 'quattuordesiliun'
		  else if (digit >= 42) return 'tredesiliun'
		  else if (digit >= 39) return 'duodesiliun'
		  else if (digit >= 36) return 'undesiliun'
		  else if (digit >= 33) return 'desiliun'
		  else if (digit >= 30) return 'noniliun'
		  else if (digit >= 27) return 'oktiliun'
		  else if (digit >= 24) return 'septiliun'
		  else if (digit >= 21) return 'sextiliun'
		  else if (digit >= 18) return 'quintiliun'
		  else if (digit >= 15) return 'quadriliun'
		  else if (digit >= 12) return 'triliun'
		  else if (digit >= 9) return 'milyar'
		  else if (digit >= 6) return 'juta'
		  else if (digit >= 3) return 'ribu'
		  else return ''
	},
	gf_angka_terbilang(options) 
	{
		var angka = options.angka;

	  let result = ''
	  let printUnit = true
	  let isBelasan = false

	  for (var i = 0; i < angka.length; i++) {
	    var length = angka.length - 1 - i
	    if (length % 3 == 0) {
	      var num = (angka[i] == 1 && (isBelasan || ($.gf_convert_to_unit({digit: length}) == 'ribu' && ((angka[i - 2] == undefined || angka[i - 2] == 0) && (angka[i - 1] == undefined || angka[i - 1] == 0))))) ? 'se' : `${$.gf_number_to_string({index: angka[i]})} `
	      result += ` ${num}`

	      if ((angka[i - 2] && angka[i - 2] != 0) || (angka[i - 1] && angka[i - 1] != 0) || angka[i] != 0) {
	        printUnit = true
	      }
	      if (printUnit) {
	        printUnit = false
	        result += ((isBelasan) ? 'belas ' : '') + $.gf_convert_to_unit({digit: length})
	        if (isBelasan) {
	          isBelasan = false
	        }
	      }
	    } else if (length % 3 == 2 && angka[i] != 0) {
	      result += ` ${(angka[i] == 1) ? 'se' : $.gf_number_to_string({index: angka[i]}) + ' '}ratus`
	    } else if (length % 3 == 1 && angka[i] != 0) {
	      if (angka[i] == 1) {
	        if (angka[i + 1] == 0) {
	          result += ' sepuluh'
	        } else {
	          isBelasan = true
	        }
	      } else {
	        result += ` ${$.gf_number_to_string({index: angka[i]})} puluh`
	      }
	    }
	  }
	  return result.trim().replace(/\s+/g, ' ')
	},
	gf_number_to_string(options)
	{
		var index = options.index;
		var numbers = ['satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
		return numbers[index - 1] || ''
	},
	gf_stimulsoft_license()
	{
		return "6vJhGtLLLz2GNviWmUTrhSqnOItdDwjBylQzQcAOiHl1GcSnK5ohvPCLuwUBD0mb9HQpf7/1mVu+qp2D" +
		"FVi9birzJpPKspbdH5oem7Sa3kKI84aBIn1YKUMDN7PE4nRptvBqpBAmK5Pnbk4tPTJX7vzMneoWkN0X" +
		"GC5o6g1D1makalgaUrK3Jm/8uqbIVGcweAVIbZ8Uwg4MiipduG9+7QrQtVmPmFwpICkuqq/v71ZYlGWZ" +
		"Pfc8rhQIuZEsscYrbAJSY9xnI/m5IoPc794bmTKzV3JDv6mT5LJcgpeQxqu8Dfj1MtdTB8S0V0YPTBYz" +
		"SqZJeFrwx0WoII/2rYCRJa/jmiUWe22f4LtDYgkdVVo0hEfQ+pkguBSneSSyfVgvVa1Gx2nrChi2hzeP" +
		"yrlGAGCITrh8chpdyDbA0WmsTppA3gZ41ngr8uR3rm/QF0PHH4jd7msk5IJ7yr4GdJcRUrkWqzRVzSiZ" +
		"emDtlBLpsV0y6T7LgfBcdwkdMyDynmwr9emQgj3Xn+G4ECbafUUyuvb8aw/dNenmBv3egesqtEX/8PBj" +
		"39u9ksENpX67pgHqy7l0S47OwFJpxp4dMp4RlQ==";
	},
	gf_print_using_stimulsoft(options)
	{
		oDialog = BootstrapDialog.show({
			title: options.sTitleDialog,
			message: "<div id=\"divReport\" class=\"text-center\"><i class=\"fa fa-cog fa-spin fa-4x\"></i></div>",
			type: BootstrapDialog.TYPE_DEFAULT,
			size: BootstrapDialog.SIZE_WIDE,
			onshown: function() {
				var sURL = options.sURL.replace(undefined, ""),
				oDialog = null,
				oForm = $.gf_create_form({action: sURL + "c_core_apps_open_report/gf_execute_query_to_mrt/"}),
				oShowToolbar = options.showToolbar;

				oForm.append("<input type=\"hidden\" id=\"selFieldName\" name=\"selFieldName[]\" value=\""+options.sFieldName+"\" />");
				oForm.append("<input type=\"hidden\" id=\"txtValue\" name=\"txtValue[]\" value=\""+options.sFieldNameValue+"\" />");
				oForm.append("<input type=\"hidden\" id=\"selOperand\" name=\"selOperand[]\" value=\"AND\" />");
				oForm.append("<input type=\"hidden\" id=\"hideType\" name=\"hideType[]\" value=\"3\" />");
				oForm.append("<input type=\"hidden\" id=\"nIdOpenReport\" name=\"nIdOpenReport\" value=\""+options.nIdReport+"\" />");
				oForm.append("<input type=\"hidden\" id=\"selOperator\" name=\"selOperator[]\" value=\"=\" />");
				oForm.append("<input type=\"hidden\" id=\"selReport\" name=\"selReport\" value=\"ReportDesc\" />");
				oForm.append("<input type=\"hidden\" id=\"selFieldLabelName\" name=\"selFieldLabelName[]\" value=\""+options.sFieldNameLabel+"\" />");

				$.gf_custom_ajax({
					"oForm": oForm,
					"success": function(r) {
						var JSON = $.parseJSON(r.oRespond);

						Stimulsoft.Base.StiLicense.key = $.gf_stimulsoft_license();				

						var report 	= Stimulsoft.Report.StiReport.createNewReport();
						var dataset = new Stimulsoft.System.Data.DataSet("data");
						var options = new Stimulsoft.Viewer.StiViewerOptions();

						report.loadFile(sURL+JSON.oReportInfo+"?t="+ new Date());
						dataset.readJson(JSON);
						report.dictionary.databases.clear();
						report.regData(dataset.dataSetName, "data", dataset)
						report.dictionary.synchronize()

						if(oShowToolbar !== undefined && !oShowToolbar)
							options.toolbar.visible = false;

						options.appearance.scrollbarsMode = true;
						if(oShowToolbar === undefined || oShowToolbar)
						{
							options.toolbar.showOpenButton = false;
							options.toolbar.zoom = 100;
							options.toolbar.autoHide = true;
							options.toolbar.showAboutButton = false;	
						}
						
						//-- Direct print when user click Print toolbar button
						options.toolbar.printDestination = Stimulsoft.Viewer.StiPrintDestination.Direct;

						var viewer = new Stimulsoft.Viewer.StiViewer(options, "StiViewer", false);
						viewer.report = report;
						viewer.renderHtml("divReport");
					},
					"validate": true,
					"beforeSend": function(r) {
					},
					"beforeSendType": "custom",
					"error": function(r) {}
				});
			}
		});
	},
	gf_loading_show: function(options)
	{
		var o = (options !== undefined ? options.sMessage : "Please wait...");
		var top = (parseInt($(window).height()) / 2);
		if($("div[id='divL']").length === 0)
			$("body").append("<div id=\"divL\" style=\"border-radius: 10px 10px 10px 10px; position: absolute; top: "+top+"px; left: 50%; transform: translate(-50%, -50%); text-align :center; z-index: 9999999; display: block; padding: 20px; border: solid 0px #222; background-color: #555; color: #ddd;\"><i class=\"fa fa-cog fa-spin fa-3x\"></i><br />"+o+"</div>");
		else
			$("div[id='divL']").html("<i class=\"fa fa-cog fa-spin fa-3x\"></i><br />"+o);
	},
	gf_loading_hide: function(options)
	{
		$("div[id='divL']").fadeOut("fast", function() {
			$(this).remove();
		});
	},
	gf_add_param_to_form(options)
	{
		for(i=0; i<options.params.length; i++)
			options.form.append("<input type=\"hidden\" name=\"params[]\" id=\"params[]\" value=\""+options.params[i]+"\" />");
	},
	gf_count_down(options)
	{
		var dt = options.dt,
				id = options.id,
				end = new Date(dt),
				_second = 1000,
				_minute = _second * 60,
				_hour = _minute * 60,
				_day = _hour * 24,
				timer;

		function showRemaining() {
				var now = new Date();
				var distance = end - now;
				if (distance < 0) {
					clearInterval(timer);
					options.oObj.html("EXPIRED!");
					return;
				}
				var days = Math.floor(distance / _day);
				var hours = Math.floor((distance % _day) / _hour);
				var minutes = Math.floor((distance % _hour) / _minute);
				var seconds = Math.floor((distance % _minute) / _second);

				options.oObj.html(days + "d " + hours + "h " + minutes + "m " + seconds + "s");
		}
		timer = setInterval(showRemaining, 1000);
	},
	gf_is_scroll_into_view(options)
	{
		console.log(options.oObj);
		var docViewTop = $(window).scrollTop();
    var docViewBottom = docViewTop + $(window).height();
    var elemTop = options.oObj.offset().top;
    var elemBottom = elemTop + options.oObj.height();
    return ((elemBottom <= docViewBottom) && (elemTop >= docViewTop));
	},
	gf_nl2br(options)
	{
		if (typeof options.str === 'undefined' || options.str === null) 
			return '';
		var breakTag = (options.is_xhtml || typeof options.is_xhtml === 'undefined') ? '<br />' : '<br>';
		return (options.str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	},
	gf_remove_all_tags_in_string(options)
	{
    return options.str.replace(/(<([^>]+)>)/ig,"");
	},
	gf_base64_encode(options) 
	{
		return window.btoa(encodeURIComponent(options.str));
	},
	gf_base64_decode(options) 
	{
		return decodeURIComponent(window.atob(options.str));
	},
	gf_format_bytes(options) {
    if (options.bytes === 0) return '0 Bytes';
    const k = 1024;
    const dm = options.decimals < 0 ? 0 : options.decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    const i = Math.floor(Math.log(options.bytes) / Math.log(k));
    return parseFloat((options.bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
	},
	gf_snack_bar(options) {
		if($("div[class='snackbar']").length === 0)
			$("body").append("<div class=\"snackbar\"></div>");
		var x = $("div[class='snackbar']");
		x.html((options.message === undefined ? "Empty Message !" : options.message)).addClass("slideUp");
		var timer;
    if(options.duration !== undefined){
			timer = setInterval(function(){
				clearInterval(timer);
				x.addClass("slideDown");
			}, options.duration);	
		}
	},
	gf_animate_number(options) {
		let startTimestamp = null;
		const step = (timestamp) => {
			if (!startTimestamp) startTimestamp = timestamp;
			const progress = Math.min((timestamp - startTimestamp) / options.duration, 1);
			options.obj.innerHTML = Math.floor(progress * (options.end - options.start) + options.start);
			if (progress < 1) {
				window.requestAnimationFrame(step);
			}
		};
		window.requestAnimationFrame(step);
	},
});

$(function()
{
	$('textarea').each(function()
	{
		autosize(this);
	});
	$("table tr td").css("vertical-align", "middle");
	$("table").find("tr:gt(0)").find("td:eq(0)").css("text-align", "right");
});
