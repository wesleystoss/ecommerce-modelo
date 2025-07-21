<?php
if (!isset($config)) {
    require_once __DIR__ . '/../../../config/database.php';
    require_once __DIR__ . '/../../../app/models/Configuracao.php';
    $db = getDB();
    $config = Configuracao::get($db);
}
if (!isset($categorias)) {
    if (!isset($db)) {
        require_once __DIR__ . '/../../../config/database.php';
        $db = getDB();
    }
    $categorias = $db->query('SELECT * FROM categorias')->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!-- Barra superior -->
<header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-30">
    <div class="container mx-auto px-4 py-3 flex items-center justify-between gap-4">
        <a href="/" class="flex items-center gap-3 group hover:no-underline">
            <?php if (!empty($config['logo'])): ?>
                <span class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center overflow-hidden">
                    <img src="<?php echo htmlspecialchars($config['logo']); ?>" alt="Logo" style="height:<?php echo (int)($config['logo_height'] ?? 40); ?>px; max-width:40px;" class="object-contain">
                </span>
            <?php else: ?>
                <span class="w-12 h-12 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center">
                    <i class="fas fa-store text-white text-2xl"></i>
                </span>
            <?php endif; ?>
            <span class="text-2xl md:text-3xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent tracking-tight group-hover:opacity-80 transition">
                <?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?>
            </span>
        </a>
        <form method="get" action="" class="flex-1 max-w-lg mx-auto flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-1 border border-gray-100 shadow-sm">
            <input type="hidden" name="rota" value="produtos">
            <span class="text-gray-400"><i class="fas fa-search"></i></span>
            <input type="text" name="nome" class="bg-transparent border-0 outline-none focus:ring-0 w-full px-2 py-2 text-gray-700" placeholder="Buscar produtos..." value="<?php echo htmlspecialchars($_GET['nome'] ?? ''); ?>">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Buscar</button>
        </form>
        <div class="flex items-center gap-3">
            <a href="?rota=carrinho" class="relative text-blue-700 hover:bg-blue-50 p-2 rounded-full transition">
                <i class="fas fa-shopping-cart text-2xl"></i>
            </a>
            <a href="?rota=login" class="text-blue-700 hover:bg-blue-50 p-2 rounded-full transition">
                <i class="fas fa-user text-2xl"></i>
            </a>
            <a href="/admin" class="text-purple-700 hover:bg-purple-50 px-3 py-2 rounded-lg font-semibold transition">Admin</a>
        </div>
    </div>
    <!-- Barra de navegação -->
    <nav class="bg-white border-t border-gray-100 shadow-sm">
        <div class="container mx-auto px-4 flex items-center justify-center gap-2 md:gap-6">
            <a href="/" class="px-3 py-3 font-medium text-blue-700 hover:bg-blue-50 rounded transition">Início</a>
            <a href="?rota=produtos" class="px-3 py-3 font-medium text-blue-700 hover:bg-blue-50 rounded transition">Produtos</a>
            <!-- Dropdown Categorias -->
            <div class="relative group">
                <button type="button" class="px-3 py-3 font-medium text-blue-700 hover:bg-blue-50 rounded transition flex items-center gap-2 focus:outline-none">
                    <i class="fas fa-th-large"></i> Categorias <i class="fas fa-chevron-down text-xs"></i>
                </button>
                <div class="absolute left-1/2 -translate-x-1/2 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-lg opacity-0 group-hover:opacity-100 group-hover:pointer-events-auto pointer-events-none transition-opacity z-40" style="min-width:200px;">
                    <ul class="py-2">
                        <?php foreach ($categorias as $cat): ?>
                            <li>
                                <a href="?rota=produtos&categoria=<?php echo $cat['id']; ?>" class="flex items-center gap-2 px-4 py-2 hover:bg-blue-50 text-gray-700 transition">
                                    <span class="text-xl"><?php echo $cat['icone']; ?></span>
                                    <span><?php echo htmlspecialchars($cat['nome']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <a href="?rota=avaliacoes" class="px-3 py-3 font-medium text-blue-700 hover:bg-blue-50 rounded transition hidden md:inline">Avaliações</a>
            <a href="?rota=vantagens" class="px-3 py-3 font-medium text-blue-700 hover:bg-blue-50 rounded transition hidden md:inline">Vantagens</a>
        </div>
    </nav>
</header>
<script>
// Dropdown de categorias: abre no hover (desktop) e no clique (mobile)
document.querySelectorAll('.group').forEach(function(el) {
    el.addEventListener('mouseenter', function() {
        this.querySelector('div').classList.add('opacity-100', 'pointer-events-auto');
    });
    el.addEventListener('mouseleave', function() {
        this.querySelector('div').classList.remove('opacity-100', 'pointer-events-auto');
    });
    el.querySelector('button').addEventListener('click', function(e) {
        e.preventDefault();
        const dropdown = el.querySelector('div');
        dropdown.classList.toggle('opacity-100');
        dropdown.classList.toggle('pointer-events-auto');
    });
});
</script> 