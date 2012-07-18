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
	$tpl->loadTemplatefile("profielbeheer.tpl.php");
	
	
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	
	$tpl->setVariable("titel","");
	$id = $user["id"];
	
	//USER CORRECT GEUPDATE!!!
	$bevestigd = "
		
		<table width='100%' border='0' class='tekstnormal' bgcolor='#fae3e3'>
		<tr>
			<td align='center' colspan='2'><img src='images/tick.png' > Uw profiel is correct gewijzigd!</td>
		</tr>
		</table>
		<br>
		
		";
	
	
	if($_REQUEST["action"]=="edituser"){
		$Name = $_REQUEST["Name"];
		$Surename = $_REQUEST["Surename"];
		$Street = $_REQUEST["Street"];
		$Place = $_REQUEST["Place"];
		$Phone = $_REQUEST["Phone"];
		$Mobile = $_REQUEST["Mobile"];
		$Email = $_REQUEST["Email"];
		$Password = $_REQUEST["Newpass"];
		
		
		UpdateUser($id, $Name, $Surename, $Street, $Place, $Phone, $Mobile, $Email, $Password);
		$tpl->setVariable("txt_bevestigd",$bevestigd);
	}

	//get date
	$today = date('d-m-Y');
	$tpl->setVariable("today",$today);
	
	//** Profiel ophalen
		$userdata = getUserById($id);
		$tpl->setVariable("Name","".$userdata["voornaam"]." ".$userdata["naam"]."");
		$tpl->setVariable("Street",$userdata["adres"]);
		$tpl->setVariable("Place",$userdata["woonplaats"]);
		$tpl->setVariable("Phone",$userdata["telefoon"]);
		$tpl->setVariable("Mobile",$userdata["mobiel"]);
		$tpl->setVariable("Email",$userdata["email"]);
		$tpl->setVariable("Naam",$userdata["naam"]);
		$tpl->setVariable("Surename",$userdata["voornaam"]);
		$tpl->setVariable("Oldpass",$userdata["paswoord"]);
		$tpl->setVariable("Username",$userdata["gebruikersnaam"]);

	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>