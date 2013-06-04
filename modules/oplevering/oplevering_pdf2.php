<?php session_start(); define("IN_SITE", true); define('EUR',chr(128));$root = $_SERVER['DOCUMENT_ROOT'];
	require_once("fpdf.php");
	require_once("myfpdf-table.php");
	require_once("class.fpdftable.php");
	require("../../PEAR/MDB2.php");
	require("../../inc/db.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/opmetingen.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/users.da.inc.php");
	
	// $ebits = ini_get('error_reporting');
	// 	error_reporting($ebits ^ E_NOTICE);
	
		
	//WERF ID GETTEN
	$werf = $_REQUEST["werven_ID"];
	
	
	//werf ophalen
	$werfdata = GetWerfByWerfID($werf);
		
	$werfnr = $werfdata["nummer"];
	$project = "".$werfdata["nummer"]." ".$werfdata["omschrijving"]."";	

	
	//** Profiel ophalen
	$userId			= $_REQUEST["id"];
	$profile 	= GetUserById($userId);
	
	$naam = "".$profile["voornaam"]." ".$profile["naam"]."";
	
	//Aanbestedingsbedrag
	$aanbesteding = GetBedragAanbesteding($werf);
	$bedrag = GetBedragUitgevoerdeWerken($werf);
	//create the fpdf object and do some initialization
	$oFpdf = new myFpdf();
	$oFpdf->Open();
	$oFpdf->SetAutoPageBreak(true, 20);
	$oFpdf->SetMargins(20, 20, 20);
	$oFpdf->AddPage();
	$oFpdf->AliasNbPages();
	$oFpdf->SetFont('Arial','','10');
	$oFpdf->Image('../home/images/docbalk5.png',20,10,170,'','','');
	$oFpdf->Image('../home/images/infrax.jpg',140,20,'',12,'','');
	$oFpdf->Ln();
	$ns = wordwrap($project,50,"\n",true);
	$oFpdf->Write(5, $ns);
	$oFpdf->Ln();
// 	$oFpdf->MultiCell(150, 2, $project, '', 'L', 0);
	$oFpdf->Cell(0,6,'Toezichter: '.$naam.'');
	$oFpdf->Ln();
// 	$oFpdf->Line(20, 40, 190, 40);
	$oFpdf->Ln(11);
	$oFpdf->SetFont('Arial','B','10');
	$oFpdf->Cell(20,'','Totaal aanbestedingsbedrag: '.EUR.' '.number_format($aanbesteding, 2, ',', ' ').'','','','L');
	$oFpdf->Ln();
	$oFpdf->Cell(20,10,'Bedrag uitgevoerde werken: '.EUR.' '.number_format($bedrag, 2, ',', ' ').'','','','L');
	$oFpdf->Ln();
// 	$oFpdf->Line(20, 60, 190, 60);
	$oFpdf->Ln(20);
	
	$oTable = new fpdfTable($oFpdf);
	
	/**
	 * Set the tag styles
	 */
	$oTable->setStyle("p","times","",10,"130,0,30");
	$oTable->setStyle("b","arial","B",9,"0,0,0");
	$oTable->setStyle("bsmall","arial","B",7,"0,0,0");
	$oTable->setStyle("desc","arial","",7,"0,0,0");
	$oTable->setStyle("t1","arial","",9,"0,0,0");
	$oTable->setStyle("t2","arial","I",7,"0,0,0");
	$oTable->setStyle("bi","times","BI",12,"0,0,120");
	$oTable->setStyle("t3","arial","U",7,"36,46,243");
	
	//change multiple values
	$aCustomConfiguration = array(
	        'TABLE' => array(
	                'TABLE_ALIGN'       => 'C',                 //left align
	                'BORDER_COLOR'      => array(0, 0, 0),      //border color
	                'BORDER_SIZE'       => '0.2',               //border size
	        )
	);

//LOAD DATA
$totaal = 0;
$totaalvh = 0;
$opgemeten = 0;
$prijs = 0;
//ALLE OPMETINGEN OPHALEN
$posten = $db->query("SELECT DISTINCT v_opmetingen_werf_".$werf.".IDmeetstaat, v_opmetingen_werf_".$werf.".IDmeetstaat, v_meetstaat_werf_".$werf.".nummer, v_meetstaat_werf_".$werf.".eenheden, v_meetstaat_werf_".$werf.".voorziene_HV, v_meetstaat_werf_".$werf.".prijs, v_meetstaat_werf_".$werf.".omschrijving FROM v_opmetingen_werf_".$werf." INNER JOIN v_meetstaat_werf_".$werf." ON v_opmetingen_werf_".$werf.".IDmeetstaat=v_meetstaat_werf_".$werf.".ID");

while($post = $posten->fetchrow(MDB2_FETCHMODE_ASSOC)){

	$msID = $post["idmeetstaat"];
	$nummer = $post["nummer"];
	$eenheden = $post["eenheden"];
	$hoeveelheid_ruw = $post["voorziene_hv"];
	$hoeveelheid = number_format($hoeveelheid_ruw,'3',',',' ');
	$eprijs_ruw = $post["prijs"];
	$eprijs = number_format($eprijs_ruw,'2',',',' ');
	
	//POST GEGEVENS OPHALEN	
			//MEETSTAAT ID
			$msID = $post["idmeetstaat"];	
		
			// $description = GetExtraInfoPost($msID,$werf);
			// 		
			// 			if(!empty($description))
			// 			{
			// 				foreach($description as $value)
			// 				{
			// 					if($value != ""){
			// 						$row = "".$value."\n";
			// 		
			// 					}
			// 		
			// 				}
			// 		
			// 			}
	
	$omschrijving = "".wordwrap($row."\n".$post["omschrijving"],150,"\n")."";
	
	//Initialize the table class, 5 columns with the specified widths
	$oTable->initialize(array(50, 30, 30, 25, 25), $aCustomConfiguration);
	
	$aRow = Array();
	$aRow[0]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[0]['TEXT'] = "<b>Postnr.: </b><t1>$nummer</t1>";
	$aRow[0]['TEXT_ALIGN'] = "L";
	$aRow[0]['BORDER_COLOR'] = array(0, 0, 0);
	$aRow[1]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[1]['COLSPAN'] = 2;
	$aRow[1]['TEXT'] = "<b>V.H.: </b><t1>$hoeveelheid</t1>";
	$aRow[1]['TEXT_ALIGN'] = "C";
	$aRow[1]['BORDER_COLOR'] = array(0, 0, 0);
	$aRow[3]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[3]['COLSPAN'] = 2;
	$aRow[3]['TEXT'] = "<b>Eenheidsprijs: </b><t1>".EUR." $eprijs</t1>";
	$aRow[3]['TEXT_ALIGN'] = "L";
	$aRow[3]['BORDER_COLOR'] = array(0, 0, 0);
	
	$oTable->addRow($aRow);
	
	$aRow = Array();
	$aRow[0]['TEXT'] = $omschrijving;
	$aRow[0]['COLSPAN'] = 5;
	$aRow[0]['TEXT_ALIGN'] = "L";
	$aRow[0]['BORDER_COLOR'] = array(0, 0, 0);
	$oTable->addRow($aRow);
	
	$res = GetTotaalOpgemetenPerPost($werf, $msID);
	$prijs = $res * $eprijs_ruw;
	
	$aRow = Array();
	$aRow[0]['COLSPAN'] = 2;
	$aRow[0]['TEXT'] = '<b>Totaal opgemeten: '.number_format($res,'3',',',' ').'</b>';
	$aRow[0]['TEXT_ALIGN'] = "L";
	$aRow[0]['BORDER_COLOR'] = array(0, 0, 0);
	$aRow[2]['COLSPAN'] = 3;
	$aRow[2]['TEXT'] = '<b>Totaal prijs: '.EUR.' '.number_format($prijs,'2',',',' ').'</b>';
	$aRow[2]['TEXT_ALIGN'] = "L";
	$aRow[2]['BORDER_COLOR'] = array(0, 0, 0);
	$oTable->addRow($aRow);
	
	$aRow = Array();
	$aRow[0]['TEXT'] = " ";
	$aRow[0]['COLSPAN'] = 5;
	$aRow[0]['TEXT_ALIGN'] = "L";
	$aRow[0]['BORDER_COLOR'] = array(0, 0, 0);
	$oTable->addRow($aRow);
	
	// Load data
	$opgemeten= 0;
	$opmetingen = $db->query("SELECT * FROM v_opmetingen_werf_".$werf." WHERE IDmeetstaat = '$msID'");
	
	$aRow = Array();
	$aRow[0]['COLSPAN'] = 3;
	$aRow[0]['TEXT'] = '<t1>Omschrijving/Berekening</t1>';
	$aRow[0]['TEXT_ALIGN'] = "L";
	$aRow[0]['BACKGROUND_COLOR'] = array(235, 235, 235);
	$aRow[0]['BORDER_COLOR'] = array(0, 0, 0);
	$aRow[3]['TEXT'] = '<t1>Uitgevoerd</t1>';
	$aRow[3]['TEXT_ALIGN'] = "L";
	$aRow[3]['BACKGROUND_COLOR'] = array(235, 235, 235);
	$aRow[3]['BORDER_COLOR'] = array(0, 0, 0);
	$aRow[4]['TEXT'] = '<t1>Bijlage</t1>';
	$aRow[4]['TEXT_ALIGN'] = "C";
	$aRow[4]['BACKGROUND_COLOR'] = array(235, 235, 235);
	$aRow[4]['BORDER_COLOR'] = array(0, 0, 0);
	$oTable->addRow($aRow);
	
	$rijnummer = 0;
	while($opmeting = $opmetingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
			
		$berekening = $opmeting["berekening"];
		$uitgevoerd = $opmeting["uitgevoerd"];
		
		if($opmeting["bijlage1"] != ""){
			$link = "<a href='bijlagen/".$opmeting["bijlage1"]."'>click to download</a>";
			// $link = "<a href='".$root."/files_dir/uploads/opmetingen".$userId."/".$opmeting["bijlage1"]."'>click to download</a>";
			}else{
			$link = "";
		}
			
		$aRow = Array();
		$aRow[0]['COLSPAN'] = 3;
		$aRow[0]['TEXT'] = '<t2>'.wordwrap($berekening, 60, " ", true).'</t2>';
		$aRow[0]['TEXT_ALIGN'] = "L";
		$aRow[0]['BORDER_COLOR'] = array(0, 0, 0);
		$aRow[3]['TEXT'] = '<t2>'.number_format($uitgevoerd,'3',',',' ').'</t2>';
		$aRow[3]['TEXT_ALIGN'] = "L";
		$aRow[3]['BORDER_COLOR'] = array(0, 0, 0);
		$aRow[4]['TEXT'] = '<t3>'.$link.'</t3>';
		$aRow[4]['TEXT_ALIGN'] = "C";
		$aRow[4]['BORDER_COLOR'] = array(0, 0, 0);
		if($rijnummer % 2){
			$aRow[0]['BACKGROUND_COLOR'] = array(224, 235, 255);
			$aRow[3]['BACKGROUND_COLOR'] = array(224, 235, 255);
			$aRow[4]['BACKGROUND_COLOR'] = array(224, 235, 255);
		}
		
		$oTable->addRow($aRow);
		$rijnummer++;
		
		$opgemeten = $opgemeten + $uitgevoerd;
			
		//BEREKEN GEMETEN en HV PRIJS
		$prijs = $eprijs_ruw*$opgemeten;
	}
	
	
	//close the table
	$oTable->close();
	$oFpdf->Ln(10);
}

$filename = "eindopmeting_".$werfnr.".pdf";


//send the pdf to the browser
$oFpdf->Output($filename,'D');
		
?>
