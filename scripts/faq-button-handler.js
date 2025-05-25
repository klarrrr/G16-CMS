// Floating FAQ functionality
document.addEventListener('DOMContentLoaded', function() {
    const faqFloatBtn = document.getElementById('faqFloatBtn');
    const faqFloatContainer = document.getElementById('faqFloatContainer');
    const faqFloatClose = document.getElementById('faqFloatClose');
    
    // Toggle FAQ container
    faqFloatBtn.addEventListener('click', function() {
        faqFloatContainer.classList.toggle('show');
    });
    
    // Close FAQ container
    faqFloatClose.addEventListener('click', function() {
        faqFloatContainer.classList.remove('show');
    });
    
    // Close when clicking outside
    document.addEventListener('click', function(event) {
        if (!faqFloatContainer.contains(event.target)) {
            if (event.target !== faqFloatBtn) {
                faqFloatContainer.classList.remove('show');
            }
        }
    });
    
    // FAQ card toggle functionality
    const faqCards = document.querySelectorAll('.faq-card');
    
    faqCards.forEach(card => {
        const toggleBtn = card.querySelector('.faq-card-toggle');
        
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent card click from triggering
            card.classList.toggle('active');
            
            // Close other cards when opening a new one
            if (card.classList.contains('active')) {
                faqCards.forEach(otherCard => {
                    if (otherCard !== card && otherCard.classList.contains('active')) {
                        otherCard.classList.remove('active');
                    }
                });
            }
        });
        
        // Optional: Click anywhere on card to toggle (uncomment if desired)
        /*
        card.addEventListener('click', function() {
            this.classList.toggle('active');
        });
        */
    });
});