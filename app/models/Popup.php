<?php
class Popup {
    public static function all($db) {
        return $db->query('SELECT * FROM popups ORDER BY criado_em DESC')->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($db, $id) {
        $stmt = $db->prepare('SELECT * FROM popups WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($db, $data) {
        $stmt = $db->prepare('INSERT INTO popups (titulo, conteudo_html, tamanho, tipo, paginas_exibicao, frequencia, cor_fundo, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([
            $data['titulo'],
            $data['conteudo_html'],
            $data['tamanho'],
            $data['tipo'],
            json_encode($data['paginas_exibicao']), // Salva como JSON
            $data['frequencia'] ?? 'sempre',
            $data['cor_fundo'] ?? null,
            $data['ativo'] ?? 0
        ]);
        return $db->lastInsertId();
    }

    public static function update($db, $id, $data) {
        $stmt = $db->prepare('UPDATE popups SET titulo=?, conteudo_html=?, tamanho=?, tipo=?, paginas_exibicao=?, frequencia=?, cor_fundo=?, ativo=? WHERE id=?');
        $stmt->execute([
            $data['titulo'],
            $data['conteudo_html'],
            $data['tamanho'],
            $data['tipo'],
            json_encode($data['paginas_exibicao']), // Salva como JSON
            $data['frequencia'] ?? 'sempre',
            $data['cor_fundo'] ?? null,
            $data['ativo'] ?? 0,
            $id
        ]);
    }

    public static function delete($db, $id) {
        $stmt = $db->prepare('DELETE FROM popups WHERE id = ?');
        $stmt->execute([$id]);
    }

    public static function getActivePopupForPage($db, $rota) {
        $stmt = $db->prepare("SELECT * FROM popups WHERE ativo = 1");
        $stmt->execute();
        $popups = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($popups as $popup) {
            $paginas = json_decode($popup['paginas_exibicao'], true);
            if (in_array($rota, $paginas)) {
                return $popup; // Retorna o primeiro pop-up ativo para a página
            }
        }
        return null;
    }
} 