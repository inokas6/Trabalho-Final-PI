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
    $sql = "DELETE FROM menus WHERE id_menu = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: menus.php');
    exit();
}

// Processar adição/edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $menu = $_POST['menu'];
    $pag = $_POST['pag'];
    $ordem = (int)$_POST['ordem'];
    $ling = $_POST['ling'];
    
    if (isset($_POST['id'])) {
        // Edição
        $id = (int)$_POST['id'];
        $sql = "UPDATE menus SET menu = ?, pag = ?, ordem = ?, ling = ? WHERE id_menu = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssisi", $menu, $pag, $ordem, $ling, $id);
    } else {
        // Adição
        $sql = "INSERT INTO menus (menu, pag, ordem, ling) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $menu, $pag, $ordem, $ling);
    }
    
    $stmt->execute();
    header('Location: menus.php');
    exit();
}

// Buscar menus
$sql = "SELECT * FROM menus ORDER BY ordem, ling";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Menus - Green Shop Admin</title>
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
                        <a class="nav-link active" href="menus.php">Menus</a>
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
            <h1>Gerenciar Menus</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#menuModal">
                <i class="fas fa-plus"></i> Novo Menu
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Menu</th>
                        <th>Página</th>
                        <th>Ordem</th>
                        <th>Idioma</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_menu']; ?></td>
                        <td><?php echo htmlspecialchars($row['menu']); ?></td>
                        <td><?php echo htmlspecialchars($row['pag']); ?></td>
                        <td><?php echo $row['ordem']; ?></td>
                        <td><?php echo htmlspecialchars($row['ling']); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editMenu(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="?delete=<?php echo $row['id_menu']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este menu?')">
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
    <div class="modal fade" id="menuModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="menu_id">
                        <div class="mb-3">
                            <label for="menu" class="form-label">Menu</label>
                            <input type="text" class="form-control" id="menu" name="menu" required>
                        </div>
                        <div class="mb-3">
                            <label for="pag" class="form-label">Página</label>
                            <input type="text" class="form-control" id="pag" name="pag" required>
                        </div>
                        <div class="mb-3">
                            <label for="ordem" class="form-label">Ordem</label>
                            <input type="number" class="form-control" id="ordem" name="ordem" required>
                        </div>
                        <div class="mb-3">
                            <label for="ling" class="form-label">Idioma</label>
                            <select class="form-select" id="ling" name="ling" required>
                                <option value="pt">Português</option>
                                <option value="en">English</option>
                            </select>
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
        function editMenu(menu) {
            document.getElementById('menu_id').value = menu.id_menu;
            document.getElementById('menu').value = menu.menu;
            document.getElementById('pag').value = menu.pag;
            document.getElementById('ordem').value = menu.ordem;
            document.getElementById('ling').value = menu.ling;
            new bootstrap.Modal(document.getElementById('menuModal')).show();
        }
    </script>
</body>
</html> 