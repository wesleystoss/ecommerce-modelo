<?php
session_start();
header('Content-Type: application/json');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Produto.php';
$db = getDB();

$produto_id = isset($_POST['produto_id']) ? (int)$_POST['produto_id'] : 0;
$quantidade = isset($_POST['quantidade']) ? (int)$_POST['quantidade'] : 1;

if ($produto_id > 0) {
    if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }
    if ($quantidade < 1) {
        unset($_SESSION['carrinho'][$produto_id]);
        echo json_encode(['status' => 'removed']);
        exit;
    } else {
        $_SESSION['carrinho'][$produto_id] = $quantidade;
    }
    // Buscar produto atualizado
    $produto = Produto::find($db, $produto_id);
    if ($produto) {
        $preco = (!empty($produto['em_promocao']) && !empty($produto['preco_promocional'])) ? $produto['preco_promocional'] : $produto['preco'];
        $subtotal = $preco * $quantidade;
        // Calcular total do carrinho
        $total = 0.0;
        foreach ($_SESSION['carrinho'] as $id => $qtd) {
            $p = Produto::find($db, $id);
            if ($p) {
                $p_preco = (!empty($p['em_promocao']) && !empty($p['preco_promocional'])) ? $p['preco_promocional'] : $p['preco'];
                $total += $p_preco * $qtd;
            }
        }
        echo json_encode([
            'status' => 'ok',
            'subtotal' => number_format($subtotal, 2, ',', '.'),
            'total' => number_format($total, 2, ',', '.'),
            'quantidade' => $quantidade
        ]);
        exit;
    }
}
echo json_encode(['status' => 'error']); 