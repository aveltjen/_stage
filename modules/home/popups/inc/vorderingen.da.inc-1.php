<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("db.inc.php");
		
		
		//Functie inserten van document in DB.
		
		function addVordering($werf,$user,$msID,$vs,$datum,$omschrijving,$uitgevoerd){
			global $db;
			
		$db->query("INSERT INTO vorderingen (vorderingen_ID, vorderingen_werven_ID, vorderingen_user_ID, vorderingen_meetstaat_ID, vorderingen_VS, vorderingen_datum, vorderingen_omschrijving, vorderingen_uitgevoerd) VALUES( 'NULL', '$werf', '$user', '$msID', '$vs', '$datum', '$omschrijving', '$uitgevoerd')");
		}
		
		//Functie om user op te halen aan de hand van zijn groep ID
		function GetVorderingenByPost($msID){
			
            global $db;
			
			$result = $db->query("SELECT * FROM vorderingen where vorderingen_meetstaat_ID = '$msID' ORDER BY vorderingen_ID");
			//$user = $result->fetchrow(DB_FETCHMODE_ASSOC);
			//return $user;
			return $result;
		}
		
		function deleteVordering($vid){
			global $db;
			
		$db->query("DELETE FROM vorderingen WHERE vorderingen_ID = $vid");
		}
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>