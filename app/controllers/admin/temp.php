<?php
class AdminPaginasController {
    public function index() {
        require_once __DIR__ . '/../models/PaginasConfig.php';
        require_once __DIR__ . '/../../../config/database.php';
        $db = getDB();
        $hero_vh = PaginasConfig::get($db, 'home', 'hero_vh') ?? '70';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $novo = $_POST['hero_vh'] ?? '70';
            PaginasConfig::set($db, 'home', 'hero_vh', $novo);
            $hero_vh = $novo;
            $msg = 'Configuração salva com sucesso!';
        }
        include __DIR__ . '/../views/admin/paginas_config.php';
    }
} 