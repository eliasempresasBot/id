<?php
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer();

try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'eliasempresasBOT@gmail.com'; // Seu e-mail
    $mail->Password = 'epye lfua hdjc znlq'; // Sua senha
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('eliasempresasBOT@gmail.com', 'Elias Empresas');
    $mail->addAddress('eliasempresas0@gmail.com, 'Destinatário');

    $mail->isHTML(true);
    $mail->Subject = 'Teste PHPMailer';
    $mail->Body = 'Este é um e-mail de teste enviado pelo <b>PHPMailer</b>!';
    $mail->AltBody = 'Este é um e-mail de teste enviado pelo PHPMailer!';

    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
?>
