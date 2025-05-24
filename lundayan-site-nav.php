<?php
include 'php-backend/connect.php';

$user_id = $_SESSION['user_id'] ?? null;
$pic = $_SESSION['profile_picture'] ?? null;
$user_type = $_SESSION['user_type'] ?? null; // Get user type from session

$pfp = ($pic) ? ('data:image/png;base64,' . $pic) : 'pics/no-pic.jpg';
?>


<header>
    <nav>
        <ul class="nav-links">
            <li><a href="lundayan-site-home.php">Home</a></li>
            <li><a href="lundayan-site-archive.php">Archive</a></li>
            <li><a href="lundayan-site-calendar.php">Calendar</a></li>

            <?php if ($user_id): ?>
                <li>
                    <img src="<?php echo $pfp ?>" alt="Profile Picture" id="lundayan-pfp" style="height: 40px; width: 40px; border-radius: 50%;">
                </li>
            <?php endif; ?>

            <li><a href="lundayan-site-contact.php">Contact</a></li>
            <li><a href="lundayan-site-about.php">About</a></li>
            <li><a href="lundayan-site-team.php">Team</a></li>

            <?php if (!$user_id): ?>
                <li><a href="lundayan-sign-in-page.php">Login</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<script>
    const userType = <?php echo json_encode($user_type); ?>;

    const pfp = document.getElementById('lundayan-pfp');
    if (pfp) {
        pfp.addEventListener('click', () => {
            if (userType === 'Admin') {
                window.location.href = 'admin-dashboard.php';
            } else if (userType === 'Reviewer' || userType === 'Writer') {
                window.location.href = 'editor-dashboard.php';
            } else {
                alert("Unknown user type.");
            }
        });
    }
</script>