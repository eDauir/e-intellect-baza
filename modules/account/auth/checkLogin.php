<?php
function checkLogin($db) {
	if(isset($_GET['login'])) {
		$log = convertStr($_GET['login']);
		$log = mb_strtolower($log);

		$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM users WHERE id = '$log' OR mail = '$log'";
		$data = $db->getAll($sql);
		$count = count($data);

		if($count > 0) {
			$sql = "SELECT SQL_CALC_FOUND_ROWS name, surname FROM users_profile WHERE user_id = '$log' OR user_id = (SELECT id FROM users WHERE mail = '$log')";
			$data = $db->getAll($sql);

			return $data;
		}
		else return false;
	}
}