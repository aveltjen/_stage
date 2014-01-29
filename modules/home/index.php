<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];$root = $_SERVER['DOCUMENT_ROOT'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require("inc/users.da.inc.php");
	require("inc/documents.da.inc.php");
	require("inc/werven.da.inc.php");

	$ebits = ini_get('error_reporting');
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
	$tpl->loadTemplatefile("index.tpl.php");
	
	$tpl->setVariable("titel","");
	//*******Template specific code*************
	
	//** Uitloggen
	if(isset($_REQUEST["action"])=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}

	//** Documenten ophalen ophalen
	// print_r($user);
	$id			= $user["id"];
	
	$upload_dir	= "../../files_dir/uploads/documents".$id."/server/php/";

	//** Profiel ophalen
	//user gegevens uit sessie halen
		$tpl->setVariable("Name","".$user["voornaam"]." ".$user["naam"]."");
		$tpl->setVariable("Street",$user["adres"]);
		$tpl->setVariable("Place",$user["woonplaats"]);
		$tpl->setVariable("Phone",$user["telefoon"]);
		$tpl->setVariable("Mobile",$user["mobiel"]);
		$tpl->setVariable("Email",$user["email"]);

		
		
	//** Build information aan de hand van de user
	$GroupId = $user["idgroep"];
	//ADMIN
	If($GroupId==1){
		$tpl->setVariable("configLnk","
			<tr><td width='25' height='24'><img src='images/user_edit.png'></td><td valign='middle' align='left'><a href='profielbeheer.php'>Profielbeheer</a></td></tr>
			<tr><td  width='25' height='24'><img src='images/database_table.png'> </td><td valign='middle' align='left'><a href='wervenbeheer.php'>Wervenbeheer</a></td></tr>
			<tr><td  width='25' height='24'><img src='images/folder_page_white.png'> </td><td valign='middle' align='left'><a href='documentenbeheer.php'>Documentenbeheer</a></td></tr>
			<tr><td  width='25' height='24'><img src='images/cog_edit.png'></td><td valign='middle' align='left'><a href='#'>Alg. Configuratie</a></td></tr>
	
		");
	}
	//WERFTOEZICHTER
	If($GroupId==2){
		
		//build config block
		$tpl->setVariable("configLnk","
			<tr><td width='25' height='24'><img src='images/user_edit.png'></td><td valign='middle' align='left'><a href='profielbeheer.php'>Profielbeheer</a></td></tr>
			<tr><td width='25' height='24'><img src='images/database_table.png'> </td><td valign='middle' align='left'><a href='wervenbeheer.php'>Wervenbeheer</a></td></tr>
			<tr><td width='25' height='24'><img src='images/folder_page_white.png'> </td><td valign='middle' align='left'><a href='documentenbeheer.php'>Documentenbeheer</a></td></tr>
	
		");
		
		//build mijn werven block
		//**WERVEN OPHALEN
		$werflist = GetWervenByUserID($id);
		
		$tpl->setCurrentBlock("Werflist");
		while($werf = $werflist->fetchrow(MDB2_FETCHMODE_ASSOC)){
			if($werf["actief"]==1){
				$tpl->setVariable("Description","<a href='startwerf.php?werf=".$werf["id"]."'>".$werf["omschrijving"]."</a>");
				$tpl->setVariable("bullet","<img src='images/mouse.png'>");
			}else{
				$tpl->setVariable("Description","".$werf["omschrijving"]."");
				$tpl->setVariable("bullet","<img src='images/mouse_error.png'>");
			}
			$tpl->setVariable("id",$werf["id"]);
			$tpl->setVariable("Number",$werf["nummer"]);
		
			$tpl->setVariable("icon","<img src='images/box--arrow.png'>");
			$tpl->parseCurrentBlock();
		}
		
		//build documenten block
		$tpl->setVariable("docblock","
				<table width='230' border='0' cellpadding='0' cellspacing='0' class='tekstkader' align='left'>
					<!-- fwtable fwsrc='Untitled' fwbase='index.png' fwstyle='Dreamweaver' fwdocid = '234834546' fwnested='0' -->
					  
					
					  <tr>
					   <td width='14' background='images/index_r1_c1.gif'><img src='images/spacer.gif' height='29' width='14'></td>
					   <td background='images/index_r1_c2.gif'>&nbsp;</td>
					   <td width='9' background='images/index_r1_c3.png'></td>
					   <td width='136' background='images/index_r1_c4.png' align='center' valign='middle'><b>Mijn documenten</b></td>
					   <td width='9' background='images/index_r1_c5.png'></td>
					   <td background='images/index_r1_c6.gif'>&nbsp;</td>
					   <td width='10' background='images/index_r1_c7.gif'></td>
					  </tr>
					  <tr>
					   <td background='images/index_r2_c1.png'><img src='images/spacer.gif' height='3' alt='' width='13'></td>
					   <td colspan='5' bgcolor='White' valign='middle'>
			
					  			 	<div id='documents' style='margin-top: 10px;'>
								    <form id='fileupload' action='".$upload_dir."' method='POST' enctype='multipart/form-data'> 		            
								        <table class='config' cellspacing='0' border='0'>
								        	<tbody class='files' data-toggle='modal-gallery' data-target='#modal-gallery'>
								        	
								        	</tbody>
								        </table>
								    </form>
									</div>
						</td>
					   <td background='images/index_r2_c7.gif'><img src='images/spacer.gif' height='3' alt='' width='13'></td>
			
					  </tr>
					  <tr>
					   <td width='14' background='images/index_r3_c1.gif'><img src='images/spacer.gif' height='15' width='14'></td>
					   <td colspan='5' background='images/index_r3_c2.gif'><img src='images/spacer.gif' height='15' alt='' width='3'></td>
					   <td width='10' background='images/index_r3_c7.gif'></td>
					   
					  </tr>
					</table>
				");
		
	}
	//VIEWER
	If($GroupId==3){
		
		//build config block
		$tpl->setVariable("configLnk","
			<tr><td valign='top' width='25' height='24'><img src='images/user_edit.png'></td><td valign='middle' align='left'><a href='profielbeheer.php'>profielbeheer</a></td></tr>
			<tr><td width='25' height='24'><img src='images/folder_page_white.png'> </td><td valign='middle' align='left'><a href='documentenbeheer.php'>Documentenbeheer</a></td></tr>	
			");
		
		//**WERVEN OPHALEN
		$werflist = GetWervenAll();
		
		$tpl->setCurrentBlock("Werflist");
		while($werf = $werflist->fetchrow(MDB2_FETCHMODE_ASSOC)){
			if($werf["actief"]==1){
				$tpl->setVariable("Description","<a href='startwerf.php?werf=".$werf["id"]."'>".$werf["omschrijving"]."</a>");
				$tpl->setVariable("bullet","<img src='images/mouse.png'>");
			}else{
				$tpl->setVariable("Description","".$werf["omschrijving"]."");
				$tpl->setVariable("bullet","<img src='images/mouse_error.png'>");
			}
			$tpl->setVariable("id",$werf["id"]);
			$tpl->setVariable("Number",$werf["nummer"]);
		
			$tpl->setVariable("Year",$werf["year"]);
			$tpl->setVariable("Month",$werf["month"]);
			$tpl->setVariable("Day",$werf["day"]);
			$tpl->setVariable("icon","<img src='images/box--arrow.png'>");
			$tpl->parseCurrentBlock();
		}
		
		
		//build documenten block
		$tpl->setVariable("docblock","
				<table width='230' border='0' cellpadding='0' cellspacing='0' class='tekstkader' align='left'>
				<!-- fwtable fwsrc='Untitled' fwbase='index.png' fwstyle='Dreamweaver' fwdocid = '234834546' fwnested='0' -->
					
					
				<tr>
				<td width='14' background='images/index_r1_c1.gif'><img src='images/spacer.gif' height='29' width='14'></td>
				<td background='images/index_r1_c2.gif'>&nbsp;</td>
				<td width='9' background='images/index_r1_c3.png'></td>
				<td width='136' background='images/index_r1_c4.png' align='center' valign='middle'><b>Mijn documenten</b></td>
				<td width='9' background='images/index_r1_c5.png'></td>
				<td background='images/index_r1_c6.gif'>&nbsp;</td>
				<td width='10' background='images/index_r1_c7.gif'></td>
				</tr>
				<tr>
				<td background='images/index_r2_c1.png'><img src='images/spacer.gif' height='3' alt='' width='13'></td>
				<td colspan='5' bgcolor='White' valign='middle'>
					
				<div id='documents' style='margin-top: 10px;'>
				<form id='fileupload' action='".$upload_dir."' method='POST' enctype='multipart/form-data'>
				<table class='config' cellspacing='0' border='0'>
				<tbody class='files' data-toggle='modal-gallery' data-target='#modal-gallery'>
				 
				</tbody>
				</table>
				</form>
				</div>
				</td>
				<td background='images/index_r2_c7.gif'><img src='images/spacer.gif' height='3' alt='' width='13'></td>
					
				</tr>
				<tr>
				<td width='14' background='images/index_r3_c1.gif'><img src='images/spacer.gif' height='15' width='14'></td>
				<td colspan='5' background='images/index_r3_c2.gif'><img src='images/spacer.gif' height='15' alt='' width='3'></td>
				<td width='10' background='images/index_r3_c7.gif'></td>
		
				</tr>
				</table>
				");
	}
	
	
	
	
	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>