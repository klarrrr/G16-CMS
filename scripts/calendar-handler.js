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
    let allCellsEmpty = true;
    
    for (let j = 0; j < 7; j++) {
        const cell = document.createElement("td");

        if (i === 0 && j < firstDay) {
            cell.textContent = "";
            cell.classList.add("empty-cell");
        } else if (date > daysInMonth) {
            cell.textContent = "";
            cell.classList.add("empty-cell");
        } else {
            cell.textContent = date;
            const today = new Date();
            if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                cell.classList.add("td-highlighted");
            }
            date++;
            allCellsEmpty = false;
        }

        row.appendChild(cell);
    }

    if (allCellsEmpty && date > daysInMonth) {
        break; 
    }

    calendarBody.appendChild(row);
}

};

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

const timeContainer = document.querySelector(".time-day-text-container h3");
const dateContainer = document.querySelector(".time-day-text-container p");

function updateTime() {
    const now = new Date();
    const options = { weekday: 'long', month: 'long', year: 'numeric' };
    const formattedDate = now.toLocaleDateString('en-US', options);
    const formattedTime = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });

    timeContainer.textContent = formattedTime;
    dateContainer.textContent = formattedDate;
}

setInterval(updateTime, 1000);
updateTime(); // Call once initially
