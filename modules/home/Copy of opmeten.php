<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("PEAR/MDB2.php");
	require_once "PEAR/HTTP/Upload.php";
	require_once("PEAR/HTMLTemplate/IT.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/opmetingen.da.inc.php");

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
	$tpl->loadTemplatefile("opmeten.tpl.php");
	
	
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	//** Profiel ophalen
	$id			= $user["id"];
		
	$tpl->setVariable("titel","");
	
	//** Geselcteerde post ophalen
	$msID = $_REQUEST["msID"];
	$werf = $_REQUEST["werf"];
	$tpl->setVariable("msID",$msID);
	$tpl->setVariable("werf",$werf);
	
	$post = GetPostByID($msID, $werf);
	$tpl->setVariable("nummer",$post["nummer"]);
	$tpl->setVariable("omschrijving",$post["omschrijving"]);
	$tpl->setVariable("eenheden",$post["eenheden"]);
	$tpl->setVariable("hoeveelheid",$post["voorziene_hv"]);
	
	
	if($_REQUEST["lastopmeting"]==1){
	//LAATSTE OPMETING OPHALEN
	$lastopmeting= GetLastInsertO($werf,$id);
	
	$tpl->setVariable("lastomschrijving",$lastopmeting["berekening"]);
	$tpl->setVariable("lastopgemeten",$lastopmeting["uitgevoerd"]);
	}
	
	//VORDERING WIJZIGEN
	if($_REQUEST["action"]== "wijzig"){
		//VORDERINGGEGEVENS OPHALEN
		$werf = $_REQUEST["werf"];
		$vid = $_REQUEST["vid"];
		$opmeting = GetOpmetingByVid($vid,$werf);
		
		$bijlage_old = $opmeting["bijlage1"];
		$datum_old = $opmeting["datum"];
		$omschrijving_old = $opmeting["berekening"];
		$uitgevoerd_old = $opmeting["uitgevoerd"];
		
		$tpl->setVariable("txt_wijzig","
		
		<table width='100%' border='0' class='tekstnormal' bgcolor='#fae3e3'>
		<tr>
			<td align='center' colspan='2'><img src='images/exclamation.png' > Wenst u de opmeting te wijzigen?</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>
				<form name='wijzig' action='?werf={werf}&msID={msID}&wijzig=yes&vid=".$vid."' method='POST' enctype='multipart/form-data'>
                            		
                            		<table width='650' class='tekstnormal'>
                            			<tr>
                            				<td>Omschrijving:</td>
                                            <td><input type='text' size='50' value='".$omschrijving_old."' id='txtOpmeting_berekening' name='omschrijving_new' /></td>
                            				<td align='right'><img src='images/disk-black.png'> <a href='#' onClick='document.wijzig.submit();'>wijzig</a>&nbsp;&nbsp;<img src='images/cross-shield.png'> <a href='?werf={werf}&msID={msID}'>Annuleren</a></td>
                            			</tr>
                            			<tr>
                            				<td>Opgemeten:</td>
                                            <td><input type='text' size='10' value='".$uitgevoerd_old."' id='txtOpmeting_resultaat' name='opgemeten_new' /> <a href='javascript:openCalculatorBox()'><img src='images/calculator--plus.png' align='bottom' alt='Bereken'></a></td>
                                            <td></td>
                            			</tr>
                            			<tr>
                            				<td>Bijlage: <img src='images/pin--plus.png'></td>
                                            <td><input type='file' name='f' size='25'></td>
                                            <td><input type='hidden' name='bijlage_old' value='".$bijlage_old."'></td>
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
		$datum_new 			= date("Y-m-d");
		$omschrijving_new 	= $_REQUEST["omschrijving_new"];
		$uitgevoerd_new		= $_REQUEST["opgemeten_new"];
		$bijlage_old		= $_REQUEST["bijlage_old"];

		
		
			//upload uitvoeren
		$upload = new HTTP_Upload("nl");
		$file = $upload->getFiles("f");
			
			if ($file->isValid()) {
				 $file->setName("uniq");
				 $bijlage_new = $file->getProp("name");
				 
			    $moved = $file->moveTo("uploads/opmetingen".$id."");
			    if (!PEAR::isError($moved)) {
			    	unlink("uploads/opmetingen".$id."/".$bijlage_old."");
			    	UpdateOpmeting($vid,$datum_new,$omschrijving_new,$uitgevoerd_new,$bijlage_new);
			    	//Update meetstaat
			    	//OPMETINGEN OPHALEN
			    	$opmetingen = GetOpmetingenByPost($msID,$werf);
			    	$oh = 0;
			    	while($opmeting = $opmetingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
			    			
			    		$oh = $oh + $opmeting["uitgevoerd"];
			    	}
			    	UpdateOH($oh,$msID,$werf);
			    	
			    } else {
			        echo $moved->getMessage();
			    }
			} elseif ($file->isMissing()) {
			   		UpdateOpmeting($vid,$datum_new,$omschrijving_new,$uitgevoerd_new,$bijlage_old,$werf);
			} elseif ($file->isError()) {
			    echo $file->errorMsg();
			}
			
			
		
	}else{
		
	}
	
	//opmeting VERWIJDEREN
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
					<td width='50%'><img src='images/tick-shield.png'> <a href='?msID=".$msID."&werf=".$WerfID."&delete=yes&vid=".$_REQUEST["vid"]."'>Ja</a></td>
					<td width='50%'><img src='images/cross-shield.png'> <a href='?msID=".$msID."&werf=".$WerfID."'>Nee</a> </td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		<br>
		");
			
	}
	

	//OPMETING VERWIJDEREN
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
					<td width='50%'><img src='images/tick-shield.png'> <a href='?msID=".$_REQUEST["msID"]."&werf=".$_REQUEST["werf"]."&delete=yes&vid=".$_REQUEST["vid"]."&bijlage=".$_REQUEST["bijlage"]."'>Ja</a></td>
					<td width='50%'><img src='images/cross-shield.png'> <a href='?msID=".$_REQUEST["msID"]."&werf=".$_REQUEST["werf"]."'>Nee</a> </td>
				</tr>
				</table>
			</td>
		</tr>
		</table>
		<br>
		");
			
	}
	
	if($_REQUEST["delete"]== "yes"){
		
		$vid = $_REQUEST["vid"];
		$bijlage = $_REQUEST["bijlage"];
		
		
		deleteOpmeting($vid);
		//Update meetstaat
		//OPMETINGEN OPHALEN
		$opmetingen = GetOpmetingenByPost($msID,$werf);
		$oh = 0;
		while($opmeting = $opmetingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
				
			$oh = $oh + $opmeting["uitgevoerd"];
		}
		UpdateOH($oh,$msID,$werf);
			if($bijlage==""){
				
			}else{
				unlink("uploads/opmetingen".$id."/".$bijlage."");
			}
		}else {
			
		}

	
	//OPMETING TOEVOEGEN
	if($_REQUEST["action"]=="add"){
		$werf = $_REQUEST["werf"];
	
		$user = $user["id"];
		$msID = $_REQUEST["msID"];
		$omschrijving = $_REQUEST["omschrijving"];
		$uitgevoerd = $_REQUEST["opgemeten"];
		$datum = date("Y-m-d"); 
	
		
		//upload uitvoeren
		$upload = new HTTP_Upload("nl");
		$file = $upload->getFiles("f");
		
		
		//checken of document bestaat
		$bijlage = $file->getProp("name");
			
			if ($file->isValid()) {
				 $file->setName("uniq");
				 $bijlage = $file->getProp("name");
				 
			    $moved = $file->moveTo("uploads/opmetingen".$id."");
			    if (!PEAR::isError($moved)) {
			    	addOpmeting($werf,$user,$msID,$datum,$omschrijving,$uitgevoerd,$bijlage);
			    	
			    } else {
			        echo $moved->getMessage();
			    }
			} elseif ($file->isMissing()) {
					$bijlage = "";
			   		addOpmeting($werf,$user,$msID,$datum,$omschrijving,$uitgevoerd,$bijlage);
					
			} elseif ($file->isError()) {
			    echo $file->errorMsg();
			}
// 							//Update meetstaat
// 							//OPMETINGEN OPHALEN
							$opmetingen = GetOpmetingenByPost($msID,$werf);
// 							
							$oh = 0;
								while($opmeting = $opmetingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
			
									$oh = $oh + $opmeting["uitgevoerd"];	
								}
							UpdateOH($oh,$msID,$werf);

	}
	//OPMETINGEN OPHALEN
	$opmetingen = GetOpmetingenByPost($msID,$werf);
	$tpl->setCurrentBlock("opmetingen");
	$totaal = 0;
	while($opmeting = $opmetingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
		$tpl->setVariable("icon","<img src='images/arrow-curve-000-left.png'>");
		$tpl->setVariable("datum",$opmeting["datum"]);
		if($opmeting["bijlage1"]==""){
			$tpl->setVariable("bijlage","");
		}else{
			$tpl->setVariable("bijlage","<a href='uploads/opmetingen".$id."/".$opmeting["bijlage1"]."' target='_blank'><img src='images/attach.png'></a>");
		}
		
		$tpl->setVariable("berekening",$opmeting["berekening"]);
		$tpl->setVariable("gemeten",$opmeting["uitgevoerd"]);
		$tpl->setVariable("delete","<a href='?msID=".$msID."&werf=".$werf."&action=delete&vid=".$opmeting["id"]."&bijlage=".$opmeting["bijlage1"]."'><img src='images/cross.png'></a>");
		$tpl->setVariable("wijzig","<a href='?msID=".$msID."&werf=".$werf."&action=wijzig&vid=".$opmeting["id"]."'><img src='images/bin--pencil.png'></a>");
		
		$totaal = $totaal + $opmeting["uitgevoerd"];
		$tpl->setVariable("totaal",$totaal);
		$tpl->parseCurrentBlock();
	}
	//GEEN OPMETINGEN
	$num = $opmetingen->numRows();
			
				if($num > 0){
					$tpl->setVariable("geenopm","");
					$tpl->setVariable("printen2","<img src='images/document-pdf.png'>  <a href='opmetingen_post_pdf.php?werf=".$werf."&msID=".$msID."' target='_blank'>download PDF</a>");
				}else{
					$tpl->setVariable("printen2","");
					$tpl->setVariable("geenopm","
					<tr class='drukrows'>
						<td colspan='6'>Geen opmetingen</td>
					</tr>
					");	
				}
	
	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>