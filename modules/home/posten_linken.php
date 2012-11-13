<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/link.da.inc.php");

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
	$tpl->loadTemplatefile("posten_linken.tpl.php");
	
	//DEEL2 FRAME BUILDING-------------------------------------------------------------------------------------------
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	//DELETE LINK
	if ($_REQUEST["unlink"]) {
		$linkID = $_REQUEST["unlink"];
		
		DeleteLink($linkID);
	}
			
	//** Profiel ophalen
	$id			= $user["id"];
	$group		= $user["idgroep"];
	$WerfID = $_REQUEST["werf"];
	$tpl->setVariable("WerfID",$WerfID);
	
	//toezichter ophalen
	$toezichterid = GetToezichterByWerf($WerfID);
	$toezichterdata = getUserById($toezichterid["iduser"]);
	
			
	//ADD LINK
			if (isset($_REQUEST["selecteren"])) {
				
				foreach ($_REQUEST["selecteren"] as $msID_link){
					
					$msID_select = $_REQUEST["msID"];
					
					
					InsertLink($WerfID, $msID_select, $msID_link);
				
				}
			}
	
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
	
	//DEEL2 GESELECTEERDE POST OPHALEN------------------------------------------------------------------------------------
	//** Geselecteerde post ophalen
	
	$msID = $_REQUEST["msID"];
	$tpl->setVariable("msID",$msID);
	
	$post = GetPostByID($msID, $WerfID);
	
	$tpl->setVariable("nummer_select",$post["nummer"]);
	$tpl->setVariable("omschrijving_select",$post["omschrijving"]);
	$tpl->setVariable("eenheden_select",$post["eenheden"]);
	$tpl->setVariable("hoeveelheid_select",$post["voorziene_hv"]);
	
	// SHOW links OF POST
	$data = SelectLinkByPost($msID);
	$tpl->setCurrentBlock("link");
	
		if($data != NULL){
			while($row = $data->fetchrow(MDB2_FETCHMODE_ASSOC)){
							$link = $row["idmeetstaat_link"];
							$linkID = $row["id"];
						
										$post = GetPostByID($link,$WerfID);
										$tpl->setVariable("norecords","");	
										$tpl->setVariable("link_nummer",$post["nummer"]);
										$tpl->setVariable("link_omschrijving",$post["omschrijving"]);
										$tpl->setVariable("link_delete","<a href='?msID=".$msID."&werf=".$WerfID."&unlink=".$linkID."'>unlink</a>");

							$tpl->parseCurrentBlock();
			}
		}else{
			$tpl->setVariable("norecords","--geen linken--");
		}
		
	

	//DEEL3 POSTENBOEK CONTENT-------------------------------------------------------------------------------------------
	

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
				//geselecteerde post geen selectievakje
				if($msID == $vs["id"]){
					$tpl->setVariable("checkbox","");	
					
				}else{
					$msID = $IDmeetstaat_select;
					$vs["id"] = $IDmeetstaat_link;
					
					if(CheckIfLinked($IDmeetstaat_select,$IDmeetstaat_link) == false){
						$tpl->setVariable("checkbox","<input type='checkbox' name='selecteren[]' value='".$vs["id"]."'>");
					}else{
						//reeds gekoppelde post geen selectievakje
						$tpl->setVariable("checkbox","");
					}
							
				}
		
			}else{
				$tpl->setVariable("nummer",$vs["nummer"]);
				$tpl->setVariable("omschrijving",wordwrap($vs["omschrijving"], 20, "\n", true));
				$tpl->setVariable("VHTP",$vs["vh_tb"]);
				$tpl->setVariable("eenheden",$vs["eenheden"]);	
				//geselecteerde post geen selectievakje
				if($msID == $vs["id"]){
					$tpl->setVariable("checkbox","");	
					
				}else{
					
					if(CheckIfLinked($msID,$vs["id"]) == false){
						$tpl->setVariable("checkbox","<input type='checkbox' name='selecteren[]' value='".$vs["id"]."'>");
					}else{
						//reeds gekoppelde post geen selectievakje
						$tpl->setVariable("checkbox","");
					}
					
						
					
				}
			}
				
				$tpl->setVariable("class","vs");
							
		
			
		}else{
			
			$tpl->setVariable("nummer","");
			$tpl->setVariable("omschrijving",wordwrap($vs["omschrijving"], 20, "\n", true));
			$tpl->setVariable("VHTP","&nbsp;");
			$tpl->setVariable("eenheden","&nbsp;");
			
			$tpl->setVariable("class","novs");
			
		}
		
		$tpl->parseCurrentBlock();
	}
	
	
	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>
