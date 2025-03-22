<?php
session_start();
require 'send_email.php'; // Arquivo com a função PHPMailer

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'usuario', 'senha', 'nome_do_banco');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmaSenha = $_POST['confirmaSenha'];

    // Validações básicas
    if ($senha !== $confirmaSenha) {
        header("Location: registrar.html?erro=As senhas não correspondem.");
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: registrar.html?erro=E-mail inválido.");
        exit;
    }

    // Verifica se o e-mail já existe no banco de dados
    $stmt = $conn->prepare("SELECT email FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header("Location: registrar.html?erro=E-mail já registrado.");
        exit;
    }
    $stmt->close();

    // Gera um código de verificação
    $codigoVerificacao = rand(100000, 999999);

    // Salva os dados no banco de dados
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO usuarios (email, senha, codigo_verificacao, verificado) VALUES (?, ?, ?, 0)");
    $stmt->bind_param("ssi", $email, $senhaHash, $codigoVerificacao);
    if ($stmt->execute()) {
        // Envia o e-mail de verificação
        if (enviarEmailVerificacao($email, $codigoVerificacao)) {
            $_SESSION['email'] = $email; // Salva o e-mail na sessão
            header("Location: verificar.html");
        } else {
            header("Location: registrar.html?erro=Erro ao enviar o e-mail.");
        }
    } else {
        header("Location: registrar.html?erro=Erro ao registrar usuário.");
    }
    $stmt->close();
}

$conn->close();
?>
