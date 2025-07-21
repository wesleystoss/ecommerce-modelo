<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Loja Modelo</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen flex flex-col">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main class="flex-1 flex items-center justify-center py-8">
        <div class="bg-white/90 shadow-xl rounded-2xl p-8 w-full max-w-md border border-gray-100">
            <div class="flex flex-col items-center mb-6">
                <span class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center mb-2">
                    <i class="fas fa-user-plus text-white text-3xl"></i>
                </span>
                <h1 class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent text-center">Criar nova conta</h1>
                <p class="text-gray-500 text-sm mt-1 text-center">Preencha os dados para se cadastrar</p>
            </div>
            <?php if (!empty($erro)): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center"><?php echo $erro; ?></div>
            <?php endif; ?>
            <form method="post" class="space-y-4">
                <div>
                    <label for="nome" class="block text-sm font-semibold mb-1">Nome</label>
                    <input type="text" name="nome" id="nome" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="Seu nome completo">
                </div>
                <div>
                    <label for="email" class="block text-sm font-semibold mb-1">E-mail</label>
                    <input type="email" name="email" id="email" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="seu@email.com">
                </div>
                <div>
                    <label for="telefone" class="block text-sm font-semibold mb-1">Telefone</label>
                    <input type="text" name="telefone" id="telefone" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="(99) 99999-9999">
                </div>
                <div>
                    <label for="senha" class="block text-sm font-semibold mb-1">Senha</label>
                    <input type="password" name="senha" id="senha" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="Crie uma senha">
                </div>
                <div>
                    <label for="senha2" class="block text-sm font-semibold mb-1">Confirmar Senha</label>
                    <input type="password" name="senha2" id="senha2" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="Repita a senha">
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 rounded-lg font-bold hover:from-blue-700 hover:to-purple-700 transition flex items-center justify-center gap-2"><i class="fas fa-user-plus"></i> Criar Conta</button>
            </form>
            <div class="mt-6 text-center text-sm text-gray-600">
                Já tem conta? <a href="?rota=login" class="text-blue-700 font-semibold hover:underline">Entrar</a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
<script>
// Máscara de telefone (99) 99999-9999
const telInput = document.getElementById('telefone');
if (telInput) {
  telInput.addEventListener('input', function(e) {
    let v = this.value.replace(/\D/g, '');
    if (v.length > 11) v = v.slice(0, 11);
    if (v.length > 0) v = '(' + v;
    if (v.length > 3) v = v.slice(0, 3) + ') ' + v.slice(3);
    if (v.length > 10) v = v.slice(0, 10) + '-' + v.slice(10);
    else if (v.length > 6) v = v.slice(0, 9) + '-' + v.slice(9);
    this.value = v;
  });
}
</script>
</html> 