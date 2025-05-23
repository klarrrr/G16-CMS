document.addEventListener('DOMContentLoaded', function() {
    const readMoreLinks = document.querySelectorAll('.read-more');

    readMoreLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const container = this.closest('.ql-editor');
            const limited = container.querySelector('.limited-content');
            const full = container.querySelector('.full-content');
            const articleContainer = container.closest('#article-information');

            if (full.classList.contains('show')) {
                // Collapse with transition
                full.classList.remove('show');
                this.textContent = 'Read More';
                setTimeout(() => {
                    limited.style.display = 'block';
                }, 500); // Match the CSS transition duration
            } else {
                // Expand with transition
                limited.style.display = 'none';
                full.classList.add('show');
                this.textContent = 'Show Less';
            }

            // Scroll to top of the article
            const articleTop = articleContainer.getBoundingClientRect().top + window.pageYOffset;
            window.scrollTo({
                top: articleTop - 20,
                behavior: 'smooth'
            });
        });
    });
});
