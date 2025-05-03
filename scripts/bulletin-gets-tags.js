console.log("Script loaded!"); //added line for confirmations
const filterTags = document.getElementById('filter-tags');

$.ajax({
    url: 'php-backend/bulletin-get-tags.php', //removed ../
    type: 'get',
    dataType: 'json',
    data: {},
    success: (res) => {
        console.log("Tags response:", res); //added line for confirmations

        function getTags() {
            const tags = res.tags
            tags.forEach(tag => {
                const buttonTag = document.createElement('button');
                buttonTag.className = 'tag';
                buttonTag.textContent = tag.tag_name;
                filterTags.appendChild(buttonTag);
            });

        }

        getTags();
    },
    error: (error) => {
        console.log(error);
    }
});