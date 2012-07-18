<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("../../inc/db.inc.php");
		
		
        //Functie laatst ingevoerd vordering ophalen.
		
		function GetLastInsertO($werf,$id){
			global $db;
			
		$result = $db->query("SELECT * FROM v_opmetingen_werf_".$werf." WHERE IDuser='$id' ORDER BY `ID` DESC LIMIT 0,1");
		$lastopmeting = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
		
		return $lastopmeting;
		}
        
		//Functie inserten van document in DB.
		
		function addOpmeting($werf,$user,$msID,$datum,$omschrijving,$uitgevoerd,$bijlage,$werf){
			global $db;
			
		$db->query("INSERT INTO v_opmetingen_werf_".$werf." (ID, IDmeetstaat, IDuser, datum, berekening, uitgevoerd, bijlage1) VALUES( 'NULL', '$msID', '$user', '$datum', '$omschrijving', '$uitgevoerd', '$bijlage')");
		}
		
		//Functie om user op te halen aan de hand van zijn groep ID
		function GetOpmetingenByPost($msID,$werf){
			
            global $db;
            
			$result = $db->query("SELECT * FROM v_opmetingen_werf_".$werf." where IDmeetstaat = '$msID'");
			
			return $result;
		}
		
		function GetOpmetingByVid($vid,$werf){
			
            global $db;
			
			$result = $db->query("SELECT * FROM v_opmetingen_werf_".$werf." where ID = '$vid' ORDER BY ID");
			$vordering = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
			
			return $vordering;
		}
		
	

		function deleteOpmeting($vid){
			global $db;
			
		$db->query("DELETE FROM opmetingen WHERE ID = $vid");
		}
		
		
		
		function UpdateOpmeting($vid,$datum_new,$omschrijving_new,$uitgevoerd_new,$bijlage_new,$werf){
			global $db;
			
		$db->query("UPDATE v_opmetingen_werf_".$werf." SET datum = '$datum_new', berekening = '$omschrijving_new', uitgevoerd = '$uitgevoerd_new', bijlage1 = '$bijlage_new' WHERE ID = '$vid'");

		}
		
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>
