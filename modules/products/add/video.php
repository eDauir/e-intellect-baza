<?php 
header("Access-Control-Allow-Origin: *");

if(!empty($_POST['authToken']) && !empty($_POST['video']) && !empty($_POST['name']) && !empty($_POST['sectionId']) && !empty($_POST['productId']) && !empty($_POST['duration'])) {

	include "../../../db/safemysql.class.php";
	include "../../../functions/shortFunctions.php";

	$db = new safeMysql();

	$authToken = convertStr($_POST['authToken']);
	$name = convertStr($_POST['name']);
	$sectionId = convertStr($_POST['sectionId']);
	$productId = convertStr($_POST['productId']);
	$duration = convertStr($_POST['duration']);

	$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM products WHERE id = '$productId' AND userId = (SELECT id FROM users WHERE accessToken = '$authToken')";
	$data = $db->getAll($sql);
	$count = count($data);

	if($count > 0) {
		$videoName = mb_strtolower(random_str(32));
		$link = '/digway/videos/' . $videoName . '.mp4';

		$fp = file_put_contents($_SERVER['DOCUMENT_ROOT'] . $link, base64_decode($_POST['video'], true));

		$sql = "INSERT INTO lessons (name, productId, sectionId, elemType) VALUES ('$name', '$productId', '$sectionId', 1)";
		$insertQuery = $db->query($sql);
		$lessonsId = $db->insertId();

		$sql = "INSERT INTO videos (lessonsId, duration, link) VALUES ('$lessonsId', '$duration', ?s)";
		$insertQuery = $db->query($sql, 'https://e-intellect.kz' . $link);

		if($insertQuery) {
			$sql = "UPDATE products SET active = 1 WHERE id = '$productId'";
            $updateQuery = $db->query($sql);

			return true;
		}

		return false;
	}

	return false;
}

return false;
?>
