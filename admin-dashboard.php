<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_type']) !== 'admin') {
    header('Location: lundayan-sign-in-page.php');
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lundayan Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            transition: 0.3s ease-in-out;
        }

        .sidebar {
            width: 250px;
            background-color: #0F5132;
            color: #ecf0f1;
            padding: 20px;
            height: 100vh;
            position: fixed;
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
            display: block;
            padding: 8px 0;
        }

        .sidebar ul li a:hover {
            text-decoration: underline;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        .main-content {
            flex: 1;
            background-color: #f4f4f4;
            padding: 20px;
            margin-left: 250px;
            /* Same as sidebar width */
        }

        header h1 {
            margin-bottom: 20px;
        }

        .admin-info h2 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        .welcome-message {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    
    <div class="admin-container">
        <?php include 'admin-side-bar.php' ?>
        <main class="main-content">
            <header>
                <div class="welcome-message">
                    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_first']) . ' ' . htmlspecialchars($_SESSION['user_last']); ?></h1>
                    <p>You are logged in as <?php echo htmlspecialchars($_SESSION['user_type']); ?></p>
                </div>
            </header>
            <section class="admin-info">
                <h2>Admin Details</h2>
                <table>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Profile Picture</th>
                    </tr>
                    <tr>
                        <td><?php echo htmlspecialchars($_SESSION['user_first']); ?></td>
                        <td><?php echo htmlspecialchars($_SESSION['user_last']); ?></td>
                        <td><?php echo htmlspecialchars($_SESSION['user_email']); ?></td>
                        <td>
                            <?php if (!empty($_SESSION['profile_picture'])): ?>
                                <img src="<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%;">
                            <?php else: ?>
                                No image
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </section>
        </main>
    </div>
</body>

</html>