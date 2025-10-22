<?php
    $pageTitle = "Política de Privacidade e Termos de Uso";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> - ClassAI</title>
    <link rel="stylesheet" href="../templates/Css/PoliticaPrivacidade.css">
</head>
<body>

    <!-- Elemento para o fundo de partículas -->
    <div id="particles-js"></div>

    <div class="main-container">
        <header class="header">
            <a href="PaginaInicial.php" class="back-button">&larr;</a>
            <div class="logo">Class<span>/</span>AI</div>
            <div class="placeholder"></div>
        </header>

        <nav class="nav-tabs">
            <button id="btn-privacy" class="tab-button active">Política de Privacidade</button>
            <button id="btn-terms" class="tab-button">Termos de Uso</button>
        </nav>

        <div class="content">
            <!-- Seção de Política de Privacidade -->
            <section id="privacy" class="content-section active">
                <h2>Política de Privacidade</h2>
                <h3>1. Coleta de Dados</h3>
                <p>Coletamos informações que você nos fornece diretamente ao se cadastrar, como nome, e-mail e senha. Também podemos coletar dados de uso da plataforma, como cursos acessados, progresso e interações, para melhorar sua experiência.</p>
                <h3>2. Uso das Informações</h3>
                <p>As informações coletadas são utilizadas para:</p>
                <ul>
                    <li>Personalizar sua experiência de aprendizado.</li>
                    <li>Processar inscrições e matrículas nos cursos.</li>
                    <li>Enviar comunicações importantes sobre a plataforma.</li>
                    <li>Analisar o uso do serviço para realizar melhorias contínuas.</li>
                </ul>
                <h3>3. Compartilhamento de Dados</h3>
                <p>Não compartilhamos suas informações pessoais com terceiros, exceto quando necessário para a operação do serviço (ex: processadores de pagamento) ou se exigido por lei. Seus dados de progresso podem ser usados de forma anônima para estatísticas.</p>
                <h3>4. Segurança</h3>
                <p>Empregamos medidas de segurança robustas para proteger seus dados contra acesso não autorizado, alteração ou destruição. No entanto, nenhum método de transmissão pela internet é 100% seguro.</p>
            </section>

            <!-- Seção de Termos de Uso -->
            <section id="terms" class="content-section">
                <h2>Termos de Uso</h2>
                <h3>1. Aceitação dos Termos</h3>
                <p>Ao acessar e usar a plataforma ClassAI, você concorda em cumprir estes Termos de Uso e todas as leis e regulamentos aplicáveis. Se você não concorda, não está autorizado a usar a plataforma.</p>
                <h3>2. Uso da Plataforma</h3>
                <p>Você concorda em usar a ClassAI apenas para fins lícitos e de acordo com as funcionalidades oferecidas. É proibido:</p>
                <ul>
                    <li>Distribuir, copiar ou revender o conteúdo dos cursos.</li>
                    <li>Tentar obter acesso não autorizado aos nossos sistemas.</li>
                    <li>Usar a plataforma para qualquer atividade fraudulenta ou maliciosa.</li>
                </ul>
                <h3>3. Propriedade Intelectual</h3>
                <p>Todo o conteúdo disponível na ClassAI, incluindo vídeos, textos, imagens e o próprio software, é de propriedade exclusiva da ClassAI ou de seus licenciadores e protegido por leis de direitos autorais.</p>
                <h3>4. Limitação de Responsabilidade</h3>
                <p>A plataforma é fornecida "como está". Não garantimos que o serviço será ininterrupto ou livre de erros. Em nenhuma circunstância a ClassAI será responsável por quaisquer danos diretos ou indiretos resultantes do uso ou da incapacidade de usar o serviço.</p>
            </section>
        </div>
    </div>

    <!-- Biblioteca Particles.js -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
    
    <!-- Seu script principal -->
    <script src="../templates/js/PoliticaPrivacidade.js"></script>
</body>
</html>
