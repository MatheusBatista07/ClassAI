<?php
require_once __DIR__ . '/../../auth_admin.php';
require_once __DIR__ . '/../../Model/Connection.php';

$aplicacao_id = $_GET['id'] ?? null;

if (!$aplicacao_id) {
    header('Location: DashboardAdmin.php');
    exit;
}

$pdo = Model\Connection::getInstance();
$stmt = $pdo->prepare("SELECT * FROM aplicacoes_professores WHERE id = ?");
$stmt->execute([$aplicacao_id]);
$app = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$app) {
    header('Location: DashboardAdmin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Detalhes da Aplicação</title>
    <link rel="stylesheet" href="/ClassAI/Templates/css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <div class="admin-wrapper">
        <?php require_once __DIR__ . '/_sidebar_admin.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <a href="DashboardAdmin.php" class="btn-voltar"><i class="bi bi-arrow-left"></i> Voltar para a lista</a>
                <h1>Detalhes da Aplicação</h1>
            </div>

            <div class="detalhes-grid">
                <div class="detalhe-card card-principal">
                    <img src="/ClassAI/<?php echo htmlspecialchars($app['caminho_foto_perfil'] ?? 'Images/perfil_padrao.png' ); ?>" alt="Foto de Perfil" class="detalhe-foto">
                    <h2><?php echo htmlspecialchars($app['nome_completo']); ?></h2>
                    <p class="detalhe-formacao"><?php echo htmlspecialchars($app['formacao']); ?></p>
                    <div class="detalhe-contato">
                        <span><i class="bi bi-envelope-fill"></i> <?php echo htmlspecialchars($app['email']); ?></span>
                        <?php if (!empty($app['telefone'])): ?>
                            <span><i class="bi bi-telephone-fill"></i> <?php echo htmlspecialchars($app['telefone']); ?></span>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo htmlspecialchars($app['link_portfolio']); ?>" target="_blank" class="btn-link-externo">
                        <i class="bi bi-linkedin"></i> Ver Portfólio/LinkedIn
                    </a>
                </div>

                <div class="detalhe-card">
                    <h3>Carta de Apresentação</h3>
                    <p class="carta-apresentacao"><?php echo nl2br(htmlspecialchars($app['carta_apresentacao'])); ?></p>
                </div>

                <div class="detalhe-card card-curriculo">
                    <h3>Currículo</h3>
                    <a href="/ClassAI/<?php echo htmlspecialchars($app['caminho_curriculo']); ?>" download class="btn-download-cv">
                        <i class="bi bi-file-earmark-arrow-down-fill"></i> Baixar Currículo
                    </a>
                </div>

                <div class="detalhe-card card-acoes">
                    <h3>Ações</h3>
                    <p>Após analisar o perfil, aprove ou rejeite a aplicação.</p>
                    <form action="/ClassAI/processa_decisao_admin.php" method="POST" class="form-acoes">
                        <input type="hidden" name="aplicacao_id" value="<?php echo $app['id']; ?>">
                        <button type="submit" name="acao" value="aprovar" class="btn-acao btn-aprovar">
                            <i class="bi bi-check-lg"></i> Aprovar Candidato
                        </button>
                        <button type="submit" name="acao" value="rejeitar" class="btn-acao btn-rejeitar">
                            <i class="bi bi-x-lg"></i> Rejeitar Candidato
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
