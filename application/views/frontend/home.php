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
        $this->load->view('frontend/navbar'); 
        $data_sto_this_week_carousel = json_decode($data_sto_this_week_carousel, TRUE);
    ?>
    <div class="container-fluid tm-container-content tm-mt-20">
        <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php
                    $i = 0;
                    foreach($data_sto_this_week_carousel as $row) {
                    ?>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="<?php print $i; ?>" class="active" aria-current="true" aria-label="Slide <?php print $i; ?>"></button>
                    <?php
                    $i++;
                    }
                    ?>
            </div>
            <div class="carousel-inner mb-5">
                <?php
                     $i = 0;
                     foreach($data_sto_this_week_carousel as $row) {
                     ?>
                        <div class="carousel-item <?php print $i === 0 ? "active" : "" ?>" data-bs-interval="2000">
                             <a href="<?php print site_url(); ?>view/<?php print $row['sISBN']; ?>"><center><img onerror="this.onerror=null;this.src='<?php print site_url(); ?>/img/img_no_photo.png'" src="<?php print $row['sNewPathCoverThumbnail']; ?>" path="<?php print $row['sPathCover']; ?>" class="d-block w-80" alt="..."></center></a>
                            <div class="carousel-caption d-none d-md-block">
                                <p>&nbsp;</p>
                                <h5><?php print $row['sJudulPerubahan']; ?></h5>
                                <p><?php print word_limiter($row['sPenjelasanProduk'], 10); ?></p>
                            </div>
                        </div>
                    <?php
                    $i++;
                     }
                     ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>




        <div class="row mb-4">
            <h2 class="col-6 tm-text-primary">
                🔴 Latest Books
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
            foreach($data as $row) {
            ?>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-5">
                    <div class="card" style="">                        
                        <img onerror="this.onerror=null;this.src='<?php print site_url(); ?>/img/img_no_photo.png'" src="<?php print $row['sNewPathCoverThumbnail']; ?>" path="<?php print $row['sNewPathCoverThumbnail']; ?>" class="card-img-top mx-auto d-block" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php print $row['sNoProduk']; ?></h5>
                            <p class="card-text"><?php print word_limiter($row['sPenjelasanProduk'], 10); ?></p>
                            <footer class="blockquote-footer"><?php print trim($row['sNamaPengarangCover'], 10); ?></footer>
                            <p class="card-text"><i class="fas fa-calendar-alt"></i> <?php print $row['dTglSTO']; ?> | <i class="fas fa-eye"></i> <?php print trim($row['nViews']) === "" ? 0 : trim($row['nViews']); ?></p>
                            <p class="card-text"><?php print trim($row['sKategorisasiToko']) === "-" ? trim($row['sKategorisasi']) : trim($row['sKategorisasiToko']); ?></p>
                        </div>
                        <!--<ul class="list-group list-group-flush">
                            <li class="list-group-item card-text"><?php print trim($row['sKategorisasiToko']) === "-" ? trim($row['sKategorisasi']) : trim($row['sKategorisasiToko']); ?></li>
                            <li class="list-group-item">A second item</li>
                            <li class="list-group-item">A third item</li>
                        </ul>-->
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?php print site_url(); ?>view/<?php print $row['sISBN']; ?>" class="btn btn-primary btn-block btn-sm">View Detail</a>
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
    
    <script src="<?php print site_url(); ?>plugins/jquery/jquery-2.2.0.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');
        });
    </script>
</body>
</html>