<?php
function changePass($db) {
	if(isset($_GET['authToken']) && isset($_GET['pass'])) {
		$authToken = convertStr($_GET['authToken']);
		$pass = convertStr($_GET['pass']);

		$pass512 = hash('sha512', $pass);
		$pass512 = password_hash($pass512, PASSWORD_DEFAULT);

		$sql = "UPDATE users SET password = '$pass512' WHERE accessToken = '$authToken'";
		$updateQuery = $db->query($sql);

		if($updateQuery)
			return true;
		else 
			return false;
	}
}