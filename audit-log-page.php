<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: lundayan-sign-in-page.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contento : Audit Log Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="cms-preview-styles.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body class="body">
    <div class="float-cards" style='display: none;'></div>
    <!-- ACTUAL NAV OF CMS WEBSITE -->
    <div class="left-editor-container">
        <?php include 'editor-nav.php'; ?>
    </div>
    <div class="right-editor-container">
        <section class="audit-log-main-page" id='audit-log-main-page'>
            <div class="">
                <h1 style='font-family: "main"; font-size: 3rem;'>Audit Log</h1>
                <p style='font-family: "sub";'>Paul Group</p>
            </div>
            <input type="text" placeholder="Search for logs..." id='search-for-logs'>
        </section>
        <!-- Script for Menu Button on Top Left -->
        <script src="scripts/menu_button.js"></script>
        <!-- Populate the Selection Input of all the pages -->
        <script src="scripts/nav_panel_switcher.js"></script>

        <!-- Table -->

        <div class="table-container">
            <table summary="" class="audit-log-table">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Article</th>
                        <th>Date and Time</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Klarenz Cobie Manrique</td>
                        <td>CHED visits PLP!</td>
                        <td>09/16/2025 - 06:17PM</td>
                        <td><button class='delete-log'>Delete</button></td>
                    </tr>
                    <tr>
                        <td>Charl Joven Castro</td>
                        <td>Happy Birthday Charl Joven Castro!</td>
                        <td>05/09/2025 - 12:17AM</td>
                        <td><button class='delete-log'>Delete</button></td>
                    </tr>
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
</body>

</html>