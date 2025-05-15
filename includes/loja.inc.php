<?php

include 'header.inc.php';
echo '<body>';
include 'nav.inc.php';

// Conteúdo da página de loja
echo '
    <!-- Start Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <h1 class="h2 pb-4">Categorias</h1>
                <ul class="list-unstyled templatemo-accordion">';

// Buscar categorias do banco de dados
$categorias = my_query('SELECT * FROM categorias');

if($categorias && is_array($categorias)) {
    foreach($categorias as $categoria) {
        if(isset($categoria['id_categoria'])) {
            $nome_categoria = $_SESSION['ling'] == 'pt' ? $categoria['categoria_pt'] : $categoria['categoria_en'];
            echo '<li class="pb-3">
                    <a class="collapsed d-flex justify-content-between h3 text-decoration-none" href="#">
                        ' . htmlspecialchars($nome_categoria) . '
                        <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </a>
                    <ul class="collapse show list-unstyled pl-3">';
            
            // Buscar tipos de produtos para esta categoria
            $tipos = my_query('SELECT * FROM tipo');
            
            if($tipos && is_array($tipos)) {
                foreach($tipos as $tipo) {
                    $nome_tipo = $_SESSION['ling'] == 'pt' ? $tipo['tipo_pt'] : $tipo['tipo_eng'];
                    echo '<li><a class="text-decoration-none" href="#">' . htmlspecialchars($nome_tipo) . '</a></li>';
                }
            }
            
            echo '</ul></li>';
        }
    }
}

echo '</ul>
            </div>

            <div class="col-lg-9">
                <h2 class="h2 pb-4">Filtros Avançados</h2>
                <form method="GET" action="loja.php" class="mb-4">
                    <div class="row">
                        <!-- Linha 1 de Filtros -->
                        <div class="col-md-4 mb-3">
                            <label for="pesquisa" class="form-label">Pesquisar Artigo</label>
                            <input type="text" name="pesquisa" id="pesquisa" class="form-control" placeholder="Nome do artigo..." value="<?php echo (isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : ''); ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="categoria" class="form-label">Categoria</label>
                            <select name="categoria" id="categoria" class="form-control">
                                <option value="">Mostrar tudo</option>
                                <?php
                                if ($categorias && is_array($categorias)) {
                                    foreach ($categorias as $cat) {
                                        $selected = (isset($_GET['categoria']) && $_GET['categoria'] == $cat['id_categoria']) ? 'selected' : '';
                                        $nome_cat = $_SESSION['ling'] == 'pt' ? $cat['categoria_pt'] : $cat['categoria_en'];
                                        echo '<option value="' . intval($cat['id_categoria']) . '" ' . $selected . '>' . htmlspecialchars($nome_cat) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="tipo" class="form-label">Tipo/Subcategoria</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option value="">Mostrar tudo</option>
                                <?php
                                // Assumindo que $tipos foi buscado anteriormente, como $tipos = my_query('SELECT * FROM tipo');
                                if ($tipos && is_array($tipos)) {
                                    foreach ($tipos as $tp) {
                                        $selected = (isset($_GET['tipo']) && $_GET['tipo'] == $tp['id_tipo']) ? 'selected' : '';
                                        $nome_tp = $_SESSION['ling'] == 'pt' ? $tp['tipo_pt'] : $tp['tipo_eng'];
                                        echo '<option value="' . intval($tp['id_tipo']) . '" ' . $selected . '>' . htmlspecialchars($nome_tp) . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Linha 2 de Filtros -->
                        <div class="col-md-3 mb-3">
                            <label for="preco_min" class="form-label">Preço De</label>
                            <input type="number" name="preco_min" id="preco_min" class="form-control" placeholder="De" value="<?php echo isset($_GET['preco_min']) ? htmlspecialchars($_GET['preco_min']) : ''; ?>" step="0.01">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="preco_max" class="form-label">Preço Até</label>
                            <input type="number" name="preco_max" id="preco_max" class="form-control" placeholder="Até" value="<?php echo isset($_GET['preco_max']) ? htmlspecialchars($_GET['preco_max']) : ''; ?>" step="0.01">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="tamanho" class="form-label">Tamanho</label>
                            <select name="tamanho" id="tamanho" class="form-control">
                                <option value="">Mostrar tudo</option>
                                <option value="P" <?php echo (isset($_GET['tamanho']) && $_GET['tamanho'] == 'P') ? 'selected' : ''; ?>>P</option>
                                <option value="M" <?php echo (isset($_GET['tamanho']) && $_GET['tamanho'] == 'M') ? 'selected' : ''; ?>>M</option>
                                <option value="G" <?php echo (isset($_GET['tamanho']) && $_GET['tamanho'] == 'G') ? 'selected' : ''; ?>>G</option>
                                <!-- Adicionar mais tamanhos ou popular dinamicamente se necessário -->
                            </select>
                        </div>
                         <div class="col-md-3 mb-3">
                            <label for="cor" class="form-label">Cor</label>
                            <select name="cor" id="cor" class="form-control">
                                <option value="">Mostrar tudo</option>
                                <option value="vermelho" <?php echo (isset($_GET['cor']) && $_GET['cor'] == 'vermelho') ? 'selected' : ''; ?>>Vermelho</option>
                                <option value="azul" <?php echo (isset($_GET['cor']) && $_GET['cor'] == 'azul') ? 'selected' : ''; ?>>Azul</option>
                                <option value="preto" <?php echo (isset($_GET['cor']) && $_GET['cor'] == 'preto') ? 'selected' : ''; ?>>Preto</option>
                                <!-- Adicionar mais cores ou popular dinamicamente se necessário -->
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Linha 3 de Filtros -->
                        <div class="col-md-4 mb-3">
                            <label for="genero" class="form-label">Género</label>
                            <select name="genero" id="genero" class="form-control">
                                <option value="">Mostrar tudo</option>
                                <option value="masculino" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'masculino') ? 'selected' : ''; ?>>Masculino</option>
                                <option value="feminino" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'feminino') ? 'selected' : ''; ?>>Feminino</option>
                                <option value="unissexo" <?php echo (isset($_GET['genero']) && $_GET['genero'] == 'unissexo') ? 'selected' : ''; ?>>Unissexo</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3 align-self-end">
                            <button type="submit" class="btn btn-primary w-100">Filtrar</button>
                        </div>
                         <div class="col-md-4 mb-3 align-self-end">
                            <a href="loja.php" class="btn btn-secondary w-100">Limpar Filtros</a>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="list-inline shop-top-menu pb-3 pt-1">
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3" href="#">Todos</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none mr-3" href="#">Masculino</a>
                            </li>
                            <li class="list-inline-item">
                                <a class="h3 text-dark text-decoration-none" href="#">Feminino</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-6 pb-4">
                        <div class="d-flex">
                            <select class="form-control">
                                <option>Destaque</option>
                                <option>A a Z</option>
                                <option>Item</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">';

// Buscar produtos do banco de dados
$produtos = my_query('SELECT p.*, t.tipo_pt, t.tipo_eng, c.categoria_pt, c.categoria_en 
                     FROM produtos p 
                     JOIN tipo t ON p.id_tipo = t.id_tipo 
                     JOIN categorias c ON p.id_categoria = c.id_categoria');

if($produtos && is_array($produtos)) {
    foreach($produtos as $produto) {
        if(isset($produto['id_produto'])) {
            $nome_produto = $_SESSION['ling'] == 'pt' ? $produto['nome_pt'] : $produto['nome_en'];
            $descricao = $_SESSION['ling'] == 'pt' ? $produto['descricao_pt'] : $produto['descricao_en'];
            
            // Buscar tamanhos do produto
            $tamanhos = my_query('SELECT t.tamanho 
                                FROM produto_tamanho pt 
                                JOIN tamanho t ON pt.id_tamanho = t.id_tamanho 
                                WHERE pt.id_produto = ' . intval($produto['id_produto']));
            
            $tamanhos_disponiveis = '';
            if($tamanhos && is_array($tamanhos)) {
                foreach($tamanhos as $tamanho) {
                    $tamanhos_disponiveis .= '<li>' . htmlspecialchars($tamanho['tamanho']) . '</li>';
                }
            }
            
            echo '<div class="col-md-4">
                    <div class="card mb-4 product-wap rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="assets/img/product_1.jpg">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                <ul class="list-unstyled">
                                    <li><a class="btn btn-success text-white" href="shop-single.php?id=' . intval($produto['id_produto']) . '"><i class="far fa-heart"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.php?id=' . intval($produto['id_produto']) . '"><i class="far fa-eye"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="shop-single.php?id=' . intval($produto['id_produto']) . '"><i class="fas fa-cart-plus"></i></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="shop-single.php?id=' . intval($produto['id_produto']) . '" class="h3 text-decoration-none">' . htmlspecialchars($nome_produto) . '</a>
                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                <li>' . $tamanhos_disponiveis . '</li>
                                <li class="pt-2">
                                    <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                </li>
                            </ul>
                            <p class="text-center mb-0">R$ ' . number_format(floatval($produto['preco']), 2, ',', '.') . '</p>
                        </div>
                    </div>
                </div>';
        }
    }
}

echo '</div>
                <div div="row">
                    <ul class="pagination pagination-lg justify-content-end">
                        <li class="page-item disabled">
                            <a class="page-link active rounded-0 mr-3 shadow-sm border-top-0 border-left-0" href="#" tabindex="-1">1</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 mr-3 shadow-sm border-top-0 border-left-0 text-dark" href="#">2</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link rounded-0 shadow-sm border-top-0 border-left-0 text-dark" href="#">3</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->';

include 'footer.inc.php';

echo '</body>';
include 'scripts.inc.php';

echo '</html>';
?> 