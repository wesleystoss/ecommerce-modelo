<?php
class AuthController {
    public function login() {
        session_start();
        require_once __DIR__ . '/../models/Cliente.php';
        require_once __DIR__ . '/../../config/database.php';
        $db = getDB();
        $erro = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $cliente = $db->prepare('SELECT * FROM clientes WHERE email = ?');
            $cliente->execute([$email]);
            $cliente = $cliente->fetch(PDO::FETCH_ASSOC);
            if ($cliente && password_verify($senha, $cliente['senha'])) {
                $_SESSION['cliente_id'] = $cliente['id'];
                header('Location: ?rota=conta');
                exit;
            } else {
                $erro = 'E-mail ou senha inválidos.';
            }
        }
        include __DIR__ . '/../views/auth/login.php';
    }
    public function cadastro() {
        session_start();
        require_once __DIR__ . '/../models/Cliente.php';
        require_once __DIR__ . '/../../config/database.php';
        $db = getDB();
        $erro = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $telefone = $_POST['telefone'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $senha2 = $_POST['senha2'] ?? '';
            if ($senha !== $senha2) {
                $erro = 'As senhas não coincidem.';
            } else {
                $existe = $db->prepare('SELECT id FROM clientes WHERE email = ?');
                $existe->execute([$email]);
                if ($existe->fetch()) {
                    $erro = 'E-mail já cadastrado.';
                } else {
                    Cliente::create($db, [
                        'nome' => $nome,
                        'email' => $email,
                        'telefone' => $telefone,
                        'senha' => password_hash($senha, PASSWORD_DEFAULT),
                        'bloqueado' => 0
                    ]);
                    header('Location: ?rota=login&cadastro=ok');
                    exit;
                }
            }
        }
        include __DIR__ . '/../views/auth/cadastro.php';
    }
    public function logout() {
        session_start();
        session_destroy();
        header('Location: ?rota=login');
        exit;
    }
    public function conta() {
        session_start();
        require_once __DIR__ . '/../models/Cliente.php';
        require_once __DIR__ . '/../../config/database.php';
        $db = getDB();
        if (!isset($_SESSION['cliente_id'])) {
            header('Location: ?rota=login');
            exit;
        }
        $cliente = Cliente::find($db, $_SESSION['cliente_id']);
        $erro = '';
        $sucesso = false;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nome = $_POST['nome'] ?? '';
            $email = $_POST['email'] ?? '';
            $telefone = $_POST['telefone'] ?? '';
            $senha = $_POST['senha'] ?? '';
            $senha2 = $_POST['senha2'] ?? '';
            $dados = [
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone,
                'senha' => $cliente['senha'],
                'bloqueado' => 0
            ];
            if ($senha || $senha2) {
                if ($senha !== $senha2) {
                    $erro = 'As senhas não coincidem.';
                } else {
                    $dados['senha'] = password_hash($senha, PASSWORD_DEFAULT);
                }
            }
            if (!$erro) {
                Cliente::update($db, $cliente['id'], $dados);
                $sucesso = true;
                $cliente = Cliente::find($db, $cliente['id']);
            }
        }
        include __DIR__ . '/../views/auth/conta.php';
    }
} 