<?php
function user($db) {
	if($_GET['subType'] == "getInfo") {
		include "get/info.php";
		$res = info($db);
	}
	elseif($_GET['subType'] == "getRequest") {
		include "get/request.php";
		$res = request($db);
	}
	elseif($_GET['subType'] == "getInfoToken") {
		include "get/infoToken.php";
		$res = info($db);
	}
	elseif($_GET['subType'] == "getProducts") {
		include "get/products.php";
		$res = products($db);
	}
	elseif($_GET['subType'] == "getWorkers") {
		include "get/infoWorker.php";
		$res = info($db);
	}
	elseif($_GET['subType'] == "getSearch") {
		include "get/searchWorker.php";
		$res = info($db);
	}
	return $res;
}