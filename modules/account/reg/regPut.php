<?php
function checkRows($db) {
	if(isset($_GET['name']) && isset($_GET['surname']) && isset($_GET['mail']) && isset($_GET['password'])) {
		$name = convertStr(ucfirst($_GET['name']));
		$surname = convertStr(ucfirst($_GET['surname']));
		$mail = convertStr(mb_strtolower($_GET['mail']));
		$password = convertStr($_GET['password']);

		$res = loadToDb($name, $surname, $mail, $password, $db);

		return $res;
	}
}

function loadToDb($name, $surname, $mail, $password, $db) {
	include "noAvatar.php";
	$pass512 = hash('sha512', $password);
	$pass512 = password_hash($pass512, PASSWORD_DEFAULT);
	$edauir_id = explode("@", $mail);

	$sql = "INSERT INTO users (mail, password) VALUES ('$mail', '$pass512')";
	$insertQuery = $db->query($sql);
	$user_id = $db->insertId();
	$edauir_id = $edauir_id[0] . random_str(5);

	if ($insertQuery) {

		$sql = "INSERT INTO users_profile (user_id, name, surname, login, avatar) VALUES ('$user_id', '$name', '$surname', '$edauir_id', '$noAvatar')";
		$insertQuery = $db->query($sql);

		$sql = "INSERT INTO balance (userId) VALUES ('$user_id')";
		$insertQuery = $db->query($sql);

		$sql = "INSERT INTO notify (title, text, type, userId) VALUES ('Добро пожаловать!', 'Вы успешно прошли регистрацию.', '1', '$user_id')";
        $insertQuery = $db->query($sql);

		if($_GET['createLink'] == true) {
			$authToken = convertStr($_GET['authToken']);

			$sql = "SELECT id FROM users WHERE authToken = '$authToken'";
			$partnerId = $db->getOne($sql);

			$sql = "INSERT INTO linkPartnerMentor (partnerId, mentorId) VALUES ('$partnerId', '$user_id')";
			$insertQuery = $db->query($sql);
		}
			
		return true;
	}
	else false;
}