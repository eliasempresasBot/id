<?php
$host = 'localhost'; // Host do banco de dados
$usuario = 'root'; // Usuário do banco de dados
$senha = ''; // Senha do banco de dados
$banco = 'site_usuarios'; // Nome do banco de dados

$conn = new mysqli($host, $usuario, $senha, $banco);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
