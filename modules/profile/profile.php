<?php
function profile($db) {
	if($_GET['subType'] == "get") {
		include "get/getProfile.php";
		$res = getProfile($db);
	}
	elseif($_GET['subType'] == "getUserInfo") {
		include "get/getUserInfo.php";
		$res = getUserInfo($db);
	}
	elseif($_GET['subType'] == "delete") {
		include "delete/deleteAcc.php";
		$res = deleteAcc($db);
	}
	elseif($_GET['subType'] == "activeAcc") {
		include "activation/activeAcc.php";
		$res = activeAcc($db);
	}
	elseif($_GET['subType'] == "change") {
		include "change/change.php";
		$res = change($db);
	}
	elseif($_GET['subType'] == "checkAuth") {
		include "checkAuth.php";
		$res = checkAuth($db);
	}
	return $res;
}