<?php if(defined("IN_SITE")) { // Hack protection
############################################## ?>
<?php
	$dbUser = "root";
	$dbPass = "root";
	$dbHost = "localhost";
	$dbName = "_stage";

	$db =& MDB2::connect("mysql://$dbUser:$dbPass@$dbHost/$dbName");
	if (PEAR::isError($db)) {
		die($db->getMessage());
	}
	
// 	$db = DB::connect("mysql://$dbUser:$dbPass@$dbHost/$dbName");
	
// 	if (DB::isError($db)) {
//  		die($db->getMessage());
// 	}
?>
<?php ###########################################
} else { echo("Hacking Attempt"); } // End     ?>

