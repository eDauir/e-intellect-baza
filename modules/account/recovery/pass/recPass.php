<?php
function recoveryPass($db) {
	if($_GET['part'] == "takeCode") {
		include "parts/takeCode.php";
		$res = takeCode($db);
	}
	elseif($_GET['part'] == "checkCode") {
		include "parts/checkCode.php";
		$res = checkCode($db);
	}
	elseif($_GET['part'] == "changePass") {
		include "parts/changePass.php";
		$res = changePass($db);
	}

	return $res;
}