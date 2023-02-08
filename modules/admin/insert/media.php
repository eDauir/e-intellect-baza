<?php
header("Access-Control-Allow-Origin: *");

if(isset($_POST['authToken']) && isset($_POST['media']) && isset($_POST['mType'])) {
	include "../../../db/safemysql.class.php";
	include "../../../functions/shortFunctions.php";

	$db = new safeMysql();

	$authToken = convertStr($_POST['authToken']);
        $postId = convertStr($_POST['postId']);
        $projectPathName = "digway";
        $projectDomen = "e-intellect.kz";

	$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM users WHERE accessToken = '$authToken' AND editor = 2";

        $data = $db->getAll($sql);
        $count = count($data);

        if($count > 0) {

                if($_POST['mType'] == 'videos') {
                        $videoName = mb_strtolower(random_str(32));
		        $link = '/'.$projectPathName.'/videos/' . $videoName . '.mp4';

		        $fp = file_put_contents($_SERVER['DOCUMENT_ROOT'] . $link, base64_decode($_POST['media'], true));

		        $sql = "INSERT INTO videos (link, productId) VALUES (?s, '$postId')";
		        $insertQuery = $db->query($sql, 'https://' . $projectDomen . $link);
				if($insertQuery) {
					$sql = "UPDATE products SET isVideo = 1 WHERE id = '$postId' AND userId = (SELECT id FROM users WHERE accessToken = '$authToken')";
					$updateQuery = $db->query($sql);
				}

                }
                elseif($_POST['mType'] == 'banner') {
                        $postImg = $_POST['media'];
                        $image = convertImgToBase($postImg);
        
                        $sql = "INSERT INTO banner (link) VALUES ('$image')";
                        $insetQuery = $db->query($sql);

                        echo 'true';
                }
                else {
                        $postImg = $_POST['media'];
                        $image = convertImgToBase($postImg);
        
                        $sql = "INSERT INTO images (link, productId) VALUES ('$image', '$postId')";
                        $insetQuery = $db->query($sql);
                }
        } 
        else {
                echo 'error: authToken invalid';
        }
}
else {
        echo 'error: check request body';
}