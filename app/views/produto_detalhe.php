<?php
require_once __DIR__ . '/../../app/models/Configuracao.php';
$config = Configuracao::get($db);
include __DIR__ . '/partials/header.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produto['nome']); ?> - <?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?></title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col text-gray-900">
    <main class="flex-1 container mx-auto p-4 md:p-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-4">
            <a href="/" class="hover:underline">Início</a> &gt; 
            <a href="?rota=produtos" class="hover:underline">Produtos</a> &gt; 
            <?php if ($categoria): ?><a href="?rota=produtos&categoria=<?php echo $categoria['id']; ?>" class="hover:underline"><?php echo htmlspecialchars($categoria['nome']); ?></a> &gt; <?php endif; ?>
            <span class="text-gray-700 font-semibold"><?php echo htmlspecialchars($produto['nome']); ?></span>
        </nav>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <!-- Imagem principal -->
            <div class="bg-white rounded-2xl shadow-md p-6 flex items-center justify-center border border-gray-100">
                <img src="<?php echo htmlspecialchars($produto['imagem']); ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>" class="rounded-xl w-full max-h-[350px] object-cover mb-4">
            </div>
            <!-- Detalhes do produto -->
            <div class="bg-white rounded-2xl shadow-md p-8 border border-gray-100 flex flex-col gap-4">
                <div class="flex items-center gap-2 mb-2">
                    <?php if ($categoria): ?><span class="px-2 py-1 bg-gray-200 rounded text-xs font-semibold text-gray-700"><?php echo htmlspecialchars($categoria['nome']); ?></span><?php endif; ?>
                    <?php if (($produto['tipo_estoque'] ?? 'ilimitado') == 'controlado'): ?>
                        <?php if (($produto['estoque'] ?? 0) > 0): ?>
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold"><?php echo (int)$produto['estoque']; ?> unidades disponíveis</span>
                        <?php else: ?>
                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">Esgotado</span>
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Disponível</span>
                    <?php endif; ?>
                </div>
                <h2 class="text-3xl font-bold mb-2 text-gray-900"><?php echo htmlspecialchars($produto['nome']); ?></h2>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-yellow-500 text-lg">★★★★★</span>
                    <span class="text-gray-600 text-sm">(4.8 - 127 avaliações)</span>
                </div>
                <div class="text-3xl font-bold text-blue-600 mb-2">R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?></div>
                <div class="text-green-700 font-semibold mb-2">
                    <?php if (($produto['tipo_estoque'] ?? 'ilimitado') == 'controlado'): ?>
                        <?php if (($produto['estoque'] ?? 0) > 0): ?>
                            <?php echo (int)$produto['estoque']; ?> unidades disponíveis
                        <?php else: ?>
                            Esgotado
                        <?php endif; ?>
                    <?php else: ?>
                        Disponível
                    <?php endif; ?>
                </div>
                <div class="mb-4 text-gray-700 text-lg"><?php echo nl2br(htmlspecialchars($produto['descricao'])); ?></div>
                <form method="post" action="?rota=carrinho">
                    <input type="hidden" name="produto_id" value="<?php echo $produto['id']; ?>">
                    <div class="flex items-center gap-2 mb-4">
                        <label for="qtd" class="font-semibold">Quantidade</label>
                        <input type="number" name="qtd" id="qtd" value="1" min="1" class="border border-gray-300 rounded-lg w-20 p-2">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-8 py-3 rounded-full font-bold hover:bg-blue-700 transition w-full md:w-auto shadow">Adicionar ao Carrinho</button>
                </form>
                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-2 text-gray-600 text-sm">
                    <div>🚚 Entrega gratuita</div>
                    <div>🛡️ Garantia de 1 ano</div>
                    <div>🔄 Devolução em 30 dias</div>
                    <div>💬 Suporte 24/7</div>
                </div>
            </div>
        </div>
        <!-- Produtos relacionados -->
        <div class="mt-16">
            <h3 class="text-2xl font-bold mb-6 text-gray-900">Produtos Relacionados</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
                <?php foreach ($relacionados as $rel): ?>
                    <div class="bg-white rounded-2xl shadow-md p-6 flex flex-col items-center hover:shadow-xl transition border border-gray-100">
                        <img src="<?php echo htmlspecialchars($rel['imagem']); ?>" alt="<?php echo htmlspecialchars($rel['nome']); ?>" class="w-24 h-24 object-cover rounded-xl mb-2">
                        <div class="flex items-center gap-2 mb-1">
                            <?php if (!empty($rel['categoria_nome'])): ?><span class="px-2 py-1 bg-gray-200 rounded text-xs font-semibold text-gray-700"><?php echo htmlspecialchars($rel['categoria_nome']); ?></span><?php endif; ?>
                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Em estoque</span>
                        </div>
                        <div class="font-semibold text-gray-900 text-center mb-1"><?php echo htmlspecialchars($rel['nome']); ?></div>
                        <div class="text-blue-600 font-bold mb-1">R$ <?php echo number_format($rel['preco'], 2, ',', '.'); ?></div>
                        <a href="?rota=produto&id=<?php echo $rel['id']; ?>" class="bg-blue-50 text-blue-700 px-4 py-2 rounded-full hover:bg-blue-100 transition text-sm font-semibold w-full text-center">Ver Detalhes</a>
                        <form method="post" action="?rota=carrinho" class="w-full mt-2">
                            <input type="hidden" name="produto_id" value="<?php echo $rel['id']; ?>">
                            <button type="submit" class="w-full bg-green-500 text-white px-2 py-2 rounded-full hover:bg-green-600 transition text-xs font-semibold">Adicionar</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html> 