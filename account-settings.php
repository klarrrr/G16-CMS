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
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <style>
        /* Remove button styles */
        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #666;
            color: rgb(255, 255, 255);
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: none;
            z-index: 1000000;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            transition: all 0.2s ease;
        }

        .remove-btn:hover {
            background: #333;
            color: white;
            transform: scale(1.1);
        }

        .profile-pic-account:hover .remove-btn,
        .cover-pic:hover .remove-btn {
            display: flex;
            align-items: center;
            justify-content: center;
        }


        /* Ensure proper z-index stacking */
        .profile-pic-account,
        .cover-pic {
            position: relative;
            z-index: 1;
        }

        .-label,
        .-label-cover {
            z-index: 2;
        }
    </style>
</head>

<body class="body">
    <!-- Floating dark mode button -->

    <div class="float-cards" style='display: none;'></div>
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <div class="right-editor-container" id='act-settings'>
        <section class="account-settings" id='account-settings'>

            <div class="cover-pic">
                <button class="remove-btn" onclick="removeImage('cover')" <?php echo !$cover_photo ? 'style="display:none"' : ''; ?>>×</button>

                <label class="-label-cover" for="cover-file">
                    <span>Change Cover Photo</span>
                </label>

                <input id="cover-file" type="file" onchange="loadCover(event)" />

                <img src="<?php echo (!$cover_photo) ? 'pics/plp-outside.jpg' : $cover_photo; ?>" id="cover" />
            </div>

            <div class="person-info-container">

                <div id='account-setting-title'>
                    <h1 style='font-family: "main"; font-size: 2rem;'>Account Settings</h1>
                </div>

                <div class="below-account-title">
                    <div class="pictures-container">
                        <div class="profile-pic-account">
                            <button class="remove-btn" onclick="removeImage('pfp')" <?php echo !$profile_pic ? 'style="display:none"' : ''; ?>>×</button>

                            <label class="-label" for="pfp-file">
                                <span>Change Profile Picture</span>
                            </label>

                            <input id="pfp-file" type="file" onchange="loadPfp(event)" />

                            <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : $profile_pic; ?>" id="pfp" />
                        </div>
                    </div>

                    <div class="input-fields">
                        <div class="first-last">
                            <div class='input-box-container'>
                                <p>First name</p>
                                <input type="text" placeholder="First Name" value='<?php echo $fname; ?>' id='user-first-name'>
                            </div>

                            <div class='input-box-container'>
                                <p>Last name</p>
                                <input type="text" placeholder="Last Name" value='<?php echo $lname; ?>' id='user-last-name'>
                            </div>
                        </div>

                        <div class='input-box-container'>
                            <p>Email address</p>
                            <input type="email" placeholder="Email Address" value='<?php echo $email; ?>' id='user-email'>
                        </div>

                        <div class="save-buttons">
                            <input type="button" name="saveChanges" value="Save Changes" onclick="saveChanges()">
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
            if (!file) return;

            const formData = new FormData();
            formData.append("user_id", user_id);
            formData.append("pfp_file", file);

            $.ajax({
                url: 'php-backend/account-settings-update-profile-pic.php',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: (res) => {
                    console.log(res.status);
                    pfp.src = res.path;
                    // Show remove button after upload
                    document.querySelector('.profile-pic-account .remove-btn').style.display = 'flex';
                    updateDateUpdated(user_id);
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }

        function loadCover(event) {
            const cover = document.getElementById("cover");
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append("user_id", user_id);
            formData.append("cover_file", file);

            $.ajax({
                url: 'php-backend/account-settings-update-cover-pic.php',
                type: 'post',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: (res) => {
                    console.log(res.status);
                    cover.src = res.path;
                    // Show remove button after upload
                    document.querySelector('.cover-pic .remove-btn').style.display = 'flex';
                    updateDateUpdated(user_id);
                },
                error: (error) => {
                    console.log(error);
                }
            });
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

        function removeImage(type) {
            if (!confirm(`Are you sure you want to remove your ${type === 'pfp' ? 'profile picture' : 'cover photo'}?`)) {
                return;
            }

            const fallbackImage = type === 'pfp' ? 'pics/no-pic.jpg' : 'pics/plp-outside.jpg';
            const endpoint = type === 'pfp' ? 'php-backend/account-settings-remove-profile-pic.php' : 'php-backend/account-settings-remove-cover-pic.php';
            const removeBtn = document.querySelector(`.${type === 'pfp' ? 'profile-pic-account' : 'cover-pic'} .remove-btn`);

            $.ajax({
                url: endpoint,
                type: 'post',
                dataType: 'json',
                data: {
                    user_id: user_id
                },
                success: (res) => {
                    if (res.success) {
                        document.getElementById(type).src = fallbackImage;
                        removeBtn.style.display = 'none';
                        updateDateUpdated(user_id);

                        // Show success message
                        alert(`${type === 'pfp' ? 'Profile picture' : 'Cover photo'} removed successfully!`);
                    }
                },
                error: (error) => {
                    console.log(error);
                    alert('Error removing image. Please try again.');
                }
            });
        }

        // Save Changes function
        const userFirstName = document.getElementById('user-first-name');
        const userLastName = document.getElementById('user-last-name');
        const userEmail = document.getElementById('user-email');

        function saveChanges() {
            $.ajax({
                url: 'php-backend/update-account-settings.php',
                type: 'post',
                dataType: 'json',
                data: {
                    userFirstName: userFirstName.value,
                    userLastName: userLastName.value,
                    userEmail: userEmail.value,
                    user_id: user_id
                },
                success: (res) => {
                    if (res.success) {
                        alert("Successfully Updated");
                    }
                },
                error: (error) => {
                    console.log(error);
                }
            });
        }
    </script>
</body>

</html>