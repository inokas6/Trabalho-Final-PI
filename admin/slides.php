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
    $sql = "DELETE FROM slides WHERE id_slide = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header('Location: slides.php');
    exit();
}

// Processar adição/edição
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_inicial = (int)$_POST['id_inicial'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $ordem = (int)$_POST['ordem'];
    $imagem = $_POST['imagem'];
    
    if (isset($_POST['id'])) {
        // Edição
        $id = (int)$_POST['id'];
        $sql = "UPDATE slides SET id_inicial = ?, titulo = ?, descricao = ?, ordem = ?, imagem = ? WHERE id_slide = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issisi", $id_inicial, $titulo, $descricao, $ordem, $imagem, $id);
    } else {
        // Adição
        $sql = "INSERT INTO slides (id_inicial, titulo, descricao, ordem, imagem) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("issis", $id_inicial, $titulo, $descricao, $ordem, $imagem);
    }
    
    $stmt->execute();
    header('Location: slides.php');
    exit();
}

// Buscar slides com informações relacionadas
$sql = "SELECT s.*, h.titulo as home_titulo 
        FROM slides s 
        LEFT JOIN home h ON s.id_inicial = h.id_inicial 
        ORDER BY s.ordem";
$result = $conn->query($sql);

// Buscar páginas iniciais para o formulário
$home_pages = $conn->query("SELECT * FROM home ORDER BY id_inicial");
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Slides - Green Shop Admin</title>
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
                        <a class="nav-link active" href="slides.php">Slides</a>
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
            <h1>Gerenciar Slides</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#slideModal">
                <i class="fas fa-plus"></i> Novo Slide
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Página Inicial</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Ordem</th>
                        <th>Imagem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_slide']; ?></td>
                        <td><?php echo htmlspecialchars($row['home_titulo']); ?></td>
                        <td><?php echo htmlspecialchars($row['titulo']); ?></td>
                        <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                        <td><?php echo $row['ordem']; ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($row['imagem']); ?>" alt="Slide" style="max-width: 100px;">
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editSlide(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <a href="?delete=<?php echo $row['id_slide']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este slide?')">
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
    <div class="modal fade" id="slideModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Slide</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="slide_id">
                        <div class="mb-3">
                            <label for="id_inicial" class="form-label">Página Inicial</label>
                            <select class="form-select" id="id_inicial" name="id_inicial" required>
                                <option value="">Selecione...</option>
                                <?php while ($home = $home_pages->fetch_assoc()): ?>
                                <option value="<?php echo $home['id_inicial']; ?>"><?php echo htmlspecialchars($home['titulo']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" id="descricao" name="descricao" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="ordem" class="form-label">Ordem</label>
                            <input type="number" class="form-control" id="ordem" name="ordem" required>
                        </div>
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Caminho da Imagem</label>
                            <input type="text" class="form-control" id="imagem" name="imagem" required>
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
        function editSlide(slide) {
            document.getElementById('slide_id').value = slide.id_slide;
            document.getElementById('id_inicial').value = slide.id_inicial;
            document.getElementById('titulo').value = slide.titulo;
            document.getElementById('descricao').value = slide.descricao;
            document.getElementById('ordem').value = slide.ordem;
            document.getElementById('imagem').value = slide.imagem;
            new bootstrap.Modal(document.getElementById('slideModal')).show();
        }
    </script>
</body>
</html> 