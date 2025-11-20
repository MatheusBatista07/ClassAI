<?php
// Arquivo: index.php (VERSÃO COMPLETA E CORRIGIDA)

// --- 1. CONFIGURAÇÃO E LÓGICA PHP ---
define('ROOT_PATH', __DIR__);
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_name = str_replace('index.php', '', $_SERVER['SCRIPT_NAME'] );
define('BASE_URL', $protocol . "://" . $host . $script_name);

// Carrega as configurações (DB, Pusher, e a chave da Groq que adicionamos)
require_once ROOT_PATH . '/Config/Configuration.php';

// Pega a 'view' e a 'action' da URL. Se não existirem, usa valores padrão.
$view = $_GET['view'] ?? 'home';
$action = $_GET['action'] ?? null;

// --- ROTEAMENTO DE AÇÕES (API) ---
// Se a URL contiver ?action=askLazo, o código abaixo é executado e o script para.
if ($action === 'askLazo') {
    require_once ROOT_PATH . '/Controller/LazoController.php';
    $userController = new UserController();
    $userController->askLazo();
    exit; // Essencial: impede que o HTML da página seja enviado como resposta para a API.
}

// --- ROTEAMENTO DE PÁGINAS (VIEWS) ---
// Se a URL pedir uma view específica (ex: ?view=painel), carrega o arquivo da view e para.
if ($view !== 'home') {
    $view_file = ROOT_PATH . '/View/' . $view . '.php';
    if (file_exists($view_file)) {
        require_once $view_file;
    } else {
        // Se o arquivo da view não for encontrado, mostra um erro simples.
        http_response_code(404 );
        echo "<h1>Erro 404</h1><p>Página não encontrada.</p>";
    }
    // Para a execução aqui para não carregar a landing page por baixo.
    exit;
}

// --- PÁGINA PADRÃO (HOME / LANDING PAGE) ---
// Se nenhuma 'view' foi solicitada na URL, o código chega até aqui e mostra a página de apresentação.
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi</title>
    <link rel="stylesheet" href="Templates/css/Apresentacao.css">
</head>

<body>
    <header>
        <img src="Images/Pagina-de-Apresentacao/Logo_verde.png" alt="Logo ClassAi">
    </header>

    <main class="hero">
        <div class="principal">
            <img src="Images/Pagina-de-Apresentacao/Trabalhador_computador.png"
                alt="Imagem de homem com roupa e capacete de trabalhador mexendo em um computador">
            <div class="txt_principal">
                <h1>Onde o trabalho encontra seu <span style="color: #09FF00">FUTURO!</span></h1>
                <P>Domine a inteligência artificial, se reintegre ao mercado e transforme sua carreira com os cursos da
                    ClassAI — a plataforma que conecta você ao futuro do trabalho com IA.</P>
            </div>
        </div>
        <div class="comecando">
            <a href="#matricula" id="comecar" class="comecar">Começar Agora</a>
            <img src="Images/Pagina-de-Apresentacao/Seta_roxa.png" alt="Duas setas roxas apontadas para baixo">
        </div>

    </main>

    <section class="comentarios">

        <div class="slider">
            <div class="slider-track esquerda">
                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/Maria_Conceição.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>Maria Conceição</h1>
                            <p>Auxiliar administrativa</p>
                        </div>
                    </div>
                    <p class="prcp">No começo eu achei que IA era coisa de filme, mas com a plataforma, entendi como
                        pode me ajudar no dia a dia. Estou usando IA para organizar melhor minhas tarefas e ganhar
                        tempo!</p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/João_Pedro.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>João Pedro</h1>
                            <p>Técnico em Logística</p>
                        </div>
                    </div>
                    <p class="prcp" class="prcp">A plataforma abriu minha mente! Agora sei como usar IA para otimizar
                        rotas e prever demandas no estoque. Nunca pensei que fosse aprender algo tão atual!</p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/Fernanda_Lima.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>Fernanda Lima</h1>
                            <p>Professora</p>
                        </div>
                    </div>
                    <p class="prcp">Achei incrível a forma como os conteúdos são explicados. Simples, direto e com
                        muitos exemplos práticos. Já estou usando IA para planejar minhas aulas de forma mais eficiente.
                    </p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/Maria_Conceição.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>Maria Conceição</h1>
                            <p>Auxiliar administrativa</p>
                        </div>
                    </div>
                    <p class="prcp">No começo eu achei que IA era coisa de filme, mas com a plataforma, entendi como
                        pode me ajudar no dia a dia. Estou usando IA para organizar melhor minhas tarefas e ganhar
                        tempo!</p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/João_Pedro.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>João Pedro</h1>
                            <p>Técnico em Logística</p>
                        </div>
                    </div>
                    <p class="prcp">A plataforma abriu minha mente! Agora sei como usar IA para otimizar rotas e prever
                        demandas no estoque. Nunca pensei que fosse aprender algo tão atual!</p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/Fernanda_Lima.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>Fernanda Lima</h1>
                            <p>Professora</p>
                        </div>
                    </div>
                    <p class="prcp">Achei incrível a forma como os conteúdos são explicados. Simples, direto e com
                        muitos exemplos práticos. Já estou usando IA para planejar minhas aulas de forma mais eficiente.
                    </p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="slider">
            <div class="slider-track direita">
                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/Eduardo_santana.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>Eduardo Santana</h1>
                            <p>Autônomo</p>
                        </div>
                    </div>
                    <p class="prcp">A plataforma me deu uma visão nova do meu negócio. Agora uso IA pra analisar
                        tendências e tomar decisões com mais segurança. Sensacional!</p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/Luciana_Freitas.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>Luciana Freitas</h1>
                            <p>Balconista de Farmácia</p>
                        </div>
                    </div>
                    <p class="prcp">Mesmo com pouco tempo, consigo assistir às aulas e praticar. Já estou usando IA pra
                        responder dúvidas comuns de clientes com mais precisão.</p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/Rogério_Matos.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>Rogério Matos</h1>
                            <p>Segurança Patrimonial</p>
                        </div>
                    </div>
                    <p class="prcp">Nunca imaginei que poderia aprender sobre IA. A plataforma me mostrou como a
                        tecnologia pode me ajudar até na prevenção de riscos no meu trabalho.</p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/Eduardo_santana.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>Eduardo Santana</h1>
                            <p>Autônomo</p>
                        </div>
                    </div>
                    <p class="prcp">A plataforma me deu uma visão nova do meu negócio. Agora uso IA pra analisar
                        tendências e tomar decisões com mais segurança. Sensacional!</p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/Luciana_Freitas.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>Luciana Freitas</h1>
                            <p>Balconista de Farmácia</p>
                        </div>
                    </div>
                    <p class="prcp">Mesmo com pouco tempo, consigo assistir às aulas e praticar. Já estou usando IA pra
                        responder dúvidas comuns de clientes com mais precisão.</p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>

                <div class="card">
                    <div class="foto_txt">
                        <img src="Images/Pagina-de-Apresentacao/Rogério_Matos.png" alt="Imagem de Maria Conceição">
                        <div class="txtt">
                            <h1>Rogério Matos</h1>
                            <p>Segurança Patrimonial</p>
                        </div>
                    </div>
                    <p class="prcp">Nunca imaginei que poderia aprender sobre IA. A plataforma me mostrou como a
                        tecnologia pode me ajudar até na prevenção de riscos no meu trabalho.</p>
                    <div class="estrela">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <img src="Images/Pagina-de-Apresentacao/estrela.png" alt="Estrela roxa">
                        <p>5,0</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="Matricule-se" id="matricula">
        <img class="homem" src="Images/Pagina-de-Apresentacao/Mão_homem.png"
            alt="Mão humana esticada para pegar em outra mão">
        <div class="txt_matricule">
            <h1>Vem aprender IA com a gente também!</h1>
            <img src="Images/Pagina-de-Apresentacao/Linha_verde.png" alt="Linha verde">
            <p>O futuro está chamando! Vamos juntos nessa?</p>
            <a href="View/paginaDeCadastro.php" class="Matricular">Matricule-se</a>
        </div>
        <img class="robô" src="Images/Pagina-de-Apresentacao/Mão_robô.png"
            alt="Mão de um robô estendida para pegar em outra mão">
    </section>

    <section class="lazo">
        <div class="geral">
            <div class="org_esqr">
                <div class="lazo1">
                    <h2>Olá, eu sou a Lazo!</h2>
                    <p>A IA que vai te ajudar a estudar</p>
                </div>

                <div class="lazo2">
                    <p>Servirei como apoio nas aulas e tirarei dúvidas</p>
                </div>
            </div>

            <img src="Images/Pagina-de-Apresentacao/Lazo.png"
                alt="Imagem de Robô branco e roxo usando capacete de trabalhador">

            <div class="org_dir">
                <div class="lazo3">
                    <p>Eu vou te ajudar a se aprofundar nos assuntos que tem mais dificuldade</p>
                </div>

                <div class="lazo4">
                    <p>Além do mais, vou gerar atividades e simulações para te deixar preparado!</p>
                </div>
            </div>
        </div>

    </section>

    <section class="opq">
        <h1 class="primeiroh1">POR QUE ESCOLHER O <span style="color: #09FF00">ClassAI</span>?</h1>

        <div class="progressao">

            <h1>Progressão</h1>
            <div class="txt1">
                <p>Nos preocupamos em construir uma boa base para que o aluno desenvolva dominio sobre IA.</p>
            </div>

            <h2>Outras Escolas</h2>
            <div class="txt2">
                <p>Já começam usando prompt sem o aluno sequer ter conhecimentos sobre.</p>
            </div>
        </div>

        <div class="progressao">
            <h1>Prática</h1>

            <div class="txt1">
                <p>Projetos práticos e muitos exercícios em todas as etapas garantindo ao aluno um conhecimento sólido.
                </p>
            </div>

            <h2>Outras Escolas</h2>
            <div class="txt2">
                <p>Muita vídeo-aula, pouco exercício, pouca repetição, pulam de nível antes da compreensão da matéria.
                </p>
            </div>
        </div>

        <div class="progressao">
            <h1>Vantagens</h1>

            <div class="txt1">
                <p>Uzufruir das tecnologias e desenvolvimento da capacidade de montar seus projetos com total integração
                    com sua área e acelerar seus projetos</p>
            </div>

            <h2>Outras Escolas</h2>
            <div class="txt2">
                <p>Muita vídeo-aula, pouco exercício, pouca repetição, pulam de nível antes da compreensão da matéria.
                </p>
            </div>
        </div>

        <a href="#matricula" class="fzrparte"> Quero fazer parte > </a>

    </section>

    <section class="faleConosco">
        <div class="txtfc">
            <h1 class="algdu">Alguma dúvida?</h1>
            <h1 class="fc">Fale Conosco!</h1>
            <p>Estamos aqui para te ajudar em todas as áreas. O seu futuro está no ClassAI!</p>
        </div>

        <form action="index.php?action=submitFeedback" method="POST" class="form">
            <input name="mensagem" type="text" class="mensagem" placeholder="Digite sua mensagem...">
            <div class="inputss">
                <input name="nome" type="text" class="nome" placeholder="Nome">
                <input name="email" type="text" class="email" placeholder="E-mail">
            </div>
            <button id="envio" type="submit">Enviar</button>

        </form>
    </section>
    <footer>
        <div class="dir">
            <img src="Images/Icones-do-header/Logo-ClassAI-branca.png" alt="Logo do ClassAI branca">
            <div class="redes">
                <img class="zap" src="Images/Pagina-de-Apresentacao/whatsapp.png" alt="Logo Whatsapp">
                <img class="face" src="Images/Pagina-de-Apresentacao/Facebook.png" alt="Logo Facebook">
                <img class="insta" src="Images/Pagina-de-Apresentacao/Instagram.png" alt="Logo Instagram">
            </div>
            <p>Copyright © ClassAI 2025</p>
        </div>

        <div class="pages">
            <div class="red" id="pop-up-indique">
                <p>Indique o ClassAI</p>
                <img src="Images/Pagina-de-Apresentacao/seta_roxa_fina.png" alt="Seta roxa para esquerda">
            </div>
            <div class="red">
                <p>Quem Somos</p>
                <img src="Images/Pagina-de-Apresentacao/seta_roxa_fina.png" alt="Seta roxa para esquerda">
            </div>
            <div class="red">
                <p>Fale Conosco</p>
                <img src="Images/Pagina-de-Apresentacao/seta_roxa_fina.png" alt="Seta roxa para esquerda">
            </div>
            <div class="red">
                <p>Trabalhe no ClassAI</p>
                <img src="Images/Pagina-de-Apresentacao/seta_roxa_fina.png" alt="Seta roxa para esquerda">
            </div>
            <div class="red">
                <p>Política de Privacidade</p>
                <img src="Images/Pagina-de-Apresentacao/seta_roxa_fina.png" alt="Seta roxa para esquerda">
            </div>
        </div>

        <div id="popup-overlay" class="popup-overlay">
            <div class="popup-container">
                <button id="close-popup" class="close-popup-btn">&times;</button>

                <h2>Copiar Link</h2>
                <div class="link-container">
                    <input type="text" id="link-para-copiar" value="www.classai.com.br/pagina-principal" readonly>
                    <button id="copy-button" class="copy-button">
                        <img src="https://api.iconify.design/ph:copy-bold.svg" alt="Copiar">
                    </button>
                </div>
                <span id="copy-feedback" class="copy-feedback"></span>

                <div class="divider"></div>

                <h2>Compartilhar</h2>
                <div class="social-icons">
                    <a href="#" id="native-share-btn" aria-label="Compartilhar genérico"><img src="https://api.iconify.design/material-symbols:share-outline.svg" alt="Compartilhar"></a>
                    <a href="#" aria-label="Compartilhar no WhatsApp"><img src="https://api.iconify.design/ic:baseline-whatsapp.svg" alt="WhatsApp"></a>
                    <a href="#" aria-label="Compartilhar no Gmail"><img src="https://api.iconify.design/logos:google-gmail.svg" alt="Gmail"></a>
                    <a href="#" aria-label="Compartilhar no Facebook"><img src="https://api.iconify.design/logos:facebook.svg" alt="Facebook"></a>
                    <a href="#" aria-label="Compartilhar no Instagram"><img src="https://api.iconify.design/skill-icons:instagram.svg" alt="Instagram"></a>
                </div>
            </div>
        </div>
        </div>
    </footer>
</body>
<script src="Templates/js/Apresentacao.js"></script>
<script src="Templates/js/Pop-up-indique.js"></script>

</html>
