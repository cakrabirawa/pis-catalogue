<?php
	$this->load->view('backend/v_core_header');
	if(in_array($o_page, array("backend/v_core_forgot_password", "backend/v_core_registration", "backend/v_gbox_download", "backend/v_core_login")))
	{
		$this->load->view($o_page);
		return false;
	}
	$this->load->view('backend/v_wsb_core_content');
