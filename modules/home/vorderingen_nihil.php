<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require_once "../../PEAR/HTTP/Upload.php";
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/vorderingen.da.inc.php");
	$ebits = ini_get('error_reporting');
error_reporting($ebits ^ E_NOTICE);

	
	//*********Template modifications***************
	$tpl = new HTML_Template_IT("./");
	$tpl->loadTemplatefile("vorderingen_nihil.tpl.php");
	
	
	//*******Template specific code*************
	

	//** Werf ophalen
	$werf = $_REQUEST["werf"];
	
	
	$werfdata = GetWerfByWerfID($werf);
	$tpl->setVariable("description",$werfdata["Description"]);
	$tpl->setVariable("id",$werfdata["id"]);
	
	//** Vorderingsstaat ophalen
	$vslist = GetFullVorderingsstaatByWerfNihil($werf);
	
	$tpl->setCurrentBlock("vslist");
	while($vs = $vslist->fetchrow(MDB2_FETCHMODE_ASSOC)){
		
			$tpl->setVariable("nummer",$vs["nummer"]);
			$tpl->setVariable("omschrijving",$vs["omschrijving"]);
			$tpl->setVariable("VHTP",$vs["vh_tb"]);
			$tpl->setVariable("eenheden",$vs["eenheden"]);
			$tpl->setVariable("voorzien",number_format($vs["voorziene_hv"],'3',',',' '));
			$tpl->setVariable("eenheidsprijs",number_format($vs["prijs"],'3',',',' '));
			$tpl->setVariable("historiek","<input type='checkbox'>");
			$tpl->setVariable("class","drukrows");
			$tpl->setVariable("gevorderd","<font color='red'>".number_format($vs["totgevorderd"],'3',',',' ')."</font>");
			
			$tpl->parseCurrentBlock();
			
	}

	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>