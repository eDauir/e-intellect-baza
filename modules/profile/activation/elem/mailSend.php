<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/src/Exception.php';
require 'mailer/src/PHPMailer.php';
require 'mailer/src/SMTP.php';

function mailSend($db) {
	if(isset($_GET['authToken'])) {
		$authToken = convertStr($_GET['authToken']);
		$tokenRecovery = rand(1000, 9999);

		$sql = "SELECT SQL_CALC_FOUND_ROWS mail, id FROM users WHERE accessToken = '$authToken'";	
		$data = $db->getAll($sql);

		$sql = "DELETE FROM mail_active WHERE user_id = (SELECT id FROM users WHERE accessToken = '$authToken')";
		$deleteQuery = $db->query($sql);
		
		$sql = "INSERT INTO mail_active (user_id, code) VALUES ('".$data[0]['id']."', '$tokenRecovery')";
		$insertQuery = $db->query($sql);

		if ($insertQuery) {
			$res = phpMailerSend($data[0]['mail'], 'Код для активации профиля', $tokenRecovery);

			if($res == true)
				return true;
			
			return false;
		}
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
    $mail->Body = 'Данный код нужно ввести в приложений: ' . $code;
	$mail->CharSet = 'UTF-8';
    $mail->AddAddress($to);
    
    if(!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}
