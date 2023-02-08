<?php 
header("Access-Control-Allow-Origin: *");

if($_POST['videoChanged'] == 0) {
	if(!empty($_REQUEST['authToken']) && !empty($_REQUEST['lessonsId']) && !empty($_REQUEST['mentorId']) && !empty($_REQUEST['sectionId']) && !empty($_REQUEST['name'])) {

		include "../../../db/safemysql.class.php";
		include "../../../functions/shortFunctions.php";
	
		$db = new safeMysql();
	
		$authToken = convertStr($_REQUEST['authToken']);
		$lessonsId = convertStr($_REQUEST['lessonsId']);
		$sectionId = convertStr($_REQUEST['sectionId']);
		$name = convertStr($_REQUEST['name']);
		$mentorId = convertStr($_REQUEST['mentorId']);
	
		$sql = "UPDATE lessons SET name = '$name', sectionId = '$sectionId' WHERE id = '$lessonsId'";
		$updateQuery = $db->query($sql);
	
		if($updateQuery) {
			$result = true;
		}
		else {
			$result = false;
		}
	}
}
else {
	if(!empty($_REQUEST['authToken'])  && !empty($_REQUEST['mentorId']) && !empty($_REQUEST['lessonsId']) && !empty($_REQUEST['sectionId']) && !empty($_REQUEST['name'])) {
	
		include "../../../db/safemysql.class.php";
		include "../../../functions/shortFunctions.php";
	
		$db = new safeMysql();
	
		$authToken = convertStr($_REQUEST['authToken']);
		$lessonsId = convertStr($_REQUEST['lessonsId']);
		$sectionId = convertStr($_REQUEST['sectionId']);
		$name = convertStr($_REQUEST['name']);
		$mentorId = convertStr($_REQUEST['mentorId']);
	
		$sql = "UPDATE lessons SET name = '$name', sectionId = '$sectionId' WHERE id = '$lessonsId'";
		$updateQuery = $db->query($sql);
	
		if($updateQuery) {
			if($_POST['videoChanged'] == 1) {
	
				$duration = convertStr($_REQUEST['duration']);
	
				$videoName = mb_strtolower(random_str(32));
        		$link = '/digway/videos/' . $videoName . '.mp4';
        
        		$moveUpload = move_uploaded_file($_FILES['file']['tmp_name'], '../../../../videos/' . $videoName . '.mp4');
		
				$linkId = 'https://e-intellect.kz' . $link;
		
				$sql = "UPDATE videos SET link = '$linkId', duration = '$duration' WHERE lessonsId = '$lessonsId'";
				$updateQuery = $db->query($sql);
		
				if($updateQuery)
					$result = true;
				else
					$result = false;
		
			}
			else 
				$result = false;
		}
		else {
			$result = false;
		}
	} else {
		$result = false;
	}
}


echo json_encode($result);
?>
