--===============================================================================================================
--============================================= DROPS ===========================================================
--===============================================================================================================

DROP TABLE Usuarios;
DROP TABLE Tipos_Usuarios;
DROP TABLE Produtos;
DROP TABLE Tipos_Produtos;
DROP TABLE Usuarios_Interesses;
DROP TABLE Compras;
DROP TABLE Produtos_Compras;

--===============================================================================================================
--============================================= CREATE ==========================================================
--===============================================================================================================

-- Tipos de usuário. Ex: Professor, aluno, funcionário,...
CREATE TABLE Tipos_Usuarios (
    tipo_usuario_id INT PRIMARY KEY,
	tipo VARCHAR(100) NOT NULL
);

-- Usuarios do sistema, pode ou não ser gestor
CREATE TABLE Usuarios (
    usuario_id INT AUTO_INCREMENT PRIMARY KEY,
	cartao_UFRGS VARCHAR(20) UNIQUE,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(200) NOT NULL,
    password VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    gestor BOOLEAN NOT NULL,
    tipo_usuario_id INT NOT NULL,
	FOREIGN KEY (tipo_usuario_id) REFERENCES Tipos_Usuarios(tipo_usuario_id)
);

-- Tipos de produtos. Ex: Roupas, chaveiros,...
CREATE TABLE Tipos_Produtos (
    tipo_produto_id INT PRIMARY KEY,
    tipo VARCHAR(100) NOT NULL
);

-- Produtos Cadastrados
CREATE TABLE Produtos (
    produto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo_produto_id INT NOT NULL,
    preco NUMERIC(3, 2) NOT NULL,
    disponivel BOOLEAN NOT NULL,
    prontaEntrega BOOLEAN NOT NULL,
	FOREIGN KEY (tipo_produto_id) REFERENCES Tipos_Produtos(tipo_produto_id)
);

-- Interresses do cliente
CREATE TABLE Usuarios_Interesses (
    usuario_interesse_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    produto_id INT NOT NULL,
    UNIQUE (usuario_id, produto_id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id),
    FOREIGN KEY (produto_id) REFERENCES Produtos(produto_id)
);

-- Registro de compra
CREATE TABLE Compras (
    compra_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    horario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id)
);

-- Produtos dentro de uma compra
CREATE TABLE Produtos_Compras (
    produto_compra_id INT AUTO_INCREMENT PRIMARY KEY,
    compra_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    valor_unidade NUMERIC(3, 2) NOT NULL,
    FOREIGN KEY (compra_id) REFERENCES Compras(compra_id),
    FOREIGN KEY (produto_id) REFERENCES Produtos(produto_id)
);

--===============================================================================================================
--============================================= INSERTS =========================================================
--===============================================================================================================

INSERT INTO Tipos_Usuarios (tipo_usuario_id, tipo) VALUES (0, 'Aluno');
INSERT INTO Tipos_Usuarios (tipo_usuario_id, tipo) VALUES (1, 'Professor');

INSERT INTO Tipos_Produtos (tipo_produto_id, tipo) VALUES (0, 'Camiseta');
INSERT INTO Tipos_Produtos (tipo_produto_id, tipo) VALUES (1, 'Chaveiro');
INSERT INTO Tipos_Produtos (tipo_produto_id, tipo) VALUES (2, 'Bottom');

INSERT INTO Produtos (nome, tipo_produto_id, preco, disponivel, prontaEntrega) VALUES ('Camiseta INF Branca', 0, 50.99, True, False);
INSERT INTO Produtos (nome, tipo_produto_id, preco, disponivel, prontaEntrega) VALUES ('Camiseta INF Preta', 0, 50.99, True, False);
INSERT INTO Produtos (nome, tipo_produto_id, preco, disponivel, prontaEntrega) VALUES ('Camiseta INF Azul', 0, 50.99, True, True);
INSERT INTO Produtos (nome, tipo_produto_id, preco, disponivel, prontaEntrega) VALUES ('Moletom INF Preto', 0, 75.99, True, True);
INSERT INTO Produtos (nome, tipo_produto_id, preco, disponivel, prontaEntrega) VALUES ('Chaveiro INF customizado', 1, 5.0, True, False);
INSERT INTO Produtos (nome, tipo_produto_id, preco, disponivel, prontaEntrega) VALUES ('Chapéu DACOMP', 1, 100.0, False, False);

