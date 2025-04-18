<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Nav Bar</title>
    <link rel="stylesheet" href="styles_admin_nav.css">
</head>

<body>
    <nav>
        <div class="text_container">
            <h1>Admin Page</h1>
        </div>
        <div class="choices_container">
            <div class="main_choices_container">
                <ul class="main_choices">
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="admin_manage_user.php">Manage Users</a></li>
                    <li><a href="admin_manage_projects.php">Manage Projects</a></li>
                </ul>
            </div>
            <div class="sub_choices_container">
                <ul class="sub_choices">
                    <li><a href="admin_settings.php">Settings</a></li>
                    <!-- TODO : Lagyan function ng logout -->
                    <li><a href="">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</body>

</html>