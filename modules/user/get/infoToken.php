<?php
function info($db) {
	if(!empty($_GET['authToken'])) {
		$authToken = convertStr($_GET['authToken']);

		$sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, users.editor FROM users_profile INNER JOIN users ON users_profile.user_id = users.id WHERE user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
		$data = $db->getAll($sql);

		return $data;
	}
}