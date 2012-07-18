<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("../../inc/db.inc.php");
		
		//user gegevens ophalen (enkel voor PDF generatie)
		function getUserById($userId){
			global $db;
				
			$sql = $db->query("SELECT * FROM users WHERE ID = '$userId'");
			$result = $sql->fetchrow(MDB2_FETCHMODE_ASSOC);
			
			return $result;
		}	
				
		
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>