<?php
require_once __DIR__ . '/../../models/Popup.php';
$rota_atual = $_GET['rota'] ?? 'home';
if ($rota_atual === 'produto') {
    $rota_atual = 'produto_detalhe';
}
$db = getDB();
$popups = $db->query("SELECT * FROM popups WHERE ativo = 1 AND tipo = 'banner_topo'")->fetchAll(PDO::FETCH_ASSOC);
$popups_para_pagina = array_filter($popups, function($p) use ($rota_atual) {
    $paginas = json_decode($p['paginas_exibicao'] ?? '[]', true);
    return in_array($rota_atual, $paginas ?? []);
});
if (!empty($popups_para_pagina)):
    $js_ids = [];
    foreach ($popups_para_pagina as $popup_ativo) {
        $cor_fundo = trim($popup_ativo['cor_fundo'] ?? '');
        $cor_attr = '';
        if ($cor_fundo) {
            if (strpos($cor_fundo, 'bg-') === 0) {
                $cor_attr = 'class="' . htmlspecialchars($cor_fundo) . '"';
            } else {
                $cor_attr = 'style="background:' . htmlspecialchars($cor_fundo) . ';"';
            }
        }
        $conteudo = $popup_ativo['conteudo_html'];
        $popup_id = $popup_ativo['id'];
        $js_ids[] = $popup_id;
        if (strpos($conteudo, 'data-popup-id=') === false) {
            $conteudo = preg_replace('/^<([a-zA-Z0-9]+)/', '<$1 data-popup-id="' . $popup_id . '"', $conteudo, 1);
        }
        $conteudo = preg_replace('/(<[^>]+data-popup-id=[^>]+)(>)/i', '$1 ' . $cor_attr . '$2', $conteudo, 1);
        // Wrapper para empilhar (posição será ajustada via JS)
        echo '<div class="banner-topo-stack" data-banner-id="' . $popup_id . '" style="position:fixed;left:0;width:100%;z-index:100;pointer-events:auto;top:0;">' . $conteudo . '</div>';
    }
?>
<script>
window.addEventListener('DOMContentLoaded', function() {
  var header = document.querySelector('header');
  var banners = Array.from(document.querySelectorAll('.banner-topo-stack'));
  var alturaAcumulada = 0;
  banners.forEach(function(wrapper, idx) {
    var banner = wrapper.querySelector('[data-popup-id]');
    if (!banner) return;
    // Frequência de exibição
    var popupId = banner.getAttribute('data-popup-id');
    var podeExibir = true;
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
    var frequencia = banner.getAttribute('data-frequencia') || 'sempre';
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
    if (!podeExibir) {
      wrapper.style.display = 'none';
      return;
    }
    // Ajusta a posição top dinamicamente
    wrapper.style.top = alturaAcumulada + 'px';
    alturaAcumulada += banner.offsetHeight;
    // Botão fechar
    var btn = banner.querySelector('button[aria-label="Fechar"]');
    if (btn) {
      btn.onclick = function() {
        wrapper.style.display = 'none';
        // Recalcula altura dos banners visíveis
        var altura = 0;
        banners.forEach(function(w){
          if(w.style.display !== 'none') {
            var b = w.querySelector('[data-popup-id]');
            if(b) {
              w.style.top = altura + 'px';
              altura += b.offsetHeight;
            }
          }
        });
        if (header) header.style.marginTop = altura + 'px';
      }
    }
  });
  if (header) header.style.marginTop = alturaAcumulada + 'px';
});
</script>
<?php endif; ?> 