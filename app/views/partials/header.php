<header class="bg-white shadow p-4 flex flex-col md:flex-row md:items-center md:justify-between sticky top-0 z-10 gap-4">
    <a href="/" class="flex items-center gap-2 group hover:no-underline">
        <?php if (!empty($config['logo'])): ?>
            <img src="<?php echo htmlspecialchars($config['logo']); ?>" alt="Logo" style="height: <?php echo (int)($config['logo_height'] ?? 32); ?>px" class="w-auto group-hover:opacity-80 transition">
        <?php endif; ?>
        <h1 class="text-2xl md:text-3xl font-extrabold text-blue-700 tracking-tight group-hover:underline"><?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?></h1>
    </a>
    <form method="get" action="" class="flex-1 max-w-lg mx-auto flex items-center gap-2">
        <input type="hidden" name="rota" value="produtos">
        <input type="text" name="nome" class="border rounded w-full p-2" placeholder="Buscar produtos..." value="<?php echo htmlspecialchars($_GET['nome'] ?? ''); ?>">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Buscar</button>
    </form>
    <nav class="space-x-4 flex items-center justify-end">
        <a href="/" class="text-blue-600 hover:underline font-medium">Início</a>
        <a href="?rota=produtos" class="text-blue-600 hover:underline font-medium">Produtos</a>
        <a href="?rota=carrinho" class="text-blue-600 hover:underline font-medium">Carrinho</a>
        <a href="/admin" class="text-blue-600 hover:underline font-medium">Admin</a>
    </nav>
</header> 