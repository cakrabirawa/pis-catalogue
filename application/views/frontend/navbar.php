<!--<nav class="navbar fixed-top navbar-light bg-light navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php print site_url(); ?>">
      <img src="<?php print site_url(); ?>img/favicon1.png" class="img-responsive" style="max-width: 40px;" />
      Gramedia Catalogue
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
      <li class="nav-item">
          <a class="nav-link nav-link-1 active" aria-current="page" href="<?php site_url(); ?>">Products</a>
      </li>
    </ul>
    </div>
  </div>
</nav>-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php print site_url(); ?>"><img src="<?php print site_url(); ?>img/favicon1.png" class="img-responsive" style="max-width: 40px;" />Publisher Catalogue</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02" style="z-index: 999;">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="<?php print site_url(); ?>">Home</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<br />
<div class="container-fluid tm-container-content">
  <div class="input-group mb-3">
    <input type="text" class="form-control form-control-lg" id="txtSearchBook" placeholder="Search Book Title, Original Author, Category, Product Id, ISBN, Editor, Cover Author etc..." value="<?php print isset($data_search) ? urldecode($data_search) : "" ?>">
    <button class="btn btn-primary" type="button" id="cmdSearchBook"><i class="fas fa-search"></i>&nbsp;Search</button>
  </div>
</div>
<div class="container-fluid tm-container-content">
  Popular Search Word: 
  <?php
    $a = array(
              array ("keyword" => "ayam", "count" => 10),
              array ("keyword" => "chicken", "count" => 87),
              array ("keyword" => "cooking", "count" => 37),
              array ("keyword" => "vb.net", "count" => 27),
    );
    $data_keyword = json_decode($data_keyword, TRUE);
    $i = 0;
    foreach($data_keyword as $data) {
      ?>
        <a href="<?php print site_url(); ?>search/<?php print trim($data['sKeywordName']); ?>" class="tm-text-primary"><?php print $data['sKeywordName']; ?> (<?php print $data['nCount']; ?>)</a>
      <?php
      $i++;
    }
  ?>
</div>
<br />
<script>
$(window).on("load", function() {
  $("#cmdSearchBook").on("click", function() {
    if($.trim($("#txtSearchBook").val()) !== "")
      window.location.href = "<?php print site_url(); ?>search/" + escape($("#txtSearchBook").val());
    else
    $("#txtSearchBook").focus();
  });
  $("#txtSearchBook").on("keydown", function(e) {
    if(e.keyCode === 13) {
      $("#cmdSearchBook").trigger("click");
    }
  })
});
</script>