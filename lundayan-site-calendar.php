<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : Calendar</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
</head>

<body>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>
    <main>
        <!-- <div class="news-banner">
            <div class="scrolling-text">
                <span> | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | CALENDAR | </span>
            </div>
        </div> -->
        <section class="calendar">
            <br>
            <div class="calendar-vertical-layout">
                <!-- LEFT COLUMN -->
                <div class="calendar-left">
                    <div class="time-day">
                        <img id="time-image" src="" alt="Time of day image">
                        <div class="time-day-text-container">
                            <h3>05:35 AM</h3>
                            <p>Sunday, April 2025</p>
                        </div>
                    </div>

                    <div class="upcoming-events">
                        <div class="title-container">
                            <h2>Upcoming Events</h2>
                        </div>
                        <div class="events">
                            <div class="event">
                                <img src="pics/sample1.jpg" alt="">
                                <div class="event-text-container">
                                    <h3>Celebration of the Literary Month</h3>
                                    <p>Posted on April 11, 2025</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN -->
                <div class="calendar-right">
                    <div class="calendar-controls">
                        <div class="adjust-calendar-container">
                            <div class="month-container">
                                <div class="select">
                                    <select id="month-select">
                                        <option value="0">January</option>
                                        <option value="1">February</option>
                                        <option value="2">March</option>
                                        <option value="3">April</option>
                                        <option value="4">May</option>
                                        <option value="5">June</option>
                                        <option value="6">July</option>
                                        <option value="7">August</option>
                                        <option value="8">September</option>
                                        <option value="9">October</option>
                                        <option value="10">November</option>
                                        <option value="11">December</option>
                                    </select>
                                </div>
                            </div>
                            <div class="year-container">
                                <div class="select">
                                    <select id="year-select">
                                        <!-- TODO : Dynamic, start from the oldest article's year up to present -->
                                        <option value="2025">2025</option>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                    </select>
                                </div>
                            </div>
                            <div class="calendar-btns">
                                <button><img src="svg/left-arrow.svg" alt=""></button>
                                <button><img src="svg/right-arrow.svg" alt=""></button>
                            </div>
                        </div>
                    </div>

                    <div class="calendar-body">
                        <div class="calendar-numbers">
                            <table bgcolor="lightgrey" align="center" cellspacing="21" cellpadding="21">
                                <thead>
                                    <tr>
                                        <th>Sun</th>
                                        <th>Mon</th>
                                        <th>Tue</th>
                                        <th>Wed</th>
                                        <th>Thu</th>
                                        <th>Fri</th>
                                        <th>Sat</th>
                                    </tr>
                                </thead>
                                <tbody id="calendar-body">
                                    <!-- JavaScript will populate this -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <div id="event-box" style="display:none; position:absolute; z-index:1000;"></div>

    <?php include 'lundayan-site-footer.php' ?>
    <script src='scripts/calendar-handler.js'></script>
    <script src='scripts/time-icon-handler.js'></script>
</body>

</html>