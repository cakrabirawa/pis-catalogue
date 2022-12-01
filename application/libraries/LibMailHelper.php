<?php
/*
----------------------------------------------------
Apps Name: Core Apps Library Module
Apps Author: Edwar Rinaldo a.k.a Ado 
Apps Year: 2018
----------------------------------------------------
*/class libMailHelper
{
	protected $c = null;
	protected $CI = null;
	public function __construct()
	{
		$CI = & get_instance();
		$CI->load->library(array('libMailEngine', 'libMailPOP3Engine', 'libMailSMTPEngine'));
		
		$this->c 							= new libMailEngine();
		$this->c->isSMTP();                           // Set mailer to use SMTP
		$this->c->Host 				= '10.12.30.10';  			// Specify main and backup SMTP servers
		$this->c->SMTPAuth 		= true;                 // Enable SMTP authentication
		$this->c->Username 		= 'info@gramedia.id';   // SMTP username
		$this->c->Password 		= 'marcomm2017';        // SMTP password
		$this->c->SMTPSecure 	= '';                   // Enable TLS encryption, `ssl` also accepted
		$this->c->Port 				= 587;    							// TCP port to connect to
		$this->c->isHTML(true);                       
	}
	
	public function gf_set_from($sFrom=null)
	{
		$this->c->setFrom(trim($sFrom['sEmailFrom']), trim($sFrom['sEmailName']));
	}
	
	public function gf_set_recipient($sRecipient=null)
	{
		foreach($sRecipient as $s)
		{
			$this->c->addAddress(trim($s['sEmailRecipient']), (trim($s['sEmailRecipientName']) == "" ? "" : trim($s['sEmailRecipientName'])));
		}
	}
	
	public function gf_set_cc($sCC=null)
	{
		foreach($sCC as $r)
			$this->c->addCC(trim($r));
	}
	
	public function gf_set_bcc($sBCC=null)
	{
		foreach($sBCC as $r)
			$this->c->addBCC(trim($r));
	}
	
	public function gf_set_attach($sAttach=null)
	{
		foreach($sAttach as $r)
			$this->c->addAttachment(trim($r));
	}
	
	public function gf_set_subject($sSubject=null)
	{
		$this->c->Subject = $sSubject;
	}
	
	public function gf_set_body($sBody=null)
	{
		$this->c->Body = $sBody;
	}
	
	public function gf_send()
	{
		return $this->c->send();
	}
}