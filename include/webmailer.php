<?php

use PHPMailer\PHPMailer\PHPMailer;

require '../WebMailer/PHPMailer.php';
require '../WebMailer/SMTP.php';
require '../WebMailer/Exception.php';

//Configure mail message
$mail = new PHPMailer;

//SMTP Settings
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->Username = "webquizphp@gmail.com";
$mail->Password = "WebQuiz1234";
$mail->Port = 465;
$mail->SMTPSecure = "ssl";
