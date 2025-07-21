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
    foreach ($popups_para_pagina as $i => $popup_ativo) {
        $cor_fundo = trim($popup_ativo['cor_fundo'] ?? '');
        $cor_attr = '';
        if ($cor_fundo) {
            if (strpos($cor_fundo, 'bg-') === 0) {
                $cor_attr = 'class="' . htmlspecialchars($cor_fundo) . '"';
            } else {
                $cor_attr = 'style=\"background:' . htmlspecialchars($cor_fundo) . ';\"';
            }
        }
        $conteudo = $popup_ativo['conteudo_html'];
        $popup_id = $popup_ativo['id'];
        if (strpos($conteudo, 'data-popup-id=') === false) {
            $conteudo = preg_replace('/^<([a-zA-Z0-9]+)/', '<$1 data-popup-id=\"' . $popup_id . '\"', $conteudo, 1);
        }
        $conteudo = preg_replace('/(<[^>]+data-popup-id=[^>]+)(>)/i', '$1 ' . $cor_attr . '$2', $conteudo, 1);
        // Cada banner recebe um data-banner-index para empilhamento
        echo '<div class="banner-topo-stack" data-banner-id="' . $popup_id . '" data-banner-index="' . $i . '" style="position:fixed;left:0;width:100%;z-index:' . (100 + $i) . ';pointer-events:auto;top:0;">' . $conteudo . '</div>';
    }
endif;
?>
<style>
.banner-topo-stack {
  left: 0;
  width: 100%;
  pointer-events: auto;
  /* z-index e top são definidos inline para empilhamento */
}
header.sticky-header-fix {
  position: fixed;
  left: 0;
  width: 100%;
  z-index: 30;
  transition: top 0.2s;
}
body {
  /* O padding-top será ajustado via JS */
}
</style>
<script>
window.addEventListener('DOMContentLoaded', function() {
  // Empilha banners e ajusta header
  function ajustarTopo() {
    var banners = Array.from(document.querySelectorAll('.banner-topo-stack'));
    var header = document.querySelector('header');
    var altura = 0;
    banners.forEach(function(w, idx){
      var b = w.querySelector('[data-popup-id]');
      if(w.style.display !== 'none' && b) {
        w.style.top = altura + 'px';
        w.style.zIndex = 100 + idx;
        altura += b.offsetHeight;
      } else {
        w.style.top = '-9999px';
      }
    });
    if (header) {
      header.classList.add('sticky-header-fix');
      header.style.top = altura + 'px';
    }
    // Ajusta o padding do body para não sobrepor o conteúdo
    document.body.style.paddingTop = (altura + (header ? header.offsetHeight : 0)) + 'px';
  }
  // Fecha banner
  document.querySelectorAll('.banner-topo-stack button[aria-label="Fechar"]').forEach(function(btn){
    btn.onclick = function() {
      var wrapper = btn.closest('.banner-topo-stack');
      if(wrapper) wrapper.style.display = 'none';
      setTimeout(ajustarTopo, 10);
    }
  });
  // Recalcula ao redimensionar e ao carregar imagens
  window.addEventListener('resize', ajustarTopo);
  setTimeout(ajustarTopo, 200);
  document.querySelectorAll('.banner-topo-stack img').forEach(function(img){
    img.addEventListener('load', function(){ setTimeout(ajustarTopo, 10); });
  });
});
</script> 