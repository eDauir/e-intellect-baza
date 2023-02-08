<?php
function getFinish($db) {
	if(isset($_GET['authToken']) && !empty($_GET['productId'])) {
		$authToken = convertStr($_GET['authToken']);
		$productId = convertStr($_GET['productId']);

		$sql = "SELECT * FROM progressFinish WHERE userId = (SELECT id FROM users WHERE accessToken = '$authToken') AND productId = '$productId'";
		$data = $db->getAll($sql);

        return $data;
	}
}