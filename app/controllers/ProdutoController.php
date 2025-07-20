<?php
class ProdutoController {
    public function index() {
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../models/Produto.php';
        $db = getDB();
        $nome = $_GET['nome'] ?? '';
        $preco_min = $_GET['preco_min'] ?? '';
        $preco_max = $_GET['preco_max'] ?? '';
        $where = [];
        $params = [];
        if ($nome) {
            $where[] = 'nome LIKE ?';
            $params[] = "%$nome%";
        }
        if ($preco_min !== '') {
            $where[] = 'preco >= ?';
            $params[] = $preco_min;
        }
        if ($preco_max !== '') {
            $where[] = 'preco <= ?';
            $params[] = $preco_max;
        }
        $sql = 'SELECT * FROM produtos';
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $produtos = $db->prepare($sql);
        $produtos->execute($params);
        $produtos = $produtos->fetchAll(PDO::FETCH_ASSOC);
        include __DIR__ . '/../views/produtos.php';
    }
    public function show() {
        require_once __DIR__ . '/../../config/database.php';
        require_once __DIR__ . '/../models/Produto.php';
        require_once __DIR__ . '/../models/Categoria.php';
        require_once __DIR__ . '/../models/Avaliacao.php';
        $db = getDB();
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: ?rota=produtos');
            exit;
        }
        $produto = Produto::find($db, $id);
        if (!$produto) {
            header('Location: ?rota=produtos');
            exit;
        }
        $categoria = Categoria::find($db, $produto['categoria_id']);
        $avaliacoes = Avaliacao::all($db); // Filtrar por produto se desejar
        $relacionados = $db->prepare('SELECT * FROM produtos WHERE categoria_id = ? AND id != ? LIMIT 4');
        $relacionados->execute([$produto['categoria_id'], $produto['id']]);
        $relacionados = $relacionados->fetchAll(PDO::FETCH_ASSOC);
        include __DIR__ . '/../views/produto_detalhe.php';
    }
} 