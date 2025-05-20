// Function to get all selected tags and their tag-ids
function getSelectedTags() {
    const selectedTags = document.getElementsByClassName('tag selected');
    let tagIds = [];

    for (let i = 0; i < selectedTags.length; i++) {
        const tagId = selectedTags[i].getAttribute('tag-id');
        if (tagId) {
            tagIds.push(tagId);
        }
    }

    return tagIds;
}

// Updated loadNewsByTags function
function loadNewsByTags(page = 1) {
    const tagIds = getSelectedTags(); // Get all selected tag ids

    // Ensure there's at least one tag selected
    if (tagIds.length === 0) {
        console.log('No tags selected');
        return;
    }

    $.ajax({
        url: 'php-backend/bulletin-search-by-tags.php',
        type: 'POST',
        dataType: 'json',
        data: {
            page: page,
            tag_ids: tagIds
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
