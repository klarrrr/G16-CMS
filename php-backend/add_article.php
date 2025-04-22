<?php
include 'connect.php';

// Post Page ID here
$pageOwner = $_POST['page_id'] ?? null;

// check
if (!$pageOwner) {
    echo json_encode(['error' => 'No page ID provided']);
    exit;
}

// Insert a blank section where the article will be put into
// TODO : Change Template to 'project' later on
$stmt1 = $conn->prepare("INSERT INTO sections (section_name, page_owner, `type`) VALUES ('Article', ?, 'template')");
$stmt1->bind_param("i", $pageOwner);

$stmt1->execute();

// Insert title text, images and paragraph in sections to elements
// TODO : Change template to project in future updates
$stmt2 = $conn->prepare("
INSERT INTO elements (element_name, element_type, content, section_owner, `type`) VALUES 
('Title Text', 'title', '{\"content\": \"Sample Captivating Title\"}', (SELECT MAX(section_id) FROM sections), 'template'),
('Image', 'image', '{\"content\": \"default.png\"}', (SELECT MAX(section_id) FROM sections), 'template'),
('Paragraph Text', 'paragraph', '{\"content\": \"Sample Captivating Paragraph...\"}', (SELECT MAX(section_id) FROM sections), 'template')
");

$stmt2->execute();

$elementsArray = [];

// Gets all the elements that are related to the recently inserted Section
$stmt3 = $conn->prepare("SELECT * FROM elements WHERE section_owner = (SELECT MAX(section_id) FROM sections)");
$stmt3->execute();
$result = $stmt3->get_result();

while ($row = mysqli_fetch_assoc($result)) {
    $elementsArray[] = $row;
}

$stmt1->close();
$stmt2->close();
$stmt3->close();
$conn->close();

echo json_encode([
    'elements' => $elementsArray
]);
