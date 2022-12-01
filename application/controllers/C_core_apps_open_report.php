<?php
/*
------------------------------
Menu Name: Report
File Name: C_core_apps_open_report.php
File Path: D:\Project\PHP\billing\application\controllers\C_core_apps_open_report.php
Create Date Time: 2019-08-25 19:07:59
------------------------------
*/
defined('BASEPATH') or exit('No direct script access allowed');
class c_core_apps_open_report extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$a = new libSession();
		if ($a->gf_check_session())
		redirect("c_core_login");
		else {
			$this->load->model(array('m_core_user_menu', 'm_core_user_login', 'm_core_apps', 'm_core_apps_open_report'));
			$this->load->library(array('libPaging'));
		}
		$this->data['o_page'] = 'backend/v_core_apps_open_report';
		$this->data['o_page_title'] = 'Report';
		$this->data['o_page_desc'] = 'Maintenance Report';
		$this->data['o_data'] 			= null;
		$this->data['o_extra']      = $this->m_core_apps->gf_load_additional_data(array("sMenuCtlName" => "c_core_apps_open_report"));
	}
	public function index()
	{
		$this->data['o_mode'] = "I";
		$this->data['o_listrpt'] = $this->m_core_apps_open_report->gf_load_report_list(0);
		$this->data['o_listor'] = $this->m_core_apps_open_report->gf_load_open_reports();
		$this->load->view($this->data['o_page'] , $this->data); 
	}
	function gf_read_open_reports()
	{
		print $this->m_core_apps_open_report->gf_read_open_reports();
	}
	function gf_execute_query_to_grid()
	{
		print $this->m_core_apps_open_report->gf_execute_query_to_grid();
	}
	function gf_export_excel()
	{
		header("Content-type: application/vnd-ms-excel;charset=utf-8");
		header("Content-Disposition: attachment; filename=".$this->input->post('hideReportName', TRUE)."_".date('d_m_Y_H_i_s').".xls");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		print $this->m_core_apps_open_report->gf_export_excel();
		exit(0);
	}
	function gf_query()
	{
		print $this->m_core_apps_open_report->gf_query();
	}
	function gf_execute_query_to_mrt()
	{
		print $this->m_core_apps_open_report->gf_execute_query_to_mrt();
	}
	function gf_execute_query_to_mrt_clicked()
	{
		print $this->m_core_apps_open_report->gf_execute_query_to_mrt_clicked();
	}
}
