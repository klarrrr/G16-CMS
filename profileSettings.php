<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profileSettings.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Settings Page</title>
</head>
<body>

    <!-- Navigation -->
    <?php include 'nav_dashboard.php' ?>

    <!-- Left Sidebar -->
    <div class="main-container">
        <div class="settings-choices">
            <h3>Account Settings</h3>
            <ul>
                <li><a href="profileSettings.php">Personal Information</a></li>
                <li> <a href="login-info.php">Username & Password</a></li>
                <li>Notification</li>
                <li>Connected Accounts</li>
            </ul>
        </div>

        <!-- Right Main Container -->
        <div class="my-profile">

            <!-- Darkmode Toggle -->
            <div class="theme-toggle">
                <div>
                    <h3>My Profile</h3>
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

                    <button><p>Delete Picture</p></button>
                </div>

                <!-- Personal Infos -->
                <div class="perso-info">
                    <h5>Paul Justin Francisco (Full Name)</h5>
                    <p class="bio">2nd Year Student (Bio)</p>
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
    </div>

    <script>
        // Toggle darkmode
        document.getElementById('toggleTheme').addEventListener('click', () => {
            document.body.classList.toggle('dark');
        });
    </script>

</body>
</html>
