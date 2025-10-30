document.addEventListener('DOMContentLoaded', function() {

    const courseCards = document.querySelectorAll('.course-card');

    
    courseCards.forEach(card => {
        
        const likeIcon = card.querySelector('::after'); 
        
    
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

});


function sendLike(courseId, isLiked) {
    console.log(`Curso ${courseId} foi ${isLiked ? 'curtido' : 'descurtido'}`);

    fetch('/user/like', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest' 
        },
        body: JSON.stringify({
            course_id: courseId,
            liked: isLiked
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Ação registrada com sucesso no servidor!');
        } else {
            console.error('Falha ao registrar a ação.');
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
    });
}
