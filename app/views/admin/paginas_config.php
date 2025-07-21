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
    <title>Admin - Configuração de Páginas</title>
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
                            <i class="fas fa-pager text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Configuração de Páginas
                            </h1>
                            <p class="text-sm text-gray-600">Administração de Páginas Especiais</p>
                        </div>
                    </div>
                    <nav class="flex items-center space-x-6">
                        <a href="/" class="flex items-center space-x-2 text-gray-600 hover:text-blue-600 transition-colors">
                            <i class="fas fa-external-link-alt"></i>
                            <span>Ver Site</span>
                        </a>
                    </nav>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="container mx-auto px-6 py-8">
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            <i class="fas fa-pager mr-2 text-blue-600"></i>Página Inicial - Hero
                        </h2>
                        <p class="text-gray-600">Configure o tamanho do hero da página inicial</p>
                    </div>
                    <form method="post" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="hero_vh">
                                <i class="fas fa-arrows-alt-v mr-2 text-purple-600"></i>Tamanho do Hero (altura)
                            </label>
                            <select name="hero_vh" id="hero_vh" class="w-full border border-gray-200 rounded-xl px-4 py-3 bg-gray-50 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                <option value="25" <?php if($hero_vh=='25') echo 'selected'; ?>>25% da tela</option>
                                <option value="50" <?php if($hero_vh=='50') echo 'selected'; ?>>50% da tela</option>
                                <option value="70" <?php if($hero_vh=='70') echo 'selected'; ?>>70% da tela</option>
                                <option value="100" <?php if($hero_vh=='100') echo 'selected'; ?>>100% da tela</option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-bold hover:bg-blue-700 transition flex items-center justify-center gap-2 text-lg">
                            <i class="fas fa-save"></i> Salvar
                        </button>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 