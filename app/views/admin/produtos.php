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
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-700">Administração - Produtos</h1>
        <nav>
            <a href="/admin/" class="text-blue-600 hover:underline">Dashboard</a>
        </nav>
    </header>
    <main class="flex-1 container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-8">Gerenciar Produtos</h2>
        <form method="post" class="mb-6 bg-white p-4 rounded shadow grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
            <div>
                <label class="block mb-1 font-semibold">Nome</label>
                <input type="text" name="nome" class="border rounded w-full p-2" required value="<?php echo htmlspecialchars($editar['nome'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Preço</label>
                <input type="number" step="0.01" name="preco" class="border rounded w-full p-2" required value="<?php echo htmlspecialchars($editar['preco'] ?? ''); ?>">
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1 font-semibold">Descrição</label>
                <textarea name="descricao" class="border rounded w-full p-2"><?php echo htmlspecialchars($editar['descricao'] ?? ''); ?></textarea>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Categoria</label>
                <select name="categoria_id" class="border rounded w-full p-2" required>
                    <option value="">Selecione</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" <?php if (($editar['categoria_id'] ?? '') == $cat['id']) echo 'selected'; ?>><?php echo htmlspecialchars($cat['icone'] . ' ' . $cat['nome']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">URL da Imagem</label>
                <input type="url" name="imagem" class="border rounded w-full p-2" placeholder="https://..." value="<?php echo htmlspecialchars($editar['imagem'] ?? ''); ?>">
            </div>
            <div class="md:col-span-2 flex items-center gap-2">
                <input type="checkbox" name="destaque" id="destaque" value="1" <?php if (($editar['destaque'] ?? 0) == 1) echo 'checked'; ?>>
                <label for="destaque" class="font-semibold">Produto em destaque</label>
            </div>
            <div class="md:col-span-2 flex items-center gap-2">
                <input type="checkbox" name="em_promocao" id="em_promocao" value="1" <?php if (($editar['em_promocao'] ?? 0) == 1) echo 'checked'; ?> onchange="togglePromocaoFields(this.checked)">
                <label for="em_promocao" class="font-semibold">Produto em promoção</label>
                <?php if ($editar): ?>
                    <span class="text-xs text-gray-500">(Valor atual: <?php echo $editar['em_promocao'] ? 'Sim' : 'Não'; ?>)</span>
                <?php endif; ?>
            </div>
            <div id="promocao_fields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4" style="display: <?php echo (($editar['em_promocao'] ?? 0) == 1) ? 'grid' : 'none'; ?>">
                <div>
                    <label class="block mb-1 font-semibold">Preço Promocional</label>
                    <input type="number" step="0.01" name="preco_promocional" class="border rounded w-full p-2" value="<?php echo htmlspecialchars($editar['preco_promocional'] ?? ''); ?>" placeholder="0.00">
                    <?php if ($editar): ?>
                        <span class="text-xs text-gray-500">(Valor atual: <?php echo $editar['preco_promocional'] ?? 'N/A'; ?>)</span>
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block mb-1 font-semibold">Percentual de Desconto (%)</label>
                    <input type="number" name="percentual_desconto" class="border rounded w-full p-2" value="<?php echo htmlspecialchars($editar['percentual_desconto'] ?? ''); ?>" placeholder="20" min="1" max="99">
                    <?php if ($editar): ?>
                        <span class="text-xs text-gray-500">(Valor atual: <?php echo $editar['percentual_desconto'] ?? 'N/A'; ?>%)</span>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Tipo de Estoque</label>
                <select name="tipo_estoque" class="border rounded w-full p-2" required onchange="this.form.estoque.disabled = (this.value !== 'controlado');">
                    <option value="ilimitado" <?php if (($editar['tipo_estoque'] ?? 'ilimitado') == 'ilimitado') echo 'selected'; ?>>Sem controle de estoque</option>
                    <option value="controlado" <?php if (($editar['tipo_estoque'] ?? '') == 'controlado') echo 'selected'; ?>>Controlar quantidade</option>
                </select>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Quantidade em Estoque</label>
                <input type="number" name="estoque" class="border rounded w-full p-2" min="0" value="<?php echo (int)($editar['estoque'] ?? 0); ?>" <?php if (($editar['tipo_estoque'] ?? 'ilimitado') != 'controlado') echo 'disabled'; ?>>
            </div>
            <div class="md:col-span-2 flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <?php echo $editar ? 'Salvar Alterações' : 'Adicionar Produto'; ?>
                </button>
                <?php if ($editar): ?>
                    <a href="?rota=produtos" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
        <h3 class="text-lg font-semibold mb-2">Produtos Cadastrados</h3>
        <form method="get" class="mb-6 bg-white p-4 rounded-xl shadow flex flex-col md:flex-row md:items-end gap-4 border border-blue-100">
            <input type="hidden" name="rota" value="produtos">
            <div class="flex-1 min-w-[180px]">
                <label class="block text-gray-700 mb-1 font-semibold">Buscar por nome</label>
                <input type="text" name="busca_nome" class="border border-blue-200 rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="Nome do produto" value="<?php echo htmlspecialchars($_GET['busca_nome'] ?? ''); ?>">
            </div>
            <div class="w-32">
                <label class="block text-gray-700 mb-1 font-semibold">Buscar por ID</label>
                <input type="number" name="busca_id" class="border border-blue-200 rounded-lg p-2 w-full focus:ring-2 focus:ring-blue-400 focus:outline-none" placeholder="ID" value="<?php echo htmlspecialchars($_GET['busca_id'] ?? ''); ?>">
            </div>
            <div class="flex gap-2 items-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 font-bold transition">Filtrar</button>
                <a href="?rota=produtos" class="text-blue-600 hover:underline font-semibold">Limpar</a>
            </div>
        </form>
        <table class="w-full bg-white rounded-2xl shadow border-blue-100 overflow-hidden p-4">
            <thead class="bg-blue-50 sticky top-0 z-10">
                <tr>
                    <th class="p-3 text-left font-bold text-blue-700">ID</th>
                    <th class="p-3 text-left font-bold text-blue-700">Nome</th>
                    <th class="p-3 text-left font-bold text-blue-700">Categoria</th>
                    <th class="p-3 text-left font-bold text-blue-700">Preço</th>
                    <th class="p-3 text-left font-bold text-blue-700">Imagem</th>
                    <th class="p-3 text-left font-bold text-blue-700">Descrição</th>
                    <th class="p-3 text-left font-bold text-blue-700">Destaque</th>
                    <th class="p-3 text-left font-bold text-blue-700">Promoção</th>
                    <th class="p-3 text-left font-bold text-blue-700">Tipo de Estoque</th>
                    <th class="p-3 text-left font-bold text-blue-700">Qtd. Estoque</th>
                    <th class="p-3 font-bold text-blue-700">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $i => $produto): ?>
                <tr class="<?php echo $i % 2 === 0 ? 'bg-white' : 'bg-blue-50'; ?> hover:bg-blue-100 transition">
                    <td class="p-3 font-mono text-xs text-gray-500"><?php echo $produto['id']; ?></td>
                    <td class="p-3 font-semibold text-blue-900"><?php echo htmlspecialchars($produto['nome']); ?></td>
                    <td class="p-3"><?php echo htmlspecialchars($produto['categoria_nome'] ?? ''); ?></td>
                    <td class="p-3 font-bold text-green-700">
                        <?php if (!empty($produto['em_promocao']) && !empty($produto['preco_promocional'])): ?>
                            <span class="text-gray-400 line-through text-sm">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></span><br>
                            <span class="text-red-600">R$ <?php echo number_format($produto['preco_promocional'], 2, ',', '.'); ?></span>
                            <?php if (!empty($produto['percentual_desconto'])): ?>
                                <br><span class="text-xs text-red-500">-<?php echo $produto['percentual_desconto']; ?>%</span>
                            <?php endif; ?>
                        <?php else: ?>
                            R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                        <?php endif; ?>
                    </td>
                    <td class="p-3">
                        <?php if (!empty($produto['imagem'])): ?>
                            <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="img" class="w-12 h-12 object-cover rounded shadow">
                        <?php else: ?>
                            <span class="text-gray-400">(sem imagem)</span>
                        <?php endif; ?>
                    </td>
                    <td class="p-3 text-gray-700 text-sm max-w-xs truncate" title="<?php echo htmlspecialchars($produto['descricao']); ?>">
                        <?php
                            $desc = $produto['descricao'] ?? '';
                            echo htmlspecialchars(mb_strimwidth($desc, 0, 50, '...'));
                        ?>
                    </td>
                    <td class="p-3 text-center"><?php echo !empty($produto['destaque']) ? '<span class=\'inline-block bg-yellow-400 text-white text-xs font-bold px-2 py-1 rounded shadow\'>Sim</span>' : 'Não'; ?></td>
                    <td class="p-3 text-center"><?php echo !empty($produto['em_promocao']) ? '<span class=\'inline-block bg-red-500 text-white text-xs font-bold px-2 py-1 rounded shadow\'>Sim</span>' : 'Não'; ?></td>
                    <td class="p-3 text-center"><?php echo ucfirst($produto['tipo_estoque'] ?? 'ilimitado'); ?></td>
                    <td class="p-3 text-center"><?php echo ($produto['tipo_estoque'] ?? 'ilimitado') == 'controlado' ? (int)$produto['estoque'] : '-'; ?></td>
                    <td class="p-3 text-center flex gap-2 justify-center">
                        <a href="?rota=produtos&editar=<?php echo $produto['id']; ?>" class="text-blue-600 hover:underline font-bold">Editar</a>
                        <a href="?rota=produtos&excluir=<?php echo $produto['id']; ?>" class="text-red-600 hover:underline font-bold" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($produtos)): ?>
                <tr><td colspan="9" class="text-center text-gray-500 p-6">Nenhum produto encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php if ($total_paginas > 1): ?>
            <div class="flex justify-center mt-8 gap-2">
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
    <footer class="bg-blue-900 text-white p-4 text-center mt-8">
        &copy; <?php echo date('Y'); ?> Loja Modelo - Admin
    </footer>
</body>
</html> 