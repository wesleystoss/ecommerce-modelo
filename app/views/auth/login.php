<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Loja Modelo</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen flex flex-col">
    <?php include __DIR__ . '/../partials/header.php'; ?>
    <main class="flex-1 flex items-center justify-center py-8">
        <div class="bg-white/90 shadow-xl rounded-2xl p-8 w-full max-w-md border border-gray-100">
            <div class="flex flex-col items-center mb-6">
                <span class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-600 to-purple-600 flex items-center justify-center mb-2">
                    <i class="fas fa-user text-white text-3xl"></i>
                </span>
                <h1 class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent text-center">Bem-vindo de volta</h1>
                <p class="text-gray-500 text-sm mt-1 text-center">Entre na sua conta para continuar</p>
            </div>
            <?php if (!empty($erro)): ?>
                <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center"><?php echo $erro; ?></div>
            <?php endif; ?>
            <?php if (isset($_GET['cadastro']) && $_GET['cadastro'] === 'ok'): ?>
                <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">Cadastro realizado com sucesso! Faça login.</div>
            <?php endif; ?>
            <form method="post" class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-semibold mb-1">E-mail</label>
                    <input type="email" name="email" id="email" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="seu@email.com">
                </div>
                <div>
                    <label for="senha" class="block text-sm font-semibold mb-1">Senha</label>
                    <input type="password" name="senha" id="senha" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="Sua senha">
                </div>
                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 rounded-lg font-bold hover:from-blue-700 hover:to-purple-700 transition flex items-center justify-center gap-2"><i class="fas fa-sign-in-alt"></i> Entrar</button>
            </form>
            <div class="flex items-center my-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="mx-3 text-gray-400 text-xs">ou continue com</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>
            <div class="flex flex-col gap-3">
                <button type="button" class="w-full flex items-center justify-center gap-3 border border-gray-200 rounded-lg py-2 font-semibold text-gray-700 bg-white hover:bg-gray-50 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5"> Continuar com Google
                </button>
                <button type="button" class="w-full flex items-center justify-center gap-3 border border-gray-200 rounded-lg py-2 font-semibold text-gray-700 bg-white hover:bg-gray-50 transition">
                    <span class="w-5 h-5 flex items-center justify-center"><svg viewBox="0 0 32 32" width="20" height="20" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="16" cy="16" r="16" fill="#1877F3"/><path d="M21.333 16.001h-3.2v8h-3.2v-8h-1.6v-2.667h1.6v-1.6c0-2.133 1.067-3.2 3.2-3.2h2.133v2.667h-1.333c-.533 0-.8.267-.8.8v1.333h2.133l-.267 2.667z" fill="#fff"/></svg></span> Continuar com Facebook
                </button>
            </div>
            <div class="mt-6 text-center text-sm text-gray-600">
                Não tem uma conta? <a href="?rota=cadastro" class="text-blue-700 font-semibold hover:underline">Cadastre-se</a>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/../partials/footer.php'; ?>
</body>
</html> 