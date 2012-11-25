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
		
		
		//MEETSTAAT GET EXTRA INFO OF POST
			function GetExtraInfoPost($msID,$werf){
				global $db;
				
				$rij = array($msID-8,$msID-7,$msID-6,$msID-5,$msID-4,$msID-3,$msID-2,$msID-1);
				
				foreach ($rij as $waarde)
				{			
					$result = $db->query("SELECT * FROM v_meetstaat_werf_".$werf." WHERE ID = $waarde");
					$row = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
					if($row[nummer] == "" AND $row[eenheden] == ""){
						if($row[omschrijving] != "")
						{
							$description[] = $row[omschrijving];
						}	
					}
				}
			
					return $description;
			}
		
		?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>