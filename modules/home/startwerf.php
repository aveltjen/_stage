<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");

	// $ebits = ini_get('error_reporting');
	// error_reporting($ebits ^ E_NOTICE);
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
	$tpl->loadTemplatefile("startwerf.tpl.php");
	
	//DEEL2 FRAME BUILDING-------------------------------------------------------------------------------------------
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	//** Profiel ophalen
	$id			= $user["id"];
	$group		= $user["idgroep"];
	$WerfID = $_REQUEST["werf"];
	
	//toezichter ophalen
	$toezichterid = GetToezichterByWerf($WerfID);
	$toezichterdata = getUserById($toezichterid["iduser"]);
	
	
	
	$tpl->setVariable("Name","".$user["voornaam"]." ".$user["naam"]."");
	$GroupId = $user["idgroep"];
	//lezer
	If($GroupId==3){
		$tpl->setVariable("Toezichter","(toezichter: ".$toezichterdata["voornaam"]." ".$toezichterdata["naam"].")");
	}else{
		$tpl->setVariable("Toezichter","");	
	}	
	$tpl->setVariable("titel","");
	$tpl->setVariable("user",$id);
	
	//DEEL2 POSTENBOEK CONTENT-------------------------------------------------------------------------------------------
	

	//** Werf ophalen
	
	$werf = GetWerfByWerfID($WerfID);
	$werf_omschrijving = $werf["omschrijving"];
	$string = substr($werf_omschrijving,0,60).'...';
	$tpl->setVariable("description",$string);
	$tpl->setVariable("id",$werf["id"]);
	
	
	
	
	//** Vorderingsstaat ophalen
	$vslist = GetFullVorderingsstaatByWerf($WerfID);
	
	$tpl->setCurrentBlock("vslist");
	while($vs = $vslist->fetchrow(MDB2_FETCHMODE_ASSOC)){

		if($vs["nummer"] != "" AND $vs["voorziene_hv"] != ""){
			
			if($vs["vh_tb"] == "" AND $vs["eenheden"] == "")
			{
				$tpl->setVariable("nummer","");
				$tpl->setVariable("omschrijving",wordwrap($vs["omschrijving"], 20, "\n", true));
				$tpl->setVariable("VHTP","&nbsp;");
				$tpl->setVariable("eenheden","&nbsp;");
				
				if($vs["voorziene_hv"]==0){
					$tpl->setVariable("voorzien","&nbsp;");
				}else{
					$tpl->setVariable("voorzien",$vs["voorziene_hv"]);
				}
				
				$tpl->setVariable("eenheidsprijs","&nbsp;");
				$tpl->setVariable("gevorderd","&nbsp;");
				$tpl->setVariable("opmeten","&nbsp;");
				$tpl->setVariable("historiek","&nbsp;");
				$tpl->setVariable("class","novs");
					
			}else{
				$tpl->setVariable("nummer",$vs["nummer"]);
				$tpl->setVariable("omschrijving",wordwrap($vs["omschrijving"], 20, "\n", true));
				$tpl->setVariable("VHTP",$vs["vh_tb"]);
				$tpl->setVariable("eenheden",$vs["eenheden"]);
				$voorzien = $vs["voorziene_hv"];
							if ($voorzien != "0") {
								$tpl->setVariable("voorzien",number_format($voorzien,3,',',''));
							} else {
								$tpl->setVariable("voorzien","");
							}
				//$tpl->setVariable("voorzien",$voorzien);
				$tpl->setVariable("eenheidsprijs",number_format($vs["prijs"],2,',',''));
				$tpl->setVariable("historiek","<input type='checkbox' name='selecteren[]' value='".$vs["id"]."'>");
				
				if($group == "3"){
					$tpl->setVariable("vorderen","");
					$tpl->setVariable("opmeten","");
				}else{
					$tpl->setVariable("vorderen","<a href='vorderen.php?msID=".$vs["id"]."&werf=".$WerfID."' onclick=\"return parent.GB_showCenter2('Supervisie - Vorderen', this.href)\"><img src='images/book--plus.png'></a>");
					$tpl->setVariable("opmeten","<a href='opmeten.php?msID=".$vs["id"]."&werf=".$WerfID."' onclick=\"return parent.GB_showCenter2('Supervisie - Opmeten', this.href)\"><img src='images/ruler--plus.png'></a>");
				
				}
				
				$tpl->setVariable("class","vs");
				
				//VORDERINGEN OPHALEN
					$gh = $vs["totgevorderd"];		
					
							
							if ($gh != "0" AND $gh !== NULL) {
								$tpl->setVariable("gevorderd",number_format($gh,3,',',''));
							} else {
								if ($gh === NULL){
									$tpl->setVariable("gevorderd","");
								}else{
									$tpl->setVariable("gevorderd",number_format($gh,3,',',''));
								}
								
							}
	
				
				
				//OPMETINGEN OPHALEN
					$oh = $vs["totopgemeten"];		
					
							if ($oh != "0" AND $oh !== NULL) {
								$tpl->setVariable("opgemeten",number_format($oh,3,',',''));
							} else {
								if ($oh === NULL){
									$tpl->setVariable("opgemeten","");
								}else{
									$tpl->setVariable("opgemeten",number_format($oh,3,',',''));
								}
								
							}
							
			}
		}else{
			
			$tpl->setVariable("nummer","");
			$tpl->setVariable("omschrijving",wordwrap($vs["omschrijving"], 20, "\n", true));

			$tpl->setVariable("VHTP","&nbsp;");
			$tpl->setVariable("eenheden","&nbsp;");
			
			if($vs["voorziene_hv"]==0){
				$tpl->setVariable("voorzien","&nbsp;");
			}else{
				$tpl->setVariable("voorzien",$vs["voorziene_hv"]);
			}
			
			$tpl->setVariable("eenheidsprijs","&nbsp;");
			$tpl->setVariable("gevorderd","&nbsp;");
			$tpl->setVariable("opmeten","&nbsp;");
			$tpl->setVariable("historiek","&nbsp;");
			$tpl->setVariable("class","novs");
			
		}
		
		$tpl->parseCurrentBlock();
	}
	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>
