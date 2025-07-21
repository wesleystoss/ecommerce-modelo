<?php
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../app/models/Vantagem.php';
$db = getDB();

// Adicionar vantagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST['id'])) {
    Vantagem::create($db, [
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'icone' => $_POST['icone']
    ]);
    header('Location: ?rota=vantagens');
    exit;
}
// Editar vantagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    Vantagem::update($db, $_POST['id'], [
        'titulo' => $_POST['titulo'],
        'descricao' => $_POST['descricao'],
        'icone' => $_POST['icone']
    ]);
    header('Location: ?rota=vantagens');
    exit;
}
// Excluir vantagem
if (isset($_GET['excluir'])) {
    Vantagem::delete($db, $_GET['excluir']);
    header('Location: ?rota=vantagens');
    exit;
}
// Buscar vantagem para edição
$editar = null;
if (isset($_GET['editar'])) {
    $editar = Vantagem::find($db, $_GET['editar']);
}
$vantagens = Vantagem::all($db);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Por que escolher a loja</title>
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
                            <i class="fas fa-lightbulb text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Por que escolher a loja
                            </h1>
                            <p class="text-sm text-gray-600">Administração de Vantagens</p>
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
                        <?php echo $editar ? 'Editar Vantagem' : 'Adicionar Nova Vantagem'; ?>
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
                            <i class="fas fa-heading mr-2 text-blue-600"></i>Título da Vantagem
                        </label>
                        <input type="text" name="titulo" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required value="<?php echo htmlspecialchars($editar['titulo'] ?? ''); ?>">
                    </div>
                    
                    <!-- Ícone -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-smile mr-2 text-yellow-600"></i>Ícone (emoji)
                        </label>
                        <input type="text" name="icone" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all text-center text-2xl" maxlength="2" placeholder="🚀" value="<?php echo htmlspecialchars($editar['icone'] ?? ''); ?>">
                    </div>
                    
                    <!-- Descrição -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-2 text-gray-600"></i>Descrição
                        </label>
                        <textarea name="descricao" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"><?php echo htmlspecialchars($editar['descricao'] ?? ''); ?></textarea>
                    </div>
                    
                    <!-- Botões -->
                    <div class="md:col-span-2 flex gap-4 pt-4">
                        <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-save mr-2"></i>
                            <?php echo $editar ? 'Salvar Alterações' : 'Adicionar Vantagem'; ?>
                        </button>
                        <?php if ($editar): ?>
                            <a href="?rota=vantagens" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                                <i class="fas fa-times mr-2"></i>Cancelar
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <!-- Advantages Table -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">
                        <i class="fas fa-list mr-2 text-blue-600"></i>Vantagens Cadastradas
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ícone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Título</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php foreach ($vantagens as $vant): ?>
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-blue-100 rounded-xl flex items-center justify-center text-2xl">
                                        <?php echo htmlspecialchars($vant['icone']); ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($vant['titulo']); ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-500"><?php echo htmlspecialchars($vant['descricao']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center space-x-2">
                                        <a href="?rota=vantagens&editar=<?php echo $vant['id']; ?>" class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="?rota=vantagens&excluir=<?php echo $vant['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta vantagem?')" class="text-red-600 hover:text-red-900 transition-colors">
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