<?php 
header("Access-Control-Allow-Origin: *");

if(!empty($_POST['authToken']) && !empty($_POST['lessonsId']) && !empty($_POST['sectionId']) && !empty($_POST['name'])) {

	include "../../../db/safemysql.class.php";
	include "../../../functions/shortFunctions.php";

	$db = new safeMysql();

	$authToken = convertStr($_POST['authToken']);
	$lessonsId = convertStr($_POST['lessonsId']);
	$sectionId = convertStr($_POST['sectionId']);
	$name = convertStr($_POST['name']);

	$sql = "UPDATE lessons SET name = '$name', sectionId = '$sectionId' WHERE id = '$lessonsId'";
	$updateQuery = $db->query($sql);

	if($updateQuery) {
		if($POST['videoChanged'] == 1) {

			$duration = convertStr($_POST['duration']);

			$videoName = mb_strtolower(random_str(32));
			$link = '/digway/videos/' . $videoName . '.mp4';
	
			$fp = file_put_contents($_SERVER['DOCUMENT_ROOT'] . $link, base64_decode($_POST['video'], true));
	
			$linkId = 'https://e-intellect.kz' . $link;
	
			$sql = "UPDATE videos SET link = '$linkId', duration = '$duration' WHERE lessonsId = '$lessonsId'";
			$updateQuery = $db->query($sql);
	
			if($updateQuery)
				return true;
	
			return false;
	
		}

		else 
			return true;
	}

	return false;
}

return false;
?>
