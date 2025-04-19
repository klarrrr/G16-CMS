<?php

include 'connect.php';

if (isset($_POST["page_id"]) && isset($_POST["elements"])) {
    $pageId = $_POST["page_id"];
    $elements = $_POST["elements"]; // This is an associative array: elementId => content

    foreach ($elements as $elementId => $newContent) {
        // Sanitize and encode the data (depending on how you're storing it)
        $sanitizedContent = mysqli_real_escape_string($conn, $newContent);
        $jsonContent = json_encode(["content" => $sanitizedContent]);

        // Update the specific element
        $sql = "UPDATE elements SET content = ? WHERE element_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "si", $jsonContent, $elementId);
        mysqli_stmt_execute($stmt);
    }
} else {
    echo "Invalid request.";
}
