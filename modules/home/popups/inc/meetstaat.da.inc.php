<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
        require("db.inc.php");
		
		function GetFullVorderingsstaatByWerf($werf){
			global $db;
			
			$vslist = $db->query("SELECT * FROM meetstaat WHERE meetstaat_werven_ID = '$werf' ORDER BY meetstaat_ID");

			return $vslist;
		}
		
		function GetPostByID($msID){
			global $db;
			
			$result = $db->query("SELECT * FROM meetstaat WHERE meetstaat_ID = '$msID'");
			$post = $result->fetchrow(DB_FETCHMODE_ASSOC);
			
			return $post;
		}
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>