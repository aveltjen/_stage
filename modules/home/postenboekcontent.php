<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/DB.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require_once "../../PEAR/HTTP/Upload.php";
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/vorderingen.da.inc.php");
	require("inc/opmetingen.da.inc.php");
	

	$ebits = ini_get('error_reporting');
error_reporting($ebits ^ E_NOTICE);
	//*********Template modifications***************
	$tpl = new HTML_Template_IT("./");
	$tpl->loadTemplatefile("postenboekcontent.tpl.php");
	
	
	//*******Template specific code*************
	if($_REQUEST["historiek"]=="show"){
		
		foreach ($_REQUEST["selecteren"] as $msID){
			echo $msID;
		}
		
	}
	

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
			
			$tpl->setVariable("nummer",$vs["nummer"]);
			$tpl->setVariable("omschrijving",$vs["omschrijving"]);
			$tpl->setVariable("VHTP","&nbsp;");
			$tpl->setVariable("eenheden","&nbsp;");
			$tpl->setVariable("voorzien",$vs["voorziene_HV"]);
			$tpl->setVariable("eenheidsprijs","&nbsp;");
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
			$tpl->setVariable("eenheidsprijs",$vs["prijs"]);
			$tpl->setVariable("historiek","<input type='checkbox' name='selecteren[]' value='".$vs["ID"]."'>");
			$tpl->setVariable("vorderen","<a href='vorderen.php?msID=".$vs["ID"]."&werf=".$WerfID."' onclick=\"return parent.GB_showCenter2('Supervisie - Vorderen', this.href)\"><img src='images/book--plus.png'></a>");
			$tpl->setVariable("opmeten","<a href='opmeten.php?msID=".$vs["ID"]."&werf=".$WerfID."' onclick=\"return parent.GB_showCenter2('Supervisie - Opmeten', this.href)\"><img src='images/ruler--plus.png'></a>");
			$tpl->setVariable("class","vs");
			
			//VORDERINGEN OPHALEN
				$msID = $vs["meetstaat_ID"];		
				$vorderingen = GetVorderingenByPost($msID);
				$totaal = 0;
					while($vordering = $vorderingen->fetchrow(DB_FETCHMODE_ASSOC)){
	
						$totaal = $totaal + $vordering["vorderingen_uitgevoerd"];
						$tpl->setVariable("gevorderd",$totaal);
					}
			
			//OPMETINGEN OPHALEN
				$msID = $vs["meetstaat_ID"];		
				$opmetingen = GetOpmetingenByPost($msID);
				$totaalO = 0;
					while($opmeting = $opmetingen->fetchrow(DB_FETCHMODE_ASSOC)){
	
						$totaalO = $totaalO + $opmeting["opmetingen_uitgevoerd"];
						$tpl->setVariable("opgemeten",$totaalO);
					}
		}
		
		$tpl->parseCurrentBlock();
	}

	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>