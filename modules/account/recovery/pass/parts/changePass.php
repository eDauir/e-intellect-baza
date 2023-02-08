<?php
function changePass($db) {
	if(isset($_GET['mail']) && isset($_GET['pass'])) {
		include "checkCode.php";
		$res = checkCode($db);
		
		if($res == true) {
			$mail = mb_strtolower(convertStr($_GET['mail']));
			$pass = strtoupper(convertStr($_GET['pass']));

			$pass512 = hash('sha512', $pass);
			$pass512 = password_hash($pass512, PASSWORD_DEFAULT);

			$sql = "UPDATE users SET password = '$pass512' WHERE mail = '$mail'";
			$updateQuery = $db->query($sql);

			if ($updateQuery) {
				$sql = "DELETE FROM recovery_password WHERE mail = '$mail'";
				$db->query($sql);

				return true;
			} return false;
			}
	}
}