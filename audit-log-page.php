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
            <h1 style='font-family: "main"; font-size: 3rem;'>Empty For Now</h1>
            <p style='font-family: "sub";'>Paul Group</p>
        </section>
        <!-- Script for Menu Button on Top Left -->
        <script src="scripts/menu_button.js"></script>
        <!-- Populate the Selection Input of all the pages -->
        <script src="scripts/nav_panel_switcher.js"></script>
</body>

</html>