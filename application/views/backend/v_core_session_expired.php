<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php print $this->config->item('ConAppsTitle'); ?></title>
	<link rel="shortcut icon" type="image/png" href="<?php print site_url(); ?>img/favicon.png" />
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="<?php print site_url(); ?>bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" href="<?php print site_url(); ?>dist/css/AdminLTE.min.css" />
	<link rel="stylesheet" href="<?php print site_url(); ?>dist/css/font-awesome.min.css" />
	<script src="<?php print site_url(); ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>

<body style="background: #f0f0f0">
	<div class="margin-bottom"></div>
	<div class="row">
		<div class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">
			<div class="panel">
				<div class="box-header with-border">
					<h3 class="box-title"><i class="fa fa-clock-o text-white"></i> Session Expired !</h3>
					<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="remove"></button>
					</div>
					<!-- /.box-tools -->
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="box-body">
						<blockquote>
							<p>Oops,,, Your session has been expired.<br />You must be Login again before use this Apps. click <a href="<?php print site_url(); ?>c_core_login" class="text-red">here</a> to quick jump to Login page.</p>
							<small>Session Manager Information for<cite title="Source Title"><?php print $this->config->item('ConAppsTitle'); ?></cite></small>
						</blockquote>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</head>

</html>