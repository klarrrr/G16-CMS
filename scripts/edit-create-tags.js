const tagsInput = document.getElementById('widget-tags-input');
const tagsContainer = document.querySelector('.tags-container');
let currentTags = [];

// Add tag on Enter key
tagsInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        // Remove the message if it exists
        const existingMsg = tagsContainer.querySelector('.no-tags-msg');
        if (existingMsg) {
            existingMsg.remove();
        }
        e.preventDefault();
        const tagName = tagsInput.value.trim();
        if (tagName && !currentTags.includes(tagName)) {
            addTagElement(tagName);
            currentTags.push(tagName);
            tagsInput.value = '';
        }
    }
});

// Add tag element to the DOM
function addTagElement(tagName) {
    const tagDiv = document.createElement('div');
    tagDiv.className = 'added-tag';
    tagDiv.innerHTML = `
        <span class='tag-name'>${tagName}</span>
        <span class='remove-tag'>x</span>
    `;
    tagsContainer.appendChild(tagDiv);

    // REMOVE TAG
    tagDiv.querySelector('.remove-tag').addEventListener('click', () => {
        tagsContainer.removeChild(tagDiv);
        currentTags = currentTags.filter(tag => tag !== tagName);

        // Check if no more tags exist
        const remainingTags = tagsContainer.querySelectorAll('.added-tag'); // Replace with your actual tag class
        if (remainingTags.length === 0) {
            // Remove any existing message first
            const existingMsg = tagsContainer.querySelector('.no-tags-msg');
            if (!existingMsg) {
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
        }
    });

}

// Send tags to server (call this on Save/Submit)
function saveTags(article_id) {
    console.log(article_id);
    console.log(currentTags);

    $.ajax({
        url: 'php-backend/save-tags.php',
        type: 'POST',
        dataType: 'json',
        data: {
            article_id: article_id,
            tags: currentTags
        },
        success: (res) => {
            if (res.success) {
                alert('Tags saved successfully!');
                updateDateUpdated(article_id, "Article Tags modified");
            }
        },
        error: (err) => {
            console.error(err);
        }
    });
}

// Save button
document.getElementById('save-tags-button').addEventListener('click', function () {
    saveTags(article_id);
});