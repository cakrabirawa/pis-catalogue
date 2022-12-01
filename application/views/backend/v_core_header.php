<?php $oConfig = $o_extra['o_config']; ?>
<!DOCTYPE html>
<html oncontextmenu="return false;">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta http-equiv='cache-control' content='no-cache'>
	<meta http-equiv='expires' content='0'>	
	<meta http-equiv='pragma' content='no-cache'>

	<title><?php print trim($oConfig['APPS_NAME']); ?></title>
	<link rel="shortcut icon" type="image/png" href="<?php print site_url(); ?>img/favicon1.png" />

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

	<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/bootstrap/css/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/dist/css/AdminLTE.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/dist/css/font-awesome.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/jquery.app/app.css" />

	<script src="<?php print site_url(); ?>plugins/jquery/jquery-2.2.0.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/dist/js/jquery-ui.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/jquery.bootstrapdialog/bootstrap-dialog.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/jquery.ado/ado.js"></script>

	<?php
	if(trim($this->uri->segment(1)) !== "c_core_login")
	{
		?>
		<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/dist/css/bootstrap-dialog.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/dist/css/skins/_all-skins.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/dist/css/jquery.fileupload.css" />
		<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/dist/css/font-awesome-animation.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/dist/css/ionicons.min.css">
		<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/jquery.datepicker/datepicker3.css">
		<!--<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/jquery.codemirror-5.23.0/lib/codemirror.css" />
		<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/jquery.codemirror-5.23.0/addon/hint/show-hint.css" />
		<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/jquery.codemirror-5.23.0/addon/hint/show-hint.css" />-->
		<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/jquery.bootstrapselect/dist/css/bootstrap-select.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php print site_url(); ?>plugins/stimulsoft/stimulsoft.viewer.office2013.whiteblue.css" />
		<script src="<?php print site_url(); ?>plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.easing/jquery.easing.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.plupload/plupload/js/plupload.full.min.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.autogrow/autosize-master/dist/autosize.min.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.datepicker/bootstrap-datepicker.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.ace/ace.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.bootstrapselect/dist/js/bootstrap-select.min.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.numeric/autoNumeric-1.9.41.min.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.app/app.min.js"></script>
		
		<script src="<?php print site_url(); ?>plugins/stimulsoft/stimulsoft.reports.pack.js"></script>
		<script src="<?php print site_url(); ?>plugins/stimulsoft/stimulsoft.viewer.pack.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.timeago/timeago.min.js"></script>

		<!--<script src="<?php print site_url(); ?>plugins/jquery.highchart.10.0.0/code/highcharts.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.highchart.10.0.0/code/highcharts-3d.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.highchart.10.0.0/code/modules/exporting.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.highchart.10.0.0/code/modules/export-data.js"></script>
		<script src="<?php print site_url(); ?>plugins/jquery.highchart.10.0.0/code/modules/accessibility.js"></script>-->

		<?php
	}
	?>
</head>
<body class="skin-blue fixed sidebar-mini sidebar-mini-expand-feature">
	<div id="divWrapper" class="wrapper">