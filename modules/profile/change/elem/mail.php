<?php
function changeMail($db) {
	if(!empty($_GET['authToken']) && !empty($_GET['mail'])) {
		$authToken = convertStr($_GET['authToken']);
		$mail = convertStr($_GET['mail']);

		$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM users WHERE mail = '$mail'";
		$data = $db->getAll($sql);
		$count = count($data);

		if($count > 0)
			return false;
		else {
			$sql = "UPDATE users SET mail = '$mail', activeStatus = 0 WHERE accessToken = '$authToken'";
			$updateQuery = $db->query($sql);

			return true;
		}
	}

	return false;
}