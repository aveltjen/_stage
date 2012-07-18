<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("db.inc.php");
		
		//Functie om document op te halen aan de hand van  userID
		function GetDocsByUserID($id){
			
            global $db;
			
			$doclist = $db->query("SELECT * FROM documents where UserID = '$id'");
			
			return $doclist;
		}
		
		//Functie inserten van document in DB.
		
		function addDocument($docname,$Doclink,$UserID){
			global $db;
			
		$db->query("INSERT INTO documents (ID, Docname , Doclink, UserID) VALUES( 'NULL', '$docname', '$Doclink', '$UserID')");
		}
		
		//Functie om t echecken of document reeds bestaat.
		
		function checkDocument($Doclink,$UserID){
			global $db;
			
		$result = $db->query("SELECT *FROM documents WHERE Doclink='$Doclink' AND UserID='$UserID'");
		
		$num = $result->numRows();
			if($num >= 1){
				return true;
			}else{
				return false;	
			}	
		
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