<?php
// View/paginaPersonalizacao.php

// Força a exibição de erros para ajudar no diagnóstico.
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inicia a sessão para garantir que os dados das etapas anteriores estejam acessíveis.
session_start();

// Proteção: Se o usuário pulou as etapas anteriores, redireciona para o início do cadastro.
if (!isset($_SESSION['cadastro_etapa1']) || !isset($_SESSION['cadastro_etapa2'])) {
    header('Location: paginaDeCadastro.php');
    exit;
}

// Inclui o controller que contém a lógica de negócio.
require_once __DIR__ . '/../Controller/UserController.php';

$erro = null; // Inicializa a variável de erro.

// Verifica se o formulário foi submetido via POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Controller\UserController();
    
    // ====================================================================
    // A CORREÇÃO ESTÁ AQUI:
    // Passamos os arrays globais $_POST e $_FILES diretamente para o controller.
    // O controller agora é responsável por extrair 'userName', 'userDescricao', e a foto.
    // ====================================================================
    $erro = $controller->processarEtapa3($_POST, $_FILES);
    
    // Se o método processarEtapa3 for bem-sucedido, ele mesmo fará o redirecionamento
    // e encerrará o script com 'exit'. Portanto, não precisamos de um 'if ($erro === null)' aqui.
    // O script só continuará a ser executado se o método retornar uma string de erro.
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Cadastro - Etapa Final</title>
    <link rel="stylesheet" href="../Templates/css/paginaPersonalizacao.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <a href="index.php">
            <figure>
                <img src="../Images/Ícones do header/Logo ClassAi branca.png" alt="Logo ClassAi">
            </figure>
        </a>
    </header>

    <div class="container">
        <main>
            <div class="conteudo_principal">
                <!-- O formulário precisa do atributo 'enctype' para que o upload de arquivos funcione -->
                <form action="paginaPersonalizacao.php" method="POST" class="formulario" enctype="multipart/form-data">
                    <h1>Vamos deixar com a sua cara agora!</h1>
                    <h2>Seus dados estão protegidos!</h2>

                    <!-- Bloco para exibir a mensagem de erro, se houver -->
                    <?php if ($erro ): ?>
                        <div style="color: red; background-color: #ffdddd; border: 1px solid red; padding: 10px; margin: 15px 0; border-radius: 5px; text-align: center; font-weight: bold;">
                            <?php echo htmlspecialchars($erro); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-layout">
                        <div class="top-row">
                            <div class="upload-container">
                                <!-- O 'name' do input deve corresponder ao que o controller espera ('profile_photo') -->
                                <input type="file" id="foto-perfil" name="profile_photo" accept="image/*" style="display: none;">
                                <label for="foto-perfil" class="upload-label">
                                    <i class="bi bi-plus"></i>
                                    <img id="imagePreview" src="#" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; display: none;" />
                                </label>
                            </div>
                            <div class="field-wrapper">
                                <!-- O 'name' do input deve corresponder ao que o controller espera ('username') -->
                                <input type="text" name="username" class="userName form-control" placeholder="Usuário" required>
                                <small class="msg-erro nome-erro" style="display:none; color:red;">Por favor, digite seu nome de usuário.</small>
                            </div>
                        </div>
                        <div class="bottom-row">
                             <!-- O 'name' do input deve corresponder ao que o controller espera ('description') -->
                            <textarea name="description" class="userDescription form-control" placeholder="Descrição"></textarea>
                        </div>
                    </div>

                    <div class="buttons">
                        <button class="entrar" type="submit" id="btnCadastrar">Finalizar</button>
                    </div>
                </form>

                <div class="lazzo">
                    <figure>
                        <img class="lazzoImg" src="../Images/Login/lazzoPf.png" alt="Lazzo">
                    </figure>
                </div>
            </div>
        </main>
    </div>

    <script src="../Templates/js/paginaPersonalizacao.js"></script>
</body>
</html>
