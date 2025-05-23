<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Admin Settings - Lundayan Dashboard</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            transition: 0.3s ease-in-out;
        }

        .admin-container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #ecf0f1;
            text-decoration: none;
        }

        .sidebar ul li a:hover {
            text-decoration: underline;
        }

        .main-content {
            flex: 1;
            background-color: #f4f4f4;
            padding: 20px;
        }

        header h1 {
            margin-bottom: 20px;
        }

        .settings-section h2 {
            margin-bottom: 15px;
        }

        .settings-form {
            background-color: white;
            padding: 20px;
            max-width: 600px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .settings-form label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .settings-form input,
        .settings-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .settings-form button {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        .settings-form button:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <aside class="sidebar">
            <h2>Admin Panel</h2>
            <ul>
                <li><a href="#">Dashboard</a></li>
                <li><a href="#">Inbox</a></li>
                <li><a href="#">Manage Users</a></li>
                <li><a href="#">Audit Log</a></li>
                <li><a href="#">Settings</a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            <header>
                <h1>Settings</h1>
            </header>

            <section class="settings-section">
                <h2>System Settings</h2>
                <form class="settings-form" method="POST" action="update-settings.php">
                    <!-- Contact Email (Used in Mailer) -->
                    <label for="contact_email">Contact Email</label>
                    <input type="email" id="contact_email" name="contact_email" value="depadua_charlesjeramy@plpasig.edu.ph" required />

                    <!-- Admin Account Email -->
                    <label for="admin_email">Admin Email</label>
                    <input type="email" id="admin_email" name="admin_email" value="admin@lundayan.plpasig.edu.ph" required />

                    <!-- Change Password -->
                    <label for="admin_password">Change Password</label>
                    <input type="password" id="admin_password" name="admin_password" placeholder="Enter new password" />

                    <!-- Theme Selector -->
                    <label for="dashboard_theme">Dashboard Theme</label>
                    <select id="dashboard_theme" name="dashboard_theme">
                        <option value="default">Default</option>
                        <option value="dark">Dark</option>
                        <option value="light">Light</option>
                    </select>

                    <!-- Submit Button -->
                    <button type="submit">Save Changes</button>
                </form>
            </section>
        </main>
    </div>
</body>

</html>
