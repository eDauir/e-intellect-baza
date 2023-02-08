<?php
function setup($db) {

	$result = $db->query("SHOW TABLES LIKE 'global'");
		
	if( $result->num_rows == 1 ) {
		return false;
	}
	else {
		include "createSQL.php";

		foreach ($queries as $key) {
			$db->query($key);
		}
		
	}        
}