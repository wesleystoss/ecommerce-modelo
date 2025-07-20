<footer class="bg-blue-900 text-white p-4 text-center mt-8">
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