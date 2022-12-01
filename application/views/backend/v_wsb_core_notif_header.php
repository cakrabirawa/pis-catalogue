<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
  <!-- Sidebar toggle button-->
  <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a>
  <div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
      <?php //$this->load->view('backend/v_wsb_core_notif_01'); 
      ?>
      <?php //$this->load->view('backend/v_wsb_core_notif_02'); 
      ?>
      <?php //$this->load->view('backend/v_wsb_core_notif_03'); 
      ?>
      <?php $this->load->view('backend/v_wsb_core_notif_07'); ?>
      <?php $this->load->view('backend/v_wsb_core_notif_05'); ?>
      <?php
      //if (intval($this->session->userdata('nGroupUserId_fk')) === 0)
        $this->load->view('backend/v_wsb_core_notif_06');
      ?>
      <?php //$this->load->view('backend/v_wsb_core_notif_04'); 
      ?>
      <!-- Control Sidebar Toggle Button -->
      <!--<li>
        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
      </li>-->
      &nbsp;
    </ul>
  </div>
</nav>