<?php
function getGlobal($db) {

	$result = $db->query("SHOW TABLES LIKE 'global'");
		
	if( $result->num_rows == 1 ) {
		$sql = "SELECT * FROM global LIMIT 1";

		$data = $db->getAll($sql);
		return $data;
	}
	else {
		return false;
	}        
}