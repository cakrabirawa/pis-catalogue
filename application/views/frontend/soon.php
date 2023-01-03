<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Publisher Information Catalogue System V 1.0</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php print site_url(); ?>assets/fontawesome/css/all.min.css" />
    <link rel="stylesheet" href="<?php print site_url(); ?>assets/css/templatemo-style.css" />
    <link rel="shortcut icon" type="image/png" href="<?php print site_url(); ?>img/favicon1.png" />
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,700' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" />
    <script src="<?php print site_url(); ?>plugins/jquery/jquery-2.2.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="<?php print site_url(); ?>plugins/jquery.slimscroll/jquery.slimscroll.min.js"></script>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv='cache-control' content='no-cache' />
	<meta http-equiv='expires' content='0' />	
	<meta http-equiv='pragma' content='no-cache' />

    <style>
        body { font-family: 'Poppins', sans-serif !important; }
    </style>

</head>
<body>
    <div id="loader-wrapper">
        <div id="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>
    <?php 
        $this->load->view('frontend/navbar', $data_keyword); 
    ?>
    <div class="container-fluid tm-container-content tm-mt-20">
      Soon Page Not Ready !
    </div>
    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>