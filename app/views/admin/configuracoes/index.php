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
    <title>Admin - Configurações do Site</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-700">Administração - Configurações</h1>
        <nav>
            <a href="/admin/" class="text-blue-600 hover:underline">Dashboard</a>
        </nav>
    </header>
    <main class="flex-1 container mx-auto p-8">
        <h2 class="text-2xl font-bold mb-8">Configurações do Site</h2>
        <form method="post" class="bg-white p-6 rounded shadow max-w-xl mx-auto grid gap-4">
            <div>
                <label class="block mb-1 font-semibold">Nome da Empresa</label>
                <input type="text" name="nome_empresa" class="border rounded w-full p-2" required value="<?php echo htmlspecialchars($config['nome_empresa'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">URL do Logo</label>
                <input type="url" name="logo" class="border rounded w-full p-2" value="<?php echo htmlspecialchars($config['logo'] ?? ''); ?>">
                <?php if (!empty($config['logo'])): ?>
                    <img src="<?php echo htmlspecialchars($config['logo']); ?>" alt="Logo" class="mt-2" style="height: <?php echo (int)($config['logo_height'] ?? 32); ?>px">
                <?php endif; ?>
            </div>
            <div>
                <label class="block mb-1 font-semibold">Altura da Logo (px)</label>
                <input type="number" name="logo_height" class="border rounded w-full p-2" min="16" max="200" value="<?php echo (int)($config['logo_height'] ?? 32); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">E-mail de Contato</label>
                <input type="email" name="email" class="border rounded w-full p-2" value="<?php echo htmlspecialchars($config['email'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Telefone</label>
                <input type="text" name="telefone" class="border rounded w-full p-2" value="<?php echo htmlspecialchars($config['telefone'] ?? ''); ?>">
            </div>
            <div>
                <label class="block mb-1 font-semibold">Endereço</label>
                <textarea name="endereco" class="border rounded w-full p-2"><?php echo htmlspecialchars($config['endereco'] ?? ''); ?></textarea>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar Configurações</button>
            </div>
        </form>
    </main>
    <footer class="bg-blue-900 text-white p-4 text-center mt-8">
        &copy; <?php echo date('Y'); ?> Loja Modelo - Admin
    </footer>
</body>
</html> 