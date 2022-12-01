<?php
$o_info = json_decode($o_extra['o_info'], TRUE);
?>
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
  <!-- Sidebar user panel -->
  <div class="user-panel">
    <div class="pull-left image">
      <img onerror="this.onerro=null;this.src='<?php print site_url(); ?>img/img-user.png';" src="<?php print site_url(); ?><?php print trim($o_info['sInfo']['sAvatar']) === "" ? "img/img-user.png" :   "c_core_user_login/gf_load_image/" . trim($o_info['sInfo']['sAvatar']); ?>" id="imgAvatar" class="img-responsive img-rounded" />
    </div>
    <div class="pull-left info">
      <?php
      $nLimit = 15;
      ?>
      <p><?php print anchor(site_url() . "c_core_edit_profile", (strlen(trim($this->session->userdata('sRealName'))) > $nLimit && trim($this->session->userdata('sRealName')) !== "" ? substr(trim($this->session->userdata('sRealName')), 0, $nLimit) . "..." : trim($this->session->userdata('sRealName'))), array("segment" => site_url() . "c_core_edit_profile", "id" => "aEditProfile", "title" => "Edit Profile: " . trim($this->session->userdata('sRealName')))); ?></p>
      <a href="#"><i class="fa fa-circle text-success"></i><?php print $this->session->userdata('sGroupUserName'); ?></a>
    </div>
  </div>
  <!-- search form -->
  <!--<form action="#" method="get" class="sidebar-form">
    <div class="input-group">
      <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
          <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
          </button>
        </span>
    </div>
  </form>-->
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu">
    <li class="header">MAIN MENU</li>
    <?php print $o_extra['o_side_bar']; ?>
    <li class="header"><i class="fa fa-circle-o text-green"></i> Last Login: <?php print $o_info['sInfo']['dLastLoginDate']; ?></li>
    <li class="header"><i class="fa fa-circle-o text-red"></i> Session: <?php print $this->session->userdata('sUnitName'); ?></li>
    <!--<li class="header"><i class="fa fa-circle-o text-blue"></i> Database: <?php print $this->db->database; ?></li>
    <li class="header"><i class="fa fa-circle-o text-yellow"></i> Server: <?php print $this->db->hostname; ?></li>-->
    <!-- Added Information for SCO -->
    <li class="header"><i class="fa fa-circle-o text-aqua"></i> User Group: <?php print $this->session->userdata('sGroupUserName'); ?></li>
  </ul>
</section>
<!-- /.sidebar -->