<?php
function checkCode($db) {
	if(isset($_GET['mail']) && isset($_GET['code'])) {
		$mail = mb_strtolower(convertStr($_GET['mail']));
		$code = strtoupper(convertStr($_GET['code']));

		$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM recovery_password WHERE mail = '$mail' AND code = '$code' AND recDate = CURDATE()";
		$data = $db->getAll($sql);
		$count = count($data);
		if($count > 0) return true;
		else return false;
	}
}