<?php
require_once __DIR__ . '/../../config/database.php';

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../../app/controllers/admin/' . $class . '.php',
        __DIR__ . '/../../app/models/' . $class . '.php',
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

require_once __DIR__ . '/../../app/controllers/admin/AdminCategoriaController.php';
require_once __DIR__ . '/../../app/controllers/admin/AdminProdutoController.php';
require_once __DIR__ . '/../../app/controllers/admin/AdminPedidoController.php';
require_once __DIR__ . '/../../app/controllers/admin/AdminClienteController.php';
require_once __DIR__ . '/../../app/controllers/admin/AdminCupomController.php';
require_once __DIR__ . '/../../app/controllers/admin/AdminPopupController.php';
require_once __DIR__ . '/../../app/controllers/admin/AdminConfiguracaoController.php';
require_once __DIR__ . '/../../app/controllers/admin/AdminVantagemController.php';
require_once __DIR__ . '/../../app/controllers/admin/AdminAvaliacaoController.php';
require_once __DIR__ . '/../../app/controllers/admin/AdminBannerController.php';

$rota = $_GET['rota'] ?? 'dashboard';

switch ($rota) {
    case 'produtos':
        $controller = new AdminProdutoController();
        $controller->index();
        break;
    case 'categorias':
        $controller = new AdminCategoriaController();
        $controller->index();
        break;
    case 'avaliacoes':
        $controller = new AdminAvaliacaoController();
        $controller->index();
        break;
    case 'vantagens':
        $controller = new AdminVantagemController();
        $controller->index();
        break;
    case 'pedidos':
        $controller = new AdminPedidoController();
        $controller->index();
        break;
    case 'clientes':
        $controller = new AdminClienteController();
        $controller->index();
        break;
    case 'banners':
        $controller = new AdminBannerController();
        $controller->index();
        break;
    case 'cupons':
        $controller = new AdminCupomController();
        $controller->index();
        break;
    case 'popups':
        $controller = new AdminPopupController();
        $acao = $_GET['acao'] ?? null;
        if ($acao === 'create') {
            $controller->create();
        } elseif ($acao === 'edit' && isset($_GET['id'])) {
            $controller->edit($_GET['id']);
        } elseif ($acao === 'store') {
            $controller->store();
        } elseif ($acao === 'update' && isset($_GET['id'])) {
            $controller->update($_GET['id']);
        } elseif ($acao === 'delete' && isset($_GET['id'])) {
            $controller->delete($_GET['id']);
        } else {
            $controller->index();
        }
        break;
    case 'configuracoes':
        $controller = new AdminConfiguracaoController();
        $controller->index();
        break;
    default:
        include __DIR__ . '/../../app/views/admin/dashboard.php';
        break;
}
