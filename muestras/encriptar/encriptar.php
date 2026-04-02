<?php
// Obtener dato del formulario
if (isset($_POST['numero'])) {
    $texto = $_POST['numero'];
} else {
    echo "❌ No se recibió ningún dato para encriptar.";
    exit;
}

$archivo_encriptado = __DIR__ . "/licencia_encriptada.txt"; // ruta segura

$clave = hash('sha256', 'MiClaveSegura123', true);
$metodo = "AES-256-CBC";

// Generar IV aleatorio
$iv_length = openssl_cipher_iv_length($metodo);
$iv = openssl_random_pseudo_bytes($iv_length);

// Encriptar
$texto_cifrado = openssl_encrypt($texto, $metodo, $clave, OPENSSL_RAW_DATA, $iv);

// Concatenar IV + texto cifrado y codificar en base64
$archivo_final = base64_encode($iv . $texto_cifrado);

// Guardar archivo encriptado
file_put_contents($archivo_encriptado, $archivo_final);

// **Forzar descarga**
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="licencia_encriptada.txt"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($archivo_encriptado));

// Limpiar buffer
ob_clean();
flush();

// Enviar el archivo
readfile($archivo_encriptado);
exit;
