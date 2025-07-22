<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../../app/models/Configuracao.php';
require_once __DIR__ . '/../../app/models/Produto.php';
require_once __DIR__ . '/../../app/models/Faq.php';
require_once __DIR__ . '/../../app/models/PaginasConfig.php';
$db = getDB();
$config = Configuracao::get($db);
$banners = $db->query('SELECT * FROM banners WHERE ativo = 1 ORDER BY ordem ASC, id DESC')->fetchAll(PDO::FETCH_ASSOC);
$categorias = $db->query('SELECT * FROM categorias')->fetchAll(PDO::FETCH_ASSOC);
$produtos = Produto::destaques($db, 0);
$vantagens = $db->query('SELECT * FROM vantagens')->fetchAll(PDO::FETCH_ASSOC);
$avaliacoes = $db->query('SELECT * FROM avaliacoes ORDER BY id DESC LIMIT 4')->fetchAll(PDO::FETCH_ASSOC);
$faqs = Faq::all($db);

// Buscar produtos mais vendidos (simulado)
$mais_vendidos = $db->query('SELECT * FROM produtos ORDER BY RANDOM() LIMIT 6')->fetchAll(PDO::FETCH_ASSOC);

// Buscar produtos em promoção reais do banco
$promocoes = Produto::promocoes($db, 4);

$hero_vh = PaginasConfig::get($db, 'home', 'hero_vh') ?? '70';
$button_color = PaginasConfig::get($db, 'home', 'button_color') ?? '#2563eb';
$button_text_color = PaginasConfig::get($db, 'home', 'button_text_color') ?? '#fff';
$button_add_bg = PaginasConfig::get($db, 'home', 'button_add_bg') ?? '#22c55e';
$button_add_text = PaginasConfig::get($db, 'home', 'button_add_text') ?? '#fff';
$button_details_bg = PaginasConfig::get($db, 'home', 'button_details_bg') ?? '#6366f1';
$button_details_text = PaginasConfig::get($db, 'home', 'button_details_text') ?? '#fff';
$button_promos_bg = PaginasConfig::get($db, 'home', 'button_promos_bg') ?? '#f59e42';
$button_promos_text = PaginasConfig::get($db, 'home', 'button_promos_text') ?? '#fff';
$button_best_bg = PaginasConfig::get($db, 'home', 'button_best_bg') ?? '#0ea5e9';
$button_best_text = PaginasConfig::get($db, 'home', 'button_best_text') ?? '#fff';

function produto_image($produto) {
    if (!empty($produto['imagem'])) {
        return $produto['imagem'];
    } else {
        return '/public/img/placeholder.png';
    }
}
?>
<style>
  .btn-principal {
    background: <?php echo $button_color; ?> !important;
    color: <?php echo $button_text_color; ?> !important;
    border: none;
  }
  .btn-principal:hover { filter: brightness(0.9); }
  .btn-add-carrinho {
    background: <?php echo $button_add_bg; ?> !important;
    color: <?php echo $button_add_text; ?> !important;
    border: none;
  }
  .btn-add-carrinho:hover { filter: brightness(0.9); }
  .btn-detalhes {
    background: <?php echo $button_details_bg; ?> !important;
    color: <?php echo $button_details_text; ?> !important;
    border: none;
  }
  .btn-detalhes:hover { filter: brightness(0.9); }
  .btn-promos {
    background: <?php echo $button_promos_bg; ?> !important;
    color: <?php echo $button_promos_text; ?> !important;
    border: none;
  }
  .btn-promos:hover { filter: brightness(0.9); }
  .btn-best {
    background: <?php echo $button_best_bg; ?> !important;
    color: <?php echo $button_best_text; ?> !important;
    border: none;
  }
  .btn-best:hover { filter: brightness(0.9); }
</style>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?> - Início</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col text-gray-900">
    <?php include __DIR__ . '/partials/banner_topo.php'; ?>
    <?php include __DIR__ . '/partials/header.php'; ?>
    <main class="flex-1">
        <!-- Hero Carrossel Fullscreen -->
        <section class="w-full h-[<?php echo $hero_vh; ?>vh] min-h-[300px] relative overflow-hidden hero-carousel bg-white">
            <?php foreach ($banners as $i => $banner): ?>
                <?php if (!empty($banner['link'])): ?>
                    <a href="<?php echo htmlspecialchars($banner['link']); ?>" target="_blank" class="carousel-slide block w-full h-full absolute top-0 left-0 transition-opacity duration-700 <?php echo $i === 0 ? 'opacity-100 z-20' : 'opacity-0 z-10'; ?>">
                        <img src="<?php echo htmlspecialchars($banner['imagem']); ?>" alt="Banner" class="w-full h-[<?php echo $hero_vh; ?>vh] min-h-[300px] object-cover object-center">
                    </a>
                <?php else: ?>
                    <div class="carousel-slide w-full h-full absolute top-0 left-0 transition-opacity duration-700 <?php echo $i === 0 ? 'opacity-100 z-20' : 'opacity-0 z-10'; ?>">
                        <img src="<?php echo htmlspecialchars($banner['imagem']); ?>" alt="Banner" class="w-full h-[<?php echo $hero_vh; ?>vh] min-h-[300px] object-cover object-center">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="carousel-dots absolute left-1/2 -translate-x-1/2 bottom-8 flex gap-2 z-30">
                <?php foreach ($banners as $i => $banner): ?>
                    <span class="carousel-dot w-3 h-3 rounded-full border-2 border-white bg-white/70 cursor-pointer transition <?php echo $i === 0 ? 'bg-blue-600 border-blue-600' : ''; ?>" data-index="<?php echo $i; ?>"></span>
                <?php endforeach; ?>
            </div>
        </section>

<script>
(function() {
    const slides = document.querySelectorAll('.hero-carousel .carousel-slide');
    const dots = document.querySelectorAll('.carousel-dot');
    let idx = 0;
    let interval = null;
    function show(n) {
        slides.forEach((el, i) => {
            el.classList.toggle('opacity-100', i === n);
            el.classList.toggle('opacity-0', i !== n);
            el.classList.toggle('z-20', i === n);
            el.classList.toggle('z-10', i !== n);
        });
        dots.forEach((dot, i) => {
            dot.classList.toggle('bg-blue-600', i === n);
            dot.classList.toggle('border-blue-600', i === n);
        });
        idx = n;
    }
    function next() {
        show((idx + 1) % slides.length);
    }
    interval = setInterval(next, 5000);
    dots.forEach(dot => {
        dot.addEventListener('click', function() {
            show(Number(this.dataset.index));
            clearInterval(interval);
            interval = setInterval(next, 5000);
        });
    });
})();
</script>

        <!-- Categorias -->
        <section class="py-12 px-4 bg-gray-50">
            <div class="max-w-7xl mx-auto">
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
            </div>
        </section>

        <?php if (!empty($produtos)): ?>
        <!-- Produtos em destaque -->
        <section class="py-12 px-4 bg-white">
            <div class="max-w-7xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Produtos em destaque</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <?php foreach ($produtos as $produto): ?>
                        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center border border-gray-100 hover:shadow-xl transition group relative justify-around">
                            <img src="<?php echo produto_image($produto); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="w-28 h-28 object-cover rounded-xl mb-4 border border-gray-200 group-hover:scale-105 transition">
                            <h2 class="text-lg font-semibold mb-1 text-gray-900 text-center group-hover:text-blue-600 transition"><?php echo htmlspecialchars($produto['nome']); ?></h2>
                            <p class="mb-2 text-gray-600 text-center text-sm"><?php echo htmlspecialchars($produto['descricao']); ?></p>
                            <span class="mb-4 font-bold text-blue-600 text-lg">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                            <a href="?rota=produto&id=<?php echo $produto['id']; ?>" class="block btn-detalhes px-4 py-2 rounded-full transition text-center font-semibold mb-2">Ver Detalhes</a>
                            <form method="post" action="?rota=carrinho" class="w-full">
                                <input type="hidden" name="adicionar_id" value="<?php echo $produto['id']; ?>">
                                <button type="submit" class="w-full btn-add-carrinho px-4 py-2 rounded-full transition font-bold text-base shadow">Adicionar ao Carrinho</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="flex justify-center mt-8">
                    <a href="?rota=produtos" class="btn-principal inline-block px-8 py-3 rounded-full shadow font-semibold text-lg transition">Ver todos os produtos</a>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Produtos mais vendidos -->
        <section class="bg-blue-50 py-12 px-4">
            <div class="max-w-7xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Mais Vendidos</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                    <?php foreach ($mais_vendidos as $produto): ?>
                        <div class="bg-gray-50 rounded-2xl shadow-md p-4 flex flex-col items-center border border-gray-100 hover:shadow-xl transition group relative justify-around">
                            <div class="absolute top-2 left-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full">🔥</div>
                            <img src="<?php echo produto_image($produto); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="w-20 h-20 object-cover rounded-xl mb-3 border border-gray-200 group-hover:scale-105 transition">
                            <h2 class="text-sm font-semibold mb-1 text-gray-900 text-center group-hover:text-blue-600 transition"><?php echo htmlspecialchars($produto['nome']); ?></h2>
                            <span class="mb-2 font-bold text-blue-600 text-base">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                            <form method="post" action="?rota=carrinho" class="w-full">
                                <input type="hidden" name="adicionar_id" value="<?php echo $produto['id']; ?>">
                                <button type="submit" class="w-full btn-best px-3 py-1 rounded-full font-semibold text-sm shadow">Comprar</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <?php if (!empty($promocoes)): ?>
        <!-- Produtos em promoção -->
        <section class="py-12 px-4 bg-white">
            <div class="max-w-7xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Promoções Especiais</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                    <?php foreach (
                        $promocoes as $produto): ?>
                        <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center border border-gray-100 hover:shadow-xl transition group relative justify-around">
                            <?php if ($produto['percentual_desconto']): ?>
                                <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">-<?php echo $produto['percentual_desconto']; ?>%</div>
                            <?php endif; ?>
                            <img src="<?php echo produto_image($produto); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="w-24 h-24 object-cover rounded-xl mb-4 border border-gray-200 group-hover:scale-105 transition">
                            <h2 class="text-base font-semibold mb-1 text-gray-900 text-center group-hover:text-blue-600 transition"><?php echo htmlspecialchars($produto['nome']); ?></h2>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="text-gray-400 line-through text-sm">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                                <span class="font-bold text-red-600 text-lg">R$ <?php echo number_format($produto['preco_promocional'] ?? $produto['preco'], 2, ',', '.'); ?></span>
                            </div>
                            <form method="post" action="?rota=carrinho" class="w-full">
                                <input type="hidden" name="adicionar_id" value="<?php echo $produto['id']; ?>">
                                <button type="submit" class="btn-promos w-full px-4 py-2 rounded-full font-bold text-base shadow transition">Aproveitar Oferta</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="flex justify-center mt-8">
                    <a href="?rota=produtos&promocao=1" class="btn-promos inline-block px-8 py-3 rounded-full shadow font-semibold text-lg">Ver todas as promoções</a>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <!-- Vantagens expandidas -->
        <section class="bg-gray-100 py-12 px-4">
            <div class="max-w-7xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Por que escolher a <?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?>?</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php foreach ($vantagens as $vant): ?>
                        <div class="bg-white rounded-xl shadow-md p-8 flex flex-col items-center border border-gray-100">
                            <span class="text-4xl mb-4 text-blue-600"><?php echo htmlspecialchars($vant['icone']); ?></span>
                            <h4 class="font-semibold text-lg mb-2 text-gray-900"><?php echo htmlspecialchars($vant['titulo']); ?></h4>
                            <p class="text-gray-600 text-center text-base"><?php echo htmlspecialchars($vant['descricao']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="bg-blue-600 py-12 px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h3 class="text-2xl font-bold text-white mb-4">Fique por dentro das novidades!</h3>
                <p class="text-blue-100 mb-6 text-lg">Receba ofertas exclusivas e seja o primeiro a saber sobre novos produtos</p>
                <form class="flex flex-col sm:flex-row gap-4 max-w-md mx-auto">
                    <input type="email" placeholder="Seu melhor e-mail" class="flex-1 px-4 py-3 rounded-full border-0 focus:ring-2 focus:ring-white">
                    <button type="submit" class="btn-principal bg-white text-blue-600 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">Inscrever-se</button>
                </form>
            </div>
        </section>

        <!-- FAQ -->
        <section class="bg-white py-12 px-4">
            <div class="max-w-4xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">Perguntas Frequentes</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <?php if (!empty($faqs)): ?>
                        <?php foreach ($faqs as $faq): ?>
                            <?php if (empty(trim($faq['pergunta'])) || empty(trim($faq['resposta']))) continue; ?>
                            <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                                <h4 class="font-semibold text-lg mb-2 text-gray-900"><?php echo htmlspecialchars($faq['pergunta']); ?></h4>
                                <p class="text-gray-600"><?php echo nl2br(htmlspecialchars($faq['resposta'])); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-span-full text-center text-gray-500">Nenhuma pergunta frequente cadastrada.</div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Depoimentos -->
        <section class="bg-gray-50 py-12 px-4">
            <div class="max-w-5xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">O que dizem nossos clientes</h3>
                <div class="flex flex-col md:flex-row gap-8 justify-center">
                    <?php if (count($avaliacoes) > 0): ?>
                        <?php foreach ($avaliacoes as $av): ?>
                            <div class="bg-white rounded-xl shadow-md p-6 flex-1 border border-gray-100">
                                <p class="text-gray-700 italic mb-2 text-base">"<?php echo htmlspecialchars($av['texto']); ?>"</p>
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
        <?php if (!empty($config['instagram_url'])): ?>
        <section class="py-12 px-4 bg-white">
            <div class="max-w-3xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center flex items-center justify-center gap-2">
                    <i class="fab fa-instagram text-pink-500"></i> Siga-nos no Instagram
                </h3>
                <div class="flex flex-col items-center">
                    <a href="<?php echo htmlspecialchars($config['instagram_url']); ?>" target="_blank" class="mb-6 inline-flex items-center gap-2 px-6 py-2 bg-gradient-to-r from-pink-500 to-yellow-500 text-white rounded-full font-semibold shadow hover:scale-105 transition">
                        <i class="fab fa-instagram"></i> @<?php echo preg_replace('~https?://(www\.)?instagram.com/~', '', rtrim($config['instagram_url'], '/')); ?>
                    </a>
                    <div class="w-full flex justify-center">
                        <!-- Instagram embed -->
                        <iframe src="https://www.instagram.com/<?php echo preg_replace('~https?://(www\.)?instagram.com/~', '', rtrim($config['instagram_url'], '/')); ?>/embed" width="400" height="480" frameborder="0" scrolling="no" allowtransparency="true" class="rounded-2xl shadow border border-gray-100 bg-white"></iframe>
                    </div>
                    <p class="text-center text-gray-500 mt-4">Veja as últimas novidades e promoções no nosso Instagram!</p>
                </div>
            </div>
        </section>
        <?php endif; ?>
    </main>
    <?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html> 