<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("../../inc/db.inc.php");
		
        //Functie userprofiel wijzigen aan de hand van zijn ID.
		function UpdateUser($id, $Name, $Surename, $Street, $Place, $Phone, $Mobile, $Email, $Password){
			global $db;
			
		$db->query("UPDATE users SET naam='$Name', voornaam='$Surename',adres='$Street', woonplaats='$Place',telefoon='$Phone', mobiel ='$Mobile',email='$Email',paswoord='$Password' WHERE ID=$id");

		}
	
		//user gegevens ophalen (enkel voor PDF generatie)
		function getUserById($id){
			global $db;
				
			$sql = $db->query("SELECT * FROM users WHERE ID = '$id'");
			$result = $sql->fetchrow(MDB2_FETCHMODE_ASSOC);
			
			return $result;
		}	
				
		
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>