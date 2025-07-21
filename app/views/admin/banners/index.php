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
    <title>Admin - Banners</title>
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
                            <i class="fas fa-image text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Gerenciar Banners
                            </h1>
                            <p class="text-sm text-gray-600">Administração de Banners</p>
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
            <!-- Form Section -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-semibold text-gray-800">
                        <?php echo $editar ? 'Editar Banner' : 'Adicionar Novo Banner'; ?>
                    </h2>
                    <?php if ($editar): ?>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                            Editando ID: <?php echo $editar['id']; ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
                    
                    <!-- Título -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-heading mr-2 text-blue-600"></i>Título do Banner
                        </label>
                        <input type="text" name="titulo" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required value="<?php echo htmlspecialchars($editar['titulo'] ?? ''); ?>">
                    </div>
                    
                    <!-- URL da Imagem -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-image mr-2 text-pink-600"></i>URL da Imagem
                        </label>
                        <input type="url" name="imagem" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required value="<?php echo htmlspecialchars($editar['imagem'] ?? ''); ?>">
                    </div>
                    
                    <!-- Link -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-link mr-2 text-green-600"></i>Link (opcional)
                        </label>
                        <input type="url" name="link" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($editar['link'] ?? ''); ?>">
                    </div>
                    
                    <!-- Ordem -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-sort-numeric-up mr-2 text-purple-600"></i>Ordem
                        </label>
                        <input type="number" name="ordem" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($editar['ordem'] ?? 0); ?>">
                    </div>
                    
                    <!-- Ativo -->
                    <div class="md:col-span-2">
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <input type="checkbox" name="ativo" id="ativo" value="1" <?php if (($editar['ativo'] ?? 1) == 1) echo 'checked'; ?> class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                            <label for="ativo" class="ml-3 text-sm font-medium text-gray-700">
                                <i class="fas fa-check-circle mr-2 text-green-500"></i>Banner Ativo
                            </label>
                        </div>
                    </div>
                    
                    <!-- Botões -->
                    <div class="md:col-span-2 flex gap-4 pt-4">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            <?php echo $editar ? 'Salvar Alterações' : 'Adicionar Banner'; ?>
                        </button>
                        <?php if ($editar): ?>
                            <a href="?rota=banners" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Banners Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-list mr-2 text-blue-600"></i>Banners Cadastrados
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ordem</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($banners as $ban): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($ban['imagem']): ?>
                                        <img src="<?php echo htmlspecialchars($ban['imagem']); ?>" alt="<?php echo htmlspecialchars($ban['titulo']); ?>" class="w-20 h-12 object-cover rounded-lg shadow-sm">
                                    <?php else: ?>
                                        <div class="w-20 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($ban['titulo']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($ban['link']): ?>
                                        <a href="<?php echo htmlspecialchars($ban['link']); ?>" target="_blank" class="text-sm text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-external-link-alt mr-1"></i>Ver link
                                        </a>
                                    <?php else: ?>
                                        <span class="text-sm text-gray-500">Sem link</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <?php echo htmlspecialchars($ban['ordem']); ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($ban['ativo']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Ativo
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Inativo
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="?rota=banners&editar=<?php echo $ban['id']; ?>" class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?rota=banners&excluir=<?php echo $ban['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este banner?')" class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 