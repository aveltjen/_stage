<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/vorderingen.da.inc.php");

	$ebits = ini_get('error_reporting');
	//error_reporting($ebits ^ E_NOTICE);
	//*********Check user session***************	
	if(!isset($_SESSION["user"])){
		header("Location: ../../index.php");
		exit;
	}else{
		$user = $_SESSION["user"];	
	}
	//*********WerfID ophalen***************
	
	//$werf = $_REQUEST["werf"];
	
	//*********Template modifications***************
	$tpl = new HTML_Template_IT("./");
	$tpl->loadTemplatefile("vorderingen.tpl.php");
	
	
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	//** Profiel ophalen
	$id			= $user["id"];
	
		
	$tpl->setVariable("titel","");
	
	//**WERF OPHALEN
	$tpl->setVariable("werfID",$_REQUEST["werf"]);

	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>