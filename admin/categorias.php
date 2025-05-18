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
    $sql = "DELETE FROM categorias WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: categorias.php');
    exit();
}

// Processar adição/edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoria_pt = $_POST['categoria_pt'];
    $categoria_en = $_POST['categoria_en'];
    
    if (isset($_POST['id'])) {
        // Edição
        $id = (int)$_POST['id'];
        $sql = "UPDATE categorias SET categoria_pt = ?, categoria_en = ? WHERE id_categoria = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $categoria_pt, $categoria_en, $id);
    } else {
        // Adição
        $sql = "INSERT INTO categorias (categoria_pt, categoria_en) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $categoria_pt, $categoria_en);
    }
    
    $stmt->execute();
    header('Location: categorias.php');
    exit();
}

// Buscar categorias
$sql = "SELECT * FROM categorias ORDER BY id_categoria";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias - Green Shop Admin</title>
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
                        <a class="nav-link active" href="categorias.php">Categorias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="produtos.php">Produtos</a>
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
            <h1>Gerenciar Categorias</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#categoriaModal">
                <i class="fas fa-plus"></i> Nova Categoria
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Categoria (PT)</th>
                        <th>Categoria (EN)</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_categoria']; ?></td>
                        <td><?php echo htmlspecialchars($row['categoria_pt']); ?></td>
                        <td><?php echo htmlspecialchars($row['categoria_en']); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editCategoria(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="?delete=<?php echo $row['id_categoria']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">
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
    <div class="modal fade" id="categoriaModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="categoria_id">
                        <div class="mb-3">
                            <label for="categoria_pt" class="form-label">Categoria (PT)</label>
                            <input type="text" class="form-control" id="categoria_pt" name="categoria_pt" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria_en" class="form-label">Categoria (EN)</label>
                            <input type="text" class="form-control" id="categoria_en" name="categoria_en" required>
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
        function editCategoria(categoria) {
            document.getElementById('categoria_id').value = categoria.id_categoria;
            document.getElementById('categoria_pt').value = categoria.categoria_pt;
            document.getElementById('categoria_en').value = categoria.categoria_en;
            new bootstrap.Modal(document.getElementById('categoriaModal')).show();
        }
    </script>
</body>
</html> 