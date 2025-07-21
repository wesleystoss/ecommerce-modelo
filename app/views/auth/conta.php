<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta - Loja Modelo</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen flex flex-col">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main class="flex-1 flex items-center justify-center py-8">
        <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-2 flex flex-col gap-8">
                <section class="bg-white/90 rounded-2xl shadow p-6 border border-gray-100">
                    <h2 class="text-lg font-bold mb-1">Informações Pessoais</h2>
                    <p class="text-gray-500 text-sm mb-4">Atualize seus dados de contato</p>
                    <?php if (!empty($erro)): ?>
                        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center"><?php echo $erro; ?></div>
                    <?php endif; ?>
                    <?php if (!empty($sucesso)): ?>
                        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">Dados atualizados com sucesso!</div>
                    <?php endif; ?>
                    <form method="post" class="space-y-4">
                        <div>
                            <label for="nome" class="block text-sm font-semibold mb-1">Nome Completo</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-user"></i></span>
                                <input type="text" name="nome" id="nome" required class="w-full border border-gray-200 rounded-lg px-10 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" value="<?php echo htmlspecialchars($cliente['nome']); ?>">
                            </div>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold mb-1">E-mail</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" id="email" required class="w-full border border-gray-200 rounded-lg px-10 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" value="<?php echo htmlspecialchars($cliente['email']); ?>">
                            </div>
                        </div>
                        <div>
                            <label for="telefone" class="block text-sm font-semibold mb-1">Telefone</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-phone"></i></span>
                                <input type="text" name="telefone" id="telefone" required class="w-full border border-gray-200 rounded-lg px-10 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" value="<?php echo htmlspecialchars($cliente['telefone']); ?>">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-gray-700 text-white py-2 rounded-lg font-bold hover:bg-gray-800 transition flex items-center justify-center gap-2"><i class="fas fa-save"></i> Atualizar Perfil</button>
                    </form>
                </section>
                <section class="bg-white/90 rounded-2xl shadow p-6 border border-gray-100">
                    <h2 class="text-lg font-bold mb-1">Alterar Senha</h2>
                    <p class="text-gray-500 text-sm mb-4">Mantenha sua conta segura</p>
                    <form method="post" class="space-y-4">
                        <div>
                            <label for="senha" class="block text-sm font-semibold mb-1">Nova Senha</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-lock"></i></span>
                                <input type="password" name="senha" id="senha" class="w-full border border-gray-200 rounded-lg px-10 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="Mínimo 6 caracteres">
                            </div>
                        </div>
                        <div>
                            <label for="senha2" class="block text-sm font-semibold mb-1">Confirmar Nova Senha</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-lock"></i></span>
                                <input type="password" name="senha2" id="senha2" class="w-full border border-gray-200 rounded-lg px-10 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="Confirme a nova senha">
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 rounded-lg font-bold hover:from-blue-700 hover:to-purple-700 transition flex items-center justify-center gap-2"><i class="fas fa-key"></i> Alterar Senha</button>
                    </form>
                </section>
            </div>
            <aside class="flex flex-col gap-8">
                <div class="bg-white/90 rounded-2xl shadow p-6 border border-gray-100 flex flex-col items-center">
                    <span class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center text-2xl text-white font-bold mb-2">
                        <?php echo strtoupper(substr($cliente['nome'], 0, 1)); ?>
                    </span>
                    <div class="text-center">
                        <div class="font-bold text-lg"><?php echo htmlspecialchars($cliente['nome']); ?></div>
                        <div class="text-gray-500 text-sm"><?php echo htmlspecialchars($cliente['email']); ?></div>
                    </div>
                    <div class="mt-4 text-xs text-gray-500">
                        Membro desde <span class="font-semibold">--/--</span><br>
                        Status: <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-700 font-semibold">Ativo</span>
                    </div>
                </div>
                <div class="bg-white/90 rounded-2xl shadow p-6 border border-gray-100">
                    <h3 class="font-bold text-sm mb-2">Ações Rápidas</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="?rota=pedidos" class="flex items-center gap-2 text-gray-700 hover:text-blue-700"><i class="fas fa-box"></i> Meus Pedidos</a></li>
                        <li><a href="?rota=carrinho" class="flex items-center gap-2 text-gray-700 hover:text-blue-700"><i class="fas fa-shopping-cart"></i> Carrinho</a></li>
                        <li><a href="?rota=produtos" class="flex items-center gap-2 text-gray-700 hover:text-blue-700"><i class="fas fa-store"></i> Ver Produtos</a></li>
                    </ul>
                </div>
                <div class="bg-green-50 border border-green-200 rounded-2xl p-4 text-green-800 text-sm flex items-center gap-2">
                    <i class="fas fa-lock"></i> Conta Segura: Suas informações estão protegidas com criptografia SSL.
                </div>
                <div class="text-center mt-2">
                    <a href="?rota=logout" class="text-red-600 font-semibold hover:underline">Sair da conta</a>
                </div>
            </aside>
        </div>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html> 