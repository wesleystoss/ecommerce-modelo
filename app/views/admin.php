<?php
require_once __DIR__ . '/../../config/database.php';
$db = getDB();

// Adicionar produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['preco']) && empty($_POST['id'])) {
    $stmt = $db->prepare('INSERT INTO produtos (nome, descricao, preco, imagem) VALUES (?, ?, ?, ?)');
    $stmt->execute([
        $_POST['nome'],
        $_POST['descricao'] ?? '',
        $_POST['preco'],
        $_POST['imagem'] ?? ''
    ]);
}
// Editar produto
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && $_POST['id']) {
    $stmt = $db->prepare('UPDATE produtos SET nome=?, descricao=?, preco=?, imagem=? WHERE id=?');
    $stmt->execute([
        $_POST['nome'],
        $_POST['descricao'] ?? '',
        $_POST['preco'],
        $_POST['imagem'] ?? '',
        $_POST['id']
    ]);
}
// Excluir produto
if (isset($_GET['excluir'])) {
    $stmt = $db->prepare('DELETE FROM produtos WHERE id = ?');
    $stmt->execute([$_GET['excluir']]);
}
// Buscar produto para edição
$editar = null;
if (isset($_GET['editar'])) {
    $stmt = $db->prepare('SELECT * FROM produtos WHERE id = ?');
    $stmt->execute([$_GET['editar']]);
    $editar = $stmt->fetch(PDO::FETCH_ASSOC);
}
$produtos = $db->query('SELECT * FROM produtos')->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administração - Loja Modelo</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Administração</h1>
        <nav>
            <a href="/" class="mr-4 text-blue-600 hover:underline">Início</a>
            <a href="?rota=produtos" class="mr-4 text-blue-600 hover:underline">Produtos</a>
            <a href="?rota=carrinho" class="text-blue-600 hover:underline">Carrinho</a>
        </nav>
    </header>
    <main class="flex-1 container mx-auto p-4">
        <h2 class="text-xl font-semibold mb-4">Gerenciar Produtos</h2>
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
            <div class="md:col-span-2">
                <label class="block mb-1 font-semibold">URL da Imagem</label>
                <input type="url" name="imagem" class="border rounded w-full p-2" placeholder="https://..." value="<?php echo htmlspecialchars($editar['imagem'] ?? ''); ?>">
            </div>
            <div class="md:col-span-2 flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <?php echo $editar ? 'Salvar Alterações' : 'Adicionar Produto'; ?>
                </button>
                <?php if ($editar): ?>
                    <a href="?rota=admin" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
        <h3 class="text-lg font-semibold mb-2">Produtos Cadastrados</h3>
        <table class="w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="p-2 text-left">Nome</th>
                    <th class="p-2 text-left">Descrição</th>
                    <th class="p-2 text-left">Preço</th>
                    <th class="p-2 text-left">Imagem</th>
                    <th class="p-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                    <tr>
                        <td class="p-2"><?php echo htmlspecialchars($produto['nome']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($produto['descricao']); ?></td>
                        <td class="p-2">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></td>
                        <td class="p-2">
                            <?php if (!empty($produto['imagem'])): ?>
                                <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="img" class="w-12 h-12 object-cover rounded">
                            <?php else: ?>
                                <span class="text-gray-400">(sem imagem)</span>
                            <?php endif; ?>
                        </td>
                        <td class="p-2 text-center">
                            <a href="?rota=admin&editar=<?php echo $produto['id']; ?>" class="text-blue-600 hover:underline mr-2">Editar</a>
                            <a href="?rota=admin&excluir=<?php echo $produto['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <footer class="bg-white shadow p-4 text-center text-gray-500">
        &copy; <?php echo date('Y'); ?> Loja Modelo
    </footer>
</body>
</html> 