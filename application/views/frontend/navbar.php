<nav class="navbar fixed-top navbar-light bg-light navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php print site_url(); ?>">
      <img src="<?php print site_url(); ?>img/favicon1.png" class="img-responsive" style="max-width: 40px;" />
      Gramedia Pubslihers Catalogue
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-bars"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
      <li class="nav-item">
          <a class="nav-link nav-link-1 active" aria-current="page" href="<?php site_url(); ?>home">Books</a>
      </li>
      <!--<li class="nav-item">
          <a class="nav-link nav-link-2" href="<?php site_url(); ?>home">Videos</a>
      </li>
      <li class="nav-item">
          <a class="nav-link nav-link-3" href="<?php site_url(); ?>home">About</a>
      </li>
      <li class="nav-item">
          <a class="nav-link nav-link-4" href="<?php site_url(); ?>home">Contact</a>
      </li>-->
    </ul>
    </div>
  </div>
</nav>
<br />
<div class="container-fluid tm-container-content tm-mt-60">
  <div class="input-group mb-3">
    <input type="text" class="form-control form-control-lg" id="txtSearchBook" placeholder="Search Book Title, Original Author, Category, Product Id, ISBN, Editor, Cover Author etc...">
    <button class="btn btn-primary" type="button" id="button-addon1"><i class="fas fa-search"></i>&nbsp;Search</button>
  </div>
</div>
