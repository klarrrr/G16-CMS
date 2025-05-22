<?php
include 'php-backend/connect.php';

session_start();

$user_id = $_SESSION['user_id'] ?? null;
$pic = $_SESSION['profile_picture'] ?? null;
?>

<header>
    <nav>
        <ul class="nav-links">
            <li><a href="lundayan-site-home.php">Home</a></li>
            <li><a href="lundayan-site-archive.php">Archive</a></li>
            <li><a href="lundayan-site-calendar.php">Calendar</a></li>

            <?php if ($user_id && $pic): ?>
                <li>
                    <img src="data:image/png;base64,<?= htmlspecialchars($pic) ?>" alt="Profile Picture" id="lundayan-pfp" style="height: 40px; width: 40px; border-radius: 50%;">
                </li>
            <?php endif; ?>

            <li><a href="lundayan-site-contact.php">Contact</a></li>
            <li><a href="lundayan-site-about.php">About</a></li>
            <li><a href="#">Team</a></li>

            <?php if (!$user_id): ?>
                <li><a href="lundayan-sign-in-page.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<script>
    document.getElementById('lundayan-pfp').addEventListener('click', () => {
        window.location.href = 'editor-dashboard.php';
    });
</script>