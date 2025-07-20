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
    <title>Admin - Clientes</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-700">Administração - Clientes</h1>
        <nav>
            <a href="/admin/" class="text-blue-600 hover:underline">Dashboard</a>
        </nav>
    </header>
    <main class="flex-1 container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-8">Gerenciar Clientes</h2>
        <form method="post" class="mb-6 bg-white p-4 rounded shadow grid grid-cols-1 md:grid-cols-2 gap-4">
            <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
            <div>
                <label class="block mb-1 font-semibold">Nome</label>
                <input type="text" name="nome" class="border rounded w-full p-2" required value="<?php echo htmlspecialchars($editar['nome'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">E-mail</label>
                <input type="email" name="email" class="border rounded w-full p-2" required value="<?php echo htmlspecialchars($editar['email'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Telefone</label>
                <input type="text" name="telefone" class="border rounded w-full p-2" value="<?php echo htmlspecialchars($editar['telefone'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Senha <?php if ($editar) echo '(deixe em branco para não alterar)'; ?></label>
                <input type="password" name="senha" class="border rounded w-full p-2" <?php if (!$editar) echo 'required'; ?> autocomplete="new-password">
            </div>
            <div class="md:col-span-2 flex items-center gap-2">
                <input type="checkbox" name="bloqueado" id="bloqueado" value="1" <?php if (($editar['bloqueado'] ?? 0) == 1) echo 'checked'; ?>>
                <label for="bloqueado" class="font-semibold">Bloqueado</label>
            </div>
            <div class="md:col-span-2 flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    <?php echo $editar ? 'Salvar Alterações' : 'Adicionar Cliente'; ?>
                </button>
                <?php if ($editar): ?>
                    <a href="?rota=clientes" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</a>
                <?php endif; ?>
            </div>
        </form>
        <h3 class="text-lg font-semibold mb-2">Clientes Cadastrados</h3>
        <table class="w-full bg-white rounded shadow">
            <thead>
                <tr>
                    <th class="p-2 text-left">Nome</th>
                    <th class="p-2 text-left">E-mail</th>
                    <th class="p-2 text-left">Telefone</th>
                    <th class="p-2 text-left">Bloqueado</th>
                    <th class="p-2">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clientes as $cli): ?>
                    <tr>
                        <td class="p-2"><?php echo htmlspecialchars($cli['nome']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($cli['email']); ?></td>
                        <td class="p-2"><?php echo htmlspecialchars($cli['telefone']); ?></td>
                        <td class="p-2 text-center"><?php echo $cli['bloqueado'] ? 'Sim' : 'Não'; ?></td>
                        <td class="p-2 text-center">
                            <a href="?rota=clientes&editar=<?php echo $cli['id']; ?>" class="text-blue-600 hover:underline mr-2">Editar</a>
                            <a href="?rota=clientes&excluir=<?php echo $cli['id']; ?>" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
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