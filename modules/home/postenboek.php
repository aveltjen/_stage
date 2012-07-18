<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/DB.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require_once "../../PEAR/HTTP/Upload.php";
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	

$ebits = ini_get('error_reporting');
error_reporting($ebits ^ E_NOTICE);
	//*********Check user session***************	
	if(!isset($_SESSION["user"])){
		header("Location: ../../index.php");
		exit;
	}else{
		$user = $_SESSION["user"];	
	}
	
	//*********Template modifications***************
	$tpl = new HTML_Template_IT("./");
	$tpl->loadTemplatefile("postenboek.tpl.php");
	
	
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	
	$tpl->setVariable("titel","");
	
	
	//** Profiel ophalen
	$id			= $user["ID"];
	$profile 	= GetUserById($id);
	
		$tpl->setVariable("Name","".$profile["voornaam"]." ".$profile["naam"]."");

	//** Werf ophalen
	$WerfID = $_REQUEST["werf"];
	
	$werf = GetWerfByWerfID($WerfID);
	$tpl->setVariable("description",$werf["Description"]);
	$tpl->setVariable("id",$werf["ID"]);
	
	//** Vorderingsstaat ophalen
	$vslist = GetFullVorderingsstaatByWerf($WerfID);
	
	$tpl->setCurrentBlock("vslist");
	while($vs = $vslist->fetchrow(DB_FETCHMODE_ASSOC)){
		if($vs["nummer"]==""){
			
			$tpl->setVariable("nummer","&nbsp;");
			$tpl->setVariable("omschrijving",$vs["omschrijving"]);
			$tpl->setVariable("VHTP","&nbsp;");
			$tpl->setVariable("eenheden","&nbsp;");
			$tpl->setVariable("voorzien","&nbsp;");
			$tpl->setVariable("gevorderd","&nbsp;");
			$tpl->setVariable("opmeten","&nbsp;");
			$tpl->setVariable("historiek","&nbsp;");
			$tpl->setVariable("class","novs");
	
		}else{
			$tpl->setVariable("nummer",$vs["nummer"]);
			$tpl->setVariable("omschrijving",$vs["omschrijving"]);
			$tpl->setVariable("VHTP",$vs["VH_TB"]);
			$tpl->setVariable("eenheden",$vs["eenheden"]);
			$tpl->setVariable("voorzien",$vs["voorziene_HV"]);
			$tpl->setVariable("gevorderd","0");
			$tpl->setVariable("opmeten","<img src='images/opmeten.gif'>");
			$tpl->setVariable("historiek","<input type='checkbox'>");
			$tpl->setVariable("class","vs");
		}
		
		$tpl->parseCurrentBlock();
	}

	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>