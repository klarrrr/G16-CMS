<?php
include 'connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

header('Content-Type: application/json');

$messageId = intval($_POST['message_id'] ?? 0);
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Validate Details
if ($messageId <= 0 || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($subject) || empty($message)) {
  http_response_code(400);
  echo json_encode(['success' => false, 'error' => 'Invalid input']);
  exit;
}

// Dynamically get the Website's Admin Email and App Pass first
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

$mail->setFrom($mailEmail);
$mail->addAddress($email);

$mail->isHTML(true);
$mail->Subject = "{$subject}";
$mail->Body = "{$message}";

if ($mail->send()) {
  // Mark message as replied in database
  $query = "UPDATE inbox SET replied = 1 WHERE inbox_id = ?";
  $stmt = mysqli_prepare($conn, $query);
  mysqli_stmt_bind_param($stmt, 'i', $messageId);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'error' => 'Failed to send email']);
}

mysqli_close($conn);
