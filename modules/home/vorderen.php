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
	$tpl->loadTemplatefile("vorderen.tpl.php");
	
	
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	//** Profiel ophalen
	$id			= $user["id"];
		
	$tpl->setVariable("titel","");
	
	//** Geselecteerde post ophalen
	$msID = $_REQUEST["msID"];
	$werf = $_REQUEST["werf"];
	$tpl->setVariable("msID",$msID);
	$tpl->setVariable("werf",$werf);
	
	$post = GetPostByID($msID, $werf);
	
	$tpl->setVariable("nummer",$post["nummer"]);
	$tpl->setVariable("omschrijving",$post["omschrijving"]);
	$tpl->setVariable("eenheden",$post["eenheden"]);
	$tpl->setVariable("hoeveelheid",$post["voorziene_hv"]);

	//get date
	//laatst ingegeven vorderingsdatum weergeven
// 	$today = date('Y-m-d');
	$lastvordering = GetLastInsert($werf,$id);
	
	$today = $lastvordering["datum"];
	$tpl->setVariable("today",$today);
	
	if($_REQUEST["lastvordering"]==1){
	
		//VORIGE VORDERING OPHALEN
	$lastvordering = GetLastInsert($werf,$id);
	
	$tpl->setVariable("lastdate",$lastvordering["datum"]);
	$tpl->setVariable("lastomschrijving",$lastvordering["omschrijving"]);
	$tpl->setVariable("lastuitgevoerd",$lastvordering["uitgevoerd"]);
	}else{
		$tpl->setVariable("lastdate",$today);
	}
	
	//VORDERING WIJZIGEN
	if($_REQUEST["action"]== "wijzig"){
		//VORDERINGGEGEVENS OPHALEN
		$vid = $_REQUEST["vid"];
		
		$vordering = GetVorderingByVid($vid,$werf);
		
		$datum_old = $vordering["datum"];
		$omschrijving_old = $vordering["omschrijving"];
		$uitgevoerd_old = number_format($vordering["uitgevoerd"],3,',','');
		
		$tpl->setVariable("txt_wijzig","
		
		<table width='100%' border='0' class='tekstnormal' bgcolor='#fae3e3'>
		<tr>
			<td align='center' colspan='2'><img src='images/exclamation.png' > Wenst u de vordering te wijzigen?</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>
				<form name='wijzig' action='?werf={werf}&msID={msID}&wijzig=yes&vid=".$vid."' method='POST'>
                            		
                            		<table width='650' class='tekstnormal'>
                            			<tr>
                            				<td>Datum:</td>
                            				<td><input type='text' id='date' size='10' name='datum_new' value='".$datum_old."' /></td>
                            				<td align='right'><img src='images/disk-black.png'> <a href='#' onClick='document.wijzig.submit();'>wijzig</a>&nbsp;&nbsp;<img src='images/cross-shield.png'> <a href='?werf={werf}&msID={msID}'>Annuleren</a></td>
                            			</tr>
                            			<tr>
                            				<td>Omschrijving:</td>
                                            <td><input type='text' size='50' name='omschrijving_new' value='".$omschrijving_old."' /></td>
                                            <td></td>
                            			</tr>
                            			<tr>
                            				<td>Uitgevoerd:</td>
                                            <td><input type='text' size='10' name='uitgevoerd_new' value='".$uitgevoerd_old."' /></td>
                                            <td></td>
                            			</tr>
                            		</table>
                </form>
			</td>
		</tr>
		</table>
		<br>
		
		");
		
	}
	
	if($_REQUEST["wijzig"]== "yes"){
		
		$vid 				= $_REQUEST["vid"];
		$datum_new 			= $_REQUEST["datum_new"];
		$omschrijving_new 	= $_REQUEST["omschrijving_new"];
		$uitgevoerd_new		= str_replace(",", ".", $_REQUEST["uitgevoerd_new"]);
		
		$date = explode("-",$datum_new); 
		$timestamp = mktime(0,0,0,$date[1],$date[2],$date[0]);
		
		$periode_new = date("m-Y", $timestamp);
		
		UpdateVordering($vid,$datum_new,$omschrijving_new,$uitgevoerd_new,$periode_new,$werf);
		
		//UPDATE MEETSTAAT
		//VORDERINGEN OPHALEN
			
		$vorderingen = GetVorderingenByPost($msID,$werf);
		$gh = 0;
		while($vordering = $vorderingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
			$gh = $gh + $vordering["uitgevoerd"];
		}
		
		UpdateGH($gh,$msID,$werf);
		
	}else{
		
	}
	
	//VORDERING VERWIJDEREN
	if($_REQUEST["action"]== "delete"){
		
		$tpl->setVariable("txt_delete","
		
		
		<table width='100%' border='0' class='tekstnormal' bgcolor='#fae3e3'>
		<tr>
			<td align='center' colspan='2'><img src='images/exclamation.png' > definitief verwijderen?</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>
				<table width='150' border='0'>
				<tr>
					<td width='50%'><img src='images/tick-shield.png'> <a href='?msID=".$msID."&werf=".$werf."&delete=yes&vid=".$_REQUEST["vid"]."'>Ja</a></td>
					<td width='50%'><img src='images/cross-shield.png'> <a href='?msID=".$msID."&werf=".$werf."'>Nee</a> </td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		<br>
		");
			
	}
	
	if($_REQUEST["delete"]== "yes"){
		
		$werf = $_REQUEST["werf"];
		$vid = $_REQUEST["vid"];

		deleteVordering($vid,$werf);
		
		//UPDATE MEETSTAAT
		//VORDERINGEN OPHALEN
			
		$vorderingen = GetVorderingenByPost($msID,$werf);
		$gh = 0;
		while($vordering = $vorderingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
			$gh = $gh + $vordering["uitgevoerd"];
		}
		
		UpdateGH($gh,$msID,$werf);
		
		}else {
			
		}
	
	//VORDERING TOEVOEGEN
	if($_REQUEST["action"]=="add"){
		$werf = $_REQUEST["werf"];
		$user = $user["id"];
		$msID = $_REQUEST["msID"];
		$vs = $_REQUEST["vs"];
		$omschrijving = mysql_real_escape_string($_REQUEST["omschrijving"]);
		$uitgevoerd = str_replace(",", ".", $_REQUEST["uitgevoerd"]);
		$datum = $_REQUEST["datum"];
		
		$date = explode("-",$datum); 
		$timestamp = mktime(0,0,0,$date[1],$date[2],$date[0]);
		
		$periode = date("m-Y", $timestamp);
		addVordering($werf,$user,$msID,$vs,$datum,$omschrijving,$uitgevoerd,$periode);
		
						//UPDATE MEETSTAAT
						//VORDERINGEN OPHALEN
					
						$vorderingen = GetVorderingenByPost($msID,$werf);
						$gh = 0;
							while($vordering = $vorderingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
								$gh = $gh + $vordering["uitgevoerd"];
							}
		
						UpdateGH($gh,$msID,$werf);
	}
	
	//VORDERINGEN OPHALEN
	$vorderingen = GetVorderingenByPost($msID,$werf);
	$tpl->setCurrentBlock("vorderingen");
	$totaal = 0;
	while($vordering = $vorderingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
		$tpl->setVariable("icon","<img src='images/arrow-curve-000-left.png'>");
		$tpl->setVariable("datum",$vordering["datum"]);
		$tpl->setVariable("omschrijving_vordering",wordwrap($vordering["omschrijving"], 42, "\n", true));
		$tpl->setVariable("uitgevoerd",number_format($vordering["uitgevoerd"],3,',',''));
		$tpl->setVariable("delete","<a href='?msID=".$msID."&werf=".$werf."&action=delete&vid=".$vordering["id"]."'><img src='images/cross.png'></a>");
		$tpl->setVariable("wijzig","<a href='?msID=".$msID."&werf=".$werf."&action=wijzig&vid=".$vordering["id"]."'><img src='images/bin--pencil.png'></a>");
		
		$totaal = $totaal + $vordering["uitgevoerd"];
		$tpl->setVariable("totaal",number_format($totaal,3,',',''));
		$tpl->parseCurrentBlock();
	}
	//GEEN VORDERINGEN
	$num = $vorderingen->numRows();
			
				if($num > 0){
					$tpl->setVariable("geenvord","");
				}else{
					$tpl->setVariable("geenvord","
					<tr class='drukrows'>
						<td colspan='6'>Geen vorderingen</td>
					</tr>
					");	
				}
	
	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>