<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Result for <?php print urldecode($data_search); ?></title>
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
        $data['data_search'] = trim($data_search);
        $this->load->view('frontend/navbar', $data); 
        $data_sto_this_week_carousel = json_decode($data_sto_this_week_carousel, TRUE);
    ?>
    <div class="container-fluid tm-container-content tm-mt-20">
        <div class="row mb-4">
            <h4 class="col-6 tm-text-primary">
                Search Result for <b><?php print urldecode($data_search); ?></b>
            </h4>
        </div>
        <div class="row tm-mb-90 tm-gallery">
        <?php 
            $data = json_decode($data_search_list, TRUE);
            foreach($data as $row) {
            ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-5">
                    <div class="card" id="inner-content-div">                        
                    <a href="<?php print site_url(); ?>view/<?php print $row['sISBN']; ?>"><img onerror="this.onerror=null;this.src='<?php print site_url(); ?>/img/img_no_photo.png'" src="<?php print $row['sNewPathCoverThumbnail']; ?>" class="card-img-top mx-auto d-block" ></a>
                        <div class="card-body">
                            <h5 class="card-title"><?php print $row['sNoProduk']; ?></h5>
                            <p class="card-text"><?php print word_limiter($row['sPenjelasanProduk'], 10); ?></p>
                            <footer class="blockquote-footer"><?php print trim($row['sNamaPengarangCover'], 10); ?></footer>
                            <p class="card-text"><i class="fas fa-calendar-alt"></i> <?php print $row['dTglSTO']; ?> | <i class="fas fa-eye"></i> <?php print trim($row['nViews']) === "" ? 0 : trim($row['nViews']); ?></p>
                            <p class="card-text"><?php print trim($row['sKategorisasiToko']) === "-" ? trim($row['sKategorisasi']) : trim($row['sKategorisasiToko']); ?></p>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?php print site_url(); ?>view/<?php print $row['sISBN']; ?>" class="btn btn-primary btn-block btn-lg">View Detail</a>
                            </div>
                        </div>
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
    
    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
            $("div[id='inner-content-div']").slimScroll({
                height: '400px'
            });
            $("div[id='inner-content-div']").trigger("mouseleave");
        });
    </script>
</body>
</html>