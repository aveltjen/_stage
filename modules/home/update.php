<?php session_start(); define("IN_SITE", true); $self=$_SERVER['PHP_SELF'];

require("../../PEAR/MDB2.php");
require_once("../../PEAR/HTMLTemplate/IT.php");
require("inc/meetstaat.da.inc.php");
require("inc/opmetingen.da.inc.php");
require("inc/vorderingen.da.inc.php");
require("../../inc/db.inc.php");

//*********Template modifications***************
$tpl = new HTML_Template_IT("./");

$werf= $_REQUEST["werf"];

//GET MEETSTAAT BY WERFID
$meetstaat = GetFullVorderingsstaatByWerf($werf);
$tpl->setCurrentBlock("meetstaat");
while($post = $meetstaat->fetchrow(MDB2_FETCHMODE_ASSOC)){
	
	$msID = $post["id"];
	echo "".$msID."<BR>";
	
						//UPDATE MEETSTAAT
						//VORDERINGEN OPHALEN
					
						$vorderingen = GetVorderingenByPost($msID,$werf);
						$gh = 0;
						$tpl->setCurrentBlock("vorderingen");
							while($vordering = $vorderingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
								$gh = $gh + $vordering["uitgevoerd"];
								$tpl->parse("vorderingen");							}
		
						UpdateGH($gh,$msID,$werf);
						
						//Update meetstaat
						//OPMETINGEN OPHALEN
						
						$opmetingen = GetOpmetingenByPost($msID,$werf);
						$oh = 0;
						$tpl->setCurrentBlock("opmetingen");
						while($opmeting = $opmetingen->fetchrow(MDB2_FETCHMODE_ASSOC)){
							$oh = $oh + $opmeting["uitgevoerd"];
							$tpl->parse("opmetingen");
						}
						
						UpdateOH($oh,$msID,$werf);
	
	$tpl->parse("meetstaat");
}


