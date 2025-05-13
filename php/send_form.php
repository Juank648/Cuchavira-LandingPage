<?php
$to = "tucorreo@dominio.com";
$subject = "Nueva denuncia desde el formulario web";

$nombre = $_POST['demo-name'];
$localidad = $_POST['demo-locality'];
$direccion = $_POST['demo-address'];
$categoria = $_POST['demo-category'];
$mensaje = $_POST['demo-message'];

$body = "Nombre: $nombre\n";
$body .= "Localidad: $localidad\n";
$body .= "Dirección: $direccion\n";
$body .= "Categoría: $categoria\n\n";
$body .= "Mensaje:\n$mensaje\n";

// Manejo del archivo adjunto (imagen)
if (isset($_FILES['demo-images'])) {
    $total = count($_FILES['demo-images']['name']);
    
    for ($i = 0; $i < $total; $i++) {
        if ($_FILES['demo-images']['error'][$i] === UPLOAD_ERR_OK) {
            $file_tmp = $_FILES['demo-images']['tmp_name'][$i];
            $file_name = $_FILES['demo-images']['name'][$i];
            $file_type = $_FILES['demo-images']['type'][$i];
            $file_content = chunk_split(base64_encode(file_get_contents($file_tmp)));

            $boundary = md5(time());
            
            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";
            $headers .= "From: formulario@tusitio.com\r\n";

            $mensaje_email = "--$boundary\r\n";
            $mensaje_email .= "Content-Type: text/plain; charset=UTF-8\r\n\r\n";
            $mensaje_email .= $body . "\r\n";

            // Agregar cada imagen como archivo adjunto
            $mensaje_email .= "--$boundary\r\n";
            $mensaje_email .= "Content-Type: $file_type; name=\"$file_name\"\r\n";
            $mensaje_email .= "Content-Disposition: attachment; filename=\"$file_name\"\r\n";
            $mensaje_email .= "Content-Transfer-Encoding: base64\r\n\r\n";
            $mensaje_email .= $file_content . "\r\n";
        }
    }

    $mensaje_email .= "--$boundary--";
    mail($to, $subject, $mensaje_email, $headers);
} else {
    // Email sin imagen
    $headers = "From: formulario@tusitio.com\r\n";
    mail($to, $subject, $body, $headers);
}

echo "Mensaje enviado correctamente.";
?>
