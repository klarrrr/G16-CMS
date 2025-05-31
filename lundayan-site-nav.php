<?php
include 'php-backend/connect.php';

$user_id = $_SESSION['user_id'] ?? null;
$pic = $_SESSION['profile_picture'] ?? null;
$user_type = $_SESSION['user_type'] ?? null; // Get user type from session

$pfp = ($pic) ? ($pic) : 'pics/no-pic.jpg';
?>


<header class="site-header">
    <div class="header-container">

        <?php if ($user_id): ?>
            <img src="<?php echo $pfp ?>" alt="Profile Picture" id="lundayan-pfp" class="pfp-img">
        <?php endif; ?>

        <h1 class="site-title" style='display: none;'>LUNDAYAN</h1>


        <div class="burger" id="burger">
            <div></div>
            <div></div>
            <div></div>
        </div>

        <nav class="nav-container" id="nav-container">
            <ul class="nav-links">
                <li><a href="lundayan-site-home.php">Home</a></li>
                <li><a href="lundayan-site-archive.php">Archive</a></li>
                <li><a href="lundayan-site-calendar.php">Calendar</a></li>

                <?php if ($user_id): ?>
                    <li id='loob'>
                        <img src="<?php echo $pfp ?>" alt="Profile Picture" id="lundayan-pfp" class="pfp-img">
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
    </div>
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

    // Burger menu toggle
    const burger = document.getElementById('burger');
    const navContainer = document.getElementById('nav-container');

    burger.addEventListener('click', () => {
        navContainer.classList.toggle('show');
    });
</script>