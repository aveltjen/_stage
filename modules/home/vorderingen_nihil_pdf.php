<?php session_start(); define("IN_SITE", true);define('EUR',chr(128));
	require_once("../oplevering/fpdf.php");
	require_once("myfpdf-table_overschrijding.php");
	require_once("../oplevering/class.fpdftable.php");
	require("../../PEAR/MDB2.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/vorderingen.da.inc.php");
	require("pdf/class.ezpdf.php");
	
	//$ebits = ini_get('error_reporting');
	//error_reporting($ebits ^ E_NOTICE);

	//** Werf ophalen
	$werf = $_REQUEST["werf"];

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
	$oFpdf->Image('../home/images/docbalk_nihil.png',20,10,170,'','','');
	$oFpdf->Image('../home/images/infrax.jpg',140,20,'',12,'','');
	$oFpdf->SetFont('','B','12');
	$oFpdf->Ln();
	$ns = wordwrap($project,48,"\n",true);
	$oFpdf->Write(5,'Project: '.$wnummer.' - '.$ns.'');
	$oFpdf->Ln();
	$oFpdf->Cell(10,7,'Toezichter: '.	$naam.'');
	$oFpdf->Ln();
	$oFpdf->SetFont('Arial','B','10');	
	// $oFpdf->Line(20, 52, 200,52);
	$oFpdf->Ln();
	$oFpdf->SetFont('','','10');
	
	$oTable = new fpdfTable($oFpdf);

	/**
	 * Set the tag styles
	 */
	$oTable->setStyle("p","times","",10,"130,0,30");
	$oTable->setStyle("b","arial","B",9,"0,0,0");
	$oTable->setStyle("t1","arial","",9,"0,0,0");
	$oTable->setStyle("t2","arial","I",9,"0,0,0");
	$oTable->setStyle("bi","times","BI",12,"0,0,120");
	$oTable->setStyle("t3","arial","U",9,"36,46,243");
	$oTable->setStyle("kop","arial","B",9,"0,0,0");

	
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
			$oTable->initialize(array(20, 60, 20, 20, 20, 20, 20), $aCustomConfiguration);

			$aRow = Array();
			$aRow[0]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[0]['TEXT'] = "<kop>Nr.</kop>";
			$aRow[0]['TEXT_ALIGN'] = "C";
			$aRow[0]['BORDER_COLOR'] = array(0, 0, 0);
			
			$aRow[1]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[1]['TEXT'] = "<kop>Omschrijving</kop>";
			$aRow[1]['TEXT_ALIGN'] = "C";
			$aRow[1]['BORDER_COLOR'] = array(0, 0, 0);
			
			$aRow[2]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[2]['TEXT'] = "<kop>VH/TP</kop>";	
			$aRow[2]['TEXT_ALIGN'] = "C";
			$aRow[2]['BORDER_COLOR'] = array(0, 0, 0);
			
			$aRow[3]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[3]['TEXT'] = "<kop>Eenheid</kop>";
			$aRow[3]['TEXT_ALIGN'] = "C";
			$aRow[3]['BORDER_COLOR'] = array(0, 0, 0);
			
			$aRow[4]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[4]['TEXT'] = "<kop>Eenheidsprijs</kop>";
			$aRow[4]['TEXT_ALIGN'] = "C";
			$aRow[4]['BORDER_COLOR'] = array(0, 0, 0);
			
			$aRow[5]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[5]['TEXT'] = "<kop>Voorziene hv.</kop>";
			$aRow[5]['TEXT_ALIGN'] = "C";
			$aRow[5]['BORDER_COLOR'] = array(0, 0, 0);
			
			$aRow[6]['BACKGROUND_COLOR'] = array(249,145,56);
			$aRow[6]['TEXT'] = "<kop>gevorderde hv.</kop>";
			$aRow[6]['TEXT_ALIGN'] = "C";
			$aRow[6]['BORDER_COLOR'] = array(0, 0, 0);
			
			$oTable->addRow($aRow);
			
		
		//** Vorderingsstaat ophalen
		$rijnummer = 0;
		//** Vorderingsstaat ophalen
		$vslist = GetFullVorderingsstaatByWerfNihil($werf);

		while($vs = $vslist->fetchrow(MDB2_FETCHMODE_ASSOC)){
				$aRow = Array();

				$aRow[0]['TEXT'] = $vs["nummer"];
				$aRow[0]['TEXT_ALIGN'] = "C";
				$aRow[0]['BORDER_COLOR'] = array(0, 0, 0);
				if($rijnummer % 2){
					$aRow[0]['BACKGROUND_COLOR'] = array(224, 235, 255);
				}
				
				$aRow[1]['TEXT'] = $vs["omschrijving"];
				$aRow[1]['TEXT_ALIGN'] = "C";
				$aRow[1]['BORDER_COLOR'] = array(0, 0, 0);
				if($rijnummer % 2){
					$aRow[1]['BACKGROUND_COLOR'] = array(224, 235, 255);
				}
				
				$aRow[2]['TEXT'] = $vs["vh_tb"];
				$aRow[2]['TEXT_ALIGN'] = "C";
				$aRow[2]['BORDER_COLOR'] = array(0, 0, 0);
				if($rijnummer % 2){
					$aRow[2]['BACKGROUND_COLOR'] = array(224, 235, 255);
				}
				
				$aRow[3]['TEXT'] = $vs["eenheden"];
				$aRow[3]['TEXT_ALIGN'] = "C";
				$aRow[3]['BORDER_COLOR'] = array(0, 0, 0);
				if($rijnummer % 2){
					$aRow[3]['BACKGROUND_COLOR'] = array(224, 235, 255);
				}
				
				$aRow[4]['TEXT'] = number_format($vs["prijs"],'2',',',' ');
				$aRow[4]['TEXT_ALIGN'] = "C";
				$aRow[4]['BORDER_COLOR'] = array(0, 0, 0);
				if($rijnummer % 2){
					$aRow[4]['BACKGROUND_COLOR'] = array(224, 235, 255);
				}
				
				$aRow[5]['TEXT'] = number_format($vs["voorziene_hv"],'3',',',' ');
				$aRow[5]['TEXT_ALIGN'] = "C";
				$aRow[5]['BORDER_COLOR'] = array(0, 0, 0);
				if($rijnummer % 2){
					$aRow[5]['BACKGROUND_COLOR'] = array(224, 235, 255);
				}
				
				$aRow[6]['TEXT'] = number_format($vs["totgevorderd"],3,',',' ');
				$aRow[6]['TEXT_ALIGN'] = "C";
				$aRow[6]['TEXT_COLOR'] = array(227, 27, 27);
				$aRow[6]['BORDER_COLOR'] = array(0, 0, 0);
				if($rijnummer % 2){
					$aRow[6]['BACKGROUND_COLOR'] = array(224, 235, 255);
				}
				
				$oTable->addRow($aRow);
				$rijnummer++;

		}
		

//close the table
$oTable->close();

$filename = "Posten_nihil".$wnummer.".pdf";


//send the pdf to the browser
$oFpdf->Output($filename,'D');
?>