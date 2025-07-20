<?php
class AdminClienteController {
    public function index() {
        require_once __DIR__ . '/../../../config/database.php';
        require_once __DIR__ . '/../../../app/models/Cliente.php';
        $db = getDB();

        // Adicionar cliente
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['id'])) {
            Cliente::create($db, [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'telefone' => $_POST['telefone'],
                'senha' => password_hash($_POST['senha'], PASSWORD_DEFAULT),
                'bloqueado' => isset($_POST['bloqueado']) ? 1 : 0
            ]);
            header('Location: ?rota=clientes');
            exit;
        }
        // Editar cliente
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : Cliente::find($db, $_POST['id'])['senha'];
            Cliente::update($db, $_POST['id'], [
                'nome' => $_POST['nome'],
                'email' => $_POST['email'],
                'telefone' => $_POST['telefone'],
                'senha' => $senha,
                'bloqueado' => isset($_POST['bloqueado']) ? 1 : 0
            ]);
            header('Location: ?rota=clientes');
            exit;
        }
        // Excluir cliente
        if (isset($_GET['excluir'])) {
            Cliente::delete($db, $_GET['excluir']);
            header('Location: ?rota=clientes');
            exit;
        }
        // Buscar cliente para edição
        $editar = null;
        if (isset($_GET['editar'])) {
            $editar = Cliente::find($db, $_GET['editar']);
        }
        $clientes = Cliente::all($db);

        include __DIR__ . '/../../views/admin/clientes/index.php';
    }
} 