<?php
function addProduct($db) {
	if(!empty($_GET['authToken']) && !empty($_GET['name']) && !empty($_GET['mentorId']) && !empty($_GET['about']) && !empty($_GET['price']) && !empty($_GET['categoryId']) ) {

		$authToken = convertStr($_GET['authToken']);
		$name = convertStr($_GET['name']);
		$about = convertStr($_GET['about']);
		$price = convertStr($_GET['price']);
		$categoryId = convertStr($_GET['categoryId']);
		$mentorId = convertStr($_GET['mentorId']);

		$sqlUser = "SELECT id FROM users WHERE id = '$mentorId' AND editor = 1";
		$dataUser = $db->getOne($sqlUser);

		if(!empty($dataUser) && $dataUser != false) { 

			$sql = "INSERT INTO products (name, about, userId, price, categoryId) VALUES ('$name', '$about', '$mentorId', '$price' , '$categoryId')";
		
			$insertQuery = $db->query($sql);

			$productId = $db->insertId();
					
			return $productId;
		}
	}
}