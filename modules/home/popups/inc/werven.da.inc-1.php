<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("db.inc.php");
		
		//Functie om werven op te halen aan de hand van  userID
		function GetWervenByUserID($UserID){
			
            global $db;
			
			$werflist = $db->query("SELECT * FROM werven where UserID = '$UserID'");
			
			return $werflist;
		}
		
		//Functie om werf op te halen aan de hand van werfID
		function GetWerfByWerfID($WerfID){
			
            global $db;
			
			$result = $db->query("SELECT * FROM werven where ID = '$WerfID'");
			$werf = $result->fetchrow(DB_FETCHMODE_ASSOC);
			return $werf;
		}
		
		//Functie inserten van werf in DB.
		
		function addWerf($UserID,$Number,$Description,$Year,$Month,$Day){
			global $db;
			
		$db->query("INSERT INTO werven (ID, UserID , Number, Description, Year, Month, Day) VALUES( 'NULL', '$UserID', '$Number', '$Description', '$Year', '$Month', '$Day')");
		}
		

		
		//Functie werven verwijderen.
		function DeleteWerven($WerfID){
			global $db;
			
			$db->query("DELETE FROM `werven` WHERE `ID` = $WerfID");
		
		}
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>