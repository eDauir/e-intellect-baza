<?php
function geo($db) {
	if(isset($_GET['authToken'])) {
		$authToken = convertStr($_GET['authToken']);
		$co = convertStr($_GET['co']);
		$ind = convertStr($_GET['ind']);
		$obl = convertStr($_GET['obl']);
		$ray = convertStr($_GET['ray']);
		$nas = convertStr($_GET['nas']);
		$adr = convertStr($_GET['adr']);

		$sql = "UPDATE user_contact SET country = '$co', c_index = '$ind', oblast = '$obl', rayon = '$ray', naselenni_punkt = '$nas', adress = '$adr' WHERE user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
		$updateQuery = $db->query($sql);
	}
}