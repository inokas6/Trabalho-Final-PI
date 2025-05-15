-- Inserir produtos de exemplo
INSERT INTO `produtos` (`nome_pt`, `nome_en`, `descricao_pt`, `descricao_en`, `id_tipo`, `id_categoria`, `preco`) VALUES
('Camiseta Básica Verde', 'Basic Green T-Shirt', 'Camiseta básica feita com algodão orgânico', 'Basic t-shirt made with organic cotton', 3, 1, 29.99),
('Vestido Floral', 'Floral Dress', 'Vestido floral sustentável para o verão', 'Sustainable floral dress for summer', 4, 2, 59.99),
('Camisola de Lã Natural', 'Natural Wool Sweater', 'Camisola quente feita com lã natural', 'Warm sweater made with natural wool', 1, 1, 79.99),
('Vestido Casual', 'Casual Dress', 'Vestido casual para o dia a dia', 'Casual dress for everyday wear', 4, 2, 49.99),
('T-Shirt Unissexo', 'Unisex T-Shirt', 'T-shirt unissexo em algodão reciclado', 'Unisex t-shirt in recycled cotton', 3, 4, 34.99),
('Camisola Infantil', 'Children Sweater', 'Camisola confortável para crianças', 'Comfortable sweater for children', 1, 3, 39.99);

-- Inserir tamanhos para os produtos
INSERT INTO `produto_tamanho` (`id_produto`, `id_tamanho`) VALUES
(8, 1), -- S
(8, 2), -- M
(8, 3), -- L
(9, 1), -- S
(9, 2), -- M
(9, 3), -- L
(10, 1), -- S
(10, 2), -- M
(10, 3), -- L
(11, 1), -- S
(11, 2), -- M
(11, 3), -- L
(12, 1), -- S
(12, 2), -- M
(12, 3), -- L
(13, 1), -- S
(13, 2), -- M
(13, 3); -- L 