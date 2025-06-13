// Function to load all assigned tags for an article
function loadAssignedTags(article_id) {
    $.ajax({
        url: 'php-backend/get-assigned-tags.php',
        type: 'POST',
        dataType: 'json',
        data: {
            article_id: article_id
        },
        success: (res) => {
            const tagsContainer = document.querySelector('.tags-container');

            // Remove the message if it exists
            const existingMsg = tagsContainer.querySelector('.no-tags-msg');
            if (existingMsg) {
                existingMsg.remove();
            }

            if (res.success && res.tags.length > 0) {
                res.tags.forEach(tag => {
                    addTagElement(tag.tag_name);
                    currentTags.push(tag.tag_name);
                });
            } else {
                // Create the message element
                const msg = document.createElement('div');
                msg.className = 'no-tags-msg';
                msg.style.padding = '1rem';
                msg.style.color = '#555';
                msg.style.fontStyle = 'italic';
                msg.style.fontFamily = 'sub';
                msg.style.fontSize = '0.8rem';
                msg.textContent = '🗿 Ayo! This article doesn\'t have assigned tags!';

                tagsContainer.appendChild(msg);
            }
        },
        error: (err) => {
            console.error(err);
        }
    });
}

