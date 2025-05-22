<?php
$targetDir = "../video/";
$publicDir = "/G16-CMS/video/"; // Public URL path (relative to your localhost)

if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

if (isset($_FILES['video'])) {
    $file = $_FILES['video'];
    $fileName = time() . "_" . basename($file["name"]);
    $targetFile = $targetDir . $fileName;
    $allowedTypes = ['video/mp4', 'video/webm', 'video/ogg'];

    if (in_array($file['type'], $allowedTypes)) {
        if (move_uploaded_file($file["tmp_name"], $targetFile)) {
            echo json_encode([
                "success" => true,
                "url" => $publicDir . $fileName // ✅ Use public URL
            ]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to move uploaded file."]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Invalid file type."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No file uploaded."]);
}
