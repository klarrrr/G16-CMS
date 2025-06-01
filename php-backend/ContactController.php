<?php
session_start();
include 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// Get form data
$firstName = $_POST['first_name'] ?? '';
$lastName = $_POST['last_name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Validate required fields
if (empty($firstName) || empty($lastName) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields except phone number are required']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
    exit;
}

// Prepare the message content
$formattedMessage = "You have received a new contact form submission:\n\n";
$formattedMessage .= "Name: $firstName $lastName\n";
$formattedMessage .= "Email: $email\n";
$formattedMessage .= "Phone: " . ($phone ? $phone : 'Not provided') . "\n";
$formattedMessage .= "Subject: $subject\n\n";
$formattedMessage .= "Message:\n$message";

// Insert into inbox table
$stmt = $conn->prepare("
    INSERT INTO inbox 
    (sender_first_name, sender_last_name, sender_email, sender_phone, subject, message) 
    VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "ssssss",
    $firstName,
    $lastName,
    $email,
    $phone,
    $subject,
    $formattedMessage
);
try {
    // Dynamically get the Website's Admin Email and App Pass
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
    $mailPassword = $passQuery->fetch_assoc()['setting_value'] ?? 'lmug rrup rumq epqh';

    // Instantiate PHPMailer
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = (string) $mailEmail;
    // If something is changed in the gmail account
    // App Password needs to be regenerated
    $mail->Password = (string) $mailPassword;
    // $mail->SMTPDebug = 3; // Enable verbose debug output
    $mail->SMTPSecure = 'ssl';
    $mail->Port = 465;

    if ($stmt->execute()) {
        $fullname = $firstName . ' ' . $lastName;

        $mail->setFrom($email, $fullname);
        $mail->addAddress($mailEmail);

        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "
        First Name: {$_POST['first_name']} <br>
        Last Name: {$_POST['last_name']} <br>
        Email: {$_POST['email']} <br>
        Phone: {$_POST['phone']} <br>
        Subject: {$_POST['subject']} <br>
        Message: {$_POST['message']}
        ";

        if ($mail->send()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode([
                'status' => $mail->ErrorInfo
            ]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save message. Please try again.']);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => $e
    ]);
}

$stmt->close();
$conn->close();
