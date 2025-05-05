<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : Pamantasan ng Lungsod ng Pasig</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v22.0"></script>
</head>


<body>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>
    <main id='home-main'>
        <section class="latest-news" id='latest-news-container'>
            <div class="container" id='highlight-articles'>
                <div class="text-container">
                    <div>
                        <p class="time-posted">Posted <small>●</small> <span id='latest-news-day-posted'></span></p>
                        <h1 id='latest-news-title'></h1>
                    </div>
                    <!-- TODO : MAKE THIS DYNAMIC -->
                    <!-- <a href="lundayan-site-article.php" id='latest-read-more'>Read More</a> -->
                </div>
            </div>
        </section>

        <!-- <div class="news-banner">
            <div class="scrolling-text">
                <span> | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | </span>
            </div>
        </div> -->
        <section class="news-cards">
            <div class="remaining-latest">
                <div class="remaining-texts">
                    <p>Browse and read the latest stuff</p>
                    <h2>Latest News</h2>
                </div>
                <div class="card-news-container" id='card-news-container'>
                    <!-- To be filled up -->
                </div>
            </div>
            <div class="extras-container">
                <div class="home-upcoming-events">

                </div>
                <div class="fb-page" data-href="https://www.facebook.com/LundayanPLP" data-tabs="timeline" data-width="800" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-lazy='true'>
                    <blockquote cite="https://www.facebook.com/LundayanPLP" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/LundayanPLP">Lundayan Student Publication - PLPasig</a></blockquote>
                </div>
            </div>
        </section>
    </main>

    <?php include 'lundayan-site-footer.php' ?>
    <!-- Date formatter function -->
    <script src="scripts/date-formatter.js"></script>
    <!-- Gets the Latest News -->
    <script src="scripts/home-latest-news.js"></script>
</body>

</html>