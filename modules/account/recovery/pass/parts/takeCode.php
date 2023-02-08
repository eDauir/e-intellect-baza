<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/src/Exception.php';
require 'mailer/src/PHPMailer.php';
require 'mailer/src/SMTP.php';

function takeCode($db) {
	if(isset($_GET['mail'])) {
		$mail = mb_strtolower(convertStr($_GET['mail']));

		$sql = "SELECT SQL_CALC_FOUND_ROWS id FROM users WHERE mail = '$mail'";
		$data = $db->getAll($sql);
		$count = count($data);

		if($count > 0) {

			$tokenRecovery = strtoupper(random_str(6));

			$sql = "DELETE FROM recovery_password WHERE mail = '$mail'";
			$db->query($sql);
			
			$sql = "INSERT INTO recovery_password (mail, code, recDate) VALUES ('$mail', '$tokenRecovery', CURDATE())";
			$insertQuery = $db->query($sql);

			if ($insertQuery) {
				$res = phpMailerSend($mail, 'Код для смены пароля', $tokenRecovery);

				$sql = "SELECT SQL_CALC_FOUND_ROWS name, surname FROM users_profile WHERE user_id = (SELECT id FROM users WHERE mail = '$mail')";
				$data = $db->getAll($sql);

				return $data;
			} else return false;
		} else return false;
	}
}

function phpMailerSend($to, $title, $code) {        
    $mail = new PHPMailer(); // create a new object
    $mail->IsSMTP(); // enable SMTP
    $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
    $mail->SMTPAuth = true; // authentication enabled
    $mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->IsHTML(true);
    $mail->Username = "e.intellect.kz@gmail.com";
    $mail->Password = "azbq jikk pnkq jdap";
    $mail->SetFrom("e.intellect.kz@gmail.com", "e-Intellect");
    $mail->Subject = $title;
    $mail->Body = 'Код для смены пароля: ' . $code;
	$mail->CharSet = 'UTF-8';
    $mail->AddAddress($to);
    
    if(!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}