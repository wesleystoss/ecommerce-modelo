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
    <title>Admin - FAQs</title>
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
                            <i class="fas fa-question-circle text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Gerenciar FAQs
                            </h1>
                            <p class="text-sm text-gray-600">Administração de Perguntas Frequentes</p>
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
                        <?php echo $editar ? 'Editar FAQ' : 'Adicionar Nova FAQ'; ?>
                    </h2>
                    <?php if ($editar): ?>
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                            Editando ID: <?php echo $editar['id']; ?>
                        </span>
                    <?php endif; ?>
                </div>
                <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
                    <!-- Pergunta -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-question mr-2 text-blue-600"></i>Pergunta
                        </label>
                        <input type="text" name="pergunta" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required value="<?php echo htmlspecialchars($editar['pergunta'] ?? ''); ?>">
                    </div>
                    <!-- Resposta -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-reply mr-2 text-green-600"></i>Resposta
                        </label>
                        <textarea name="resposta" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required><?php echo htmlspecialchars($editar['resposta'] ?? ''); ?></textarea>
                    </div>
                    <div class="md:col-span-2 flex justify-end gap-2">
                        <?php if ($editar): ?>
                            <a href="?rota=faqs" class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300 transition">Cancelar</a>
                        <?php endif; ?>
                        <button type="submit" class="px-6 py-2 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition">
                            <?php echo $editar ? 'Salvar Alterações' : 'Adicionar FAQ'; ?>
                        </button>
                    </div>
                </form>
            </div>
            <!-- Lista de FAQs -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">
                    <i class="fas fa-list mr-2 text-purple-600"></i>FAQs Cadastradas
                </h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pergunta</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Resposta</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php foreach ($faqs as $faq): ?>
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">#<?php echo $faq['id']; ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-800 max-w-xs truncate" title="<?php echo htmlspecialchars($faq['pergunta']); ?>"><?php echo htmlspecialchars($faq['pergunta']); ?></td>
                                    <td class="px-4 py-2 text-sm text-gray-600 max-w-xs truncate" title="<?php echo htmlspecialchars($faq['resposta']); ?>"><?php echo htmlspecialchars($faq['resposta']); ?></td>
                                    <td class="px-4 py-2 text-right">
                                        <a href="?rota=faqs&editar=<?php echo $faq['id']; ?>" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-edit"></i></a>
                                        <a href="?rota=faqs&excluir=<?php echo $faq['id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir esta FAQ?');"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($faqs)): ?>
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">Nenhuma FAQ cadastrada.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 