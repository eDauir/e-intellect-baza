<?php
function mailCheck($db) {
	if(isset($_GET['authToken']) && isset($_GET['code'])) {
		$authToken = convertStr($_GET['authToken']);
		$code = convertStr($_GET['code']);

		$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM mail_active WHERE code = '$code' AND user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
		$data = $db->getAll($sql);
		$count = count($data);

		if($count > 0) {

			$sql = "UPDATE users SET activeStatus = 1 WHERE accessToken = '$authToken'";
			$updateQuery = $db->query($sql);

			if($updateQuery)  {
				$sql = "DELETE FROM mail_active WHERE code = '$code' AND user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
				$deleteQuery = $db->query($sql);
				return true;
			}
		}
		else return false; 
	}
}