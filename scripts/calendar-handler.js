const monthSelect = document.getElementById("month-select");
const yearSelect = document.getElementById("year-select");
const calendarBody = document.getElementById("calendar-body");
const prevBtn = document.querySelector(".calendar-btns button:first-child");
const nextBtn = document.querySelector(".calendar-btns button:last-child");

let currentMonth, currentYear;

let shown = false;

// $.ajax({
//     url: 'php-backend/get-news-bulletin.php',
//     type: 'POST',
//     dataType: 'json',
//     data: {},
//     success: (res) => {
//         const widgets = res.widget;
//     },
//     error: (error) => {
//         console.log(error);
//     }
// });

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
                if (
                    date === today.getDate() &&
                    month === today.getMonth() &&
                    year === today.getFullYear()
                ) {
                    cell.classList.add("td-highlighted");
                }

                const thisDay = date;

                cell.addEventListener("click", (e) => {
                    showEventBox(e.target, thisDay, month, year);
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

    const rect = cell.getBoundingClientRect();

    // Simulated events
    // Hard Coded, make it dynamic
    const events = [
        { title: "CHED Visits Inang Pamantasan", description: "Zoom @ 10:00 AM" },
        { title: "Project Deadline", description: "Submit by 5 PM" }
    ];

    const cards = events.map(event => `
        <div class="event-card">
            <strong>${event.title}</strong>
        </div>
    `).join("");

    box.innerHTML = `
    <div class='close-event-box-container'>
        <h4>${month + 1}/${day}/${year}</h4>
        <span id='close-event-box' class='close-event-box'>X</span>
    </div>
    ${cards}
        `;
    box.style.display = "block";
    box.style.top = `${rect.top + window.scrollY + 10}px`;
    box.style.left = `${rect.left + window.scrollX + 10}px`;

    const closeEventBtn = document.getElementById('close-event-box');
    closeEventBtn.addEventListener('click', () => {
        hideEventBox();
    });
}

function hideEventBox() {
    const box = document.getElementById("event-box");
    box.style.display = "none";
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

    timeContainer.textContent = formattedTime;
    dateContainer.textContent = formattedDate;
}

// Init
const now = new Date();
currentMonth = now.getMonth();
currentYear = now.getFullYear();

monthSelect.value = currentMonth;
yearSelect.value = currentYear;

renderCalendar(currentMonth, currentYear);
setInterval(updateTime, 1000);
updateTime();

// Events
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
