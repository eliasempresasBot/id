<?php
session_start();

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'usuario', 'senha', 'nome_do_banco');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Verifica se os dados foram enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $email = $_SESSION['email']; // Obtém o e-mail da sessão

    // Verifica o código de verificação no banco de dados
    $stmt = $conn->prepare("SELECT codigo_verificacao, verificado FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['verificado'] == 1) {
            header("Location: verificar.html?erro=E-mail já verificado.");
            exit;
        }

        if ($codigo == $row['codigo_verificacao']) {
            // Atualiza o status para "verificado"
            $stmt = $conn->prepare("UPDATE usuarios SET verificado = 1 WHERE email = ?");
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                echo "E-mail verificado com sucesso! Você pode agora fazer login.";
                session_destroy(); // Remove os dados da sessão
            } else {
                header("Location: verificar.html?erro=Erro ao atualizar o status.");
            }
        } else {
            header("Location: verificar.html?erro=Código de verificação inválido.");
        }
    } else {
        header("Location: verificar.html?erro=Usuário não encontrado.");
    }
    $stmt->close();
}

$conn->close();
?>
