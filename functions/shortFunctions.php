<?php
	function convertStr($str) {
		$convertedStr = strip_tags($str);
		$convertedStr1 = htmlspecialchars($convertedStr);
   		return $convertedStr1;
	}

	function random_str($n) {
	    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $randomString = '';
	  
	    for ($i = 0; $i < $n; $i++) {
	        $index = rand(0, strlen($characters) - 1);
	        $randomString .= $characters[$index];
	    }
	  
	    return $randomString;
	}

	function convertImgToBase($byte) {
		$projectPathName = "digway";
		$projectDomen = "e-intellect.kz";

		$fileName = strtolower(random_str(15));
		$im = imagecreatefromstring(base64_decode($byte));
		$imgResized = $im;

		$width = intval(imagesx($im) / 2);
		if(imagesx($im) > 400)
			$imgResized = imagescale($im , $width);

		$root = $_SERVER['DOCUMENT_ROOT'];

		imagejpeg($imgResized, $root . '/'.$projectPathName.'/images/' . $fileName . '.jpg');
		imagedestroy($im);

		$path = 'https://'.$projectDomen.'/'.$projectPathName.'/images/' . $fileName . '.jpg';
		return $path;
	}