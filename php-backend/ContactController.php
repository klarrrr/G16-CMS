<?php
require_once 'ContactModel.php';
require_once 'Mailer.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    $model = new ContactModel($_POST);

    $body = "Name: {$model->first_name} {$model->last_name}\n";
    $body .= "Email: {$model->email}\n";
    $body .= "Phone: {$model->phone}\n";
    $body .= "Message:\n{$model->message}\n";

    $to = "manrique_klarenzcobie@plpasig.edu.ph";
    $sent = Mailer::send($to, $model->subject, $body, $model->email);

    if ($sent) {
        header("Location: ../lundayan-site-contact.php?status=success");
    } else {
        header("Location: ../lundayan-site-contact.php?status=fail");
    }
    exit;
}
