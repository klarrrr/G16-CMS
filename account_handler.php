<?php

include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login_account'])) {
        // Sanizied Data
        $email = test_input($_POST["user_email"]);
        $pass = test_input($_POST["user_pass"]);

        $query = "SELECT * FROM users WHERE user_email = '$email' AND user_pass = '$pass'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            header("Location: editor.php");
            exit();
        } else {
            echo "<script>alert('Something wrong with email or password');</script>";
        }
    }
}


// User sanitizer, kill 99.99% of script injectors!!
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
