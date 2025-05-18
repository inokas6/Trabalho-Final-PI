<?php
require_once 'config/database.php';

// Dados do utilizador admin
$username = 'admin';
$password = 'admin';
$ling = 'pt';

// Criptografar a senha
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Verificar se o utilizador já existe
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    // Inserir o utilizador admin
    $sql = "INSERT INTO users (username, password, ling) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $hashed_password, $ling);
    
    if ($stmt->execute()) {
        echo "utilizador admin criado com sucesso!";
    } else {
        echo "Erro ao criar utilizador admin: " . $conn->error;
    }
} else {
    echo "O utilizador admin já existe!";
}

$conn->close();
?> 