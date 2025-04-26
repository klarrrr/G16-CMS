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

    <!-- Body -->
    <div class="main-container">
        <div class="settings-choices">
            <h3>Profile Settings</h3>
            <ul>
                <li>Personal Information</li>
                <li>Username & Password</li>
                <li>Notification</li>
                <li>Connected Accounts</li>
            </ul>

            <button>Log Out</button>
        </div>

        <div class="my-profile">
            <div class="theme-toggle">
                <button id="toggleTheme"><i class='bx bxs-moon'></i> Darkmode Toggle</button>
            </div>

            <div>
                <h3>My Profile</h3>
            </div>

            <div class="profile-picture">
                <input type="image" src="#" alt="Profile Picture Placeholder">
                
                <label for="file-upload" class="custom-file-upload">Change Picture</label>
                <input id="file-upload" type="file" style="display: none;">

                <button><p>Delete Picture</p></button>
            </div>

            <div class="perso-info">
                <h5>Full Name</h5>
                <p class="bio">Bio / Additional Description</p>
            </div>

            <div class="input-fields">
                <input type="text" placeholder="Last Name">
                <input type="text" placeholder="First Name">
                <input type="email" placeholder="Email Address">
                <input type="text" placeholder="Bio">

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
