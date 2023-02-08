<?php
header("Access-Control-Allow-Origin: *");

if(isset($_POST['authToken']) && isset($_POST['image'])) {
	include "../../../../db/safemysql.class.php";
	include "../../../../functions/shortFunctions.php";

	$db = new safeMysql();

	$authToken = convertStr($_POST['authToken']);
	$postImg = $_POST['image'];
	$image = convertImgToBase($postImg);
	$projectPathName = "digway";
	$root = $_SERVER['DOCUMENT_ROOT'];

	$sql = "SELECT SQL_CALC_FOUND_ROWS avatar FROM users_profile WHERE user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";

	$data = $db->getOne($sql);
	$imageFile = explode("/", $data);
	if(end($imageFile) != 'noAva.png')
		unlink($root . '/'.$projectPathName.'/images/' . end($imageFile));

	$sql = "UPDATE users_profile SET avatar = '$image' WHERE user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
	$updateQuery = $db->query($sql);
}
