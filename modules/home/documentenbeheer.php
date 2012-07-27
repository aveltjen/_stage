<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require_once "../../PEAR/HTTP/Upload.php";
	require("inc/users.da.inc.php");
	require("inc/documents.da.inc.php");
	require("inc/functions.inc.php");

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
	$tpl->loadTemplatefile("documentenbeheer.tpl.php");
	
	
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
	$upload_dir	= "../../../files_dir/uploads/documents".$id."/server/php/";
	$tpl->setVariable("upload_dir",$upload_dir);
	
	$tpl->setVariable("Name","".$profile["voornaam"]." ".$profile["naam"]."");
	

	//VARIABELE DOCUMENT CORRECT VERWIJDERD!!!
	$deleted = "
		
		<table width='100%' border='0' class='tekstnormal' bgcolor='#fae3e3'>
		<tr>
			<td align='center' colspan='2'><img src='images/tick.png' > Het document is correct verwijderd!</td>
		</tr>
	
		</table>
		<br>
		
		";
	
	//VARIABELE DOCUMENT CORRECT upgeload!!!
	$uploaded = "
		
		<table width='100%' border='0' class='tekstnormal' bgcolor='#fae3e3'>
		<tr>
			<td align='center' colspan='2'><img src='images/tick.png' > Het document is correct upgeload!</td>
		</tr>
	
		</table>
		<br>
		
		";
		
	//** DOCUMENT DELETEN
	if($_REQUEST["action"]=="delete"){
		if (isset($_POST["selecteren"])) {
			foreach ($_POST["selecteren"] as $DocID){
				$UserID = $_REQUEST["UserID"];
				$Doclink = $_REQUEST["Doclink"];
			 	DeleteDocuments($DocID,$UserID,$Doclink);
			 	$tpl->setVariable("txt_deleted",$deleted);
			}
			
		 }
						
	}
	
	
	
	//** DOCUMENT UPLOADEN
	if($_REQUEST["action"]=="upload"){
		
		
// 		//posts in variabelen stoppen
// 		$UserID	= $user["id"];
// 		$docname = $_REQUEST["docname"];
// 		//upload uitvoeren
// 		$upload = new HTTP_Upload("nl");
// 		$file = $upload->getFiles("f");
		
// 		if($doc == false){
			
// 			if ($file->isValid()) {
// 				$file->setName("uniq");
// 				$moved = $file->moveTo("uploads/documents".$UserID."");
// 			    if (!PEAR::isError($moved)) {
// 			    	$Doclink = $file->getProp("name");
// 			    	addDocument($docname,$Doclink,$UserID);
// 			    	$tpl->setVariable("txt_uploaded",$uploaded);
// 			    } else {
// 			        echo $moved->getMessage();
// 			    }
// 			} elseif ($file->isMissing()) {
			   		
// 			} elseif ($file->isError()) {
// 			    echo $file->errorMsg();
// 			}
		
// 		}else{
			
// 		}
	}
	
	
	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>