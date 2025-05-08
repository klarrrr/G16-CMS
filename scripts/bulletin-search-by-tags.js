
const everyTags = document.getElementsByClassName('tag');

for (let i = 0; i < everyTags.length; i++) {
    console.log(everyTags[i].className);
}

function loadNewsByTags(page = 1, tag_id) {
    $.ajax({
        url: 'php-backend/bulletin-search-by-tags.php', //removed ../
        type: 'GET',
        dataType: 'json',
        data: {
            page: page,
            tag_id: tag_id
        },
        success: (res) => {
            const widgets = res;
            let rows = '';

            // Generate rows for each widget
            widgets.forEach(widget => {
                let picUrl = null;
                if (widget.widget_img != '') {
                    picUrl = 'data:image/png;base64,' + widget.widget_img;
                } else {
                    picUrl = 'pics/plp-outside.jpg';
                }

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

// loadNewsByTags();