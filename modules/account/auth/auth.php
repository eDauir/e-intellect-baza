<?php
function auth($db) {
	if($_GET['subType'] == "login") {
		include "checkLogin.php";
		$res = checkLogin($db);
	}
	elseif($_GET['subType'] == "password") {
		include "checkPass.php";
		$res = checkPass($db);
	}

	return $res;
}