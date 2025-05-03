const existingTags = document.getElementById('filter-tags');

let selectedTags = [];

// Event delegation: delegate click events to the parent container
existingTags.addEventListener('click', function(event) {
    if (event.target && event.target.classList.contains('tag')) {
        // Toggle the 'selected' class for the clicked button
        event.target.classList.toggle('selected');
        
        // Add or remove the tag from the selectedTags array
        const tagText = event.target.textContent.trim();
        
        if (event.target.classList.contains('selected')) {
            // If the tag is selected, add it to the array
            selectedTags.push(tagText);
        } else {
            // If the tag is deselected, remove it from the array
            selectedTags = selectedTags.filter(tag => tag !== tagText);
        }
        
        loadNewsByTags(1, selectedTags.join(', '));
    }
});

