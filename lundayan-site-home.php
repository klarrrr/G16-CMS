<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : Pamantasan ng Lungsod ng Pasig</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'lundayan-site-nav.php'; ?>
    <main>
        <section class="hero">
            <div class="school">
                <img src="pics/PLP_Logo.png" alt="" class="plp-name-logo">
            </div>
            <h1>Welcome to Lundayan</h1>
            <p>Student Publication of Pamantasan ng Lungsod ng Pasig</p>
        </section>

        <section class="latest-news">
            <div class="news-banner">
                <div class="scrolling-text">
                    <span> | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | </span>
                </div>
            </div>
            <div class="container">
                <div class="text-container">
                    <!-- TODO : MAKE THIS DYNAMIC -->
                    <h1 id='latest-news-title'>CHED's Certificates of Program Compliance (COPCs)</h1>
                    <!-- TODO : MAKE THIS DYNAMIC -->
                    <p class="time-posted">Posted <small>●</small> <span id='latest-news-day-posted'>April 25, 2025</span></p>
                    <!-- TODO : MAKE THIS DYNAMIC -->
                    <p class="latest-paragraph" id='latest-news-paragraph'>
                        Programs that comprise the College of Business and Accountancy (CBA), College of Computer
                        Studies
                        (CCS), College of International Hospitality Management (CIHM), College of Engineering (COE), and
                        College of Education (COED) secured their compliance certificates, acquiring the go-signal to
                        sustain the delivery of assured quality education to PLPians.
                    </p>
                    <!-- TODO : MAKE THIS DYNAMIC -->
                    <a href="lundayan-site-article.php" id='latest-read-more'>Read More</a>
                </div>
                <!-- TODO : MAKE THIS DYNAMIC -->
                <img src="pics/image.png" alt="Picture of the latest news fresh from the oven" id='latest-news-pic'>
            </div>

            <div class="news-banner">
                <div class="scrolling-text">
                    <span> | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | LATEST NEWS | </span>
                </div>
            </div>
        </section>

        <section class="news-cards">

        </section>

        <section class="news-cards">
            <div class="card-news-container" id='card-news-container'>

            </div>
        </section>
    </main>

    <?php include 'lundayan-site-footer.php' ?>
    <!-- Gets the Latest News -->
    <script src="scripts/home-latest-news.js"></script>
</body>

</html>