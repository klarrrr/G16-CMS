<?php
session_start();
include 'connect.php';

$user_id = $_POST['user_id'];
$uploadDir = '../cover-pics/';
$file = $_FILES['cover_file'];

if ($file && $file['error'] === UPLOAD_ERR_OK) {
    $fileName = 'cover_' . $user_id . '_' . time() . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
    $targetFilePath = $uploadDir . $fileName;
    $relativePath = 'cover-pics/' . $fileName;

    // Fetch old cover
    $res = mysqli_query($conn, "SELECT cover_photo FROM users WHERE user_id = $user_id");
    $row = mysqli_fetch_assoc($res);
    $old_path = $row['cover_photo'];

    if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
        if ($old_path && $old_path != 'pics/plp-outside.jpg' && file_exists('../' . $old_path)) {
            unlink('../' . $old_path);
        }

        $query = "UPDATE users SET cover_photo = '$relativePath' WHERE user_id = $user_id";
        mysqli_query($conn, $query);
        $_SESSION['cover_photo'] = $relativePath;

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
