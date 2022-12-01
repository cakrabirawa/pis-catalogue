<?php
$o_info = json_decode($o_extra['o_info'], TRUE);
$oUser = $o_info['sUserList'];
$oUserCount = count($oUser);
$oMaxLengthCaption = 17;
?>
<li class="dropdown messages-menu">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="aUserDropDown">
		<i class="fa fa-user-o"></i>
		<span class="label label-primary"><?php print $oUserCount; ?></span>
	</a>
	<ul class="dropdown-menu">
		<li class="header">You have Access <b><?php print $oUserCount; ?></b> Users</li>
		<li class="header">
			<input type="text" id="txtFindUser" placeholder="Search Real Name..." class="form-control" autocomplete="off">
		</li>
		<li>
			<ul class="menu" id="ulUser">
			</ul>
		</li>
	</ul>
</li>
<script>
	var bFirstTime = true,
		oTxtFindUser = $("#txtFindUser"),
		typingTimer,
		doneTypingInterval = 300;

	$(function() {
		$("#aUserDropDown").on("click", function() {
			if (bFirstTime) {
				setTimeout(function() {
					oTxtFindUser.select().focus().select();
				}, 1);
				bFirstTime = false;
			}
		});

		oTxtFindUser.on("keyup", function(e) {
			clearTimeout(typingTimer);
			typingTimer = setTimeout(doneTyping, doneTypingInterval);
		}).on('keydown', function() {
			clearTimeout(typingTimer);
		}).on("blur", function(){
			bFirstTime = true;
		});
	});

	function doneTyping() {
		if ($.trim(oTxtFindUser.val()) !== "") {
			var UL = $("#ulUser"),
				nSession = "<?php print($this->session->userdata('nUserId')); ?>",
				nDivisi = "<?php print($this->session->userdata('nIdDivisi_fk')); ?>",
				nGroup = "<?php print($this->session->userdata('nGroupUserId_fk')); ?>",
				s = $.trim(oTxtFindUser.val());

			$.ajax({
				url: "<?php print site_url(); ?>c_core_user_login/gf_search_user_login/",
				data: {
					sParam: s
				},
				type: "post",
				success: function(data) {
					UL.find("li").remove();
					var JSON = $.parseJSON(data);
					$.each(JSON.sData, function(i, n) {
						var s = "<li><a href=\"<?php print site_url(); ?>c_core_login/gf_change_login/" + n.nUserId + "\"><div class=\"pull-left\"><i class=\"fa fa-user-o fa-2x " + ((parseInt(nSession) === parseInt(n.nUserId)) && (parseInt(nGroup) === parseInt(n.nGroupUserId_fk)) ? "text-red" : "text-black") + "\"></i></div><h4 class=\"" + ((parseInt(nSession) === parseInt(n.nUserId)) && (parseInt(nGroup) === parseInt(n.nGroupUserId_fk)) && (parseInt(nDivisi) === parseInt(n.nIdDivisi_fk)) ? "text-red" : "text-black") + "\">" + (n.sRealName.length > 17 ? n.sRealName.substring(0, 17) : n.sRealName) + "</h4><p>" + n.nUserId + "</p></a></li>";
						UL.append(s);
					});
					oTxtFindUser.removeClass("disabled");
				},
				beforeSend: function() {
					oTxtFindUser.addClass("disabled");
					UL.find("li").remove();
					UL.append("<li class=\"text-center\"><a class=\"text-black\"><i class=\"fa fa-cog fa-spin\"></i> Loading...</a></li>");
				}
			});
		}
	}
</script>