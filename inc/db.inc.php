<?php
	$dbUser = "root";
	$dbPass = "root";
	$dbHost = "localhost";
	$dbName = "_stage";

	$db =& MDB2::connect("mysql://$dbUser:$dbPass@$dbHost/$dbName");
		if (PEAR::isError($db)) {
				die($db->getMessage());
				exit;
			}
			
?>