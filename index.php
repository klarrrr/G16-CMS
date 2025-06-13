<?php session_start(); ?>

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
    <style>
        #highlight-articles {
            position: relative;
            transition: all 0.3s ease;
        }

        #highlight-articles:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .pagination .page-link {
            padding: 0.5rem 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #ddd;
            transition: all 0.2s;
        }

        .pagination .page-link:hover {
            background-color: #f5f5f5;
        }

        .pagination .page-link.active {
            background-color: #fcb404;
            color: #161616;
            border-color: #fcb404;
        }

        .no-news-message {
            text-align: center;
            padding: 2rem;
            color: #9a9a9a;
        }

        .no-news-message h3 {
            margin-top: 0.5rem;
            color: #b1b1b1;
        }

        .calendar-container {
            padding: 0.5rem;
            border-radius: 0.5rem;
            background: white;
        }
    </style>
</head>


<body>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>
    <main id='home-main'>
        <section class="latest-news" id='latest-news-container'>
            <div class="container" id='highlight-articles'>
                <div class="text-container">
                    <div>
                        <p class="time-posted"><span id='latest-news-day-posted'></span></p>
                        <h1 id='latest-news-title'></h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="news-cards">
            <div class="extras-container">
                <div class="remaining-texts">
                    <p>announcements</p>
                    <h2>Upcoming Events</h2>
                </div>
                <!-- Upcoming Events -->
                <iframe src="announcements-widget.php?limit=5&layout=column" width="100%" height="300px" frameborder="0" style="border:none; background-color: white; border-radius: 0.5rem"></iframe>

                <div class="remaining-texts">
                    <p>Lundayan on Facebook</p>
                    <h2>Facebook page</h2>
                </div>
                <div class="fb-page-container">
                    <div class="fb-page" data-href="https://www.facebook.com/LundayanPLP" data-tabs="timeline" data-width="500" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-lazy='true'>
                        <blockquote cite="https://www.facebook.com/LundayanPLP" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/LundayanPLP">Lundayan Student Publication - PLPasig</a></blockquote>
                    </div>
                </div>

                <div class="remaining-texts">
                    <p>See the Schedules</p>
                    <h2>The Calendar</h2>
                </div>

                <div class="calendar-container">
                    <iframe src="events-widget.php?view=calendar&limit=5&startdate=2025-06-10&width=100%&height=500px" width="100%" height="500px" frameborder="0" style="border:none;"></iframe>
                </div>
            </div>
            <div class="remaining-latest">
                <div class="remaining-texts">
                    <p>Browse and read the latest stuff</p>
                    <h2>Latest News</h2>
                </div>
                <div class="card-news-container" id='card-news-container'>
                    <!-- To be filled up -->

                </div>
                <!-- Add this pagination container -->
                <div class="pagination" id='pagination'></div>
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