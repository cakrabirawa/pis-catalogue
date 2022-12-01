<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_chart extends CI_Model
{
  var $nUnitId = null;
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_core_apps'));
    $this->nUnitId = $this->session->userdata('nUnitId_fk');
	}
	function gf_chart_orders()
	{
    $return = array();
		$sql = "CALL sp_generate_chart('CHART_ORDER_THIS_WEEK', ".$this->nUnitId.", false, null)";
		$rs = $this->db->query($sql);
		$pivot = $this->gf_pivot($rs);
    array_push($return, $pivot);
    //--------------------------
		$sql = "CALL sp_generate_chart('CHART_ORDER_BY_PRODUCT_CATEGORY_ALL_THIS_WEEK', ".$this->nUnitId.", false, null)";
		$rs = $this->db->query($sql);
		$pivot = $this->gf_pivot($rs);
    array_push($return, $pivot);
    //--------------------------
		$sql = "CALL sp_generate_chart('CHART_TOP_5_PRODUCT_ORDER', ".$this->nUnitId.", false, null)";
		$rs = $this->db->query($sql);
		$pivot = $this->gf_pivot($rs);
    array_push($return, $pivot);
    //--------------------------
		return json_encode($return);
	}
  function gf_pivot($rs)
  {
    if($rs->num_rows() === 0) {
      return array("sFields" => "No Data, 0", "sDatas" => "No Data, 0", "sFieldsX" => "0", "sDatasX" => "0");
      exit(0);
    }
    $sField = "";
		$sFieldX = "";
    $i = 0;
		foreach ($rs->list_fields() as $field) {
			$sField .= $field.",";
      if($i > 0)
        $sFieldX .= $field.",";
      $i++;
    }
		$sField =	substr($sField, 0, strlen($sField) - 1);
		$sFieldX =	substr($sFieldX, 0, strlen($sFieldX) - 1);
		$sData = "";
		$sDataX = "";
		foreach ($rs->result_array() as $row) {
			$sTemp = "";
      $sTempX = "";
      $i = 0;
			foreach ($rs->list_fields() as $field) {
				$sTemp .= trim($row[$field]).",";
        if($i > 0)
          $sTempX .= trim($row[$field]).",";
        $i++;
      }
      $sTemp =	substr($sTemp, 0, strlen($sTemp) - 1);
      $sTempX =	substr($sTempX, 0, strlen($sTempX) - 1);
      $sData .= $sTemp."~";
      $sDataX .= $sTempX."~";
		}
    $sData =	substr($sData, 0, strlen($sData) - 1);
    $sDataX =	substr($sDataX, 0, strlen($sDataX) - 1);
    return array("sFields" => $sField, "sDatas" => $sData, "sFieldsX" => $sFieldX, "sDatasX" => $sDataX);
  }
}