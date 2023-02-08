<?php
function checkMail($db) {
	if(isset($_GET['mail'])) {
		$mail = convertStr($_GET['mail']);
		$mail = mb_strtolower($mail);

		$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM users WHERE mail = '$mail'";
		$data = $db->getAll($sql);
		$count = count($data);

		if($count > 0) return false;
		else return true;
	}
}