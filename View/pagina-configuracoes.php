<?php
require_once __DIR__ . '/../auth.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI | Configurações</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/ClassAI/Templates/css/PaginaHome.css">
    <link rel="stylesheet" href="/ClassAI/Templates/css/pagina-configuracoes.css">
</head>

<body>

    <?php require_once __DIR__ . '/_sidebar.php'; // AGORA USANDO A SIDEBAR UNIVERSAL ?>

    <div class="main-content">
        <?php require_once __DIR__ . '/_header.php'; ?>

        <main class="container mt-4">
            <h1 class="mb-4">Configurações</h1>

            <?php
            if (isset($_GET['status']  )) {
                $status = $_GET['status'];
                $msg_code = $_GET['msg'] ?? '';
                $mensagem = '';
                $alert_class = '';

                if ($status === 'success') {
                    $alert_class = 'alert-success';
                    if ($msg_code === 'senha_alterada') {
                        $mensagem = 'Senha alterada com sucesso!';
                    }
                } else {
                    $alert_class = 'alert-danger';
                    switch ($msg_code) {
                        case 'campos_vazios':
                            $mensagem = 'Por favor, preencha todos os campos.';
                            break;
                        case 'senhas_nao_coincidem':
                            $mensagem = 'A nova senha e a confirmação não coincidem.';
                            break;
                        case 'senha_curta':
                            $mensagem = 'A nova senha deve ter pelo menos 6 caracteres.';
                            break;
                        case 'senha_atual_incorreta':
                            $mensagem = 'A senha atual está incorreta.';
                            break;
                        default:
                            $mensagem = 'Ocorreu um erro inesperado. Tente novamente.';
                            break;
                    }
                }

                if ($mensagem) {
                    echo "<div class='alert {$alert_class}' role='alert'>{$mensagem}</div>";
                }
            }
            ?>

            <div class="settings-card">
                <h3 class="settings-card-title">Segurança da Conta</h3>
                <form action="../Controller/alterar-senha.php" method="POST">
                    <div class="form-group">
                        <label for="senha_atual">Senha Atual</label>
                        <input type="password" id="senha_atual" name="senha_atual" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="nova_senha">Nova Senha</label>
                        <input type="password" id="nova_senha" name="nova_senha" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="confirmar_nova_senha">Confirmar Nova Senha</label>
                        <input type="password" id="confirmar_nova_senha" name="confirmar_nova_senha" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Alterar Senha</button>
                </form>
            </div>

            <div class="settings-card">
                <h3 class="settings-card-title">Preferências</h3>
                <div class="preference-item">
                    <span>Tema da plataforma</span>
                    <button class="btn btn-secondary-custom disabled" disabled>
                        <i class="bi bi-moon-stars-fill"></i> Modo Escuro
                    </button>
                </div>
            </div>

            <div class="settings-card danger-zone">
                <h3 class="settings-card-title">Zona de Perigo</h3>
                <div class="danger-item">
                    <div>
                        <strong>Excluir esta conta</strong>
                        <p>Uma vez que você exclui sua conta, não há como voltar atrás. Tenha certeza.</p>
                    </div>
                    <button class="btn btn-danger">Excluir minha conta</button>
                </div>
            </div>

        </main>
    </div>

    <!-- SCRIPTS GLOBAIS REMOVIDOS DAQUI -->

</body>
</html>
