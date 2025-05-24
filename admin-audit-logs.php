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

    select, input[type="date"] {
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

    th, td {
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
            <div>
                <button class="btn btn-primary" id="exportBtn">
                    <i class="fas fa-download"></i> Export
                </button>
            </div>
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
        $(document).ready(function () {
            let auditLogs = [];
            let currentPage = 1;
            const rowsPerPage = 10;

            // Fetch audit logs data from server via AJAX
            function fetchAuditLogs() {
                // You can replace this with an actual AJAX call to your server API
                $.ajax({
                    url: 'fetch-audit-logs.php', // Replace with your API endpoint
                    method: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        auditLogs = data;
                        populateUserFilter();
                        renderTable();
                        renderPagination();
                    },
                    error: function () {
                        alert('Failed to load audit logs.');
                    }
                });
            }

            // Populate User filter dropdown
            function populateUserFilter() {
                const userSet = new Set(auditLogs.map(log => log.user));
                const userFilter = $('#userFilter');
                userFilter.empty().append('<option value="">All Users</option>');
                Array.from(userSet).sort().forEach(user => {
                    userFilter.append(`<option value="${user}">${user}</option>`);
                });
            }

            // Render the audit logs table
            function renderTable() {
                const tbody = $('#auditTable tbody');
                tbody.empty();

                let filteredLogs = auditLogs.filter(log => {
                    const userVal = $('#userFilter').val();
                    const actionVal = $('#actionFilter').val();
                    const dateFromVal = $('#dateFrom').val();
                    const dateToVal = $('#dateTo').val();

                    let match = true;

                    if (userVal && log.user !== userVal) match = false;
                    if (actionVal && log.action !== actionVal) match = false;

                    if (dateFromVal) {
                        const dateFrom = new Date(dateFromVal);
                        const logDate = new Date(log.datetime);
                        if (logDate < dateFrom) match = false;
                    }

                    if (dateToVal) {
                        const dateTo = new Date(dateToVal);
                        const logDate = new Date(log.datetime);
                        if (logDate > dateTo) match = false;
                    }

                    return match;
                });

                const totalRecords = filteredLogs.length;
                if (totalRecords === 0) {
                    $('#auditTable').hide();
                    $('#noRecords').show();
                    $('#pagination').hide();
                    return;
                } else {
                    $('#auditTable').show();
                    $('#noRecords').hide();
                    $('#pagination').show();
                }

                // Pagination
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                const paginatedLogs = filteredLogs.slice(start, end);

                paginatedLogs.forEach(log => {
                    const dateTime = new Date(log.datetime).toLocaleString();
                    let actionBadgeClass = 'badge-info';
                    switch (log.action) {
                        case 'create': actionBadgeClass = 'badge-success'; break;
                        case 'update': actionBadgeClass = 'badge-warning'; break;
                        case 'delete': actionBadgeClass = 'badge-danger'; break;
                        case 'login':
                        case 'logout': actionBadgeClass = 'badge-info'; break;
                    }

                    tbody.append(`
                        <tr>
                            <td>${log.user}</td>
                            <td><span class="badge ${actionBadgeClass}">${log.action}</span></td>
                            <td>${log.description}</td>
                            <td>${dateTime}</td>
                        </tr>
                    `);
                });

                renderPagination(filteredLogs.length);
            }

            // Render pagination links
            function renderPagination(totalFilteredRecords = auditLogs.length) {
                const totalPages = Math.ceil(totalFilteredRecords / rowsPerPage);
                const pagination = $('#pagination');
                pagination.empty();

                if (totalPages <= 1) {
                    pagination.hide();
                    return;
                }
                pagination.show();

                for (let i = 1; i <= totalPages; i++) {
                    const activeClass = i === currentPage ? 'active' : '';
                    pagination.append(`<a href="#" class="${activeClass}" data-page="${i}">${i}</a>`);
                }
            }

            // Event handlers
            $('#filterBtn').on('click', function () {
                currentPage = 1;
                renderTable();
            });

            $('#pagination').on('click', 'a', function (e) {
                e.preventDefault();
                const page = Number($(this).data('page'));
                if (page !== currentPage) {
                    currentPage = page;
                    renderTable();
                }
            });

            $('#exportBtn').on('click', function () {
                exportToCSV();
            });

            function exportToCSV() {
                let csvContent = "data:text/csv;charset=utf-8,";
                csvContent += "User,Action,Description,Date & Time\n";

                // Export filtered data
                let filteredLogs = auditLogs.filter(log => {
                    const userVal = $('#userFilter').val();
                    const actionVal = $('#actionFilter').val();
                    const dateFromVal = $('#dateFrom').val();
                    const dateToVal = $('#dateTo').val();

                    let match = true;

                    if (userVal && log.user !== userVal) match = false;
                    if (actionVal && log.action !== actionVal) match = false;

                    if (dateFromVal) {
                        const dateFrom = new Date(dateFromVal);
                        const logDate = new Date(log.datetime);
                        if (logDate < dateFrom) match = false;
                    }

                    if (dateToVal) {
                        const dateTo = new Date(dateToVal);
                        const logDate = new Date(log.datetime);
                        if (logDate > dateTo) match = false;
                    }

                    return match;
                });

                filteredLogs.forEach(log => {
                    const row = [
                        log.user,
                        log.action,
                        `"${log.description.replace(/"/g, '""')}"`,
                        new Date(log.datetime).toLocaleString()
                    ].join(',');
                    csvContent += row + "\n";
                });

                const encodedUri = encodeURI(csvContent);
                const link = document.createElement('a');
                link.setAttribute('href', encodedUri);
                link.setAttribute('download', 'audit_logs.csv');
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }

            fetchAuditLogs();
        });
    </script>
</body>

</html>
