<?php
class Faq {
    public static function all($db) {
        return $db->query('SELECT * FROM faqs ORDER BY id DESC')->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($db, $id) {
        $stmt = $db->prepare('SELECT * FROM faqs WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($db, $data) {
        $stmt = $db->prepare('INSERT INTO faqs (pergunta, resposta) VALUES (?, ?)');
        $stmt->execute([$data['pergunta'], $data['resposta']]);
    }
    public static function update($db, $id, $data) {
        $stmt = $db->prepare('UPDATE faqs SET pergunta=?, resposta=?, updated_at=CURRENT_TIMESTAMP WHERE id=?');
        $stmt->execute([$data['pergunta'], $data['resposta'], $id]);
    }
    public static function delete($db, $id) {
        $stmt = $db->prepare('DELETE FROM faqs WHERE id=?');
        $stmt->execute([$id]);
    }
} 