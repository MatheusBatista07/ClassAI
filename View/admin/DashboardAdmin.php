<?php
require_once __DIR__ . '/../../auth_admin.php'; // Nosso guardião!
require_once __DIR__ . '/../../Model/Connection.php';

$pdo = Model\Connection::getInstance();
$stmt = $pdo->prepare("SELECT * FROM aplicacoes_professores WHERE status = 'pendente' ORDER BY data_aplicacao ASC");
$stmt->execute();
$aplicacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Aplicações Pendentes</title>
    <link rel="stylesheet" href="/ClassAI/Templates/css/admin_dashboard.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <div class="admin-wrapper">
        <?php require_once __DIR__ . '/_sidebar_admin.php'; ?>

        <div class="admin-content">
            <div class="admin-header">
                <h1>Aplicações de Instrutores Pendentes</h1>
                <p>Revise as aplicações e tome uma ação.</p>
            </div>

            <div class="aplicacoes-lista">
                <?php if (empty($aplicacoes )): ?>
                    <div class="nenhuma-aplicacao">
                        <i class="bi bi-check2-circle"></i>
                        <p>Nenhuma aplicação pendente no momento.</p>
                    </div>
                <?php else: ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Candidato</th>
                                <th>E-mail</th>
                                <th>Formação</th>
                                <th>Data da Aplicação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aplicacoes as $app): ?>
                                <tr>
                                    <td>
                                        <div class="candidato-info">
                                            <img src="/ClassAI/<?php echo htmlspecialchars($app['caminho_foto_perfil'] ?? 'Images/perfil_padrao.png'); ?>" alt="Foto de <?php echo htmlspecialchars($app['nome_completo']); ?>">
                                            <span><?php echo htmlspecialchars($app['nome_completo']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($app['email']); ?></td>
                                    <td><?php echo htmlspecialchars($app['formacao']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($app['data_aplicacao'])); ?></td>
                                    <td>
                                        <a href="DetalhesAplicacao.php?id=<?php echo $app['id']; ?>" class="btn-acao btn-detalhes">
                                            <i class="bi bi-search"></i> Ver Detalhes
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
