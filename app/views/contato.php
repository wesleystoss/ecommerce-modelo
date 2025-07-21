<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Configuracao.php';
$db = getDB();
$config = Configuracao::get($db);
$sucesso = false;
$erro = '';
$nome = '';
$email = '';
$mensagem = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $mensagem = trim($_POST['mensagem'] ?? '');
    if (!$nome || !$email || !$mensagem) {
        $erro = 'Preencha todos os campos obrigatórios.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro = 'E-mail inválido.';
    } else {
        // Aqui você pode enviar o e-mail ou salvar no banco
        $sucesso = true;
        $nome = $email = $mensagem = '';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - <?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?></title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-50 min-h-screen flex flex-col text-gray-900">
<?php include __DIR__ . '/partials/header.php'; ?>
<main class="flex-1 flex flex-col justify-center py-12 px-4 bg-gradient-to-b from-blue-50 to-white min-h-[80vh]">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-extrabold text-center mb-2 mt-4">Entre em Contato</h1>
        <p class="text-center text-gray-500 mb-10">Estamos aqui para ajudar! Entre em contato conosco para dúvidas, suporte ou parcerias.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-white rounded-2xl shadow p-8 border border-gray-100 flex flex-col justify-between">
                <h2 class="text-xl font-bold mb-4">Envie sua mensagem</h2>
                <?php if ($sucesso): ?>
                    <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-center">Mensagem enviada com sucesso!</div>
                <?php elseif ($erro): ?>
                    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-center"><?php echo $erro; ?></div>
                <?php endif; ?>
                <form method="post" class="space-y-4">
                    <div>
                        <label for="nome" class="block text-sm font-semibold mb-1">Nome completo *</label>
                        <input type="text" name="nome" id="nome" required class="w-full border border-gray-200 rounded-lg px-3 py-2 bg-gray-50" placeholder="Seu nome completo" value="<?php echo htmlspecialchars($nome); ?>">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-semibold mb-1">Email *</label>
                        <input type="email" name="email" id="email" required class="w-full border border-gray-200 rounded-lg px-3 py-2 bg-gray-50" placeholder="seu@email.com" value="<?php echo htmlspecialchars($email); ?>">
                    </div>
                    <div>
                        <label for="mensagem" class="block text-sm font-semibold mb-1">Mensagem *</label>
                        <textarea name="mensagem" id="mensagem" required rows="5" class="w-full border border-gray-200 rounded-lg px-3 py-2 bg-gray-50" placeholder="Descreva sua dúvida ou solicitação..."><?php echo htmlspecialchars($mensagem); ?></textarea>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-2 rounded-lg font-bold hover:from-blue-700 hover:to-purple-700 transition flex items-center justify-center gap-2"><i class="fas fa-paper-plane"></i> Enviar mensagem</button>
                </form>
            </div>
            <div class="bg-white rounded-2xl shadow p-8 border border-gray-100 flex flex-col justify-start">
                <h2 class="text-xl font-bold mb-4">Informações de contato</h2>
                <ul class="space-y-6 text-gray-700 text-base">
                    <li class="flex items-start gap-3">
                        <span class="mt-1"><i class="fas fa-envelope text-blue-600 text-xl"></i></span>
                        <div>
                            <div class="font-semibold">Email</div>
                            <div><?php echo htmlspecialchars($config['email'] ?? 'contato@loja.com'); ?></div>
                            <div class="text-gray-400 text-xs">Respostas em até 24 horas</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1"><i class="fas fa-phone text-green-600 text-xl"></i></span>
                        <div>
                            <div class="font-semibold">Telefone</div>
                            <div><?php echo htmlspecialchars($config['telefone'] ?? '(11) 99999-9999'); ?></div>
                            <div class="text-gray-400 text-xs">Segunda a sexta, 8h às 18h</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-1"><i class="fas fa-map-marker-alt text-purple-600 text-xl"></i></span>
                        <div>
                            <div class="font-semibold">Endereço</div>
                            <div><?php echo htmlspecialchars($config['endereco'] ?? 'Rua Exemplo, 123, Centro, Cidade - UF'); ?></div>
                            <div class="text-gray-400 text-xs">Próximo ao metrô</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</main>
<?php include __DIR__ . '/partials/footer.php'; ?>
</body>
</html> 