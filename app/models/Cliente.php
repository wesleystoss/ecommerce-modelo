<?php
class Cliente {
    public static function all($db) {
        return $db->query('SELECT * FROM clientes')->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($db, $id) {
        $stmt = $db->prepare('SELECT * FROM clientes WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($db, $data) {
        $stmt = $db->prepare('INSERT INTO clientes (nome, email, telefone, senha, bloqueado) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$data['nome'], $data['email'], $data['telefone'], $data['senha'], $data['bloqueado'] ?? 0]);
    }
    public static function update($db, $id, $data) {
        $stmt = $db->prepare('UPDATE clientes SET nome=?, email=?, telefone=?, senha=?, bloqueado=? WHERE id=?');
        $stmt->execute([$data['nome'], $data['email'], $data['telefone'], $data['senha'], $data['bloqueado'] ?? 0, $id]);
    }
    public static function delete($db, $id) {
        $stmt = $db->prepare('DELETE FROM clientes WHERE id=?');
        $stmt->execute([$id]);
    }
} 