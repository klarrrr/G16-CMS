const searchBar = document.getElementById('search-bar');

// Function to load search data with pagination
function loadSearchData(page = 1, searchFor = '') {
    $.ajax({
        url: 'php-backend/bulletin-search-news.php',
        type: 'GET',
        dataType: 'json',
        data: {
            page: page,
            search: searchFor
        },
        success: (res) => {
            const widgets = res.widget;
            let rows = '';

            // Generate rows for each widget
            widgets.forEach(widget => {
                rows += `
                <div class="bulletin-news-card">
                    <img src="pics/${widget.widget_img}" loading="lazy">
                    <div class="card-text-container">
                        <div>
                            <h2>${widget.widget_title}</h2>
                            <p class="time-posted" style="padding-bottom: 1em;">
                                Posted<small> ● </small>${formatDateTime(widget.date_created)}
                            </p>
                            <hr>
                        </div>
                        <p>${widget.widget_paragraph}</p>
                        <a href="#">Read More</a>
                    </div>
                </div>`;
            });

            $(bulletinCardNewsContainer).html(rows);

            // Handle pagination
            let pagination = '';
            for (let i = 1; i <= res.totalPages; i++) {
                pagination += `<a href="#" class="page-link ${i === page ? 'active' : ''}" data-page="${i}">${i}</a>`;
            }
            $(paginationContainer).html(pagination);
        },
        error: (error) => {
            console.log(error);
        }
    });
}

// Handle "Enter" key press in the search bar
searchBar.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        e.preventDefault(); // Prevent form submission or default action
        loadSearchData(1, searchBar.value); // Trigger search with the current value in the search bar
    }
});

// Handle pagination link clicks
$(document).on('click', '.page-link', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    currentPage = page;
    loadSearchData(page, searchBar.value); // Pass current search term and page
});

// Initial load (if needed, on page load)
loadSearchData(currentPage, searchBar.value);
