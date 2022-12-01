<!-- Notifications: style can be found in dropdown.less -->
<?php
$oData = json_decode($o_extra['o_info'], TRUE);
if (count($oData['sDb']) === 1)
  return;
else {
?>
  <li class="dropdown notifications-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
      <i class="fa fa-bell-o"></i>
      <span class="label label-danger"><?php print count($oData['sDb']); ?></span>
    </a>
    <ul class="dropdown-menu">
      <li class="header">Dear <b><?php print $oData['sInfo']['sRealName']; ?></b> You are Granted <b><?php print count($oData['sDb']); ?></b> Databases Access. To Use Antoher Database Session, Please Click Once in Below the List.</li>
      <li>
        <!-- inner menu: contains the actual data -->
        <ul class="menu">
          <?php
          foreach ($oData['sDb'] as $row) {
            print "<li><a href=\"" . site_url() . "c_core_user_menu/gf_change_database/" . trim($row['nUnitId_fk']) . "\" title=\"Click Here to Enter Database: " . trim($row['sUnitName']) . "\"><i class=\"fa fa-database fa-1x\"></i>" . ((intval($row['nUnitId_fk']) === intval($this->session->userdata('nUnitId_fk'))) ? "<b class=\"text-red\">" : "") . "" . trim($row['sUnitName']) . "" . ((intval($row['nUnitId_fk']) === intval($this->session->userdata('nUnitId_fk'))) ? "</b>" : "") . "</a></li>";
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