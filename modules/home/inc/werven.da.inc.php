<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("../../inc/db.inc.php");
		
        
        
        //Functie om werven op te halen aan de hand van  userID
        function GetToezichterByWerf($werf){
        		
        	global $db;
        		
        	$werflist = $db->query("SELECT * FROM werven WHERE ID =  $werf");
        	$werf = $werflist->fetchrow(MDB2_FETCHMODE_ASSOC);
        	
        		
        	return $werf;
        }
        
        //Functie om werven op te halen aan de hand van  userID
        function GetWervenAll(){
        
        	global $db;
        
        	$werflist = $db->query("SELECT *, TRIM(LEADING 'R' FROM nummer) AS sortnummer FROM werven WHERE actief != '2' ORDER BY sortnummer");
        
        	return $werflist;
        }
        
		//Functie om werven op te halen aan de hand van  userID
		function GetWervenByUserID($UserID){
			
            global $db;
			
			$werflist = $db->query("SELECT *, TRIM(LEADING 'R' FROM nummer) AS sortnummer FROM werven WHERE IDuser = '$UserID' AND actief != '2' ORDER BY sortnummer");
			
			return $werflist;
		}
		
		//Functie om werven op te halen aan de hand van  userID
		function GetWervenByUserIDArchief($UserID){
				
			global $db;
				
			$werflist = $db->query("SELECT * FROM werven where IDuser = '$UserID'");
				
			return $werflist;
		}
		
		//Functie om werf op te halen aan de hand van werfID
		function GetWerfByWerfID($id){
			
            global $db;
			
			$result = $db->query("SELECT * FROM werven where ID = '$id'");
			$werf = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
			return $werf;
		}
		
		//Functie inserten van werf in DB.
		
		function addWerf($id,$nummer,$omschrijving,$startdatum,$meetstaat){
			global $db;
			
		$db->query("INSERT INTO werven (ID, IDuser, nummer, omschrijving, datum, meetstaat) VALUES( 'NULL', '$id', '$nummer', '$omschrijving', '$startdatum','$meetstaat')");
		}
		
		//Functie inserten van werf in DB.
		
		function editWerf($id,$nummer,$omschrijving,$startdatum){
			global $db;
			
		$db->query("UPDATE werven SET nummer = '$nummer', omschrijving = '$omschrijving', startdatum = '$startdatum' WHERE ID = '$id'");
		}
		
		function setarchief($id){
			global $db;
				
			$db->query("UPDATE werven SET actief = '2' WHERE ID = '$id'");
		}

		
		//Functie werven verwijderen.
		function DeleteWerven($WerfID){
			global $db;
			
			$db->query("DELETE FROM `werven` WHERE `ID` = $WerfID");
		
		}
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>