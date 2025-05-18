<?php
session_start();
require_once '../config/database.php';

// Verificar se o utilizador está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Processar exclusão
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $sql = "DELETE FROM sobre_nos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: sobre.php');
    exit();
}

// Processar adição/edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = $_POST['titulo'];
    $texto_principal = $_POST['texto_principal'];
    $titulo_sec = $_POST['titulo_sec'];
    $texto_sec = $_POST['texto_sec'];
    $icon_1 = $_POST['icon_1'];
    $icon_2 = $_POST['icon_2'];
    $icon_3 = $_POST['icon_3'];
    $icon_4 = $_POST['icon_4'];
    $ling = $_POST['ling'];
    
    if (isset($_POST['id'])) {
        // Edição
        $id = (int)$_POST['id'];
        $sql = "UPDATE sobre_nos SET titulo = ?, texto_principal = ?, titulo_sec = ?, texto_sec = ?, icon_1 = ?, icon_2 = ?, icon_3 = ?, icon_4 = ?, ling = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssssi", $titulo, $texto_principal, $titulo_sec, $texto_sec, $icon_1, $icon_2, $icon_3, $icon_4, $ling, $id);
    } else {
        // Adição
        $sql = "INSERT INTO sobre_nos (titulo, texto_principal, titulo_sec, texto_sec, icon_1, icon_2, icon_3, icon_4, ling) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $titulo, $texto_principal, $titulo_sec, $texto_sec, $icon_1, $icon_2, $icon_3, $icon_4, $ling);
    }
    
    $stmt->execute();
    header('Location: sobre.php');
    exit();
}

// Buscar conteúdo
$sql = "SELECT * FROM sobre_nos ORDER BY id";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Controlar Sobre Nós - Green Shop Admin</title>
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
                        <a class="nav-link" href="menus.php">Menus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="sobre.php">Sobre Nós</a>
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
            <h1>Controlar Sobre Nós</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sobreModal">
                <i class="fas fa-plus"></i> Novo Conteúdo
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Título Secundário</th>
                        <th>Idioma</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($row['titulo_sec']); ?></td>
                        <td><?php echo htmlspecialchars($row['ling']); ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editSobre(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este conteúdo?')">
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
    <div class="modal fade" id="sobreModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sobre Nós</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="sobre_id">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="texto_principal" class="form-label">Texto Principal</label>
                            <textarea class="form-control" id="texto_principal" name="texto_principal" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="titulo_sec" class="form-label">Título Secundário</label>
                            <input type="text" class="form-control" id="titulo_sec" name="titulo_sec" required>
                        </div>
                        <div class="mb-3">
                            <label for="texto_sec" class="form-label">Texto Secundário</label>
                            <textarea class="form-control" id="texto_sec" name="texto_sec" rows="4" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="icon_1" class="form-label">Ícone 1</label>
                                <input type="text" class="form-control" id="icon_1" name="icon_1" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="icon_2" class="form-label">Ícone 2</label>
                                <input type="text" class="form-control" id="icon_2" name="icon_2" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="icon_3" class="form-label">Ícone 3</label>
                                <input type="text" class="form-control" id="icon_3" name="icon_3" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="icon_4" class="form-label">Ícone 4</label>
                                <input type="text" class="form-control" id="icon_4" name="icon_4" required>
                            </div>
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
        function editSobre(sobre) {
            document.getElementById('sobre_id').value = sobre.id;
            document.getElementById('titulo').value = sobre.titulo;
            document.getElementById('texto_principal').value = sobre.texto_principal;
            document.getElementById('titulo_sec').value = sobre.titulo_sec;
            document.getElementById('texto_sec').value = sobre.texto_sec;
            document.getElementById('icon_1').value = sobre.icon_1;
            document.getElementById('icon_2').value = sobre.icon_2;
            document.getElementById('icon_3').value = sobre.icon_3;
            document.getElementById('icon_4').value = sobre.icon_4;
            document.getElementById('ling').value = sobre.ling;
            new bootstrap.Modal(document.getElementById('sobreModal')).show();
        }
    </script>
</body>
</html> 