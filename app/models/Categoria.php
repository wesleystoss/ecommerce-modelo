<?php
class Categoria {
    public static function all($db) {
        return $db->query('SELECT * FROM categorias')->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($db, $id) {
        $stmt = $db->prepare('SELECT * FROM categorias WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($db, $data) {
        $stmt = $db->prepare('INSERT INTO categorias (nome, icone, descricao) VALUES (?, ?, ?)');
        $stmt->execute([$data['nome'], $data['icone'], $data['descricao']]);
    }
    public static function update($db, $id, $data) {
        $stmt = $db->prepare('UPDATE categorias SET nome=?, icone=?, descricao=? WHERE id=?');
        $stmt->execute([$data['nome'], $data['icone'], $data['descricao'], $id]);
    }
    public static function delete($db, $id) {
        $stmt = $db->prepare('DELETE FROM categorias WHERE id=?');
        $stmt->execute([$id]);
    }
} 