<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado (ado[at]gramedia[dot]com)
Apps Year: 2018
----------------------------------------------------
*/
class m_core_global extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
  }
  public function gfLoadMenu()
  {
    //$sql = "select * from tm_MenuAplikasi where nMenuId = 2 /*Master*/";
    //$rs = $this->db->query($sql);	  	
    return ""; //json_encode($rs->result_array());
  }
  public function gf_load_email()
  {
    $sql = "select distinct sEmail from tm_emails order by 1";
    $rs = $this->db->query($sql);
    return json_encode($rs->result_array());
  }
  public function gf_unique_id()
  {
    return md5(date('Y-m-d H:i:s'));
  }
  public function gf_random($nNum = 20)
  {
    $Caracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
    $QuantidadeCaracteres = strlen($Caracteres);
    $QuantidadeCaracteres--;
    $Hash = NULL;
    for ($x = 1; $x <= $nNum; $x++) {
      $Posicao = rand(0, $QuantidadeCaracteres);
      $Hash .= substr($Caracteres, $Posicao, 1);
    }
    return $Hash;
  }
  function gf_conv_size($bytes, $decimals = 2)
  {
    $size = array(' B', ' KB', ' MB', ' GB', ' TB', ' PB', ' EB', ' ZB', ' YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
  }
}
