<?php
function login($db) {
	if(isset($_GET['authToken']) && isset($_GET['login'])) {
		$authToken = convertStr($_GET['authToken']);
		$login = convertStr($_GET['login']);

		$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM users_profile WHERE login = '$login'";
		$data = $db->getAll($sql);
		$count = count($data);

		if($count > 0)
			return false;
		else {
			$sql = "UPDATE users_profile SET login = '$login' WHERE user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
			$updateQuery = $db->query($sql);;

			return true;
		}
	}
}