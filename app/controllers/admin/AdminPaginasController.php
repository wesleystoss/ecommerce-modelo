<?php
class AdminPaginasController {
    public function index() {
        require_once __DIR__ . '/../../../config/database.php';
        require_once __DIR__ . '/../../../app/models/PaginasConfig.php';
        $db = getDB();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            PaginasConfig::set($db, 'home', 'hero_vh', $_POST['hero_vh'] ?? '70');
            PaginasConfig::set($db, 'home', 'button_color', $_POST['button_color'] ?? '#2563eb');
            PaginasConfig::set($db, 'home', 'button_text_color', $_POST['button_text_color'] ?? '#fff');
            PaginasConfig::set($db, 'home', 'button_add_bg', $_POST['button_add_bg'] ?? '#22c55e');
            PaginasConfig::set($db, 'home', 'button_add_text', $_POST['button_add_text'] ?? '#fff');
            PaginasConfig::set($db, 'home', 'button_details_bg', $_POST['button_details_bg'] ?? '#6366f1');
            PaginasConfig::set($db, 'home', 'button_details_text', $_POST['button_details_text'] ?? '#fff');
            PaginasConfig::set($db, 'home', 'button_promos_bg', $_POST['button_promos_bg'] ?? '#f59e42');
            PaginasConfig::set($db, 'home', 'button_promos_text', $_POST['button_promos_text'] ?? '#fff');
            PaginasConfig::set($db, 'home', 'button_best_bg', $_POST['button_best_bg'] ?? '#0ea5e9');
            PaginasConfig::set($db, 'home', 'button_best_text', $_POST['button_best_text'] ?? '#fff');
            PaginasConfig::set($db, 'home', 'button_sec_bg', $_POST['button_sec_bg'] ?? '#f3f4f6');
            PaginasConfig::set($db, 'home', 'button_sec_text', $_POST['button_sec_text'] ?? '#374151');
            header('Location: ?rota=paginas');
            exit;
        }
        $hero_vh = PaginasConfig::get($db, 'home', 'hero_vh') ?? '70';
        $button_color = PaginasConfig::get($db, 'home', 'button_color') ?? '#2563eb';
        $button_text_color = PaginasConfig::get($db, 'home', 'button_text_color') ?? '#fff';
        $button_add_bg = PaginasConfig::get($db, 'home', 'button_add_bg') ?? '#22c55e';
        $button_add_text = PaginasConfig::get($db, 'home', 'button_add_text') ?? '#fff';
        $button_details_bg = PaginasConfig::get($db, 'home', 'button_details_bg') ?? '#6366f1';
        $button_details_text = PaginasConfig::get($db, 'home', 'button_details_text') ?? '#fff';
        $button_promos_bg = PaginasConfig::get($db, 'home', 'button_promos_bg') ?? '#f59e42';
        $button_promos_text = PaginasConfig::get($db, 'home', 'button_promos_text') ?? '#fff';
        $button_best_bg = PaginasConfig::get($db, 'home', 'button_best_bg') ?? '#0ea5e9';
        $button_best_text = PaginasConfig::get($db, 'home', 'button_best_text') ?? '#fff';
        $button_sec_bg = PaginasConfig::get($db, 'home', 'button_sec_bg') ?? '#f3f4f6';
        $button_sec_text = PaginasConfig::get($db, 'home', 'button_sec_text') ?? '#374151';
        include __DIR__ . '/../../views/admin/paginas_config.php';
    }
}
