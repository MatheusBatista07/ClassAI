document.addEventListener('DOMContentLoaded', function() {
    const accordion = document.querySelector('.accordion');
    const faqSection = document.querySelector('.faq-list-section');

    if (accordion && faqSection) {
        accordion.addEventListener('scroll', function() {
  
            const isAtEnd = accordion.scrollTop + accordion.clientHeight >= accordion.scrollHeight - 1;

            if (isAtEnd) {
               
                faqSection.classList.add('scrolled-to-end');
            } else {
        
                faqSection.classList.remove('scrolled-to-end');
            }
        });

   
        const needsScroll = accordion.scrollHeight > accordion.clientHeight;
        if (!needsScroll) {
            faqSection.classList.add('scrolled-to-end');
        }
    }
});
