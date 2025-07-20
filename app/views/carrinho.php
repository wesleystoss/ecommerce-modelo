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
<main class="flex-1 container mx-auto p-4 md:p-8">
    <h2 class="text-3xl font-bold mb-8 text-gray-900">Seu Carrinho</h2>
    <?php if ($produtos): ?>
        <ul class="mb-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <?php foreach ($produtos as $produto): ?>
                <li class="flex justify-between items-center bg-white p-6 rounded-2xl shadow-md border border-gray-100">
                    <span class="font-semibold text-lg text-gray-900"><?php echo htmlspecialchars($produto['nome']); ?></span>
                    <span class="font-bold text-blue-600 text-xl">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
        <form method="post" action="?rota=carrinho&finalizar=1" class="flex justify-end">
            <button type="submit" class="bg-green-500 text-white px-8 py-3 rounded-full font-bold hover:bg-green-600 transition shadow">Finalizar Compra</button>
        </form>
    <?php else: ?>
        <p class="text-gray-700 text-lg">Seu carrinho está vazio.</p>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?> 