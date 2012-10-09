<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];
	//********Requirements & Includes***************
	require_once("../oplevering/fpdf.php");
	require_once("myfpdf-table.php");
	require_once("../oplevering/class.fpdftable.php");
	require("../../PEAR/MDB2.php");
	require("../../inc/db.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/opmetingen.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/users.da.inc.php");

	// $ebits = ini_get('error_reporting');
	// error_reporting($ebits ^ E_NOTICE);
	//*********Check user session***************	
	if(!isset($_SESSION["user"])){
		header("Location: ../../index.php");
		exit;
	}else{
		$user = $_SESSION["user"];	
	}
	//*********WerfID ophalen***************
	$WerfID = $_REQUEST["werf"];
	//** Werf ophalen
	$werf = GetWerfByWerfID($WerfID);
	$werf_omschrijving = $werf["omschrijving"];
	$werfnr = $werf["nummer"];

	//toezichter ophalen
	$toezichterid = GetToezichterByWerf($WerfID);
	$toezichterdata = getUserById($toezichterid["iduser"]);
	
	$toezichter = "".$toezichterdata["voornaam"]." ".$toezichterdata["naam"]."";
	
	//DEEL1 HOOFDING-------------------------------------------------------------------------------------------
		//create the fpdf object and do some initialization
		$oFpdf = new myFpdf();
		$oFpdf->Open();
		$oFpdf->SetAutoPageBreak(true, 20);
		$oFpdf->SetMargins(20, 20, 20);
		$oFpdf->AddPage();
		$oFpdf->AliasNbPages();
		$oFpdf->SetFont('Arial','','9');
		$oFpdf->Image('../home/images/meetstaat.png',20,10,170,'','','');
		$oFpdf->Image('../home/images/infrax.jpg',140,20,'',12,'','');
		$oFpdf->Ln();
		$ns = wordwrap($werf_omschrijving,48,"\n",true);
		$oFpdf->Write(5,'Project: '.$werfnr.' - '.$ns.'');
		$oFpdf->Ln();
		$oFpdf->Cell(0,6,'Toezichter: '.$toezichter.'');
		$oFpdf->SetFont('Arial','B','10');	
		$oFpdf->Ln(10);

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
	
	//DEEL2 POSTENBOEK CONTENT-------------------------------------------------------------------------------------------

	//Initialize the table class, 5 columns with the specified widths
	$oTable->initialize(array(15, 60, 13, 12, 20, 20, 23, 20));
	
	$aRow = Array();
	$aRow[0]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[0]['TEXT'] = "<b>Nr.</b>";
	$aRow[0]['TEXT_ALIGN'] = "L";
	
	$aRow[1]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[1]['TEXT'] = "<b>Omschrijving</b>";
	$aRow[1]['TEXT_ALIGN'] = "C";
	
	$aRow[2]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[2]['TEXT'] = "<b>VH/TP</b>";
	$aRow[2]['TEXT_ALIGN'] = "L";
	
	$aRow[3]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[3]['TEXT'] = "<b>Eenheid</b>";
	$aRow[3]['TEXT_ALIGN'] = "L";
	
	$aRow[4]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[4]['TEXT'] = "<b>Eenheidsprijs</b>";
	$aRow[4]['TEXT_ALIGN'] = "L";
	
	$aRow[5]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[5]['TEXT'] = "<b>Voorziene hv.</b>";
	$aRow[5]['TEXT_ALIGN'] = "L";
	
	$aRow[6]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[6]['TEXT'] = "<b>Gevorderde hv.</b>";
	$aRow[6]['TEXT_ALIGN'] = "L";
	
	$aRow[7]['BACKGROUND_COLOR'] = array(236, 185, 124);
	$aRow[7]['TEXT'] = "<b>Opgemeten hv.</b>";
	$aRow[7]['TEXT_ALIGN'] = "L";
	
	$oTable->addRow($aRow);

	//** Vorderingsstaat ophalen
	$vslist = GetFullVorderingsstaatByWerf($WerfID);
	
	while($vs = $vslist->fetchrow(MDB2_FETCHMODE_ASSOC)){

		if($vs["nummer"] != "" AND $vs["voorziene_hv"] != ""){
			
			if($vs["vh_tb"] == "" AND $vs["eenheden"] == "")
			{
				$nummer = "";
				$omschrijving = wordwrap($vs["omschrijving"], 100, "\n", true);
				$VHTP = "";
				$eenheden = "";
				
				if($vs["voorziene_hv"]==0){
					$voorzien ="";
				}else{
					$voorzien = $vs["voorziene_hv"];
				}
				
				$eenheidsprijs = "";
				$gevorderd = "";
				$opmeten = "";
				
				$aRow = Array();
				
				$aRow[0]['BACKGROUND_COLOR'] = array(221, 238, 218);
				$aRow[0]['TEXT'] = $nummer;
				$aRow[0]['TEXT_ALIGN'] = "L";
				
				$aRow[1]['BACKGROUND_COLOR'] = array(221, 238, 218);
				$aRow[1]['TEXT'] = $omschrijving;
				$aRow[1]['TEXT_ALIGN'] = "L";
				
				$aRow[2]['BACKGROUND_COLOR'] = array(221, 238, 218);
				$aRow[2]['TEXT'] = $VHTP;
				$aRow[2]['TEXT_ALIGN'] = "L";
				
				$aRow[3]['BACKGROUND_COLOR'] = array(221, 238, 218);
				$aRow[3]['TEXT'] = $eenheden;
				$aRow[3]['TEXT_ALIGN'] = "L";
				
				$aRow[4]['BACKGROUND_COLOR'] = array(221, 238, 218);
				$aRow[4]['TEXT'] = $eenheidsprijs;
				$aRow[4]['TEXT_ALIGN'] = "L";
				
				$aRow[5]['BACKGROUND_COLOR'] = array(221, 238, 218);
				$aRow[5]['TEXT'] = $voorzien;
				$aRow[5]['TEXT_ALIGN'] = "L";
				
				$aRow[6]['BACKGROUND_COLOR'] = array(221, 238, 218);
				$aRow[6]['TEXT'] = $gevorderd;
				$aRow[6]['TEXT_ALIGN'] = "L";
				
				$aRow[7]['BACKGROUND_COLOR'] = array(221, 238, 218);
				$aRow[7]['TEXT'] = $opmeten;
				$aRow[7]['TEXT_ALIGN'] = "L";
				
				
				$oTable->addRow($aRow);
					
			}else{
				$nummer = $vs["nummer"];
				$omschrijving = wordwrap($vs["omschrijving"], 50, "\n", true);
				$VHTP = $vs["vh_tb"];
				$eenheden = $vs["eenheden"];
				$voorziene_hv = $vs["voorziene_hv"];
							if ($voorziene_hv != "0") {
								$voorzien = number_format($voorziene_hv,3,',','');
							} else {
								$voorzien = "";
							}
				
				$eenheidsprijs = number_format($vs["prijs"],2,',','');

				$class = "vs";
				
				//VORDERINGEN OPHALEN
					$gh = $vs["totgevorderd"];		
					
							
							if ($gh != "0" AND $gh !== NULL) {
								$gevorderd = number_format($gh,3,',','');
							} else {
								if ($gh === NULL){
									$gevorderd = "";
								}else{
									$gevorderd = number_format($gh,3,',','');
								}
								
							}
				
				//OPMETINGEN OPHALEN
					$oh = $vs["totopgemeten"];		
					
							if ($oh != "0" AND $oh !== NULL) {
								$opgemeten = number_format($oh,3,',','');
							} else {
								if ($oh === NULL){
									$opgemeten = "";
								}else{
									$opgemeten = number_format($oh,3,',','');
								}
								
							}
							
							$aRow = Array();
							
							$aRow[0]['TEXT'] = $nummer;
							$aRow[0]['TEXT_ALIGN'] = "L";
							
							
							$aRow[1]['TEXT'] = $omschrijving;
							$aRow[1]['TEXT_ALIGN'] = "L";
							
							$aRow[2]['TEXT'] = $VHTP;
							$aRow[2]['TEXT_ALIGN'] = "L";
							
							$aRow[3]['TEXT'] = $eenheden;
							$aRow[3]['TEXT_ALIGN'] = "L";
							
							$aRow[4]['TEXT'] = $eenheidsprijs;
							$aRow[4]['TEXT_ALIGN'] = "L";
							
							$aRow[5]['TEXT'] = $voorzien;
							$aRow[5]['TEXT_ALIGN'] = "L";

							$aRow[6]['TEXT'] = $gevorderd;
							$aRow[6]['TEXT_ALIGN'] = "L";
							
							$aRow[7]['TEXT'] = $opgemeten;
							$aRow[7]['TEXT_ALIGN'] = "L";

							$oTable->addRow($aRow);
							
			}
		}else{
			
			$nummer = "";
			$omschrijving = wordwrap($vs["omschrijving"], 50, "\n", true);

			$VHTP = "";
			$eenheden = "";
			
			if($vs["voorziene_hv"]==0){
				$voorzien = "";
			}else{
				$voorzien = $vs["voorziene_hv"];
			}
			
			$eenheidsprijs = "";
			$gevorderd = "";
			$opmeten = "";
			$class = "novs";
			
			$aRow = Array();
			
			$aRow[0]['BACKGROUND_COLOR'] = array(221, 238, 218);
			$aRow[0]['TEXT'] = "<b>".$nummer."</b>";
			$aRow[0]['TEXT_ALIGN'] = "L";
			
			$aRow[1]['BACKGROUND_COLOR'] = array(221, 238, 218);
			$aRow[1]['TEXT'] = "<b>".$omschrijving."</b>";
			$aRow[1]['TEXT_ALIGN'] = "L";
			
			$aRow[2]['BACKGROUND_COLOR'] = array(221, 238, 218);
			$aRow[2]['TEXT'] = "<b>".$VHTP."</b>";
			$aRow[2]['TEXT_ALIGN'] = "L";
		
			$aRow[3]['BACKGROUND_COLOR'] = array(221, 238, 218);
			$aRow[3]['TEXT'] = "<b>".$eenheden."</b>";
			$aRow[3]['TEXT_ALIGN'] = "L";
			
			$aRow[4]['BACKGROUND_COLOR'] = array(221, 238, 218); 
			$aRow[4]['TEXT'] = "<b>".$eenheidsprijs."</b>";
			$aRow[4]['TEXT_ALIGN'] = "L";
			
			$aRow[5]['BACKGROUND_COLOR'] = array(221, 238, 218); 
			$aRow[5]['TEXT'] = "<b>".$voorzien."</b>";
			$aRow[5]['TEXT_ALIGN'] = "L";
			
			$aRow[6]['BACKGROUND_COLOR'] = array(221, 238, 218); 
			$aRow[6]['TEXT'] = "<b>".$gevorderd."</b>";
			$aRow[6]['TEXT_ALIGN'] = "L";
			
			$aRow[7]['BACKGROUND_COLOR'] = array(221, 238, 218); 
			$aRow[7]['TEXT'] = "<b>".$opmeten."</b>";
			$aRow[7]['TEXT_ALIGN'] = "L";

			$oTable->addRow($aRow);
			
		}
		
	}
	
	
	//********************* Template Tonen *************
	//close the table
	$oTable->close();
	$oFpdf->Ln(10);
	
	$filename = "meetstaat_".$werfnr.".pdf";


	//send the pdf to the browser
	$oFpdf->Output($filename,'D');
	
?>
