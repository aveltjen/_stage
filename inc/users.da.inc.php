<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("db.inc.php");
		
		//Funtie Authentication van de user)
		function AuthenticateUser($username,$password){
			
            global $db;
            
//          $db->setOption('result_buffering', false);
//			select all query -> bij aanmelden alle gegevens in sessie steken -> nadien geen user query meer nodig
			$result = $db->query("SELECT * FROM users where gebruikersnaam = '$username' AND paswoord = '$password'");
			$row = $result->fetchrow(MDB2_FETCHMODE_ASSOC);
			
			$num = $result->numRows();
			
				if($num == 1){
					return $row;
				}else{
					return null;	
				}
	
		}
			
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>