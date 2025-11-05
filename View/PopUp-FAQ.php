<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI - Área de Ajuda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Crie um novo arquivo CSS para esta página -->
    <link rel="stylesheet" href="../Templates/css/PopUpFAQ.css">
</head>

<body>

    <div class="faq-container">
        <!-- Cabeçalho -->
        <header class="faq-header">
            <a href="#" class="back-button"><i class="bi bi-chevron-left"></i></a>
            <h1 class="header-title">Área De Ajuda</h1>
        </header>

        <main class="faq-content">
            <!-- Seção de Introdução e Busca -->
            <section class="intro-section">
                <h2>Estamos aqui para ajudar você, qual a sua Dúvida?</h2>
                <p>O ClassAI fornece total suporte a você! Compartilhe sua preocupação ou verifique nossas perguntas frequentes listadas abaixo.</p>
                <div class="search-bar">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Pesquisar dúvidas">
                </div>
            </section>

            <!-- Seção do FAQ (Accordion ) -->
            <section class="faq-list-section">
                <h3 class="faq-subtitle">FAQ</h3>
                <div class="accordion" id="faqAccordion">
                    <!-- Item 1 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                O que é o ClassAI?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                O ClassAI é uma plataforma de aprendizado online que utiliza inteligência artificial para personalizar a experiência de estudo, oferecendo cursos interativos, suporte automatizado e trilhas de conhecimento adaptadas ao seu perfil.
                            </div>
                        </div>
                    </div>
                    <!-- Item 2 -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                Como funciona o sistema de cursos?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Nosso sistema oferece uma vasta biblioteca de cursos. Você pode se matricular, assistir às aulas em vídeo, completar atividades práticas e interagir com instrutores e outros alunos. Seu progresso é salvo automaticamente.
                            </div>
                        </div>
                    </div>
                    <!-- Adicione os outros itens do FAQ aqui seguindo o mesmo modelo -->
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                Como consigo a certificação?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Ao concluir 100% das aulas e atividades de um curso, o certificado de conclusão é gerado automaticamente e fica disponível para download na sua área de "Certificados".
                            </div>
                        </div>
                    </div>
                    <!-- Item 4 -->
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
            Quantos cursos posso acessar?
        </button>
    </h2>
    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
            Isso depende do seu plano. Oferecemos tanto a compra de cursos avulsos quanto planos de assinatura mensal ou anual com acesso ilimitado a toda a nossa biblioteca de cursos.
        </div>
    </div>
</div>

<!-- Item 5 -->
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
            A onde tiro dúvidas com a instrutor(a)?
        </button>
    </h2>
    <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
            Cada curso possui uma seção de "Perguntas e Respostas" onde você pode postar suas dúvidas. Os instrutores e a comunidade de alunos respondem ativamente para ajudar.
        </div>
    </div>
</div>

<!-- Item 6 -->
<div class="accordion-item">
    <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix">
            Como consigo virar um instrutor do ClassAI?
        </button>
    </h2>
    <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
        <div class="accordion-body">
            Ficamos felizes com seu interesse! Você pode se candidatar através da nossa página "Seja um Instrutor". Analisaremos seu perfil, experiência e proposta de curso.
        </div>
    </div>
</div>
                </div>
            </section>

            <!-- Seção de Contato -->
            <section class="contact-section">
                <h4>Encontrou problemas? Envie um e-mail</h4>
                <button class="btn-submit">Enviar Mensagem</button>
            </section>
        </main>
    </div>

    <!-- Scripts do Bootstrap (essencial para o accordion funcionar) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script src="../Templates/js/PaginaFAQ.js"></script>
</body>

</html>
