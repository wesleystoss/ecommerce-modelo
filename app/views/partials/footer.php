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

if ($popup_ativo && ($popup_ativo['tipo'] ?? 'modal_central') === 'modal_central'):
    // Define classes de tamanho com base no DB
    $tamanho_classes = [
        'pequeno' => 'max-w-md min-w-[300px] min-h-[100px] p-4',
        'medio' => 'max-w-xl min-w-[400px] min-h-[200px] p-6',
        'grande' => 'max-w-3xl min-w-[600px] min-h-[300px] p-10',
    ];
    $classe_tamanho = $tamanho_classes[$popup_ativo['tamanho']] ?? 'max-w-xl min-w-[400px] min-h-[200px] p-6';
    $frequencia = $popup_ativo['frequencia'] ?? 'sempre';
    $popup_id = $popup_ativo['id'];
?>
    <div id="popup-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 flex items-center justify-center" style="display:none;">
        <div id="popup-container" class="bg-white rounded-lg shadow-2xl relative <?php echo $classe_tamanho; ?> transform transition-all duration-300 scale-95 opacity-0">
            <button id="popup-close" class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
            <div class="p-6">
                <?php echo $popup_ativo['conteudo_html']; ?>
            </div>
        </div>
    </div>
    <script>
    (function() {
        const frequencia = '<?php echo $frequencia; ?>';
        const popupId = '<?php echo $popup_id; ?>';
        const overlay = document.getElementById('popup-overlay');
        const container = document.getElementById('popup-container');
        const closeBtn = document.getElementById('popup-close');
        let podeExibir = true;
        function getCookie(name) {
            const v = document.cookie.match('(^|;) ?' + name + '=([^;]*)(;|$)');
            return v ? v[2] : null;
        }
        function setCookie(name, value, days) {
            let expires = '';
            if (days) {
                const d = new Date();
                d.setTime(d.getTime() + (days*24*60*60*1000));
                expires = '; expires=' + d.toUTCString();
            }
            document.cookie = name + '=' + value + expires + '; path=/';
        }
        if (frequencia === 'unica_sessao') {
            if (sessionStorage.getItem('popup_' + popupId)) {
                podeExibir = false;
            } else {
                sessionStorage.setItem('popup_' + popupId, '1');
            }
        } else if (frequencia === 'diaria') {
            const cookie = getCookie('popup_' + popupId);
            if (cookie === '1') {
                podeExibir = false;
            } else {
                setCookie('popup_' + popupId, '1', 1);
            }
        }
        if (podeExibir) {
            overlay.style.display = 'flex';
            setTimeout(() => {
                container.classList.remove('scale-95', 'opacity-0');
                container.classList.add('scale-100', 'opacity-100');
            }, 50);
        }
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
    })();
    </script>
<?php endif; // fechamento do if modal_central ?> 