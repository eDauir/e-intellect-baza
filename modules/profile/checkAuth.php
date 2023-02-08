<?php
function checkAuth($db) {
	if(isset($_GET['authToken'])) {
		$authToken = convertStr($_GET['authToken']);

		$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM users WHERE accessToken = '$authToken'";
		$data = $db->getAll($sql);
		$count = count($data);
		if($count > 0)
			return true;
		else return false;
	}
}