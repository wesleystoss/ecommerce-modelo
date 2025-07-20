<?php
class AdminConfiguracaoController {
    public function index() {
        require_once __DIR__ . '/../../../config/database.php';
        require_once __DIR__ . '/../../../app/models/Configuracao.php';
        $db = getDB();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Configuracao::update($db, [
                'nome_empresa' => $_POST['nome_empresa'],
                'logo' => $_POST['logo'],
                'email' => $_POST['email'],
                'telefone' => $_POST['telefone'],
                'endereco' => $_POST['endereco'],
                'logo_height' => $_POST['logo_height'] ?? 32
            ]);
            header('Location: ?rota=configuracoes');
            exit;
        }
        $config = Configuracao::get($db);
        include __DIR__ . '/../../views/admin/configuracoes/index.php';
    }
} 