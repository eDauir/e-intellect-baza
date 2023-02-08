<?php
function defElem($db) {
	if(isset($_GET['authToken']) && isset($_GET['row']) && isset($_GET['table']) && isset($_GET['value'])) {
		$authToken = convertStr($_GET['authToken']);
		$table = convertStr($_GET['table']);
		$row = convertStr($_GET['row']);
		$value = $_GET['value'];

		$sql = "UPDATE $table SET $row = '$value' WHERE user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
		$updateQuery = $db->query($sql);
	}
}