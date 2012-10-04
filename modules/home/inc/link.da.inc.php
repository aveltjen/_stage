<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("../../inc/db.inc.php");
		

        //Functie insert link.
		function InsertLink($werf,$msID_select, $msID_link){
			global $db;
			
			$result = $db->query("INSERT INTO link (ID, werfID, IDmeetstaat_select, IDmeetstaat_link) VALUES( 'NULL', '$werf', '$msID_select', '$msID_link')");
		}
		
		
		
		function SelectLinkByPost($msID){
			global $db;
			
			$result = $db->query("SELECT IDmeetstaat_link, ID FROM link WHERE IDmeetstaat_select = '$msID' UNION SELECT IDmeetstaat_select, ID FROM link WHERE IDmeetstaat_link = '$msID'");
			
			$num = $result->numRows();
			
			if($num > 0){
					return $result;
			}else{
				return NULL;
			}
		}
		
		
		//Kijk of posten al zijn gelinkt
		function CheckIfLinked($IDmeetstaat_select,$IDmeetstaat_link){
			global $db;
			
			$result = $db->query("SELECT * FROM link WHERE IDmeetstaat_select = '$IDmeetstaat_select' AND IDmeetstaat_link = '$IDmeetstaat_link'");
			
			$num = $result->numRows();
			
				if($num == 1){
				
					return true;
					
				}else{
					
					$result = $db->query("SELECT * FROM link WHERE IDmeetstaat_link = '$IDmeetstaat_select' AND IDmeetstaat_select = '$IDmeetstaat_link'");

					$num = $result->numRows();
					
						if($num == 1){

							return true;

						}else{
							return false;
						}
				}
			
		}
		
		//Kijk of posten al zijn gelinkt
		function CheckIfHasLink($msID){
			global $db;
			
			$result = $db->query("SELECT * FROM link WHERE IDmeetstaat_select = '$msID'");
			
			$num = $result->numRows();
			
				if($num > 0){
				
					return true;
					
				}else{
					
					$result = $db->query("SELECT * FROM link WHERE IDmeetstaat_link = '$msID'");

					$num = $result->numRows();
					
						if($num > 0){

							return true;

						}else{
							return NULL;
						}
				}
			
		}
		
		function DeleteLink($linkID){
			global $db;
			
			$db->query("DELETE FROM link WHERE ID = '$linkID'");
		}
		
		function CheckLinkVordering($vid){
			global $db;
			
			$sql = $db->query("SELECT sleutel FROM link_vordering WHERE IDvordering = '$vid'");
			$result = $sql->fetchrow(MDB2_FETCHMODE_ASSOC);
			
			$num = $sql->numRows();
			
			if($num > 0){
				
				$sleutel = $result["sleutel"];
				$sql2 = $db->query("SELECT * FROM link_vordering WHERE sleutel = '$sleutel'");
				
				while($row = $sql2->fetchrow(MDB2_FETCHMODE_ASSOC)){
					$list[] = $row["idvordering"];
				}
			
				return $list;
						
			}else{
				return NULL;
			}
		}
		
		function DeleteLinkVordering($linkID){
			global $db;
			
			$db->query("DELETE FROM link_vordering WHERE IDvordering = '$linkID'");
		}
			
		
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>
