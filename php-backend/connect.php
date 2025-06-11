<?php

// Localhost, usernam, pass, db_name
$conn = mysqli_connect("sql202.infinityfree.com", "if0_39140690", "2J1ejyuqTfg3", "if0_39140690_cms_db");

if ($conn == false) {
    // stop then output connect error
    die("Error: " . mysqli_connect_error());
}
