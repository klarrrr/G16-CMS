const tagsInput = document.getElementById('widget-tags-input');
const tagsContainer = document.querySelector('.tags-container');
let currentTags = []; // This will store our tags in memory
const MAX_TAGS = 15;

// ========== Load Tags from Server ========== //
function loadAssignedTags(article_id) {
    $.ajax({
        url: 'php-backend/get-assigned-tags.php',
        type: 'POST',
        dataType: 'json',
        data: { article_id: article_id },
        success: (res) => {
            // 1. Clear existing tags from DOM and memory
            clearAllTags();

            // 2. If new tags exist, add them
            if (res.success && res.tags.length > 0) {
                res.tags.forEach(tag => {
                    addTagElement(tag.tag_name); // Adds to DOM
                    currentTags.push(tag.tag_name); // Adds to memory
                });
            } 
            // 3. If no tags, show message
            else {
                showNoTagsMessage();
            }

            updateTagCounter(); // Refresh counter
        },
        error: (err) => console.error(err)
    });
}

// ========== Helper Functions ========== //
function clearAllTags() {
    // Remove from DOM
    document.querySelectorAll('.added-tag').forEach(tag => tag.remove());
    // Remove from memory
    currentTags = [];
    // Remove any "no tags" message
    const existingMsg = tagsContainer.querySelector('.no-tags-msg');
    if (existingMsg) existingMsg.remove();
}

function showNoTagsMessage() {
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

// ========== Tag Management ========== //
// Add tag on Enter key
tagsInput.addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const tagName = tagsInput.value.trim();
        
        if (tagName && !currentTags.includes(tagName)) {
            if (currentTags.length >= MAX_TAGS) {
                showTagLimitWarning();
                return;
            }
            addTagElement(tagName);
            currentTags.push(tagName);
            tagsInput.value = '';
            updateTagCounter();
        }
    }
});

// Add a tag to the DOM
function addTagElement(tagName) {
    const tagDiv = document.createElement('div');
    tagDiv.className = 'added-tag';
    tagDiv.innerHTML = `
        <span class='tag-name'>${tagName}</span>
        <span class='remove-tag'>x</span>
    `;
    tagsContainer.appendChild(tagDiv);

    // Remove tag when "x" is clicked
    tagDiv.querySelector('.remove-tag').addEventListener('click', () => {
        tagDiv.remove();
        currentTags = currentTags.filter(tag => tag !== tagName);
        updateTagCounter();
        
        // Show "no tags" message if all are removed
        if (currentTags.length === 0) {
            showNoTagsMessage();
        }
    });
}

// ========== UI Helpers ========== //
function showTagLimitWarning() {
    const existingWarning = document.getElementById('tag-limit-warning');
    if (existingWarning) existingWarning.remove();
    
    const warning = document.createElement('div');
    warning.id = 'tag-limit-warning';
    warning.textContent = `Maximum ${MAX_TAGS} tags allowed`;
    warning.style.color = '#ff4444';
    warning.style.padding = '0.5rem';
    warning.style.fontSize = '0.8rem';
    warning.style.fontWeight = 'bold';
    
    tagsContainer.appendChild(warning);
    setTimeout(() => warning.remove(), 3000);
}

function updateTagCounter() {
    const existingCounter = document.getElementById('tag-counter');
    if (existingCounter) existingCounter.remove();
    
    const counter = document.createElement('div');
    counter.id = 'tag-counter';
    counter.textContent = `${currentTags.length}/${MAX_TAGS} tags`;
    counter.style.color = currentTags.length >= MAX_TAGS ? '#ff4444' : '#666';
    counter.style.padding = '0.5rem';
    counter.style.fontSize = '0.8rem';
    counter.style.fontStyle = 'italic';
    
    tagsContainer.appendChild(counter);
}

// ========== Save Tags ========== //
function saveTags(article_id) {
    if (currentTags.length === 0 && !confirm('Continue without tags?')) return;
    
    $.ajax({
        url: 'php-backend/save-tags.php',
        type: 'POST',
        dataType: 'json',
        data: { article_id: article_id, tags: currentTags },
        success: (res) => {
            if (res.success) {
                alert('Tags saved!');
                updateDateUpdated(article_id, "Article Tags modified");
                loadAssignedTags(article_id); // Refresh tags from server
            }
        },
        error: (err) => console.error(err)
    });
}

// ========== Initialize ========== //
document.getElementById('save-tags-button').addEventListener('click', () => {
    saveTags(article_id);
});

loadAssignedTags(article_id); // Load tags on page load