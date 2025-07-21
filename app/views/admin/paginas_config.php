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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_color">
                                    <i class="fas fa-paint-brush mr-2 text-blue-600"></i>Cor de Fundo do Botão Principal
                                </label>
                                <input type="color" name="button_color" id="button_color" value="<?php echo htmlspecialchars($button_color); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_text_color">
                                    <i class="fas fa-font mr-2 text-blue-600"></i>Cor do Texto do Botão Principal
                                </label>
                                <input type="color" name="button_text_color" id="button_text_color" value="<?php echo htmlspecialchars($button_text_color); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_add_bg">
                                    <i class="fas fa-cart-plus mr-2 text-green-600"></i>Cor de Fundo "Adicionar ao Carrinho"
                                </label>
                                <input type="color" name="button_add_bg" id="button_add_bg" value="<?php echo htmlspecialchars($button_add_bg); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_add_text">
                                    <i class="fas fa-font mr-2 text-green-600"></i>Cor do Texto "Adicionar ao Carrinho"
                                </label>
                                <input type="color" name="button_add_text" id="button_add_text" value="<?php echo htmlspecialchars($button_add_text); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_details_bg">
                                    <i class="fas fa-search mr-2 text-indigo-600"></i>Cor de Fundo "Ver Detalhes"
                                </label>
                                <input type="color" name="button_details_bg" id="button_details_bg" value="<?php echo htmlspecialchars($button_details_bg); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_details_text">
                                    <i class="fas fa-font mr-2 text-indigo-600"></i>Cor do Texto "Ver Detalhes"
                                </label>
                                <input type="color" name="button_details_text" id="button_details_text" value="<?php echo htmlspecialchars($button_details_text); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_promos_bg">
                                    <i class="fas fa-tags mr-2 text-orange-500"></i>Cor de Fundo "Ver Todas as Promoções"
                                </label>
                                <input type="color" name="button_promos_bg" id="button_promos_bg" value="<?php echo htmlspecialchars($button_promos_bg); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_promos_text">
                                    <i class="fas fa-font mr-2 text-orange-500"></i>Cor do Texto "Ver Todas as Promoções"
                                </label>
                                <input type="color" name="button_promos_text" id="button_promos_text" value="<?php echo htmlspecialchars($button_promos_text); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_best_bg">
                                    <i class="fas fa-star mr-2 text-cyan-500"></i>Cor de Fundo "Mais Vendidos"
                                </label>
                                <input type="color" name="button_best_bg" id="button_best_bg" value="<?php echo htmlspecialchars($button_best_bg); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_best_text">
                                    <i class="fas fa-font mr-2 text-cyan-500"></i>Cor do Texto "Mais Vendidos"
                                </label>
                                <input type="color" name="button_best_text" id="button_best_text" value="<?php echo htmlspecialchars($button_best_text); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_sec_bg">
                                    <i class="fas fa-clone mr-2 text-gray-500"></i>Cor de Fundo do Botão Secundário
                                </label>
                                <input type="color" name="button_sec_bg" id="button_sec_bg" value="<?php echo htmlspecialchars($button_sec_bg); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2" for="button_sec_text">
                                    <i class="fas fa-font mr-2 text-gray-500"></i>Cor do Texto do Botão Secundário
                                </label>
                                <input type="color" name="button_sec_text" id="button_sec_text" value="<?php echo htmlspecialchars($button_sec_text); ?>" class="w-16 h-10 p-0 border-0 bg-transparent cursor-pointer">
                            </div>
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