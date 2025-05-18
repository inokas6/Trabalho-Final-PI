<?php
session_start();
require_once '../config/database.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Processar exclusão
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM produtos WHERE id_produto = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: produtos.php');
    exit();
}

// Processar adição/edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_pt = $_POST['nome_pt'];
    $nome_en = $_POST['nome_en'];
    $descricao_pt = $_POST['descricao_pt'];
    $descricao_en = $_POST['descricao_en'];
    $id_tipo = (int)$_POST['id_tipo'];
    $id_categoria = (int)$_POST['id_categoria'];
    $preco = (float)$_POST['preco'];
    
    if (isset($_POST['id'])) {
        // Edição
        $id = (int)$_POST['id'];
        $sql = "UPDATE produtos SET nome_pt = ?, nome_en = ?, descricao_pt = ?, descricao_en = ?, id_tipo = ?, id_categoria = ?, preco = ? WHERE id_produto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiidi", $nome_pt, $nome_en, $descricao_pt, $descricao_en, $id_tipo, $id_categoria, $preco, $id);
    } else {
        // Adição
        $sql = "INSERT INTO produtos (nome_pt, nome_en, descricao_pt, descricao_en, id_tipo, id_categoria, preco) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssiid", $nome_pt, $nome_en, $descricao_pt, $descricao_en, $id_tipo, $id_categoria, $preco);
    }
    
    $stmt->execute();
    header('Location: produtos.php');
    exit();
}

// Buscar produtos com informações relacionadas
$sql = "SELECT p.*, t.tipo_pt, c.categoria_pt 
        FROM produtos p 
        LEFT JOIN tipo t ON p.id_tipo = t.id_tipo 
        LEFT JOIN categorias c ON p.id_categoria = c.id_categoria 
        ORDER BY p.id_produto";
$result = $conn->query($sql);

// Buscar tipos e categorias para o formulário
$tipos = $conn->query("SELECT * FROM tipo ORDER BY tipo_pt");
$categorias = $conn->query("SELECT * FROM categorias ORDER BY categoria_pt");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos - Green Shop Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Green Shop Admin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="categorias.php">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="produtos.php">Produtos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tamanhos.php">Tamanhos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tipos.php">Tipos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="slides.php">Slides</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menus.php">Menus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sobre.php">Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contato.php">Contato</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Sair</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gerenciar Produtos</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#produtoModal">
                <i class="fas fa-plus"></i> Novo Produto
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome (PT)</th>
                        <th>Nome (EN)</th>
                        <th>Descrição (PT)</th>
                        <th>Descrição (EN)</th>
                        <th>Tipo</th>
                        <th>Categoria</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_produto']; ?></td>
                        <td><?php echo htmlspecialchars($row['nome_pt']); ?></td>
                        <td><?php echo htmlspecialchars($row['nome_en']); ?></td>
                        <td><?php echo htmlspecialchars($row['descricao_pt']); ?></td>
                        <td><?php echo htmlspecialchars($row['descricao_en']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_pt']); ?></td>
                        <td><?php echo htmlspecialchars($row['categoria_pt']); ?></td>
                        <td>€<?php echo number_format($row['preco'], 2); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editProduto(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="?delete=<?php echo $row['id_produto']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este produto?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="produtoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="produto_id">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome_pt" class="form-label">Nome (PT)</label>
                                <input type="text" class="form-control" id="nome_pt" name="nome_pt" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="nome_en" class="form-label">Nome (EN)</label>
                                <input type="text" class="form-control" id="nome_en" name="nome_en" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="descricao_pt" class="form-label">Descrição (PT)</label>
                                <textarea class="form-control" id="descricao_pt" name="descricao_pt" required></textarea>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="descricao_en" class="form-label">Descrição (EN)</label>
                                <textarea class="form-control" id="descricao_en" name="descricao_en" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="id_tipo" class="form-label">Tipo</label>
                                <select class="form-select" id="id_tipo" name="id_tipo" required>
                                    <option value="">Selecione...</option>
                                    <?php while ($tipo = $tipos->fetch_assoc()): ?>
                                    <option value="<?php echo $tipo['id_tipo']; ?>"><?php echo htmlspecialchars($tipo['tipo_pt']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="id_categoria" class="form-label">Categoria</label>
                                <select class="form-select" id="id_categoria" name="id_categoria" required>
                                    <option value="">Selecione...</option>
                                    <?php while ($categoria = $categorias->fetch_assoc()): ?>
                                    <option value="<?php echo $categoria['id_categoria']; ?>"><?php echo htmlspecialchars($categoria['categoria_pt']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="preco" class="form-label">Preço</label>
                                <input type="number" step="0.01" class="form-control" id="preco" name="preco" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editProduto(produto) {
            document.getElementById('produto_id').value = produto.id_produto;
            document.getElementById('nome_pt').value = produto.nome_pt;
            document.getElementById('nome_en').value = produto.nome_en;
            document.getElementById('descricao_pt').value = produto.descricao_pt;
            document.getElementById('descricao_en').value = produto.descricao_en;
            document.getElementById('id_tipo').value = produto.id_tipo;
            document.getElementById('id_categoria').value = produto.id_categoria;
            document.getElementById('preco').value = produto.preco;
            new bootstrap.Modal(document.getElementById('produtoModal')).show();
        }
    </script>
</body>
</html> 