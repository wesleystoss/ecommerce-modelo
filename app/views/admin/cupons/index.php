<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Cupons</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <?php include __DIR__.'/../_sidebar.php'; ?>
    <div class="pl-64 min-h-screen">
        <header class="bg-white shadow-lg border-b border-gray-200">
            <div class="container mx-auto px-6 py-4">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-pink-500 to-yellow-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-tag text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-pink-500 to-yellow-500 bg-clip-text text-transparent">
                            Gerenciar Cupons
                        </h1>
                        <p class="text-sm text-gray-600">Administração de Cupons</p>
                    </div>
                </div>
            </div>
        </header>
        <main class="container mx-auto px-6 py-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-8 flex items-center gap-2">
                <i class="fas fa-tag text-pink-500"></i> Gestão de Cupons
            </h2>
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col items-center justify-center">
                <i class="fas fa-ticket-alt text-5xl text-pink-400 mb-4"></i>
                <p class="text-lg text-gray-700 mb-2">Em breve: listagem e gestão de cupons aqui.</p>
                <p class="text-sm text-gray-400">Você poderá cadastrar, editar e remover cupons promocionais para sua loja.</p>
            </div>
        </main>
    </div>
</body>
</html> 