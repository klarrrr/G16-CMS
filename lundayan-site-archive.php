<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : Archive</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>
    <main>
        <section class="sub-header">
            <h3>Search for articles</h3>
            <div class="search">
                <input type="text" name='search-bar' id='search-bar' placeholder="Search for an existing article">
            </div>
            <div class="filters">
                <div class="filter-group">
                    <h3>Sort by category</h3>
                    <div class="filter-tags" id='filter-tags'>

                    </div>
                </div>
            </div>
        </section>
        <!-- Lagyan ng sort ascending - descending -->
        <section class="bulletin-news-cards">
            <div class="bulletin-card-news-container" id='bulletin-card-news-container'>
            </div>
            <div class="pagination" id='pagination'>

            </div>
        </section>
    </main>

    <?php include 'lundayan-site-footer.php' ?>
    <script>
        const bulletinCardNewsContainer = document.getElementById('bulletin-card-news-container');
        const paginationContainer = document.getElementById('pagination');

        let currentPage = 1;
        const itemsPerPage = 10;
    </script>

    <!-- Date formatter Function -->
    <script src="scripts/date-formatter.js"></script>
    <!-- Get Tags First -->
    <script src="scripts/bulletin-gets-tags.js"></script>
    <!-- Script for Search via search bar and tags -->
    <script src="scripts/bulletin-search-by-news-and-tags.js"></script>
    <!-- Tag Filter Algorithm -->
    <script src="scripts/tag-click-handler.js"></script>
</body>

</html>