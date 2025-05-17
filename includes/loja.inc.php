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
$ordenar = isset($_GET['ordenar']) ? $_GET['ordenar'] : '';
$view = isset($_GET['view']) && $_GET['view'] === 'list' ? 'list' : 'grid';

// Mapeamento das opções de ordenação
$opcoes_ordenacao = [
    '' => ($_SESSION['ling'] == 'pt' ? 'Ordenar por...' : 'Sort by...'),
    'nome_az' => ($_SESSION['ling'] == 'pt' ? 'Nome (A-Z)' : 'Name (A-Z)'),
    'nome_za' => ($_SESSION['ling'] == 'pt' ? 'Nome (Z-A)' : 'Name (Z-A)'),
    'preco_asc' => ($_SESSION['ling'] == 'pt' ? 'Mais barato' : 'Lowest price'),
    'preco_desc' => ($_SESSION['ling'] == 'pt' ? 'Mais caro' : 'Highest price'),
    'categoria_az' => ($_SESSION['ling'] == 'pt' ? 'Categoria (A-Z)' : 'Category (A-Z)'),
    'tipo_az' => ($_SESSION['ling'] == 'pt' ? 'Tipo (A-Z)' : 'Type (A-Z)'),
];

// Conteúdo da página
echo '    <div class="container py-5">
        <div class="row">
            <div class="col-lg-12">
                <form method="GET" class="mb-4">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <select name="categoria" class="form-control">
                                <option value="">' . ($_SESSION['ling'] == 'pt' ? 'Todas as Categorias' : 'All Categories') . '</option>';

$categorias = my_query('SELECT * FROM categorias');
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
                </form>';

// Formulário de ordenação
echo '<form method="GET" class="mb-4 d-flex align-items-center justify-content-between" id="form-ordenar">
    <div>
        <input type="hidden" name="categoria" value="' . $categoria . '">
        <input type="hidden" name="tipo" value="' . $tipo . '">
        <input type="hidden" name="tamanho" value="' . $tamanho . '">
        <input type="hidden" name="preco_min" value="' . ($preco_min !== '' ? $preco_min : '') . '">
        <input type="hidden" name="preco_max" value="' . ($preco_max !== '' ? $preco_max : '') . '">
        <label for="ordenar" class="mb-0 mr-2"><strong>' . ($_SESSION['ling'] == 'pt' ? 'Ordenar por:' : 'Sort by:') . '</strong></label>
        <select name="ordenar" id="ordenar" class="form-control d-inline-block w-auto" onchange="document.getElementById(\'form-ordenar\').submit();">';

foreach($opcoes_ordenacao as $valor => $texto) {
    $selected = ($ordenar == $valor) ? 'selected' : '';
    echo '<option value="' . $valor . '" ' . $selected . '>' . $texto . '</option>';
}

echo '</select>
    </div>';

// Botões de visualização
$baseUrl = strtok($_SERVER["REQUEST_URI"], '?');
$queryString = $_GET;
$queryString['view'] = 'grid';
$gridUrl = $baseUrl . '?' . http_build_query($queryString);
$queryString['view'] = 'list';
$listUrl = $baseUrl . '?' . http_build_query($queryString);

echo '<div class="view-toggle ml-3">
    <a href="' . htmlspecialchars($gridUrl) . '" class="mr-2' . ($view == 'grid' ? ' active' : '') . '" title="' . ($_SESSION['ling'] == 'pt' ? 'Mosaico' : 'Grid') . '">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="' . ($view == 'grid' ? '#003c3c' : '#8ca0a0') . '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
    </a>
    <a href="' . htmlspecialchars($listUrl) . '" class="' . ($view == 'list' ? ' active' : '') . '" title="' . ($_SESSION['ling'] == 'pt' ? 'Lista' : 'List') . '">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="' . ($view == 'list' ? '#003c3c' : '#8ca0a0') . '" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="3"/><rect x="3" y="10.5" width="18" height="3"/><rect x="3" y="16" width="18" height="3"/></svg>
    </a>
</div>';
echo '</form>';

echo '<div class="row" id="produtos-listagem">';

$query = 'SELECT p.*, t.tipo_pt, t.tipo_eng, c.categoria_pt, c.categoria_en 
          FROM produtos p 
          JOIN tipo t ON p.id_tipo = t.id_tipo 
          JOIN categorias c ON p.id_categoria = c.id_categoria 
          WHERE 1=1';

if($categoria) {
    $query .= ' AND p.id_categoria = ' . $categoria;
}
if($tipo) {
    $query .= ' AND p.id_tipo = ' . $tipo;
}
if($preco_min !== '') {
    $query .= ' AND p.preco >= ' . $preco_min;
}
if($preco_max !== '') {
    $query .= ' AND p.preco <= ' . $preco_max;
}
if($tamanho) {
    $query .= ' AND p.id_produto IN (SELECT id_produto FROM produto_tamanho WHERE id_tamanho = ' . $tamanho . ')';
}

switch($ordenar) {
    case 'nome_az':
        $query .= ($_SESSION['ling'] == 'pt') ? ' ORDER BY p.nome_pt ASC' : ' ORDER BY p.nome_en ASC';
        break;
    case 'nome_za':
        $query .= ($_SESSION['ling'] == 'pt') ? ' ORDER BY p.nome_pt DESC' : ' ORDER BY p.nome_en DESC';
        break;
    case 'preco_asc':
        $query .= ' ORDER BY p.preco ASC';
        break;
    case 'preco_desc':
        $query .= ' ORDER BY p.preco DESC';
        break;
    case 'categoria_az':
        $query .= ($_SESSION['ling'] == 'pt') ? ' ORDER BY c.categoria_pt ASC' : ' ORDER BY c.categoria_en ASC';
        break;
    case 'tipo_az':
        $query .= ($_SESSION['ling'] == 'pt') ? ' ORDER BY t.tipo_pt ASC' : ' ORDER BY t.tipo_eng ASC';
        break;
    default:
        $query .= ' ORDER BY p.id_produto DESC';
}

$produtos = my_query($query);

if($produtos && is_array($produtos)) {
    foreach($produtos as $produto) {
        if(isset($produto['id_produto'])) {
            $nome_produto = $_SESSION['ling'] == 'pt' ? $produto['nome_pt'] : $produto['nome_en'];
            $descricao = $_SESSION['ling'] == 'pt' ? $produto['descricao_pt'] : $produto['descricao_en'];

            $tamanhos = my_query('SELECT t.tamanho FROM produto_tamanho pt JOIN tamanho t ON pt.id_tamanho = t.id_tamanho WHERE pt.id_produto = ' . intval($produto['id_produto']));

            $tamanhos_disponiveis = '';
            if($tamanhos && is_array($tamanhos)) {
                foreach($tamanhos as $tamanho) {
                    $tamanhos_disponiveis .= '<li>' . htmlspecialchars($tamanho['tamanho']) . '</li>';
                }
            }

            if($view == 'list') {
                // Visualização em lista
                echo '<div class="col-12 mb-3">
                        <div class="card flex-row align-items-center p-2">
                            <img class="img-fluid" src="assets/img/product_1.jpg" style="width:100px; height:100px; object-fit:cover;">
                            <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center w-100">
                                <div>
                                    <a href="shop-single.php?id=' . intval($produto['id_produto']) . '" class="h5 text-decoration-none">' . htmlspecialchars($nome_produto) . '</a>
                                    <p class="mb-1">' . htmlspecialchars($descricao) . '</p>
                                    <ul class="list-inline mb-1">' . $tamanhos_disponiveis . '</ul>
                                </div>
                                <div class="text-right">
                                    <p class="mb-1 font-weight-bold" style="font-size:1.2em; color:#4CAF50;">€' . number_format(floatval($produto['preco']), 2, ',', '.') . '</p>
                                    <a class="btn btn-success text-white" href="shop-single.php?id=' . intval($produto['id_produto']) . '"><i class="fas fa-cart-plus"></i> ' . ($_SESSION['ling'] == 'pt' ? 'Comprar' : 'Buy') . '</a>
                                </div>
                            </div>
                        </div>
                    </div>';
            } else {
                // Visualização em mosaico (grid)
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
    }
} else {
    echo '<div class="col-12 text-center">
            <p>' . ($_SESSION['ling'] == 'pt' ? 'Nenhum produto encontrado.' : 'No products found.') . '</p>
          </div>';
}

echo '</div>
            </div>
        </div>
    </div>';

// CSS extra para visualização
?>
<style>
.view-toggle a svg {
    vertical-align: middle;
    transition: filter 0.2s;
}
.view-toggle a.active svg {
    filter: drop-shadow(0 0 2px #003c3c);
}
.view-toggle a {
    opacity: 0.7;
    transition: opacity 0.2s;
}
.view-toggle a.active {
    opacity: 1;
}
.card.flex-row {
    flex-direction: row !important;
}
</style>
<?php

include 'footer.inc.php';
echo '</body>';
include 'scripts.inc.php';
echo '</html>';
?>
