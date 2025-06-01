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
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contento : Audit Logs</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="styles-admin.css">
  <link rel="icon" href="pics/lundayan-logo.png">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>


    body {
      font-family: Arial, sans-serif;
      background: #f0f2f5;

    }

    .body {
      display: flex;
      height: 100vh;
      overflow: hidden;
    }

    .page-header {
      background: white;
      padding: 1.5rem 2rem;
      border-bottom: 1px solid #e0e0e0;
    }

    .page-header h1 {
      font-size: 1.8rem;
      color: #333;
    }

    .page-header p {
      color: #666;
      font-size: 0.9rem;
    }

    .main-content {
      padding: 2rem;
    }

    /* Audit Logs Specific Styles */
    .card {
      background: #fff;
      border-radius: 10px;
      padding: 1.5rem;
      margin-bottom: 2rem;
    }

    .filters {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
      flex-wrap: wrap;
    }

    .filter-group {
      flex: 1;
      min-width: 150px;
    }

    select,
    input[type="date"] {
      width: 100%;
      padding: 0.6rem;
      border: 1px solid #ddd;
      border-radius: 5px;
    }

    .btn {
      padding: 0.6rem 1rem;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .btn-primary {
      background: #0F5132;
      color: white;
    }

    table {
      width: 100%;
      border-collapse: collapse;
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
      background: #d1ecf1;
      color: #0c5460;
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
      border-radius: 5px;
      text-decoration: none;
      color: #333;
    }

    .pagination a.active {
      background: #0F5132;
      color: white;
      border-color: #0F5132;
    }

    .no-records {
      text-align: center;
      padding: 2rem;
      color: #666;
    }
        .nav-container {
            display: flex;
            align-items: center
        }

        nav {
            display: flex;
            width: 100%;
            padding: 0 10px;
            border-bottom: 1px solid #d3d3d3;
            height: 7vh;
            justify-content: space-between;
            align-items: center;
            background-color: #fff
        }

        nav ul {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%
        }

        nav h1 {
            font-family: boldonse;
            font-size: 1em;
            color: #161616
        }

        .left-editor-container {
            height: fit-content
        }

        .right-editor-container {
            width: 100%;
            background-color: #fff;
            height: 100vh;
            display: flex;
            flex-direction: column
        }



  </style>
</head>

<body class="body">
  <div class="left-editor-container">
    <?php include 'admin-side-bar.php'; ?>
  </div>
  
  <div class="right-editor-container">
    <div class="page-header">
      <h1>Audit Logs</h1>
      <p>Recent Activities</p>
    </div>
    
    <div class="main-content">
      <div class="card">
        <div class="filters">
          <div class="filter-group">
            <label for="userFilter">User</label>
            <select id="userFilter">
              <option value="">All Users</option>
            </select>
          </div>

          <div class="filter-group">
            <label for="userTypeFilter">User Type</label>
            <select id="userTypeFilter">
              <option value="">All Types</option>
              <option value="writer">Writer</option>
              <option value="reviewer">Reviewer</option>
              <option value="admin">Admin</option>
            </select>
          </div>

          <div class="filter-group">
            <label for="actionFilter">Action</label>
            <select id="actionFilter">
              <option value="">All Actions</option>
              <option value="create">Create</option>
              <option value="update">Update</option>
              <option value="delete">Delete</option>
              <option value="login">Login</option>
              <option value="logout">Logout</option>
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

          <div class="filter-group" style="align-self: flex-end;">
            <button class="btn btn-primary" id="filterBtn">Filter</button>
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
                <th>Action Performed</th>
                <th>Timestamp</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <div id="noRecords" class="no-records" style="display:none;">
            No audit log records found.
          </div>
        </div>

        <div class="pagination" id="pagination"></div>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      const today = new Date();
      const thirtyDaysAgo = new Date();
      thirtyDaysAgo.setDate(today.getDate() - 30);

      $('#dateFrom').val(thirtyDaysAgo.toISOString().split('T')[0]);
      $('#dateTo').val(today.toISOString().split('T')[0]);

      loadUsers();
      loadAuditLogs();

      $('#filterBtn').click(function () {
        loadAuditLogs();
      });
    });

    function loadUsers() {
      $.ajax({
        url: 'php-backend/admin-populate-users.php',
        type: 'GET',
        dataType: 'json',
        success: function (users) {
          const userFilter = $('#userFilter');
          userFilter.empty().append('<option value="">All Users</option>');
          users.forEach(user => {
            userFilter.append(`<option value="${user.user_id}">${user.user_first_name} ${user.user_last_name}</option>`);
          });
        },
        error: function (error) {
          console.error('Error loading users:', error);
        }
      });
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

      $.ajax({
        url: 'php-backend/fetch-audit-logs.php',
        type: 'GET',
        data: filters,
        dataType: 'json',
        success: function (response) {
          const tbody = $('#auditTable tbody');
          tbody.empty();

          if (response.data.length === 0) {
            $('#noRecords').show();
            return;
          }
          
          $('#noRecords').hide();

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
        },
        error: function (error) {
          console.error('Error loading audit logs:', error);
        }
      });
    }

    function getUserTypeBadge(userType) {
      const types = {
        'admin': { class: 'badge-danger', label: 'Admin' },
        'reviewer': { class: 'badge-info', label: 'Reviewer' },
        'writer': { class: 'badge-warning', label: 'Writer' }
      };
      const config = types[userType?.toLowerCase()] || { class: 'badge-secondary', label: userType || 'N/A' };
      return `<span class="badge ${config.class}">${config.label}</span>`;
    }

    function getActionBadge(action) {
      const actions = {
        'create': { class: 'badge-success', icon: 'plus' },
        'update': { class: 'badge-info', icon: 'edit' },
        'delete': { class: 'badge-danger', icon: 'trash' },
        'login': { class: 'badge-success', icon: 'sign-in-alt' },
        'logout': { class: 'badge-warning', icon: 'sign-out-alt' }
      };
      const config = actions[action.toLowerCase()] || { class: 'badge-info', icon: 'info-circle' };
      return `<span class="badge ${config.class}"><i class="fas fa-${config.icon}"></i> ${action}</span>`;
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

      if (currentPage > 1) {
        pagination.append(`<a href="#" onclick="loadAuditLogs(${currentPage - 1})"><i class="fas fa-chevron-left"></i></a>`);
      }

      for (let i = 1; i <= totalPages; i++) {
        if (i === currentPage) {
          pagination.append(`<a href="#" class="active">${i}</a>`);
        } else {
          pagination.append(`<a href="#" onclick="loadAuditLogs(${i})">${i}</a>`);
        }
      }

      if (currentPage < totalPages) {
        pagination.append(`<a href="#" onclick="loadAuditLogs(${currentPage + 1})"><i class="fas fa-chevron-right"></i></a>`);
      }
    }
  </script>
  <script src="scripts/menu_button-admin.js"></script>
</body>

</html>