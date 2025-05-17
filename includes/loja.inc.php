<?php

include 'header.inc.php';
echo '<body>';
include 'nav.inc.php';

// Obter parâmetros de filtro
$categoria = isset($_GET['categoria']) ? intval($_GET['categoria']) : '';
$tipo = isset($_GET['tipo']) ? intval($_GET['tipo']) : '';
$tamanho = isset($_GET['tamanho']) ? intval($_GET['tamanho']) : '';
$preco_min = isset($_GET['preco_min']) && $_GET['preco_min'] !== '' ? floatval($_GET['preco_min']) : '';
$preco_max = isset($_GET['preco_max']) && $_GET['preco_max'] !== '' ? floatval($_GET['preco_max']) : '';

// Conteúdo da página
echo '
    <!-- Start Content -->
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <h1 class="h2 pb-4">' . ($_SESSION['ling'] == 'pt' ? 'Categorias' : 'Categories') . '</h1>
                <ul class="list-unstyled templatemo-accordion">';

//Categorias da base de dados
$categorias = my_query('SELECT * FROM categorias');

if($categorias && is_array($categorias)) {
    foreach($categorias as $cat) {
        if(isset($cat['id_categoria'])) {
            $nome_categoria = $_SESSION['ling'] == 'pt' ? $cat['categoria_pt'] : $cat['categoria_en'];
            $active = ($categoria == $cat['id_categoria']) ? 'active' : '';
            echo '<li class="pb-3">
                    <a class="collapsed d-flex justify-content-between h3 text-decoration-none ' . $active . '" href="?categoria=' . $cat['id_categoria'] . '">
                        ' . htmlspecialchars($nome_categoria) . '
                        <i class="fa fa-fw fa-chevron-circle-down mt-1"></i>
                    </a>
                    <ul class="collapse show list-unstyled pl-3">';
            
            // tipos de produtos para esta categoria
            $tipos = my_query('SELECT DISTINCT t.* FROM tipo t 
                             INNER JOIN produtos p ON t.id_tipo = p.id_tipo 
                             WHERE p.id_categoria = ' . $cat['id_categoria']);
            
            if($tipos && is_array($tipos)) {
                foreach($tipos as $t) {
                    $nome_tipo = $_SESSION['ling'] == 'pt' ? $t['tipo_pt'] : $t['tipo_eng'];
                    $active = ($tipo == $t['id_tipo']) ? 'active' : '';
                    echo '<li><a class="text-decoration-none ' . $active . '" href="?categoria=' . $cat['id_categoria'] . '&tipo=' . $t['id_tipo'] . '">' . htmlspecialchars($nome_tipo) . '</a></li>';
                }
            }
            
            echo '</ul></li>';
        }
    }
}

echo '</ul>
            </div>

            <div class="col-lg-9">
                <!-- Filtros -->
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <select name="categoria" class="form-control">
                                <option value="">' . ($_SESSION['ling'] == 'pt' ? 'Todas as Categorias' : 'All Categories') . '</option>';
                                
// Categorias para o select
if($categorias && is_array($categorias)) {
    foreach($categorias as $cat) {
        $selected = ($categoria == $cat['id_categoria']) ? 'selected' : '';
        $nome_categoria = $_SESSION['ling'] == 'pt' ? $cat['categoria_pt'] : $cat['categoria_en'];
        echo '<option value="' . $cat['id_categoria'] . '" ' . $selected . '>' . htmlspecialchars($nome_categoria) . '</option>';
    }
}

echo '</select>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select name="tipo" class="form-control">
                                <option value="">' . ($_SESSION['ling'] == 'pt' ? 'Todos os Tipos' : 'All Types') . '</option>';
                                
// Tipos para o select
$tipos = my_query('SELECT * FROM tipo');
if($tipos && is_array($tipos)) {
    foreach($tipos as $t) {
        $selected = ($tipo == $t['id_tipo']) ? 'selected' : '';
        $nome_tipo = $_SESSION['ling'] == 'pt' ? $t['tipo_pt'] : $t['tipo_eng'];
        echo '<option value="' . $t['id_tipo'] . '" ' . $selected . '>' . htmlspecialchars($nome_tipo) . '</option>';
    }
}

echo '</select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select name="tamanho" class="form-control">
                                <option value="">' . ($_SESSION['ling'] == 'pt' ? 'Tamanho' : 'Size') . '</option>';
                                
// Tamanhos disponíveis
$tamanhos = my_query('SELECT * FROM tamanho');
if($tamanhos && is_array($tamanhos)) {
    foreach($tamanhos as $tam) {
        $selected = ($tamanho == $tam['id_tamanho']) ? 'selected' : '';
        echo '<option value="' . $tam['id_tamanho'] . '" ' . $selected . '>' . htmlspecialchars($tam['tamanho']) . '</option>';
    }
}

echo '</select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="number" name="preco_min" class="form-control" placeholder="' . ($_SESSION['ling'] == 'pt' ? 'Mín' : 'Min') . '" value="' . ($preco_min !== '' ? $preco_min : '') . '">
                        </div>
                        <div class="col-md-2 mb-2">
                            <input type="number" name="preco_max" class="form-control" placeholder="' . ($_SESSION['ling'] == 'pt' ? 'Máx' : 'Max') . '" value="' . ($preco_max !== '' ? $preco_max : '') . '">
                        </div>
                        <div class="col-md-12 mb-2">
                            <button type="submit" class="btn btn-primary w-100">' . ($_SESSION['ling'] == 'pt' ? 'Filtrar' : 'Filter') . '</button>
                        </div>
                    </div>
                </form>

                <div class="row">';

// Construir a query base para produtos
$query = 'SELECT p.*, t.tipo_pt, t.tipo_eng, c.categoria_pt, c.categoria_en 
          FROM produtos p 
          JOIN tipo t ON p.id_tipo = t.id_tipo 
          JOIN categorias c ON p.id_categoria = c.id_categoria 
          WHERE 1=1';

// Adicionar filtros à query
if($categoria) {
    $query .= ' AND p.id_categoria = ' . $categoria;
}
if($tipo) {
    $query .= ' AND p.id_tipo = ' . $tipo;
}
if($preco_min) {
    $query .= ' AND p.preco >= ' . $preco_min;
}
if($preco_max) {
    $query .= ' AND p.preco <= ' . $preco_max;
}
if($tamanho) {
    $query .= ' AND p.id_produto IN (SELECT id_produto FROM produto_tamanho WHERE id_tamanho = ' . $tamanho . ')';
}

// Executar a query
$produtos = my_query($query);

if($produtos && is_array($produtos)) {
    foreach($produtos as $produto) {
        if(isset($produto['id_produto'])) {
            $nome_produto = $_SESSION['ling'] == 'pt' ? $produto['nome_pt'] : $produto['nome_en'];
            $descricao = $_SESSION['ling'] == 'pt' ? $produto['descricao_pt'] : $produto['descricao_en'];
            
            //tamanhos
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
                            </ul>
                            <p class="text-center mb-0">€' . number_format(floatval($produto['preco']), 2, ',', '.') . '</p>
                        </div>
                    </div>
                </div>';
        }
    }
} else {
    echo '<div class="col-12 text-center">
            <p>' . ($_SESSION['ling'] == 'pt' ? 'Nenhum produto encontrado.' : 'No products found.') . '</p>
          </div>';
}

echo '</div>
            </div>
        </div>
    </div>
    <!-- End Content -->';

include 'footer.inc.php';

echo '</body>';
include 'scripts.inc.php';

echo '</html>';
?> 