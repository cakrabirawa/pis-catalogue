<?
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class libRptEngine
{
	var $CI = null;
	var	$oDaysName  = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu");
	var	$oMonthName = array("","Januari","Pebruari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
 	var $no = 0;
 	var $c = 0;

	function libRptEngine()
	{
		$this->CI = & get_instance();
		$this->CI->load->library('libTerbilang');
		$this->CI->load->model('m_core_apps');
	}
	function gf_show_variable($name)
	{
  	if(isset($this->data[$name]))
    	print $this->data[$name];
    else
      print "[".$name."]";
  }
  function gf_wrap($element)
  {
  	$this->stack[] = $this->data;
    foreach($element as $k => $v)
	  {
	  	$oPrefix = explode("_", $k);
	  	$oKey = trim($oPrefix[0]);
	  	if($oKey === "nourut")
  		{
  			if(isset($oPrefix[1]))
  			{
  			  if(intval($this->c)!==intval($oPrefix[1]))
    			{
    				if(intval($this->c) === 0)
    				{
    					$this->no = 0;
    					$this->c = $oPrefix[1];
      			}
    				else
    					$this->no = 0;
          }
      	}
    		$this->no++;
  		}

	  	if(strtolower($oKey) === "sess")
	  	{
	  		$oFormat = empty($oPrefix[1]) || trim($oPrefix[1]) === "" ? 0 : intval($oPrefix[1]);
	  		$oSymbol = empty($oPrefix[2]) || trim($oPrefix[2]) === "" ? "" : trim($oPrefix[2]);
	  		$this->data[$k] = $this->CI->session->userdata(trim($oPrefix[1]));
	  	}
	  	else if(strtolower($oKey) === "sessu")
	  	{
	  		$oFormat = empty($oPrefix[1]) || trim($oPrefix[1]) === "" ? 0 : intval($oPrefix[1]);
	  		$oSymbol = empty($oPrefix[2]) || trim($oPrefix[2]) === "" ? "" : trim($oPrefix[2]);
	  		$this->data[$k] = strtoupper($this->CI->session->userdata(trim($oPrefix[1])));
	  	}
	  	else if(strtolower($oKey) === "cur")
	  	{
	  		$oFormat = empty($oPrefix[1]) || trim($oPrefix[1]) === "" ? 0 : intval($oPrefix[1]);
	  		$oSymbol = empty($oPrefix[2]) || trim($oPrefix[2]) === "" ? "" : trim($oPrefix[2]);
	  		$this->data[$k] = $oSymbol.(trim($oSymbol) !== "" ? ". " : "").number_format($v, $oFormat);
	  	}
	  	else if(strtolower($oKey) === "dat")
	  	{
	  		$oFormat = empty($oPrefix[1]) || trim($oPrefix[1]) === "" ? "dMY" : trim($oPrefix[1]);
	  		$this->data[$k] = date($oFormat, $this->gf_date_normalize($v));
	  	}
	  	else if(strtolower($oKey) === "trb")
	  	{
	  		$oSymbol = empty($oPrefix[1]) || trim($oPrefix[1]) === "" ? "" : trim($oPrefix[1]);
	  		$oPos    = empty($oPrefix[2]) || trim($oPrefix[1]) === "" ? "" : trim($oPrefix[2]);
	  		if(trim($oPos) !== "")
	  		{
	  			if(strtolower(trim($oPos)) === "f") //-- Front Stamp
			  		$this->data[$k] = trim($oSymbol)." ".$this->CI->lib_terbilang->gfRenderTerbilang($v);
			  	else if(strtolower(trim($oPos)) === "r") //-- Rear Stamp
			  		$this->data[$k] = $this->CI->lib_terbilang->gfRenderTerbilang($v, 4)." ".trim($oSymbol);
			  }
			  else
			  	$this->data[$k] = $this->CI->lib_terbilang->gfRenderTerbilang($v, 4);
	  	}
	  	else if(strtolower($oKey) === "nowi")
	  		$this->data[$k] = $this->oDaysName[date('N')].", ".date('j')." ".$this->oMonthName[date('n')]." ".date('Y');
	  	else if(strtolower($oKey) === "nowj")
	  		$this->data[$k] = date('j')." ".$this->oMonthName[date('n')]." ".date('Y');
	  	else if(strtolower($oKey) === "nowe")
	  		$this->data[$k] = date('M').", ".date('j')." ".date('Y');
	  	else if(strtolower($oKey) === "nourut")
	  		$this->data[$k] = $this->no;
			else if(strtolower($oKey) === "siteurl")
	  		$this->data[$k] = site_url();
			else if(strtolower($oKey) === "dbname")
	  		$this->data[$k] = $this->CI->db->database;
  		else if(strtolower($oKey) === "enc")
  		{
  			$oResult = json_decode($this->CI->m_core_apps->gf_enc_dec(array("sData" => trim($v), "nSeed" => intval($oPrefix[1]), "sMode" => "ENC")), TRUE);
	  		$this->data[$k] = $oResult['sData'];
	  	}
	  	else if(strtolower($oKey) === "img")
	  	{
	  		$oImgPath = explode("_", $k);
	  		$v = explode(",", $v);
	  		$this->data[$k] = "<img src=\"".site_url()."img/".$v[0]."\" style=\"".trim($v[1])."\" />";
	  	}
	  	else
		  	$this->data[$k] = (trim($v) === "" || is_null($v) ? "" : trim($v));
	  }
  }
  function gf_un_wrap()
  {
    $this->data = array_pop($this->stack);
  }
  function gf_run()
  {
    ob_start();
    eval(func_get_arg(0));
    return ob_get_clean();
  }
  function gf_process($template, $data)
  {
    $this->data = $data;
    $this->stack = array();
    $template = str_replace('<', '<?php echo \'<\'; ?>', $template);
    $template = preg_replace('~\[(\w+)\]~', '<?php $this->gf_show_variable(\'$1\'); ?>', $template);
    $template = preg_replace('~\[RS:(\w+)\]~', '<?php foreach ($this->data[\'$1\'] as $ELEMENT): $this->gf_wrap($ELEMENT); ?>', $template);
    $template = preg_replace('~\[ENDRS:(\w+)\]~', '<?php $this->gf_un_wrap(); endforeach; ?>', $template);
    $template = '?>' . $template;
    return $this->gf_run($template);
  }
  function gf_date_normalize($d)
  {
		if($d instanceof DateTime)
			return $d->getTimestamp();
		else
			return strtotime($d);
	}
}
?>