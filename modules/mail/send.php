<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../mailer/src/Exception.php';
require '../../mailer/src/PHPMailer.php';
require '../../mailer/src/SMTP.php';

$name = $_GET['name'];
$to = $_GET['mail'];
$tel = $_GET['tel'];
$title = $_GET['title'];
$subject = $_GET['subject'];

phpMailerSend($name, $to, $tel, $title, $subject);

function phpMailerSend($name, $to, $tel, $title, $subject) {        
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
    $mail->Body = '<h3>Имя: ' . $name . '<br>Почта: ' . $subject . '<br>Телефон: ' . $tel . '<br>Тема: ' . $title . '</h3><br><hr><br><p>Сообщение: ' . $subject . '</p>';
	$mail->CharSet = 'UTF-8';
    $mail->AddAddress('e.intellect.kz@gmail.com');
    
    if(!$mail->Send()) {
        echo false;
    } else {
        echo true;
    }
}
