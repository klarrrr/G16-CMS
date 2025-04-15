<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Backend</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            gap: 50px;
        }

        .website_details_container {
            display: flex;
            flex-direction: column;
        }

        .website_template_container {
            display: flex;
            flex-direction: column;
        }

        .sign_up_container {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <h1 contenteditable="true">CREATE PAGE</h1>
    <form action="" method="post">
        <!-- Website Details Container -->
        <div class="website_details_container">
            <div class="">
                <label for="website_name">Website Name:</label>
                <input type="text" name="website_name">
            </div>
            <div class="">
                <label for="website_description">Website Description:</label>
                <textarea name="website_description" id=""></textarea>
            </div>
            <div class="">
                <!-- TODO : Make this a selector, get the website type from database -->
                <label for="website_type">Website Type:</label>
                <input type="text" name="website_type">
            </div>
        </div>
        <!-- Website Template Container -->
        <div class="website_template_container">
            <div class="">
                <!-- TODO : Make a visual choice where user can see what template looks like -->
                <label for="website_template">Website Template:</label>
                <input type="text" name="website template">
            </div>
        </div>
        <!-- Website Sign Up Container -->
        <div class="sign_up_container">
            <div class="">
                <label for="username_box">Username</label>
                <input type="text" name="username_box">
            </div>
            <div class="">
                <label for="password_box">Password</label>
                <input type="password" name="password_box">
            </div>
        </div>
        <div class="domain_name_container">
            <div class="">
                <label for="domain_name_box">Domain Name: </label>
                <input type="text" name="domain_name_box">
            </div>
        </div>
        <!-- Automize Basic Info Container -->
        <div class="automize_basic_info_container">
            <div class="automize_basic_info">
                <div class="">
                    <label for="tagline_box">Tagline:</label>
                    <input type="text" name="tagline_box" id="">
                </div>
                <div class="">
                    <label for="logo_box">Logo: </label>
                    <input type="file" name="logo_box" id="">
                </div>
                <div class="">
                    <label for="contact_box">Contact: </label>
                    <input type="number" name="contact_box" id="">
                </div>
                <div class="">
                    <label for="soc_med">Social Media: </label>
                    <input type="email" name="soc_med" id="">
                </div>
            </div>
        </div>
        <!-- Style Preferences Container -->
        <div class="style_preferences_container">
            <div class="style_preferences">
                <!-- TODO : Make this a selector in the future -->
                <!-- PLUS : Make input for main, sub, sub2, or any other variants of color schemes -->
                <div class="">
                    <label for="color_scheme">Color Scheme: </label>
                    <input type="text" name="color_scheme">
                </div>
                <!-- TODO : Make this a selection in the future -->
                <div class="">
                    <label for="typography">Typography</label>
                    <input type="text" name="typography">
                </div>
            </div>
        </div>
        <div class="navigation_container">
            <div class="navigation">
                <div class="">
                    <!-- TODO : Make this automatically be Home, About, Services, Content, Blog or Store as default -->
                    <label for="">Navigation Pages</label>
                    <input type="text" name="navigation">
                </div>
            </div>
        </div>
    </form>
</body>

</html>