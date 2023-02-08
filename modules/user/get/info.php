<?php
function info($db) {
	if(!empty($_GET['id'])) {
		$id = convertStr($_GET['id']);

		$sql = "SELECT SQL_CALC_FOUND_ROWS users_profile.*, COUNT(products.id) as courseCount, COUNT(orders.id) as ordersCount, COUNT(comments.id) AS commentsCount FROM users_profile LEFT JOIN products ON users_profile.user_id = products.userId LEFT JOIN orders ON orders.productId = products.id LEFT JOIN comments ON comments.productId = products.id WHERE users_profile.user_id = '$id'";
		$data = $db->getAll($sql);

		return $data;
	}
}