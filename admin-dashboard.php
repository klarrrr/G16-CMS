<?php
session_start();

include 'php-backend/connect.php';

if (!isset($_SESSION['user_id']) || strtolower($_SESSION['user_type']) !== 'admin') {
  header('Location: lundayan-sign-in-page.php');
  exit;
}

function getCount($conn, $sql)
{
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  return array_values($row)[0];
}

$totalArticles = getCount($conn, "SELECT COUNT(*) FROM articles");
$totalUsers = getCount($conn, "SELECT COUNT(*) FROM users");
$archivedCount = getCount($conn, "SELECT COUNT(*) FROM articles WHERE archive_status = 'archived'");
$postedCount = getCount($conn, "SELECT COUNT(*) FROM articles WHERE completion_status = 'published' AND approve_status = 'yes' AND archive_status = 'active'");
$draftCount = getCount($conn, "SELECT COUNT(*) FROM articles WHERE completion_status = 'draft'");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="styles-admin.css">
  <link rel="icon" href="pics/lundayan-logo.png">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    main.dashboard-content {
      display: flex;
      flex-direction: column;
      width: 100%;
      height: 100%;
      padding: 2rem;
      overflow-y: auto;
    }

    .welcome-card {
      background: #fff;
      border-radius: 10px;
      padding: 1.5rem;
      border: 1px solid lightgray;
      margin-bottom: 2rem;
    }

    .welcome-card h1 {
      font-size: 1.8rem;
      margin-bottom: 0.5rem;
      color: #161616;
    }

    .welcome-card p {
      color: #555;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 1.5rem;
    }

    .stat-card {
      background-color: #ffffff;
      border: 1px solid #ddd;
      border-radius: 12px;
      padding: 1.5rem;
      display: flex;
      align-items: center;
      gap: 1rem;
      transition: 0.3s;
    }

    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .stat-icon {
      font-size: 2rem;
      color: #161616;
    }

    .stat-info h3 {
      margin: 0;
      font-size: 1.4rem;
      color: #161616;
    }

    .stat-info p {
      margin: 0;
      color: #555;
      font-size: 0.9rem;
      font-family: sub;
    }

    .charts-container {
      display: flex;
      flex-direction: row;
      height: fit-content;

      div {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 300px;
        padding: 1rem;
        border-radius: 10px;
        border: 1px solid lightgray;
        background-color: white;
      }
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
  <?php include 'admin-side-bar.php'; ?>

  <main class="dashboard-content">
    <div class="welcome-card">
      <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_first']) . ' ' . htmlspecialchars($_SESSION['user_last']); ?></h1>
      <p>You are logged in as <?php echo htmlspecialchars($_SESSION['user_type']); ?></p>
    </div>

    <div class="stats-grid">
      <div class="stat-card">
        <i class="fas fa-newspaper stat-icon"></i>
        <div class="stat-info">
          <h3><?= $totalArticles ?></h3>
          <p>Total Articles</p>
        </div>
      </div>

      <div class="stat-card">
        <i class="fas fa-users stat-icon"></i>
        <div class="stat-info">
          <h3><?= $totalUsers ?></h3>
          <p>Registered Users</p>
        </div>
      </div>

      <div class="stat-card">
        <i class="fas fa-archive stat-icon"></i>
        <div class="stat-info">
          <h3><?= $archivedCount ?></h3>
          <p>Archived Articles</p>
        </div>
      </div>

      <div class="stat-card">
        <i class="fas fa-upload stat-icon"></i>
        <div class="stat-info">
          <h3><?= $postedCount ?></h3>
          <p>Posted Articles</p>
        </div>
      </div>

      <div class="stat-card">
        <i class="fas fa-pencil-alt stat-icon"></i>
        <div class="stat-info">
          <h3><?= $draftCount ?></h3>
          <p>Draft Articles</p>
        </div>
      </div>
    </div>

    <div class="charts-container">
      <!-- Pie Chart -->
      <div style="margin-top: 2rem;">
        <!-- <h2>Articles Overview</h2> -->
        <canvas id="articlesChart" height="100"></canvas>
      </div>

      <!-- Bar Chart -->
      <!-- <div style="margin-top: 2rem;">
        <h2>User Growth</h2>
        <canvas id="userChart" height="100"></canvas>
      </div> -->

    </div>

  </main>

  <script>
    const articlesCtx = document.getElementById('articlesChart').getContext('2d');
    const articlesChart = new Chart(articlesCtx, {
      type: 'pie',
      data: {
        labels: ['Posted', 'Draft', 'Archived'],
        datasets: [{
          data: [<?= $postedCount ?>, <?= $draftCount ?>, <?= $archivedCount ?>],
          backgroundColor: ['#161616', '#363636', '#565656']
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'bottom'
          },
          title: {
            display: true,
            text: 'Articles by Status'
          }
        }
      }
    });

    // const userCtx = document.getElementById('userChart').getContext('2d');
    // const userChart = new Chart(userCtx, {
    //   type: 'bar',
    //   data: {
    //     labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'], // Example months
    //     datasets: [{
    //       label: 'New Users',
    //       data: [5, 8, 4, 9, 12, 7], // Replace with real data from DB
    //       backgroundColor: '#161616'
    //     }]
    //   },
    //   options: {
    //     responsive: true,
    //     plugins: {
    //       title: {
    //         display: true,
    //         text: 'User Registrations Over Time'
    //       }
    //     },
    //     scales: {
    //       y: {
    //         beginAtZero: true
    //       }
    //     }
    //   }
    // });
  </script>

</body>

</html>