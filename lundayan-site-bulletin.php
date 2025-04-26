<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lundayan : Bulletin</title>
    <link rel="stylesheet" href="styles-lundayan-site.css">
    <link rel="icon" href="pics/lundayan-logo.png">
</head>

<body>
    <?php include 'lundayan-site-nav.php'; ?>
    <main>
        <section class="hero">
            <div class="school">
                <img src="pics/PLP_Logo.png" alt="" class="plp-name-logo">
            </div>
            <h1>Bulletin</h1>
        </section>
        <div class="news-banner">
            <div class="scrolling-text">
                <span> | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | BULLETIN | </span>
            </div>
        </div>

        <section class="sub-header">
            <h1>Filtering Controls</h1>
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
        <div class="calendar"></div>
        <section class="news-cards">

            <div class="bulletin-card-news-container">
                <div class="bulletin-news-card">
                    <img src="pics/sample1.jpg" alt="">
                    <div class="card-text-container">
                        <h2>Celebration of the Literary Month</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>Spearheaded by The English Society (TES), the seminar titled "Mastering the Art of Writing:
                            Techniques and Strategies for Effective Writing" aims...</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="bulletin-news-card">
                    <img src="pics/plp-outside.jpg" alt="">
                    <div class="card-text-container">
                        <h2>𝟱𝟭% 𝗼𝗳 𝗙𝗶𝗹𝗶𝗽𝗶𝗻𝗼 𝗔𝗱𝘂𝗹𝘁𝘀 𝗦𝘁𝗿𝘂𝗴𝗴𝗹𝗲 𝘁𝗼 𝗜𝗱𝗲𝗻𝘁𝗶𝗳𝘆 𝗙𝗮𝗸𝗲
                            𝗡𝗲𝘄𝘀</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>this is one of the issues tackled in the seminar titled “Democracy in Action: A Code to
                            Abide, Vote with Pride." It was held today at the PLP...</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="bulletin-news-card">
                    <img src="pics/sample3.jpg" alt="">
                    <div class="card-text-container">
                        <h2>"Help Me Help You: Mastering Peer Facilitation"</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>The event, held at the PLP Function Hall, gathered members from various colleges. Resource
                            speaker, Mr. Mark M. Francisco emphasized the...</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="bulletin-news-card">
                    <img src="pics/sample4.jpg" alt="">
                    <div class="card-text-container">
                        <h2>Buwan ng Panitikan 2025</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>Sa temang “Sikad Panitikan: Kultura at Panitikan ng Kaunlaran,” binigyang-diin ng palihan ang
                            mahalagang papel ng panitikan at kultura sa pagbubuo...</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="bulletin-news-card">
                    <img src="pics/sample5.jpg" alt="">
                    <div class="card-text-container">
                        <h2>Evaluation and Regional Quality Assessment Team (RQAT) On-Site Inspection</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>Led by CHED officials, Mr. Sharn Rosmer Baluyot, CHED NCR Education Supervisor II, Dr. John
                            Mark S. Distor, and Dr. Sheila Marie G. Hocson, CHED...</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
                <div class="bulletin-news-card">
                    <img src="pics/sample6.jpg" alt="">
                    <div class="card-text-container">
                        <h2>PLPians perform bayanihan in a clean-up drive today</h2>
                        <p class="time-posted">Posted <small>●</small> April 25, 2025</p>
                        <p>"Minsan lang po tayo mabisita, so it's nice to have the opportunity to contribute something
                            for PLP sa maliit na paraan," one student said.</p>
                        <a href="#">Read More</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'lundayan-site-footer.php' ?>
    <script>
        //check the console for date click event
        //Fixed day highlight
        //Added previous month and next month view

        function CalendarControl() {
            const calendar = new Date();
            const calendarControl = {
                localDate: new Date(),
                prevMonthLastDate: null,
                calWeekDays: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
                calMonthName: [
                    "Jan",
                    "Feb",
                    "Mar",
                    "Apr",
                    "May",
                    "Jun",
                    "Jul",
                    "Aug",
                    "Sep",
                    "Oct",
                    "Nov",
                    "Dec"
                ],
                daysInMonth: function(month, year) {
                    return new Date(year, month, 0).getDate();
                },
                firstDay: function() {
                    return new Date(calendar.getFullYear(), calendar.getMonth(), 1);
                },
                lastDay: function() {
                    return new Date(calendar.getFullYear(), calendar.getMonth() + 1, 0);
                },
                firstDayNumber: function() {
                    return calendarControl.firstDay().getDay() + 1;
                },
                lastDayNumber: function() {
                    return calendarControl.lastDay().getDay() + 1;
                },
                getPreviousMonthLastDate: function() {
                    let lastDate = new Date(
                        calendar.getFullYear(),
                        calendar.getMonth(),
                        0
                    ).getDate();
                    return lastDate;
                },
                navigateToPreviousMonth: function() {
                    calendar.setMonth(calendar.getMonth() - 1);
                    calendarControl.attachEventsOnNextPrev();
                },
                navigateToNextMonth: function() {
                    calendar.setMonth(calendar.getMonth() + 1);
                    calendarControl.attachEventsOnNextPrev();
                },
                navigateToCurrentMonth: function() {
                    let currentMonth = calendarControl.localDate.getMonth();
                    let currentYear = calendarControl.localDate.getFullYear();
                    calendar.setMonth(currentMonth);
                    calendar.setYear(currentYear);
                    calendarControl.attachEventsOnNextPrev();
                },
                displayYear: function() {
                    let yearLabel = document.querySelector(".calendar .calendar-year-label");
                    yearLabel.innerHTML = calendar.getFullYear();
                },
                displayMonth: function() {
                    let monthLabel = document.querySelector(
                        ".calendar .calendar-month-label"
                    );
                    monthLabel.innerHTML = calendarControl.calMonthName[calendar.getMonth()];
                },
                selectDate: function(e) {
                    console.log(
                        `${e.target.textContent} ${
            calendarControl.calMonthName[calendar.getMonth()]
          } ${calendar.getFullYear()}`
                    );
                },
                plotSelectors: function() {
                    document.querySelector(
                        ".calendar"
                    ).innerHTML += `<div class="calendar-inner"><div class="calendar-controls">
          <div class="calendar-prev"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128"><path fill="#666" d="M88.2 3.8L35.8 56.23 28 64l7.8 7.78 52.4 52.4 9.78-7.76L45.58 64l52.4-52.4z"/></svg></a></div>
          <div class="calendar-year-month">
          <div class="calendar-month-label"></div>
          <div>-</div>
          <div class="calendar-year-label"></div>
          </div>
          <div class="calendar-next"><a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="128" height="128" viewBox="0 0 128 128"><path fill="#666" d="M38.8 124.2l52.4-52.42L99 64l-7.77-7.78-52.4-52.4-9.8 7.77L81.44 64 29 116.42z"/></svg></a></div>
          </div>
          <div class="calendar-today-date">Today: 
            ${calendarControl.calWeekDays[calendarControl.localDate.getDay()]}, 
            ${calendarControl.localDate.getDate()}, 
            ${calendarControl.calMonthName[calendarControl.localDate.getMonth()]} 
            ${calendarControl.localDate.getFullYear()}
          </div>
          <div class="calendar-body"></div></div>`;
                },
                plotDayNames: function() {
                    for (let i = 0; i < calendarControl.calWeekDays.length; i++) {
                        document.querySelector(
                            ".calendar .calendar-body"
                        ).innerHTML += `<div>${calendarControl.calWeekDays[i]}</div>`;
                    }
                },
                plotDates: function() {
                    document.querySelector(".calendar .calendar-body").innerHTML = "";
                    calendarControl.plotDayNames();
                    calendarControl.displayMonth();
                    calendarControl.displayYear();
                    let count = 1;
                    let prevDateCount = 0;

                    calendarControl.prevMonthLastDate = calendarControl.getPreviousMonthLastDate();
                    let prevMonthDatesArray = [];
                    let calendarDays = calendarControl.daysInMonth(
                        calendar.getMonth() + 1,
                        calendar.getFullYear()
                    );
                    // dates of current month
                    for (let i = 1; i < calendarDays; i++) {
                        if (i < calendarControl.firstDayNumber()) {
                            prevDateCount += 1;
                            document.querySelector(
                                ".calendar .calendar-body"
                            ).innerHTML += `<div class="prev-dates"></div>`;
                            prevMonthDatesArray.push(calendarControl.prevMonthLastDate--);
                        } else {
                            document.querySelector(
                                ".calendar .calendar-body"
                            ).innerHTML += `<div class="number-item" data-num=${count}><a class="dateNumber" href="#">${count++}</a></div>`;
                        }
                    }
                    //remaining dates after month dates
                    for (let j = 0; j < prevDateCount + 1; j++) {
                        document.querySelector(
                            ".calendar .calendar-body"
                        ).innerHTML += `<div class="number-item" data-num=${count}><a class="dateNumber" href="#">${count++}</a></div>`;
                    }
                    calendarControl.highlightToday();
                    calendarControl.plotPrevMonthDates(prevMonthDatesArray);
                    calendarControl.plotNextMonthDates();
                },
                attachEvents: function() {
                    let prevBtn = document.querySelector(".calendar .calendar-prev a");
                    let nextBtn = document.querySelector(".calendar .calendar-next a");
                    let todayDate = document.querySelector(".calendar .calendar-today-date");
                    let dateNumber = document.querySelectorAll(".calendar .dateNumber");
                    prevBtn.addEventListener(
                        "click",
                        calendarControl.navigateToPreviousMonth
                    );
                    nextBtn.addEventListener("click", calendarControl.navigateToNextMonth);
                    todayDate.addEventListener(
                        "click",
                        calendarControl.navigateToCurrentMonth
                    );
                    for (var i = 0; i < dateNumber.length; i++) {
                        dateNumber[i].addEventListener(
                            "click",
                            calendarControl.selectDate,
                            false
                        );
                    }
                },
                highlightToday: function() {
                    let currentMonth = calendarControl.localDate.getMonth() + 1;
                    let changedMonth = calendar.getMonth() + 1;
                    let currentYear = calendarControl.localDate.getFullYear();
                    let changedYear = calendar.getFullYear();
                    if (
                        currentYear === changedYear &&
                        currentMonth === changedMonth &&
                        document.querySelectorAll(".number-item")
                    ) {
                        document
                            .querySelectorAll(".number-item")[calendar.getDate() - 1].classList.add("calendar-today");
                    }
                },
                plotPrevMonthDates: function(dates) {
                    dates.reverse();
                    for (let i = 0; i < dates.length; i++) {
                        if (document.querySelectorAll(".prev-dates")) {
                            document.querySelectorAll(".prev-dates")[i].textContent = dates[i];
                        }
                    }
                },
                plotNextMonthDates: function() {
                    let childElemCount = document.querySelector('.calendar-body').childElementCount;
                    //7 lines
                    if (childElemCount > 42) {
                        let diff = 49 - childElemCount;
                        calendarControl.loopThroughNextDays(diff);
                    }

                    //6 lines
                    if (childElemCount > 35 && childElemCount <= 42) {
                        let diff = 42 - childElemCount;
                        calendarControl.loopThroughNextDays(42 - childElemCount);
                    }

                },
                loopThroughNextDays: function(count) {
                    if (count > 0) {
                        for (let i = 1; i <= count; i++) {
                            document.querySelector('.calendar-body').innerHTML += `<div class="next-dates">${i}</div>`;
                        }
                    }
                },
                attachEventsOnNextPrev: function() {
                    calendarControl.plotDates();
                    calendarControl.attachEvents();
                },
                init: function() {
                    calendarControl.plotSelectors();
                    calendarControl.plotDates();
                    calendarControl.attachEvents();
                }
            };
            calendarControl.init();
        }

        const calendarControl = new CalendarControl();
    </script>
</body>

</html>