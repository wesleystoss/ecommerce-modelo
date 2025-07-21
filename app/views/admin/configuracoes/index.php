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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-to-br from-gray-50 to-blue-50 min-h-screen">
    <?php include __DIR__.'/../_sidebar.php'; ?>
    <div class="pl-64 min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-lg border-b border-gray-200">
            <div class="container mx-auto px-6 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cog text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Configurações do Site
                            </h1>
                            <p class="text-sm text-gray-600">Administração de Configurações</p>
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
            <!-- Settings Form -->
            <div class="max-w-2xl mx-auto">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-2">
                            <i class="fas fa-cogs mr-2 text-blue-600"></i>Configurações Gerais
                        </h2>
                        <p class="text-gray-600">Configure as informações básicas da sua loja</p>
                    </div>
                    
                    <form method="post" class="space-y-6">
                        <!-- Nome da Empresa -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-building mr-2 text-blue-600"></i>Nome da Empresa
                            </label>
                            <input type="text" name="nome_empresa" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required value="<?php echo htmlspecialchars($config['nome_empresa'] ?? ''); ?>">
                        </div>
                        
                        <!-- Logo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-image mr-2 text-pink-600"></i>URL do Logo
                            </label>
                            <input type="url" name="logo" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($config['logo'] ?? ''); ?>">
                            <?php if (!empty($config['logo'])): ?>
                                <div class="mt-3 p-4 bg-gray-50 rounded-xl">
                                    <p class="text-sm text-gray-600 mb-2">Preview do logo:</p>
                                    <img src="<?php echo htmlspecialchars($config['logo']); ?>" alt="Logo" class="max-h-16 object-contain">
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Altura da Logo -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-arrows-alt-v mr-2 text-purple-600"></i>Altura da Logo (px)
                            </label>
                            <input type="number" name="logo_height" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" min="16" max="200" value="<?php echo (int)($config['logo_height'] ?? 32); ?>">
                        </div>
                        
                        <!-- E-mail -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-2 text-green-600"></i>E-mail de Contato
                            </label>
                            <input type="email" name="email" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($config['email'] ?? ''); ?>">
                        </div>
                        
                        <!-- Telefone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-phone mr-2 text-yellow-600"></i>Telefone
                            </label>
                            <input type="text" name="telefone" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($config['telefone'] ?? ''); ?>">
                        </div>
                        
                        <!-- Endereço -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-red-600"></i>Endereço
                            </label>
                            <textarea name="endereco" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"><?php echo htmlspecialchars($config['endereco'] ?? ''); ?></textarea>
                        </div>
                        
                        <!-- Botão Salvar -->
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>Salvar Configurações
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Info Card -->
                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-2xl p-6">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-600"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-800 mb-1">Informações Importantes</h3>
                            <p class="text-sm text-blue-700">
                                Estas configurações serão exibidas em todo o site. Certifique-se de que as informações estão corretas e atualizadas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 