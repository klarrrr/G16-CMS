const monthSelect = document.getElementById("month-select");
const yearSelect = document.getElementById("year-select");
const calendarBody = document.getElementById("calendar-body");
const prevBtn = document.querySelector(".calendar-btns button:first-child");
const nextBtn = document.querySelector(".calendar-btns button:last-child");

let currentMonth, currentYear;
let articles = [];
let articlesByDate = {};

const fetchArticles = () => {
    return $.ajax({
        url: "php-backend/calendar-get-articles.php",
        type: "GET",
        dataType: "json",
        success: function (res) {
            const resArticles = res.articles || [];
            articles = resArticles;
            articlesByDate = {};

            resArticles.forEach(article => {
                const dateKey = article.date_posted.split(' ')[0];
                if (!articlesByDate[dateKey]) {
                    articlesByDate[dateKey] = [];
                }
                articlesByDate[dateKey].push(article);
            });

            if (res.minYear && res.maxYear) {
                const startYear = parseInt(res.minYear) - 1;
                const endYear = parseInt(res.maxYear) + 1;

                yearSelect.innerHTML = "";
                for (let y = endYear; y >= startYear; y--) {
                    const opt = document.createElement("option");
                    opt.value = y;
                    opt.textContent = y;
                    yearSelect.appendChild(opt);
                }

                const nowYear = new Date().getFullYear();
                currentYear = nowYear >= startYear && nowYear <= endYear ? nowYear : endYear;
                yearSelect.value = currentYear;
            }
        },
        error: function (xhr, status, error) {
            console.error("Failed to fetch articles:", error);
            articles = [];
            articlesByDate = {};
        }
    });
};

const renderCalendar = (month, year) => {
    const firstDay = new Date(year, month).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    calendarBody.innerHTML = "";

    let date = 1;
    for (let i = 0; i < 6; i++) {
        const row = document.createElement("tr");
        let allCellsEmpty = true;

        for (let j = 0; j < 7; j++) {
            const cell = document.createElement("td");

            if (i === 0 && j < firstDay || date > daysInMonth) {
                cell.textContent = "";
                cell.classList.add("empty-cell");
            } else {
                cell.textContent = date;

                const today = new Date();
                if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    cell.classList.add("td-today");
                }

                const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;

                if (articlesByDate[dateKey]) {
                    cell.classList.add("td-highlighted");
                }

                const thisDay = date;

                cell.addEventListener("click", (e) => {
                    if (articlesByDate[dateKey]) {
                        showEventBox(e.target, thisDay, month, year);
                    } else {
                        hideEventBox();
                    }
                });

                date++;
                allCellsEmpty = false;
            }

            row.appendChild(cell);
        }

        if (allCellsEmpty && date > daysInMonth) break;
        calendarBody.appendChild(row);
    }
};

function updateDropdowns() {
    monthSelect.value = currentMonth;
    yearSelect.value = currentYear;
}

function showEventBox(cell, day, month, year) {
    const box = document.getElementById("event-box");
    const backdrop = document.getElementById("event-backdrop");

    const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    const events = articlesByDate[dateKey] || [];

    if (events.length === 0) {
        hideEventBox();
        return;
    }

    const cards = events.map(event => `
        <div class="event-card" articleid="${event.article_id}">
            <h3 class="event-title">${event.article_title}</h3>
            <p class="event-description">${event.widget_paragraph || "No summary available."}</p>
            <div class="event-meta">
                <span class="event-author">By ${event.author || "Unknown"}</span>
                <span class="event-date">${new Date(event.date_posted).toLocaleString()}</span>
            </div>
        </div>
    `).join("");

    box.innerHTML = `
        <div class='close-event-box-container'>
            <h4>${month + 1}/${day}/${year}</h4>
            <span id='close-event-box' class='close-event-box'>X</span>
        </div>
        ${cards}
    `;

    // Get current scroll position and viewport size
    const scrollTop = window.scrollY;
    const scrollLeft = window.scrollX;
    const viewportHeight = window.innerHeight;
    const viewportWidth = window.innerWidth;

    // Set position based on viewport center + scroll
    box.style.top = `${scrollTop + viewportHeight / 2}px`;
    box.style.left = `${scrollLeft + viewportWidth / 2}px`;
    box.style.transform = `translate(-50%, -50%)`;
    box.style.position = "absolute";
    box.style.display = "block";

    backdrop.style.display = "block";
    document.body.style.overflow = "hidden";

    document.getElementById('close-event-box').addEventListener('click', hideEventBox);
    backdrop.onclick = hideEventBox;

    box.querySelectorAll('.event-card').forEach(card => {
        card.addEventListener('click', function () {
            goToArticle(this);
        });
    });
}


function hideEventBox() {
    const box = document.getElementById("event-box");
    const backdrop = document.getElementById("event-backdrop");

    box.style.display = "none";
    backdrop.style.display = "none";
    document.body.style.overflow = "";
}

function updateTime() {
    const now = new Date();
    const formattedDate = now.toLocaleDateString('en-US', {
        weekday: 'long', month: 'long', year: 'numeric'
    });
    const formattedTime = now.toLocaleTimeString('en-US', {
        hour: '2-digit', minute: '2-digit'
    });

    const timeContainer = document.querySelector(".time-day-text-container h3");
    const dateContainer = document.querySelector(".time-day-text-container p");

    if (timeContainer) timeContainer.textContent = formattedTime;
    if (dateContainer) dateContainer.textContent = formattedDate;
}

// Initialize
const now = new Date();
currentMonth = now.getMonth();
currentYear = now.getFullYear();

monthSelect.value = currentMonth;
yearSelect.value = currentYear;

fetchArticles().then(() => {
    renderCalendar(currentMonth, currentYear);
});

setInterval(updateTime, 1000);
updateTime();

// Event listeners
monthSelect.addEventListener("change", () => {
    currentMonth = parseInt(monthSelect.value);
    renderCalendar(currentMonth, currentYear);
});

yearSelect.addEventListener("change", () => {
    currentYear = parseInt(yearSelect.value);
    renderCalendar(currentMonth, currentYear);
});

prevBtn.addEventListener("click", () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    updateDropdowns();
    renderCalendar(currentMonth, currentYear);
});

nextBtn.addEventListener("click", () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    updateDropdowns();
    renderCalendar(currentMonth, currentYear);
});

function goToArticle(thisContainer) {
    const article_id = thisContainer.getAttribute('articleid');
    window.location.href = `/G16-CMS/lundayan-site-article.php?article_id=${article_id}`;
}