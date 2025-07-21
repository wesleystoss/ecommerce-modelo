<?php
class AdminFaqController {
    public function index() {
        require_once __DIR__ . '/../../../config/database.php';
        require_once __DIR__ . '/../../../app/models/Faq.php';
        $db = getDB();

        // Adicionar FAQ
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['id'])) {
            Faq::create($db, [
                'pergunta' => $_POST['pergunta'],
                'resposta' => $_POST['resposta']
            ]);
            header('Location: ?rota=faqs');
            exit;
        }
        // Editar FAQ
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            Faq::update($db, $_POST['id'], [
                'pergunta' => $_POST['pergunta'],
                'resposta' => $_POST['resposta']
            ]);
            header('Location: ?rota=faqs');
            exit;
        }
        // Excluir FAQ
        if (isset($_GET['excluir'])) {
            Faq::delete($db, $_GET['excluir']);
            header('Location: ?rota=faqs');
            exit;
        }
        // Buscar FAQ para edição
        $editar = null;
        if (isset($_GET['editar'])) {
            $editar = Faq::find($db, $_GET['editar']);
        }
        $faqs = Faq::all($db);

        include __DIR__ . '/../../views/admin/faqs/index.php';
    }
} 