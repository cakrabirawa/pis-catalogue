<?php
$oConfig = $o_extra['o_config'];
$sLoginButtonThemes = "default";
$sALinkRefreshCaptchaThemes = "text-black";
?>
<form id="form-login" action="<?php print site_url(); ?>c_core_login/gf_check_login" method="post">
	<div class="login-box">
		<div class="login-box-body login-bg-form">
			<center><img src="<?php print site_url(); ?>img/ap.png" class="img-responsve" style="width: 90px;" /></center>
			<h3 id="h3-title">
				<p id="pLoginTitle" class="login-box-msg"><?php print $oConfig['APPS_NAME']; ?></p>
			</h3>
			<div id="div-login" class="">
				<div class="form-group has-feedback" id="div-top">
					<input allow-empty="false" id="txtUserNameLogin" name="txtUserNameLogin" type="text" class="form-control" placeholder="Email">
					<span class="fa fa-envelope form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback" id="divPassword">
					<input allow-empty="false" id="txtPassword" name="txtPassword" type="password" class="form-control" placeholder="Password">
					<span class="fa fa-lock form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback" id="divSecCode1">
					<input allow-empty="false" id="txtSecCodeLogin1" name="txtSecCodeLogin1" type="text" class="form-control" placeholder="Security Login">
					<span class="fa fa-expeditedssl form-control-feedback"></span>
				</div>
				<div class="form-group has-feedback" id="divSecCode2">
					<center><img id="imgSecurity" src="<?php print site_url(); ?>c_core_captcha/gf_generate_captcha/" /></center>
				</div>
				<div class="form-group has-feedback">
					<a id="aRefreshSecurtyImage" class="cursor-pointer <?php print $sALinkRefreshCaptchaThemes; ?>" title="Refresh Security Image">Refresh Security Image</a>
				</div>
			</div>
			<div class="form-group has-feedback">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 from-group">
					<div class="row">
						<button id="button-submit" type="button" class="btn btn-<?php print $sLoginButtonThemes; ?> btn-block btn-lg"><span class="fa fa-sign-in"></span> Sign In</button>
					</div>
					<div class="margin-bottom"></div>
				</div>
				<!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 from-group">
    			<div class="row">
		        <a id="aForgotPassword" href="#" type="button" class="text-center text-red" title="Click here to Reset you Password"><span class="fa fa-clock-o"></span> Forgot Password</a> Not yet have account ? click<a id="aRegister" href="#" type="button" class="text-center text-red" title="Click here to Register"> here</a> to Register.
		      </div>
	        <div class="margin-bottom"></div>
        </div>-->
			</div>
			<div id="div-link">
				<small>
					<p class="login-box-msg"><?php print html_entity_decode($oConfig['APPS_COPYRIGHT']); ?></p>
				</small>
			</div>
		</div>
	</div>
</form>
<script>
	var x;
	$(function() {
		$(".wrapper, body").css({
			backgroundColor: "rgb(236, 240, 245)"
		});
		$("input[type='text'], input[type='password']").keypress(function(e) {
			if (e.keyCode === 13)
				gf_submit();
		});
		$("#aForgotPassword").unbind("click").on("click", function() {
			$.gf_clear_form({
				"oForm": $("#form-login")
			});
			if ($.trim($(this).text()) === "Forgot Password") {
				$("p#pLoginTitle").html("<b><?php print $oConfig['APPS_NAME']; ?></b> Forgot Password");
				$("#divPassword").slideUp(500, "easeInElastic", function() {
					$("#txtUserNameLogin").focus();
					$("#aForgotPassword").html("<span class=\"fa fa-clock-o\"></span> Login");
					$("button#button-submit").html("<span class=\"fa fa-sign-in\"></span> Send Request New Password");
				});
			} else {
				$(this).html("Login");
				$("p#pLoginTitle").html("<b><?php print $oConfig['APPS_NAME']; ?></b> Login");
				$("#divPassword").slideDown(500, "easeOutElastic", function() {
					$("#divRealName").remove();
					$("#txtUserNameLogin").focus();
					$("#aForgotPassword").html("<span class=\"fa fa-clock-o\"></span> Forgot Password");
					$("button#button-submit").html("<span class=\"fa fa-sign-in\"></span> Sign In");
				});
			}
		});
		$("#aRegister").unbind("click").on("click", function() {
			$.gf_clear_form({
				"oForm": $("#form-login")
			});
			$("#divRealName").slideUp(500, "easeInElastic", function() {
				$(this).remove();
			});
			$("p#pLoginTitle").html("<b><?php print $oConfig['APPS_NAME']; ?></b> Register");
			var x = "<div class=\"form-group has-feedback\" id=\"divRealName\">";
			x += "<input allow-empty=\"false\" id=\"txtRealName\" name=\"txtRealName\" type=\"text\" class=\"form-control\" placeholder=\"Full Name\">";
			x += "<span class=\"fa fa-edit form-control-feedback\"></span>";
			x += "</div>";
			$(x).insertAfter($("#div-top"));
			$("button#button-submit").html("<span class=\"fa fa-sign-in\"></span> Register Now!");
			$("#txtUserNameLogin").focus();
			$("#aForgotPassword").html("<span class=\"fa fa-clock-o\"></span> Login");
		});
		$("#aRefreshSecurtyImage").unbind("click").on("click", function(e) {
			$("#imgSecurity").attr("src", "<?php print site_url(); ?>c_core_captcha/gf_generate_captcha/" + new Date().getTime());
			$("#txtSecCodeLogin1").select().focus();

		});
		gf_submit_x();
		$("#txtUserNameLogin").focus();
	});

	function gf_submit_x() {
		$("#button-submit").unbind("click").click(function() {
			$("div[id='divAlert']").remove();
			gf_submit();
		});
	}

	function gf_submit() {
		var oForm = $("#form-login");
		var bNext = true;
		if ($.trim($("button#button-submit").text()) === "Sign In") {
			var oRet = $.gf_valid_form({
				"oForm": oForm,
				"oObjDivAlert": $("#div-top")
			});
			bNext = oRet.oReturnValue;
			if (!bNext)
				return false;
			oForm.attr("action", "<?php print site_url(); ?>c_core_login/gf_check_login");
			$.gf_custom_ajax({
				"oForm": oForm,
				"success": function(r) {
					$.gf_remove_all_modal();
					$.gf_blur_clear({
						oObj: $(".login-box")
					});
					var JSON = $.parseJSON(r.oRespond);
					const urlParams = new URLSearchParams(window.location.search);
					const urlNext = $.trim(urlParams.get('next'));
					window.next = urlNext;
					if (JSON.status === 1) {
						history.pushState(null, "", "<?php print site_url(); ?>");
						$.ajax({
							url: "<?php print site_url(); ?>?next=" + urlNext,
							beforeSend: function(xhr) {
								$("body").css("display", "none").html("<div style=\"position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align :center;\"><i class=\"fa fa-cog fa-spin fa-4x\"></i><br />Please wait, Loading Application into your Memory...</div>").fadeIn("fast");
							}
						}).done(function(data) {
							//$("body").empty().html(data).css("display", "none").fadeIn("fast");
							window.location.href = ".";
						});
					} else {
						$("#button-submit").removeClass("disabled").find("span").removeClass("fa fa-cog fa-spin fa-1x").addClass("fa fa-sign-in");
						$.gf_custom_notif({
							"sMessage": JSON.message,
							"oObjDivAlert": $("#div-top")
						});
						$("#txtUserNameLogin").focus();
					}
				},
				"validate": true,
				"beforeSend": function(r) {
					$("#button-submit").addClass("disabled").find("span").removeClass("fa fa-sign-in").addClass("fa fa-cog fa-spin fa-1x");
					$.gf_blur_container({
						oObj: $(".login-box")
					});
				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
			//------------------------------------------  
		} else if ($.trim($("button#button-submit").text()) === "Send Request New Password") {
			var oRet = $.gf_valid_form({
				"oForm": oForm,
				"oObjDivAlert": $("#div-top")
			});
			bNext = oRet.oReturnValue;
			if (!bNext)
				return false;
			oForm.attr("action", "<?php print site_url(); ?>c_core_login/gf_forgot_password");
			$.gf_custom_ajax({
				"oForm": oForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					$.gf_remove_all_modal();
					if (JSON.status === 1) {
						$("#button-submit").removeClass("disabled").find("span").removeClass("fa fa-cog fa-spin fa-1x").addClass("fa fa-sign-in");
						$.gf_custom_notif({
							"sMessage": JSON.message,
							"oObjDivAlert": $("#div-top")
						});
						$("#aForgotPassword").trigger("click");
						$("#txtUserNameLogin").val("");
						$("#txtPassword").val("");
					} else {
						$("#button-submit").removeClass("disabled").find("span").removeClass("fa fa-cog fa-spin fa-1x").addClass("fa fa-sign-in");
						$.gf_custom_notif({
							"sMessage": JSON.message,
							"oObjDivAlert": $("#div-top")
						});
					}
					$("#txtUserNameLogin").focus();
				},
				"validate": true,
				"beforeSend": function(r) {
					$("#button-submit").addClass("disabled").find("span").removeClass("fa fa-sign-in").addClass("fa fa-cog fa-spin fa-1x");
				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
			//------------------------------------------   
		} else if ($.trim($("button#button-submit").text()) === "Register Now!") {
			var oRet = $.gf_valid_form({
				"oForm": oForm,
				"oObjDivAlert": $("#div-top")
			});
			bNext = oRet.oReturnValue;
			if (!bNext)
				return false;
			oForm.attr("action", "<?php print site_url(); ?>c_core_login/gf_register");
			$.gf_custom_ajax({
				"oForm": oForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					$.gf_remove_all_modal();
					if (JSON.status === 1) {
						$("#divRealName").remove();
						$("#button-submit").removeClass("disabled").find("span").removeClass("fa fa-cog fa-spin fa-1x").addClass("fa fa-sign-in");
						$.gf_custom_notif({
							"sMessage": JSON.message,
							"oObjDivAlert": $("#div-top")
						});
						$("#txtUserNameLogin").val("");
						$("#txtPassword").val("");
						$("#txtSecCodeLogin").val("");
						$("#txtSecCodeLogin1").val("");
						$("button#button-submit").html("<span class=\"fa fa-sign-in\"></span> Sign In");
						$("p#pLoginTitle").html("<b><?php print $oConfig['APPS_NAME']; ?></b> Login");
						$("#aRefreshSecurtyImage").trigger("click");
					} else {
						$("#button-submit").removeClass("disabled").find("span").removeClass("fa fa-cog fa-spin fa-1x").addClass("fa fa-sign-in");
						$.gf_custom_notif({
							"sMessage": JSON.message,
							"oObjDivAlert": $("#div-top")
						});
					}
					$("#txtUserNameLogin").focus();
				},
				"validate": true,
				"beforeSend": function(r) {
					var x = $.gf_custom_modal({
						"sMessage": $.gf_spinner()
					});
					$("#button-submit").addClass("disabled").find("span").removeClass("fa fa-sign-in").addClass("fa fa-cog fa-spin fa-1x");
				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
			//------------------------------------------   
		}
	}
</script>