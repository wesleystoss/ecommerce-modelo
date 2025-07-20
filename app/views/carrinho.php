<?php
session_start();
require_once __DIR__ . '/../../config/database.php';
$db = getDB();
require_once __DIR__ . '/../../app/models/Configuracao.php';
$config = Configuracao::get($db);
include __DIR__ . '/partials/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produto_id'])) {
    $_SESSION['carrinho'][] = $_POST['produto_id'];
}

$carrinho = $_SESSION['carrinho'] ?? [];
$produtos = [];
if ($carrinho) {
    $placeholders = implode(',', array_fill(0, count($carrinho), '?'));
    $stmt = $db->prepare('SELECT * FROM produtos WHERE id IN (' . $placeholders . ')');
    $stmt->execute($carrinho);
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<main class="flex-1 container mx-auto p-4">
    <h2 class="text-xl font-semibold mb-4">Produtos no Carrinho</h2>
    <?php if ($produtos): ?>
        <ul class="mb-4">
            <?php foreach ($produtos as $produto): ?>
                <li class="mb-2 flex justify-between items-center bg-white p-2 rounded shadow">
                    <span><?php echo htmlspecialchars($produto['nome']); ?></span>
                    <span class="font-bold text-green-600">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <form method="post" action="?rota=carrinho&finalizar=1">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Finalizar Compra</button>
        </form>
    <?php else: ?>
        <p class="text-gray-700">Seu carrinho está vazio.</p>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?> 