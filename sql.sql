CREATE DATABASE IF NOT EXISTS honoink CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE honoink;

-- Cria a tabela de usuários, se não existir
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('usuario','admin') DEFAULT 'usuario',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    foto_perfil VARCHAR(255) DEFAULT 'default.png'
);

-- Insere o usuário admin apenas se não existir
INSERT INTO usuarios (nome, usuario, senha, tipo)
SELECT * FROM (SELECT 'Kamile Hono', 'kamile', 
        '$2y$10$NZ4NmqFtaqWoUBxlEO845.O.0aEW929.JWO8xmSLIllZYAq8B/2um',
        'admin') AS tmp
WHERE NOT EXISTS (
    SELECT usuario FROM usuarios WHERE usuario = 'kamile'
) LIMIT 1;

-- Atualiza a senha caso queira garantir
UPDATE usuarios
SET senha = '$2y$10$NZ4NmqFtaqWoUBxlEO845.O.0aEW929.JWO8xmSLIllZYAq8B/2um'
WHERE usuario = 'kamile';

CREATE TABLE IF NOT EXISTS orcamentos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255),
  telefone VARCHAR(30),
  descricao TEXT,
  local VARCHAR(100),
  imagem VARCHAR(255),
  data_envio DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE cards_eventos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    subtitulo VARCHAR(255),
    texto1 VARCHAR(255),
    texto2 VARCHAR(255),
    texto3 VARCHAR(255),
    texto4 VARCHAR(255),
    imagem VARCHAR(255)
);
INSERT INTO cards_eventos (id, titulo, subtitulo, texto1, texto2, texto3, texto4, imagem)
VALUES
(1, 'Mini Flash', 'Até 4 horas de evento', 'Até 8 tatuagens pequenas', 'Ideal para eventos menores', 'Catálogo pronto de tatuagens', 'Realizado por ordem de chegada e lista de espera', 'evento-card1.png'),
(2, 'Flash Padrão', 'Até 6 horas de evento', 'Até 14 tatuagens pequenas', 'Ideal para casamentos e aniversários', 'Catálogo pronto de tatuagens', 'Realizado por ordem de chegada e lista de espera', 'evento-card1.png'),
(3, 'Full Tattoo', 'Até 8 horas de evento', 'Até 20 tatuagens pequenas', 'Ideal para casamentos e aniversários', 'Catálogo pronto de tatuagens', 'Realizado por ordem de chegada e lista de espera', 'evento-card1.png');

CREATE TABLE galeria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    imagem VARCHAR(255) NOT NULL,
    categoria ENUM('fineline','blackwork','flash') NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

