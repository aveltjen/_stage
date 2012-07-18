<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	include_once("../filemanager/class/FileManager.php");
	
	$ebits = ini_get('error_reporting');
error_reporting($ebits ^ E_NOTICE);
	//*********Check user session***************	
	if(!isset($_SESSION["user"])){
		header("Location: ../../index.php");
		exit;
	}else{
		$user = $_SESSION["user"];	
	}
	//*********WerfID ophalen***************
	 if(!session_id()) session_start();

    header('Cache-control: private, no-cache, must-revalidate');
    header('Expires: 0');
	
	//*********Template modifications***************
	$tpl = new HTML_Template_IT("./");
	$tpl->loadTemplatefile("werfdocumenten.tpl.php");
	
	
	//*******Template specific code*************
	//** user ophalen
	$id	= $user["id"];
	
	//**WERF OPHALEN
	$werfid = $_REQUEST["werf"];
	$werfdata = GetWerfByWerfID($werfid);
	$werfnummer = $werfdata["nummer"];
	
	
// 	$FileManager = new FileManager("/var/www/html/users/supervisie/modules/filemanager/root/".$id."/w".$werf."");
	$FileManager = new FileManager("".$_SERVER['DOCUMENT_ROOT']."/files_dir/root/".$werfnummer."_rootfolder");
   
	$tpl->setVariable("filemanager",$FileManager->create());
		
	$tpl->setVariable("titel","");
	
	

	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>