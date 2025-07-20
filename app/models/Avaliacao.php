<?php
class Avaliacao {
    public static function all($db) {
        return $db->query('SELECT * FROM avaliacoes')->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($db, $id) {
        $stmt = $db->prepare('SELECT * FROM avaliacoes WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($db, $data) {
        $stmt = $db->prepare('INSERT INTO avaliacoes (nome_cliente, texto, nota) VALUES (?, ?, ?)');
        $stmt->execute([$data['nome_cliente'], $data['texto'], $data['nota']]);
    }
    public static function update($db, $id, $data) {
        $stmt = $db->prepare('UPDATE avaliacoes SET nome_cliente=?, texto=?, nota=? WHERE id=?');
        $stmt->execute([$data['nome_cliente'], $data['texto'], $data['nota'], $id]);
    }
    public static function delete($db, $id) {
        $stmt = $db->prepare('DELETE FROM avaliacoes WHERE id=?');
        $stmt->execute([$id]);
    }
} 