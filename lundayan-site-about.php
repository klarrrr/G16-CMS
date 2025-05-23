<?php 
session_start();
require_once 'php-backend/connect.php';

// Fetch about settings from database
$aboutSettings = [];
$aboutQuery = $conn->query("SELECT section_type, title, content, image_url, video_url FROM about_settings");
while ($row = $aboutQuery->fetch_assoc()) {
    $aboutSettings[$row['section_type']] = $row;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : About</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="<?= htmlspecialchars($aboutSettings['what_is']['image_url'] ?? 'pics/lundayan-logo.png') ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>

    <main class="about-main-content">

        <div class="about-banner">
            <?php if (!empty($aboutSettings['banner']['video_url'])): ?>
                <video autoplay loop muted>
                    <source src="<?= htmlspecialchars($aboutSettings['banner']['video_url']) ?>" type="video/mp4">
                </video>
            <?php endif; ?>
            <h1 class='about-lundayan-title'>ABOUT US</h1>
        </div>

        <div class="what-is-lundayan">
            <img src="<?= htmlspecialchars($aboutSettings['what_is']['image_url'] ?? 'pics/lundayan-logo.png') ?>" alt="Lundayan Logo">

            <div class="info-container-left">
                <h2><?= htmlspecialchars($aboutSettings['what_is']['title'] ?? 'What even is the Lundayan website?') ?></h2>

                <hr>

                <p><?= nl2br(htmlspecialchars($aboutSettings['what_is']['content'] ?? 'Lundayan is an article publication platform created to showcase compelling written works— from insightful news to thought-provoking opinion pieces. Whether you\'re a casual reader or a passionate writer, Lundayan is your harbor for verified and meaningful content. <br><br>
                    The platform highlights articles authored by dedicated writers and carefully reviewed by our panel of reviewers to ensure quality, accuracy, and integrity in every publication.')) ?>
                </p>
            </div>
        </div>

        <div class="our-mission">
            <div class="info-container-right">
                <h2><?= htmlspecialchars($aboutSettings['mission']['title'] ?? 'What is our mission?') ?></h2>

                <hr>

                <p><?= nl2br(htmlspecialchars($aboutSettings['mission']['content'] ?? 'Our mission is to promote thoughtful discourse and storytelling by giving students a platform to publish their works and engage with a wider audience. We believe in the power of well-crafted words to inform, inspire, and influence.')) ?>
                </p>
            </div>

            <img src="<?= htmlspecialchars($aboutSettings['mission']['image_url'] ?? 'pics/thinker.jpg') ?>" alt="Our Mission">
        </div>

        <div class="who-are-we">
            <img src="<?= htmlspecialchars($aboutSettings['who_we_are']['image_url'] ?? 'pics/study-anime.gif') ?>" alt="Who We Are">

            <div class="info-container-left">
                <h2><?= htmlspecialchars($aboutSettings['who_we_are']['title'] ?? 'Who are we?') ?></h2>

                <hr>

                <p><?= nl2br(htmlspecialchars($aboutSettings['who_we_are']['content'] ?? 'We are student storytellers from Pamantasan ng Lungsod ng Pasig—curious minds with pens in hand and purpose in heart. Through Lundayan, we breathe life into words, crafting articles that echo voices often unheard, shed light on truths that matter, and spark conversations that move. Every story we publish is a piece of who we are: driven, daring, and deeply devoted to the power of the written word.')) ?>
                </p>
            </div>
        </div>

        <div class="what-we-do">
            <div class="info-container-center">
                <h2><?= htmlspecialchars($aboutSettings['roles']['title'] ?? 'What do we do?') ?></h2>
                <hr>
            </div>

            <div class="roles-container">
                <div class="role" style="background-image: url(<?= htmlspecialchars($aboutSettings['role_writer']['image_url'] ?? 'pics/typewriter.jpg') ?>);" title="What writer does">
                    <p><?= htmlspecialchars($aboutSettings['role_writer']['content'] ?? 'Writers contribute original articles covering a wide range of topics.') ?></p>
                    <h3><?= htmlspecialchars($aboutSettings['role_writer']['title'] ?? 'Writer') ?></h3>
                    <hr>
                    <div class="darken-bg"></div>
                </div>
                <div class="role" style="background-image: url(<?= htmlspecialchars($aboutSettings['role_reviewer']['image_url'] ?? 'pics/reviewer.jpg') ?>);" title="What reviewer does">
                    <p><?= htmlspecialchars($aboutSettings['role_reviewer']['content'] ?? 'Reviewers ensure each piece meets editorial and factual standards.') ?></p>
                    <h3><?= htmlspecialchars($aboutSettings['role_reviewer']['title'] ?? 'Reviewer') ?></h3>
                    <hr>
                    <div class="darken-bg"></div>
                </div>
                <div class="role" style="background-image: url(<?= htmlspecialchars($aboutSettings['role_reader']['image_url'] ?? 'pics/reader.jpg') ?>);" title="What reader does">
                    <p><?= htmlspecialchars($aboutSettings['role_reader']['content'] ?? 'Readers enjoy fresh, meaningful, and reliable content.') ?></p>
                    <h3><?= htmlspecialchars($aboutSettings['role_reader']['title'] ?? 'Reader') ?></h3>
                    <hr>
                    <div class="darken-bg"></div>
                </div>
            </div>

            <p class='end-p'><?= htmlspecialchars($aboutSettings['roles']['footer_content'] ?? 'Whether you want to express your ideas, stay informed, or support student journalism— Lundayan is here for you.') ?></p>
        </div>

    </main>

    <?php include 'lundayan-site-footer.php' ?>

</body>

</html>