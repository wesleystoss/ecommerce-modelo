<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Produto.php';
$db = getDB();
$carrinho = $_SESSION['carrinho'] ?? [];
$produtos = [];
$total = 0.0;
$cliente = null;
if (isset($_SESSION['cliente_id'])) {
    require_once __DIR__ . '/../models/Cliente.php';
    $cliente = Cliente::find($db, $_SESSION['cliente_id']);
}
if ($carrinho) {
    $ids = array_keys($carrinho);
    if ($ids) {
        $in = implode(',', array_fill(0, count($ids), '?'));
        $stmt = $db->prepare('SELECT * FROM produtos WHERE id IN (' . $in . ')');
        $stmt->execute($ids);
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
foreach ($produtos as &$p) {
    $p['quantidade'] = $carrinho[$p['id']] ?? 1;
    $p['subtotal'] = $p['quantidade'] * $p['preco'];
    $total += $p['subtotal'];
}
unset($p);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Loja Modelo</title>
    <link href="/css/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50 min-h-screen flex flex-col">
    <?php include __DIR__ . '/partials/header.php'; ?>
    <main class="flex-1 flex items-center justify-center py-8">
        <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-8">
            <section class="bg-white/90 rounded-2xl shadow p-8 border border-gray-100 flex flex-col gap-6">
                <h1 class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">Finalizar Compra</h1>
                <?php if (!isset($_SESSION['cliente_id'])): ?>
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded mb-6 flex items-center gap-4">
                        <i class="fas fa-exclamation-triangle text-2xl"></i>
                        <div>
                            <div class="font-bold">É necessário estar logado para finalizar a compra.</div>
                            <a href="?rota=login" class="inline-block mt-2 bg-blue-600 text-white px-6 py-2 rounded font-semibold hover:bg-blue-700 transition">Fazer Login ou Cadastro</a>
                        </div>
                    </div>
                <?php endif; ?>
                <form method="post" class="space-y-4" <?php if (!isset($_SESSION['cliente_id'])) echo 'style="pointer-events:none;opacity:0.5;"'; ?>>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nome" class="block text-sm font-semibold mb-1">Nome Completo</label>
                            <input type="text" name="nome" id="nome" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" value="<?php echo htmlspecialchars($cliente['nome'] ?? ''); ?>">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold mb-1">E-mail</label>
                            <input type="email" name="email" id="email" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" value="<?php echo htmlspecialchars($cliente['email'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="telefone" class="block text-sm font-semibold mb-1">Telefone</label>
                            <input type="text" name="telefone" id="telefone" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="(99) 99999-9999" value="<?php echo htmlspecialchars($cliente['telefone'] ?? ''); ?>">
                        </div>
                        <div>
                            <label for="cep" class="block text-sm font-semibold mb-1">CEP</label>
                            <input type="text" name="cep" id="cep" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="00000-000">
                        </div>
                    </div>
                    <div>
                        <label for="endereco" class="block text-sm font-semibold mb-1">Endereço</label>
                        <input type="text" name="endereco" id="endereco" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="cidade" class="block text-sm font-semibold mb-1">Cidade</label>
                            <input type="text" name="cidade" id="cidade" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50">
                        </div>
                        <div>
                            <label for="estado" class="block text-sm font-semibold mb-1">Estado</label>
                            <input type="text" name="estado" id="estado" required class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50">
                        </div>
                    </div>
                    <div class="mt-8">
                        <h2 class="text-lg font-bold mb-2">Forma de Pagamento</h2>
                        <div class="flex gap-4 mb-4">
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="pagamento" value="pix" class="hidden peer" checked>
                                <div class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 h-32 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                    <span class="w-10 h-10 mb-2 flex items-center justify-center">
                                        <!-- Ícone QR Code para Pix -->
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="4" y="4" width="24" height="24" rx="4" stroke="#444" stroke-width="2" fill="#fff"/>
                                            <rect x="7" y="7" width="4" height="4" rx="1" fill="#444"/>
                                            <rect x="21" y="7" width="4" height="4" rx="1" fill="#444"/>
                                            <rect x="7" y="21" width="4" height="4" rx="1" fill="#444"/>
                                            <rect x="13" y="13" width="2" height="2" fill="#444"/>
                                            <rect x="17" y="13" width="2" height="2" fill="#444"/>
                                            <rect x="13" y="17" width="2" height="2" fill="#444"/>
                                            <rect x="17" y="17" width="2" height="2" fill="#444"/>
                                        </svg>
                                    </span>
                                    <span class="font-semibold">Pix</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="pagamento" value="boleto" class="hidden peer">
                                <div class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 h-32 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                    <span class="w-10 h-10 mb-2 flex items-center justify-center">
                                        <!-- Ícone Boleto monocromático -->
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="6" y="8" width="20" height="16" rx="2" stroke="#444" stroke-width="2" fill="#fff"/>
                                            <rect x="10" y="12" width="2" height="8" rx="1" fill="#444"/>
                                            <rect x="14" y="12" width="2" height="8" rx="1" fill="#444"/>
                                            <rect x="18" y="12" width="2" height="8" rx="1" fill="#444"/>
                                        </svg>
                                    </span>
                                    <span class="font-semibold">Boleto</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer">
                                <input type="radio" name="pagamento" value="cartao" class="hidden peer">
                                <div class="flex flex-col items-center justify-center border-2 border-gray-200 rounded-lg p-4 h-32 peer-checked:border-blue-600 peer-checked:bg-blue-50 transition">
                                    <span class="w-10 h-10 mb-2 flex items-center justify-center">
                                        <!-- Ícone Cartão monocromático -->
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect x="6" y="10" width="20" height="12" rx="2" stroke="#444" stroke-width="2" fill="#fff"/>
                                            <rect x="10" y="20" width="6" height="2" rx="1" fill="#444"/>
                                            <rect x="18" y="20" width="4" height="2" rx="1" fill="#444"/>
                                        </svg>
                                    </span>
                                    <span class="font-semibold">Cartão</span>
                                </div>
                            </label>
                        </div>
                        <div id="cartao-fields" class="hidden space-y-4 mt-4">
                            <div>
                                <label for="numero_cartao" class="block text-sm font-semibold mb-1">Número do Cartão</label>
                                <input type="text" name="numero_cartao" id="numero_cartao" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" maxlength="19" placeholder="0000 0000 0000 0000">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="nome_cartao" class="block text-sm font-semibold mb-1">Nome impresso</label>
                                    <input type="text" name="nome_cartao" id="nome_cartao" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" placeholder="Como no cartão">
                                </div>
                                <div>
                                    <label for="validade_cartao" class="block text-sm font-semibold mb-1">Validade</label>
                                    <input type="text" name="validade_cartao" id="validade_cartao" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" maxlength="5" placeholder="MM/AA">
                                </div>
                            </div>
                            <div>
                                <label for="cvv_cartao" class="block text-sm font-semibold mb-1">CVV</label>
                                <input type="text" name="cvv_cartao" id="cvv_cartao" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50" maxlength="4" placeholder="CVV">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-3 rounded-lg font-bold hover:from-blue-700 hover:to-purple-700 transition flex items-center justify-center gap-2 text-lg mt-4" <?php if (!isset($_SESSION['cliente_id'])) echo 'disabled'; ?>><i class="fas fa-credit-card"></i> Finalizar Pedido</button>
                </form>
            </section>
            <aside class="bg-white/90 rounded-2xl shadow p-8 border border-gray-100 flex flex-col gap-6">
                <h2 class="text-lg font-bold mb-4">Resumo do Pedido</h2>
                <ul class="divide-y divide-gray-200 mb-4">
                    <?php foreach ($produtos as $p): ?>
                        <li class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <img src="<?php echo htmlspecialchars($p['imagem'] ?? 'https://via.placeholder.com/60'); ?>" alt="<?php echo htmlspecialchars($p['nome']); ?>" class="w-14 h-14 rounded-lg object-cover border border-gray-100">
                                <div>
                                    <div class="font-semibold text-gray-900"><?php echo htmlspecialchars($p['nome']); ?></div>
                                    <div class="text-xs text-gray-500">Qtd: <?php echo $p['quantidade']; ?></div>
                                </div>
                            </div>
                            <div class="font-bold text-blue-700">R$ <?php echo number_format($p['subtotal'], 2, ',', '.'); ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <div class="flex items-center justify-between text-lg font-bold">
                    <span>Total</span>
                    <span class="text-blue-700">R$ <?php echo number_format($total, 2, ',', '.'); ?></span>
                </div>
            </aside>
        </div>
    </main>
    <?php include __DIR__ . '/partials/footer.php'; ?>
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
    // Máscara de CEP 00000-000
    const cepInput = document.getElementById('cep');
    const enderecoInput = document.getElementById('endereco');
    const cidadeInput = document.getElementById('cidade');
    const estadoInput = document.getElementById('estado');
    if (cepInput) {
      cepInput.addEventListener('input', function(e) {
        let v = this.value.replace(/\D/g, '');
        if (v.length > 8) v = v.slice(0, 8);
        if (v.length > 5) v = v.slice(0, 5) + '-' + v.slice(5);
        this.value = v;
      });
      cepInput.addEventListener('blur', function() {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length === 8) {
          fetch('https://viacep.com.br/ws/' + cep + '/json/')
            .then(r => r.json())
            .then(data => {
              if (data.erro) {
                alert('CEP não encontrado.');
                if (enderecoInput) enderecoInput.value = '';
                if (cidadeInput) cidadeInput.value = '';
                if (estadoInput) estadoInput.value = '';
              } else {
                if (enderecoInput) enderecoInput.value = (data.logradouro || '') + (data.bairro ? ' - ' + data.bairro : '');
                if (cidadeInput) cidadeInput.value = data.localidade || '';
                if (estadoInput) estadoInput.value = data.uf || '';
              }
            })
            .catch(() => {
              alert('Erro ao buscar o CEP.');
            });
        }
      });
    }
    // Exibir campos do cartão apenas se selecionado
    const radios = document.querySelectorAll('input[name="pagamento"]');
    const cartaoFields = document.getElementById('cartao-fields');
    radios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'cartao') {
                cartaoFields.classList.remove('hidden');
            } else {
                cartaoFields.classList.add('hidden');
            }
        });
    });
    // Máscara cartão: número
    const numeroCartao = document.getElementById('numero_cartao');
    if (numeroCartao) {
      numeroCartao.addEventListener('input', function() {
        let v = this.value.replace(/\D/g, '').slice(0,16);
        v = v.replace(/(\d{4})(?=\d)/g, '$1 ');
        this.value = v;
      });
    }
    // Máscara cartão: validade MM/AA
    const validadeCartao = document.getElementById('validade_cartao');
    if (validadeCartao) {
      validadeCartao.addEventListener('input', function() {
        let v = this.value.replace(/\D/g, '').slice(0,4);
        if (v.length > 2) v = v.slice(0,2) + '/' + v.slice(2);
        this.value = v;
      });
    }
    // Máscara cartão: CVV
    const cvvCartao = document.getElementById('cvv_cartao');
    if (cvvCartao) {
      cvvCartao.addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '').slice(0,4);
      });
    }
    </script>
</body>
</html> 