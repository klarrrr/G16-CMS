<?php

use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

$mail = new PHPMailer();
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'lundayan.studentpublication@gmail.com';
$mail->Password = 'nviy xqzc wxpg swsu';
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

$mail->setFrom('lundayan.studentpublication@gmail.com', 'Lundayan Contact Form');

// TODO: Make this dynamic
// Admin Side will be able to change this

$mail->addAddress('depadua_charlesjeramy@plpasig.edu.ph');

$mail->isHTML(true);
$mail->Subject = 'New Contact Form Submission';
$mail->Body    = "
    First Name: {$_POST['firstName']} <br>
    Last Name: {$_POST['lastName']} <br>
    Email: {$_POST['email']} <br>
    Phone: {$_POST['phone']} <br>
    Subject: {$_POST['subject']} <br>
    Message: {$_POST['message']}
";

if ($mail->send()) {
    echo 'success';
} else {
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}
