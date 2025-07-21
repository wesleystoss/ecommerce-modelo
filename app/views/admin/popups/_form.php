<?php
$paginas_disponiveis = ['home', 'produtos', 'carrinho', 'produto_detalhe'];
$paginas_selecionadas = isset($popup) ? json_decode($popup['paginas_exibicao'], true) ?: [] : [];
?>
<!-- Título -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-heading mr-2 text-blue-600"></i>Título do Pop-up
    </label>
    <input type="text" name="titulo" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" required value="<?php echo htmlspecialchars($popup['titulo'] ?? ''); ?>">
</div>

<!-- Conteúdo HTML -->
<div class="md:col-span-2">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-code mr-2 text-green-600"></i>Conteúdo HTML
    </label>
    <textarea name="conteudo_html" rows="10" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"><?php echo htmlspecialchars($popup['conteudo_html'] ?? ''); ?></textarea>
</div>

<!-- Tamanho -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-expand-arrows-alt mr-2 text-purple-600"></i>Tamanho
    </label>
    <select name="tamanho" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
        <option value="pequeno" <?php echo (($popup['tamanho'] ?? '') == 'pequeno') ? 'selected' : ''; ?>>Pequeno</option>
        <option value="medio" <?php echo (($popup['tamanho'] ?? 'medio') == 'medio') ? 'selected' : ''; ?>>Médio</option>
        <option value="grande" <?php echo (($popup['tamanho'] ?? '') == 'grande') ? 'selected' : ''; ?>>Grande</option>
    </select>
</div>

<!-- Tipo -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-object-group mr-2 text-yellow-600"></i>Tipo de Pop-up
    </label>
    <select name="tipo" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
        <option value="modal_central" <?php echo (($popup['tipo'] ?? '') == 'modal_central') ? 'selected' : ''; ?>>Modal Central</option>
        <option value="banner_topo" <?php echo (($popup['tipo'] ?? '') == 'banner_topo') ? 'selected' : ''; ?>>Banner no Topo</option>
    </select>
</div>

<!-- Páginas de Exibição -->
<div class="md:col-span-2">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        <i class="fas fa-file-alt mr-2 text-gray-600"></i>Exibir nas Páginas
    </label>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gray-50 rounded-xl">
        <?php foreach ($paginas_disponiveis as $pagina): ?>
            <div class="flex items-center">
                <input type="checkbox" name="paginas_exibicao[]" id="page_<?php echo $pagina; ?>" value="<?php echo $pagina; ?>" <?php echo in_array($pagina, $paginas_selecionadas) ? 'checked' : ''; ?> class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="page_<?php echo $pagina; ?>" class="ml-2 text-sm text-gray-700"><?php echo ucfirst(str_replace('_', ' ', $pagina)); ?></label>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- Ativo -->
<div class="md:col-span-2">
    <div class="flex items-center p-4 bg-gray-50 rounded-xl">
        <input type="checkbox" name="ativo" id="ativo" value="1" <?php if (($popup['ativo'] ?? 0) == 1) echo 'checked'; ?> class="w-5 h-5 text-green-600 border-gray-300 rounded focus:ring-green-500">
        <label for="ativo" class="ml-3 text-sm font-medium text-gray-700">
            <i class="fas fa-check-circle mr-2 text-green-500"></i>Ativar Pop-up
        </label>
        <input type="hidden" name="ativo_hidden" value="0"> <!-- Campo para garantir que '0' seja enviado se o checkbox não for marcado -->
    </div>
</div>

<!-- Frequência de Exibição -->
<div class="mb-4">
    <label for="frequencia" class="block text-gray-700 font-semibold mb-1"><i class="fas fa-clock mr-1"></i> Frequência de Exibição</label>
    <select name="frequencia" id="frequencia" class="w-full border rounded p-2">
        <option value="sempre" <?php if(($popup['frequencia'] ?? '') === 'sempre') echo 'selected'; ?>>Sempre exibir</option>
        <option value="unica_sessao" <?php if(($popup['frequencia'] ?? '') === 'unica_sessao') echo 'selected'; ?>>Exibir uma vez por sessão</option>
        <option value="diaria" <?php if(($popup['frequencia'] ?? '') === 'diaria') echo 'selected'; ?>>Exibir uma vez por dia</option>
    </select>
</div>

<!-- Cor de Fundo -->
<div class="mb-4">
    <label for="cor_fundo" class="block text-gray-700 font-semibold mb-1"><i class="fas fa-fill-drip mr-1"></i> Cor de Fundo do Banner</label>
    <input type="text" name="cor_fundo" id="cor_fundo" value="<?php echo htmlspecialchars($popup['cor_fundo'] ?? '', ENT_QUOTES); ?>" placeholder="Ex: #ff0000 ou bg-red-600 ou linear-gradient(...)" class="w-full border rounded p-2" />
    <small class="text-gray-500">Aceita cor hexadecimal, nome de classe Tailwind ou CSS gradient.</small>
</div>

<!-- Botões -->
<div class="md:col-span-2 flex gap-4 pt-4">
    <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-purple-700 transition-all duration-300 transform hover:scale-105">
        <i class="fas fa-save mr-2"></i>
        <?php echo $editar ? 'Salvar Alterações' : 'Criar Pop-up'; ?>
    </button>
    <a href="?rota=popups" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl font-semibold hover:bg-gray-200 transition-all">
        <i class="fas fa-times mr-2"></i>Cancelar
    </a>
</div> 