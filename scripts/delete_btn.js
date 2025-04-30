function makeDeleteButton(section) {
    // More Options
    const deleteBtn = document.createElement('img');
    deleteBtn.src = '../svg/delete.svg';
    deleteBtn.className = 'del-article-btn';
    deleteBtn.style.width = '1.5em';
    deleteBtn.style.cursor = 'pointer';
    deleteBtn.style.backgroundColor = 'red';
    deleteBtn.style.borderRadius = '3px';
    deleteBtn.style.padding = '5px';
    deleteBtn.style.transition = '0.2s ease-in-out'
    deleteBtn.setAttribute('data-section-id', section.section_id);

    deleteBtn.addEventListener('click', () => {
        const container = document.createElement('div');
        container.style.width = '100vw';
        container.style.height = '100vh';
        container.style.display = 'flex';
        container.style.flexDirection = 'column';
        container.style.justifyContent = 'center';
        container.style.alignItems = 'center';
        container.style.backgroundColor = 'rgba(0, 0, 0, 0.7)';
        container.style.position = 'absolute';

        const areYouSure = document.createElement('div');
        areYouSure.style.display = 'flex';
        areYouSure.style.flexDirection = 'column';
        areYouSure.style.backgroundColor = 'white';
        areYouSure.style.width = '30vw';
        areYouSure.style.height = '20vh';
        areYouSure.style.position = 'absolute';
        areYouSure.style.borderRadius = '3px';
        areYouSure.style.padding = '30px';
        areYouSure.style.justifyContent = 'center';
        areYouSure.style.alignItems = 'center';
        areYouSure.style.gap = '30px';


        const warningText = document.createElement('p');
        warningText.textContent = `Are you sure on deleting this Article?`;
        warningText.style.textAlign = 'center';

        areYouSure.appendChild(warningText);

        const buttonContainer = document.createElement('div');
        buttonContainer.style.display = 'flex';
        buttonContainer.style.gap = '30px';
        buttonContainer.style.justifyContent = 'center';
        buttonContainer.style.alignItems = 'center';

        const cancelDel = document.createElement('button');
        cancelDel.textContent = 'Cancel';
        cancelDel.style.backgroundColor = 'red';
        cancelDel.style.padding = '7px';
        cancelDel.style.color = 'white';
        cancelDel.style.border = 'none';
        cancelDel.style.borderRadius = '3px';

        cancelDel.addEventListener('click', () => {
            container.remove();
        });

        buttonContainer.appendChild(cancelDel);

        const confirmDel = document.createElement('button');
        confirmDel.textContent = 'Confirm'
        confirmDel.style.backgroundColor = 'green';
        confirmDel.style.padding = '7px';
        confirmDel.style.color = 'white';
        confirmDel.style.border = 'none';
        confirmDel.style.borderRadius = '3px';

        confirmDel.addEventListener('click', () => {
            $.ajax({
                type: 'POST',
                url: '../php-backend/delete_article_page.php',
                dataType: 'json',
                data: {
                    section_id: section.section_id
                },
                success: function (res) {

                    const editDetSect = Array.from(document.querySelectorAll('*')).find(el =>
                        el.getAttribute('edit-det-section-id') == section.section_id
                    );

                    editDetSect.remove();

                    const livePrevSect = Array.from(document.querySelectorAll('*')).find(el =>
                        el.getAttribute('prev-section-id') == section.section_id
                    );

                    livePrevSect.remove();

                },

                error: function (error) {
                    console.log("Error on Adding Delete Event," + error);
                }
            });

            container.remove();
        });

        document.addEventListener('keydown', (e) => {
            if (e.key = 'Escape') container.remove();
        });

        buttonContainer.appendChild(confirmDel);

        areYouSure.appendChild(buttonContainer);
        container.appendChild(areYouSure);

        document.body.prepend(container);

    });

    return deleteBtn;
}