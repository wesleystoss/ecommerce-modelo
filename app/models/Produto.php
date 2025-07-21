<?php
class Produto {
    public static function all($db) {
        return $db->query('SELECT p.*, c.nome as categoria_nome FROM produtos p LEFT JOIN categorias c ON p.categoria_id = c.id')->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function find($db, $id) {
        $stmt = $db->prepare('SELECT * FROM produtos WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public static function create($db, $data) {
        $stmt = $db->prepare('INSERT INTO produtos (nome, descricao, preco, imagem, categoria_id, destaque, tipo_estoque, estoque, em_promocao, preco_promocional, percentual_desconto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['nome'],
            $data['descricao'],
            $data['preco'],
            $data['imagem'],
            $data['categoria_id'],
            $data['destaque'] ?? 0,
            $data['tipo_estoque'] ?? 'ilimitado',
            $data['estoque'] ?? 0,
            $data['em_promocao'] ?? 0,
            $data['preco_promocional'] ?? null,
            $data['percentual_desconto'] ?? null
        ]);
    }
    public static function update($db, $id, $data) {
        $stmt = $db->prepare('UPDATE produtos SET nome=?, descricao=?, preco=?, imagem=?, categoria_id=?, destaque=?, tipo_estoque=?, estoque=?, em_promocao=?, preco_promocional=?, percentual_desconto=? WHERE id=?');
        $stmt->execute([
            $data['nome'],
            $data['descricao'],
            $data['preco'],
            $data['imagem'],
            $data['categoria_id'],
            $data['destaque'] ?? 0,
            $data['tipo_estoque'] ?? 'ilimitado',
            $data['estoque'] ?? 0,
            $data['em_promocao'] ?? 0,
            $data['preco_promocional'] ?? null,
            $data['percentual_desconto'] ?? null,
            $id
        ]);
    }
    public static function delete($db, $id) {
        $stmt = $db->prepare('DELETE FROM produtos WHERE id=?');
        $stmt->execute([$id]);
    }
    public static function destaques($db, $limite = 4) {
        if ($limite) {
            $stmt = $db->prepare('SELECT * FROM produtos WHERE destaque = 1 LIMIT ?');
            $stmt->bindValue(1, $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $db->prepare('SELECT * FROM produtos WHERE destaque = 1');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
    public static function promocoes($db, $limite = 4) {
        if ($limite) {
            $stmt = $db->prepare('SELECT * FROM produtos WHERE em_promocao = 1 LIMIT ?');
            $stmt->bindValue(1, $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $stmt = $db->prepare('SELECT * FROM produtos WHERE em_promocao = 1');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
} 