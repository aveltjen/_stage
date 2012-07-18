<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("../../inc/db.inc.php");
		
		//Functie om document op te halen aan de hand van  userID
		function GetDocsByUserID($id){
			
            global $db;
			
			$doclist = $db->query("SELECT * FROM documents where IDuser = '$id'");
			
			return $doclist;
		}
		
		//Functie inserten van document in DB.
		
		function addDocument($docname,$Doclink,$UserID){
			global $db;
			
		$db->query("INSERT INTO documents (ID, Docname , Doclink, IDuser) VALUES( 'NULL', '$docname', '$Doclink', '$UserID')");
		}
		
		
				
		//Functie documents verwijderen.
		function DeleteDocuments($DocID,$UserID,$Doclink){
			global $db;
			
			$db->query("DELETE FROM `documents` WHERE `ID` = $DocID");
			
				$myFile = "uploads/documents".$UserID."/".$Doclink."";
				unlink($myFile);
		}
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>