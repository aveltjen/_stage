<?php session_start(); define("IN_SITE", true); define('EUR',chr(128)); $root = $_SERVER['DOCUMENT_ROOT'];
	//require('../html2pdf/html2pdf.class.php');
	require("../../PEAR/MDB2.php");
	require("../../PEAR/HTMLTemplate/IT.php");
	require("../../inc/db.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/users.da.inc.php");
	
		//$ebits = ini_get('error_reporting');
//error_reporting($ebits ^ E_NOTICE);
//*********Check user session***************	
	if(!isset($_SESSION["user"])){
		header("Location: ../../index.php");
		exit;
	}else{
		$user = $_SESSION["user"];	
	}
	
	//*********Template modifications***************
	$tpl = new HTML_Template_IT("./");
	$tpl->loadTemplatefile("oplevering.tpl.php");

//WERF ID GETTEN
$werf = $_REQUEST["werven_ID"];
$tpl->setVariable("title","supervisie");
$tpl->setVariable("id",$werf);

//werf ophalen
	$werfdata = GetWerfByWerfID($werf);
		
	$werfnr = $werfdata["nummer"];
	$toezichterid = $werfdata["iduser"];
	$project = "".$werfdata["nummer"]." ".$werfdata["omschrijving"]."";	
	$tpl->setVariable("project",$project);
	
// 	//** Profiel ophalen
	$user			= $_SESSION["user"];
	$userId			= $user["id"];
	
	$toezichterdata = getUserById($toezichterid);
	
	$tpl->setVariable("toezichter","".$toezichterdata["voornaam"]." ".$toezichterdata["naam"]."");
	$tpl->setVariable("user",$toezichterid);
	
		
//OPMETINGEN OPHALEN EN OPBOUWEN
//ALLE OPMETINGEN OPHALEN

$tpl->setCurrentBlock("opmetingen");
// $posten = $db->query("SELECT v_opmetingen_werf_".$werf.".IDmeetstaat, v_meetstaat_werf_".$werf.".nummer, v_meetstaat_werf_".$werf.".omschrijving, v_meetstaat_werf_".$werf.".eenheden, v_meetstaat_werf_".$werf.".voorziene_hv, v_meetstaat_werf_".$werf.".prijs FROM v_opmetingen_werf_".$werf." INNER JOIN v_meetstaat_werf_".$werf." ON v_opmetingen_werf_".$werf.".IDmeetstaat=v_meetstaat_werf_".$werf.".ID ORDER BY ID");
$posten = $db->query("SELECT DISTINCT v_opmetingen_werf_".$werf.".IDmeetstaat, v_meetstaat_werf_".$werf.".nummer, v_meetstaat_werf_".$werf.".eenheden, v_meetstaat_werf_".$werf.".voorziene_HV, v_meetstaat_werf_".$werf.".prijs, v_meetstaat_werf_".$werf.".omschrijving FROM v_opmetingen_werf_".$werf." INNER JOIN v_meetstaat_werf_".$werf." ON v_opmetingen_werf_".$werf.".IDmeetstaat=v_meetstaat_werf_".$werf.".ID");
$totaalbedrag = 0;
while($post = $posten->fetchrow(MDB2_FETCHMODE_ASSOC)){

	
//POST GEGEVENS OPHALEN	
//MEETSTAAT ID
$msID = $post["idmeetstaat"];	

$description = GetExtraInfoPost($msID,$werf);

//print_r($description);
//$row="<b>...</b><br>";
if(!empty($description))
{
	foreach($description as $value)
	{
		if($value != ""){
			$row = "".$value."<br>";
			
		}
		
	}
	
}

//$row = "".$description[0]."<br>".$description[1]."<br>".$description[2]."<br>".$description[3]."<br>".$description[3]."";

$tpl->setVariable("nummer",$post["nummer"]);
$tpl->setVariable("omschrijving","<b>...<br>".wordwrap($row."</b><br>".$post["omschrijving"],85,"<br />\n")."");
$tpl->setVariable("eenheden",$post["eenheden"]);
$tpl->setVariable("VH",number_format($post["voorziene_hv"],'3',',',' '));
$tpl->setVariable("eprijs",number_format($post["prijs"],'2',',',' '));
$tpl->setVariable("eur","".EUR."");

		//Load data
			$opgemeten= 0;
			$opmetingen2 = $db->query("SELECT * FROM v_opmetingen_werf_".$werf." WHERE IDmeetstaat='$msID'");
				$tpl->setCurrentBlock("opmeting");
				while($opmeting2 = $opmetingen2->fetchrow(MDB2_FETCHMODE_ASSOC)){
					
					if($opmeting2["bijlage1"]==""){
						$uitgevoerd = $opmeting2["uitgevoerd"];
						$berekening = wordwrap($opmeting2["berekening"], 55, "\n", true);
						$link ="";
						
						$tpl->setVariable("berekening",$berekening);
						$tpl->setVariable("uitgevoerd",number_format($uitgevoerd,'3',',',' '));
						$tpl->setVariable("link",$link);
					}else{
						$uitgevoerd = $opmeting2["uitgevoerd"];
						$berekening = wordwrap($opmeting2["berekening"], 55, "\n", true);
						$link = "<a href='../../../files_dir/uploads/opmetingen".$toezichterid."/".$opmeting2["bijlage1"]."' target='blank'>download<a/>";
						
						$tpl->setVariable("berekening",$berekening);
						$tpl->setVariable("uitgevoerd",number_format($uitgevoerd,'3',',',' '));
						$tpl->setVariable("link",$link);
					
					}
					$opgemeten = $opgemeten + $uitgevoerd;
				$tpl->parse("opmeting");		
				}
																											
																													
				//BEREKEN GEMETEN en HV PRIJS
				$eprijs = $post["prijs"];
				$prijs = $eprijs*$opgemeten;
				$tpl->setVariable("topgemeten",number_format($opgemeten,'3',',',' '));
				$tpl->setVariable("popgemeten","".EUR." ".number_format($prijs, 2, ',', ' ')."");
				
				$totaalbedrag = $totaalbedrag + $prijs;
		  
		     			
$tpl->parse("opmetingen");		   
}

// AANBESTEDING
		   $posten = $db->query("SELECT voorziene_hv, prijs FROM v_meetstaat_werf_".$werf." WHERE nummer NOT LIKE 'V%'");

					$vtotaal2 = 0;
					while($post = $posten->fetchrow(MDB2_FETCHMODE_ASSOC)){
						$vh = $post["voorziene_hv"];
						$eprijs = $post["prijs"];

						$prijs = $vh*$eprijs;

						$vtotaal2 = $vtotaal2 + $prijs;
					}

$tpl->setVariable("totaal","".EUR." ".number_format($totaalbedrag, 2, ',', ' ')."");
$tpl->setVariable("vtotaal","".EUR." ".number_format($vtotaal2, 2, ',', ' ')."");

//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet

?>
