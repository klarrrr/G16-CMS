<?php
require_once 'footer-functions.php';
$contactInfo = getContactInfo();
?>

<footer class="footer">
    <div class="footer-container">

        <div class="footer-branding">
            <h1>LUNDAYAN</h1>
            <p>
                Lundayan is developed and maintained by <strong class="highlight">G16</strong> — a collaborative team from
                <strong class="highlight">BSIT-2C</strong> at Pamantasan ng Lungsod ng Pasig.
                The group is a fusion of two creative units:
                <strong class="highlight">Group 1</strong> and <strong class="highlight">Group 6</strong>.
            </p>
            <div class="footer-logos">
                <img src="pics/lundayan-logo.png" alt="Lundayan Logo">
                <img src="pics/PLP_Logo.png" alt="PLP Logo">
                <p>&copy; <?= date('Y'); ?> <strong class="highlight">Lundayan</strong>. All rights reserved.</p>
            </div>
        </div>

        <div class="footer-links">
            <h3>Quick Links</h3>
            <ul>
                <li><a href="lundayan-site-archive.php">Archive</a></li>
                <li><a href="lundayan-site-calendar.php">Calendar</a></li>
                <li><a href="lundayan-site-contact.php">Contact</a></li>
                <li><a href="lundayan-site-about.php">About Us</a></li>
                <li><a href="lundayan-site-team.php">Team</a></li>
            </ul>
        </div>

        <div class="footer-contact">
            <div>
                <h3>Address</h3>
                <p><?= htmlspecialchars($contactInfo['address'] ?? '12-B Alcalde Jose, Pasig, 1600 Metro Manila') ?></p>
            </div>
            <div>
                <h3>Open Time</h3>
                <p>Monday - Friday: <?= htmlspecialchars($contactInfo['open_time'] ?? '10:00–20:00') ?></p>
            </div>
            <div>
                <h3>Contact</h3>
                <p>Phone: <?= htmlspecialchars($contactInfo['phone'] ?? '2-8643-1014') ?></p>
                <p>Email: <?= htmlspecialchars($contactInfo['email'] ?? 'lundayan@plpasig.edu.ph') ?></p>
            </div>
            <div>
                <h3>Stay Connected</h3>
                <div class="footer-socials">
                    <?php if (!empty($contactInfo['socials']['facebook_url'])): ?>
                        <a href="<?= htmlspecialchars($contactInfo['socials']['facebook_url']) ?>" target="_blank">
                            <img src="svg/fb.svg" alt="Facebook">
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($contactInfo['socials']['instagram_url'])): ?>
                        <a href="<?= htmlspecialchars($contactInfo['socials']['instagram_url']) ?>" target="_blank">
                            <img src="svg/ig.svg" alt="Instagram">
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($contactInfo['socials']['pinterest_url'])): ?>
                        <a href="<?= htmlspecialchars($contactInfo['socials']['pinterest_url']) ?>" target="_blank">
                            <img src="svg/pinterest.svg" alt="Pinterest">
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</footer>

<!-- Floating FAQ Button and Container -->
<div class="faq-float-btn" id="faqFloatBtn">?</div>
<div class="faq-float-container" id="faqFloatContainer">
    <div class="faq-float-header">
        <h2>FAQs</h2>
        <button class="faq-float-close" id="faqFloatClose">&times;</button>
    </div>
    <div class="faq-float-content">
        <!-- FAQ Card 1 -->
        <div class="faq-card">
            <div class="faq-card-header">
                <h3 class="faq-card-title">What type of content do you publish?</h3>
                <button class="faq-card-toggle">+</button>
            </div>
            <div class="faq-card-content">
                <p>We publish a wide range of content including news articles about PLP, opinion pieces, tutorials, how-to guides, interviews, and expert analysis in various categories such as technology, health, lifestyle, education, entertainment, and more.</p>
            </div>
        </div>

        <!-- FAQ Card 2 -->
        <div class="faq-card">
            <div class="faq-card-header">
                <h3 class="faq-card-title">How do I search for specific topics?</h3>
                <button class="faq-card-toggle">+</button>
            </div>
            <div class="faq-card-content">
                <p>You can use the search bar at the Archive Page to find articles by keyword, title, or topic. You can also browse by category or tags for more specific content.</p>
            </div>
        </div>

        <!-- FAQ Card 3 -->
        <div class="faq-card">
            <div class="faq-card-header">
                <h3 class="faq-card-title">Are the articles fact-checked?</h3>
                <button class="faq-card-toggle">+</button>
            </div>
            <div class="faq-card-content">
                <p>Yes, we prioritize accuracy and credibility. All articles go through editorial review, and factual information is verified using reliable sources before publication.</p>
            </div>
        </div>

        <!-- FAQ Card 4 -->
        <div class="faq-card">
            <div class="faq-card-header">
                <h3 class="faq-card-title">Can I share articles on social media?</h3>
                <button class="faq-card-toggle">+</button>
            </div>
            <div class="faq-card-content">
                <p>Absolutely! We encourage readers to share our content on social platforms using the share buttons provided at the top or bottom of each article.</p>
            </div>
        </div>

        <!-- FAQ Card 5 -->
        <div class="faq-card">
            <div class="faq-card-header">
                <h3 class="faq-card-title">Do you have a mobile app?</h3>
                <button class="faq-card-toggle">+</button>
            </div>
            <div class="faq-card-content">
                <p>Currently, we do not have a dedicated mobile app, but our website is fully responsive and optimized for smartphones and tablets.</p>
            </div>
        </div>

        <!-- FAQ Card 6 -->
        <div class="faq-card">
            <div class="faq-card-header">
                <h3 class="faq-card-title">How to report an error?</h3>
                <button class="faq-card-toggle">+</button>
            </div>
            <div class="faq-card-content">
                <p>If you notice an error, please contact us via our "Contact Us" page and specify the article title and the issue. We take corrections seriously and will update the article as needed.</p>
            </div>
        </div>

        <!-- FAQ Card 7 -->
        <div class="faq-card">
            <div class="faq-card-header">
                <h3 class="faq-card-title">How to contact the editorial team?</h3>
                <button class="faq-card-toggle">+</button>
            </div>
            <div class="faq-card-content">
                <p>You can reach out to our editorial team using the contact form or by emailing us at <a href="mailto:lundayan@plpasig.edu.ph" style="color: #fcb404;">lundayan@plpasig.edu.ph</a>. We welcome feedback, story suggestions, and inquiries.</p>
            </div>
        </div>

        <!-- FAQ Card 8 -->
        <div class="faq-card">
            <div class="faq-card-header">
                <h3 class="faq-card-title">Can I republish your articles?</h3>
                <button class="faq-card-toggle">+</button>
            </div>
            <div class="faq-card-content">
                <p>Republishing articles without permission is not allowed. However, you may quote short excerpts with proper attribution and a backlink to the original article. For full republishing rights, please contact us.</p>
            </div>
        </div>
    </div>
</div>

<script src="scripts/faq-button-handler.js"></script>