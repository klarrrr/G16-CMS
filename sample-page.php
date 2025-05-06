<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome - Lundayan</title>
</head>
<body>
    <h1>Welcome, <?= htmlspecialchars(
        $_SESSION['user_first'] . ' ' . $_SESSION['user_last']
    ) ?>!</h1>
    <p>This is your dashboard.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
