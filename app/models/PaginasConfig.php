<?php
class PaginasConfig {
    public static function get($db, $pagina, $chave) {
        $stmt = $db->prepare('SELECT valor FROM paginas_config WHERE pagina = ? AND chave = ? LIMIT 1');
        $stmt->execute([$pagina, $chave]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['valor'] : null;
    }
    public static function set($db, $pagina, $chave, $valor) {
        $existe = self::get($db, $pagina, $chave);
        if ($existe === null) {
            $stmt = $db->prepare('INSERT INTO paginas_config (pagina, chave, valor) VALUES (?, ?, ?)');
            $stmt->execute([$pagina, $chave, $valor]);
        } else {
            $stmt = $db->prepare('UPDATE paginas_config SET valor = ? WHERE pagina = ? AND chave = ?');
            $stmt->execute([$valor, $pagina, $chave]);
        }
    }
} 