<?php
session_start();

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_type']) !== 'admin') {
    header('Location: lundayan-sign-in-page.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lundayan Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #e9f1ea; /* Light greenish background */
        }

        .sidebar {
            width: 250px;
            background-color: #0F5132; /* Dark green */
            color: #fff;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 20px;
        }

        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #d1e7dd; /* Light greenish text */
            text-decoration: none;
            display: block;
            padding: 8px 0;
        }

        .sidebar ul li a:hover {
            text-decoration: underline;
            color: #a3cfbb; /* Hover light green */
        }

        .main-content {
            margin-left: 250px;
            padding: 2rem;
        }

        .welcome-message {
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(15, 81, 50, 0.3);
            margin-bottom: 2rem;
        }

        .welcome-message h1 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            color: #0F5132; /* Dark green */
        }

        .welcome-message p {
            color: #2e7d32; /* Medium green */
        }

        .admin-info h2 {
            margin-bottom: 1rem;
            font-size: 1.4rem;
            color: #0F5132;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(15, 81, 50, 0.2);
        }

        th,
        td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #d4edda; /* Light greenish border */
        }

        th {
            background-color: #198754; /* Bootstrap green */
            color: white;
        }

        td img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #198754; /* subtle green border */
        }
    </style>
</head>

<body>

    <?php include 'admin-side-bar.php'; ?>

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
                        <?php if (!empty($_SESSION['profile_picture'])) : ?>
                            <img src="<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profile Picture" />
                        <?php else : ?>
                            No image
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </section>
    </main>

</body>

</html>
