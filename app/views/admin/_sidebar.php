<?php
// Sidebar fixo para o painel admin
?>
<aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-gray-200 shadow-lg flex flex-col z-30">
    <div class="flex items-center gap-3 px-6 py-6 border-b border-gray-100">
        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
            <i class="fas fa-store text-white text-2xl"></i>
        </div>
        <div>
            <span class="block text-lg font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">Loja Modelo</span>
            <span class="block text-xs text-gray-500">Painel Admin</span>
        </div>
    </div>
    <div class="px-4 py-3">
        <div class="relative">
            <input type="text" id="sidebar-search" placeholder="Buscar..." class="w-full px-4 py-2 pr-10 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm" oninput="sidebarFilter()">
            <span class="absolute right-3 top-2.5 text-gray-400"><i class="fas fa-search"></i></span>
        </div>
    </div>
    <nav class="flex-1 overflow-y-auto px-2 py-2" id="sidebar-menu">
        <ul class="space-y-2 text-sm">
            <li><a href="/admin/" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50 font-semibold text-blue-700"><i class="fas fa-tachometer-alt"></i>Dashboard</a></li>
            <li class="mt-4 mb-1 text-xs text-gray-400 uppercase tracking-wider">Gestão</li>
            <li><a href="?rota=produtos" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50"><i class="fas fa-box"></i>Produtos</a></li>
            <li><a href="?rota=categorias" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50"><i class="fas fa-folder"></i>Categorias</a></li>
            <li><a href="?rota=avaliacoes" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50"><i class="fas fa-star"></i>Avaliações</a></li>
            <li><a href="?rota=vantagens" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50"><i class="fas fa-lightbulb"></i>Vantagens</a></li>
            <li><a href="?rota=pedidos" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50"><i class="fas fa-shopping-cart"></i>Pedidos</a></li>
            <li><a href="?rota=clientes" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50"><i class="fas fa-users"></i>Clientes</a></li>
            <li><a href="?rota=banners" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50"><i class="fas fa-image"></i>Banners</a></li>
            <li><a href="?rota=cupons" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50"><i class="fas fa-tag"></i>Cupons</a></li>
            <li class="mt-4 mb-1 text-xs text-gray-400 uppercase tracking-wider">Configurações</li>
            <li><a href="?rota=configuracoes" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-50"><i class="fas fa-cog"></i>Configurações Gerais</a></li>
        </ul>
    </nav>
    <div class="px-6 py-4 border-t border-gray-100 text-xs text-gray-400">
        &copy; <?php echo date('Y'); ?> Loja Modelo<br>Administração
    </div>
    <script>
    function sidebarFilter() {
        const input = document.getElementById('sidebar-search');
        const filter = input.value.toLowerCase();
        const menu = document.getElementById('sidebar-menu');
        const items = menu.querySelectorAll('a');
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            item.parentElement.style.display = text.includes(filter) ? '' : 'none';
        });
    }
    </script>
</aside> 