<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require("../../PEAR/MDB2.php");
	require_once("../../PEAR/HTMLTemplate/IT.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/vorderingen.da.inc.php");

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
	$tpl->loadTemplatefile("vorderingen_maand.tpl.php");
	
	
	//*******Template specific code*************
	
	//** Uitloggen
	if($_REQUEST["action"]=="logout"){
		session_destroy();
		header("Location: ../../index.php");
	}
	
	//** Profiel ophalen
	$id			= $user["id"];
	$werf		= $_REQUEST["werf"];
	
	$tpl->setVariable("Name","".$user["voornaam"]." ".$user["naam"]."");

	
	$tpl->setVariable("titel","");
	$tpl->setVariable("werf",$werf);
	
	
	//GET ALL GEVORDERDE MONTHS
	$vorderingen = GetAllVorderingenDatum($werf);
	$vs = 0;
	
	$tpl->setCurrentBlock("dates");
	while($vordering = $vorderingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
		$vs = $vs + 1;
		$periode = $vordering['month_yy'];
		$tpl->setVariable("lbl_dates",$periode);	
		$tpl->setVariable("vs","VS".$vs."");	
		
		
		$tpl->parse("dates");
	}
	$tpl->setVariable("empty","
			<tr class='drukrows'>
				 <td colspan='5'>Geen periode geselecteerd!</td>
			</tr>
	");	
	
	if($_REQUEST["raadplegen"]=="yes"){
		$tpl->setVariable("empty","");	
		
		$parameter = $_REQUEST["periode"];
	
		$result = explode(' ',$parameter);
		
		//DEFINIEREN VAN DE BINNENGEKREGEN PARAMETER IN E=vsnummer EN D=periode. 
		$periode = $result[0];
		$vsnum = $result[1];
		
		
		$tpl->setVariable("printen2","<img src='images/document-pdf.png'>  <a href='vorderingen_maand_pdf.php?werf=".$werf."&periode=".$periode."&vs=".$vsnum."&id=".$id."' target='_blank'>download PDF</a>");
				
		
		$tpl->setVariable("periode",$periode);	
		$tpl->setVariable("vsnum",$vsnum);	
		
		
		//1#POSTEN DIE IN DE PERIODE GEVORDER ZIJN EERST OPZOEKEN
		$vhtotaal = 0;
		$posten = GetPostByPeriode($periode,$werf);
			
		$tpl->setCurrentBlock("posten");
		while($post = $posten->fetchrow(MDB2_FETCHMODE_ASSOC)){
			
			//2#POSTEN ID AFDRUKKEN IN CEL 1	
			$tpl->setVariable("icon","<img src='images/arrow-curve-000-left.png'>");
			
			$msID = $post["idmeetstaat"];
			
			
			$postnummer = GetPostByID($msID, $werf);
			$tpl->setVariable("msNummer",$postnummer["nummer"]);	
			
 			//3#VORIGE HOEVEELHEID OPZOEKEN
			$result = explode('-', $periode);
			$a = $result[0];
			$b = $result[1];
			
			$parameter2 = "".$b."-".$a."-01";
// 			echo "".$parameter2."<br>";
			
			$vorige= 0;
			$resultaat = GetAllVorigeVorderingenByPeriode($msID,$parameter2,$werf);
			
			$tpl->setCurrentBlock("vorige");
			while($res = $resultaat->fetchrow(MDB2_FETCHMODE_ASSOC)){
				$uitgevoerd = $res["uitgevoerd"];
		
				$vorige = $vorige + $uitgevoerd;	
				$tpl->parse("vorige");
			}
			$tpl->setVariable("vorige",number_format(($vorige),3,',',' '));
			
			//4#hUIDIGE HOEVEELHEID VAN DE POST OPZOEKEN
			$resultaat = GetAllVorderingenByPeriode($msID,$periode,$werf);
			$huidige = 0;
			$tpl->setCurrentBlock("huidige");
			while($res = $resultaat->fetchrow(MDB2_FETCHMODE_ASSOC)){
				$uitgevoerd = $res["uitgevoerd"];
			
				$huidige = $huidige + $uitgevoerd;	
				$tpl->parse("huidige");
			}
			$tpl->setVariable("huidige",number_format($huidige,3,',',' '));
			
			//5#TOTAAL GEVORDERDE HOEVEELHEID
			$totaal = $huidige + $vorige;
			$tpl->setVariable("totaal",number_format($totaal,3,',',' '));
			
			//6#TOTAAL BEDRAG
			$eprijs = $postnummer["prijs"];
			$vh = $postnummer["voorziene_hv"];
			
			$prijs = $huidige * $eprijs;
			$tpl->setVariable("bedrag","&euro; ".number_format($prijs, 2, ',', ' ')."<i> (EP = ".number_format($eprijs, 2, ',', ' ').")</i>");
			
			
			$vhprijs = $vh * $eprijs;
			
			
			//Totaal staat
			$tbedrag= $prijs + $tbedrag;
			
			
			//Totaal staat VH
			$vhtotaal= $vhprijs + $vhtotaal;
			
			$tpl->parse("posten");
		}
		
		
		//VORIGE PERIODE TOTAAL
		$vtotaal = 0;
		$rows = GetAllVorderingenByVorigePeriode($parameter2,$werf);
		$tpl->setCurrentBlock("periodetotaal");
		while($row = $rows->fetchrow(MDB2_FETCHMODE_ASSOC)){
			
				$uitgevoerd = $row["uitgevoerd"];
				$msID2 = $row["idmeetstaat"];
				
				$result = GetPostByID($msID2, $werf);
				$eprijs2 = $result["prijs"];
				
				//prijs per post
				$vprijs=$eprijs2*$uitgevoerd;
				
				//prijs totaal post
				$vtotaal = $vtotaal + $vprijs;
				$tpl->parse("periodetotaal");
			}
			
		$num = $rows->numRows();
		
		
		$tpl->setVariable("vtotaal","&euro; ".number_format($vtotaal, 2, ',', ' ')."");
		
		
		//TOTAAL BEDRAG
		$tpl->setVariable("tbedrag","&euro; ".number_format($tbedrag, 2, ',', ' ')."");
		
		//AANBESTEDINGSBEDRAG
		$totaal = GetAanbestedingsbedrag($werf);	
					
		$tpl->setVariable("hvtotaal","&euro; ".number_format($totaal, 2, ',', ' ')."");
	}
		
		
			
	

	//********************* Template Tonen *************
	
	$tpl->show(); //moet ge doen, anders ziede niet
	
?>