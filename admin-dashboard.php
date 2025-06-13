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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="styles-admin.css">
  <link rel="icon" href="pics/lundayan-logo.png">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    :root {
      --sidebar-width: 250px;
      --header-height: 70px;
      --transition-speed: 0.3s;
    }

    html, body {
      height: 100%;
    }

    body {
      font-family: 'Segoe UI', Arial, sans-serif;
      background: #f5f5f5;
      color: #333;
      display: flex;
      flex-direction: column;
      overflow-x: hidden;
    }

    /* Mobile menu toggle button */
    .mobile-menu-toggle {
      display: none;
      background: white;
      color: #222;
      border: none;
      padding: 1rem;
      width: 100%;
      text-align: left;
      font-size: 1rem;
      cursor: pointer;
      z-index: 1001;
    }

    .mobile-menu-toggle i {
      margin-right: 8px;
    }

    .main-container {
      display: flex;
      flex: 1;
      min-height: 0; 
    }

    /* Sidebar styling */
    .left-editor-container {
      width: var(--sidebar-width);
      background: #222;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      bottom: 0;
      overflow-y: auto;
      transition: transform var(--transition-speed) ease;
      z-index: 1000;
    }

    /* Main content area */
    .right-editor-container {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      margin-left: var(--sidebar-width);
      transition: margin-left var(--transition-speed) ease;
      width: 100%;
      max-width: 100vw;
      overflow-x: hidden;
    }

    .page-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: white;
      padding: 1.5rem 2rem;
      border-bottom: 1px solid #e0e0e0;
      width: 100%;
    }

    .page-header h1 {
      font-size: 1.8rem;
      color: #222;
      font-weight: 600;
    }

    .page-header p {
      color: #666;
      font-size: 0.9rem;
      margin-top: 0.5rem;
    }

    .dashboard-content {
      flex: 1;
      overflow-y: auto;
    }

    .dashboard-container {
      padding: 2rem;
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }

    .welcome-card {
      background: #fff;
      border-radius: 10px;
      padding: 1.5rem;
      border: 1px solid lightgray;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }

    .welcome-card h1 {
      font-size: 1.8rem;
      color: #161616;
    }

    .welcome-card p {
      color: #555;
    }

    #datetime {
      font-size: 1.2rem;
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
    }

    .charts-container {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .chart-card {
      display: flex;
      flex-direction: column;
      justify-content: center;
      height: 300px;
      padding: 1rem;
      border-radius: 10px;
      border: 1px solid lightgray;
      background-color: white;
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      .mobile-menu-toggle {
        display: block;
      }

      .left-editor-container {
        transform: translateX(-100%);
        width: 250px;
        position: fixed;
        z-index: 1001;
      }

      .left-editor-container.active {
        transform: translateX(0);
      }

      .right-editor-container {
        margin-left: 0;
      }

      body.sidebar-open {
        overflow: hidden;
      }

      .welcome-card {
        flex-direction: column;
      }

      .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      }
    }

    @media (max-width: 768px) {
      .page-header {
        padding: 1rem 1.25rem;
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
      }

      .page-header h1 {
        font-size: 1.4rem;
      }

      .dashboard-container {
        padding: 1rem;
      }

      .welcome-card h1 {
        font-size: 1.4rem;
      }

      #datetime {
        font-size: 1rem;
      }

      .stat-card {
        padding: 1rem;
      }

      .stat-icon {
        font-size: 1.5rem;
      }

      .stat-info h3 {
        font-size: 1.2rem;
      }
    }

    @media (max-width: 480px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }

      .page-header h1 {
        font-size: 1.2rem;
      }

      .page-header p {
        font-size: 0.8rem;
      }

      .welcome-card h1 {
        font-size: 1.2rem;
      }

      #datetime {
        font-size: 0.9rem;
      }
    }

    .sidebar-overlay {
      content: '';
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
      display: none;
    }

    body.sidebar-open .sidebar-overlay {
      display: block;
    }

    .left-editor-container {
      top: 0;
      position: fixed;
      height: 100vh;
      overflow-y: auto;
    }
  </style>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
  <!-- Mobile menu toggle button -->
  <button class="mobile-menu-toggle" id="mobileMenuToggle">
    <i class="fas fa-bars"></i> Menu
  </button>

  <div class="main-container">
    <div class="left-editor-container" id="sidebar">
      <?php include 'admin-side-bar.php'; ?>
    </div>

    <div class="right-editor-container" id="mainContent">
      <div class="page-header">
        <div style='display:flex; flex-direction:column;'>
          <h1>Dashboard</h1>
          <p>You are logged in as <?php echo htmlspecialchars($_SESSION['user_type']); ?></p>
        </div>
      </div>

      <div class="dashboard-content">
        <div class="dashboard-container">
          <div class="welcome-card">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user_first']) . ' ' . htmlspecialchars($_SESSION['user_last']); ?></h1>
            <div id="datetime" style="font-size: 1.2rem; margin-top: 0.5rem; color: #555;"></div>
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
            <div class="chart-card">
              <canvas id="articlesChart" height="100"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const mobileToggle = document.getElementById('mobileMenuToggle');
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');
      const body = document.body;
      
      // Initialize sidebar state
      function initSidebar() {
        if (window.innerWidth > 992) {
          sidebar.classList.add('active');
          mainContent.classList.add('shifted');
        }
      }
      
      // Toggle sidebar
      mobileToggle.addEventListener('click', function(e) {
        e.stopPropagation();
        sidebar.classList.toggle('active');
        body.classList.toggle('sidebar-open');
        
        // Change icon
        const icon = this.querySelector('i');
        if (sidebar.classList.contains('active')) {
          icon.classList.remove('fa-bars');
          icon.classList.add('fa-times');
        } else {
          icon.classList.remove('fa-times');
          icon.classList.add('fa-bars');
        }
      });
      
      document.addEventListener('click', function(e) {
        if (window.innerWidth <= 992 && 
            !sidebar.contains(e.target) && 
            e.target !== mobileToggle && 
            sidebar.classList.contains('active')) {
          closeSidebar();
        }
      });
      
      // Handle window resize
      window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
          sidebar.classList.add('active');
          mainContent.classList.add('shifted');
        } else {
          if (sidebar.classList.contains('active')) {
            mainContent.classList.remove('shifted');
          }
        }
      });
      
      function closeSidebar() {
        sidebar.classList.remove('active');
        body.classList.remove('sidebar-open');
        const icon = mobileToggle.querySelector('i');
        icon.classList.remove('fa-times');
        icon.classList.add('fa-bars');
      }
      
      // Initialize
      initSidebar();
    });
  </script>

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
        maintainAspectRatio: false,
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
  </script>

  <!-- Time and Date -->
  <script>
    function updateDateTime() {
      const now = new Date();

      const date = now.toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });

      const time = now.toLocaleTimeString('en-US', {
        hour: 'numeric',
        minute: '2-digit',
        second: '2-digit'
      });

      document.getElementById('datetime').textContent = `${date} • ${time}`;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
  </script>
</body>

</html>