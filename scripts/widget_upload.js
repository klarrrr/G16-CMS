document.getElementById('thumbnailInput').addEventListener('change', function () {
    const file = this.files[0];
    const articleOwnerId = 69;
    const userOwnerId = 3;

    if (file) {
        const reader = new FileReader();
        reader.onloadend = function () {
            const base64String = reader.result.replace("data:", "").replace(/^.+,/, "");

            fetch('php-backend/save_thumbnail.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    widget_img: base64String,
                    article_owner: articleOwnerId,
                    user_owner: userOwnerId
                })
            })
                .then(res => res.text())
                .then(response => {
                    if (!isNaN(response)) {
                        const uploadedFile = document.getElementById('uploadedFile');
                        uploadedFile.innerHTML = `
                        <div class="thumbnail-container">
                            <img src="data:image/jpeg;base64,${base64String}" class="thumbnail-img" />
                            <button class="delete-btn" onclick="deleteImage(${response})">x</button>
                        </div>
                    `;
                    } else {
                        alert("Failed to upload image: " + response);
                    }
                });
        };
        reader.readAsDataURL(file);
    }
});

function deleteImage(id) {
    fetch('php-backend/delete_thumbnail.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
        .then(res => res.text())
        .then(response => {
            alert(response);
            document.getElementById('uploadedFile').innerHTML = "";
            document.getElementById('thumbnailInput').value = "";
        });
}

