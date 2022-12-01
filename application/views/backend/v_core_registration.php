<div class="login-box">
	<div class="login-box-body login-bg-form" id="div-login-wrap">
		<div>
			<?php
			$a = $o_msg;
			?>
			<h3 id="h3-title">
				<p id="pLoginTitle" class="login-box-msg"><?php print intval($a['status']) === 1 ? "<i class=\"fa fa-smile-o fa-5x\"></i><br />Activation Successfully" : "<i class=\"fa fa-frown-o fa-5x\"></i><br />Oopss, Invalid Request :("; ?></p>
			</h3>
			<p class="text-red"><?php print $o_msg['message']; ?></p>
			<a href="<?php print site_url(); ?>" class="btn btn-danger btn-md btn-block">Return to Home</a>
		</div>
		<div class="margin-bottom"></div>
	</div>
</div>
<script>
	$(function() {
		$(".wrapper, body").css({
			background: "#ECF0F5"
		});
	});
</script>