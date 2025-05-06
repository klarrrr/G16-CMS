<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Optional: Clear session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to login page
header("Location: lundayan-sign-in-page.php"); // Change to your login page if needed
exit;
?>
