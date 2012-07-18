<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/DB.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
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
	
	//$werf = $_REQUEST["werf"];
	
	//*********Template modifications***************
	$tpl = new HTML_Template_IT("./");
	$tpl->loadTemplatefile("vorderingen_maand_print.tpl.php");
	
	
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	//** Profiel ophalen
	$id			= $user["ID"];
	$profile 	= GetUserById($id);
	
		$tpl->setVariable("Name","".$profile["voornaam"]." ".$profile["naam"]."");
		
	$tpl->setVariable("titel","");
	$tpl->setVariable("werf",$_REQUEST["werf"]);
	

		
		$WerfID = $_REQUEST["werf"];
		$request = $_REQUEST["periode"];
		
		//werf ophalen
		$werf = GetWerfByWerfID($WerfID);
		
		$tpl->setVariable("project","".$werf["Number"]." ".$werf["Description"]."");	
		
		$b = explode("-",$request);
		$periode = "".$b[0]."-".$b[1]."";
		$vsnum = $b[2];
		$periode_txt = $b[3];
		
		$c = mktime(0,0,0,$b[0],0,$b[1]);
		
		$tpl->setVariable("periode",$periode_txt);	
		$tpl->setVariable("vsnum",$vsnum);	
		
		//1#POSTEN DIE IN DE PERIODE GEVORDER ZIJN EERST OPZOEKEN
		$posten = GetPostByPeriode($periode,$WerfID);
		
		$tpl->setCurrentBlock("posten");
		while($post = $posten->fetchrow(DB_FETCHMODE_ASSOC)){
			//2#POSTEN ID AFDRUKKEN IN CEL 1	
			$tpl->setVariable("icon","<img src='images/arrow-curve-000-left.png'>");
			
			$msID = $post["vorderingen_meetstaat_ID"];
			
			$postnummer = GetPostByID($msID, $WerfID);
			$tpl->setVariable("msNummer",$postnummer["nummer"]);	
			
			
			
			//3#VORIGE HOEVEELHEID OPZOEKEN
			$resultaat = GetAllVorigeVorderingenByPeriode($msID,$periode,$WerfID);
			$vorige= 0;
			while($res = $resultaat->fetchrow(DB_FETCHMODE_ASSOC)){
				$uitgevoerd = $res["vorderingen_uitgevoerd"];
			
				$vorige = $vorige + $uitgevoerd;	
			}
			$tpl->setVariable("vorige",$vorige);
			
			//4#hUIDIGE HOEVEELHEID VAN DE POST OPZOEKEN
			$resultaat = GetAllVorderingenByPeriode($msID,$periode,$WerfID);
			$huidige = 0;
			while($res = $resultaat->fetchrow(DB_FETCHMODE_ASSOC)){
				$uitgevoerd = $res["vorderingen_uitgevoerd"];
			
				$huidige = $huidige + $uitgevoerd;	
			}
			$tpl->setVariable("huidige",$huidige);
			
			//5#TOTAAL GEVORDERDE HOEVEELHEID
			$totaal = $huidige + $vorige;
			$tpl->setVariable("totaal",$totaal);
			
			$tpl->parseCurrentBlock();
		}
		
		
		
			
	

	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>