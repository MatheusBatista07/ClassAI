document.addEventListener('DOMContentLoaded', function() {

    const courseCards = document.querySelectorAll('.course-card');
    
    courseCards.forEach(card => {
        const courseId = card.dataset.courseId;

        card.addEventListener('click', function(event) {
            const heartRect = card.getBoundingClientRect();
            const heartSize = 32; 
            const heartX = heartRect.right - 16 - (heartSize / 2);
            const heartY = heartRect.top + 16 + (heartSize / 2);
            const distance = Math.sqrt(Math.pow(event.clientX - heartX, 2) + Math.pow(event.clientY - heartY, 2));

            if (distance < heartSize / 2) { 
                event.preventDefault(); 
                event.stopPropagation();

                card.classList.toggle('liked');
                sendLike(courseId, card.classList.contains('liked'));
            }
        });
    });

    function sendLike(courseId, isLiked) {
        console.log(`Curso ${courseId} foi ${isLiked ? 'curtido' : 'descurtido'}`);
    }

    const container = document.getElementById('trending-courses-container');
    const prevButton = document.getElementById('carousel-prev');
    const nextButton = document.getElementById('carousel-next');

    if (container && prevButton && nextButton) {

        prevButton.addEventListener('click', function(event) {
            event.preventDefault();
            const scrollAmount = container.querySelector('.course-card').offsetWidth + 24;
            container.scrollBy({
                left: -scrollAmount,
                behavior: 'smooth'
            });
        });

        nextButton.addEventListener('click', function(event) {
            event.preventDefault();
            const scrollAmount = container.querySelector('.course-card').offsetWidth + 24;
            container.scrollBy({
                left: scrollAmount,
                behavior: 'smooth'
            });
        });

        function updateCarouselButtons() {
            if (!container.querySelector('.course-card')) return;
            
            const maxScrollLeft = container.scrollWidth - container.clientWidth;
            
            prevButton.classList.toggle('active', container.scrollLeft > 0);
            nextButton.classList.toggle('active', container.scrollLeft < maxScrollLeft - 5);
        }

        container.addEventListener('scroll', updateCarouselButtons);
        
        new ResizeObserver(updateCarouselButtons).observe(container);

        updateCarouselButtons();
    }

});
