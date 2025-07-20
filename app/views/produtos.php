<?php
require_once __DIR__ . '/../../config/database.php';
$db = getDB();
require_once __DIR__ . '/../../app/models/Configuracao.php';
$config = Configuracao::get($db);
require_once __DIR__ . '/../../app/models/Categoria.php';
$categorias = Categoria::all($db);
include __DIR__ . '/partials/header.php';

// Filtros
$nome = $_GET['nome'] ?? '';
$preco_min = $_GET['preco_min'] ?? '';
$preco_max = $_GET['preco_max'] ?? '';
$categoria_id = $_GET['categoria'] ?? '';

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
$sql = 'SELECT * FROM produtos';
if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

// Paginação
$pagina = max(1, (int)($_GET['pagina'] ?? 1));
$por_pagina = 10;
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
    <title>Produtos - Loja Modelo</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col text-gray-900">
    <main class="flex-1 container mx-auto p-4">
        <form method="get" class="mb-10 bg-white rounded-2xl shadow-md p-8 flex flex-col md:flex-row md:items-end gap-6 border border-gray-100">
            <input type="hidden" name="rota" value="produtos">
            <div class="flex-1">
                <label class="block text-gray-700 mb-1 font-semibold flex items-center gap-2"><span>🔎</span>Buscar por nome</label>
                <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" class="border border-gray-300 rounded-lg w-full p-3" placeholder="Digite o nome do produto...">
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-semibold flex items-center gap-2"><span>📂</span>Categoria</label>
                <select name="categoria" class="border border-gray-300 rounded-lg w-full p-3">
                    <option value="">Todas</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if ($categoria_id == $cat['id']) echo 'selected'; ?>><?php echo htmlspecialchars($cat['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-semibold flex items-center gap-2"><span>💰</span>Preço mínimo</label>
                <input type="number" step="0.01" name="preco_min" value="<?php echo htmlspecialchars($preco_min); ?>" class="border border-gray-300 rounded-lg w-full p-3" placeholder="0.00">
            </div>
            <div>
                <label class="block text-gray-700 mb-1 font-semibold flex items-center gap-2"><span>💸</span>Preço máximo</label>
                <input type="number" step="0.01" name="preco_max" value="<?php echo htmlspecialchars($preco_max); ?>" class="border border-gray-300 rounded-lg w-full p-3" placeholder="9999.99">
            </div>
            <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-full shadow hover:bg-blue-700 transition font-semibold text-lg">Filtrar</button>
        </form>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-10">
            <?php foreach ($produtos as $produto): ?>
                <div class="relative bg-white rounded-2xl shadow-md border border-gray-100 p-6 flex flex-col items-center hover:shadow-xl hover:scale-105 transition-all duration-200 group min-h-[420px]">
                    <?php if (!empty($produto['destaque'])): ?>
                        <span class="absolute top-3 right-3 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg uppercase tracking-wider">Destaque</span>
                    <?php endif; ?>
                    <img src="<?php echo produto_image($produto); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="w-32 h-32 object-cover rounded-xl mb-4 border border-gray-200 group-hover:scale-110 transition-all duration-200 shadow">
                    <h2 class="text-lg font-semibold mb-1 text-gray-900 text-center group-hover:text-blue-600 transition"><?php echo htmlspecialchars($produto['nome']); ?></h2>
                    <span class="mb-2 font-bold text-xl text-blue-600 block">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                    <p class="mb-4 text-gray-600 text-center text-sm line-clamp-2 min-h-[38px]"> <?php echo htmlspecialchars($produto['descricao']); ?> </p>
                    <div class="flex flex-col gap-2 w-full mt-auto">
                        <a href="?rota=produto&id=<?php echo $produto['id']; ?>" class="block bg-blue-50 text-blue-700 px-4 py-2 rounded-full hover:bg-blue-100 transition text-center font-semibold shadow">Ver Detalhes</a>
                        <form method="post" action="?rota=carrinho" class="w-full">
                            <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                            <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition font-bold text-base shadow">Adicionar ao Carrinho</button>
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
    </main>
    <?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html> 