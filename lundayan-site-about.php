<?php

session_start();

$role = 'reader';

if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['user_type'];
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : About</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>

    <main class="about-main-content">

        <div class="about-banner">
            <video autoplay loop muted>
                <source src="video/AQM9GRflcrkqyEOH95BxXqm1ePrwj9xqBYnDUDSudmRdBPoX1FBNAHX5aM--gjI2fqtUJXeaZ1XpVHC7JicWvTY8.mp4" type="video/mp4">
            </video>
            <h1 class='about-lundayan-title'>ABOUT US</h1>
        </div>

        <div class="what-is-lundayan">
            <img src="pics/lundayan-logo.png" alt="Lundayan Logo">

            <div class="info-container-left">
                <h2>What even is the Lundayan website?</h2>

                <hr>

                <p>Lundayan is an article publication platform created to showcase compelling written works— from insightful news to thought-provoking opinion pieces. Whether you’re a casual reader or a passionate writer, Lundayan is your harbor for verified and meaningful content. <br><br>
                    The platform highlights articles authored by dedicated writers and carefully reviewed by our panel of reviewers to ensure quality, accuracy, and integrity in every publication.
                </p>
            </div>
        </div>

        <div class="our-mission">
            <div class="info-container-right">
                <h2>What is our mission?</h2>

                <hr>

                <p>Our mission is to promote thoughtful discourse and storytelling by giving students a platform to publish their works and engage with a wider audience. We believe in the power of well-crafted words to inform, inspire, and influence.
                </p>
            </div>

            <img src="pics/thinker.jpg" alt="Lundayan Logo">
        </div>

        <div class="who-are-we">
            <img src="pics/study-anime.gif" alt="Lundayan Logo">

            <div class="info-container-left">
                <h2>Who are we?</h2>

                <hr>

                <p>We are student storytellers from Pamantasan ng Lungsod ng Pasig—curious minds with pens in hand and purpose in heart. Through Lundayan, we breathe life into words, crafting articles that echo voices often unheard, shed light on truths that matter, and spark conversations that move. Every story we publish is a piece of who we are: driven, daring, and deeply devoted to the power of the written word.
                </p>
            </div>
        </div>

        <div class="what-we-do">
            <div class="info-container-center">
                <h2>What do we do?</h2>
                <hr>
            </div>

            <div class="roles-container">
                <div class="role" style="background-image: url(pics/typewriter.jpg);" title="Writer Box">
                    <p>Writers contribute original articles covering a wide range of topics.</p>
                    <h3>Writer</h3>
                    <hr>
                    <div class="darken-bg"></div>
                </div>
                <div class="role" style="background-image: url(pics/reviewer.jpg);">
                    <p>Reviewers ensure each piece meets editorial and factual standards.</p>
                    <h3>Reviewer</h3>
                    <hr>
                    <div class="darken-bg"></div>
                </div>
                <div class="role" style="background-image: url(pics/reader.jpg);">
                    <p>Readers enjoy fresh, meaningful, and reliable content.</p>
                    <h3>Reader</h3>
                    <hr>
                    <div class="darken-bg"></div>
                </div>
            </div>

            <p class='end-p'>Whether you want to express your ideas, stay informed, or support student journalism— Lundayan is here for you.</p>
        </div>

        <section class="member-note" role="note" aria-live="polite">
            <div class="info-container-center">
                <h2>Are you a member?</h2>
                <hr>
            </div>
            <div class="member-role-container">
                <p>👁 You are viewing this page as a <strong><?php echo htmlspecialchars($role) ?></strong> of Lundayan.</p>
                <a href="lundayan-sign-in-page.php" id="sign-in-link">Sign in if you're a member</a>
                <a href="editor-dashboard.php" id="editor-dashboard-link">Go to Editor Dashboard</a>
            </div>
        </section>


    </main>

    <?php include 'lundayan-site-footer.php' ?>

    <script>
        // Pass PHP $user_id to JS, null if not set
        const userId = <?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null'; ?>;

        const signInLink = document.getElementById('sign-in-link');
        const editorDashboardLink = document.getElementById('editor-dashboard-link');

        if (userId) {
            // User logged in: show editor dashboard link, hide sign-in
            signInLink.style.display = 'none';
            editorDashboardLink.style.display = 'inline'; // or 'block' if you want block display
        } else {
            // User not logged in: show sign-in, hide editor dashboard
            signInLink.style.display = 'inline';
            editorDashboardLink.style.display = 'none';
        }
    </script>

</body>

</html>