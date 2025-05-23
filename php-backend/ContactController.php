session_start();
include 'connect.php';

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

if ($stmt->execute()) {
    // Send email notification to admin (optional)
    $adminEmail = 'lundayan@plpasig.edu.ph';
    $emailSubject = "New Contact Form Submission: $subject";
    $emailMessage = "You have received a new message from $firstName $lastName ($email).\n\n";
    $emailMessage .= "Subject: $subject\n";
    $emailMessage .= "Message:\n$message\n\n";
    $emailMessage .= "This message has been saved in your inbox.";

    // Uncomment to actually send email
    // mail($adminEmail, $emailSubject, $emailMessage);

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to save message. Please try again.']);
}

$stmt->close();
$conn->close();
