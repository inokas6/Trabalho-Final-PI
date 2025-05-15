-- Criar tabela de categorias
CREATE TABLE IF NOT EXISTS categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    ling VARCHAR(2) NOT NULL
);

-- Criar tabela de subcategorias
CREATE TABLE IF NOT EXISTS subcategorias (
    id_subcategoria INT AUTO_INCREMENT PRIMARY KEY,
    id_categoria INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    ling VARCHAR(2) NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria)
);

-- Criar tabela de produtos
CREATE TABLE IF NOT EXISTS produtos (
    id_produto INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    tamanho VARCHAR(20),
    imagem VARCHAR(255),
    avaliacao INT DEFAULT 0,
    ling VARCHAR(2) NOT NULL,
    id_categoria INT NOT NULL,
    id_subcategoria INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES categorias(id_categoria),
    FOREIGN KEY (id_subcategoria) REFERENCES subcategorias(id_subcategoria)
);

-- Inserir dados de exemplo para categorias
INSERT INTO categorias (nome, ling) VALUES 
('Roupas', 'pt'),
('Acessórios', 'pt'),
('Calçados', 'pt'),
('Clothing', 'en'),
('Accessories', 'en'),
('Shoes', 'en');

-- Inserir dados de exemplo para subcategorias
INSERT INTO subcategorias (id_categoria, nome, ling) VALUES 
(1, 'Camisetas', 'pt'),
(1, 'Calças', 'pt'),
(1, 'Vestidos', 'pt'),
(2, 'Bolsas', 'pt'),
(2, 'Relógios', 'pt'),
(3, 'Tênis', 'pt'),
(3, 'Sapatos', 'pt'),
(4, 'T-Shirts', 'en'),
(4, 'Pants', 'en'),
(4, 'Dresses', 'en'),
(5, 'Bags', 'en'),
(5, 'Watches', 'en'),
(6, 'Sneakers', 'en'),
(6, 'Shoes', 'en');

-- Inserir dados de exemplo para produtos
INSERT INTO produtos (nome, descricao, preco, tamanho, imagem, avaliacao, ling, id_categoria, id_subcategoria) VALUES 
('Camiseta Básica', 'Camiseta básica de algodão', 49.90, 'P/M/G', 'assets/img/shop_01.jpg', 4, 'pt', 1, 1),
('Calça Jeans', 'Calça jeans skinny', 129.90, '38/40/42', 'assets/img/shop_02.jpg', 5, 'pt', 1, 2),
('Vestido Floral', 'Vestido floral para verão', 89.90, 'P/M/G', 'assets/img/shop_03.jpg', 4, 'pt', 1, 3),
('Basic T-Shirt', 'Basic cotton t-shirt', 49.90, 'S/M/L', 'assets/img/shop_01.jpg', 4, 'en', 4, 8),
('Skinny Jeans', 'Skinny fit jeans', 129.90, '38/40/42', 'assets/img/shop_02.jpg', 5, 'en', 4, 9),
('Floral Dress', 'Summer floral dress', 89.90, 'S/M/L', 'assets/img/shop_03.jpg', 4, 'en', 4, 10); 