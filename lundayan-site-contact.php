<?php
session_start();
require_once 'php-backend/connect.php';

// Fetch all site settings
$settingsQuery = $conn->query("SELECT * FROM site_settings");
$siteSettings = [];
while ($row = $settingsQuery->fetch_assoc()) {
    $siteSettings[$row['setting_group']][$row['setting_name']] = $row['setting_value'];
}

// Format open hours
$openTime = isset($siteSettings['contact']['open_time_start']) ? date("H:i", strtotime($siteSettings['contact']['open_time_start'])) : '10:00';
$closeTime = isset($siteSettings['contact']['open_time_end']) ? date("H:i", strtotime($siteSettings['contact']['open_time_end'])) : '20:00';
$openHours = "Monday - Friday : $openTime-$closeTime";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : Contact</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
</head>

<style>
    .faq-container {
        display: flex;
        flex-direction: column;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 1rem;
        padding: 2rem 0;
    }

    .faq-container-h2 {
        font-family: robinson;
        font-size: 10rem;
        font-weight: lighter;
        line-height: normal;
        color: #f4f4f4;
        line-height: 9rem;
        text-align: center;
    }

    .faq-container-p {
        font-size: 1em;
        color: #f4f4f4;
        text-align: center;
        margin-bottom: 2rem;
    }

    .faq-container-title {
        display: flex;
        flex-direction: column;
        width: 100%;
        justify-content: center;
    }

    .faqs {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        width: 80%;
        max-width: 800px;
    }

    .faq-box {
        display: flex;
        flex-direction: column;
        background-color: #1D2E28;
        padding: 2rem;
        border-radius: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .faq-box.active {
        background-color: #2a3d36;
    }

    .faq-title {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    .faq-h2 {
        font-size: 1.2rem;
        font-weight: 600;
        color: #f4f4f4;
        margin: 0;
        flex: 1;
    }

    .faq-p {
        color: #e0e0e0;
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding-top 0.3s ease;
        line-height: 1.6;
    }

    .faq-box.active .faq-p {
        max-height: 500px;
        /* Adjust based on your longest content */
        padding-top: 1rem;
    }

    .faq-open {
        font-size: 1.5rem;
        font-weight: bold;
        color: #f4f4f4;
        transition: transform 0.3s ease;
        margin-left: 1rem;
    }

    .faq-box.active .faq-open {
        transform: rotate(45deg);
    }

    @media (max-width: 768px) {
        .faq-container-h2 {
            font-size: 5rem;
            line-height: 5rem;
        }

        .faq-container-p {
            width: 80%;
        }

        .faqs {
            width: 95%;
        }

        .faq-h2 {
            font-size: 1rem;
        }
    }


    .popup-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .popup-message {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        max-width: 400px;
        width: 90%;
        text-align: center;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
    }

    .popup-message p {
        margin-bottom: 1.5rem;
        font-size: 1.1rem;
    }

    .popup-message button {
        padding: 0.5rem 1.5rem;
        background-color: #0a5c36;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s;
    }

    .popup-message button:hover {
        background-color: #084b2d;
    }
</style>

<body>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>

    <main>
        <section class="contact">
            <div class="contact-title-container">
                <div class="send-container-title">
                    <h2>Join us in Creating Something Great</h2>
                    <p>Reach out through the form, and we will respond within the next 24 hours. If you prefer to email instead, you can reach out to us at lundayan@plpasig.edu.ph</p>
                </div>
            </div>

            <div class="contact-container">
                <form class="send-info" id="contactForm" method="POST">
                    <div class="two-input">
                        <input name='first_name' type="text" placeholder="First Name" required>
                        <input name='last_name' type="text" placeholder="Last Name" required>
                    </div>
                    <div class="two-input">
                        <input name='email' type="email" placeholder="Email" required>
                        <input name='phone' type="text" placeholder="Phone Number">
                    </div>
                    <input name='subject' type="text" placeholder="Subject" required>
                    <textarea name="message" placeholder="Message" required rows="15"></textarea>
                    <button type="submit" name="submit">Send Message</button>
                </form>

                <div class="own-info">
                    <div class="info-box">
                        <div class="vertical-two">
                            <div class="inside-two-vertical">
                                <h3>Address</h3>
                                <p><?= htmlspecialchars($siteSettings['contact']['address'] ?? '12-B Alcalde Jose, Pasig, 1600 Metro Manila') ?></p>
                            </div>
                            <div class="inside-two-vertical">
                                <h3>Open Time</h3>
                                <p><?= htmlspecialchars($openHours) ?></p>
                                <div class="vertical-two">
                                    <div class="inside-two-vertical">
                                        <h3>Contact</h3>
                                        <p>Phone: <?= htmlspecialchars($siteSettings['contact']['phone'] ?? '2-8643-1014') ?></p>
                                        <p>Email: <?= htmlspecialchars($siteSettings['mail']['email'] ?? 'lundayan@plpasig.edu.ph') ?></p>
                                    </div>
                                    <div class="inside-two-vertical">
                                        <h3>Stay Connected</h3>
                                        <div class="soc-med">
                                            <?php if (!empty($siteSettings['social']['facebook_url'])): ?>
                                                <a href="<?= htmlspecialchars($siteSettings['social']['facebook_url']) ?>" target="_blank"><img src="svg/fb.svg" alt="" title="Facebook"></a>
                                            <?php endif; ?>
                                            <?php if (!empty($siteSettings['social']['pinterest_url'])): ?>
                                                <a href="<?= htmlspecialchars($siteSettings['social']['pinterest_url']) ?>"><img src="svg/pinterest.svg" alt="" title="Pinterest"></a>
                                            <?php endif; ?>
                                            <?php if (!empty($siteSettings['social']['instagram_url'])): ?>
                                                <a href="<?= htmlspecialchars($siteSettings['social']['instagram_url']) ?>"><img src="svg/ig.svg" alt="" title="Instagram"></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

           
        </section>

        <section class="map">
            <div class="map-container-title">
                <p>Our location</p>
                <h2>Visit us personally at Pamantasan ng Lungsod ng Pasig</h2>
            </div>
            <iframe src="https://www.google.com/maps/embed?pb=!3m2!1sen!2sph!4v1745757782841!5m2!1sen!2sph!6m8!1m7!1sz4FNKx2OpNJSW-c5VZK5aQ!2m2!1d14.56158870027559!2d121.0747112138096!3f14.589646372267358!4f10.705321812288432!5f0.4000000000000002" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </section>
    </main>

    <div id="popup-backdrop" class="popup-backdrop">
        <div id="popup-message" class="popup-message">
            <p id="popup-text">Message sent!</p>
            <button onclick="closePopup()">Close</button>
        </div>
    </div>

    <?php include 'lundayan-site-footer.php'; ?>

    <script>
        function closePopup() {
            document.getElementById('popup-backdrop').style.display = 'none';
        }

        window.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const status = params.get('status');
            if (status === 'success' || status === 'fail') {
                const text = status === 'success' ? 'Message sent successfully!' : 'Failed to send message. Try again.';
                document.getElementById('popup-text').textContent = text;
                document.getElementById('popup-backdrop').style.display = 'flex';
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const faqBoxes = document.querySelectorAll('.faq-box');

            faqBoxes.forEach(box => {
                box.addEventListener('click', function() {
                    // Close all other FAQs
                    faqBoxes.forEach(otherBox => {
                        if (otherBox !== box && otherBox.classList.contains('active')) {
                            otherBox.classList.remove('active');
                        }
                    });

                    // Toggle current FAQ
                    this.classList.toggle('active');
                });
            });
        });
    </script>

    <script>
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);
            const submitButton = form.querySelector('button[type="submit"]');

            // Disable button during submission
            submitButton.disabled = true;
            submitButton.textContent = 'Sending...';

            fetch('/G16-CMS/php-backend/ContactController.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        // Show success popup
                        document.getElementById('popup-text').textContent = 'Message sent successfully!';
                        document.getElementById('popup-backdrop').style.display = 'flex';

                        // Reset form
                        form.reset();
                    } else {
                        // Show error message
                        document.getElementById('popup-text').textContent = data.message || 'Failed to send message. Please try again.';
                        document.getElementById('popup-backdrop').style.display = 'flex';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('popup-text').textContent = 'An error occurred. Please try again.';
                    document.getElementById('popup-backdrop').style.display = 'flex';
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Send Message';
                });
        });
    </script>
</body>

</html>