const filterTags = document.getElementById('filter-tags');

$.ajax({
    url: 'php-backend/bulletin-get-tags.php',
    type: 'get',
    dataType: 'json',
    data: {},
    success: (res) => {
        const tags = res.tags
        tags.forEach(tag => {
            const buttonTag = document.createElement('button');
            buttonTag.className = 'tag';
            buttonTag.textContent = tag.tag_name;
            buttonTag.setAttribute('tag-id', tag.tag_id);
            filterTags.appendChild(buttonTag);
        });
    },
    error: (error) => {
        console.log(error);
    }
});