<?php
class AdminBannerController {
    public function index() {
        require_once __DIR__ . '/../../../config/database.php';
        require_once __DIR__ . '/../../../app/models/Banner.php';
        $db = getDB();

        // Adicionar banner
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['id'])) {
            Banner::create($db, [
                'titulo' => $_POST['titulo'],
                'imagem' => $_POST['imagem'],
                'link' => $_POST['link'],
                'ordem' => $_POST['ordem'] ?? 0,
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ]);
            header('Location: ?rota=banners');
            exit;
        }
        // Editar banner
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            Banner::update($db, $_POST['id'], [
                'titulo' => $_POST['titulo'],
                'imagem' => $_POST['imagem'],
                'link' => $_POST['link'],
                'ordem' => $_POST['ordem'] ?? 0,
                'ativo' => isset($_POST['ativo']) ? 1 : 0
            ]);
            header('Location: ?rota=banners');
            exit;
        }
        // Excluir banner
        if (isset($_GET['excluir'])) {
            Banner::delete($db, $_GET['excluir']);
            header('Location: ?rota=banners');
            exit;
        }
        // Buscar banner para edição
        $editar = null;
        if (isset($_GET['editar'])) {
            $editar = Banner::find($db, $_GET['editar']);
        }
        $banners = Banner::all($db);

        include __DIR__ . '/../../views/admin/banners/index.php';
    }
} 