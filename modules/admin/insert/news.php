<?php
header("Access-Control-Allow-Origin: *");

if(isset($_POST['authToken']) && isset($_POST['title']) && isset($_POST['media']) && isset($_POST['text']) && isset($_POST['category']) && isset($_POST['time'])) {
	include "../../../db/safemysql.class.php";
	include "../../../functions/shortFunctions.php";

	$db = new safeMysql();

	$authToken = convertStr($_POST['authToken']);
        $title = convertStr($_POST['title']);
        $img = convertStr($_POST['img ']);
        $text = $_POST['text'];
        $category = convertStr($_POST['category']);
        $time = convertStr($_POST['time']);

        $projectPathName = "digway";
        $projectDomen = "e-intellect.kz";

	$sql = "SELECT SQL_CALC_FOUND_ROWS * FROM users WHERE accessToken = '$authToken' AND editor = 2";

        $data = $db->getAll($sql);
        $count = count($data);

        if($count > 0) {

                $postImg = $_POST['media'];
                $image = convertImgToBase($postImg);

                $sql = "INSERT INTO news (title, img, text, category, time) VALUES ('$title', '$image', '$text', '$category', '$time')";
                $insetQuery = $db->query($sql);

                echo 'true';
        } 
        else {
                echo 'error: authToken invalid';
        }
}
else {
        echo 'error: check request body';
}