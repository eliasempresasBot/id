CREATE DATABASE site_usuarios;

USE site_usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    sobrenome VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    codigo_verificacao INT NOT NULL,
    verificado TINYINT(1) DEFAULT 0,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);