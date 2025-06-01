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
  <link rel="stylesheet" href="styles-admin.css">
  <link rel="icon" href="pics/lundayan-logo.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <style>
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

    .main-content {
      flex: 1;
    }

    .recent-activities-container {
      padding: 2rem;
      overflow-y: auto;
      height: calc(100vh - 120px);
    }


    .card {
      background: #fff;
      border-radius: 10px;
      padding: 2rem;
      /* box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1); */
      margin-bottom: 2rem;
      border: 1px solid lightgray;
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
      background: #161616;
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
      border-radius: 5px;
      text-decoration: none;
      color: #333;
    }

    .pagination a.active {
      background: #161616;
      color: #f4f4f4;
      border-color: #161616;
    }

    .no-records {
      text-align: center;
      padding: 2rem;
      color: #666;
    }

    /* Add this to your <style> section */
    td {
      max-width: 200px;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  </style>
</head>

<body>
  <?php include 'admin-side-bar.php' ?>

  <main class="main-content">
    <div class="page-header">
      <div style='display:flex; flex-direction:column;'>
        <h1 style='font-family: main;'>Audit Logs</h1>
        <p>Review changes and updates</p>
      </div>
      <!-- <div>
        <button class="btn btn-primary" id="exportBtn">
          <i class="fas fa-download"></i> Export
        </button>
      </div> -->
    </div>

    <div class="recent-activities-container">
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
          <!-- <div class="filter-group" style="align-self: flex-end;">
            <button class="btn btn-primary" id="filterBtn">Filter</button>
          </div> -->
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

  </main>

  <script>
    $(document).ready(function() {
      // Initialize date filters to last 30 days
      const today = new Date();
      const thirtyDaysAgo = new Date();
      thirtyDaysAgo.setDate(today.getDate() - 30);

      $('#dateFrom').val(thirtyDaysAgo.toISOString().split('T')[0]);
      $('#dateTo').val(today.toISOString().split('T')[0]);

      // Load initial data (users and actions)
      loadInitialData();

      // Filter button click handler
      $('#filterBtn').click(function() {
        loadAuditLogs(1);
      });

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