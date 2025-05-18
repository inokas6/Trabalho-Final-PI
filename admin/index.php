<?php
session_start();
require_once '../config/database.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo - Green Shop</title>
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
                        <a class="nav-link" href="sobre.php">Sobre Nós</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contato.php">Contato</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="usuarios.php">Usuários</a>
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
        <h1>Bem-vindo ao Painel Administrativo</h1>
        <p class="lead">Selecione uma opção no menu acima para gerenciar o conteúdo do site.</p>

        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Categorias</h5>
                        <p class="card-text">Gerencie as categorias de produtos.</p>
                        <a href="categorias.php" class="btn btn-primary">Gerenciar Categorias</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Produtos</h5>
                        <p class="card-text">Gerencie os produtos da loja.</p>
                        <a href="produtos.php" class="btn btn-primary">Gerenciar Produtos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tamanhos</h5>
                        <p class="card-text">Gerencie os tamanhos disponíveis.</p>
                        <a href="tamanhos.php" class="btn btn-primary">Gerenciar Tamanhos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Tipos</h5>
                        <p class="card-text">Gerencie os tipos de produtos.</p>
                        <a href="tipos.php" class="btn btn-primary">Gerenciar Tipos</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Slides</h5>
                        <p class="card-text">Gerencie os slides da página inicial.</p>
                        <a href="slides.php" class="btn btn-primary">Gerenciar Slides</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Menus</h5>
                        <p class="card-text">Gerencie os itens do menu.</p>
                        <a href="menus.php" class="btn btn-primary">Gerenciar Menus</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Sobre Nós</h5>
                        <p class="card-text">Gerencie o conteúdo da página Sobre Nós.</p>
                        <a href="sobre.php" class="btn btn-primary">Gerenciar Sobre Nós</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Contato</h5>
                        <p class="card-text">Gerencie o conteúdo da página de contato.</p>
                        <a href="contato.php" class="btn btn-primary">Gerenciar Contato</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Usuários</h5>
                        <p class="card-text">Gerencie os usuários do sistema.</p>
                        <a href="usuarios.php" class="btn btn-primary">Gerenciar Usuários</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
