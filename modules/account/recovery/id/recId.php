<?php
function recoveryId($db) {
	if(isset($_GET['mail'])) {
		include "sendMail.php";
		$mail = mb_strtolower(convertStr($_GET['mail']));

		$sql = "SELECT SQL_CALC_FOUND_ROWS mail FROM users WHERE mail = '$mail'";
		$data = $db->getAll($sql);
		$count = count($data);

		if($count > 0) {
			$res = sendMail($mail, $data[0]['main_mail']); 
			return $res;
		}
		else return false;
	}
}