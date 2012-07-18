<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("PEAR/DB.php");
	require_once("PEAR/HTMLTemplate/IT.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/vorderingen.da.inc.php");

	//*********Check user session***************	
	if(!isset($_SESSION["user"])){
		header("Location: ../../index.php");
		exit;
	}else{
		$user = $_SESSION["user"];	
	}
	//*********WerfID ophalen***************
	
	
	//*********Template modifications***************
	$tpl = new HTML_Template_IT("./");
	$tpl->loadTemplatefile("deletevordering.tpl.php");
	
	
	//*******Template specific code*************
		
	$tpl->setVariable("titel","");
	$tpl->setVariable("refresh","");
	$tpl->setVariable("vid",$_REQUEST["vid"]);
	
	if($_REQUEST["action"]== "delete"){
		$vid = $_REQUEST["vid"];
		
		deleteVordering($vid);
		
		$tpl->setVariable("refresh","onload='refreshParent();'");
	}
	
	
	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>