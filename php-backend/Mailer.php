<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

class Mailer
{
    public static function send(string $to, string $subject, string $body, string $fromEmail, ?string $senderName = null): bool
    {
        $mail = new PHPMailer(true);

        try {
            // Get SMTP settings from database
            global $conn;
            
            // Use proper query matching your database structure
            $emailQuery = $conn->query("
                SELECT setting_value 
                FROM site_settings 
                WHERE setting_group = 'mail' AND setting_name = 'email'
                LIMIT 1
            ");
            $mailEmail = $emailQuery->fetch_assoc()['setting_value'] ?? 'lundayan.studentpublication@gmail.com';

            $passQuery = $conn->query("
                SELECT setting_value 
                FROM site_settings 
                WHERE setting_group = 'mail' AND setting_name = 'password'
                LIMIT 1
            ");
            $mailPassword = $passQuery->fetch_assoc()['setting_value'] ?? 'nviy xqzc wxpg swsu';

            // Enable verbose debugging (2 for full debug, 0 for production)
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'error_log';

            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $mailEmail;
            $mail->Password = $mailPassword;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            
            // Timeout settings
            $mail->Timeout = 30;
            $mail->SMTPKeepAlive = true;

            // Recipients
            $mail->setFrom($mailEmail, $senderName ?? 'Lundayan Student Publication');
            $mail->addAddress($to);
            $mail->addReplyTo($fromEmail);

            // Content
            $mail->isHTML(false);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->CharSet = 'UTF-8';

            // Verify connection
            if (!$mail->smtpConnect()) {
                throw new Exception('SMTP connect failed');
            }

            $result = $mail->send();
            $mail->smtpClose();
            
            return $result;

        } catch (Exception $e) {
            error_log("Mailer Error: " . $e->getMessage());
            if (isset($mail)) {
                $mail->smtpClose();
            }
            return false;
        }
    }
}