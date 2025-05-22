<?php
 $host = "sql210.infinityfree.com";  
$username = "if0_39052828";  
$password = "Zl3Gg7qEWqhh"; 
$dbname = "if0_39052828_cms_db";  

 $conn = mysqli_connect($host, $username, $password, $dbname);

 if ($conn == false) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully!";
?>