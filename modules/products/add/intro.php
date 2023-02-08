<?php 
header("Access-Control-Allow-Origin: *");

if(!empty($_POST['authToken']) && !empty($_POST['intro']) && !empty($_POST['mentorId']) && !empty($_POST['productId'])) {

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
		$videoName = mb_strtolower(random_str(32));
		$link = '/digway/videos/' . $videoName . '.mp4';

		$fp = file_put_contents($_SERVER['DOCUMENT_ROOT'] . $link, base64_decode($_POST['intro'], true));

		$linkId = 'https://e-intellect.kz' . $link;

		$sql = "UPDATE products SET intro = '$linkId' WHERE id = '$productId' AND userId = '$mentorId'";
		$updateQuery = $db->query($sql);

		if($updateQuery)
			return true;

		return false;
	}

	return false;
}

return false;
?>
