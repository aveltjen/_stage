<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/vorderingen.da.inc.php");

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
	
	//$werf = $_REQUEST["werf"];
	
	//*********Template modifications***************
	$tpl = new HTML_Template_IT("./");
	$tpl->loadTemplatefile("vorderingen_historiek.tpl.php");
	
	
	//*******Template specific code*************
	//**Als er geen post geslecteerd is
	
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	//** Profiel ophalen
	$id			= $user["id"];
	$werf = $_REQUEST["werf"];
		
	$tpl->setVariable("titel","");
	$tpl->setVariable("WerfID",$werf);
	
	
	
	//GESELCTEERDE VORDERINGEN DRUKKEN
	if (isset($_REQUEST["selecteren"])) {
		
		$tpl->setCurrentBlock("posten");
		foreach ($_REQUEST["selecteren"] as $msID){

			//postgegevens
			$post = GetPostByID($msID, $werf);
			
			$nummer = $post["nummer"];
			$omschrijving = $post["omschrijving"];
			$eenheden = $post["eenheden"];
			$hoeveelheid = $post["voorziene_hv"];
			
			$tpl->setVariable("postlegend","Postnr. ".$nummer.":");
			$tpl->setVariable("omschrijving","$omschrijving");
			$tpl->setVariable("eenheden","$eenheden");
			$tpl->setVariable("hoeveelheid","$hoeveelheid");
			
			//ALLE PERIODES OPZOEKEN
			$vorderingen = GetAllVorderingenDatumByMsID($msID,$werf);
			$vsnummer= 0;
			
			$tpl->setCurrentBlock("perioden");
			while($vordering = $vorderingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
					$vsnummer = $vsnummer + 1;
					$periode = $vordering["vorderingen_m_y"];
					
					$vs = GetVS($periode,$werf);
					
					$tpl->setVariable("periode","$periode");
					$tpl->setVariable("vsnummer","$vs");
						
				$tpl->parse("perioden");
					
			}
			
			$vorderingen2 = GetAllVorderingenDatumByMsID($msID,$werf);
			
			$tpl->setCurrentBlock("hoeveelheden");
			while($vordering2 = $vorderingen2->fetchrow(MDB2_FETCHMODE_ASSOC)){
				
					$periode2 = $vordering2["vorderingen_m_y"];
						
					//TOTAAL van periode
					$totaal = 0;
					$vorderingen3 = GetAllVorderingenByPeriode($msID,$periode2,$werf);
					while($vordering3 = $vorderingen3->fetchrow(MDB2_FETCHMODE_ASSOC)){
						
						$uitgevoerd = $vordering3["uitgevoerd"];
						$totaal = $totaal + $uitgevoerd;
					}
					$tpl->setVariable("uitgevoerd","$totaal");
				$tpl->parse("hoeveelheden");
			}
			
			$tpl->parse("posten");
		}
	}else{
		$tpl->setVariable("fout","<img src='images/exclamation.png'> Geen post geselecteerd! Ga terug en selecteer de gewenste post via het selectievak!");
		$tpl->setVariable("fout_img","<tr><td height='200' colspan='2' align='center'><img src='images/help1.jpg'></td></tr>");
	}
	
	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>