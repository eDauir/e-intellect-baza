<?php
function sendMail($mail, $data) {
	$text = 'Здравствуйте! Ваш eDauir ID - ' . $data;
	$resMail = mail($mail, 'Ваш eDauir ID', $text, null, "-f admin@qaganat.com");
	if($resMail) return true;
	else return false;
}