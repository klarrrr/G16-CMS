    <!-- main/contact.php -->
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Lundayan : Contact</title>
        <link rel="stylesheet" href="styles-lundayan-site.css">
        <link rel="icon" href="pics/lundayan-logo.png">
    </head>

    <body>
        <?php include 'lundayan-site-upper-nav.php' ?>
        <?php include 'lundayan-site-nav.php'; ?>
        <main>

            <!-- <div class="news-banner">
                <div class="scrolling-text">
                    <span> | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | CONTACT US | </span>
                </div>
            </div> -->

            <section class="contact">
                <div class="contact-title-container">
                    <div class="send-container-title">
                        <p>Contact Us</p>
                        <h2>Join us in Creating Something Great</h2>
                    </div>
                    <div class="img-container">
                        <img src="pics/lundayan-logo.png" alt="" id='lundayan-logo'>
                        <img src="pics/PLP_Logo.png" alt="" id='plp-logo'>
                    </div>
                </div>

                <div class="contact-container">
                    <form class="send-info" method="POST" action="../php-backend/ContactController.php">
                        <div class="two-input">
                            <input name='first_name' type="text" placeholder="First Name" required>
                            <input name='last_name' type="text" placeholder="Last Name" required>
                        </div>
                        <div class="two-input">
                            <input name='email' type="email" placeholder="Email" required>
                            <input name='phone' type="text" placeholder="Phone Number">
                        </div>
                        <input name='subject' type="text" placeholder="Subject" required>
                        <textarea name="message" placeholder="Message" required></textarea>
                        <button type="submit" name="submit">Send Message</button>
                    </form>

                    <div class="own-info">
                        <div class="info-box">
                            <div class="vertical-two">
                                <div class="inside-two-vertical">
                                    <h3>Address</h3>
                                    <p>12-B Alcalde Jose, Pasig, 1600 Metro Manila</p>
                                </div>
                                <div class="inside-two-vertical">
                                    <h3>Open Time</h3>
                                    <p>Monday - Friday : 10:00-20:00</p>
                                </div>
                            </div>
                            <div class="vertical-two">
                                <div class="inside-two-vertical">
                                    <h3>Contact</h3>
                                    <p>Phone: 2-8643-1014</p>
                                    <p>Email: lundayan@plpasig.edu.ph</p>
                                </div>
                                <div class="inside-two-vertical">
                                    <h3>Stay Connected</h3>
                                    <div class="soc-med">
                                        <a href="https://www.facebook.com/LundayanPLP" target="_blank"><img src="svg/fb.svg" alt=""></a>
                                        <a href="#"><img src="svg/pinterest.svg" alt=""></a>
                                        <a href="#"><img src="svg/ig.svg" alt=""></a>
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

    </body>

    </html>