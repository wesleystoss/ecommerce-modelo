<?php
// Carregar configurações
require_once __DIR__ . '/../config/database.php';

// Função simples de autoload
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/controllers/' . $class . '.php',
        __DIR__ . '/../app/models/' . $class . '.php',
    ];
    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Roteamento simples
$rota = $_GET['rota'] ?? 'home';

switch ($rota) {
    case 'produtos':
        $controller = new ProdutoController();
        $controller->index();
        break;
    case 'produto':
        $controller = new ProdutoController();
        $controller->show();
        break;
    case 'carrinho':
        $controller = new CarrinhoController();
        $controller->index();
        break;
    case 'admin':
        $controller = new AdminController();
        $controller->index();
        break;
    default:
        $controller = new HomeController();
        $controller->index();
        break;
}
