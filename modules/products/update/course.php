<?php 
header("Access-Control-Allow-Origin: *");

if(!empty($_POST['authToken']) && !empty($_POST['productId']) && !empty($_POST['mentorId']) && !empty($_POST['name']) && !empty($_POST['about']) && !empty($_POST['price']) && !empty($_POST['categoryId'])) {

	include "../../../db/safemysql.class.php";
	include "../../../functions/shortFunctions.php";

	$db = new safeMysql();

	$authToken = convertStr($_POST['authToken']);
	$mentorId = convertStr($_POST['mentorId']);
	$productId = convertStr($_POST['productId']);
	$name = convertStr($_POST['name']);
	$about = convertStr($_POST['about']);
	$price = convertStr($_POST['price']);
	$categoryId = convertStr($_POST['categoryId']);

	$sql = "UPDATE products SET name = '$name', about = '$about', price = '$price', categoryId = '$categoryId' WHERE id = '$productId' AND userId = '$mentorId'";
	$updateQuery = $db->query($sql);

	if($updateQuery) {
		if($_POST['videoChanged'] == '1') {

			$videoName = mb_strtolower(random_str(32));
			$link = '/digway/videos/' . $videoName . '.mp4';

			$fp = file_put_contents($_SERVER['DOCUMENT_ROOT'] . $link, base64_decode($_POST['intro'], true));

			$linkId = 'https://e-intellect.kz' . $link;

			$sql = "UPDATE products SET intro = '$linkId' WHERE id = '$productId' AND userId = '$mentorId'";
			$updateQuery = $db->query($sql);
		}

		if($_POST['photoChanged'] == '1') {
			$sql = "DELETE FROM images WHERE productId = '$productId'";
			$deleteQuery = $db->query($sql);

			$postImg = $_POST['image'];
			$image = convertImgToBase($postImg);
	
			$sql = "INSERT INTO images (link, productId) VALUES ('$image', '$productId')";
			$insetQuery = $db->query($sql);
		}

		
		return true;
	}

	return false;
}

return false;
?>
