<?php
if (isset($_POST['url'])) {

    $publicDir = "/video/";
    $storageDir = "../video/";

    $url = $_POST['url'];
    $filename = basename($url); 
    $filePath = $storageDir . $filename;

    if (file_exists($filePath)) {


        if (unlink($filePath)) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "error" => "Failed to delete file."]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "File not found."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "No file URL provided."]);
}
