CREATE DATABASE SisPoupo;
USE SisPoupo;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(100) NOT NULL UNIQUE,
    nome VARCHAR(100) NOT NULL,
    tipo_usuario VARCHAR(50) NOT NULL,  -- USUARIO_PADRAO | USUARIO_ADMIN | USUARIO_EMPRESA
    cpf_cnpj VARCHAR(14) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    situacao_cadastral TINYINT NOT NULL DEFAULT 1, -- 1 = Ativo, 0 = Inativo
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Senha: JohnDoe
INSERT INTO users (nome_usuario, nome, tipo_usuario, cpf_cnpj, telefone, email, password, situacao_cadastral) 
VALUES ('SisPoupo', 'Usuario Teste','USUARIO_PADRAO', '00000000000','00000000', 'sispoupo@gmail.com', '$2y$10$jSAr/RwmjhwioDlJErOk9OQEO7huLz9O6Iuf/udyGbHPiTNuB3Iuy', 1);

DROP TABLE IF EXISTS cartao_credito;
CREATE TABLE cartao_credito (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    nome_cartao VARCHAR(100) NOT NULL,
    limite_credito DECIMAL(10, 2) NOT NULL,
    dia_vencimento INT NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela para agrupar parcelas de boletos, cartões de crédito e PIX parcelado
DROP TABLE IF EXISTS movimentacao_grupo;
CREATE TABLE movimentacao_grupo (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    tipo_grupo VARCHAR(50) NOT NULL COMMENT 'CARTAO_CREDITO, BOLETO, PIX, OUTROS',
    valor_total DECIMAL(10, 2) NOT NULL COMMENT 'Valor total do grupo',
    quantidade_parcelas INT UNSIGNED NOT NULL COMMENT 'Número total de parcelas',
    parcelas_pagas INT UNSIGNED DEFAULT 0 COMMENT 'Parcelas já pagas',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS movimentacao_financeira;
CREATE TABLE movimentacao_financeira (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,    
    descricao VARCHAR(255) NOT NULL,
    tipo_movimentacao VARCHAR(100) NOT NULL, -- DESPESA ou RECEITA
    valor DECIMAL(10, 2) NOT NULL,
    classificacao_financeira VARCHAR(14) NOT NULL, -- FIXA, VARIAVEL
    status_pagamento VARCHAR(20) NOT NULL, -- PAGO, NAO_PAGO,  pendente, atrasado
    forma_pagamento VARCHAR(20) NULL, -- DINHEIRO, CARTAO_CREDITO, CARTAO_DEBITO, PIX, TRANSFERENCIA_BANCARIA, boleto, cheque
    quantidade_parcelas INT UNSIGNED NULL, -- Número de parcelas, se aplicável
    cartao_credito_id BIGINT UNSIGNED NULL, -- Referência para o cartão de crédito, se aplicável
    FOREIGN KEY (cartao_credito_id) REFERENCES cartao_credito(id) ON DELETE SET NULL,
    grupo_id BIGINT UNSIGNED NULL,
    FOREIGN KEY (grupo_id) REFERENCES movimentacao_grupo(id) ON DELETE SET NULL,    
    data_pagamento TIMESTAMP NULL,
    data_vencimento DATE NOT NULL,
    dia_vencimento INT NULL,
    despesa_repete_mes TINYINT NOT NULL DEFAULT 1, -- 1 = Ativo, 0 = Inativo
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS style;
CREATE TABLE style (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    cor_primaria VARCHAR(255) NULL,
    cor_secundario VARCHAR(255) NULL,
    cor_fundo VARCHAR(255) NULL,
    cor_texto VARCHAR(255) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);