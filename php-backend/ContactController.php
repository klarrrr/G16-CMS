<?php
require_once 'ContactModel.php';
require_once 'Mailer.php';
require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit'])) {
    try {
        $model = new ContactModel($_POST);

        // Compose email body
        $body = "New Contact Form Submission\n\n";
        $body .= "Name: {$model->getFullName()}\n";
        $body .= "Email: {$model->getEmail()}\n";
        $body .= "Phone: " . ($model->getPhone() ?: 'Not provided') . "\n";
        $body .= "Subject: {$model->getSubject()}\n";
        $body .= "Message:\n{$model->getMessage()}\n";

        // Get recipient email from database
        $settingsQuery = $conn->query("
            SELECT setting_value 
            FROM site_settings 
            WHERE setting_group = 'mail' AND setting_name = 'email'
            LIMIT 1
        ");
        
        $to = $settingsQuery->fetch_assoc()['setting_value'] ?? 'depadua_charlesjeramy@plpasig.edu.ph';

        // Send email
        $sent = Mailer::send(
            $to, 
            "Contact Form: " . $model->getSubject(), 
            $body, 
            $model->getEmail(),
            "Lundayan Contact Form"
        );

        if ($sent) {
            header("Location: ../lundayan-site-contact.php?status=success");
        } else {
            header("Location: ../lundayan-site-contact.php?status=fail&error=send_failed");
        }
        exit;
        
    } catch (InvalidArgumentException $e) {
        header("Location: ../lundayan-site-contact.php?status=fail&error=validation&message=" . urlencode($e->getMessage()));
        exit;
    } catch (Exception $e) {
        error_log("ContactController Error: " . $e->getMessage());
        header("Location: ../lundayan-site-contact.php?status=fail&error=server_error");
        exit;
    }
}

header("Location: ../lundayan-site-contact.php");
exit;