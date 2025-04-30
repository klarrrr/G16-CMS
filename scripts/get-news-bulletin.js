const bulletinCardNewsContainer = document.getElementById('bulletin-card-news-container');

const paginationContainer = document.getElementById('pagination');

let currentPage = 1;
const itemsPerPage = 10;

function loadData(page = 1) {
    $.ajax({
        url: '../php-backend/get-news-bulletin.php',
        type: 'GET',
        dataType: 'json',
        data: {
            page: page
        },
        success: (res) => {
            const widgets = res.widget;

            let rows = '';

            widgets.forEach(widget => {
                rows += `
                <div class="bulletin-news-card">
                    <img src="pics/${widget.widget_img}" loading="lazy">
                    <div class="card-text-container">
                        <div>
                            <h2>${widget.widget_title}</h2>
                            
                            <p class="time-posted" style="padding-bottom: 1em;">Posted<small> ● </small>${formatDateTime(widget.date_created)}</p>
                            
                            <hr>
                            
                        </div>
                        <p>${widget.widget_paragraph}</p>
                        
                        <a href="#">Read More</a>
                    </div>
                </div>`;
            });

            $(bulletinCardNewsContainer).html(rows);

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

// Handle pagination link clicks
$(document).on('click', '.page-link', function (e) {
    e.preventDefault();
    const page = $(this).data('page');
    currentPage = page;
    loadData(page);
});

// Initial load
loadData(currentPage);

