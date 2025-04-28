<?php

// Localhost, usernam, pass, db_name
$conn = mysqli_connect("localhost", "root", "", "cms_db");

if ($conn == false) {
    // stop then output connect error
    die("Error: " . mysqli_connect_error());
}
