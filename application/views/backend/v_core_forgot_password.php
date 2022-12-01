<?php
$a = rand(1, 9);
$b = rand(1, 9);
$info = json_decode($o_info, TRUE);
?>
<form id="form-login" action="" method="post">
	<div class="login-box">
		<div class="login-box-body login-bg-form" id="div-login-wrap">
			<?php
			if (count($info) > 0) {
			?>
				<h3 id="h3-title">
					<p id="pLoginTitle" class="login-box-msg">Enter new Password</p>
				</h3>
				<p>Hey, <span class="text-red"><b><?php print $info['sRealName']; ?></b></span> please type a new password for your access into Application.</p>
				<div id="div-login" class="">
					<div class="form-group has-feedback" id="div-top">
						<input allow-empty="false" id="txtPassword" name="txtPassword" type="password" class="form-control" placeholder="New Password">
						<span class="fa fa-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback" id="divPasswordAgain">
						<input allow-empty="false" id="txtPasswordAgain" name="txtPasswordAgain" type="password" class="form-control" placeholder="New Password Again">
						<span class="fa fa-lock form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback" id="divSecCode">
						<input allow-empty="false" id="txtSecCodeLogin" name="txtSecCodeLogin" type="text" class="form-control" a="<?php print $a; ?>" b="<?php print $b; ?>" placeholder="<?php print "Plase Sum: " . $a; ?> + <?php print $b; ?> ?">
						<span class="fa  fa-expeditedssl form-control-feedback"></span>
					</div>
				</div>
				<div class="form-group has-feedback">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 from-group">
						<div class="row">
							<button id="button-submit" type="button" class="btn btn-primary btn-block btn-flat btn-md"><span class="fa fa-sign-in"></span>&nbsp;Reset My Password</button>
						</div>
						<div class="margin-bottom"></div>
					</div>
				</div>
				<input type="hidden" name="sSession" id="sSession" value="<?php print trim($info['sSessionForgotPassword']); ?>" />
			<?php
			} else {
			?>
				<div>
					<p class="text-red" id="pLoginTitle" class="login-box-msg">
					<h3 id="h3-title" class="text-center"><i class="fa fa-frown-o fa-4x"></i><br />Ooopss..., Sorry...</h3>You don't have permission to reset password anyone. If you want to reset your own password, please go to Login page and then click Forgot Password link.</p>
					<a href="<?php print site_url(); ?>" class="btn btn-danger btn-md btn-block">Return to Home</a>
				</div>
				<div class="margin-bottom"></div>
			<?php
			}
			?>
			<div id="div-link">
				<small>
					<p class="login-box-msg"><?php print html_entity_decode($o_config['APPS_COPYRIGHT']); ?></p>
				</small>
			</div </div>
		</div>
</form>
<script>
	var x;
	$(function() {
		$(".wrapper, body").css({
			background: "#ECF0F5"
		});
		$("#txtPassword, #txtPasswordAgain, #txtSecCodeLogin").keypress(function(e) {
			if (e.keyCode === 13)
				gf_submit();
		});
		gf_submit_x();
		$("#txtPassword").focus();
		x = gf_captcha();
		$("#txtSecCodeLogin").attr("a", x.a);
		$("#txtSecCodeLogin").attr("b", x.b);
		$("#txtSecCodeLogin").attr("placeholder", "Please Sum: " + x.a + " + " + x.b + " ?");

		$("#txtPassword").select();

	});

	function gf_submit_x() {
		$("#button-submit").unbind("click").click(function() {
			$("div[id='div-alert']").remove();
			gf_submit();
		});
	}

	function gf_submit() {
		var bNext = true;
		if ($.trim($("button#button-submit").text()) === "Reset My Password") {
			$.each($("input[allow-empty='false']"), function(i, n) {
				if ($.trim($(this).val()) === "") {
					$.gf_remove_all_modal();
					$.gf_custom_notif({
						"sMessage": $(this).attr("placeholder") + " can't Empty...",
						"oObjDivAlert": $("#div-top")
					});
					$(this).focus();
					bNext = false;
					return false;
				}
			});
			if (bNext) {
				if ($.trim($("#txtPasswordAgain").val()) !== $.trim($("#txtPassword").val())) {
					$.gf_remove_all_modal();
					$.gf_custom_notif({
						"sMessage": "Password doesn't match. Please type Password Correctly.",
						"oObjDivAlert": $("#div-top")
					});
					bNext = false;
					return false;
				}
			}
			if (bNext) {
				if ((parseInt($("#txtSecCodeLogin").attr("a")) + parseInt($("#txtSecCodeLogin").attr("b"))) !== parseInt($("#txtSecCodeLogin").val())) {
					$.gf_remove_all_modal();
					$.gf_custom_notif({
						"sMessage": "Invalid Security Code...",
						"oObjDivAlert": $("#div-top")
					});
					bNext = false;
					return false;
				}
			}
			if (!bNext)
				return false;
			var oForm = $("#form-login");
			oForm.attr("action", "<?php print site_url(); ?>c_core_forgot_password/gf_reset_password");
			$.gf_custom_ajax({
				"oForm": oForm,
				"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					if (JSON.status === 1) {
						$.gf_remove_all_modal();
						$("#div-login-wrap").empty().html("<h3 id=\"h3-title\"><p id=\"pLoginTitle\" class=\"login-box-msg\">Congratulation...</p></h3><p>Hey, <span class=\"text-red\"><?php print $info['sRealName']; ?></span> " + JSON.message + ".</p>Click <a class=\"text-red\" href=\"<?php print site_url(); ?>\">here</a> to go to main page Application.").insertBefore($("#div-top"));
					} else {
						$("#button-submit").removeClass("disabled").find("span").removeClass("fa fa-cog fa-spin fa-1x").addClass("fa fa-sign-in");
						$.gf_custom_notif({
							"sMessage": "Invalid Login...",
							"oObjDivAlert": $("#div-top")
						});
					}
				},
				"validate": true,
				"beforeSend": function(r) {
					$("#button-submit").addClass("disabled").find("span").removeClass("fa fa-sign-in").addClass("fa fa-cog fa-spin fa-1x");
					var x = $.gf_custom_modal({
						"sMessage": "<div class=\"spinner\"><div class=\"rect1\"></div><div class=\"rect2\"></div><div class=\"rect3\"></div><div class=\"rect4\"></div><div class=\"rect5\"></div></div>"
					});
				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
			//------------------------------------------  
		}
	}

	function gf_captcha() {
		var x = Math.floor((Math.random() * 100) + 1);;
		var y = Math.floor((Math.random() * 100) + 1);;
		return ({
			"a": x,
			"b": y
		});
	}
</script>