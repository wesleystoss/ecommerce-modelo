<?php
class Vantagem {
    public static function all($db) {
        return $db->query('SELECT * FROM vantagens')->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($db, $id) {
        $stmt = $db->prepare('SELECT * FROM vantagens WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($db, $data) {
        $stmt = $db->prepare('INSERT INTO vantagens (titulo, descricao, icone) VALUES (?, ?, ?)');
        $stmt->execute([$data['titulo'], $data['descricao'], $data['icone']]);
    }
    public static function update($db, $id, $data) {
        $stmt = $db->prepare('UPDATE vantagens SET titulo=?, descricao=?, icone=? WHERE id=?');
        $stmt->execute([$data['titulo'], $data['descricao'], $data['icone'], $id]);
    }
    public static function delete($db, $id) {
        $stmt = $db->prepare('DELETE FROM vantagens WHERE id=?');
        $stmt->execute([$id]);
    }
} 