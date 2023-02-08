<?php
function checkPass($db) {
	if(isset($_GET['authToken']) && isset($_GET['pass'])) {
		$authToken = convertStr($_GET['authToken']);
		$pass = convertStr($_GET['pass']);

		$sql = "SELECT password FROM users WHERE accessToken = '$authToken'";
		$passRow = $db->getOne($sql);

		$verify = hash('sha512', $pass);
		$verify = password_verify($verify, $passRow);

		if($verify)
			return true;
		else 
			return false;
	}
}
