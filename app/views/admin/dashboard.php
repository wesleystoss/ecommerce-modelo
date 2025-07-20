<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Loja Modelo</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <header class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-blue-700">Administração</h1>
        <nav>
            <a href="/" class="text-blue-600 hover:underline">Ver Site</a>
        </nav>
    </header>
    <main class="flex-1 container mx-auto p-8">
        <h2 class="text-3xl font-bold mb-8">Painel Administrativo</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <a href="?rota=produtos" class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition border-2 border-transparent hover:border-blue-400">
                <span class="text-5xl mb-2">📦</span>
                <span class="font-bold text-lg text-blue-700">Produtos</span>
            </a>
            <a href="?rota=categorias" class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition border-2 border-transparent hover:border-blue-400">
                <span class="text-5xl mb-2">📂</span>
                <span class="font-bold text-lg text-blue-700">Categorias</span>
            </a>
            <a href="?rota=avaliacoes" class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition border-2 border-transparent hover:border-blue-400">
                <span class="text-5xl mb-2">⭐</span>
                <span class="font-bold text-lg text-blue-700">Avaliações</span>
            </a>
            <a href="?rota=vantagens" class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition border-2 border-transparent hover:border-blue-400">
                <span class="text-5xl mb-2">💡</span>
                <span class="font-bold text-lg text-blue-700">Por que escolher a loja</span>
            </a>
            <a href="?rota=pedidos" class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition border-2 border-transparent hover:border-blue-400">
                <span class="text-5xl mb-2">🧾</span>
                <span class="font-bold text-lg text-blue-700">Pedidos</span>
            </a>
            <a href="?rota=clientes" class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition border-2 border-transparent hover:border-blue-400">
                <span class="text-5xl mb-2">👤</span>
                <span class="font-bold text-lg text-blue-700">Clientes</span>
            </a>
            <a href="?rota=banners" class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition border-2 border-transparent hover:border-blue-400">
                <span class="text-5xl mb-2">🖼️</span>
                <span class="font-bold text-lg text-blue-700">Banners</span>
            </a>
            <a href="?rota=cupons" class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition border-2 border-transparent hover:border-blue-400">
                <span class="text-5xl mb-2">🏷️</span>
                <span class="font-bold text-lg text-blue-700">Cupons</span>
            </a>
            <a href="?rota=configuracoes" class="bg-white rounded-xl shadow-lg p-8 flex flex-col items-center hover:scale-105 transition border-2 border-transparent hover:border-blue-400">
                <span class="text-5xl mb-2">⚙️</span>
                <span class="font-bold text-lg text-blue-700">Configurações</span>
            </a>
        </div>
    </main>
    <footer class="bg-blue-900 text-white p-4 text-center mt-8">
        &copy; <?php echo date('Y'); ?> Loja Modelo - Admin
    </footer>
</body>
</html> 