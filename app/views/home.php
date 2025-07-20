<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Configuracao.php';
require_once __DIR__ . '/../../app/models/Produto.php';
$db = getDB();
$config = Configuracao::get($db);
// Buscar banners ativos
$banners = $db->query('SELECT * FROM banners WHERE ativo = 1 ORDER BY ordem ASC, id DESC')->fetchAll(PDO::FETCH_ASSOC);
// Buscar categorias distintas
$categorias = $db->query('SELECT * FROM categorias')->fetchAll(PDO::FETCH_ASSOC);
// Buscar todos os produtos em destaque
$produtos = Produto::destaques($db, 0);
// Buscar vantagens
$vantagens = $db->query('SELECT * FROM vantagens')->fetchAll(PDO::FETCH_ASSOC);
// Buscar avaliações
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
<body class="bg-gray-50 min-h-screen flex flex-col">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <main class="flex-1">
        <!-- Hero com carrossel de banners -->
        <section class="relative h-[70vh] min-h-[300px] flex items-center justify-center text-center overflow-hidden z-0">
            <div id="hero-carousel" class="w-full h-full relative z-0">
                <?php if (!empty($banners)): ?>
                    <?php foreach ($banners as $i => $ban): ?>
                        <div class="absolute inset-0 w-full h-full transition-opacity duration-700 <?php echo $i === 0 ? 'opacity-100 z-0' : 'opacity-0 z-0'; ?> banner-slide" data-index="<?php echo $i; ?>">
                            <img src="<?php echo htmlspecialchars($ban['imagem']); ?>" class="w-full h-full object-cover" alt="<?php echo htmlspecialchars($ban['titulo']); ?>">
                            <div class="absolute inset-0"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center z-10 text-white">
                                <?php if ($ban['titulo']): ?>
                                    <h2 class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow-lg"><?php echo htmlspecialchars($ban['titulo']); ?></h2>
                                <?php endif; ?>
                                <?php if ($ban['link']): ?>
                                    <a href="<?php echo htmlspecialchars($ban['link']); ?>" class="inline-block bg-white text-blue-700 font-bold px-8 py-3 rounded shadow-lg hover:bg-blue-50 transition text-lg" target="_blank">Saiba mais</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="absolute inset-0 w-full h-full z-0">
                        <img src='https://images.unsplash.com/photo-1512436991641-6745cdb1723f?auto=format&fit=crop&w=1200&q=80' class="w-full h-full object-cover opacity-70" alt="Banner Loja">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-blue-500/60"></div>
                        <div class="absolute inset-0 flex flex-col items-center justify-center z-10 text-white">
                            <h2 class="text-4xl md:text-5xl font-extrabold mb-4 drop-shadow-lg">Sua loja virtual moderna</h2>
                            <p class="text-lg md:text-2xl mb-8 font-medium drop-shadow">Monte, personalize e venda online com facilidade.</p>
                            <a href="?rota=produtos" class="inline-block bg-white text-blue-700 font-bold px-8 py-3 rounded shadow-lg hover:bg-blue-50 transition text-lg">Ver Produtos</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <script>
        // Carrossel automático de banners
        (function() {
            const slides = document.querySelectorAll('.banner-slide');
            if (slides.length <= 1) return;
            let current = 0;
            setInterval(() => {
                slides[current].classList.remove('opacity-100', 'z-10');
                slides[current].classList.add('opacity-0', 'z-0');
                current = (current + 1) % slides.length;
                slides[current].classList.remove('opacity-0', 'z-0');
                slides[current].classList.add('opacity-100', 'z-10');
            }, 4000);
        })();
        </script>
        <!-- Categorias -->
        <section class="container mx-auto py-12 px-4">
            <h3 class="text-2xl font-semibold text-gray-800 mb-8 text-center">Categorias</h3>
            <div class="flex flex-wrap justify-center gap-8 mb-8">
                <?php foreach ($categorias as $cat): ?>
                    <a href="?rota=produtos&categoria=<?php echo $cat['id']; ?>" class="flex flex-col items-center bg-white rounded-xl shadow-lg p-6 w-40 hover:scale-105 transition border-2 border-transparent hover:border-blue-400">
                        <span class="text-5xl mb-2"><?php echo $cat['icone']; ?></span>
                        <span class="font-bold text-lg text-blue-700"><?php echo $cat['nome']; ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
            <h3 class="text-2xl font-semibold text-gray-800 mb-8 text-center">Produtos em destaque</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                <?php foreach ($produtos as $produto): ?>
                    <div class="bg-white rounded-2xl shadow-xl p-6 flex flex-col items-center hover:scale-105 hover:shadow-2xl transition group relative">
                        <img src="<?php echo produto_image($produto); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="w-24 h-24 object-cover rounded-full mb-4 border-4 border-blue-100 group-hover:border-blue-400 transition">
                        <h2 class="text-base font-semibold mb-1 text-blue-700 text-center"><?php echo htmlspecialchars($produto['nome']); ?></h2>
                        <p class="mb-2 text-gray-600 text-center text-sm"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                        <span class="mb-4 font-bold text-green-600 text-lg">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                        <a href="?rota=produto&id=<?php echo $produto['id']; ?>" class="block bg-blue-100 text-blue-700 px-4 py-2 rounded hover:bg-blue-200 transition text-center font-semibold mb-2">Ver Detalhes</a>
                        <form method="post" action="?rota=carrinho" class="w-full">
                            <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-400 text-white px-4 py-2 rounded-lg shadow hover:from-blue-700 hover:to-blue-500 transition font-bold text-lg">Adicionar ao Carrinho</button>
                        </form>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($produtos)): ?>
                    <div class="col-span-full text-center text-gray-500">Nenhum produto encontrado.</div>
                <?php endif; ?>
            </div>
            <div class="flex justify-center mt-8">
                <a href="?rota=produtos" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-lg shadow hover:bg-blue-700 transition font-bold text-lg">Ver todos os produtos</a>
            </div>
        </section>
        <!-- Vantagens -->
        <section class="container mx-auto py-12 px-4">
            <h3 class="text-2xl font-semibold text-gray-800 mb-8 text-center">Por que escolher a Loja Modelo?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($vantagens as $vant): ?>
                    <div class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition">
                        <span class="text-5xl mb-4 text-blue-600"><?php echo htmlspecialchars($vant['icone']); ?></span>
                        <h4 class="font-bold text-lg mb-2"><?php echo htmlspecialchars($vant['titulo']); ?></h4>
                        <p class="text-gray-600 text-center"><?php echo htmlspecialchars($vant['descricao']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
        <!-- Depoimentos -->
        <section class="bg-blue-50 py-12 px-4">
            <div class="container mx-auto">
                <h3 class="text-2xl font-semibold text-blue-700 mb-8 text-center">O que dizem nossos clientes</h3>
                <div class="flex flex-col md:flex-row gap-8 justify-center">
                    <?php if (count($avaliacoes) > 0): ?>
                        <?php foreach ($avaliacoes as $av): ?>
                            <div class="bg-white rounded-xl shadow-lg p-6 flex-1">
                                <p class="text-gray-700 italic mb-2">“<?php echo htmlspecialchars($av['texto']); ?>”</p>
                                <span class="font-bold text-blue-700"><?php echo htmlspecialchars($av['nome_cliente']); ?></span><br>
                                <span class="text-yellow-500 text-xl"><?php echo str_repeat('⭐', (int)$av['nota']); ?></span>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="bg-white rounded-xl shadow-lg p-6 flex-1 text-center text-gray-500">
                            Ainda não há avaliações cadastradas.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-blue-900 text-white p-4 text-center mt-8">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center max-w-5xl mx-auto gap-2">
            <div>
                <span class="font-bold"><?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?></span>
                <?php if (!empty($config['endereco'])): ?> | <?php echo htmlspecialchars($config['endereco']); ?><?php endif; ?>
            </div>
            <div>
                <?php if (!empty($config['email'])): ?>
                    <span class="mr-2">📧 <?php echo htmlspecialchars($config['email']); ?></span>
                <?php endif; ?>
                <?php if (!empty($config['telefone'])): ?>
                    <span>📞 <?php echo htmlspecialchars($config['telefone']); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="text-xs text-gray-300 mt-2">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?>. Feito com ❤️ e Tailwind CSS.</div>
    </footer>
</body>
</html> 