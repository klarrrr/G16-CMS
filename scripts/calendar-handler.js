const monthSelect = document.getElementById("month-select");
const yearSelect = document.getElementById("year-select");
const calendarBody = document.getElementById("calendar-body");
const prevBtn = document.querySelector(".calendar-btns button:first-child");
const nextBtn = document.querySelector(".calendar-btns button:last-child");

let currentMonth, currentYear;

const renderCalendar = (month, year) => {
    const firstDay = new Date(year, month).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    calendarBody.innerHTML = "";

    let date = 1;
    for (let i = 0; i < 6; i++) {
        const row = document.createElement("tr");
        for (let j = 0; j < 7; j++) {
            const cell = document.createElement("td");
            if (i === 0 && j < firstDay) {
                cell.innerHTML = "";
            } else if (date > daysInMonth) {
                break;
            } else {
                cell.innerHTML = date;
                // Highlight today
                const today = new Date();
                if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                    cell.classList.add("td-highlighted");
                }
                date++;
            }
            row.appendChild(cell);
        }
        calendarBody.appendChild(row);
    }
};

// Load current month/year
const now = new Date();
currentMonth = now.getMonth();
currentYear = now.getFullYear();
monthSelect.value = currentMonth;
yearSelect.value = currentYear;
renderCalendar(currentMonth, currentYear);

// Dropdown change
monthSelect.addEventListener("change", () => {
    currentMonth = parseInt(monthSelect.value);
    renderCalendar(currentMonth, currentYear);
});

yearSelect.addEventListener("change", () => {
    currentYear = parseInt(yearSelect.value);
    renderCalendar(currentMonth, currentYear);
});

// Buttons
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

function updateDropdowns() {
    monthSelect.value = currentMonth;
    yearSelect.value = currentYear;
}
