<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$profile_pic = $_SESSION['profile_picture'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Audit Log Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body class="body">
    <div class="float-cards" style='display: none;'></div>
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <div class="right-editor-container">
        <div class="add-article-title-container">
            <div class="article-page-title">
                <h1>Audit Logs</h1>
                <p>Article Updates</p>
            </div>
            <div class="search-container">
                <label for="start-date" class="audit-date-lbl">Start Date</label>
                <input type="date" id="start-date" class="date-filter">
                <label for="end-date" class="audit-date-lbl">End Date</label>
                <input type="date" id="end-date" class="date-filter">

                <select id="sort-order" class="sort-dropdown">
                    <option value="desc" selected>Date & Time Descending</option>
                    <option value="asc">Date Updated & Time Ascending</option>
                </select>

                <input type="text" placeholder="Search for logs" id='search-for-logs' class='search-your-articles'>

                <div class="pfp-container">
                    <img src="<?php echo (!$profile_pic) ? 'pics/no-pic.jpg' : 'data:image/png;base64,' . $profile_pic; ?>" alt="" id='pfp-circle'>
                </div>
            </div>

        </div>

        <!-- Table -->

        <div class="table-container">
            <table class="audit-log-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Article</th>
                        <th>Action</th>
                        <th>Date & Time</th>
                        <th>Manage</th>
                    </tr>
                </thead>
                <tbody id="log-table-body">
                    <!-- Logs will be loaded here -->
                </tbody>
            </table>
            <div id="pagination-controls"></div>
        </div>

        <!-- Script for Menu Button on Top Left -->
        <script src="scripts/menu_button.js"></script>

        <script>
            let currentPage = 1;
            let limit = 10;

            function loadLogs(page = 1) {
                const search = $('#search-for-logs').val();
                const sort = $('#sort-order').val();
                const startDate = $('#start-date').val();
                const endDate = $('#end-date').val();

                $.ajax({
                    url: 'php-backend/fetch-audit-logs.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        page: page,
                        limit: limit,
                        search: search,
                        sort: sort,
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(res) {
                        const tbody = $('#log-table-body');
                        tbody.empty();

                        if (res.logs.length === 0) {
                            tbody.append('<tr><td colspan="5">No logs found.</td></tr>');
                        } else {
                            res.logs.forEach(log => {
                                tbody.append(`
                        <tr>
                            <td>${log.user_name}</td>
                            <td>${log.article_title}</td>
                            <td>${log.action}</td>
                            <td>${formatDateTime(log.log_time)}</td>
                            <td><button class='delete-log' data-id="${log.log_id}">Delete</button></td>
                        </tr>
                    `);
                            });
                        }

                        renderPagination(res.total, res.page);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading logs:', error);
                    }
                });
            }

            $('#search-for-logs, #sort-order, #start-date, #end-date').on('change keyup', function() {
                currentPage = 1;
                loadLogs(currentPage);
            });


            $('#search-your-active-articles').on('input', function() {
                const search = $(this).val();
                const sort = $('.sort-dropdown').val();
                currentPage = 1;
                loadLogs(currentPage, search, sort);
            });

            $('.sort-dropdown').on('change', function() {
                const search = $('#search-your-active-articles').val();
                const sort = $(this).val();
                currentPage = 1;
                loadLogs(currentPage, search, sort);
            });



            loadLogs();
        </script>
        <!-- Date formatterr -->
        <script src='scripts/date-formatter.js'></script>

        <!-- Render Pagination -->
        <script>
            function renderPagination(totalItems, currentPage, search = '', sort = 'desc') {
                const totalPages = Math.ceil(totalItems / limit);
                const paginationContainer = $('#pagination-controls');
                paginationContainer.empty();

                if (totalPages <= 1) return;

                if (currentPage > 1) {
                    paginationContainer.append(`<button class="page-btn" data-page="${currentPage - 1}">Previous</button>`);
                }

                const maxPagesToShow = 5;
                const startPage = Math.max(1, currentPage - 2);
                const endPage = Math.min(totalPages, startPage + maxPagesToShow - 1);

                for (let i = startPage; i <= endPage; i++) {
                    paginationContainer.append(`
            <button class="page-btn ${i === currentPage ? 'active' : ''}" data-page="${i}">${i}</button>
        `);
                }

                if (currentPage < totalPages) {
                    paginationContainer.append(`<button class="page-btn" data-page="${currentPage + 1}">Next</button>`);
                }

                $('.page-btn').off('click').on('click', function() {
                    const page = parseInt($(this).data('page'));
                    const searchValue = $('#search-your-active-articles').val();
                    const sortValue = $('.sort-dropdown').val();
                    currentPage = page;
                    loadLogs(currentPage, searchValue, sortValue);
                });
            }
        </script>


        <!-- Delete log -->
        <script>
            $(document).on('click', '.delete-log', function() {
                const logId = $(this).data('id');

                if (!confirm('Are you sure you want to delete this log entry?')) return;

                $.ajax({
                    url: 'php-backend/delete-audit-log.php',
                    type: 'POST',
                    data: {
                        log_id: logId
                    },
                    success: function(response) {
                        try {
                            const res = JSON.parse(response);
                            if (res.success) {
                                alert('Log deleted successfully.');
                                loadLogs(currentPage, $('#search-your-active-articles').val());
                            } else {
                                alert('Failed to delete log: ' + res.message);
                            }
                        } catch (e) {
                            console.error('Invalid response:', response);
                            alert('Unexpected error occurred.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX error:', error);
                        alert('Failed to delete log due to a server error.');
                    }
                });
            });
        </script>
</body>

</html>