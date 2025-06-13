document.addEventListener('DOMContentLoaded', function () {
    const faqFloatBtn = document.getElementById('faqFloatBtn');
    const faqFloatContainer = document.getElementById('faqFloatContainer');
    const faqFloatClose = document.getElementById('faqFloatClose');

    // Toggle FAQ container
    faqFloatBtn.addEventListener('click', function (e) {
        faqFloatContainer.classList.toggle('show');
        e.stopPropagation();
    });

    faqFloatContainer.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Close FAQ container
    faqFloatClose.addEventListener('click', function (e) {
        faqFloatContainer.classList.remove('show');
        e.stopPropagation();
    });

    // Close when clicking outside
    document.addEventListener('click', function (event) {
        if (!faqFloatContainer.contains(event.target) && event.target !== faqFloatBtn) {
            faqFloatContainer.classList.remove('show');
        }
    });

    // FAQ card toggle functionality
    const faqCards = document.querySelectorAll('.faq-card');

    faqCards.forEach(card => {
        card.addEventListener('click', function (e) {
            e.stopPropagation();

            const isActive = card.classList.contains('active');

            faqCards.forEach(c => {
                c.classList.remove('active');
                const toggleIcon = c.querySelector('.faq-card-toggle');
                if (toggleIcon) toggleIcon.textContent = '+';
            });

            if (!isActive) {
                card.classList.add('active');
                const toggleIcon = card.querySelector('.faq-card-toggle');
                if (toggleIcon) toggleIcon.textContent = '–';
            }
        });
    });
});
