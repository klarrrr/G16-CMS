<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$fname = $_SESSION['user_first'];
$lname = $_SESSION['user_last'];
$email = $_SESSION['user_email'];
$profile_pic = $_SESSION['profile_picture'];
$cover_photo = $_SESSION['cover_photo'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Account Settings</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body class="body">
    <div class="float-cards" style='display: none;'></div>
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <div class="right-editor-container">
        <section class="account-settings" id='account-settings'>

            <div class="settings-container">

                <div class="cover-pic">
                    <label class="-label-cover" for="cover-file">
                        <span>Change Cover Photo</span>
                    </label>

                    <input id="cover-file" type="file" onchange="loadCover(event)" />

                    <img src="<?php echo (!$cover_photo) ? 'pics/plp-outside.jpg' : 'data:image/png;base64,' . $cover_photo; ?>" id="cover" />
                </div>

                <div class="person-info-container">

                    <div class="pictures-container">
                        <div class="profile-pic-account">

                            <label class="-label" for="pfp-file">
                                <span>Change Profile Picture</span>
                            </label>

                            <input id="pfp-file" type="file" onchange="loadPfp(event)" />


                            <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : 'data:image/png;base64,' . $profile_pic; ?>" id="pfp" />
                        </div>
                    </div>


                    <div class="input-fields">

                        <div class="first-last">
                            <div class='input-box-container'>
                                <p>First name</p>
                                <input type="text" placeholder="First Name" value='<?php echo $fname; ?>'>
                            </div>

                            <div class='input-box-container'>
                                <p>Last name</p>
                                <input type="text" placeholder="Last Name" value='<?php echo $lname; ?>'>
                            </div>
                        </div>

                        <div class='input-box-container'>
                            <p>Email address</p>
                            <input type="email" placeholder="Email Address" value='<?php echo $email; ?>'>
                        </div>

                        <!-- <input type="text" placeholder="Bio"> -->

                        <!-- Save & Discard Buttons -->
                        <div class="save-buttons">
                            <input type="button" name="saveChanges" value="Save Changes">
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>


    <!-- Script for Menu Button on Top Left -->
    <script src="scripts/menu_button.js"></script>
    <script>
        const user_id = `<?php echo $user_id; ?>`;

        function loadPfp(event) {
            const pfp = document.getElementById("pfp");
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64String = e.target.result.split(',')[1]; // Extract Base64 string
                    if (base64String.length > 16777215) {
                        // NO MORE THAN 16777215 chars
                        console.log("Image size is too large : " + base64String.length);
                        // TODO : Maglagay ng warning label
                        // warningLbl.style.display = 'block';
                    } else {
                        // PWEDE basta less than 16777215 chars
                        console.log("This is allowed : " + base64String.length)
                        $.ajax({
                            url: 'php-backend/account-settings-update-profile-pic.php',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                base64String: base64String,
                                user_id: user_id
                            },
                            success: (res) => {
                                console.log(res.status);
                                pfp.src = 'data:image/png;base64,' + base64String;
                                updateDateUpdated(user_id);
                                // warningLbl.style.display = 'none';
                            },
                            error: (error) => {
                                console.log(error);
                            }
                        });
                    }
                };
                reader.readAsDataURL(file); // Read file as Data URL
            } else {
                console.log('No file selected.');
            }
        }

        function loadCover(event) {
            var cover = document.getElementById("cover");
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const base64String = e.target.result.split(',')[1]; // Extract Base64 string
                    if (base64String.length > 16777215) {
                        // NO MORE THAN 16777215 chars
                        console.log("Image size is too large : " + base64String.length);
                        // TODO : Maglagay ng warning label
                        // warningLbl.style.display = 'block';
                    } else {
                        // PWEDE basta less than 16777215 chars
                        console.log("This is allowed : " + base64String.length)
                        $.ajax({
                            url: 'php-backend/account-settings-update-cover-pic.php',
                            type: 'post',
                            dataType: 'json',
                            data: {
                                base64String: base64String,
                                user_id: user_id
                            },
                            success: (res) => {
                                console.log(res.status);
                                cover.src = 'data:image/png;base64,' + base64String;
                                updateDateUpdated(user_id);
                                // warningLbl.style.display = 'none';
                            },
                            error: (error) => {
                                console.log(error);
                            }
                        });
                    }
                };
                reader.readAsDataURL(file); // Read file as Data URL
            } else {
                console.log('No file selected.');
            }
        }

        function updateDateUpdated(user_id) {
            $.ajax({
                url: 'php-backend/account-settings-update-user-date-updated.php',
                type: 'post',
                dataType: 'json',
                data: {
                    user_id: user_id
                },
                success: (res) => {
                    console.log(res.status);
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }
    </script>
</body>

</html>