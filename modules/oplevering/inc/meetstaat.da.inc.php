<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("../../inc/db.inc.php");
		
		
		//AANBESTEDINGSBEDRAG OPHALEN
		function GetBedragAanbesteding($werf){
			global $db;
				
			$totaal = 0;
			$result = $db->query("SELECT voorziene_hv, prijs FROM v_meetstaat_werf_".$werf." WHERE nummer NOT LIKE 'V%'");
			while($row = $result->fetchrow(MDB2_FETCHMODE_ASSOC)){
		
				$prijs = $row["voorziene_hv"] * $row["prijs"];
				$totaal = $prijs + $totaal;
			}
				
			return $totaal;
		}
		?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>