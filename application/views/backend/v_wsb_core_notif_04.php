<?php
$o_info = json_decode($o_info, TRUE);
?>
<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php print trim($o_info['sInfo']['sRealName']); ?>">
    <img src="<?php print site_url(); ?><?php print trim($o_info['sInfo']['sAvatar']) === "" ? "img/img-user.png" :   "c_core_user_login/gf_load_image/" . trim($o_info['sInfo']['sAvatar']); ?>" class="user-image" alt="User Image">
    <span class="hidden-xs"><?php print(strlen($o_info['sInfo']['sRealName']) > 20 ? substr($o_info['sInfo']['sRealName'], 0, 20) . "..." : trim($o_info['sInfo']['sRealName'])); ?></span>
  </a>
  <ul class="dropdown-menu">
    <!-- User image -->
    <li class="user-header">
      <img src="<?php print site_url(); ?><?php print trim($o_info['sInfo']['sAvatar']) === "" ? "img/img-user.png" :   "c_core_user_login/gf_load_image/" . trim($o_info['sInfo']['sAvatar']); ?>" class="img-circle" alt="User Image">
      <p title="<?php print trim($o_info['sInfo']['sRealName']); ?>">
        <?php print(strlen($o_info['sInfo']['sRealName']) > 20 ? substr($o_info['sInfo']['sRealName'], 0, 20) . "..." : $o_info['sInfo']['sRealName']); ?> - <?php print $o_info['sInfo']['sGroupUserName']; ?>
        <small>Member since <?php print $o_info['sInfo']['dCreateOn']; ?></small>
      </p>
    </li>
    <!-- Menu Body -->
    <!--<li class="user-body">
      <div class="row">
        <div class="col-xs-4 text-center">
          <a href="#">Followers</a>
        </div>
        <div class="col-xs-4 text-center">
          <a href="#">Sales</a>
        </div>
        <div class="col-xs-4 text-center">
          <a href="#">Friends</a>
        </div>
      </div>
    </li>-->
    <!-- Menu Footer-->
    <li class="user-footer">
      <div class="pull-left">
        <?php print anchor(site_url() . "c_core_edit_profile", "Profile", array("title" => "Profile", "class" => "btn btn-primary")); ?>
      </div>
      <div class="pull-right">
        <?php print anchor(site_url() . "c_core_logout", "<span>Logout</span>", array("title" => "Logout", "class" => "btn btn-danger")); ?>
      </div>
    </li>
  </ul>
</li>