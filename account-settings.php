<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Account Settings</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="cms-preview-styles.css">
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
            <div class="my-profile">

                <!-- Darkmode Toggle -->
                <div class="theme-toggle">
                    <div>
                        <h1 style='font-family: "main"; font-size: 3rem;'>Account Settings</h1>
                        <p style='font-family: "sub";'>Paul Group</p>
                    </div>
                    <div class="toggle">
                        <button id="toggleTheme"><i class='bx bxs-moon'></i> Darkmode</button>
                    </div>
                </div>

                <!-- Profile Picture -->

                <div class="profile-info">
                    <div class="profile-picture">
                        <div class="img-container">
                            <input type="image" src="img.jpeg" alt="">
                        </div>

                        <label for="file-upload" class="custom-file-upload">Change Picture</label>
                        <input id="file-upload" type="file" style="display: none;">

                        <button>
                            <p>Delete Picture</p>
                        </button>
                    </div>

                    <!-- Personal Infos -->
                    <div class="perso-info">
                        <h5><?php echo $_SESSION['user_first'] . ' ' . $_SESSION['user_last'] ?></h5>
                        <p class="bio">Article Writer</p>
                    </div>
                </div>

                <div class="input-fields">
                    <div class="first-last">
                        <input type="text" placeholder="Last Name">
                        <input type="text" placeholder="First Name">
                    </div>

                    <input type="email" placeholder="Email Address">
                    <input type="text" placeholder="Bio">

                    <!-- Save & Discard Buttons -->
                    <div class="save-buttons">
                        <input type="button" name="saveChanges" value="Save Changes">
                        <input type="button" name="discardChanges" value="Discard Changes">
                    </div>
                </div>
            </div>
            <div class="settings-choices">
                <h3>Account Settings</h3>
                <ul>
                    <li><a href="profileSettings.php">Personal Information</a></li>
                    <li> <a href="login-info.php">Username & Password</a></li>
                    <li>Notification</li>
                    <li>Connected Accounts</li>
                </ul>
            </div>
        </section>

        <!-- Script for Menu Button on Top Left -->
        <script src="scripts/menu_button.js"></script>
        <script>
            // Toggle darkmode
            document.getElementById('toggleTheme').addEventListener('click', () => {
                document.body.classList.toggle('dark');
            });
        </script>
</body>

</html>