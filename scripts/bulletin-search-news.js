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
                let picUrl = null;
                if (widget.widget_img != '') {
                    picUrl = 'data:image/png;base64,' + widget.widget_img;
                } else {
                    picUrl = 'pics/plp-outside.jpg';
                }

                const articleOwner = widget.article_owner; // Store the article ID for the "Read More" functionality

                rows += `
                <div class="bulletin-news-card">
                    <img src="${picUrl}" loading="lazy">
                    <div class="card-text-container">
                        <div>
                            <h2>${widget.widget_title}</h2>
                            <p class="time-posted" style="padding-bottom: 1em;">
                                Posted<small> ● </small>${formatDateTime(widget.date_created)}
                            </p>
                            <hr>
                        </div>
                        <p>${widget.widget_paragraph}</p>
                        <a href="#" class="read-more" articleid="${articleOwner}">Read More</a>
                    </div>
                </div>`;
            });

            // Update the page with the search results
            $(bulletinCardNewsContainer).html(rows);

            // Attach event listeners to each "Read More" button
            const readMoreButtons = document.querySelectorAll('.read-more');
            readMoreButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault(); // Prevent the default anchor behavior
                    goToArticle(button); // Call the function to navigate to the article page
                });
            });

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

// Function to navigate to the article page
function goToArticle(articleId) {
    const article_id = articleId.getAttribute('articleId');
    window.location.href = `/G16-CMS/lundayan-site-article.php?article_id=${article_id}`;
}

// Initial load (if needed, on page load)
loadSearchData(currentPage, searchBar.value);
