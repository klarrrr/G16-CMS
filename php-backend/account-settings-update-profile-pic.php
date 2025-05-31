<?php
session_start();
include 'connect.php';

$user_id = $_POST['user_id'];
$uploadDir = '../pfp-pics/';
$file = $_FILES['pfp_file'];

if ($file && $file['error'] === UPLOAD_ERR_OK) {
    $fileName = 'pfp_' . $user_id . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $targetFilePath = $uploadDir . $fileName;
    $relativePath = 'pfp-pics/' . $fileName;

    // Fetch old picture
    $res = mysqli_query($conn, "SELECT profile_picture FROM users WHERE user_id = $user_id");
    $row = mysqli_fetch_assoc($res);
    $old_path = $row['profile_picture'];

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        // Delete old file if not default
        if ($old_path && $old_path != 'pics/no-pic.jpg' && file_exists('../' . $old_path)) {
            unlink('../' . $old_path);
        }

        // Update DB and session
        $query = "UPDATE users SET profile_picture = '$relativePath' WHERE user_id = $user_id";
        mysqli_query($conn, $query);
        $_SESSION['profile_picture'] = $relativePath;

        echo json_encode([
            'status' => 'success',
            'path' => $relativePath
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File move failed']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Upload error']);
}
