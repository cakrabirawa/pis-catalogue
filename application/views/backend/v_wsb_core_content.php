<?php
$oConfig = $o_extra['o_config'];
?>
<header class="main-header">
	<?php $this->load->view('backend/v_wsb_core_logo'); ?>
	<?php $this->load->view('backend/v_wsb_core_notif_header'); ?>
</header>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<?php $this->load->view('backend/v_wsb_core_menu_side_bar'); ?>
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<?php //$this->load->view('backend/v_wsb_core_breadcumb_info'); 
	?>
	<section class="content">
		<?php $this->load->view($o_page); ?>
	</section>
</div>

<!-- /.content-wrapper -->
<footer class="main-footer">
	<div class="pull-right hidden-xs">
		<?php
		$oInfo = json_decode($o_extra['o_info'], TRUE);
		?>
		<?php print html_entity_decode($oConfig['APPS_VERSION']); ?>
	</div>
	<?php print html_entity_decode($oConfig['APPS_COPYRIGHT']); ?>
</footer>

<script>
	$(function() {
		$(".sidebar-menu").
		find("li > a[segment='<?php print $this->uri->segment(1); ?>']").
		addClass("text-yellow").
		parent().
		parent().
		parent().
		addClass("active");
		<?php
		if ($oConfig['VIRTUAL_SCROLL_BODY'] === "TRUE") {
		?>
			$("#divWrapper").slimScroll({
				position: 'right',
				width: '100%',
				height: '100%',
				railVisible: false,
				color: '#000',
				railColor: '#fff',
				alwaysVisible: false,
				distance: '2px',
				wheelStep: "<?php print $oConfig['WHEEL_STEP_BODY_SCROLL']; ?>",
				size: '10px',
				allowPageScroll: true,
				disableFadeOut: false,
			});
		<?php
		}
		?>
		$(document).trigger("mouseout");
		gf_init_next();
	});
	$(window).on("mousedown", function() {
		var objForm = $.gf_create_form({
			"action": "<?php print site_url(); ?>c_core_login/gf_check_session_ajax"
		});
		$.gf_custom_ajax({
			"oForm": objForm,
			"success": function(r) {
				var JSON = $.parseJSON(r.oRespond);
				if (parseInt(JSON.status) === 1) {
					$("#divWrapper").css({
						"-webkit-filter": "blur(5px)",
						"filter": "blur(5px)"
					});
					$(window).unbind("mousedown");
					var oDialog = new BootstrapDialog({
						title: "Information",
						closable: false,
						message: "<div class=\"text-center\"><i class=\"fa fa-frown-o fa-4x text-red\"></i><br /><h4>Oops, your session has been Expired.</h4> Please re-login to use this Apps.</div>",
						type: BootstrapDialog.TYPE_DEFAULT,
						buttons: [{
							id: 'cmdOK',
							label: 'Close',
							cssClass: 'btn-default',
							hotkey: 13,
							action: function() {
								window.location.href = "<?php print site_url(); ?>";
							}
						}]
					});
					oDialog.open();
				}
			},
			"validate": true,
			"beforeSend": function(r) {},
			"beforeSendType": "custom",
			"error": function(r) {}
		});
	});
	$("ul[class='sidebar-menu'] a[page='0'], a[id='aEditProfile']").unbind("click").on("click", function(evt) {
		evt.preventDefault();
		var oObj = $(this);
		//history.pushState(null, $(this).text(), oObj.attr('segment'));
		if ($.trim(oObj.attr('segment')) === "c_core_logout") {
			window.location.href = "<?php print site_url(); ?>c_core_logout";
			return false;
		}
		$.ajax({
			url: oObj.attr('segment'),
			beforeSend: function(xhr) {
				$.gf_loading_show({
					sMessage: "Loading Page..."
				});
				$(".sidebar-menu").find("a").removeClass("text-yellow");
				$(".sidebar-menu").
				find("li > a[segment='" + oObj.attr('segment') + "']").
				addClass("text-yellow").
				parent().
				parent().
				parent().
				addClass("active");
			}
		}).done(function(data) {
			$("section[class='content']").html(data);
			$.gf_loading_hide();
		});
	});
	if ($.trim("<?php print $this->uri->segment(1); ?>") === "") {
		$(".sidebar-menu").find("a").removeClass("text-yellow");
		$(".sidebar-menu").find("li > a:first[segment='c_core_dashboard']").
		addClass("text-yellow").
		parent().
		parent().
		parent().
		addClass("active");
	}
	function gf_init_next() {
		const urlNext = window.next;		
		if ($.trim(urlNext) !== "") {
			var c = null;
			if(urlNext.indexOf("pengajuan") > 0) {
				c = "c_prepayment_pengajuan_pre_payment";
			} else if(urlNext.indexOf("penyelesaian") > 0) {
				c = "c_prepayment_penyelesaian_pre_payment";
			}
			$(".sidebar-menu").
			find("li > a[segment='" + c + "']").
			addClass("text-yellow").
			parent().
			parent().
			parent().
			addClass("active");

			var sUUID = urlNext.split("/")[urlNext.split("/").length - 1];
			var oForm = $.gf_create_form({
				action: urlNext
			});
			oForm.append("<input type=\"hidden\" name=\"sUUID\" id=\"sUUID\" value=\"" + $.trim(sUUID) + "\" />");
			$.gf_custom_ajax({
				"oForm": oForm,
				"success": function(r) {
					$.gf_loading_hide();
					$("section[class='content']").html(r.oRespond);
				},
				"validate": true,
				"beforeSend": function(r) {
					$("section[class='content']").empty();
					$.gf_loading_show({
						sMessage: "Loading Data..."
					});
				},
				"beforeSendType": "custom",
				"error": function(r) {}
			});
		}
	}
</script>

</div>