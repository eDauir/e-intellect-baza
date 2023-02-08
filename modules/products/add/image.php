<?php 
header("Access-Control-Allow-Origin: *");

if(!empty($_POST['authToken']) && !empty($_POST['image']) && !empty($_POST['mentorId']) && !empty($_POST['productId'])) {

	include "../../../db/safemysql.class.php";
	include "../../../functions/shortFunctions.php";

	$db = new safeMysql();

	$authToken = convertStr($_POST['authToken']);
	$productId = convertStr($_POST['productId']);
	$mentorId = convertStr($_POST['mentorId']);

	$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM products WHERE id = '$productId' AND userId = '$mentorId'";
	$data = $db->getAll($sql);
	$count = count($data);

	if($count > 0) {
		$postImg = $_POST['image'];
		$image = convertImgToBase($postImg);

		$sql = "INSERT INTO images (link, productId) VALUES ('$image', '$productId')";
		$insetQuery = $db->query($sql);

		if($insetQuery)
			return true;

		return false;
	}

	return false;
}

return false;