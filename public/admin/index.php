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
    case 'configuracoes':
        $controller = new AdminConfiguracaoController();
        $controller->index();
        break;
    default:
        include __DIR__ . '/../../app/views/admin/dashboard.php';
        break;
}
