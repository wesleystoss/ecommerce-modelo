<footer class="bg-blue-900 text-white p-4 text-center">
    <div class="flex flex-col md:flex-row md:justify-between md:items-center max-w-5xl mx-auto gap-2">
        <div>
            <span class="font-bold"><?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?></span>
            <?php if (!empty($config['endereco'])): ?> | <?php echo htmlspecialchars($config['endereco']); ?><?php endif; ?>
        </div>
        <div>
            <?php if (!empty($config['email'])): ?>
                <span class="mr-2">📧 <?php echo htmlspecialchars($config['email']); ?></span>
            <?php endif; ?>
            <?php if (!empty($config['telefone'])): ?>
                <span>📞 <?php echo htmlspecialchars($config['telefone']); ?></span>
            <?php endif; ?>
        </div>
    </div>
    <div class="text-xs text-gray-300 mt-2">&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($config['nome_empresa'] ?? 'Loja Modelo'); ?>. Feito com ❤️ e Tailwind CSS.</div>
</footer>

<?php
// Lógica para exibir pop-up
require_once __DIR__ . '/../../models/Popup.php';
$rota_atual = $_GET['rota'] ?? 'home';
// Se a rota for 'produto', considere como 'produto_detalhe' para o pop-up
if ($rota_atual === 'produto') {
    $rota_atual = 'produto_detalhe';
}
$popup_ativo = Popup::getActivePopupForPage(getDB(), $rota_atual);

if ($popup_ativo):
    // Define classes de tamanho com base no DB
    $tamanho_classes = [
        'pequeno' => 'max-w-md',
        'medio' => 'max-w-2xl',
        'grande' => 'max-w-4xl',
    ];
    $classe_tamanho = $tamanho_classes[$popup_ativo['tamanho']] ?? 'max-w-2xl';
?>
<div id="popup-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center">
    <div id="popup-container" class="bg-white rounded-lg shadow-2xl p-4 relative <?php echo $classe_tamanho; ?> transform transition-all duration-300 scale-95 opacity-0">
        <button id="popup-close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
        <div class="p-6">
            <?php echo $popup_ativo['conteudo_html']; ?>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const overlay = document.getElementById('popup-overlay');
    const container = document.getElementById('popup-container');
    const closeBtn = document.getElementById('popup-close');

    // Mostra o pop-up com animação
    setTimeout(() => {
        container.classList.remove('scale-95', 'opacity-0');
        container.classList.add('scale-100', 'opacity-100');
    }, 50);

    // Fecha o pop-up
    const closePopup = () => {
        container.classList.add('scale-95', 'opacity-0');
        setTimeout(() => overlay.style.display = 'none', 300);
    };

    closeBtn.addEventListener('click', closePopup);
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            closePopup();
        }
    });
});
</script>
<?php endif; ?> 