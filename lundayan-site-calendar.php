<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : Calendar</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <?php include 'lundayan-site-upper-nav.php' ?>
    <?php include 'lundayan-site-nav.php'; ?>
    <main>
        <section class="calendar">
            <div class="calendar-vertical-layout">
                <!-- LEFT COLUMN -->
                <div class="calendar-left">

                    <!-- Time and Day -->
                    <div class="time-day">
                        <img id="time-image" src="" alt="Time of day image">
                        <div class="time-day-text-container">
                            <h3></h3>
                            <p></p>
                        </div>
                    </div>

                    <!-- Upcoming Events -->
                    <div class="upcoming-events">
                        <div class="title-container">
                            <h2>Upcoming Events</h2>
                        </div>
                        <div class="events" id="upcoming-events-container">
                        </div>
                    </div>


                </div>

                <!-- RIGHT COLUMN -->
                <div class="calendar-right">
                    <div class="calendar-controls">
                        <div class="adjust-calendar-container">
                            <div class="month-container" title="Month">
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
                            <div class="year-container" title="Year">
                                <div class="select">
                                    <select id="year-select">
                                    </select>
                                </div>
                            </div>
                            <div class="calendar-btns">
                                <button>
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 12H18M6 12L11 7M6 12L11 17" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <button>
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="#161616" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="calendar-body">
                        <div class="calendar-numbers">
                            <table bgcolor="lightgrey" align="center" cellspacing="5" cellpadding="">
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
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
    <div id="event-box" style="display:none;"></div>
    <div id="event-backdrop"></div>
    <div id="event-box"></div>


    <?php include 'lundayan-site-footer.php' ?>

    <!-- populate announcements -->
    <script src="scripts/get-announcements.js"></script>
    <!-- handles caldnedar -->
    <script src='scripts/calendar-handler.js'></script>
    <!-- Time and day icon handler   -->
    <script src='scripts/time-icon-handler.js'></script>
</body>

</html>