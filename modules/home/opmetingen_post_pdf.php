<?php session_start(); define("IN_SITE", true);
require('fpdf/fpdf.php');
require("../../PEAR/MDB2.php");
	require("inc/users.da.inc.php");
	require("inc/werven.da.inc.php");
	require("inc/meetstaat.da.inc.php");
	require("inc/opmetingen.da.inc.php");
	$ebits = ini_get('error_reporting');
error_reporting($ebits ^ E_NOTICE);
class PDF extends FPDF
{
//Load data
function LoadData()
{
	global $totaal;
//get data
$msID = $_REQUEST["msID"];
$werf = $_REQUEST["werf"];
$id = $user["id"];

$opmetingen = GetOpmetingenByPost($msID,$werf);	
$totaal = 0;
$data=array();
while($opmeting = $opmetingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
		
		$berekening = $opmeting["berekening"];
		$uitgevoerd = $opmeting["uitgevoerd"];
		if($opmeting["bijlage1"]==""){
		$bijlage = "" ;	
		}else{
		$bijlage = "http://supervisie.owt.be/modules/home/uploads/opmetingen".$opmeting["IDuser"]."/".$opmeting["bijlage1"]."" ;
		}
		$totaal = $totaal + $opmeting["uitgevoerd"];

		$data[] = array($berekening,$uitgevoerd,$bijlage) ;	
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
    $w=array(120,40,30);
    
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
//     	MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
        $this->MultiCell('120',7,$row[0],'LR',1,'L',$fill);
        $this->MultiCell('20',7,$row[1],'LR',1,'R',$fill);
        
        $this->MultiCell('20',7,$this->SetFont('','U','10').'download'.$this->Link($this->GetX(),$this->GetY(),30,20,$row[2]),'LR',0,'C',$fill);

        //$this->Cell($w[2],7,$this->Image('images/pin--arrow.gif',$this->GetX(),$this->GetY(),0,6,0,$row[2]),'LR',0,'R',$fill);
        $this->Ln();
        $this->SetFont('','','14');
        $fill=!$fill;

    }
    //Closure line
    $this->Cell(array_sum($w),0,'','T');
}

//Page footer
function Footer()
{
    //Position at 1.5 cm from bottom
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Page number
    $this->Cell(0,10,'door supervisie, product van owt',0,0,'L');
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'R');
    $this->Line(10, 283, 200, 283);
}


}

		//DOCUMENT HOOFDGEGEVENS OPHALEN
		$msID = $_REQUEST["msID"];
		$WerfID = $_REQUEST["werf"];
		$werf = GetWerfByWerfID($WerfID);
		
		$project = "".$werf["nummer"]." ".$werf["omschrijving"]."";	
		$wnummer = $werf["nummer"];
		
		//Post ophalen
		$post = GetPostByID($msID, $WerfID);
		$postnummer = $post["nummer"];
		$aard = $post["omschrijving"];
		$hoeveelheid = $post["voorziene_hv"];
		$eenheden = $post["eenheden"];


		
		
$pdf=new PDF();
$pdf->AliasNbPages();

//Column titles
$header=array('Omschrijving/Berekening','Gemeten','Bijlage');
//Data loading
$data=$pdf->LoadData();
$pdf->SetFont('Arial','B',14);
$pdf->AddPage();
$pdf->Image('images/docbalk.png','',9,'','','','');
$pdf->Image('images/infrax.jpg',160,20,'',12,'','');
$pdf->Cell(47,7,'DOC.NR.4');
$pdf->Cell(500,7,'OPMETINGEN EN BEREKENINGEN UITGEVOERDE WERKEN','','','L');
$pdf->Ln();
$pdf->SetFont('','','10');
$pdf->Cell(0,7,'postnummer: '.$postnummer.' / Verm.HV: '.$hoeveelheid.' / Eenheid: '.$eenheden.'');
$pdf->Ln();
$pdf->Cell(0,7,'Aard: '.$aard.'');
$pdf->Ln();
$pdf->Cell(0,7,'Project: '.$project.'');
$pdf->Line(10, 38, 200,38);
$pdf->Ln();
$pdf->SetFont('','U','14');
$pdf->Cell(180,30,'Totaal gemeten: '.$totaal.'','','','R');
$pdf->Ln();
$pdf->SetFont('','','14');
$pdf->ImprovedTable($header,$data);
$filename = "opmeting_post".$postnummer."_".$wnummer.".pdf";
$pdf->Output($filename,'D');
?>