const existingTags = document.getElementById('filter-tags');

let selectedTags = [];

existingTags.addEventListener('click', function (event) {
    if (event.target && event.target.classList.contains('tag')) {
        event.target.classList.toggle('selected');

        const tagId = event.target.getAttribute('tag-id');

        if (event.target.classList.contains('selected')) {
            selectedTags.push(tagId);
        } else {
            selectedTags = selectedTags.filter(tag => tag !== tagId);
        }

        if (selectedTags.length == 0) {
            loadSearchData(1, '');
        } else {
            loadNewsByTags(1, selectedTags);
        }
    }
});

