<?php 
header("Access-Control-Allow-Origin: *");

if(!empty($_POST['authToken']) && !empty($_POST['img']) && !empty($_POST['mentorId']) && !empty($_POST['title']) && !empty($_POST['info']) && !empty($_POST['category']) && !empty($_POST['price']) && !empty($_POST['author']) && !empty($_POST['publish']) && !empty($_POST['year']) && !empty($_POST['genre']) && !empty($_POST['age']) && !empty($_POST['pages']) && !empty($_POST['lang'])) {

	include "../../db/safemysql.class.php";
	include "../../functions/shortFunctions.php";

	$db = new safeMysql();

	$authToken = convertStr($_POST['authToken']);
	$title = convertStr($_POST['title']);
	$info = convertStr($_POST['info']);
	$category = convertStr($_POST['category']);
	$price = convertStr($_POST['price']);
	$mentorId = convertStr($_POST['mentorId']);

	$author = convertStr($_POST['author']);
	$publish = convertStr($_POST['publish']);
	$year = convertStr($_POST['year']);
	$genre = convertStr($_POST['genre']);
	$age = convertStr($_POST['age']);
	$pages = convertStr($_POST['pages']);
	$lang = convertStr($_POST['lang']);

	$sql = "SELECT id FROM users WHERE accessToken = '$authToken' AND editor = 3";
	$userId = $db->getOne($sql);

	if(!empty($userId)) {
		$postImg = $_POST['img'];
		$image = convertImgToBase($postImg);

		$pdfName = mb_strtolower(random_str(32));
        $pdf = '/digway/pdf/' . $pdfName . '.pdf';
        
        $moveUpload = move_uploaded_file($_FILES['file']['tmp_name'], '../../../pdf/' . $pdfName . '.pdf');

		$sql = "INSERT INTO books (userId, title, info, img, category, price, file, author, publish, year, genre, age, pages, lang) VALUES ('$mentorId', '$title', '$info', '$image', '$category', '$price', ?s, '$author', '$publish', '$year', '$genre', '$age', '$pages', '$lang')";
		
		$insetQuery = $db->query($sql, 'https://e-intellect.kz' . $pdf);

		if($insetQuery)
			echo 'true';
		else
			echo 'false';
	}
	else
		echo 'false';
}
else
	echo 'false';