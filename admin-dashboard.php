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
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;
      margin: 0;
      padding: 0;
      display: flex;
      min-height: 100vh;
    }

    .sidebar {
      width: 250px;
      background-color: #0F5132;
      color: #ecf0f1;
      padding: 20px;
      height: 100vh;
      position: sticky;
      top: 0;
      overflow-y: auto;
    }

    .sidebar h2 {
      margin-bottom: 20px;
    }

    .sidebar ul {
      list-style: none;
      padding: 0;
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

    main.dashboard-content {
      flex: 1;
      padding: 2rem;
      overflow-y: auto;
    }

    .welcome-card {
      background: #fff;
      border-radius: 10px;
      padding: 1.5rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
    }

    .welcome-card h1 {
      font-size: 1.8rem;
      margin-bottom: 0.5rem;
      color: #0F5132;
    }

    .welcome-card p {
      color: #555;
    }

    .admin-card {
      background: #fff;
      border-radius: 10px;
      padding: 1.5rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .admin-card h2 {
      font-size: 1.4rem;
      margin-bottom: 1rem;
      color: #0F5132;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 1rem;
    }

    th, td {
      padding: 1rem;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #0F5132;
      color: white;
    }

    tr:hover {
      background-color: #f8f9fa;
    }

    .profile-pic {
      width: 50px;
      height: 50px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #0F5132;
    }

    .no-image {
      color: #666;
      font-style: italic;
    }
  </style>
</head>

<body>
  <?php include 'admin-side-bar.php'; ?>

  <main class="dashboard-content">
    <div class="welcome-card">
      <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_first']) . ' ' . htmlspecialchars($_SESSION['user_last']); ?></h1>
      <p>You are logged in as <?php echo htmlspecialchars($_SESSION['user_type']); ?></p>
    </div>

    <div class="admin-card">
      <h2>Admin Details</h2>
      <table>
        <thead>
          <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Profile Picture</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo htmlspecialchars($_SESSION['user_first']); ?></td>
            <td><?php echo htmlspecialchars($_SESSION['user_last']); ?></td>
            <td><?php echo htmlspecialchars($_SESSION['user_email']); ?></td>
            <td>
              <?php if (!empty($_SESSION['profile_picture'])) : ?>
                <img src="<?php echo htmlspecialchars($_SESSION['profile_picture']); ?>" alt="Profile Picture" class="profile-pic" />
              <?php else : ?>
                <span class="no-image">No image</span>
              <?php endif; ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>