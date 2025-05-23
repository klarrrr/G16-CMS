<?php session_start(); ?>
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

    .faq-container{
        display: flex;
        flex-direction: column;
        width: 100%;
        justify-content: center;
        align-items: center;
        gap: 1rem;

        .faq-container-h2{
            font-family: robinson;
            font-size: 10rem;
            font-weight: lighter;
            line-height: normal;
            color: #f4f4f4;
            line-height: 9rem;
            text-align: center;
        }

        .faq-container-p{
            font-size: 1em;
            color: #f4f4f4;
            text-align: center;
            width: 50%;
        }
    }

    .faq-container-title{
        display: flex;
        flex-direction: column;
        width: 100%;
        justify-content: center;
    }

    .faqs{
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .faq-box{
        display: flex;
        flex-direction: column;
        background-color: #1D2E28;
        padding: 2rem;
        border-radius: 1rem;
    }

    .faq-open{
        font-size: 2rem;
        align-self: center;
        font-weight: bold;
    }

    .faq-title{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
    }

    .faq-h2{
        
    }

    .faq-p{

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
                <form class="send-info" method="POST" action="/G16-CMS/php-backend/ContactController.php">
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

                <!-- <div class="own-info">
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
                                    <a href="https://www.facebook.com/LundayanPLP" target="_blank"><img src="svg/fb.svg" alt="" title="Facebook"></a>
                                    <a href="#"><img src="svg/pinterest.svg" alt="" title="Pinterest"></a>
                                    <a href="#"><img src="svg/ig.svg" alt="" title="Instagram"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <div class="faq-container">
                    <div class="faq-container-title">
                        <h2 class="faq-container-h2">FAQS</h2>
                        <p class="faq-container-p">Have questions? Check out our FAQ Section for Quick and Helpful Answers</p>
                    </div>
                  
                    <div class="faqs">
                        <div class="faq-box">
                            <div class="faq-title">
                                <h2 class="faq-h2">What type of content do you publish?</h2>
                                <span class="faq-open">+</span>
                            </div>
                            <p class="faq-p">
                                We publish a wide range of content including news articles, opinion pieces, tutorials, how-to guides, interviews, and expert analysis in various categories such as technology, health, lifestyle, education, entertainment, and more.
                            </p>
                        </div>

                         <div class="faq-box">
                            <div class="faq-title">
                                <h2 class="faq-h2">What type of content do you publish?</h2>
                                <span class="faq-open">+</span>
                            </div>
                            <p class="faq-p">
                                We publish a wide range of content including news articles, opinion pieces, tutorials, how-to guides, interviews, and expert analysis in various categories such as technology, health, lifestyle, education, entertainment, and more.
                            </p>
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

    </script>

</body>

</html>