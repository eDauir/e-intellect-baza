<?php
function getUserInfo($db) {
	if(isset($_GET['authToken'])) {
		$authToken = convertStr($_GET['authToken']);

		$sql = "SELECT SQL_CALC_FOUND_ROWS name, avatar FROM users_profile WHERE edauir_id = (SELECT edauir_id FROM users WHERE accessToken = '$authToken')";
		$data = $db->getAll($sql);

		return $data;
	}
}