<?php
// send_form.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// Cargar variables de entorno desde .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Configuración de PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = $_ENV['SMTP_HOST'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['SMTP_USER'];
    $mail->Password   = $_ENV['SMTP_PASSWORD'];
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = $_ENV['SMTP_PORT'];

    // Remitente y destinatario
    $mail->setFrom($_ENV['SMTP_FROM'], 'Formulario Web');
    $mail->addAddress($_ENV['SMTP_TO'], 'Destinatario');

    // Contenido del correo
    $mail->isHTML(false);
    $mail->Subject = 'Nueva denuncia desde el formulario web';

    // Construir cuerpo
    $nombre    = !empty($_POST['demo-name']) ? $_POST['demo-name'] : 'No proporcionado';
    $localidad = $_POST['demo-locality'] ?? 'No proporcionado';
    $direccion = $_POST['demo-address'] ?? 'No proporcionado';
    $categoria = $_POST['demo-category'] ?? 'No seleccionada';
    $mensaje   = $_POST['demo-message'] ?? '';

    $body  = "Nombre: {$nombre}\n";
    $body .= "Localidad: {$localidad}\n";
    $body .= "Dirección: {$direccion}\n";
    $body .= "Categoría: {$categoria}\n\n";
    $body .= "Mensaje:\n{$mensaje}\n";

    $mail->Body = $body;

    // Adjuntar imágenes si existen
    if (isset($_FILES['demo-images']) && is_array($_FILES['demo-images']['tmp_name'])) {
        foreach ($_FILES['demo-images']['tmp_name'] as $index => $tmpName) {
            if (is_uploaded_file($tmpName) && $_FILES['demo-images']['error'][$index] === UPLOAD_ERR_OK) {
                $originalName = $_FILES['demo-images']['name'][$index];
                $mail->addAttachment($tmpName, $originalName);
            }
        }
    }

    // Enviar
    $mail->send();
    echo 'Mensaje enviado correctamente.';
} catch (Exception $e) {
    echo "No se pudo enviar el correo. Error: {$mail->ErrorInfo}";
}
