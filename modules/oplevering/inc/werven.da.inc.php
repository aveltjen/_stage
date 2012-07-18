<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("../../inc/db.inc.php");
				
		//Functie om werf op te halen aan de hand van werfID
		function GetWerfByWerfID($werf){
			
            global $db;
			
			$result = $db->query("SELECT * FROM werven where ID = '$werf'");
			$werf = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
			return $werf;
		}
		

		?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>