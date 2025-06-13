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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Audit Logs - Lundayan Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="styles-admin.css">
  <link rel="icon" href="pics/lundayan-logo.png">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
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

    html,
    body {
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

    /* Main container layout */
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

    .main-content {
      flex: 1;
      padding: 2rem;
      width: 100%;
      overflow-y: auto;
    }

    .card {
      background: white;
      border-radius: 8px;
      padding: 1.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
      border: 1px solid #e0e0e0;
      width: 100%;
    }

    .card h2 {
      font-size: 1.4rem;
      margin-bottom: 1.5rem;
      padding-bottom: 0.75rem;
      border-bottom: 1px solid #eee;
      color: #222;
      font-weight: 600;
    }

    .card h3 {
      font-size: 1.2rem;
      margin: 1.5rem 0 1rem 0;
      color: #333;
      font-weight: 500;
    }

    .card label {
      display: block;
      margin-bottom: 0.5rem;
      font-size: 0.9rem;
      color: #555;
      font-weight: 500;
    }

    .card input,
    .card select,
    .card textarea {
      width: 100%;
      padding: 0.75rem;
      margin-bottom: 1.25rem;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 0.95rem;
      transition: all 0.2s ease;
    }

    .card input:focus,
    .card select:focus,
    .card textarea:focus {
      outline: none;
      border-color: #999;
      box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
    }

    .filters {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .filter-group {
      width: 100%;
    }

    .btn {
      padding: 0.75rem 1.5rem;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 0.95rem;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .btn-primary {
      background: #222;
      color: white;
    }

    .btn-primary:hover {
      background: #111;
      transform: translateY(-1px);
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 1.5rem;
    }

    th,
    td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #f8f9fa;
      font-weight: 600;
    }

    .badge {
      display: inline-block;
      padding: 4px 8px;
      border-radius: 4px;
      font-size: 12px;
      font-weight: 500;
    }

    .badge-success {
      background: #d4edda;
      color: #155724;
    }

    .badge-warning {
      background: #fff3cd;
      color: #856404;
    }

    .badge-danger {
      background: #f8d7da;
      color: #721c24;
    }

    .badge-info {
      background: #eee;
      color: #161616;
    }

    .pagination {
      display: flex;
      justify-content: center;
      gap: 0.5rem;
      margin-top: 1.5rem;
    }

    .pagination a {
      padding: 0.5rem 0.8rem;
      border: 1px solid #ddd;
      border-radius: 4px;
      text-decoration: none;
      color: #333;
    }

    .pagination a.active {
      background: #222;
      color: white;
      border-color: #222;
    }

    .no-records {
      text-align: center;
      padding: 2rem;
      color: #666;
    }

    .success,
    .error {
      border-radius: 4px;
      padding: 1rem;
      margin-bottom: 1.5rem;
      border-left: 4px solid;
      background: #f8f8f8;
    }

    .success {
      color: #155724;
      border-left-color: #28a745;
    }

    .error {
      color: #721c24;
      border-left-color: #dc3545;
    }

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

      .card,
      .main-content {
        padding: 1rem;
      }

      .filters {
        grid-template-columns: 1fr 1fr;
      }
    }

    @media (max-width: 768px) {
      .page-header {
        padding: 1rem 1.25rem;
      }

      .page-header h1 {
        font-size: 1.4rem;
      }

      .main-content {
        padding: 1rem;
      }

      .card {
        padding: 1rem;
      }

      .card h2 {
        font-size: 1.2rem;
      }

      .filters {
        grid-template-columns: 1fr;
      }

      table {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
      }

      .pagination {
        flex-wrap: wrap;
      }
    }

    @media (max-width: 480px) {
      .mobile-menu-toggle {
        font-size: 0.95rem;
        padding: 0.75rem 1rem;
      }

      .card h2,
      .card h3 {
        font-size: 1rem;
      }

      .card label {
        font-size: 0.85rem;
      }

      th,
      td {
        padding: 8px 10px;
        font-size: 0.85rem;
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
          <h1>Audit Logs</h1>
          <p>Review changes and updates</p>
        </div>
      </div>

      <div class="main-content">
        <?php if (isset($_SESSION['success'])): ?>
          <div class="success"><?= htmlspecialchars($_SESSION['success']);
                                unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="error"><?= htmlspecialchars($_SESSION['error']);
                              unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <div class="card">
          <div class="card-header">
            <h2 class="card-title">Recent Activities</h2>
          </div>

          <div class="filters">
            <div class="filter-group">
              <label for="userFilter">User</label>
              <select id="userFilter">
                <option value="">All Users</option>
                <!-- Populated dynamically -->
              </select>
            </div>

            <div class="filter-group">
              <label for="userTypeFilter">User Type</label>
              <select id="userTypeFilter">
                <option value="">All Types</option>
                <option value="writer">Writer</option>
                <option value="reviewer">Reviewer</option>
              </select>
            </div>

            <div class="filter-group">
              <label for="actionFilter">Action</label>
              <select id="actionFilter">
                <option value="">All Actions</option>
              </select>
            </div>
            <div class="filter-group">
              <label for="dateFrom">Date From</label>
              <input type="date" id="dateFrom" />
            </div>
            <div class="filter-group">
              <label for="dateTo">Date To</label>
              <input type="date" id="dateTo" />
            </div>
          </div>

          <div class="table-responsive">
            <table id="auditTable" aria-label="Audit logs table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>User</th>
                  <th>User Type</th>
                  <th>Article Title</th>
                  <th>Action</th>
                  <th>Timestamp</th>
                </tr>
              </thead>
              <tbody>
                <!-- Rows populated dynamically -->
                <tr>
                  <td colspan="6">Loading...</td>
                </tr>
              </tbody>
            </table>
            <div id="noRecords" class="no-records" style="display:none;">
              No audit log records found.
            </div>
          </div>

          <div class="pagination" id="pagination">
            <!-- Pagination links -->
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      // Initialize sidebar functionality
      const mobileToggle = document.getElementById('mobileMenuToggle');
      const sidebar = document.getElementById('sidebar');
      const mainContent = document.getElementById('mainContent');
      const body = document.body;

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

      // Close sidebar when clicking outside on mobile
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

      // Initialize date filters to last 30 days
      const today = new Date();
      const thirtyDaysAgo = new Date();
      thirtyDaysAgo.setDate(today.getDate() - 30);

      $('#dateFrom').val(thirtyDaysAgo.toISOString().split('T')[0]);
      $('#dateTo').val(today.toISOString().split('T')[0]);

      // Load initial data (users and actions)
      loadInitialData();

      // Auto-apply filters when dropdowns change
      $('#userFilter, #userTypeFilter, #actionFilter, #dateFrom, #dateTo').change(function() {
        loadAuditLogs(1);
      });
    });

    function loadInitialData() {
      // Load users and initial audit logs
      $.when(
        loadUsers(),
        loadAuditLogs()
      ).then(function(usersResponse, logsResponse) {
        // Populate action filter from the first response
        populateActionFilter(logsResponse[0].available_actions);
      });
    }

    function loadUsers() {
      return $.ajax({
        url: 'php-backend/admin-populate-users.php',
        type: 'GET',
        dataType: 'json'
      }).done(function(users) {
        const userFilter = $('#userFilter');
        userFilter.empty();
        userFilter.append('<option value="">All Users</option>');

        users.forEach(user => {
          userFilter.append(`<option value="${user.user_id}">${user.user_first_name} ${user.user_last_name}</option>`);
        });
      }).fail(function(error) {
        console.error('Error loading users:', error);
      });
    }

    function populateActionFilter(actions) {
      const actionFilter = $('#actionFilter');
      actionFilter.empty();
      actionFilter.append('<option value="">All Actions</option>');

      // Add only actions from database (no default actions)
      if (actions && actions.length > 0) {
        actions.forEach(action => {
          actionFilter.append(`<option value="${action}">${action.charAt(0).toUpperCase() + action.slice(1)}</option>`);
        });
      }
    }

    function loadAuditLogs(page = 1) {
      const filters = {
        user_id: $('#userFilter').val(),
        user_type: $('#userTypeFilter').val(),
        action: $('#actionFilter').val(),
        date_from: $('#dateFrom').val(),
        date_to: $('#dateTo').val(),
        page: page
      };

      // Show loading state
      $('#auditTable tbody').html('<tr><td colspan="6">Loading...</td></tr>');
      $('#noRecords').hide();

      return $.ajax({
        url: 'php-backend/fetch-audit-logs.php',
        type: 'GET',
        data: filters,
        dataType: 'json',
        success: function(response) {
          const tbody = $('#auditTable tbody');
          tbody.empty();

          if (!response.success || response.data.length === 0) {
            $('#noRecords').show();
            return response; // Return response for promise chain
          }

          response.data.forEach(log => {
            const actionBadge = getActionBadge(log.action);

            tbody.append(`
              <tr>
                <td>${log.log_id}</td>
                <td>${log.user_name || 'System'}</td>
                <td>${getUserTypeBadge(log.user_type)}</td>
                <td>${log.article_title || 'N/A'}</td>
                <td>${actionBadge}</td>
                <td>${formatDateTime(log.log_time)}</td>
              </tr>
            `);
          });

          renderPagination(response.total, response.per_page, page);
          return response; // Return response for promise chain
        },
        error: function(xhr, status, error) {
          console.error('Error loading audit logs:', error);
          $('#auditTable tbody').html('<tr><td colspan="6">Error loading audit logs</td></tr>');
        }
      });
    }

    function getUserTypeBadge(userType) {
      const types = {
        'admin': 'badge-admin',
        'writer': 'badge-writer',
        'reviewer': 'badge-reviewer'
      };

      const badgeClass = types[userType?.toLowerCase()] || 'badge-secondary';
      const displayType = userType ? userType.charAt(0).toUpperCase() + userType.slice(1) : 'N/A';

      return `<span class="badge ${badgeClass}">${displayType}</span>`;
    }

    function getActionBadge(action) {
      const actions = {
        'create': {
          class: 'badge-success',
          icon: 'plus'
        },
        'update': {
          class: 'badge-info',
          icon: 'edit'
        },
        'delete': {
          class: 'badge-danger',
          icon: 'trash'
        },
        'login': {
          class: 'badge-success',
          icon: 'sign-in-alt'
        },
        'logout': {
          class: 'badge-warning',
          icon: 'sign-out-alt'
        }
      };

      const config = actions[action.toLowerCase()] || {
        class: 'badge-info',
        icon: 'info-circle'
      };

      return `
        <span class="badge ${config.class}">
          <i class="fas fa-${config.icon}"></i> ${action}
        </span>
      `;
    }

    function formatDateTime(datetime) {
      if (!datetime) return 'N/A';

      const date = new Date(datetime);
      return date.toLocaleString();
    }

    function renderPagination(total, perPage, currentPage) {
      const totalPages = Math.ceil(total / perPage);
      const pagination = $('#pagination');
      pagination.empty();

      if (totalPages <= 1) return;

      // Previous button
      if (currentPage > 1) {
        pagination.append(`<a href="#" onclick="loadAuditLogs(${currentPage - 1})"><i class="fas fa-chevron-left"></i></a>`);
      }

      // Show limited page numbers (max 5 around current page)
      const startPage = Math.max(1, currentPage - 2);
      const endPage = Math.min(totalPages, currentPage + 2);

      for (let i = startPage; i <= endPage; i++) {
        if (i === currentPage) {
          pagination.append(`<a href="#" class="active">${i}</a>`);
        } else {
          pagination.append(`<a href="#" onclick="loadAuditLogs(${i})">${i}</a>`);
        }
      }

      // Next button
      if (currentPage < totalPages) {
        pagination.append(`<a href="#" onclick="loadAuditLogs(${currentPage + 1})"><i class="fas fa-chevron-right"></i></a>`);
      }
    }
  </script>
</body>

</html>