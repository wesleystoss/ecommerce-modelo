<?php
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../app/models/Produto.php';
$db = getDB();
$termo = trim($_GET['q'] ?? '');
if (strlen($termo) < 2) {
    echo json_encode([]);
    exit;
}
$stmt = $db->prepare('SELECT id, nome, preco, imagem FROM produtos WHERE nome LIKE ? ORDER BY id DESC LIMIT 6');
$stmt->execute(['%' . $termo . '%']);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($produtos as &$p) {
    $p['link'] = '?rota=produto&id=' . $p['id'];
    if (empty($p['imagem'])) {
        $p['imagem'] = 'https://source.unsplash.com/collection/190727/80x80?sig=' . $p['id'];
    }
    $p['preco'] = number_format($p['preco'], 2, ',', '.');
}
echo json_encode($produtos); 