<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Pedidos</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <?php include __DIR__.'/../_sidebar.php'; ?>
    <div class="pl-64 min-h-screen">
        <header class="bg-white shadow-lg border-b border-gray-200">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-shopping-cart text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-green-500 to-blue-500 bg-clip-text text-transparent">
                            Gerenciar Pedidos
                        </h1>
                        <p class="text-sm text-gray-600">Administração de Pedidos</p>
                    </div>
                </div>
            </div>
        </header>
        <main class="container mx-auto px-6 py-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-8 flex items-center gap-2">
                <i class="fas fa-shopping-cart text-green-500"></i> Gestão de Pedidos
            </h2>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col items-center justify-center">
                <i class="fas fa-clipboard-list text-5xl text-green-400 mb-4"></i>
                <p class="text-lg text-gray-700 mb-2">Em breve: listagem e gestão de pedidos aqui.</p>
                <p class="text-sm text-gray-400">Você poderá visualizar, atualizar status e gerenciar os pedidos da loja.</p>
            </div>
        </main>
    </div>
</body>
</html> 