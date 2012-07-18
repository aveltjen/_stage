<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require_once "../../PEAR/HTTP/Upload.php";
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/functions.inc.php");

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
	$tpl->loadTemplatefile("editwerf.tpl.php");
	
	
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	//** Profiel ophalen
	$userid			= $user["id"];
	$profile 	= GetUserById($userid);
	
	$tpl->setVariable("Name","".$profile["voornaam"]." ".$profile["naam"]."");
	
	//GET WERF
	$id = $_REQUEST["WerfID"];
	
	//VARIABELE WERF CORRECT UPGELOAD!!!
	$bevestigd = "
	
	<table width='100%' border='0' class='tekstnormal' bgcolor='#fae3e3'>
	<tr>
	<td align='center' colspan='2'><img src='images/tick.png' > De werf is correct gewijzigd!</td>
	</tr>
	</table>
	<br>
	
	";
	
	//** Werf wijzigen
	if($_REQUEST["action"]=="editwerf"){
		
		$nummer = $_REQUEST["Number"];
		$omschrijving = $_REQUEST["Description"];
		$startdatum = $_REQUEST["Date"];
		$id = $_REQUEST["WerfID"];
		
		editWerf($id,$nummer,$omschrijving,$startdatum);
		$tpl->setVariable("txt_bevestigd",$bevestigd);
	}	
	
	$tpl->setVariable("titel","");
	
	//** Werf openen
	
		$werf = GetWerfByWerfID($id);
		
		$tpl->setVariable("Nummer",$werf["nummer"]);
		$tpl->setVariable("Description",$werf["omschrijving"]);
		$tpl->setVariable("Date",$werf["startdatum"]);
		$tpl->setVariable("WerfID",$id);
		

		
	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>