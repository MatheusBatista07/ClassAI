document.addEventListener('DOMContentLoaded', () => {
    const quizBody = document.getElementById('quiz-body');
    const questionBlocks = document.querySelectorAll('.question-block');
    const prevBtn = document.getElementById('prev-btn');
    const nextBtn = document.getElementById('next-btn');
    const finishBtn = document.getElementById('finish-btn');
    const progressBar = document.getElementById('progress-bar');
    const progressText = document.getElementById('progress-text');
    const resultContainer = document.getElementById('result-container');
    const scoreSpan = document.getElementById('score');
    const feedbackList = document.getElementById('feedback-list');

    let currentQuestionIndex = 0;
    const totalQuestions = questionBlocks.length;
    const userAnswers = new Array(totalQuestions).fill(null);

    function showQuestion(index) {
        questionBlocks.forEach((block, i) => {
            block.classList.toggle('active', i === index);
        });
        updateProgress();
        updateNavigation();
    }

    function updateProgress() {
        const progressPercentage = ((currentQuestionIndex + 1) / totalQuestions) * 100;
        progressBar.style.width = `${progressPercentage}%`;
        progressText.textContent = `Questão ${currentQuestionIndex + 1} de ${totalQuestions}`;
    }

    function updateNavigation() {
        prevBtn.disabled = currentQuestionIndex === 0;
        if (currentQuestionIndex === totalQuestions - 1) {
            nextBtn.style.display = 'none';
            finishBtn.style.display = 'inline-block';
        } else {
            nextBtn.style.display = 'inline-block';
            finishBtn.style.display = 'none';
        }
    }

    function handleOptionClick(event) {
        const selectedOption = event.currentTarget;
        const questionBlock = selectedOption.closest('.question-block');
        const optionsContainer = questionBlock.querySelector('.options-container');

        if (optionsContainer.classList.contains('disabled')) {
            return;
        }

        questionBlock.querySelectorAll('.option').forEach(opt => opt.classList.remove('selected'));
        selectedOption.classList.add('selected');

        const isCorrect = selectedOption.dataset.correct === 'true';
        
        userAnswers[currentQuestionIndex] = {
            question: questionBlock.querySelector('.question-title').textContent,
            selected: selectedOption.textContent.trim(),
            isCorrect: isCorrect,
            correctAnswer: ''
        };

        optionsContainer.classList.add('disabled');
        selectedOption.classList.add(isCorrect ? 'correct' : 'wrong');

        if (!isCorrect) {
            const correctOption = questionBlock.querySelector('.option[data-correct="true"]');
            correctOption.classList.add('correct');
            userAnswers[currentQuestionIndex].correctAnswer = correctOption.textContent.trim();
        }
    }

    function showResults() {
        quizBody.style.display = 'none';
        document.querySelector('.quiz-navigation').style.display = 'none';
        document.querySelector('.quiz-header').style.display = 'none';
        resultContainer.style.display = 'block';

        let score = 0;
        feedbackList.innerHTML = '';

        userAnswers.forEach(answer => {
            if (answer && answer.isCorrect) {
                score++;
            }
            
            if (answer) {
                const feedbackItem = document.createElement('div');
                feedbackItem.classList.add('feedback-item', answer.isCorrect ? 'correct' : 'wrong');
                
                let feedbackHTML = `<p>${answer.question}</p>`;
                if (answer.isCorrect) {
                    feedbackHTML += `<span>Sua resposta: ${answer.selected} (Correta!)</span>`;
                } else {
                    feedbackHTML += `<span>Sua resposta: ${answer.selected} (Incorreta)</span>`;
                    feedbackHTML += `<span>Resposta correta: ${answer.correctAnswer}</span>`;
                }
                feedbackItem.innerHTML = feedbackHTML;
                feedbackList.appendChild(feedbackItem);
            }
        });

        scoreSpan.textContent = score;
    }

    nextBtn.addEventListener('click', () => {
        if (currentQuestionIndex < totalQuestions - 1) {
            currentQuestionIndex++;
            showQuestion(currentQuestionIndex);
        }
    });

    prevBtn.addEventListener('click', () => {
        if (currentQuestionIndex > 0) {
            currentQuestionIndex--;
            showQuestion(currentQuestionIndex);
        }
    });

    finishBtn.addEventListener('click', showResults);

    document.querySelectorAll('.option').forEach(option => {
        option.addEventListener('click', handleOptionClick);
    });

    showQuestion(currentQuestionIndex);
});
