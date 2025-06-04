<?php
header('Content-Type: text/html; charset=UTF-8');

$view = isset($_GET['view']) ? $_GET['view'] : 'list';
$limit = isset($_GET['limit']) ? $_GET['limit'] : '5';
$startDate = isset($_GET['startdate']) ? $_GET['startdate'] : date('Y-m-d');
$width = isset($_GET['width']) ? $_GET['width'] : '100%';
$height = isset($_GET['height']) ? $_GET['height'] : ($view === 'list' ? 'auto' : '500px');

include 'php-backend/connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Events Widget</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body {
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        background: white;
        margin: 0;
        padding: 0;
        color: hsla(155, 41%, 16%, 1);
    }

    .events-container {
        max-width: 100%;
        width: <?php echo htmlspecialchars($width); ?>;
        height: <?php echo htmlspecialchars($height); ?>;
        overflow: hidden;
        <?php if ($height !== 'auto'): ?>
        overflow-y: auto;
        <?php endif; ?>
    }

    .date-controls {
        display: flex;
        gap: 12px;
        margin-bottom: 20px;
        align-items: center;
        background: rgba(15, 81, 50, 0.05);
        padding: 16px;
        border-radius: 12px;
    }

    .date-controls label {
        font-weight: 600;
        color: #0F5132;
    }

    .date-controls input[type="date"] {
        padding: 8px 12px;
        border: 1px solid rgba(15, 81, 50, 0.2);
        border-radius: 8px;
        background: white;
    }

    .date-controls button {
        background-color: #0F5132;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .date-controls button:hover {
        background-color: hsla(155, 41%, 16%, 1);
    }

    .event-date-header {
        font-size: clamp(1rem, 2vw, 1.2rem);
        font-weight: 600;
        margin: 24px 0 12px 0;
        color: #0F5132;
        padding-bottom: 8px;
        border-bottom: 2px solid #ffc93c;
    }

    .event-card {
        display: flex;
        margin-bottom: 20px;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        background-color: white;
        border: 1px solid rgba(15, 81, 50, 0.1);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .event-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.12);
    }

    .event-image {
        flex: 0 0 180px;
        background: #f8f9fa;
        min-height: 120px;
    }

    .event-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .event-content {
        flex: 1;
        padding: 20px;
    }

    .event-title {
        margin: 0 0 12px 0;
        font-size: clamp(1rem, 1.5vw, 1.1rem);
        font-weight: 600;
        color: #0F5132;
    }

    .event-description {
        margin: 0 0 12px 0;
        font-size: clamp(0.85rem, 1.2vw, 0.95rem);
        line-height: 1.5;
        color: hsla(155, 41%, 16%, 0.8);
    }

    .event-meta {
        display: flex;
        gap: 16px;
        font-size: clamp(0.75rem, 1vw, 0.85rem);
        color: hsla(155, 41%, 16%, 0.6);
    }

    .view-toggle {
        text-align: right;
        margin-bottom: 20px;
    }

    .view-toggle button {
        background: #0F5132;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .view-toggle button:hover {
        background: hsla(155, 41%, 16%, 1);
    }

.calendar-header {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    gap: 12px;
}

.calendar-nav {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

#today-btn {
    background: #ffc93c;
    color: #0F5132;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 500;
    transition: all 0.2s ease;
    white-space: nowrap;
    flex-shrink: 0;
}

@media (max-width: 768px) {
    .calendar-header {
        flex-direction: column;
        align-items: stretch;
        gap: 8px;
    }
    
    .calendar-nav {
        justify-content: center;
    }
    
    #today-btn {
        width: 100%;
    }
}

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .calendar-nav {
        display: flex;
        gap: 12px;
        align-items: center;
    }

    .calendar-nav button {
        background: #0F5132;
        color: white;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
    }

    .calendar-nav button:hover {
        background: hsla(155, 41%, 16%, 1);
        transform: scale(1.1);
    }

    .calendar-nav select {
        padding: 6px 10px;
        border: 1px solid rgba(15, 81, 50, 0.2);
        border-radius: 6px;
        background: white;
        color: hsla(155, 41%, 16%, 1);
    }

    #today-btn {
        background: #ffc93c;
        color: #0F5132;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    #today-btn:hover {
        background: #f5ba2a;
    }

    .calendar-grid {
        width: 100%;
        border-collapse: separate;
        border-spacing: 4px;
        background: white;
    }

    .calendar-grid th {
        background: rgba(15, 81, 50, 0.05);
        color: #0F5132;
        padding: 12px;
        font-weight: 500;
        text-align: center;
        font-size: clamp(0.8rem, 1.2vw, 1rem);
    }

    .calendar-grid td {
        padding: 12px;
        text-align: center;
        border-radius: 8px;
        transition: all 0.2s ease;
        position: relative;
        font-size: clamp(0.8rem, 1.2vw, 1rem);
    }

    .calendar-grid td:hover:not(.empty-cell) {
        transform: scale(1.05);
    }

    .td-highlighted {
        background: #0F5132;
        color: white;
        font-weight: 600;
        box-shadow: 0 2px 6px rgba(15, 81, 50, 0.2);
    }

    .td-highlighted:hover {
        background: hsla(155, 41%, 16%, 1);
    }

    .td-today {
        background: #ffc93c;
        color: #0F5132;
        font-weight: 600;
    }

    .empty-cell {
        background: transparent;
    }

    .no-events {
        padding: 40px 20px;
        text-align: center;
        color: hsla(155, 41%, 16%, 0.5);
        font-size: 1.1rem;
    }

    /* Modal Styles */
    .event-popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 24px;
        border-radius: 12px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.15);
        z-index: 1000;
        max-width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        width: min(600px, 90vw);
    }

    .event-popup h3 {
        color: #0F5132;
        margin-top: 0;
        padding-bottom: 12px;
        border-bottom: 2px solid #ffc93c;
    }

    .close-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        cursor: pointer;
        font-size: 1.5rem;
        color: hsla(155, 41%, 16%, 0.6);
        transition: all 0.2s ease;
    }

    .close-btn:hover {
        color: #0F5132;
        transform: scale(1.1);
    }

    .event-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 999;
        backdrop-filter: blur(4px);
    }

    @media (max-width: 768px) {
        .event-card {
            flex-direction: column;
        }
        
        .event-image {
            flex: 0 0 200px;
            width: 100%;
        }
        
        .date-controls {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .calendar-nav {
            flex-wrap: wrap;
        }
        
        .calendar-grid th, 
        .calendar-grid td {
            padding: 8px 4px;
        }
    }

    
/* width */
::-webkit-scrollbar {
    width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
    background: transparent;
}

/* Handle */
::-webkit-scrollbar-thumb {
    background: #ffcc4b;
    border-radius: 0.2rem;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
    background: #A7FF83;
}
    </style>
</head>
<body>
    <div class="events-container">
        <?php if ($view === 'list'): ?>
            <div class="view-toggle">
                <button onclick="showCalendarView()">Switch to Calendar View</button>
            </div>
            <div class="date-controls">
                <label>Show events from:</label>
                <input type="date" id="filter-date" value="<?php echo htmlspecialchars($startDate); ?>">
                <button onclick="applyDateFilter()">Apply</button>
            </div>
            <div id="events-list">
                <!-- Events will be loaded here -->
            </div>
        <?php else: ?>
            <div class="view-toggle">
                <button onclick="showListView()">Switch to List View</button>
            </div>
            <div id="calendar-view" class="calendar-container">
                <div class="calendar-header">
                    <div class="calendar-nav">
                        <button id="prev-btn">‹</button>
                        <select id="month-select"></select>
                        <select id="year-select"></select>
                        <button id="next-btn">›</button>
                    </div>
                    <button id="today-btn">Today</button>
                </div>
                
                <table class="calendar-grid">
                    <thead>
                        <tr>
                            <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-body"></tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Event Popup Modal -->
    <div id="event-popup" class="event-popup" style="display:none;">
        <span class="close-btn" onclick="hideEventPopup()">×</span>
        <div id="event-popup-content"></div>
    </div>
    <div id="event-backdrop" class="event-backdrop" style="display:none;"></div>
    
    <script>
    // Shared data and functions
    let articles = [];
    let articlesByDate = {};
    let currentMonth, currentYear;
    const startDate = new Date('<?php echo $startDate; ?>');
    startDate.setHours(0, 0, 0, 0);

    function formatDateString(date) {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        return date.toLocaleDateString('en-US', options);
    }

    function showCalendarView() {
        const limit = '<?php echo $limit; ?>';
        const startDate = '<?php echo $startDate; ?>';
        const width = '<?php echo $width; ?>';
        const height = '<?php echo $height; ?>';
        window.location.href = `events-widget.php?view=calendar&limit=${limit}&startdate=${startDate}&width=${width}&height=${height}`;
    }

    function showListView() {
        const limit = '<?php echo $limit; ?>';
        const startDate = '<?php echo $startDate; ?>';
        const width = '<?php echo $width; ?>';
        const height = '<?php echo $height; ?>';
        window.location.href = `events-widget.php?view=list&limit=${limit}&startdate=${startDate}&width=${width}&height=${height}`;
    }

    function applyDateFilter() {
        const newDate = document.getElementById('filter-date').value;
        const limit = '<?php echo $limit; ?>';
        const width = '<?php echo $width; ?>';
        const height = '<?php echo $height; ?>';
        window.location.href = `events-widget.php?view=list&limit=${limit}&startdate=${newDate}&width=${width}&height=${height}`;
    }

    // Load events from server
    function fetchEvents() {
        return $.ajax({
            url: "php-backend/calendar-get-articles.php",
            type: "GET",
            dataType: "json",
            success: function(res) {
                articles = res.articles || [];
                articlesByDate = {};
                
                // Sort articles by date (newest first)
                articles.sort((a, b) => new Date(a.date_posted) - new Date(b.date_posted));
                
                // Group by date
                articles.forEach(article => {
                    const dateKey = article.date_posted.split(' ')[0];
                    if (!articlesByDate[dateKey]) {
                        articlesByDate[dateKey] = [];
                    }
                    articlesByDate[dateKey].push(article);
                });
                
                if ('<?php echo $view; ?>' === 'list') {
                    renderEventsList();
                } else {
                    initCalendar();
                }
            },
            error: function(xhr, status, error) {
                console.error("Failed to fetch events:", error);
            }
        });
    }

    // List View Functions
    function renderEventsList() {
        // Filter events based on start date
        const filteredEvents = articles.filter(event => {
            const eventDate = new Date(event.date_posted.split(' ')[0]);
            return eventDate >= startDate;
        });
        
        // Apply limit
        let eventsToShow = filteredEvents;
        if ('<?php echo $limit; ?>' !== 'all') {
            eventsToShow = filteredEvents.slice(0, parseInt('<?php echo $limit; ?>'));
        }
        
        // Group by date
        const eventsByDate = {};
        eventsToShow.forEach(event => {
            const dateKey = event.date_posted.split(' ')[0];
            if (!eventsByDate[dateKey]) {
                eventsByDate[dateKey] = [];
            }
            eventsByDate[dateKey].push(event);
        });
        
        // Render events
        const container = document.getElementById('events-list');
        container.innerHTML = '';
        
        if (eventsToShow.length === 0) {
            container.innerHTML = '<div class="no-events">No events found from the selected date onward.</div>';
            return;
        }
        
        Object.keys(eventsByDate).sort().forEach(date => {
            const dateHeader = document.createElement('div');
            dateHeader.className = 'event-date-header';
            dateHeader.textContent = formatDateString(new Date(date));
            container.appendChild(dateHeader);
            
            eventsByDate[date].forEach(event => {
                const imageUrl = event.widget_img && event.widget_img.trim() !== "" ? event.widget_img : "pics/plp-outside.jpg";
                
                const card = document.createElement('div');
                card.className = 'event-card';
                card.setAttribute('articleid', event.article_id);
                card.innerHTML = `
                    <div class="event-image">
                        <img src="${imageUrl}" alt="${event.article_title}" onerror="this.onerror=null;this.src='pics/plp-outside.jpg';" />
                    </div>
                    <div class="event-content">
                        <h3 class="event-title">${event.article_title}</h3>
                        <p class="event-description">${event.widget_paragraph || "No summary available."}</p>
                        <div class="event-meta">
                            <span class="event-author">By ${event.user_first_name || "Unknown"} ${event.user_last_name || ""}</span>
                            <span class="event-date">${new Date(event.date_posted).toLocaleString()}</span>
                        </div>
                    </div>
                `;
                
                card.addEventListener('click', function() {
                    const articleId = this.getAttribute('articleid');
                    // Handle localhost vs production paths
                    const basePath = window.location.href.includes('localhost') ? '/G16-CMS' : '';
                    window.location.href = `${basePath}/lundayan-site-article.php?article_id=${articleId}`;
                });
                
                container.appendChild(card);
            });
        });
    }

    // Calendar View Functions
    function initCalendar() {
        document.getElementById('calendar-view').style.display = 'block';
        
        // Initialize month dropdown
        const monthSelect = document.getElementById('month-select');
        monthSelect.innerHTML = '';
        const months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];
        months.forEach((month, index) => {
            const option = document.createElement('option');
            option.value = index;
            option.textContent = month;
            monthSelect.appendChild(option);
        });
        
        // Initialize year dropdown with proper range
        const yearSelect = document.getElementById('year-select');
        yearSelect.innerHTML = '';
        
        // Get min and max years from articles
        let minYear = new Date().getFullYear() - 1;
        let maxYear = new Date().getFullYear() + 1;
        
        // If we have articles, get the actual min/max years
        if (articles.length > 0) {
            const years = articles.map(article => new Date(article.date_posted).getFullYear());
            minYear = Math.min(...years) - 1;
            maxYear = Math.max(...years) + 1;
        }
        
        // Populate year dropdown
        for (let year = maxYear; year >= minYear; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }
        
        const now = new Date();
        currentMonth = now.getMonth();
        currentYear = now.getFullYear();
        
        monthSelect.value = currentMonth;
        yearSelect.value = currentYear;
        
        renderCalendar(currentMonth, currentYear);
    }

    function renderCalendar(month, year) {
        const firstDay = new Date(year, month).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        const calendarBody = document.getElementById('calendar-body');
        calendarBody.innerHTML = '';
        
        let date = 1;
        for (let i = 0; i < 6; i++) {
            const row = document.createElement('tr');
            let allCellsEmpty = true;
            
            for (let j = 0; j < 7; j++) {
                const cell = document.createElement('td');
                
                if (i === 0 && j < firstDay || date > daysInMonth) {
                    cell.textContent = '';
                    cell.classList.add('empty-cell');
                } else {
                    cell.textContent = date;
                    
                    const today = new Date();
                    if (date === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
                        cell.classList.add('td-today');
                    }
                    
                    const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
                    const cellDate = new Date(year, month, date);
                    
                    if (articlesByDate[dateKey]) {
                        cell.classList.add('td-highlighted');
                    }
                    
                    if (cellDate >= startDate) {
                        cell.style.fontWeight = 'bold';
                    }
                    
                    cell.addEventListener('click', () => {
                        if (articlesByDate[dateKey]) {
                            showEventPopup(dateKey);
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
    }

    function showEventPopup(dateKey) {
        const events = articlesByDate[dateKey] || [];
        if (events.length === 0) return;
        
        const date = new Date(dateKey);
        const eventPopup = document.getElementById('event-popup');
        const eventBackdrop = document.getElementById('event-backdrop');
        const eventPopupContent = document.getElementById('event-popup-content');

        const cards = events.map(event => {
            const imageUrl = event.widget_img && event.widget_img.trim() !== "" ? event.widget_img : "pics/plp-outside.jpg";

            return `
            <div class="event-card" articleid="${event.article_id}">
                <div class="event-image">
                    <img src="${imageUrl}" alt="${event.article_title}" onerror="this.onerror=null;this.src='pics/plp-outside.jpg';" />
                </div>
                <div class="event-content">
                    <h3 class="event-title">${event.article_title}</h3>
                    <p class="event-description">${event.widget_paragraph || "No summary available."}</p>
                    <div class="event-meta">
                        <span class="event-author">By ${event.user_first_name || "Unknown"} ${event.user_last_name || ""}</span>
                        <span class="event-date">${new Date(event.date_posted).toLocaleString()}</span>
                    </div>
                </div>
            </div>
            `;
        }).join('');

        eventPopupContent.innerHTML = `
            <h3>${formatDateString(date)}</h3>
            ${cards}
        `;

        eventPopup.style.display = "block";
        eventBackdrop.style.display = "block";
        document.body.style.overflow = "hidden";

        // Add click handlers for event cards
        eventPopup.querySelectorAll('.event-card').forEach(card => {
            card.addEventListener('click', function() {
                const articleId = this.getAttribute('articleid');
                // Handle localhost vs production paths
                const basePath = window.location.href.includes('localhost') ? '/G16-CMS' : '';
                window.location.href = `${basePath}/lundayan-site-article.php?article_id=${articleId}`;
            });
        });
    }

    function hideEventPopup() {
        document.getElementById('event-popup').style.display = "none";
        document.getElementById('event-backdrop').style.display = "none";
        document.body.style.overflow = "";
    }

    // Initialize
    fetchEvents();
    
    // Calendar navigation event listeners
    if ('<?php echo $view; ?>' === 'calendar') {
        document.getElementById('prev-btn').addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            document.getElementById('month-select').value = currentMonth;
            document.getElementById('year-select').value = currentYear;
            renderCalendar(currentMonth, currentYear);
        });
        
        document.getElementById('next-btn').addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            document.getElementById('month-select').value = currentMonth;
            document.getElementById('year-select').value = currentYear;
            renderCalendar(currentMonth, currentYear);
        });
        
        document.getElementById('month-select').addEventListener('change', () => {
            currentMonth = parseInt(document.getElementById('month-select').value);
            renderCalendar(currentMonth, currentYear);
        });
        
        document.getElementById('year-select').addEventListener('change', () => {
            currentYear = parseInt(document.getElementById('year-select').value);
            renderCalendar(currentMonth, currentYear);
        });
        
        document.getElementById('today-btn').addEventListener('click', () => {
            const now = new Date();
            currentMonth = now.getMonth();
            currentYear = now.getFullYear();
            document.getElementById('month-select').value = currentMonth;
            document.getElementById('year-select').value = currentYear;
            renderCalendar(currentMonth, currentYear);
        });
    }
    </script>
</body>
</html>