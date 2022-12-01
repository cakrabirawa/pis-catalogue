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
$o_info = json_decode($o_extra['o_info'], TRUE);
?>
<div class="row">
	<form id="form_5938b5bb933d2" role="form" action="<?php print site_url(); ?>c_core_edit_profile/gf_transact" method="post">
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3" id="divTop">
			<div class="panel panel-default bootcards-file">
				<div class="panel-heading">
					<h4 class="panel-title"><i class="fa fa-pencil"></i> Edit Profile</h4>
				</div>
				<div class="box-body box-profile">
					<div class="box-body no-padding">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group " id="div-top">
								<div style="width: 100%; text-align: center;">
									<div id="dropZone">
										<a class="cursor-pointer" title="Click here to Change Profile Picture" id="aUploadImage"><center><img onerror="this.onerro=null;this.src='<?php print site_url(); ?>img/img-user.png';" src="<?php print site_url(); ?><?php print trim($o_info['sInfo']['sAvatar']) === "" ? "img/img-user.png" : 	"c_core_user_login/gf_load_image/" . str_replace(" ", "%20", trim($o_info['sInfo']['sAvatar'])); ?>" id="imgAvatarEditProfile" class="img-responsive img-rounded text-center" style="max-width: <?php print $o_extra['o_config']['PROFILE_PICTURE_AVATAR_SIZE_PX']; ?>px;"/></center></a>
									</div>
								</div>
							</div>
							<div class="row"></div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-1 form-group hidden">
								<div id="progress" class="form-group">
									<div class="progress progress-sm active">
										<div class="progress-bar progress-bar-success progress-bar-striped"></div>
									</div>
									<div id="div-text-progress-file-name">
										10 %
									</div>
									<div id="div-text-progress-percentage">
										10 %
									</div>
								</div>
							</div>
							<div class="row"></div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
								<label>User Name</label>
								<input allow-empty="false" value="<?php print $o_info['sInfo']['sUserName']; ?>" type="text" placeholder="User Name" name="txtUserName" id="txtUserName" class="form-control" maxlength="100" <?php print trim($o_info['sInfo']['sUserName']) === "" ? "" : "disabled" ?>>
								<input type="hidden" name="txtUserNameOld" id="txtUserNameOld" value="<?php print $o_info['sInfo']['sUserName']; ?>" />
								<?php
								if (trim($o_info['sInfo']['sUserName']) !== "")
									print "<input type=\"hidden\" name=\"txtUserName\" id=\"txtUserName\" value=\"" . trim($o_info['sInfo']['sUserName']) . "\" />";
								?>
							</div>
							<div class="row"></div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
								<label>Real Name</label>
								<input allow-empty="false" value="<?php print $o_info['sInfo']['sRealName']; ?>" type="text" placeholder="User Real Name" name="txtUserRealName" id="txtUserRealName" class="form-control" maxlength="200">
							</div>
							<div class="row"></div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
								<label>Email</label>
								<input allow-empty="false" value="<?php print $o_info['sInfo']['sEmail']; ?>" type="text" placeholder="Email" name="txtEmail" id="txtEmail" class="form-control" maxlength="100">
								<input type="hidden" name="txtEmailOld" id="txtEmailOld" value="<?php print $o_info['sInfo']['sEmail']; ?>" />
							</div>
							<div class="row"></div>
							<div class="col-sm-12 col-xs-12 col-md-12 col-lg-12 form-group"><label>Group User</label><select name="selGroupUser" placeholder="Group User" allow-empty="false" id="selGroupUser" class="form-control selectpicker" data-size="8" data-live-search="true">
								<?php	
									foreach($o_info['sGroupList'] as $row) {
										?>
										<option value="<?php print $row['nGroupUserId_fk']; ?>" <?php print intval($this->session->userdata('nGroupUserId_fk')) === intval($row['nGroupUserId_fk']) ? "selected" : "" ?>><?php print $row['sGroupUserName']; ?></option>
									<?php
								}
							?>
							</select>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<button id="cmdSwitchProfile" type="button" class="btn btn-danger btn-block"><i class="fa fa-plug"></i> Switch Profile</button>
							</div>
						</div>
						<input type="hidden" name="hideMode" id="hideMode" value="" />
						<input type="hidden" name="hideFileNameOld[]" id="hideFileNameOld" value="<?php print trim($o_info['sInfo']['sAvatar']); ?>" />
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-3">
			<div class="panel panel-default bootcards-file">
				<div class="panel-heading">
					<h4 class="panel-title"><i class="fa fa-key"></i> Password</h4>
				</div>
				<div class="box-body box-profile" id="divPanelStatistic">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
							<label>About Me</label>
							<textarea id="txtAboutMe" name="txtAboutMe" placeholder="About Me..." rows="5" maxlength="100" class="form-control" style="max-height: 200px;"><?php print trim($o_info['sInfo']['sAboutMe']); ?></textarea>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
							<label>Password</label>
							<input allow-empty="false" value="<?php print $o_info['sInfo']['sPassword']; ?>" type="password" placeholder="Password" name="txtPassword" id="txtPassword" class="form-control" maxlength="10"/>
						</div>
						<div class="row"></div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
							<label>Re Type Password</label>
							<input allow-empty="false" value="<?php print $o_info['sInfo']['sPassword']; ?>" type="password" placeholder="Password" name="txtPasswordAgain" id="txtPasswordAgain" class="form-control" maxlength="100">
						</div>
					</div>
				</div>
				<div class="box-footer">
					<?php print $oButton; ?>
				</div>
			</div>
			<!--<div class="panel panel-default bootcards-file <?php print intval($this->session->userdata('nGropuUserId_fk')) === 0 ? "" : "hidden" ?>">
				<div class="panel-heading">
					<h4 class="panel-title"><i class="fa fa-key"></i> Session</h4>
				</div>
				<div class="box-body box-profile" id="divPanelStatistic">
					<?php print_r($this->session->userdata()); ?>
				</div>
			</div>-->
			<input type="hidden" name="hideOldPassword" id="hideOldPassword" value="<?php print $o_info['sInfo']['sPassword']; ?>" />
	</form>
</div>

<script>
	var sSURL = "<?php print site_url(); ?>c_core_upload/gf_upload/",
			dialog = "",
			nMaxSize = "<?php print $this->config->item('ConMaxFileSize'); ?>",
			sFileName = null;
	$(function() {
		$("button").removeAttr("disabled");
		$("button[id='button-submit']").click(function() {
			if ($.trim($(this).html()) === "Cancel")
				$("a[id='aEditProfile']").trigger("click");
			else {
				var bNext = true;
				var objForm = $("#form_5938b5bb933d2");
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
				if ($.trim($("#txtPassword").val()) !== $.trim($("#txtPasswordAgain").val())) {
					$("<div id='div-alert' style='margin: 15px;' class='alert alert-error alert-dismissible'><button class='close' aria-hidden='true' data-dismiss='alert' type='button'><i class='fa fa-close'></i></button><p>Password do not match...</p></div>").insertBefore($("#div-top"));
					bNext = false;
					return false;
				}
				if (!bNext)
					return false;
				//------------------------------------------ 
				$.gf_custom_ajax({
					"oForm": objForm,
					"success": function(r) {
					var JSON = $.parseJSON(r.oRespond);
					if (JSON.status === 1)
					{
						$("#imgAvatar").fadeOut("fast", function() {
							$(this).removeAttr("src");
							if(sFileName === null) {
								$("#imgAvatar").css("display", "none").prop("src", $("#imgAvatarEditProfile").attr("src")).fadeIn("fast");
								$("#imgAvatarEditProfile").css("display", "none").prop("src", $("#imgAvatarEditProfile").attr("src")).fadeIn("fast");
							}
							else {
								$("#imgAvatar").css("display", "none").prop("src", "<?php print site_url(); ?>uploads/avatar/" + sFileName).fadeIn("fast");
								$("#imgAvatarEditProfile").css("display", "none").prop("src", "<?php print site_url(); ?>uploads/avatar/" + sFileName).fadeIn("fast");
							}
							//$("a[id='aEditProfile']").trigger("click");
						});
					}
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
					"beforeSendType": "custom",
					"error": function(r) {}
				});
				//------------------------------------------ 
			}
		});
		gf_init_plupload();
		$("button[id='cmdSwitchProfile']").on("click", function() {
			$(this).addClass("disabled");
			$(this).prop("disabled", true);
			window.location.href = "<?php print site_url(); ?>c_core_user_menu/gf_change_group/" + $("#selGroupUser").find("option:selected").val().split("|")[0];
		});
		$("select").selectpicker('refresh');
	});
	function gf_guid(num) {
		var text = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
		for (var i = 0; i < num; i++)
			text += possible.charAt(Math.floor(Math.random() * possible.length));
		return text;
	}
	function gf_init_plupload() {
		var sArrayFile = Array(),
			sArraySize = Array(),
			oJSONObj = [],
			oLength = 25,
			oAddPath = "avatar";
		var uploader = new plupload.Uploader({
			runtimes: 'html5,flash,silverlight,html4',
			browse_button: 'aUploadImage',
			divUploadContainer: $("#divUploadContainer"),
			url: "<?php print site_url(); ?>c_core_upload/gf_upload/",
			chunk_size: '500kb',
			multiple_queues: true,
			multi_selection: false,
			unique_names: true,
			filters: {
				max_file_size: '50mb',
				mime_types: [{
					title: "Image files",
					extensions: "jpg,gif,png,jpeg"
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
					uploader.start();
				},
				UploadProgress: function(up, file) {},
				Error: function(up, err) {},
				BeforeUpload: function(up, file) {},
				UploadComplete: function(uploader, files) {
					var objForm = $("#form_5938b5bb933d2");
					objForm.append("<input type=\"hidden\" name=\"hidePath\" id=\"hidePath\" value=\"" + $.trim(oAddPath) + "\" />");
					objForm.append("<input type=\"hidden\" name=\"hideStatus\" id=\"hideStatus\" value=\"UPLOAD\" />");
					objForm.find("input[id='hideFileName']").remove();
					$.each(oJSONObj, function(i, n) {
						var JSON = $.parseJSON(n.oFile);
						objForm.append("<input type=\"hidden\" name=\"hideFileName[]\" id=\"hideFileName\" value=\"" + $.trim(JSON.fnameoriginal) + "\" />");
						sFileName = $.trim(JSON.fnameoriginal);
					});
					$("button#button-submit:eq(0)").trigger("click")
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
</script>