CREATE DATABASE SisPoupo;
USE SisPoupo;

DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(100) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    tipo_usuario VARCHAR(50) NOT NULL,
    cpf_cnpj VARCHAR(14) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    situacao_cadastral TINYINT NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
-- Senha: JohnDoe
INSERT INTO users (nome_usuario, nome, tipo_usuario, cpf_cnpj, telefone, email, password, situacao_cadastral) 
VALUES ('SisPoupo', 'Usuario Teste','USUARIO_PADRAO', '00000000000','00000000', 'sispoupo@gmail.com', '$2y$10$jSAr/RwmjhwioDlJErOk9OQEO7huLz9O6Iuf/udyGbHPiTNuB3Iuy', 1);