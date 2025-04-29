<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : Bulletin</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'lundayan-site-nav.php'; ?>
    <main>
        <section class="hero">
            <h1>BULLETIN</h1>
            <p>Posted news and events</p>
        </section>
        <div class="news-banner">
            <div class="scrolling-text">
                <span> | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | </span>
            </div>
        </div>

        <section class="sub-header">
            <h3>Search for article</h3>
            <div class="search">
                <input type="text" name='search-bar' id='search-bar' placeholder="Search for an existing article">
            </div>
            <div class="filters">
                <div class="filter-group">
                    <h3>Sort by category</h3>
                    <div class="filter-tags">
                        <button class="tag">PLP</button>
                        <button class="tag">Faculty</button>
                        <button class="tag">BSN</button>
                        <button class="tag selected">BSIT</button>
                        <button class="tag">BSA</button>
                        <button class="tag">BSCS</button>
                        <button class="tag">Library</button>
                        <button class="tag">Staff</button>
                        <button class="tag">Motivation</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="news-cards">

            <div class="bulletin-card-news-container" id='bulletin-card-news-container'>

            </div>
        </section>
    </main>

    <?php include 'lundayan-site-footer.php' ?>
    <!-- Date formatter Function -->
    <script src="scripts/date-formatter.js"></script>
    <!-- SCript to get all the news -->
    <script src="scripts/get-news-bulletin.js"></script>

</body>

</html>