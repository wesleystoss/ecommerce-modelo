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
    case 'login':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
    case 'cadastro':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->cadastro();
        break;
    case 'conta':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->conta();
        break;
    case 'logout':
        require_once __DIR__ . '/../app/controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'admin':
        $controller = new AdminController();
        $controller->index();
        break;
    case 'checkout':
        include __DIR__ . '/../app/views/checkout.php';
        break;
    case 'contato':
        include __DIR__ . '/../app/views/contato.php';
        break;
    default:
        $controller = new HomeController();
        $controller->index();
        break;
}
