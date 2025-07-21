<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/models/Produto.php';
require_once __DIR__ . '/../../../app/models/Categoria.php';

// Debug - capturar todos os dados POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $debug_post = [
        'timestamp' => date('Y-m-d H:i:s'),
        'method' => $_SERVER['REQUEST_METHOD'],
        'url' => $_SERVER['REQUEST_URI'],
        'post_data' => $_POST,
        'get_data' => $_GET,
        'has_id' => !empty($_POST['id']),
        'id_value' => $_POST['id'] ?? 'N/A'
    ];
    file_put_contents(__DIR__ . '/../../../debug_promocao.log', "DEBUG POST RECEBIDO: " . print_r($debug_post, true) . "\n\n", FILE_APPEND);
}

$db = getDB();

// Buscar produto para edição
$editar = null;
if (isset($_GET['editar'])) {
    $editar = Produto::find($db, $_GET['editar']);
    
    // Debug - verificar dados carregados
    $debug_editar = [
        'timestamp' => date('Y-m-d H:i:s'),
        'id_buscado' => $_GET['editar'],
        'dados_carregados' => $editar
    ];
    file_put_contents(__DIR__ . '/../../../debug_promocao.log', "Dados carregados para edição: " . print_r($debug_editar, true) . "\n\n", FILE_APPEND);
}
$busca_nome = $_GET['busca_nome'] ?? '';
$busca_id = $_GET['busca_id'] ?? '';
$pagina = max(1, (int)($_GET['pagina'] ?? 1));
$por_pagina = 10;
$offset = ($pagina - 1) * $por_pagina;
$where = [];
$params = [];
if ($busca_nome) {
    $where[] = 'p.nome LIKE ?';
    $params[] = "%$busca_nome%";
}
if ($busca_id) {
    $where[] = 'p.id = ?';
    $params[] = $busca_id;
}
$sql = 'SELECT p.*, c.nome as categoria_nome FROM produtos p LEFT JOIN categorias c ON p.categoria_id = c.id';
if ($where) {
    $sql .= ' WHERE ' . implode(' AND ', $where);
}
// Contar total de produtos para paginação
$sql_count = 'SELECT COUNT(*) FROM produtos p';
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
$stmt = $db->prepare($sql);
$stmt->execute($params);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
$categorias = Categoria::all($db);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Produtos</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <?php include __DIR__.'/_sidebar.php'; ?>
    <div class="pl-64 min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-lg border-b border-gray-200">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-box text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Gerenciar Produtos
                            </h1>
                            <p class="text-sm text-gray-600">Administração de Produtos</p>
                        </div>
                    </div>
                    <nav class="flex items-center space-x-6">
                        <a href="/" class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition-colors">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Ver Site</span>
                        </a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-8">
            <!-- Form Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <?php echo $editar ? 'Editar Produto' : 'Adicionar Novo Produto'; ?>
                    </h2>
                    <?php if ($editar): ?>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                            Editando ID: <?php echo $editar['id']; ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
                    
                    <!-- Nome -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-tag mr-2 text-blue-600"></i>Nome do Produto
                        </label>
                        <input type="text" name="nome" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required value="<?php echo htmlspecialchars($editar['nome'] ?? ''); ?>">
                    </div>
                    
                    <!-- Preço -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-dollar-sign mr-2 text-green-600"></i>Preço
                        </label>
                        <input type="number" step="0.01" name="preco" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required value="<?php echo htmlspecialchars($editar['preco'] ?? ''); ?>">
                    </div>
                    
                    <!-- Categoria -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-folder mr-2 text-purple-600"></i>Categoria
                        </label>
                        <select name="categoria_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required>
                            <option value="">Selecione uma categoria</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php if (($editar['categoria_id'] ?? '') == $cat['id']) echo 'selected'; ?>>
                                    <?php echo htmlspecialchars($cat['icone'] . ' ' . $cat['nome']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Descrição -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-2 text-gray-600"></i>Descrição
                        </label>
                        <textarea name="descricao" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"><?php echo htmlspecialchars($editar['descricao'] ?? ''); ?></textarea>
                    </div>
                    
                    <!-- URL da Imagem -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-image mr-2 text-pink-600"></i>URL da Imagem
                        </label>
                        <input type="url" name="imagem" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="https://..." value="<?php echo htmlspecialchars($editar['imagem'] ?? ''); ?>">
                    </div>
                    
                    <!-- Checkboxes -->
                    <div class="md:col-span-2 space-y-4">
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <input type="checkbox" name="destaque" id="destaque" value="1" <?php if (($editar['destaque'] ?? 0) == 1) echo 'checked'; ?> class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="destaque" class="ml-3 text-sm font-medium text-gray-700">
                                <i class="fas fa-star mr-2 text-yellow-500"></i>Produto em destaque
                            </label>
                        </div>
                        
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <input type="checkbox" name="em_promocao" id="em_promocao" value="1" <?php if (($editar['em_promocao'] ?? 0) == 1) echo 'checked'; ?> onchange="togglePromocaoFields(this.checked)" class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <label for="em_promocao" class="ml-3 text-sm font-medium text-gray-700">
                                <i class="fas fa-percentage mr-2 text-red-500"></i>Produto em promoção
                            </label>
                            <?php if ($editar): ?>
                                <span class="ml-2 text-xs text-gray-500">(Atual: <?php echo $editar['em_promocao'] ? 'Sim' : 'Não'; ?>)</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Campos de Promoção -->
                    <div id="promocao_fields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-red-50 rounded-xl border border-red-200" style="display: <?php echo (($editar['em_promocao'] ?? 0) == 1) ? 'grid' : 'none'; ?>">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-tags mr-2 text-red-600"></i>Preço Promocional
                            </label>
                            <input type="number" step="0.01" name="preco_promocional" class="w-full px-4 py-3 border border-red-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($editar['preco_promocional'] ?? ''); ?>" placeholder="0.00">
                            <?php if ($editar): ?>
                                <p class="text-xs text-gray-500 mt-1">Atual: <?php echo $editar['preco_promocional'] ?? 'N/A'; ?></p>
                            <?php endif; ?>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-percent mr-2 text-red-600"></i>Percentual de Desconto (%)
                            </label>
                            <input type="number" name="percentual_desconto" class="w-full px-4 py-3 border border-red-200 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($editar['percentual_desconto'] ?? ''); ?>" placeholder="20" min="1" max="99">
                            <?php if ($editar): ?>
                                <p class="text-xs text-gray-500 mt-1">Atual: <?php echo $editar['percentual_desconto'] ?? 'N/A'; ?>%</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Tipo de Estoque -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-warehouse mr-2 text-indigo-600"></i>Tipo de Estoque
                        </label>
                        <select name="tipo_estoque" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required onchange="this.form.estoque.disabled = (this.value !== 'controlado');">
                            <option value="ilimitado" <?php if (($editar['tipo_estoque'] ?? 'ilimitado') == 'ilimitado') echo 'selected'; ?>>Sem controle de estoque</option>
                            <option value="controlado" <?php if (($editar['tipo_estoque'] ?? '') == 'controlado') echo 'selected'; ?>>Controlar quantidade</option>
                        </select>
                    </div>
                    
                    <!-- Quantidade em Estoque -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-cubes mr-2 text-indigo-600"></i>Quantidade em Estoque
                        </label>
                        <input type="number" name="estoque" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" min="0" value="<?php echo (int)($editar['estoque'] ?? 0); ?>" <?php if (($editar['tipo_estoque'] ?? 'ilimitado') != 'controlado') echo 'disabled'; ?>>
                    </div>
                    
                    <!-- Botões -->
                    <div class="md:col-span-2 flex gap-4 pt-4">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            <?php echo $editar ? 'Salvar Alterações' : 'Adicionar Produto'; ?>
                        </button>
                        <?php if ($editar): ?>
                            <a href="?rota=produtos" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Search Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    <i class="fas fa-search mr-2 text-blue-600"></i>Buscar Produtos
                </h3>
                <form method="get" class="flex flex-col md:flex-row gap-4">
                    <input type="hidden" name="rota" value="produtos">
                    <div class="flex-1">
                        <input type="text" name="busca_nome" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Buscar por nome do produto" value="<?php echo htmlspecialchars($_GET['busca_nome'] ?? ''); ?>">
                    </div>
                    <div class="w-32">
                        <input type="number" name="busca_id" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="ID" value="<?php echo htmlspecialchars($_GET['busca_id'] ?? ''); ?>">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700 transition-all">
                            <i class="fas fa-search mr-2"></i>Filtrar
                        </button>
                        <a href="?rota=produtos" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                            <i class="fas fa-times mr-2"></i>Limpar
                        </a>
                    </div>
                </form>
            </div>

            <!-- Products Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-list mr-2 text-blue-600"></i>Produtos Cadastrados
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preço</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estoque</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($produtos as $i => $produto): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-500">#<?php echo $produto['id']; ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <?php if ($produto['imagem']): ?>
                                            <img class="h-10 w-10 rounded-lg object-cover mr-3" src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                                        <?php else: ?>
                                            <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center mr-3">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($produto['nome']); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo htmlspecialchars(substr($produto['descricao'], 0, 50)) . (strlen($produto['descricao']) > 50 ? '...' : ''); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php echo htmlspecialchars($produto['categoria_nome'] ?? ''); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if (!empty($produto['em_promocao']) && !empty($produto['preco_promocional'])): ?>
                                        <div class="text-sm">
                                            <span class="text-gray-400 line-through">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                                            <div class="text-red-600 font-semibold">R$ <?php echo number_format($produto['preco_promocional'], 2, ',', '.'); ?></div>
                                            <?php if (!empty($produto['percentual_desconto'])): ?>
                                                <span class="text-xs text-red-500 bg-red-100 px-2 py-1 rounded-full">-<?php echo $produto['percentual_desconto']; ?>%</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-sm font-semibold text-gray-900">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col space-y-1">
                                        <?php if ($produto['destaque']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-star mr-1"></i>Destaque
                                            </span>
                                        <?php endif; ?>
                                        <?php if ($produto['em_promocao']): ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-percentage mr-1"></i>Promoção
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <?php if ($produto['tipo_estoque'] === 'controlado'): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <?php echo $produto['estoque']; ?> unidades
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Ilimitado
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="?rota=produtos&editar=<?php echo $produto['id']; ?>" class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?rota=produtos&excluir=<?php echo $produto['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este produto?')" class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <!-- Paginação -->
                <?php if ($total_paginas > 1): ?>
                <div class="flex justify-center mt-8 p-4">
                    <nav class="inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                        <?php if ($pagina > 1): ?>
                            <a href="?rota=produtos&pagina=<?php echo $pagina-1; ?><?php echo $busca_nome ? '&busca_nome='.urlencode($busca_nome) : ''; ?><?php echo $busca_id ? '&busca_id='.urlencode($busca_id) : ''; ?>" class="relative inline-flex items-center px-3 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                            <a href="?rota=produtos&pagina=<?php echo $i; ?><?php echo $busca_nome ? '&busca_nome='.urlencode($busca_nome) : ''; ?><?php echo $busca_id ? '&busca_id='.urlencode($busca_id) : ''; ?>"
                               class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium <?php echo $i == $pagina ? 'text-blue-600 font-bold bg-blue-50' : 'text-gray-500 hover:bg-gray-50'; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>
                        <?php if ($pagina < $total_paginas): ?>
                            <a href="?rota=produtos&pagina=<?php echo $pagina+1; ?><?php echo $busca_nome ? '&busca_nome='.urlencode($busca_nome) : ''; ?><?php echo $busca_id ? '&busca_id='.urlencode($busca_id) : ''; ?>" class="relative inline-flex items-center px-3 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        <?php endif; ?>
                    </nav>
                </div>
                <?php endif; ?>
            </div>
        </main>

        <script>
            function togglePromocaoFields(checked) {
                const fields = document.getElementById('promocao_fields');
                fields.style.display = checked ? 'grid' : 'none';
            }
            
            // Debug: verificar se os valores estão sendo carregados
            document.addEventListener('DOMContentLoaded', function() {
                const promocaoCheckbox = document.getElementById('em_promocao');
                const promocaoFields = document.getElementById('promocao_fields');
                const form = document.querySelector('form');
                
                if (promocaoCheckbox && promocaoFields) {
                    console.log('Checkbox promoção:', promocaoCheckbox.checked);
                    console.log('Campos promoção visíveis:', promocaoFields.style.display);
                    
                    // Garantir que os campos sejam exibidos se o checkbox estiver marcado
                    if (promocaoCheckbox.checked) {
                        promocaoFields.style.display = 'grid';
                    }
                }
                
                // Debug do formulário
                if (form) {
                    console.log('Formulário encontrado:', form);
                    
                    // Adicionar listener para debug do envio
                    form.addEventListener('submit', function(e) {
                        console.log('Formulário sendo enviado...');
                        console.log('Dados do formulário:', new FormData(form));
                        
                        // Verificar se há campos obrigatórios vazios
                        const requiredFields = form.querySelectorAll('[required]');
                        let hasErrors = false;
                        
                        requiredFields.forEach(field => {
                            if (!field.value.trim()) {
                                console.error('Campo obrigatório vazio:', field.name);
                                hasErrors = true;
                            }
                        });
                        
                        if (hasErrors) {
                            e.preventDefault();
                            alert('Por favor, preencha todos os campos obrigatórios.');
                            return false;
                        }
                        
                        console.log('Formulário válido, enviando...');
                    });
                }
            });
        </script>
    </div>
</body>
</html> 