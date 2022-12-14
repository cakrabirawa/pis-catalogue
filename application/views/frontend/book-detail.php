<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <?php
        $data = json_decode($data, TRUE);
        $view = json_decode($view, TRUE);
        $related_by_category = json_decode($related_by_category, TRUE);
        $related_by_sto      = json_decode($related_by_sto, TRUE);
    ?>
    <title><?php print trim($data[0]['sJudulPerubahan']); ?></title>
    <link rel="stylesheet" href="<?php print site_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php print site_url(); ?>assets/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="<?php print site_url(); ?>assets/css/templatemo-style.css">
    <link rel="shortcut icon" type="image/png" href="<?php print site_url(); ?>img/favicon1.png" />
    <link href='https://fonts.googleapis.com/css?family=Poppins:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv='cache-control' content='no-cache'>
	<meta http-equiv='expires' content='0'>	
	<meta http-equiv='pragma' content='no-cache'>

    <style>
        body { font-family: 'Poppins', sans-serif !important; }
    </style>
</head>
<body>
    <!-- Page Loader -->
    <div id="loader-wrapper">
        <div id="loader"></div>

        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>

    </div>
    <?php $this->load->view('frontend/navbar'); ?>

    <div class="container-fluid tm-container-content tm-mt-20" id="content">
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary">🔴 <?php print $data[0]['sJudulPerubahan']; ?></h2>
        </div>
        <div class="row tm-mb-90">            
            <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12">
                <div class="">
                    <img onerror="this.onerror=null;this.src='<?php print site_url(); ?>/img/img_no_photo.png'" style="margin-bottom: 20px;" src="<?php print $data[0]['sNewPathCoverOriginal']; ?>" path="<?php print trim($data[0]['sNewPathCoverOriginal']); ?>" class="img-fluid" alt="...">
                </div>
                <div class="tm-bg-gray col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="tm-video-details">
                        <div class="mb-2">
                            <h3 class="tm-text-gray-dark">Synopsis</h3>
                            <p><?php print preg_replace('/[[:^print:]]/', '', trim($data[0]['sPenjelasanProduk'])); ?></p>
                        </div>
                        <div class="mb-2">
                            <h3 class="tm-text-gray-dark">Selling Point</h3>
                            <p><?php print trim($data[0]['sSellingPoint']); ?></p>
                        </div>
                        <?php
                            if(trim($data[0]['sInformasiTambahan']) !== "") {
                                ?>
                                <div class="mb-2">
                                    <h3 class="tm-text-gray-dark">Additional Information</h3>
                                    <p><?php print trim($data[0]['sInformasiTambahan']); ?></p>
                                </div>
                        <?php
                            }
                        ?>
                        <div class="mb-2">
                            <h3 class="tm-text-gray-dark">Completeness</h3>
                            <p><?php print trim($data[0]['sKelengkapan']); ?></p>
                        </div>
                        <div class="mb-2">
                            <h3 class="tm-text-gray-dark">Request</h3>
                            <p><?php print trim($data[0]['sPermintaan']); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12">
                <div class="tm-bg-gray tm-video-details">
                    <div class="mb-2">
                        <h3 class="tm-text-gray-dark">Original Product Title</h3>
                        <p><?php print trim($data[0]['sJudulRC']); ?></p>
                    </div>
                    <div class="mb-2">
                        <h3 class="tm-text-gray-dark">Published Product Title</h3>
                        <p><?php print trim($data[0]['sJudulPerubahan']); ?></p>
                    </div>
                    <?php
                        if(trim($data[0]['sJudulSingkat']) !== "") {
                            ?>
                            <div class="mb-2">
                                <h3 class="tm-text-gray-dark">Short Published Product Title</h3>
                                <p><?php print trim($data[0]['sJudulSingkat']); ?></p>
                            </div>
                        <?php
                        }
                    ?>
                    <div class="mb-2">
                        <h3 class="tm-text-gray-dark">Product Detail</h3>
                    </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Product Id: </span><span class="tm-text-primary"><?php print $data[0]['sNoProduk']; ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">ISBN: </span><span class="tm-text-primary"><?php print $data[0]['sISBN']; ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">ISBN Lengkap: </span><span class="tm-text-primary"> <?php print $data[0]['sISBNLengkap']; ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">ISBN Digital: </span><span class="tm-text-primary"> <?php print trim($data[0]['sISBNDigital']) === "" ? "-" : trim($data[0]['sISBNDigital']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">ISSN: </span><span class="tm-text-primary"> <?php print trim($data[0]['sISSN']) === "" ? "-" : trim($data[0]['sISSN']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Estimated Published Date: </span><span class="tm-text-primary"> <?php print $data[0]['dTglEstimasiSTO']; ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Real Published Date: </span><span class="tm-text-primary"> <?php print $data[0]['dTglSTO']; ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Original Author: </span><span class="tm-text-primary"><?php print trim($data[0]['sDetailPengarang']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Cover Author: </span><span class="tm-text-primary"><?php print trim($data[0]['sNamaPengarangCover']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Cover Format: </span><span class="tm-text-primary"><?php print trim($data[0]['sNamaTipeCoverProduk']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Paper: </span><span class="tm-text-primary"><?php print trim($data[0]['sNamaTipeKertasProduk']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Content: </span><span class="tm-text-primary"><?php print trim($data[0]['sKertasIsi']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Store Category: </span><span class="tm-text-primary"><?php print trim($data[0]['sKategorisasiToko']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Publishers Category: </span><span class="tm-text-primary"><?php print trim($data[0]['sKategorisasi']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Product Size: </span><span class="tm-text-primary"><?php print trim($data[0]['sUkuran']); ?> CM</span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Editor: </span><span class="tm-text-primary"><?php print trim($data[0]['sEditor']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Pages: </span><span class="tm-text-primary"><?php print trim($data[0]['nTotalTebal']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Materi: </span><span class="tm-text-primary"><?php print trim($data[0]['sNamaSpekMateri']); ?></span>
                        </div>
                        <div class="mr-4 mb-2">
                            <span class="tm-text-gray-dark">Estimated Production Process Date: </span><span class="tm-text-primary"><?php print trim($data[0]['dTglRencanaProduksi']); ?></span>
                        </div>
                    <div class="mb-2">
                        <h3 class="tm-text-gray-dark">Publishers</h3>
                        <p class="tm-text-primary"><b><?php print trim($data[0]['sNamaUnit']); ?></b></p>
                    </div>
                    <div>
                        <h3 class="tm-text-gray-dark mb-3">Reader Target</h3>
                        <?php
                            foreach(explode(",", trim($data[0]['sTargetPengguna'])) as $row) {
                                ?>
                                    <a href="#" class="tm-text-primary mr-4 mb-2 d-inline-block"><?php print $row; ?></a>
                                <?php
                            }
                        ?>
                    </div>
                    <div class="text-center mb-3">
                        <div class="d-grid gap-2">
                            <a target="_blank" href="#" class="btn btn-primary btn-block tm-btn-big"><i class="fas fa-print"></i> Print Product Sheet</a>
                            <a target="_blank" href="<?php print site_url()."cover/".$data[0]['sUUID']; ?>" class="btn btn-primary btn-block tm-btn-big"><i class="fas fa-download"></i> Download Cover</a>
                        </div>
                    </div>                    
                    <!--<div class="mb-4">
                        <h3 class="tm-text-gray-dark mb-3">License</h3>
                        <p>Free for both personal and commercial use. No need to pay anything. No need to make any attribution.</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="tm-text-gray-dark mb-3">Views</h3>
                        <p><?php print $view['nViews']; ?>
                    </div>
                    -->
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary">
                Related Product By Category
            </h2>
        </div>
        <div class="row mb-3 tm-gallery">
            <?php
                foreach($related_by_category as $row) {
                    ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                            <figure class="effect-ming tm-video-item">
                            <a href="<?php print site_url(); ?>view/<?php print $row['sISBN']; ?>"><img onerror="this.onerror=null;this.src='<?php print site_url(); ?>img/img_no_photo.png';" src="<?php print $row['sNewPathCoverOriginal']; ?>" alt="Image" class="mx-auto d-block"></a>
                                <figcaption class="d-flex align-items-center justify-content-center">
                                    <h2><?php print $row['sJudulPerubahan']; ?></h2>
                                    <a href="<?php print site_url(); ?>view/<?php print $row['sISBN']; ?>">View more</a>
                                </figcaption>                    
                            </figure>
                            <div class="d-flex justify-content-between tm-text-gray">
                                <span class="tm-text-gray-light"><?php print $row['dTglSTO']; ?></span>
                                <span><i class="fas fa-eye"></i> <?php print $row['nViews']; ?></span>
                            </div>
                        </div>
                    <?php
                }
                ?>
        </div> 
        <div class="row mb-4">
            <h2 class="col-12 tm-text-primary">
                Related Product By Published Date
            </h2>
        </div>
        <div class="row mb-3 tm-gallery">
            <?php
                foreach($related_by_sto as $row) {
                    ?>
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                            <figure class="effect-ming tm-video-item">
                            <a href="<?php print site_url(); ?>view/<?php print $row['sISBN']; ?>"><img onerror="this.onerror=null;this.src='<?php print site_url(); ?>img/img_no_photo.png';" src="<?php print $row['sNewPathCoverOriginal']; ?>" alt="Image" class="mx-auto d-block"></a>
                                <figcaption class="d-flex align-items-center justify-content-center">
                                    <h2><?php print $row['sJudulPerubahan']; ?></h2>
                                    <a href="<?php print site_url(); ?>view/<?php print $row['sISBN']; ?>">View more</a>
                                </figcaption>                    
                            </figure>
                            <div class="d-flex justify-content-between tm-text-gray">
                                <span class="tm-text-gray-light"><?php print $row['dTglSTO']; ?></span>
                                <span><i class="fas fa-eye"></i> <?php print $row['nViews']; ?></span>
                            </div>
                        </div>
                    <?php
                }
                ?>
        </div> 
    </div> 

    <?php $this->load->view('frontend/footer'); ?>
    
    <script src="<?php print site_url(); ?>assets/js/plugins.js"></script>
    <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>

    <script>
        $(window).on("load", function() {
            $('body').addClass('loaded');

            
            /*window.jsPDF = window.jspdf.jsPDF;
            var doc = new jsPDF();
            var elementHTML = document.querySelector("#content");
            doc.html(elementHTML, {
                callback: function(doc) {
                    // Save the PDF
                    doc.save('sample-document.pdf');
                },
                x: 15,
                y: 15,
                width: 170, //target width in the PDF document
                windowWidth: 650 //window width in CSS pixels
            });*/
        });
    </script>
</body>
</html>