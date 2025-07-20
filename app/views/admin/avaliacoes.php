<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/models/Avaliacao.php';
$db = getDB();

// Adicionar avaliação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['id'])) {
    Avaliacao::create($db, [
        'nome_cliente' => $_POST['nome_cliente'],
        'texto' => $_POST['texto'],
        'nota' => $_POST['nota']
    ]);
    header('Location: ?rota=avaliacoes');
    exit;
}
// Editar avaliação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    Avaliacao::update($db, $_POST['id'], [
        'nome_cliente' => $_POST['nome_cliente'],
        'texto' => $_POST['texto'],
        'nota' => $_POST['nota']
    ]);
    header('Location: ?rota=avaliacoes');
    exit;
}
// Excluir avaliação
if (isset($_GET['excluir'])) {
    Avaliacao::delete($db, $_GET['excluir']);
    header('Location: ?rota=avaliacoes');
    exit;
}
// Buscar avaliação para edição
$editar = null;
if (isset($_GET['editar'])) {
    $editar = Avaliacao::find($db, $_GET['editar']);
}
$avaliacoes = Avaliacao::all($db);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Avaliações</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-700">Administração - Avaliações</h1>
        <nav>
            <a href="/admin/" class="text-blue-600 hover:underline">Dashboard</a>
        </nav>
    </header>
    <main class="flex-1 container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-8">Gerenciar Avaliações</h2>
        <form method="post" class="mb-6 bg-white p-4 rounded shadow grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
            <div>
                <label class="block mb-1 font-semibold">Nome do Cliente</label>
                <input type="text" name="nome_cliente" class="border rounded w-full p-2" required value="<?php echo htmlspecialchars($editar['nome_cliente'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Nota</label>
                <select name="nota" class="border rounded w-full p-2" required>
                    <option value="">Selecione</option>
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php if (($editar['nota'] ?? '') == $i) echo 'selected'; ?>><?php echo str_repeat('⭐', $i); ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block mb-1 font-semibold">Texto</label>
                <textarea name="texto" class="border rounded w-full p-2" required><?php echo htmlspecialchars($editar['texto'] ?? ''); ?></textarea>
            </div>
            <div class="md:col-span-2 flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <?php echo $editar ? 'Salvar Alterações' : 'Adicionar Avaliação'; ?>
                </button>
                <?php if ($editar): ?>
                    <a href="?rota=avaliacoes" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
        <h3 class="text-lg font-semibold mb-2">Avaliações Cadastradas</h3>
        <table class="w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="p-2 text-left">Cliente</th>
                    <th class="p-2 text-left">Nota</th>
                    <th class="p-2 text-left">Texto</th>
                    <th class="p-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($avaliacoes as $av): ?>
                    <tr>
                        <td class="p-2"><?php echo htmlspecialchars($av['nome_cliente']); ?></td>
                        <td class="p-2 text-xl"><?php echo str_repeat('⭐', (int)$av['nota']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($av['texto']); ?></td>
                        <td class="p-2 text-center">
                            <a href="?rota=avaliacoes&editar=<?php echo $av['id']; ?>" class="text-blue-600 hover:underline mr-2">Editar</a>
                            <a href="?rota=avaliacoes&excluir=<?php echo $av['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
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