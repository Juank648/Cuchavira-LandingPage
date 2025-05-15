<?php
// send_form.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

// Configuración de PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';           // Servidor SMTP
    $mail->SMTPAuth   = true;                       // Habilitar autenticación SMTP
    $mail->Username   = 'portalcuchavira@gmail.com';       // Tu correo SMTP
    $mail->Password   = '';          // Tu clave de aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Remitente y destinatario
    $mail->setFrom('portalcuchavira@gmail.com', 'Formulario Web');
    $mail->addAddress('jkam86425@gmail.com', 'Destinatario');

    // Contenido del correo
    $mail->isHTML(false);
    $mail->Subject = 'Nueva denuncia desde el formulario web';

    // Construir cuerpo
    $nombre    = !empty($_POST['demo-name']) ? $_POST['demo-name'] : 'No proporcionado';
    $localidad = $_POST['demo-locality'] ?? 'No proporcionado';
    $direccion = $_POST['demo-address'] ?? 'No proporcionado';
    $categoria = $_POST['demo-category'] ?? 'No seleccionada';
    $mensaje   = $_POST['demo-message'] ?? '';
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
