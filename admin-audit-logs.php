<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --success-color: #2ecc71;
            --danger-color: #e74c3c;
            --warning-color: #f39c12;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --text-color: #333;
            --border-color: #ddd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f5f7fa;
            color: var(--text-color);
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: var(--secondary-color);
            color: white;
            padding: 20px 0;
            transition: all 0.3s;
        }

        .sidebar-header {
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu {
            padding: 20px;
        }

        .sidebar-menu ul {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 10px;
        }

        .sidebar-menu a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar-menu i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 20px;
            margin-bottom: 30px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .card-title {
            font-size: 18px;
            font-weight: 600;
        }

        .filters {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .filter-group {
            flex: 1;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        select,
        input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            background-color: white;
        }

        .btn {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #2980b9;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            background-color: #f8f9fa;
            font-weight: 600;
            position: sticky;
            top: 0;
        }

        tr:hover {
            background-color: #f8f9fa;
        }

        .badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }

        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 5px;
        }

        .pagination a {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            text-decoration: none;
            color: var(--text-color);
        }

        .pagination a.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .no-records {
            text-align: center;
            padding: 30px;
            color: #6c757d;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                height: auto;
            }

            .filters {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <nav class="sidebar-menu">
                <ul>
                    <li><a href="dashboard.html"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="users.html"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="articles.html"><i class="fas fa-newspaper"></i> Articles</a></li>
                    <li><a href="audit-logs.html" class="active"><i class="fas fa-clipboard-list"></i> Audit Logs</a></li>
                    <li><a href="settings.html"><i class="fas fa-cog"></i> Settings</a></li>
                </ul>
            </nav>
        </div>

        <!-- Main Content -->
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
                            <!-- Will be populated by JavaScript -->
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
                        <label for="dateFrom">From</label>
                        <input type="date" id="dateFrom">
                    </div>
                    <div class="filter-group">
                        <label for="dateTo">To</label>
                        <input type="date" id="dateTo">
                    </div>
                    <div class="filter-group" style="align-self: flex-end;">
                        <button class="btn btn-primary" id="applyFilters">
                            <i class="fas fa-filter"></i> Apply
                        </button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table id="auditLogsTable">
                        <thead>
                            <tr>
                                <th>Log ID</th>
                                <th>User</th>
                                <th>Article</th>
                                <th>Action</th>
                                <th>Timestamp</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Will be populated by JavaScript -->
                            <tr>
                                <td colspan="6" class="no-records">Loading audit logs...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="pagination" id="pagination">
                    <!-- Will be populated by JavaScript -->
                </div>
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
                    const tbody = $('#auditLogsTable tbody');
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