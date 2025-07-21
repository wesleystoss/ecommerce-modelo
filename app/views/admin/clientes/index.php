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
    <title>Admin - Clientes</title>
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
                            <i class="fas fa-users text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Gerenciar Clientes
                            </h1>
                            <p class="text-sm text-gray-600">Administração de Clientes</p>
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
                        <?php echo $editar ? 'Editar Cliente' : 'Adicionar Novo Cliente'; ?>
                    </h2>
                    <?php if ($editar): ?>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                            Editando ID: <?php echo $editar['id']; ?>
                        </span>
                    <?php endif; ?>
                </div>
                
                <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
                    
                    <!-- Nome -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-user mr-2 text-blue-600"></i>Nome Completo
                        </label>
                        <input type="text" name="nome" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required value="<?php echo htmlspecialchars($editar['nome'] ?? ''); ?>">
                    </div>
                    
                    <!-- E-mail -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-2 text-green-600"></i>E-mail
                        </label>
                        <input type="email" name="email" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required value="<?php echo htmlspecialchars($editar['email'] ?? ''); ?>">
                    </div>
                    
                    <!-- Telefone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-phone mr-2 text-yellow-600"></i>Telefone
                        </label>
                        <input type="text" name="telefone" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" value="<?php echo htmlspecialchars($editar['telefone'] ?? ''); ?>">
                    </div>
                    
                    <!-- Senha -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-lock mr-2 text-red-600"></i>Senha
                            <?php if ($editar): ?>
                                <span class="text-xs text-gray-500 font-normal">(deixe em branco para não alterar)</span>
                            <?php endif; ?>
                        </label>
                        <input type="password" name="senha" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" <?php if (!$editar) echo 'required'; ?> autocomplete="new-password">
                    </div>
                    
                    <!-- Bloqueado -->
                    <div class="md:col-span-2">
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <input type="checkbox" name="bloqueado" id="bloqueado" value="1" <?php if (($editar['bloqueado'] ?? 0) == 1) echo 'checked'; ?> class="w-5 h-5 text-red-600 border-gray-300 rounded focus:ring-red-500">
                            <label for="bloqueado" class="ml-3 text-sm font-medium text-gray-700">
                                <i class="fas fa-ban mr-2 text-red-500"></i>Cliente Bloqueado
                            </label>
                        </div>
                    </div>
                    
                    <!-- Botões -->
                    <div class="md:col-span-2 flex gap-4 pt-4">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            <?php echo $editar ? 'Salvar Alterações' : 'Adicionar Cliente'; ?>
                        </button>
                        <?php if ($editar): ?>
                            <a href="?rota=clientes" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Clients Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-list mr-2 text-blue-600"></i>Clientes Cadastrados
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">E-mail</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($clientes as $cli): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-purple-100 rounded-xl flex items-center justify-center mr-3">
                                            <i class="fas fa-user text-blue-600"></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($cli['nome']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo htmlspecialchars($cli['email']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo htmlspecialchars($cli['telefone']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if ($cli['bloqueado']): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-ban mr-1"></i>Bloqueado
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Ativo
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="?rota=clientes&editar=<?php echo $cli['id']; ?>" class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?rota=clientes&excluir=<?php echo $cli['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir este cliente?')" class="text-red-600 hover:text-red-900 transition-colors">
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