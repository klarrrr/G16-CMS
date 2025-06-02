<?php

// Localhost, usernam, pass, db_name
$conn = mysqli_connect("sql210.infinityfree.com", "if0_39052828", "Zl3Gg7qEWqhh", "if0_39052828_cms_db");

if ($conn == false) {
    // stop then output connect error
    die("Error: " . mysqli_connect_error());
}
