CREATE TABLE turmas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    turma VARCHAR(100) NOT NULL,
    ano INT NOT NULL,
    turno ENUM('Manhã', 'Tarde') NOT NULL
);
INSERT INTO turmas (turma, ano, turno) VALUES
('primeiro ano ', 2025, 'Manhã'),
('segindo Ano ', 2025, 'Manhã'),
('terceiro Ano ', 2025, 'Manhã'),

z'

CREATE TABLE atrasos (
    id INT(11) NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    motivo_atraso TEXT NOT NULL,
    data_registro TIMESTAMP NOT NULL DEFAULT current_timestamp(),
    turma VARCHAR(100) DEFAULT NULL,
    motivo TEXT DEFAULT NULL,
    data DATETIME DEFAULT NULL,
    PRIMARY KEY (id)
);

 CREATE TABLE alunos (
    ->     id INT AUTO_INCREMENT PRIMARY KEY,
    ->     nome VARCHAR(255) NOT NULL,
    ->     turma VARCHAR(100) NOT NULL
    -> );

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);


ALTER TABLE usuarios ADD COLUMN setor VARCHAR(100) NOT NULL;

INSERT INTO usuarios (nome, senha, setor) 
VALUES ('Eduardo', '12345', 'Admin');


usuários = para logar no admim
alunos = nome de todos os alunos
turmas = nome de todas as turmas
atrasos = registrar os atrasos 
