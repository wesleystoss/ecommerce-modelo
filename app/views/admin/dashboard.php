<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Loja Modelo</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <?php include __DIR__.'/_sidebar.php'; ?>
    <div class="pl-64 min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-lg border-b border-gray-200">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-store text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Loja Modelo
                            </h1>
                            <p class="text-sm text-gray-600">Painel Administrativo</p>
                        </div>
                    </div>
                    <nav class="flex items-center space-x-6">
                        <a href="/" class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition-colors">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Ver Site</span>
                        </a>
                        <div class="w-px h-6 bg-gray-300"></div>
                        <div class="flex items-center space-x-2 text-sm text-gray-600">
                            <i class="fas fa-user-circle"></i>
                            <span>Administrador</span>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-8">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-800 mb-2">Bem-vindo ao Painel</h2>
                <p class="text-gray-600">Gerencie seus produtos, pedidos e configurações da loja</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total de Produtos</p>
                            <p class="text-2xl font-bold text-gray-900">24</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-box text-blue-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Pedidos Hoje</p>
                            <p class="text-2xl font-bold text-gray-900">8</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-shopping-cart text-green-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Clientes Ativos</p>
                            <p class="text-2xl font-bold text-gray-900">156</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-users text-purple-600 text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Receita Mensal</p>
                            <p class="text-2xl font-bold text-gray-900">R$ 12.450</p>
                        </div>
                        <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-dollar-sign text-yellow-600 text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Ações Rápidas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <a href="?rota=produtos" class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-box text-white text-2xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Produtos</h4>
                            <p class="text-sm text-gray-600">Gerenciar catálogo</p>
                        </div>
                    </a>
                    
                    <a href="?rota=pedidos" class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-shopping-bag text-white text-2xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Pedidos</h4>
                            <p class="text-sm text-gray-600">Ver pedidos</p>
                        </div>
                    </a>
                    
                    <a href="?rota=clientes" class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-purple-200 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-users text-white text-2xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Clientes</h4>
                            <p class="text-sm text-gray-600">Gerenciar clientes</p>
                        </div>
                    </a>
                    
                    <a href="?rota=configuracoes" class="group bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-lg hover:border-gray-200 transition-all duration-300 transform hover:-translate-y-1">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-16 h-16 bg-gradient-to-br from-gray-500 to-gray-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-cog text-white text-2xl"></i>
                            </div>
                            <h4 class="font-semibold text-gray-800 mb-2">Configurações</h4>
                            <p class="text-sm text-gray-600">Ajustar loja</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- All Sections -->
            <div>
                <h3 class="text-xl font-semibold text-gray-800 mb-6">Todas as Seções</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <a href="?rota=categorias" class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-blue-200 transition-all">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-folder text-blue-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Categorias</span>
                    </a>
                    
                    <a href="?rota=avaliacoes" class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-yellow-200 transition-all">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-star text-yellow-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Avaliações</span>
                    </a>
                    
                    <a href="?rota=vantagens" class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-green-200 transition-all">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-lightbulb text-green-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Vantagens</span>
                    </a>
                    
                    <a href="?rota=banners" class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-pink-200 transition-all">
                        <div class="w-10 h-10 bg-pink-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-image text-pink-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Banners</span>
                    </a>
                    
                    <a href="?rota=cupons" class="flex items-center p-4 bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md hover:border-red-200 transition-all">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-tag text-red-600"></i>
                        </div>
                        <span class="font-medium text-gray-700">Cupons</span>
                    </a>
                </div>
            </div>
        </main>        
</body>
</html> 