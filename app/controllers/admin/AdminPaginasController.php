<?php
class AdminPaginasController {
    public function index() {
        require_once __DIR__ . '/../../../config/database.php';
        require_once __DIR__ . '/../../../app/models/PaginasConfig.php';
        $db = getDB();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            PaginasConfig::set($db, 'home', 'hero_vh', $_POST['hero_vh'] ?? '70');
            header('Location: ?rota=paginas');
            exit;
        }
        $hero_vh = PaginasConfig::get($db, 'home', 'hero_vh') ?? '70';
        include __DIR__ . '/../../views/admin/paginas_config.php';
    }
}
