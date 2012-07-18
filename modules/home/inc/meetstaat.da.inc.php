<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
       require("../../inc/db.inc.php");
		
		function GetFullVorderingsstaatByWerf($werf){
			global $db;
			

			$vslist = $db->query("SELECT * FROM v_meetstaat_werf_".$werf."");
			
			return $vslist;
		}
		
		function GetFullVorderingsstaatByWerfOverschreiding($werf){
			global $db;
				
		
			$vslist = $db->query("SELECT * FROM v_meetstaat_werf_".$werf." WHERE totGevorderd > voorziene_HV AND nummer !=''");
			
			return $vslist;
		}
		
		function GetFullVorderingsstaatByWerfNihil($werf){
			global $db;
		
		
			$vslist = $db->query("SELECT * FROM v_meetstaat_werf_".$werf." WHERE totGevorderd = '0' AND nummer != ''");
		
			return $vslist;
		}
		
		function GetPostByID($msID, $werf){
			global $db;
			
			$result = $db->query("SELECT * FROM v_meetstaat_werf_".$werf." WHERE ID = '$msID'");
			$post = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
			
			return $post;
		}
		
		//AANBESTEDINGSBEDRAG OPHALEN
		function GetAanbestedingsbedrag($werf){
			global $db;
			global $totaal;
			
			
				$posten = $db->query("SELECT * FROM v_meetstaat_werf_".$werf." WHERE nummer NOT LIKE 'V%' ORDER BY ID");
								
					$totaal = 0;
					while($post = $posten->fetchrow(MDB2_FETCHMODE_ASSOC)){
						$vh = $post["voorziene_hv"];
						$eprijs = $post["prijs"];
						
						$prijs = $vh*$eprijs;
						
						$totaal = $totaal + $prijs;
					}
				
			return $totaal;
		}
		
		function UpdateGH($gh,$msID,$werf){
			global $db;
		
			$db->query("UPDATE v_meetstaat_werf_".$werf." SET totGevorderd = '$gh' WHERE ID = '$msID'");
		
		}
		
		function UpdateOH($oh,$msID,$werf){
			global $db;
		
			$db->query("UPDATE v_meetstaat_werf_".$werf." SET totOpgemeten = '$oh' WHERE ID = '$msID'");
		
		}
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>
