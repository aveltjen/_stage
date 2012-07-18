<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require_once "../../PEAR/HTTP/Upload.php";
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/functions.inc.php");
	require("inc/mail.inc.php");
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
	$tpl->loadTemplatefile("wervenbeheer.tpl.php");
	
	
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	
	$tpl->setVariable("titel","");
	
	
	//** Profiel ophalen
	$id			= $user["id"];
	$profile 	= GetUserById($id);
	
		$tpl->setVariable("Name","".$profile["voornaam"]." ".$profile["naam"]."");
	
	//** WERF DELETEN
	if($_REQUEST["action"]=="delete"){
		if (isset($_POST["selecteren"])) {
			foreach ($_POST["selecteren"] as $WerfID){
				
			 	DeleteWerven($WerfID);
			 	
			}
			
		 	
		 }
						
	}	
	//AANVRAAG ARCHIVERING
	if($_REQUEST["action"]=="archiveer"){
	$werfid = $_REQUEST["werf"];
	$werfnummer = $_REQUEST["werfnummer"];
	
	$tpl->setVariable("txt_archief","
	
			<table width='100%' border='0' class='tekstnormal' bgcolor='#fae3e3'>
			<tr>
			<td align='center' colspan='2'><img src='images/exclamation.png' > Bent u zeker werf <b>".$werfnummer."</b> te archiveren?<br>gearchiveerde werven verdwijnen uit de lijst <i>'mijn werven'</i></td>
			</tr>
			<tr>
			<td colspan='2' align='center'>
			<form name='archiveer' action='?archiveer=yes&werf=".$werfid."' method='POST'>
			<table>
			<tr>
				<td align='right'><img src='images/cd_go.png'> <a href='#' onClick='document.archiveer.submit();'>ja, archiveer!</a>&nbsp;&nbsp;<img src='images/cross-shield.png'> <a href='#'>Annuleren</a></td>
			</tr>
			</table>
			</form>
			</td>
			</tr>
			</table>
			<br>
	
			");
	}
	
	//WERF ARCHIVEREN
	if($_REQUEST["archiveer"]=="yes"){
		$werfid = $_REQUEST["werf"];
		setarchief($werfid);
	}
	
	
	//VARIABELE WERF CORRECT UPGELOAD!!!
	$bevestigd = "
		
		<table width='100%' border='0' class='tekstnormal' bgcolor='#fae3e3'>
		<tr>
			<td align='center' colspan='2'><img src='images/tick.png' > De werf is correct aangemaakt!</td>
		</tr>
		<tr>
			<td colspan='2' align='center'>
				 U krijgt bericht zodra de werf is geactiveerd!
			</td>
		</tr>
		</table>
		<br>
		
		";
	
	//** Werf toevoegen
	if($_REQUEST["action"]=="addwerf"){
		$nummer	= $_REQUEST["nummer"];
		$omschrijving = $_REQUEST["omschrijving"];
		$startdatum	= $_REQUEST["startdatum"];
		
		echo $nummer;
		echo $omschrijving;
		echo $startdatum;
		echo $id;
		
		//** DOCUMENT UPLOADEN
		
		//upload uitvoeren
		$upload = new HTTP_Upload("nl");
		$file = $upload->getFiles("f");
		
		
			if ($file->isValid()) {
				$file->setName("uniq");
				$moved = $file->moveTo("uploads/meetstaten/");
			    if (!PEAR::isError($moved)) {
			    	$meetstaat = $file->getProp("name");
			    	
			 
			    	
			    	addWerf($id,$nummer,$omschrijving,$startdatum,$meetstaat);
// 			    	email_webmaster($Doclink);
			    	
			    	$tpl->setVariable("txt_bevestigd",$bevestigd);
			    } else {
			        echo $moved->getMessage();
			    }
			} elseif ($file->isMissing()) {
			   		
			} elseif ($file->isError()) {
			    echo $file->errorMsg();
			}
		
		}
		

	//get date
	$today = date('d-m-Y');
	$tpl->setVariable("today",$today);
	
	//**WERVEN OPHALEN
	$werflist = GetWervenByUserIDArchief($id);
	
	$tpl->setCurrentBlock("Werflist");
	while($werf = $werflist->fetchrow(MDB2_FETCHMODE_ASSOC)){
		$tpl->setVariable("Number",$werf["nummer"]);
		$tpl->setVariable("id","<input type='hidden' name='UserID' value='".$werf["id"]."'");
		$tpl->setVariable("description",$werf["omschrijving"]);
		$tpl->setVariable("checkbox","<input type=\"checkbox\" name=\"selecteren[]\" value='".$werf["id"]."'>");
		$tpl->setVariable("delete","<a href='javascript: submitform()'><img src='images/verwijder.gif' title='verwijderen'></a>");
		$tpl->setVariable('archiveer',"<a href='?action=archiveer&werf=".$werf["id"]."&werfnummer=".$werf["nummer"]."'><img src='images/cd_go.png' title='archiveren'></a>");
		$tpl->setVariable('editwerf',"<a href='editwerf.php?action=checkwerf&WerfID=".$werf["id"]."'><img src='images/monitor_edit.png' title='wijzigen'></a>");
		if($werf["actief"]==2){
			$tpl->setVariable('archief',"<font color='green'>gearchiveerd!</font>");
		}else{
			$tpl->setVariable('archief',"");
				
		}
		$tpl->parseCurrentBlock();
	}

	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>