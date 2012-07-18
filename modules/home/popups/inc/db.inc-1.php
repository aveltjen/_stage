<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
	$dbUser = "root";
	$dbPass = "heyluv";
	$dbHost = "localhost";
	$dbName = "supervisorv3";

	$db = DB::connect("mysql://$dbUser:$dbPass@$dbHost/$dbName");
	
	if (DB::isError($db)) {
 		die($db->getMessage());
	}
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>
