<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Catalog-Z Bootstrap 5.0 HTML Template</title>
    <link rel="stylesheet" href="<?php print site_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php print site_url(); ?>assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php print site_url(); ?>assets/css/templatemo-style.css">
    <link rel="shortcut icon" type="image/png" href="<?php print site_url(); ?>img/favicon1.png" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv='cache-control' content='no-cache'>
	<meta http-equiv='expires' content='0'>	
	<meta http-equiv='pragma' content='no-cache'>

</head>
<body>
    <!-- Page Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>
    <?php $this->load->view('frontend/navbar'); ?>

    <div class="container-fluid tm-container-content tm-mt-20">
        <div class="row mb-4">
            <h2 class="col-6 tm-text-primary">
                Latest Books
            </h2>
            <div class="col-6 d-flex justify-content-end align-items-center">
                <form action="" class="tm-text-primary">
                    Page <input type="text" value="1" size="1" class="tm-input-paging tm-text-primary"> of 200
                </form>
            </div>
        </div>
        <div class="row tm-mb-90 tm-gallery">
        <?php 
            $data = json_decode($data_latest, TRUE);
            //print_r($data);
            foreach($data as $row) {
            ?>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                        <figure class="effect-ming tm-video-item">
                            <img id="imgCover" src="<?php print site_url(); ?>img/img_bg.jpg" path="<?php print $row['sPathCover']; ?>" alt="Image" class="img-fluid">
                            <figcaption class="d-flex align-items-center justify-content-center">
                                <h2><?php print $row['sKategorisasi']; ?></h2>
                                <a href="<?php print site_url(); ?>book-detail">View more</a>
                            </figcaption>                    
                        </figure>
                        <div class="d-flex justify-content-between tm-text-gray">
                            <span class="tm-text-gray-light">18 Oct 2020</span>
                            <span>9,906 views</span>
                        </div>
                    </div> 
            <?php
            }
        ?>
        </div> <!-- row -->
        <div class="row tm-mb-90">
            <div class="col-12 d-flex justify-content-between align-items-center tm-paging-col">
                <a href="javascript:void(0);" class="btn btn-primary tm-btn-prev mb-2 disabled">Previous</a>
                <div class="tm-paging d-flex">
                    <a href="javascript:void(0);" class="active tm-paging-link">1</a>
                    <a href="javascript:void(0);" class="tm-paging-link">2</a>
                    <a href="javascript:void(0);" class="tm-paging-link">3</a>
                    <a href="javascript:void(0);" class="tm-paging-link">4</a>
                </div>
                <a href="javascript:void(0);" class="btn btn-primary tm-btn-next">Next Page</a>
            </div>            
        </div>
    </div> <!-- container-fluid, tm-container-content -->

    <?php $this->load->view('frontend/footer'); ?>
    
    <script src="<?php print site_url(); ?>plugins/jquery/jquery-2.2.0.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/dist/js/jquery-ui.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/jquery.bootstrapdialog/bootstrap-dialog.min.js"></script>
	<script src="<?php print site_url(); ?>plugins/jquery.ado/ado.js"></script>

    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
            $("img[id='imgCover']").each(function() {
                var oImg = $(this);
                $.ajax({
                    cors: true ,
                    dataType: 'json',
                    headers: {
                        'Access-Control-Allow-Origin': '*',
                    },
                    method: "GET",
                    url: "http://10.12.42.10/ado/api.php?cmd=iterateimages1&path=S:\\PISELEX\\PROSESPROD\\EMK-NS000000314_Tidur_Berbantalkan_Koran\\COVER",
                    //data: { name: "John", location: "Boston" }
                    })
                    .done(function( msg ) {
                        alert( "Data Saved: " + msg );
                    });

                /*fetch('http://10.12.42.10/ado/api.php?cmd=iterateimages1&path=S:\\PISELEX\\PROSESPROD\\EMK-NS000000314_Tidur_Berbantalkan_Koran\\COVER', {
                    mode: 'no-cors', 
                    headers: { 
                        'Access-Control-Allow-Origin': 'http://10.12.42.10',
                    }
                })
                .then(
                function(res) {
                    console.log(res.json());
                }
                )
                .catch(function(err) {
                console.log('Fetch Error :-S', err);
                });*/
            })
        });
    </script>
</body>
</html>