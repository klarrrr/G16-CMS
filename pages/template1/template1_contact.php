<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles_template1_contact.css">
    <title>Document</title>
</head>

<body>
    <?php include 'template1_nav.php'; ?>
    <div class="main_page">
        <div class="texts_container">
            <h1>CONTACT US</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
        </div>
    </div>
    <div class="get_in_touch_container">
        <div class="left_side_container">
            <div class="title_texts_container">
                <h2>Get In Touch</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
            </div>
            <div class="contacts_container">
                <div class="phone_container">
                    <h3>Phone</h3>
                    <p>(+081) 5678 1234</p>
                </div>
                <div class="email_container">
                    <h3>Email</h3>
                    <p>company@email.com</p>
                </div>
                <div class="address_container">
                    <h3>Address</h3>
                    <p>Tondo, Manila</p>
                </div>
                <div class="instagram_container">
                    <h3>Instagram</h3>
                    <p>@company.ig</p>
                </div>
            </div>
        </div>
        <form action="" method="" class="right_side_container">
            <div class="email_name_container">
                <div class="email_container"> <label for="email">Email</label>
                    <input type="email" name="email" placeholder="Your email here">
                </div>
                <div class="name_container"> <label for="name">Name</label>
                    <input type="text" name="name" placeholder="Your name here">
                </div>
            </div>
            <div class="phone_container">
                <label for="phone">Phone</label>
                <input type="number" name="phone" placeholder="Phone number here">
            </div>
            <div class="message_container">
                <label for="message">Message</label>
                <textarea name="message" id="" style="resize: none;" placeholder="Write message here"></textarea>
            </div>
            <div class="submit_btn_container">
                <input type="submit" name="submit_btn" value="Submit">
            </div>
        </form>
    </div>
    <div class="maps_container">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d30885.507595475305!2d120.94169470275375!3d14.616815472717438!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3397b58db60b02ad%3A0xce24240621e8656e!2sTondo%2C%20Manila%2C%20Metro%20Manila!5e0!3m2!1sen!2sph!4v1744900048158!5m2!1sen!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <?php include 'template1_footer.php' ?>
</body>

</html>