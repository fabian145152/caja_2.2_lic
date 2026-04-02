<?php
$archivo_encriptado = "licencia_encriptada.txt";
$archivo_desencriptado = "licencia_desencriptada.txt";

$clave = hash('sha256', 'MiClaveSegura123', true); // clave de 32 bytes
$metodo = "AES-256-CBC";

// Leer archivo encriptado
$contenido_base64 = file_get_contents($archivo_encriptado);
$contenido = base64_decode($contenido_base64);

// Extraer IV y texto cifrado
$iv_length = openssl_cipher_iv_length($metodo);
$iv = substr($contenido, 0, $iv_length);
$texto_cifrado = substr($contenido, $iv_length);

// Desencriptar
$texto_plano = openssl_decrypt($texto_cifrado, $metodo, $clave, OPENSSL_RAW_DATA, $iv);

if ($texto_plano === false) {
    echo "❌ Error: no se pudo desencriptar el archivo. Revisa la clave y el IV.";
} else {
    file_put_contents($archivo_desencriptado, $texto_plano);
    echo "✅ Archivo desencriptado correctamente en '$archivo_desencriptado'";
}
