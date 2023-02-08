<?php
function checkPass($db) {
	if(isset($_GET['login']) && isset($_GET['password'])) {
		$log = convertStr($_GET['login']);
		$log = strtolower($log);
		$pass = convertStr($_GET['password']);

		$sql = "SELECT id FROM users WHERE id = '$log' OR mail = '$log'";
		$userId = $db->getOne($sql);

		$sql = "SELECT password FROM users WHERE id = '$userId'";
		$passRow = $db->getOne($sql);

		$verify = hash('sha512', $pass);
		$verify = password_verify($verify, $passRow);

		if ($verify) {

			$sql = "SELECT accessToken FROM users WHERE id = '$userId'";
			$tokenChecker = $db->getOne($sql);

			if(empty($tokenChecker) || $tokenChecker == null) {
				$tokenChecker = random_str(32);
				$sql = "UPDATE users SET accessToken = '$tokenChecker', tokenDate = now() WHERE id = '$userId'";
				$updateQuery = $db->query($sql);
			}

			return $tokenChecker;
		}
		return false;
	}
}