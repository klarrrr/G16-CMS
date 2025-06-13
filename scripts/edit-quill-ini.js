const quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: '#create-nav-two'
    },
    history: {
        delay: 2000,
        maxStack: 500,
        userOnly: true
    }
});

$('#custom-video-button').on('click', function () {
    const input = $('<input type="file" accept="video/mp4,video/webm,video/ogg">');
    input.trigger('click');

    input.on('change', function () {
        const file = this.files[0];
        if (file) {
            const formData = new FormData();
            formData.append('video', file);

            $.ajax({
                url: 'php-backend/upload-video.php', 
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    const res = JSON.parse(response);
                    if (res.success) {
                        let range = quill.getSelection();
                        if (!range) {
                            range = {
                                index: quill.getLength(),
                                length: 0
                            };
                        }
                        quill.insertEmbed(range.index, 'customVideo', res.url);
                        quill.setSelection(range.index + 1);
                        updateDateUpdated(article_id, "Inserted a Video");
                    } else {
                        alert('Upload failed: ' + res.error);
                    }
                },
                error: function (error) {
                    alert('An error occurred while uploading.' + error);
                }
            });
        }
    });
});


let previousVideos = new Set();

// Get all current video URLs
function getCurrentVideos() {
    return new Set(
        Array.from(quill.root.querySelectorAll('video source')).map(source => source.src)
    );
}

// Listen for text-change events
quill.on('text-change', function () {
    const currentVideos = getCurrentVideos();

    // Find deleted video URLs
    for (const url of previousVideos) {
        if (!currentVideos.has(url)) {
            // Video was deleted
            $.post('php-backend/delete-video.php', {
                url: url
            }, function (res) {
                const response = JSON.parse(res);
                if (!response.success) {
                    console.warn('Delete failed:', response.error);
                }
            });
        }
    }
    previousVideos = currentVideos;
});