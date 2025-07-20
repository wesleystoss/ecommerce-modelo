<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/models/Categoria.php';
$db = getDB();

// Adicionar categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['id'])) {
    Categoria::create($db, [
        'nome' => $_POST['nome'],
        'icone' => $_POST['icone'],
        'descricao' => $_POST['descricao']
    ]);
    header('Location: ?rota=categorias');
    exit;
}
// Editar categoria
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    Categoria::update($db, $_POST['id'], [
        'nome' => $_POST['nome'],
        'icone' => $_POST['icone'],
        'descricao' => $_POST['descricao']
    ]);
    header('Location: ?rota=categorias');
    exit;
}
// Excluir categoria
if (isset($_GET['excluir'])) {
    Categoria::delete($db, $_GET['excluir']);
    header('Location: ?rota=categorias');
    exit;
}
// Buscar categoria para edição
$editar = null;
if (isset($_GET['editar'])) {
    $editar = Categoria::find($db, $_GET['editar']);
}
$categorias = Categoria::all($db);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Categorias</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-700">Administração - Categorias</h1>
        <nav>
            <a href="/admin/" class="text-blue-600 hover:underline">Dashboard</a>
        </nav>
    </header>
    <main class="flex-1 container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-8">Gerenciar Categorias</h2>
        <form method="post" class="mb-6 bg-white p-4 rounded shadow grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
            <div>
                <label class="block mb-1 font-semibold">Nome</label>
                <input type="text" name="nome" class="border rounded w-full p-2" required value="<?php echo htmlspecialchars($editar['nome'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Ícone (emoji)</label>
                <input type="text" name="icone" class="border rounded w-full p-2" maxlength="2" placeholder="👕" value="<?php echo htmlspecialchars($editar['icone'] ?? ''); ?>">
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1 font-semibold">Descrição</label>
                <textarea name="descricao" class="border rounded w-full p-2"><?php echo htmlspecialchars($editar['descricao'] ?? ''); ?></textarea>
            </div>
            <div class="md:col-span-2 flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <?php echo $editar ? 'Salvar Alterações' : 'Adicionar Categoria'; ?>
                </button>
                <?php if ($editar): ?>
                    <a href="?rota=categorias" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
        <h3 class="text-lg font-semibold mb-2">Categorias Cadastradas</h3>
        <table class="w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="p-2 text-left">Nome</th>
                    <th class="p-2 text-left">Ícone</th>
                    <th class="p-2 text-left">Descrição</th>
                    <th class="p-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $cat): ?>
                    <tr>
                        <td class="p-2"><?php echo htmlspecialchars($cat['nome']); ?></td>
                        <td class="p-2 text-2xl"><?php echo htmlspecialchars($cat['icone']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($cat['descricao']); ?></td>
                        <td class="p-2 text-center">
                            <a href="?rota=categorias&editar=<?php echo $cat['id']; ?>" class="text-blue-600 hover:underline mr-2">Editar</a>
                            <a href="?rota=categorias&excluir=<?php echo $cat['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
    <footer class="bg-blue-900 text-white p-4 text-center mt-8">
        &copy; <?php echo date('Y'); ?> Loja Modelo - Admin
    </footer>
</body>
</html> 