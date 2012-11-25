<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
//********Requirements & Includes***************
require("PEAR/MDB2.php");
require_once("PEAR/HTMLTemplate/IT.php");
require("inc/users.da.inc.php");

$ebits = ini_get('error_reporting');
//error_reporting($ebits ^ E_NOTICE);	

//*********Template modifications***************
$tpl = new HTML_Template_IT("./");
$tpl->loadTemplatefile("index.tpl.php");

$tpl->setVariable("titel","Supervisie V3");
//*******Template specific code*************

//*** Search for login request ****
if($_REQUEST["checklogin"] == true){
	
	//login request - user authenticate,  & put in session
	$username = mysql_escape_string($_REQUEST["username"]);
	$password = mysql_escape_string($_REQUEST["password"]);
	
	$user = AuthenticateUser($username, $password);
	
	if($user != null){

		 $_SESSION["user"] = $user;
		header("Location: modules/home/index.php");
	}else{
		$tpl->setVariable('msg','<p>Gebruikersnaam of wachtwoord onjuist!!!</p>');
	}
	
}

//********************* Template Tonen *************

$tpl->show(); //moet ge doen, anders ziede niet
?>