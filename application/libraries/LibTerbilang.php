<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
class libTerbilang
{
	function gfConvert($x=0)
	{
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $result = "";
    if ($x <12)
	    $result = " ". $angka[$x];
    else if ($x <20)
      $result =$this->gfConvert($x - 10). " belas";
    else if ($x <100)
    	$result =$this->gfConvert($x/10)." puluh".$this->gfConvert($x % 10);
    else if ($x <200)
    	$result = " seratus" .$this->gfConvert($x - 100);
    else if ($x <1000)
    	$result =$this->gfConvert($x/100) . " ratus" .$this->gfConvert($x % 100);
    else if ($x <2000)
    	$result = " seribu" .$this->gfConvert($x - 1000);
    else if ($x <1000000)
    	$result =$this->gfConvert($x/1000) . " ribu" .$this->gfConvert($x % 1000);
		else if ($x <1000000000)
			$result =$this->gfConvert($x/1000000) . " juta" .$this->gfConvert($x % 1000000);
    else if ($x <1000000000000)
    	$result =$this->gfConvert($x/1000000000) . " milyar" .$this->gfConvert(fmod($x,1000000000));
    else if ($x <1000000000000000)
    	$result =$this->gfConvert($x/1000000000000) . " trilyun" .$this->gfConvert(fmod($x,1000000000000));
	   return $result;
	}	
	
	function gfRenderTerbilang($x, $style=3)
	{
		$poin = null;
    if($x < 0)
      $hasil = "minus ". trim($this->gfConvert($x));
    else
    {
      $poin = trim($this->tkoma($x));
      $hasil = trim($this->gfConvert($x));
     }
    switch ($style)
    {
      case 1: 
      	if($poin)
      		$hasil = strtoupper($hasil)." KOMA ".strtoupper($poin);
      	else
	      	$hasil  = strtoupper($hasil); break;
      case 2: 
	    	if($poin)
		  		$hasil = strtolower($hasil)." KOMA ".strtolower($poin);
      	else
	      	$hasil  = strtolower($hasil); break;
      case 3: 
	    	if($poin)
			 		$hasil = ucwords($hasil)." Koma ".ucwords($poin);
			 	else
			   	$hasil  = ucwords($hasil); break;
		  case 4: 
		  	if($poin)
			 		$hasil = ucfirst($hasil)." koma ".ucfirst($poin);
			 	else
			  	$hasil = ucfirst($hasil); break;
    }      
    return $hasil;
	}
	
	function tkoma($x)
	{
		$x = stristr($x, ".");
		$angka = array(
										"nol", 
										"satu", 
										"dua", 
										"tiga", 
										"empat", 
										"lima", 
										"enam", 
										"tujuh", 
										"delapan", 
										"sembilan");
		$temp = " ";
		$pjg = strlen($x);
		$pos = 1;
		while($pos < $pjg)
		{
			$char = substr($x, $pos, 1);
			$pos++;
			$temp .= " ".$angka[$char];
		}
		return $temp;
	}
}