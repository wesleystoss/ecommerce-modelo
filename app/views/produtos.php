<?php
require_once __DIR__ . '/../../config/database.php';
$db = getDB();
require_once __DIR__ . '/../../app/models/Configuracao.php';
$config = Configuracao::get($db);
require_once __DIR__ . '/../../app/models/Categoria.php';
$categorias = Categoria::all($db);
require_once __DIR__ . '/../../app/models/Produto.php';

// Filtros
$nome = $_GET['nome'] ?? '';
$preco_min = $_GET['preco_min'] ?? '';
$preco_max = $_GET['preco_max'] ?? '';
$categoria_id = $_GET['categoria'] ?? '';
$promocao = $_GET['promocao'] ?? '';

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
if ($categoria_id) {
    $where[] = 'categoria_id = ?';
    $params[] = $categoria_id;
}
if ($promocao) {
    $where[] = 'em_promocao = 1';
}
$sql = 'SELECT * FROM produtos';
if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

// Paginação
$pagina = max(1, (int)($_GET['pagina'] ?? 1));
$por_pagina = 12;
$offset = ($pagina - 1) * $por_pagina;

// Contar total de produtos para paginação
$sql_count = 'SELECT COUNT(*) FROM produtos';
if ($where) {
    $sql_count .= ' WHERE ' . implode(' AND ', $where);
}
$stmt_count = $db->prepare($sql_count);
$stmt_count->execute($params);
$total_produtos = $stmt_count->fetchColumn();
$total_paginas = ceil($total_produtos / $por_pagina);

// Buscar produtos paginados
$sql .= ' LIMIT ? OFFSET ?';
$params[] = $por_pagina;
$params[] = $offset;
$produtos = $db->prepare($sql);
$produtos->execute($params);
$produtos = $produtos->fetchAll(PDO::FETCH_ASSOC);

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
    <title>Produtos - <?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?></title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col text-gray-900">
    <?php include __DIR__ . '/partials/banner_topo.php'; ?>
    <?php include __DIR__ . '/partials/header.php'; ?>
    <main class="flex-1 max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Sidebar Filtros -->
            <aside id="filtro-sidebar" class="w-full md:w-64 bg-white rounded-2xl shadow-md border border-gray-100 p-6 mb-8 md:mb-0 sticky top-8 self-start">
                <form method="get" class="space-y-6">
                    <input type="hidden" name="rota" value="produtos">
                    <div>
                        <label class="block text-gray-700 mb-1 font-semibold flex items-center gap-2"><i class="fas fa-search"></i>Buscar</label>
                        <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" class="border border-gray-300 rounded-lg w-full p-3" placeholder="Nome do produto...">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-1 font-semibold flex items-center gap-2"><i class="fas fa-list"></i>Categoria</label>
                        <select name="categoria" class="border border-gray-300 rounded-lg w-full p-3">
                            <option value="">Todas</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php if ($categoria_id == $cat['id']) echo 'selected'; ?>><?php echo htmlspecialchars($cat['nome']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label class="block text-gray-700 mb-1 font-semibold flex items-center gap-2"><i class="fas fa-arrow-down"></i>Preço mín.</label>
                            <input type="number" step="0.01" name="preco_min" value="<?php echo htmlspecialchars($preco_min); ?>" class="border border-gray-300 rounded-lg w-full p-3" placeholder="0.00">
                        </div>
                        <div class="flex-1">
                            <label class="block text-gray-700 mb-1 font-semibold flex items-center gap-2"><i class="fas fa-arrow-up"></i>Preço máx.</label>
                            <input type="number" step="0.01" name="preco_max" value="<?php echo htmlspecialchars($preco_max); ?>" class="border border-gray-300 rounded-lg w-full p-3" placeholder="9999.99">
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="promocao" id="promocao" value="1" <?php if ($promocao) echo 'checked'; ?> class="w-4 h-4">
                        <label for="promocao" class="text-gray-700 font-semibold flex items-center gap-2"><i class="fas fa-bolt text-red-500"></i>Somente promoções</label>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition-all">Filtrar</button>
                        <a href="?rota=produtos" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition-all text-center">Limpar</a>
                    </div>
                </form>
            </aside>
            <!-- Grid Produtos -->
            <section class="flex-1">
                <div class="flex items-center justify-between mb-6 flex-wrap gap-2">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Produtos</h1>
                    <span class="text-gray-500 text-sm md:text-base"><?php echo $total_produtos; ?> produto<?php echo $total_produtos == 1 ? '' : 's'; ?> encontrado<?php echo $total_produtos == 1 ? '' : 's'; ?></span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                    <?php foreach ($produtos as $produto): ?>
                        <div class="relative bg-white rounded-2xl shadow-md border border-gray-100 p-6 flex flex-col items-center hover:shadow-xl hover:scale-105 transition-all duration-200 group min-h-[420px]">
                            <?php if (!empty($produto['em_promocao']) && !empty($produto['percentual_desconto'])): ?>
                                <div class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">-<?php echo $produto['percentual_desconto']; ?>%</div>
                            <?php endif; ?>
                            <?php if (!empty($produto['destaque'])): ?>
                                <span class="absolute top-3 <?php echo !empty($produto['em_promocao']) ? 'left-3' : 'right-3'; ?> bg-gradient-to-r from-yellow-400 to-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg uppercase tracking-wider">Destaque</span>
                            <?php endif; ?>
                            <img src="<?php echo produto_image($produto); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="w-32 h-32 object-cover rounded-xl mb-4 border border-gray-200 group-hover:scale-110 transition-all duration-200 shadow">
                            <h2 class="text-lg font-semibold mb-1 text-gray-900 text-center group-hover:text-blue-600 transition"><?php echo htmlspecialchars($produto['nome']); ?></h2>
                            <div class="mb-2">
                                <?php if (!empty($produto['em_promocao']) && !empty($produto['preco_promocional'])): ?>
                                    <span class="text-gray-400 line-through text-sm">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span><br>
                                    <span class="font-bold text-red-600 text-lg">R$ <?php echo number_format($produto['preco_promocional'], 2, ',', '.'); ?></span>
                                <?php else: ?>
                                    <span class="font-bold text-blue-600 text-lg">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                                <?php endif; ?>
                            </div>
                            <p class="mb-4 text-gray-600 text-center text-sm line-clamp-2 min-h-[38px]"> <?php echo htmlspecialchars($produto['descricao']); ?> </p>
                            <div class="flex flex-col gap-2 w-full mt-auto">
                                <a href="?rota=produto&id=<?php echo $produto['id']; ?>" class="block bg-blue-50 text-blue-700 px-4 py-2 rounded-full hover:bg-blue-100 transition text-center font-semibold shadow">Ver Detalhes</a>
                                <form method="post" action="?rota=carrinho" class="w-full">
                                    <input type="hidden" name="adicionar_id" value="<?php echo $produto['id']; ?>">
                                    <button type="submit" class="w-full <?php echo !empty($produto['em_promocao']) ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600'; ?> text-white px-4 py-2 rounded-full transition font-bold text-base shadow">
                                        <?php echo !empty($produto['em_promocao']) ? 'Aproveitar Oferta' : 'Adicionar ao Carrinho'; ?>
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty($produtos)): ?>
                        <div class="col-span-full text-center text-gray-500">Nenhum produto encontrado.</div>
                    <?php endif; ?>
                </div>
                <?php if ($total_paginas > 1): ?>
                    <div class="flex justify-center mt-10 gap-2">
                        <?php if ($pagina > 1): ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['pagina' => $pagina-1])); ?>" class="px-4 py-2 rounded-full border bg-white text-blue-700 border-blue-200 hover:bg-blue-50 transition text-xl">&#8592;</a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['pagina' => $i])); ?>"
                               class="px-4 py-2 rounded-full border <?php echo $i == $pagina ? 'bg-blue-600 text-white border-blue-600 font-bold' : 'bg-white text-blue-700 border-blue-200 hover:bg-blue-50'; ?> transition text-lg">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        <?php if ($pagina < $total_paginas): ?>
                            <a href="?<?php echo http_build_query(array_merge($_GET, ['pagina' => $pagina+1])); ?>" class="px-4 py-2 rounded-full border bg-white text-blue-700 border-blue-200 hover:bg-blue-50 transition text-xl">&#8594;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </section>
        </div>
    </main>
    <?php include __DIR__ . '/partials/footer.php'; ?>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    function ajustarStickyFiltro() {
        const header = document.querySelector('header');
        const filtro = document.getElementById('filtro-sidebar');
        if (header && filtro) {
            let headerHeight = header.offsetHeight;
            const topbar = document.querySelector('.topbar, .top-bar, .navbar');
            if (topbar) headerHeight += topbar.offsetHeight;
            filtro.style.top = (headerHeight + 16) + 'px'; // 16px extra de espaçamento
        }
    }
    ajustarStickyFiltro();
    window.addEventListener('resize', ajustarStickyFiltro);
});
</script>
</body>
</html> 