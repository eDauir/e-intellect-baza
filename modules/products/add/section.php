<?php
function addSection($db) {
	if(!empty($_GET['authToken']) && !empty($_GET['productId']) && !empty($_GET['mentorId']) && !empty($_GET['name'])) {

			$authToken = convertStr($_GET['authToken']);
            $productId = convertStr($_GET['productId']);
			$name = convertStr($_GET['name']);
			$mentorId = convertStr($_GET['mentorId']);


			$sqlUser = "SELECT id FROM users WHERE id = '$mentorId' AND editor = 1";
		    $dataUser = $db->getOne($sqlUser);

		    if(!empty($dataUser)) { 

			    $sql = "INSERT INTO sections (name, productId) VALUES ('$name', '$productId')";

			
				$insertQuery = $db->query($sql);

				$productId = $db->insertId();
						
				return $productId;
		}
	}
}