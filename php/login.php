<?php
session_start();
require 'conectar.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Validações básicas
    if (empty($email) || empty($senha)) {
        header("Location: ../login.html?erro=Preencha todos os campos.");
        exit;
    }

    // Busca o usuário no banco de dados
    $stmt = $conn->prepare("SELECT id, senha, verificado FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        // Verifica a senha
        if (password_verify($senha, $usuario['senha'])) {
            if ($usuario['verificado'] == 1) {
                // Login bem-sucedido
                $_SESSION['usuario_id'] = $usuario['id'];
                header("Location: ../conta.html");
            } else {
                header("Location: ../login.html?erro=E-mail não verificado.");
            }
        } else {
            header("Location: ../login.html?erro=Senha incorreta.");
        }
    } else {
        header("Location: ../login.html?erro=Usuário não encontrado.");
    }

    $stmt->close();
}

$conn->close();
?>
