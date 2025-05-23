 document.addEventListener('DOMContentLoaded', function() {
        const readMoreLinks = document.querySelectorAll('.read-more');
        
        readMoreLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const container = this.closest('.ql-editor');
                const limited = container.querySelector('.limited-content');
                const full = container.querySelector('.full-content');
                
                limited.style.display = 'none';
                full.style.display = 'block';
                
                // Scroll to the top of the article content
                container.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        });
    });