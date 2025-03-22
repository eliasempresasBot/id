<?php
// Inclua os arquivos principais do PHPMailer
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function enviarEmailVerificacao($email, $codigo) {
    $mail = new PHPMailer(true);

    try {
        // Configurações do servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'eliasempresasBOT@gmail.com'; // Seu e-mail
        $mail->Password = 'elias1@#$2Telefone'; // Sua senha
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom('eliasempresasBOT@gmail.com', 'Elias Empresas');
        $mail->addAddress($email);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Código de Verificação - ID EE';
        $mail->Body = "<p>Seu código de verificação é: <strong>$codigo</strong></p>";
        $mail->AltBody = "Seu código de verificação é: $codigo

Olá aqui é as Elias Empresas";

        $mail->send();
        return true;
    } catch (Exception $e) {
        echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
        return false;
    }
}
?>
