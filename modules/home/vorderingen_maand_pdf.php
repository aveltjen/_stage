<?php session_start(); define("IN_SITE", true);define('EUR',chr(128));
	require_once("../oplevering/fpdf.php");
	require_once("myfpdf-table_vs.php");
	require_once("../oplevering/class.fpdftable.php");
	require("../../PEAR/MDB2.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/vorderingen.da.inc.php");
	require("pdf/class.ezpdf.php");
	
	//$ebits = ini_get('error_reporting');
	//error_reporting($ebits ^ E_NOTICE);

	//REQUESTS
	$werf = $_REQUEST["werf"];
	$periode = $_REQUEST["periode"];
	$vsnum = $_REQUEST["vs"];
	$userid = $_REQUEST["id"];

	//USERINFO
	//toezichter ophalen
		$toezichterid = GetToezichterByWerf($werf);
		$toezichterdata = getUserById($toezichterid["iduser"]);


		$naam = "".$toezichterdata["voornaam"]." ".$toezichterdata["naam"]."";

	//WERFINFO
	$werfdata = GetWerfByWerfID($werf);
	$project = "".$werfdata["omschrijving"]."";
	$wnummer = $werfdata["nummer"];


	//create the fpdf object and do some initialization
	$oFpdf = new myFpdf();
	$oFpdf->Open();
	$oFpdf->SetAutoPageBreak(true, 20);
	$oFpdf->SetMargins(20, 20, 20);
	$oFpdf->AddPage();
	$oFpdf->AliasNbPages();
	$oFpdf->SetFont('Arial','','9');
	$oFpdf->Image('../home/images/docbalk_vs.png',20,10,150,'','','');
	$oFpdf->Image('../home/images/infrax.jpg',140,20,'',12,'','');
	$oFpdf->SetFont('','B','12');
	$oFpdf->Cell(10,7,'Vorderingstaat: '.$vsnum.'');
	$oFpdf->SetFont('','','11');
	$oFpdf->Ln();
	$oFpdf->Cell(10,7,'Periode: '.$periode.'');
	$oFpdf->Ln();
	$ns = wordwrap($project,48,"\n",true);
	$oFpdf->Write(5,'Project: '.$wnummer.' - '.$ns.'');
	$oFpdf->Ln();
	$oFpdf->Cell(10,7,'Toezichter: '.	$naam.'');
	$oFpdf->Ln();
	$oFpdf->SetFont('Arial','B','10');	
	$oFpdf->Line(20, 52, 200,52);
	$oFpdf->Ln();
	$oFpdf->SetFont('','','10');
	
	//AANBESTEDING
		$posten = $db->query("SELECT * FROM v_meetstaat_werf_".$werf." WHERE nummer NOT LIKE 'V%' ORDER BY ID");
		$vtotaal2 = 0;
		while($post = $posten->fetchrow(MDB2_FETCHMODE_ASSOC)){
			$vh = $post["voorziene_hv"];
			$eprijs = $post["prijs"];

			$prijs = $vh*$eprijs;

			$vtotaal2 = $vtotaal2 + $prijs;
		}
	
	$oFpdf->Cell(20,'','Totaal aanbestedingsbedrag: '.EUR.' '.number_format($vtotaal2, 2, ',', ' ').'','','','L');
	$oFpdf->Ln();
	
	//VORIGE PERIODE TOTAAL
		//explode parameter2(full date)
		$result = explode('-', $periode);
		$a = $result[0];
		$b = $result[1];
		$parameter2 = "".$b."-".$a."-01";

		$vtotaal = 0;
		$rows = GetAllVorderingenByVorigePeriode($parameter2,$werf);
		while($row = $rows->fetchrow(MDB2_FETCHMODE_ASSOC)){

			$uitgevoerd = $row["uitgevoerd"];
			$msID2 = $row["idmeetstaat"];

			$result = GetPostByID($msID2, $werf);
			$eprijs2 = $result["prijs"];

			//prijs per post
			$vprijs=$eprijs2*$uitgevoerd;

			//prijs totaal post
			$vtotaal = $vtotaal + $vprijs;
		}
	
	$oFpdf->Cell(20,10,'Totaal vorige vorderingen: '.EUR.' '.number_format($vtotaal, 2, ',', ' ').'','','','L');
	$oFpdf->Ln();
	
	$oFpdf->Line(20, 68, 200,68);
	$oFpdf->SetFont('','B','12');
	
	
	//1#TOTAAL BEDRAG ZOEKEN
			$tbedrag = 0;
			$posten = GetPostByPeriode($periode,$werf);
			
			while($post = $posten->fetchrow(MDB2_FETCHMODE_ASSOC)){
				
				//2#POSTEN ID AFDRUKKEN IN CEL 1	
				$msID = $post["idmeetstaat"];
				
				$postnummer = GetPostByID($msID, $werf);
				$msNummer = $postnummer["nummer"];
				

				//3#VORIGE HOEVEELHEID OPZOEKEN				
				$resultaat = GetAllVorigeVorderingenByPeriode($msID,$parameter2,$werf);
				$vorige= 0;
				while($res = $resultaat->fetchrow(MDB2_FETCHMODE_ASSOC)){
					$uitgevoerd = $res["uitgevoerd"];
				
					$vorige = $vorige + $uitgevoerd;	
				}
				
				
				
				//4#hUIDIGE HOEVEELHEID VAN DE POST OPZOEKEN
				$resultaat = GetAllVorderingenByPeriode($msID,$periode,$werf);
				$huidige = 0;
				while($res = $resultaat->fetchrow(MDB2_FETCHMODE_ASSOC)){
					$uitgevoerd = $res["uitgevoerd"];
					
					$huidige = $huidige + $uitgevoerd;	
				}
				
				
				//5#TOTAAL GEVORDERDE HOEVEELHEID
				$totaal = $huidige + $vorige;
				
			
				//6#TOTAAL BEDRAG
				$eprijs = $postnummer["prijs"];
				$prijs= $huidige * $eprijs;
				$bedrag= "".EUR." ".number_format($prijs, 2, ',', ' ')." (EP = ".EUR." ".number_format($eprijs, 2, ',', ' ').")";
				
				//Totaal staat
				$tbedrag= $prijs + $tbedrag;
	 	
		}
		
	$oFpdf->Cell(180,20,'Totaal bedrag vorderingstaat: '.EUR.' '.number_format($tbedrag, 2, ',', ' ').'','','','R');
	$oFpdf->Ln();
	$oFpdf->SetFont('','','11');
	
	

	$oTable = new fpdfTable($oFpdf);

	/**
	 * Set the tag styles
	 */
	$oTable->setStyle("p","times","",10,"130,0,30");
	$oTable->setStyle("b","arial","B",7,"0,0,0");
	$oTable->setStyle("t1","arial","",9,"0,0,0");
	$oTable->setStyle("t2","arial","I",7,"0,0,0");
	$oTable->setStyle("bi","times","BI",12,"0,0,120");
	$oTable->setStyle("t3","arial","U",7,"36,46,243");
	$oTable->setStyle("kop","arial","B",7,"0,0,0");

	
	//change multiple values
	$aCustomConfiguration = array(
	        'TABLE' => array(
	                'TABLE_ALIGN'       => 'C',                 //left align
	                'BORDER_COLOR'      => array(0, 0, 0),      //border color
	                'BORDER_SIZE'       => '0.2',               //border size
	        )
	);

	//LOAD DATA
			//Initialize the table class, 5 columns with the specified widths
			$oTable->initialize(array(30, 30, 30, 30, 40), $aCustomConfiguration);

			$aRow = Array();
			$aRow[0]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[0]['TEXT'] = "<kop>Post Nr.</kop>";
			$aRow[0]['TEXT_ALIGN'] = "C";
			$aRow[0]['BORDER_COLOR'] = array(0, 0, 0);
			
			$aRow[1]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[1]['TEXT'] = "<kop>Vorige Hv.</kop>";
			$aRow[1]['TEXT_ALIGN'] = "C";
			$aRow[1]['BORDER_COLOR'] = array(0, 0, 0);
			
			$aRow[2]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[2]['TEXT'] = "<kop>Huidige Hv.</kop>";	
			$aRow[2]['TEXT_ALIGN'] = "C";
			$aRow[2]['BORDER_COLOR'] = array(0, 0, 0);
			
			$aRow[3]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[3]['TEXT'] = "<kop>Totale Hv.</kop>";
			$aRow[3]['TEXT_ALIGN'] = "C";
			$aRow[3]['BORDER_COLOR'] = array(0, 0, 0);
			
			$aRow[4]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[4]['TEXT'] = "<kop>Bedrag (".EUR." )</kop>";
			$aRow[4]['TEXT_ALIGN'] = "C";
			$aRow[4]['BORDER_COLOR'] = array(0, 0, 0);
			
			$oTable->addRow($aRow);
			
	//1#POSTEN DIE IN DE PERIODE GEVORDER ZIJN EERST OPZOEKEN
			$tbedrag = 0;
			
			$posten = GetPostByPeriode($periode,$werf);
			
			while($post = $posten->fetchrow(MDB2_FETCHMODE_ASSOC)){
				$aRow = Array();
				
				//2#POSTEN ID AFDRUKKEN IN CEL 1	
				$msID = $post["idmeetstaat"];
				
				$postnummer = GetPostByID($msID, $werf);
				$msNummer = $postnummer["nummer"];
				
				$aRow[0]['TEXT'] = $msNummer;
				$aRow[0]['TEXT_ALIGN'] = "C";
				$aRow[0]['BORDER_COLOR'] = array(0, 0, 0);
				
				
				//3#VORIGE HOEVEELHEID OPZOEKEN				
				$resultaat = GetAllVorigeVorderingenByPeriode($msID,$parameter2,$werf);
				$vorige= 0;
				while($res = $resultaat->fetchrow(MDB2_FETCHMODE_ASSOC)){
					$uitgevoerd = $res["uitgevoerd"];
				
					$vorige = $vorige + $uitgevoerd;	
				}
				
				$aRow[1]['TEXT'] = number_format($vorige,'3',',',' ');
				$aRow[1]['TEXT_ALIGN'] = "C";
				$aRow[1]['BORDER_COLOR'] = array(0, 0, 0);
				
				
				//4#hUIDIGE HOEVEELHEID VAN DE POST OPZOEKEN
				$resultaat = GetAllVorderingenByPeriode($msID,$periode,$werf);
				$huidige = 0;
				while($res = $resultaat->fetchrow(MDB2_FETCHMODE_ASSOC)){
					$uitgevoerd = $res["uitgevoerd"];
					
					$huidige = $huidige + $uitgevoerd;	
				}
				
				$aRow[2]['TEXT'] = number_format($huidige,'3',',',' ');
				$aRow[2]['TEXT_ALIGN'] = "C";
				$aRow[2]['BORDER_COLOR'] = array(0, 0, 0);
				
				
				//5#TOTAAL GEVORDERDE HOEVEELHEID
				$totaal = $huidige + $vorige;
				
				$aRow[3]['TEXT'] = number_format($totaal,'3',',',' ');
				$aRow[3]['TEXT_ALIGN'] = "C";
				$aRow[3]['BORDER_COLOR'] = array(0, 0, 0);
				
				//6#TOTAAL BEDRAG
				$eprijs = $postnummer["prijs"];
				$prijs= $huidige * $eprijs;
				$bedrag= "".EUR." ".number_format($prijs, 2, ',', ' ')." (EP = ".EUR." ".number_format($eprijs, 2, ',', ' ').")";
				$aRow[4]['TEXT'] = $bedrag;
				$aRow[4]['TEXT_ALIGN'] = "C";
				$aRow[4]['BORDER_COLOR'] = array(0, 0, 0);
			
				//Totaal staat
				$tbedrag= $prijs + $tbedrag;
	 		
	 		
			$oTable->addRow($aRow);
		}
		

//Column titles
//$header=array('Post Nr.','Vorige Hv.','Huidge Hv.','Totale Hv.','Bedrag ('.EUR.' )');
//Data loading
// $pdf->Cell(125,7,'DOC.NR.3');
// $pdf->SetFont('','B','12');
// $pdf->Cell(0,7,'Vorderingstaat: '.$vsnum.'');
// $pdf->Ln();
// $pdf->SetFont('','','11');
// $pdf->Cell(0,7,'Periode: '.$periode.'');
// $pdf->Ln();
// $ns = wordwrap($project,50,"\n",true);
// $pdf->Write(5, $ns);
// $pdf->Ln();
// $pdf->Cell(0,6,'Toezichter: '.$naam.'');
// $pdf->Ln();
// $pdf->Line(10, 45, 200,45);
// $pdf->Ln();
// $pdf->SetFont('','','10');
// $pdf->Cell(20,'','Totaal aanbestedingsbedrag: '.EUR.' '.number_format($vtotaal2, 2, ',', ' ').'','','','L');
// $pdf->Ln();
// $pdf->Cell(20,10,'Totaal vorige vorderingen: '.EUR.' '.number_format($vtotaal, 2, ',', ' ').'','','','L');
// $pdf->Ln();
// $pdf->Line(10, 60, 200,60);
// $pdf->SetFont('','B','12');
// $pdf->Cell(180,20,'Totaal bedrag vorderingstaat: '.EUR.' '.number_format($tbedrag, 2, ',', ' ').'','','','R');
// $pdf->Ln();
// $pdf->SetFont('','','11');

//close the table
$oTable->close();
$oFpdf->Ln(10);

$filename = "".$vsnum."_".$periode."_".$wnummer.".pdf";


//send the pdf to the browser
$oFpdf->Output($filename,'D');
?>