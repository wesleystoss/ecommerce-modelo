<?php
class AdminProdutoController {
    public function index() {
        require_once __DIR__ . '/../../../config/database.php';
        require_once __DIR__ . '/../../../app/models/Produto.php';
        require_once __DIR__ . '/../../../app/models/Categoria.php';
        $db = getDB();

        // Adicionar produto
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['id'])) {
            $tipo_estoque = $_POST['tipo_estoque'] ?? 'ilimitado';
            $estoque = ($tipo_estoque === 'controlado') ? (int)($_POST['estoque'] ?? 0) : 0;
            Produto::create($db, [
                'nome' => $_POST['nome'],
                'descricao' => $_POST['descricao'],
                'preco' => $_POST['preco'],
                'imagem' => $_POST['imagem'],
                'categoria_id' => $_POST['categoria_id'],
                'destaque' => isset($_POST['destaque']) ? 1 : 0,
                'tipo_estoque' => $tipo_estoque,
                'estoque' => $estoque,
                'em_promocao' => isset($_POST['em_promocao']) ? 1 : 0,
                'preco_promocional' => !empty($_POST['preco_promocional']) ? $_POST['preco_promocional'] : null,
                'percentual_desconto' => !empty($_POST['percentual_desconto']) ? $_POST['percentual_desconto'] : null
            ]);
            header('Location: ?rota=produtos');
            exit;
        }
        // Editar produto
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
            $tipo_estoque = $_POST['tipo_estoque'] ?? 'ilimitado';
            $estoque = ($tipo_estoque === 'controlado') ? (int)($_POST['estoque'] ?? 0) : 0;
            Produto::update($db, $_POST['id'], [
                'nome' => $_POST['nome'],
                'descricao' => $_POST['descricao'],
                'preco' => $_POST['preco'],
                'imagem' => $_POST['imagem'],
                'categoria_id' => $_POST['categoria_id'],
                'destaque' => isset($_POST['destaque']) ? 1 : 0,
                'tipo_estoque' => $tipo_estoque,
                'estoque' => $estoque,
                'em_promocao' => isset($_POST['em_promocao']) ? 1 : 0,
                'preco_promocional' => !empty($_POST['preco_promocional']) ? $_POST['preco_promocional'] : null,
                'percentual_desconto' => !empty($_POST['percentual_desconto']) ? $_POST['percentual_desconto'] : null
            ]);
            header('Location: ?rota=produtos');
            exit;
        }
        // Excluir produto
        if (isset($_GET['excluir'])) {
            Produto::delete($db, $_GET['excluir']);
            header('Location: ?rota=produtos');
            exit;
        }
        // Buscar produto para edição
        $editar = null;
        if (isset($_GET['editar'])) {
            $editar = Produto::find($db, $_GET['editar']);
        }
        $produtos = Produto::all($db);
        $categorias = Categoria::all($db);

        include __DIR__ . '/../../views/admin/produtos.php';
    }
} 