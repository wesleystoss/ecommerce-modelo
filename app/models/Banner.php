<?php
class Banner {
    public static function all($db) {
        return $db->query('SELECT * FROM banners ORDER BY ordem ASC, id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($db, $id) {
        $stmt = $db->prepare('SELECT * FROM banners WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($db, $data) {
        $stmt = $db->prepare('INSERT INTO banners (titulo, imagem, link, ordem, ativo) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$data['titulo'], $data['imagem'], $data['link'], $data['ordem'], $data['ativo'] ?? 1]);
    }
    public static function update($db, $id, $data) {
        $stmt = $db->prepare('UPDATE banners SET titulo=?, imagem=?, link=?, ordem=?, ativo=? WHERE id=?');
        $stmt->execute([$data['titulo'], $data['imagem'], $data['link'], $data['ordem'], $data['ativo'] ?? 1, $id]);
    }
    public static function delete($db, $id) {
        $stmt = $db->prepare('DELETE FROM banners WHERE id=?');
        $stmt->execute([$id]);
    }
} 