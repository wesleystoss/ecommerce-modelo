# Loja Modelo

Loja Modelo é um projeto de e-commerce desenvolvido em PHP, utilizando Tailwind CSS para o frontend e SQLite como banco de dados. O objetivo é servir como base para lojas virtuais simples, com painel administrativo, cadastro de produtos, categorias, clientes, cupons, banners, FAQs, popups, vantagens e pedidos.

## Tecnologias Utilizadas

- **PHP >= 7.4**
- **SQLite** (banco de dados local)
- **Tailwind CSS** (estilização)
- **PostCSS** e **Autoprefixer** (build CSS)

## Estrutura do Projeto

- `app/controllers/` — Controladores da aplicação (público e admin)
- `app/models/` — Modelos de dados (Produto, Cliente, Categoria, etc.)
- `app/views/` — Views em PHP (público e admin)
- `public/` — Arquivos públicos (index.php, assets, css)
- `config/database.php` — Configuração do banco de dados SQLite
- `migrations/` — Scripts SQL para criação das tabelas
- `storage/loja.sqlite` — Banco de dados SQLite

## Como rodar localmente

1. **Pré-requisitos:**
   - PHP >= 7.4
   - Composer
   - Node.js e npm (para build do CSS)

2. **Instale as dependências PHP:**
   ```bash
   composer install
   ```

3. **Instale as dependências JS:**
   ```bash
   npm install
   ```

4. **Compile o CSS do Tailwind:**
   - Para desenvolvimento (watch):
     ```bash
     npm run dev
     ```
   - Para build de produção:
     ```bash
     npm run build
     ```

5. **Configure o banco de dados:**
   - O projeto já utiliza um banco SQLite em `storage/loja.sqlite`.
   - Para criar um novo banco, apague o arquivo e rode os scripts em `migrations/` usando um cliente SQLite:
     ```bash
     sqlite3 storage/loja.sqlite < migrations/001_create_popups_table.sql
     sqlite3 storage/loja.sqlite < migrations/002_create_faqs_table.sql
     sqlite3 storage/loja.sqlite < migrations/003_create_paginas_config_table.sql
     ```

6. **Inicie o servidor local:**
   ```bash
   php -S localhost:8000 -t public
   ```
   Acesse [http://localhost:8000](http://localhost:8000) no navegador.

7. **Acesse o painel administrativo:**
   - [http://localhost:8000/admin](http://localhost:8000/admin)

## Funcionalidades

- Página inicial com banners, produtos em destaque, vantagens, avaliações e FAQs
- Listagem, cadastro, edição e exclusão de produtos, categorias, clientes, cupons, banners, popups, vantagens e FAQs
- Carrinho de compras e checkout
- Painel administrativo completo
- Configuração de informações da loja

## Observações

- O projeto é apenas um modelo/base e pode ser customizado conforme a necessidade.
- Não possui autenticação de admin por padrão (implemente conforme sua necessidade).
- O banco SQLite é suficiente para testes e projetos pequenos. Para produção, recomenda-se adaptar para MySQL/PostgreSQL.

## Scripts úteis

- `npm run dev` — Compila o CSS do Tailwind em modo watch
- `npm run build` — Compila o CSS do Tailwind minificado para produção

---

Feito por Wesley Santos
