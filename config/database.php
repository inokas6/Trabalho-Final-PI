<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'green_shop';
$username = 'root';
$password = '';

// Criar conexão
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Configurar charset
$conn->set_charset("utf8mb4");
?> 