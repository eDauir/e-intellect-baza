<?php
function getProfile($db) {
	if(isset($_GET['authToken'])) {
		$authToken = convertStr($_GET['authToken']);

		$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM users WHERE accessToken = '$authToken'";
		$data = $db->getAll($sql);
		$count = count($data);

		if($count > 0) {
			$sql = "SELECT SQL_CALC_FOUND_ROWS activeStatus, mail, editor FROM users WHERE accessToken = '$authToken'";
			$data0 = $db->getAll($sql);

			$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM users_profile WHERE user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
			$data1 = $db->getAll($sql);

			$json = array();
			$json['actS'] = $data0;
			$json['main'] = $data1;

			return $json;

		} return false;
	}
}