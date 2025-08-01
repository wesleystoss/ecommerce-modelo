CREATE TABLE IF NOT EXISTS popups (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo VARCHAR(255) NOT NULL,
    conteudo_html TEXT NOT NULL,
    tamanho VARCHAR(50) NOT NULL DEFAULT 'medio',
    tipo VARCHAR(50) NOT NULL DEFAULT 'modal_central',
    paginas_exibicao TEXT,
    frequencia VARCHAR(50) NOT NULL DEFAULT 'sempre',
    cor_fundo VARCHAR(100) DEFAULT NULL,
    ativo BOOLEAN NOT NULL DEFAULT 0,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 