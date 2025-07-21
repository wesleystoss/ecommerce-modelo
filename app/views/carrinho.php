<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Configuracao.php';
require_once __DIR__ . '/../../app/models/Produto.php';

// Toda a lógica de manipulação do carrinho (POST) deve vir antes de qualquer HTML.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['carrinho']) || !is_array($_SESSION['carrinho'])) {
        $_SESSION['carrinho'] = [];
    }

    if (isset($_POST['adicionar_id'])) {
        $id = (int)$_POST['adicionar_id'];
        if ($id > 0) {
            $_SESSION['carrinho'][$id] = ($_SESSION['carrinho'][$id] ?? 0) + 1;
        }
    } elseif (isset($_POST['remover_id'])) {
        unset($_SESSION['carrinho'][(int)$_POST['remover_id']]);
    } elseif (isset($_POST['atualizar_todos']) && isset($_POST['quantidade'])) {
        foreach ($_POST['quantidade'] as $id => $qtd) {
            $id = (int)$id;
            $qtd = max(1, (int)$qtd);
            if ($id > 0 && isset($_SESSION['carrinho'][$id])) {
                $_SESSION['carrinho'][$id] = $qtd;
            }
        }
    }

    // Redireciona para a própria página via GET para evitar reenvio do formulário.
    header('Location: ?rota=carrinho');
    exit;
}

$db = getDB();
$config = Configuracao::get($db);
$carrinho = $_SESSION['carrinho'] ?? [];
$produtos = [];
$total = 0.0;

if (!empty($carrinho)) {
    $ids = array_keys($carrinho);
    if (!empty($ids)) {
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $db->prepare("SELECT * FROM produtos WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        
        // Correção: Usar FETCH_ASSOC e remapear para um array chaveado pelo ID.
        $produtos_from_db = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $produtos_db = [];
        foreach ($produtos_from_db as $p) {
            $produtos_db[$p['id']] = $p;
        }

        foreach ($carrinho as $id => $quantidade) {
            if (isset($produtos_db[$id])) {
                $produto = $produtos_db[$id];
                $produto['quantidade'] = $quantidade;
                $produto['preco_unitario'] = (!empty($produto['em_promocao']) && !empty($produto['preco_promocional'])) ? $produto['preco_promocional'] : $produto['preco'];
                $produto['subtotal'] = $produto['preco_unitario'] * $quantidade;
                $total += $produto['subtotal'];
                $produtos[] = $produto;
            } else {
                // Se o produto não existe mais no DB, remove do carrinho.
                unset($_SESSION['carrinho'][$id]);
            }
        }
    }
}

function produto_image($produto) {
    if (!empty($produto['imagem'])) return $produto['imagem'];
    return 'https://source.unsplash.com/collection/190727/400x400?sig=' . $produto['id'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - <?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?></title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col text-gray-900">
<?php include __DIR__ . '/partials/banner_topo.php'; ?>
<?php include __DIR__ . '/partials/header.php'; ?>
<main class="flex-1 container mx-auto p-4 md:p-8">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-8">Seu Carrinho</h1>
    <?php if ($produtos): ?>
        <form method="post" action="?rota=carrinho" class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 space-y-6 border border-gray-100">
                <?php foreach ($produtos as $produto): ?>
                    <div class="flex items-center gap-6 border-b border-gray-100 pb-6 last:border-b-0 last:pb-0">
                        <img src="<?php echo produto_image($produto); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="w-24 h-24 object-cover rounded-xl shadow-md border">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-800"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                            <p class="text-sm text-gray-600">Preço unitário: R$ <?php echo number_format($produto['preco_unitario'], 2, ',', '.'); ?></p>
                            <div class="flex items-center gap-2 mt-2">
                                <label for="qtd-<?php echo $produto['id']; ?>" class="text-sm font-semibold">Qtd:</label>
                                <input id="qtd-<?php echo $produto['id']; ?>" type="number" name="quantidade[<?php echo $produto['id']; ?>]" value="<?php echo $produto['quantidade']; ?>" min="1" class="w-20 border-gray-200 rounded-lg p-2 text-center shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-lg text-blue-600">R$ <?php echo number_format($produto['subtotal'], 2, ',', '.'); ?></p>
                            <button type="submit" name="remover_id" value="<?php echo $produto['id']; ?>" class="text-red-500 hover:text-red-700 font-semibold text-sm mt-2 transition group">
                                <i class="fas fa-trash-alt mr-1"></i>Remover
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <aside class="lg:col-span-1 bg-white rounded-2xl shadow-lg p-8 border border-gray-100 sticky top-24">
                <h2 class="text-2xl font-bold mb-6 border-b pb-4">Resumo do Pedido</h2>
                <div class="space-y-4 mb-8">
                    <div class="flex justify-between text-lg">
                        <span>Subtotal</span>
                        <span>R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
                    </div>
                    <div class="flex justify-between text-lg font-extrabold text-gray-800">
                        <span>Total</span>
                        <span>R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
                    </div>
                </div>
                <div class="space-y-3">
                    <a href="?rota=checkout" class="w-full bg-green-500 text-white px-8 py-4 rounded-full font-bold hover:bg-green-600 transition shadow-lg flex items-center justify-center text-lg">
                        <i class="fas fa-check-circle mr-2"></i> Finalizar Compra
                    </a>
                    <button type="submit" name="atualizar_todos" value="1" class="w-full bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition shadow-md flex items-center justify-center">
                        <i class="fas fa-sync-alt mr-2"></i> Atualizar Carrinho
                    </button>
                </div>
            </aside>
        </form>
    <?php else: ?>
        <div class="text-center bg-white rounded-2xl shadow-lg p-12 border border-gray-100">
            <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-6"></i>
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Seu carrinho está vazio</h2>
            <p class="text-gray-600 mb-8">Parece que você ainda não adicionou nenhum produto. Que tal dar uma olhada nas nossas ofertas?</p>
            <a href="?rota=produtos" class="bg-blue-600 text-white px-8 py-4 rounded-full font-bold hover:bg-blue-700 transition shadow-lg inline-block">
                Continuar Comprando
            </a>
        </div>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html> 