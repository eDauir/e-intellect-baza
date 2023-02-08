<?php
function deleteAcc($db) {
	if(isset($_GET['authToken'])) {
		$authToken = convertStr($_GET['authToken']);

		$sql = "DELETE FROM users_profile WHERE user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
		$deleteQuery = $db->query($sql);

		$sql = "DELETE FROM users WHERE accessToken = '$authToken'";
		$deleteQuery = $db->query($sql);

		$sql = "DELETE FROM balance WHERE userId = (SELECT id FROM users WHERE accessToken = '$authToken')";
		$deleteQuery = $db->query($sql);
	}
}