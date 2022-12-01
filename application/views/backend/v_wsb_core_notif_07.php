<!-- Notifications: style can be found in dropdown.less -->
<?php
$oData = json_decode($o_extra['o_info'], TRUE);
//print_r($oData['sGroupList']);
if (count($oData['sGroupList']) <= 1)
  return;
else {
?>
  <li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-lock"></i>
      <span class="label label-danger"><?php print count($oData['sGroupList']); ?></span>
    </a>
    <ul class="dropdown-menu">
      <li class="header">Dear <b><?php print $oData['sInfo']['sUserName']; ?></b> You are Granted <b><?php print count($oData['sGroupList']); ?></b> Group Access. To Use Antoher Group Access Session, Please Click Once in Below the List.</li>
      <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu">
          <?php
          //print_r($oData['sGroupList']);
          //print "<br />";
          //print_r($this->session->userdata());
          foreach ($oData['sGroupList'] as $row) {
            print "<li><a href=\"" . site_url() . "c_core_user_menu/gf_change_group/" . trim($row['nGroupUserId_fk'])."\" title=\"Click Here to Change Group User Session: " . trim($row['sGroupUserName']) . "\"><i class=\"fa fa-lock fa-1x\"></i>" . ((intval($row['nGroupUserId_fk']) === intval($this->session->userdata('nGroupUserId_fk'))) ? "<b class=\"text-red\">" : "") . "" . trim($row['sGroupUserName']) . ((intval($row['nGroupUserId_fk']) === intval($this->session->userdata('nGroupUserId_fk'))) ? "</b>" : "") . "</a></li>";
          }
          ?>
        </ul>
      </li>
      <!--<li class="footer"><a href="#" title="Enter All Database Access - No Filter Database"><i class="fa fa-users text-red"></i> Enter All Database Access</a></li>--->
    </ul>
  </li>
<?php
}
?>