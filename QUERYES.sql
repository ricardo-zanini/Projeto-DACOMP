-- ===============================================================================================================
-- ============================================= DROPS ===========================================================
-- ===============================================================================================================

DROP TABLE IF EXISTS Produtos_Compras;
DROP TABLE IF EXISTS Compras;
DROP TABLE IF EXISTS Compras_Status;
DROP TABLE IF EXISTS Usuarios_Interesses;
DROP TABLE IF EXISTS Produtos_Estoques;
DROP TABLE IF EXISTS Tamanhos;
DROP TABLE IF EXISTS Cores;
DROP TABLE IF EXISTS Produtos;
DROP TABLE IF EXISTS Tipos_Produtos;
DROP TABLE IF EXISTS Usuarios;
DROP TABLE IF EXISTS Tipos_Usuarios;

-- ===============================================================================================================
-- ============================================= CREATE ==========================================================
-- ===============================================================================================================

-- Tipos de usuário. Ex: Professor, aluno, funcionário,...
CREATE TABLE Tipos_Usuarios (
    tipo_usuario_id INT AUTO_INCREMENT PRIMARY KEY,
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
    tipo_produto_id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(100) NOT NULL
);

-- Tamanhos. Ex: P, M,...
CREATE TABLE Tamanhos (
    tamanho_id INT AUTO_INCREMENT PRIMARY KEY,
    tamanho VARCHAR(100) NOT NULL
);

-- Cores. Ex: Branco, Azul,...
CREATE TABLE Cores (
    cor_id INT AUTO_INCREMENT PRIMARY KEY,
    cor VARCHAR(100) NOT NULL
);

-- Produtos Cadastrados
CREATE TABLE Produtos (
    produto_id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo_produto_id INT NOT NULL,
    valor_unidade NUMERIC(7, 2) NOT NULL,
    imagem VARCHAR(100),
    excluido BOOLEAN,
	FOREIGN KEY (tipo_produto_id) REFERENCES Tipos_Produtos(tipo_produto_id)
);

-- Estoque dos produtos
CREATE TABLE Produtos_Estoques (
    produto_estoque_id INT AUTO_INCREMENT PRIMARY KEY,
    produto_id INT NOT NULL,
    tamanho_id INT NOT NULL,
    cor_id INT NOT NULL,
    disponivel BOOLEAN NOT NULL,
    prontaEntrega BOOLEAN NOT NULL,
    unidades INT NOT NULL,
    excluido BOOLEAN,
    FOREIGN KEY (produto_id) REFERENCES Produtos(produto_id),
    FOREIGN KEY (tamanho_id) REFERENCES Tamanhos(tamanho_id),
    FOREIGN KEY (cor_id) REFERENCES Cores(cor_id)
);

-- Interresses do cliente
CREATE TABLE Usuarios_Interesses (
    usuario_interesse_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    produto_estoque_id INT NOT NULL,
    UNIQUE (usuario_id, produto_estoque_id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id),
    FOREIGN KEY (produto_estoque_id) REFERENCES Produtos_Estoques(produto_estoque_id)
);

-- Status da compra
CREATE TABLE Compras_Status (
    status_id INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(100) NOT NULL
);

-- Registro de compra
CREATE TABLE Compras (
    compra_id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    horario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status_id INT NOT NULL,
    total NUMERIC(10,2),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(usuario_id),
    FOREIGN KEY (status_id) REFERENCES Compras_Status(status_id)
);

-- Produtos dentro de uma compra
CREATE TABLE Produtos_Compras (
    produto_compra_id INT AUTO_INCREMENT PRIMARY KEY,
    compra_id INT NOT NULL,
    produto_estoque_id INT NOT NULL,
    quantidade INT NOT NULL,
    valor_unidade NUMERIC(5, 2) NOT NULL,
    FOREIGN KEY (compra_id) REFERENCES Compras(compra_id),
    FOREIGN KEY (produto_estoque_id) REFERENCES Produtos_Estoques(produto_estoque_id)
);

-- ===============================================================================================================
-- ============================================= INSERTS =========================================================
-- ===============================================================================================================

INSERT INTO Tipos_Usuarios (tipo) VALUES ('Aluno');
INSERT INTO Tipos_Usuarios (tipo) VALUES ('Professor');
INSERT INTO Tipos_Usuarios (tipo) VALUES ('Outro');

INSERT INTO Tipos_Produtos (tipo) VALUES ('Vestuário');
INSERT INTO Tipos_Produtos (tipo) VALUES ('Acessórios');
INSERT INTO Tipos_Produtos (tipo) VALUES ('Papelaria');

INSERT INTO Tamanhos (tamanho) VALUES ('Tamanho Único');
INSERT INTO Tamanhos (tamanho) VALUES ('PP');
INSERT INTO Tamanhos (tamanho) VALUES ('P');
INSERT INTO Tamanhos (tamanho) VALUES ('M');
INSERT INTO Tamanhos (tamanho) VALUES ('G');
INSERT INTO Tamanhos (tamanho) VALUES ('GG');

INSERT INTO Cores (cor) VALUES ('Cor Única');
INSERT INTO Cores (cor) VALUES ('Branco');
INSERT INTO Cores (cor) VALUES ('Preto');
INSERT INTO Cores (cor) VALUES ('Azul');
INSERT INTO Cores (cor) VALUES ('Vermelho');
INSERT INTO Cores (cor) VALUES ('Cinza');

INSERT INTO Produtos (nome, tipo_produto_id, valor_unidade, imagem, excluido) VALUES ('Camiseta CIC', 1, 50.99, "camisetacic.jpg", 0);
INSERT INTO Produtos (nome, tipo_produto_id, valor_unidade, imagem, excluido) VALUES ('Camiseta EC', 1, 50.99, "camisetaec.jpg", 0);
INSERT INTO Produtos (nome, tipo_produto_id, valor_unidade, imagem, excluido) VALUES ('Moletom INF', 1, 120.00, "moletominf.jpg", 0);
INSERT INTO Produtos (nome, tipo_produto_id, valor_unidade, imagem, excluido) VALUES ('Moletom CIC', 1, 120.00, "moletomcic.jpg", 0);
INSERT INTO Produtos (nome, tipo_produto_id, valor_unidade, imagem, excluido) VALUES ('Chaveiro UFGRS', 2, 5.00, "chaveiroufrgs.jpg", 0);
INSERT INTO Produtos (nome, tipo_produto_id, valor_unidade, imagem, excluido) VALUES ('Boné UFGRS', 1, 70.99, "boneufrgs.jpg", 0);
INSERT INTO Produtos (nome, tipo_produto_id, valor_unidade, imagem, excluido) VALUES ('Caderno UFRGS', 3, 30.00, "cadernoufrgs.jpg", 0);

INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (1, 3, 2, True, True, 10, 0);
INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (1, 4, 2, True, True, 5, 0);
INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (2, 5, 3, True, False, 0, 0);
INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (2, 5, 6, True, False, 0, 0);
INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (3, 2, 2, True, True, 20, 0);
INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (3, 3, 2, True, True, 15, 0);
INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (4, 4, 4, True, True, 20, 0);
INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (4, 5, 5, True, True, 20, 0);
INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (5, 1, 1, True, False, 0, 0);
INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (6, 1, 3, False, False, 0, 0);
INSERT INTO Produtos_Estoques (produto_id, tamanho_id, cor_id, disponivel, prontaEntrega, unidades, excluido) VALUES (7, 1, 1, False, False, 0, 0);

INSERT INTO Compras_Status (status) VALUES ('Em andamento');
INSERT INTO Compras_Status (status) VALUES ('Pagamento finalizado');
INSERT INTO Compras_Status (status) VALUES ('Entregue');
