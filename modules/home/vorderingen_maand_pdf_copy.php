<?php session_start(); define("IN_SITE", true);define('EUR',chr(128));
	require('fpdf/fpdf.php');
	require("../../PEAR/MDB2.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/vorderingen.da.inc.php");
	require("pdf/class.ezpdf.php");
	
	$ebits = ini_get('error_reporting');
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
$project = "".$werfdata["nummer"]." ".$werfdata["omschrijving"]."";
$wnummer = $werfdata["nummer"];


//AANBESTEDING
$posten = $db->query("SELECT * FROM v_meetstaat_werf_".$werf." WHERE nummer NOT LIKE 'V%' ORDER BY ID");


$vtotaal2 = 0;
while($post = $posten->fetchrow(MDB2_FETCHMODE_ASSOC)){
	$vh = $post["voorziene_hv"];
	$eprijs = $post["prijs"];

	$prijs = $vh*$eprijs;

	$vtotaal2 = $vtotaal2 + $prijs;
}


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

class PDF extends FPDF
{
	//Load data
	function LoadData()
	{
		global $vsnum;
		global $periode;
		global $parameter2;
		global $tbedrag;
		global $vtotaal;
		global $project;
		global $werf;
		global $request;
		global $naam;	
			
	//1#POSTEN DIE IN DE PERIODE GEVORDER ZIJN EERST OPZOEKEN
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
	 		$data[] = array($msNummer,number_format($vorige,'3',',',' '),number_format($huidige,'3',',',' '),number_format($totaal,'3',',',' '),$bedrag) ;
	 		
			}
		
	    return $data;
	}

	//Better table
	function ImprovedTable($header,$data)
	{
		
		//Colors, line width and bold font
	    $this->SetFillColor(228,146,48);
	    $this->SetTextColor(255);
	    $this->SetDrawColor(0,0,0);
	    $this->SetLineWidth(.3);
	    $this->SetFont('','B');
	
	    //Header
	    $w=array(30,30,30,30,60);
	    
	    for($i=0;$i<count($header);$i++)
	        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
	    $this->Ln();
	    //Color and font restoration
	    $this->SetFillColor(224,235,255);
	    $this->SetTextColor(0);
	    $this->SetFont('');
	    //Data
	    $fill=false;
	    foreach($data as $row)
	    {
	        $this->Cell($w[0],7,$row[0],'LR',0,'C',$fill);
	        $this->Cell($w[1],7,$row[1],'LR',0,'R',$fill);
	        $this->Cell($w[2],7,$row[2],'LR',0,'R',$fill);
	        $this->Cell($w[3],7,$row[3],'LR',0,'R',$fill);
	        $this->Cell($w[4],7,$row[4],'LR',0,'R',$fill);
	        $this->Ln();
	        $this->SetFont('','','11');
	        $fill=!$fill;
	
	    }
	    //Closure line
	    $this->Cell(array_sum($w),0,'','T');
	}

	//Page footer
	function Footer()
	{
		global $project;
		global $vsnum;
	    //Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //Page number
	    $this->Cell(0,10,''.$vsnum.'- gegenereerd door supervisie, product van owt',0,0,'L');
	    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
	    $this->Line(10, 283, 200, 283);
	}

}	


$pdf=new PDF();
$pdf->AliasNbPages();

//Column titles
$header=array('Post Nr.','Vorige Hv.','Huidge Hv.','Totale Hv.','Bedrag ('.EUR.' )');
//Data loading
$data=$pdf->LoadData();
$pdf->SetFont('Arial','B',11);
$pdf->AddPage();
$pdf->Image('images/docbalk.png',10,10,190,'','','');
$pdf->Image('images/infrax.jpg',160,20,'',12,'','');
$pdf->Cell(125,7,'DOC.NR.3');
$pdf->Cell(540,7,'OPMAAK VORDERINGSTAAT','','','L');
$pdf->Ln();
$pdf->SetFont('','B','12');
$pdf->Cell(0,7,'Vorderingstaat: '.$vsnum.'');
$pdf->Ln();
$pdf->SetFont('','','11');
$pdf->Cell(0,7,'Periode: '.$periode.'');
$pdf->Ln();
$ns = wordwrap($project,50,"\n",true);
$pdf->Write(5, $ns);
$pdf->Ln();
$pdf->Cell(0,6,'Toezichter: '.$naam.'');
$pdf->Ln();
$pdf->Line(10, 45, 200,45);
$pdf->Ln();
$pdf->SetFont('','','10');
$pdf->Cell(20,'','Totaal aanbestedingsbedrag: '.EUR.' '.number_format($vtotaal2, 2, ',', ' ').'','','','L');
$pdf->Ln();
$pdf->Cell(20,10,'Totaal vorige vorderingen: '.EUR.' '.number_format($vtotaal, 2, ',', ' ').'','','','L');
$pdf->Ln();
$pdf->Line(10, 60, 200,60);
$pdf->SetFont('','B','12');
$pdf->Cell(180,20,'Totaal bedrag vorderingstaat: '.EUR.' '.number_format($tbedrag, 2, ',', ' ').'','','','R');
$pdf->Ln();
$pdf->SetFont('','','11');
$pdf->ImprovedTable($header,$data);
$filename = "".$vsnum."_".$periode."_".$wnummer.".pdf";
$pdf->Output($filename,'D');
?>