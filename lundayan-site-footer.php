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
                <li><a href="#">Team</a></li>
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