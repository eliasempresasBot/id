<?php
session_start();
require 'conectar.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../login.html");
    exit;
}

$id = $_SESSION['usuario_id'];

// Busca os dados do usuário
$stmt = $conn->prepare("SELECT nome, sobrenome, email, telefone FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Erro: Usuário não encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Conta</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <h1>Minha Conta</h1>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['nome'] . ' ' . $usuario['sobrenome']); ?></p>
        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($usuario['email']); ?></p>
        <p><strong>Telefone:</strong> <?php echo htmlspecialchars($usuario['telefone'] ?? 'Não informado'); ?></p>
        <form action="deletar_conta.php" method="POST">
            <button type="submit">Deletar Conta</button>
        </form>
    </div>
</body>
</html>
