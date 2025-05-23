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
  <title>Audit Logs</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

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
    }

    .sidebar {
      width: 250px;
      background-color: #0F5132;
      color: #ecf0f1;
      padding: 20px;
      height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
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

    main.audit-logs {
      margin-left: 250px;
      padding: 2rem;
      width: calc(100% - 250px);
    }

    .main-content {
      margin-left: 250px;
      padding: 2rem;
      width: calc(100% - 250px);
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
    }

    .card {
      background: #fff;
      border-radius: 10px;
      padding: 1.5rem;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      margin-bottom: 2rem;
    }

    .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid #eee;
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
  </style>
</head>

<body>
  <div class="sidebar">
    <div class="sidebar-header">
      <h2>Admin Panel</h2>
    </div>
    <?php include 'admin-side-bar.php' ?>
  </div>

  <div class="main-content">
    <div class="header">
      <h1 class="page-title">Audit Logs</h1>
      <!-- <div>
        <button class="btn btn-primary" id="exportBtn">
          <i class="fas fa-download"></i> Export
        </button>
      </div> -->
    </div>

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
              <th>User</th>
              <th>Action</th>
              <th>Description</th>
              <th>Date & Time</th>
            </tr>
          </thead>
          <tbody>
            <!-- Rows populated dynamically -->
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

  <script>
    $(document).ready(function() {
      // Initialize date filters to last 30 days
      const today = new Date();
      const thirtyDaysAgo = new Date();
      thirtyDaysAgo.setDate(today.getDate() - 30);

      $('#dateFrom').val(thirtyDaysAgo.toISOString().split('T')[0]);
      $('#dateTo').val(today.toISOString().split('T')[0]);

      // Load users for filter dropdown
      loadUsers();

      // Load audit logs
      loadAuditLogs();

      // Apply filters button
      $('#applyFilters').click(function() {
        loadAuditLogs();
      });

      // Export button
      $('#exportBtn').click(function() {
        exportAuditLogs();
      });
    });

    function loadUsers() {
      $.ajax({
        url: 'php-backend/admin-populate-users.php',
        type: 'GET',
        dataType: 'json',
        success: function(users) {
          const userFilter = $('#userFilter');
          userFilter.empty();
          userFilter.append('<option value="">All Users</option>');

          users.forEach(user => {
            userFilter.append(`<option value="${user.user_id}">${user.user_first_name} ${user.user_last_name}</option>`);
          });
        },
        error: function(error) {
          console.error('Error loading users:', error);
        }
      });
    }

    function loadAuditLogs(page = 1) {
      const filters = {
        user_id: $('#userFilter').val(),
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
        success: function(response) {
          const tbody = $('#auditTable tbody');
          tbody.empty();

          if (response.data.length === 0) {
            tbody.append('<tr><td colspan="6" class="no-records">No audit logs found</td></tr>');
            return;
          }

          response.data.forEach(log => {
            const actionBadge = getActionBadge(log.action);

            tbody.append(`
                            <tr>
                                <td>${log.log_id}</td>
                                <td>${log.user_name || 'System'}</td>
                                <td>${log.article_title || 'N/A'}</td>
                                <td>${actionBadge}</td>
                                <td>${formatDateTime(log.log_time)}</td>
                                <td><button class="btn btn-sm" onclick="showLogDetails(${log.log_id})"><i class="fas fa-eye"></i></button></td>
                            </tr>
                        `);
          });

          renderPagination(response.total, response.per_page, page);
        },
        error: function(error) {
          console.error('Error loading audit logs:', error);
          $('#auditLogsTable tbody').html('<tr><td colspan="6" class="no-records">Error loading audit logs</td></tr>');
        }
      });
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

      // Page numbers
      for (let i = 1; i <= totalPages; i++) {
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

    function showLogDetails(logId) {
      // In a real implementation, this would show a modal with detailed log information
      alert(`Showing details for log ID: ${logId}`);
    }

    function exportAuditLogs() {
      const filters = {
        user_id: $('#userFilter').val(),
        action: $('#actionFilter').val(),
        date_from: $('#dateFrom').val(),
        date_to: $('#dateTo').val()
      };

      // Convert filters to query string
      const queryString = Object.keys(filters)
        .map(key => `${encodeURIComponent(key)}=${encodeURIComponent(filters[key])}`)
        .join('&');

      // Trigger download
      window.location.href = `php-backend/export-audit-logs.php?${queryString}`;
    }
  </script>

</body>

</html>