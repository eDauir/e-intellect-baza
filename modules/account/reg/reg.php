<?php
function reg($db) {
	if($_GET['subType'] == "mailCheck") {
		include "regCheck.php";
		$res = checkMail($db);
	}
	elseif($_GET['subType'] == "loadRegData") {
		include "regCheck.php";
		include "regPut.php";
		$check = checkMail($db);
		if($check == true) 
			$res = checkRows($db);
		else $res = $check;
	}

	elseif($_GET['subType'] == "getToken") {
		
	}



	return $res;
}