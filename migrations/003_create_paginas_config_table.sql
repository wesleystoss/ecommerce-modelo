CREATE TABLE IF NOT EXISTS paginas_config (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pagina TEXT NOT NULL,
    chave TEXT NOT NULL,
    valor TEXT NOT NULL
);
-- Índice para busca rápida
CREATE UNIQUE INDEX IF NOT EXISTS idx_pagina_chave ON paginas_config(pagina, chave); 