-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS hospital_marzagaotech;
USE hospital_marzagaotech;

-- Tabela de usuários (técnicos)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    setor VARCHAR(100) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de equipamentos
CREATE TABLE equipamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    modelo VARCHAR(100),
    numero_serie VARCHAR(100),
    setor VARCHAR(100) NOT NULL,
    status ENUM('funcionando', 'manutencao', 'descartado') DEFAULT 'funcionando',
    descricao TEXT NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de manutenção
CREATE TABLE manutencao (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipamento_id INT NOT NULL,
    tecnico_id INT NOT NULL,
    data_inicio DATETIME DEFAULT CURRENT_TIMESTAMP,
    data_fim DATETIME,
    status_final ENUM('funcionando', 'descartado') NOT NULL,
    observacoes TEXT,
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id),
    FOREIGN KEY (tecnico_id) REFERENCES usuarios(id)
);

-- Tabela de descartes
CREATE TABLE descartes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipamento_id INT NOT NULL,
    motivo TEXT NOT NULL,
    data_descarte TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    responsavel_id INT,
    FOREIGN KEY (equipamento_id) REFERENCES equipamentos(id),
    FOREIGN KEY (responsavel_id) REFERENCES usuarios(id)
);

-- Tabela de substituições
CREATE TABLE substituicoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipamento_antigo INT NOT NULL,
    equipamento_novo INT NOT NULL,
    setor VARCHAR(100) NOT NULL,
    motivo TEXT NOT NULL,
    data_substituicao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (equipamento_antigo) REFERENCES equipamentos(id),
    FOREIGN KEY (equipamento_novo) REFERENCES equipamentos(id)
);

-- Trigger para atualizar status após manutenção
DELIMITER //
CREATE TRIGGER trg_manutencao_update_status
AFTER INSERT ON manutencao
FOR EACH ROW
BEGIN
    IF NEW.status_final = 'funcionando' THEN
        UPDATE equipamentos SET status = 'funcionando' WHERE id = NEW.equipamento_id;
    ELSEIF NEW.status_final = 'descartado' THEN
        -- Só atualiza se houver descarte registrado com motivo
        IF EXISTS (
            SELECT * FROM descartes 
            WHERE equipamento_id = NEW.equipamento_id AND motivo IS NOT NULL
        ) THEN
            UPDATE equipamentos SET status = 'descartado' WHERE id = NEW.equipamento_id;
        END IF;
    END IF;
END;
//
DELIMITER ;

-- Trigger para obrigar motivo em substituições
DELIMITER //
CREATE TRIGGER trg_verificar_motivo_substituicao
BEFORE INSERT ON substituicoes
FOR EACH ROW
BEGIN
    IF NEW.motivo IS NULL OR TRIM(NEW.motivo) = '' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Motivo da substituição é obrigatório!';
    END IF;
END;
//
DELIMITER ;

-- Trigger para obrigar motivo em descartes
DELIMITER //
CREATE TRIGGER trg_verificar_motivo_descarte
BEFORE INSERT ON descartes
FOR EACH ROW
BEGIN
    IF NEW.motivo IS NULL OR TRIM(NEW.motivo) = '' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Motivo do descarte é obrigatório!';
    END IF;
END;
//
DELIMITER ;
