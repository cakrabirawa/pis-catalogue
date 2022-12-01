<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['ConMaxFileSize'] 										 = 10000000 * 1024 * 1024; //byte
$config['ConChunkSize'] 	 										 = 10000000; //byte
$config['ConAppName'] 	 											 = " E-Filing Apps";
$config['ConAppNameShort'] 	 									 = "<b>A</b>LT";
$config['ConLimitMultiFileUploadSizeOverhead'] = 512;
$config['ConAppsTitle'] 	 										 = $config['ConAppName']." - © 2016 - ".date('Y')." Edwar Rinaldo";
$config['ConUnknowUserImage'] 	 							 = "unknown.png";
$config['ConPageShowCount'] 	 								 = 9;
$config['ConSpace'] 	 												 = 300; // In Mega Byte
$config['ConLimitFileName'] 	 								 = 30; 
$config['ConLimitFileNamePerRow'] 	 					 = 6; 
$config['ConUnkwonUserImage'] 	 							 = "unknown.png"; 
$config['ConTitleLogin'] 	 										 = "<!--<i class=\"fa fa-cog fa-spin fa-1x fa-fw\"></i>--><b>".$config['ConAppName']."</b> Login"; 
$config['ConTitleRegisterLogin']               = "<b>".$config['ConAppName']."</b> Register"; 
$config['ConTitleForgotLogin']                 = "<b>".$config['ConAppName']."</b> Forgot Password"; 
$config['ConTitleFooter'] 	 									 = "<b>".$config['ConAppName']."</b> ©2016 Edwar Rinaldo<br />All Right Reserved"; 
$config['ConTitleFooterBottom'] 	 						 = "<strong>Copyright © ".date('Y')." <a href=\"".$this->site_url()."\">".$config['ConAppName']."</a><strong> Edwar Rinaldo All rights reserved.";
$config['ConDeleteFileInFolderLimit']          = 10;
$config['ConFontsReportDir']                   = getcwd().DIRECTORY_SEPARATOR."plugins".DIRECTORY_SEPARATOR."dist".DIRECTORY_SEPARATOR."fonts".DIRECTORY_SEPARATOR;
