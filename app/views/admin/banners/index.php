<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Banners</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-700">Administração - Banners</h1>
        <nav>
            <a href="/admin/" class="text-blue-600 hover:underline">Dashboard</a>
        </nav>
    </header>
    <main class="flex-1 container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-8">Gerenciar Banners</h2>
        <form method="post" class="mb-6 bg-white p-4 rounded shadow grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
            <div>
                <label class="block mb-1 font-semibold">Título</label>
                <input type="text" name="titulo" class="border rounded w-full p-2" required value="<?php echo htmlspecialchars($editar['titulo'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">URL da Imagem</label>
                <input type="url" name="imagem" class="border rounded w-full p-2" required value="<?php echo htmlspecialchars($editar['imagem'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Link (opcional)</label>
                <input type="url" name="link" class="border rounded w-full p-2" value="<?php echo htmlspecialchars($editar['link'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Ordem</label>
                <input type="number" name="ordem" class="border rounded w-full p-2" value="<?php echo htmlspecialchars($editar['ordem'] ?? 0); ?>">
            </div>
            <div class="md:col-span-2 flex items-center gap-2">
                <input type="checkbox" name="ativo" id="ativo" value="1" <?php if (($editar['ativo'] ?? 1) == 1) echo 'checked'; ?>>
                <label for="ativo" class="font-semibold">Ativo</label>
            </div>
            <div class="md:col-span-2 flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <?php echo $editar ? 'Salvar Alterações' : 'Adicionar Banner'; ?>
                </button>
                <?php if ($editar): ?>
                    <a href="?rota=banners" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
        <h3 class="text-lg font-semibold mb-2">Banners Cadastrados</h3>
        <table class="w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="p-2 text-left">Título</th>
                    <th class="p-2 text-left">Imagem</th>
                    <th class="p-2 text-left">Link</th>
                    <th class="p-2 text-left">Ordem</th>
                    <th class="p-2 text-left">Ativo</th>
                    <th class="p-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($banners as $ban): ?>
                    <tr>
                        <td class="p-2"><?php echo htmlspecialchars($ban['titulo']); ?></td>
                        <td class="p-2"><?php if ($ban['imagem']): ?><img src="<?php echo htmlspecialchars($ban['imagem']); ?>" alt="img" class="w-16 h-10 object-cover rounded"><?php endif; ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($ban['link']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($ban['ordem']); ?></td>
                        <td class="p-2 text-center"><?php echo $ban['ativo'] ? 'Sim' : 'Não'; ?></td>
                        <td class="p-2 text-center">
                            <a href="?rota=banners&editar=<?php echo $ban['id']; ?>" class="text-blue-600 hover:underline mr-2">Editar</a>
                            <a href="?rota=banners&excluir=<?php echo $ban['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
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