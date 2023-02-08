<?php
function fio($db) {
	if(isset($_GET['authToken']) && isset($_GET['name']) && isset($_GET['surname']) && isset($_GET['otch'])) {
		$authToken = convertStr($_GET['authToken']);
		$name = convertStr($_GET['name']);
		$surname = convertStr($_GET['surname']);
		$otch = convertStr($_GET['otch']);

		$sql = "UPDATE users_profile SET name = '$name', surname = '$surname', otchestvo = '$otch' WHERE user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
		$updateQuery = $db->query($sql);
	}
}