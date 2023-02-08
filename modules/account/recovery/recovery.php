<?php
function recovery($db) {
	if($_GET['subType'] == "id") {
		include "id/recId.php";
		$res = recoveryId($db);
	}
	elseif($_GET['subType'] == "pass") {
		include "pass/recPass.php";
		$res = recoveryPass($db);
	}

	return $res;
}