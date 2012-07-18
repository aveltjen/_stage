<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("../../inc/db.inc.php");
		
				
		function GetPostByID($msID,$werf){
			global $db;
			
			$result = $db->query("SELECT * FROM v_meetstaat_werf_".$werf." WHERE ID = '$msID'");
			$post = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
			
			return $post;
		}
		
		
		function GetTotaalOpgemetenPerPost($werf, $msID){
			global $db;
			global $totaal;
			
			$totaal = 0;
			$result = $db->query("SELECT * FROM v_opmetingen_werf_".$werf." WHERE IDmeetstaat = '$msID'");
			while($row = $result->fetchrow(MDB2_FETCHMODE_ASSOC)){
				
				$totaal = $row["uitgevoerd"] + $totaal;
				
			}	
			
			return $totaal;
		}
		
		function GetBedragUitgevoerdeWerken($werf){
			global $db;
							
			$totaal_post = 0;
			$totaal_werf = 0;
				$result = $db->query("SELECT v_opmetingen_werf_".$werf.".IDmeetstaat, v_opmetingen_werf_".$werf.".uitgevoerd, v_meetstaat_werf_".$werf.".nummer, v_meetstaat_werf_".$werf.".eenheden, v_meetstaat_werf_".$werf.".voorziene_HV, v_meetstaat_werf_".$werf.".prijs FROM v_opmetingen_werf_".$werf." INNER JOIN v_meetstaat_werf_".$werf." ON v_opmetingen_werf_".$werf.".IDmeetstaat=v_meetstaat_werf_".$werf.".ID");
				while($row = $result->fetchrow(MDB2_FETCHMODE_ASSOC)){
				
				//PRIJS POST GEVORDERD
				$prijs_post = $row["prijs"];
				$totaal_post = $row["uitgevoerd"] * $prijs_post;
				
				$totaal_werf = $totaal_werf + $totaal_post;
			}
				
			return $totaal_werf;
		}
		?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>