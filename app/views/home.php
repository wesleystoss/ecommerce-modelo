<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Configuracao.php';
require_once __DIR__ . '/../../app/models/Produto.php';
$db = getDB();
$config = Configuracao::get($db);
$banners = $db->query('SELECT * FROM banners WHERE ativo = 1 ORDER BY ordem ASC, id DESC')->fetchAll(PDO::FETCH_ASSOC);
$categorias = $db->query('SELECT * FROM categorias')->fetchAll(PDO::FETCH_ASSOC);
$produtos = Produto::destaques($db, 0);
$vantagens = $db->query('SELECT * FROM vantagens')->fetchAll(PDO::FETCH_ASSOC);
$avaliacoes = $db->query('SELECT * FROM avaliacoes ORDER BY id DESC LIMIT 4')->fetchAll(PDO::FETCH_ASSOC);
function produto_image($produto) {
    if (!empty($produto['imagem'])) {
        return $produto['imagem'];
    }
    $nome = strtolower($produto['nome']);
    if (strpos($nome, 'camiseta') !== false) {
        return 'https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=400&q=80';
    }
    if (strpos($nome, 'tênis') !== false || strpos($nome, 'tenis') !== false) {
        return 'https://images.unsplash.com/photo-1519864600265-abb23847ef2c?auto=format&fit=crop&w=400&q=80';
    }
    if (strpos($nome, 'mochila') !== false) {
        return 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80';
    }
    return 'https://source.unsplash.com/collection/190727/400x400?sig=' . $produto['id'];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?> - Início</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col text-gray-900">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <main class="flex-1">
        <!-- Banner principal estilo Shopify -->
        <section class="w-full bg-white border-b border-gray-200">
            <div class="container mx-auto flex flex-col md:flex-row items-center justify-between py-16 px-4 gap-8 ">
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-4xl md:text-5xl font-bold mb-4 leading-tight">Descubra o melhor da <span class="text-blue-600">Loja Modelo</span></h2>
                    <p class="text-lg md:text-xl text-gray-600 mb-8">Produtos selecionados, entrega rápida e experiência premium para você.</p>
                    <a href="?rota=produtos" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-full shadow hover:bg-blue-700 transition font-semibold text-lg">Ver Produtos</a>
                </div>
                <div class="flex-1 flex justify-center">
                    <?php if (!empty($banners)): ?>
                        <img src="<?php echo htmlspecialchars($banners[0]['imagem']); ?>" alt="Banner" class="rounded-2xl shadow-lg w-full max-w-md object-cover">
                    <?php else: ?>
                        <img src="https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=600&q=80" alt="Banner" class="rounded-2xl shadow-lg w-full max-w-md object-cover">
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <!-- Categorias -->
        <section class="container mx-auto py-12 px-4">
            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Categorias</h3>
            <div class="flex justify-center">
                <div class="inline-grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">
                    <?php foreach ($categorias as $cat): ?>
                        <a href="?rota=produtos&categoria=<?php echo $cat['id']; ?>" class="flex flex-col items-center bg-white rounded-xl shadow-md p-6 hover:shadow-xl transition border border-gray-100 group">
                            <span class="text-4xl mb-2 group-hover:scale-110 transition"><?php echo $cat['icone']; ?></span>
                            <span class="font-semibold text-base text-gray-900 group-hover:text-blue-600 transition"><?php echo $cat['nome']; ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <!-- Produtos em destaque -->
        <section class="container mx-auto py-12 px-4">
            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Produtos em destaque</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php foreach ($produtos as $produto): ?>
                    <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center border border-gray-100 hover:shadow-xl transition group relative">
                        <img src="<?php echo produto_image($produto); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="w-28 h-28 object-cover rounded-xl mb-4 border border-gray-200 group-hover:scale-105 transition">
                        <h2 class="text-lg font-semibold mb-1 text-gray-900 text-center group-hover:text-blue-600 transition"><?php echo htmlspecialchars($produto['nome']); ?></h2>
                        <p class="mb-2 text-gray-600 text-center text-sm"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                        <span class="mb-4 font-bold text-blue-600 text-lg">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                        <a href="?rota=produto&id=<?php echo $produto['id']; ?>" class="block bg-blue-50 text-blue-700 px-4 py-2 rounded-full hover:bg-blue-100 transition text-center font-semibold mb-2">Ver Detalhes</a>
                        <form method="post" action="?rota=carrinho" class="w-full">
                            <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                            <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition font-bold text-base shadow">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($produtos)): ?>
                    <div class="col-span-full text-center text-gray-500">Nenhum produto encontrado.</div>
                <?php endif; ?>
            </div>
            <div class="flex justify-center mt-8">
                <a href="?rota=produtos" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-full shadow hover:bg-blue-700 transition font-semibold text-lg">Ver todos os produtos</a>
            </div>
        </section>
        <!-- Vantagens -->
        <section class="container mx-auto py-12 px-4">
            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Por que escolher a Loja Modelo?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($vantagens as $vant): ?>
                    <div class="bg-white rounded-xl shadow-md p-8 flex flex-col items-center border border-gray-100">
                        <span class="text-4xl mb-4 text-blue-600"><?php echo htmlspecialchars($vant['icone']); ?></span>
                        <h4 class="font-semibold text-lg mb-2 text-gray-900"><?php echo htmlspecialchars($vant['titulo']); ?></h4>
                        <p class="text-gray-600 text-center text-base"><?php echo htmlspecialchars($vant['descricao']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <!-- Depoimentos -->
        <section class="bg-gray-100 py-12 px-4">
            <div class="container mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">O que dizem nossos clientes</h3>
                <div class="flex flex-col md:flex-row gap-8 justify-center">
                    <?php if (count($avaliacoes) > 0): ?>
                        <?php foreach ($avaliacoes as $av): ?>
                            <div class="bg-white rounded-xl shadow-md p-6 flex-1 border border-gray-100">
                                <p class="text-gray-700 italic mb-2 text-base">“<?php echo htmlspecialchars($av['texto']); ?>”</p>
                                <span class="font-semibold text-gray-900"><?php echo htmlspecialchars($av['nome_cliente']); ?></span><br>
                                <span class="text-yellow-500 text-lg"><?php echo str_repeat('⭐', (int)$av['nota']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="bg-white rounded-xl shadow-md p-6 flex-1 text-center text-gray-500 border border-gray-100">
                            Ainda não há avaliações cadastradas.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html> 