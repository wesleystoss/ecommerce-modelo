<?php
class Configuracao {
    public static function get($db) {
        return $db->query('SELECT * FROM configuracoes WHERE id = 1')->fetch(PDO::FETCH_ASSOC);
    }
    public static function update($db, $data) {
        $stmt = $db->prepare('UPDATE configuracoes SET nome_empresa=?, logo=?, email=?, telefone=?, endereco=?, logo_height=? WHERE id=1');
        $stmt->execute([
            $data['nome_empresa'],
            $data['logo'],
            $data['email'],
            $data['telefone'],
            $data['endereco'],
            $data['logo_height'] ?? 32
        ]);
    }
} 