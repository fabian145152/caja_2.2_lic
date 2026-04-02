<?php
$archivo_encriptado = "licencia_encriptada.txt";
?>
<a href="../cobros/cobro_moviles"></a>
<?php

$carpeta_destino = "../cobros/cobro_moviles"; // Carpeta donde se guardará el archivo
$archivo_desencriptado = $carpeta_destino . "/licencia_desbloqueada.txt";

$clave = hash('sha256', 'MiClaveSegura123', true);
$metodo = "AES-256-CBC";

// Crear la carpeta si no existe
if (!is_dir($carpeta_destino)) {
    mkdir($carpeta_destino, 0777, true);
}

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
    // Guardar archivo en la carpeta 'mes'
    file_put_contents($archivo_desencriptado, $texto_plano);

    // Guardar en variable global
    $GLOBALS['mes_siguiente'] = $texto_plano;

    echo "✅ Archivo desencriptado correctamente en '$archivo_desencriptado'<br>";
    echo "Variable global 'mes_siguiente' lista para usar.";
}

// Para comprobar:
echo "<pre>";
print_r($GLOBALS['mes_siguiente']);
echo "</pre>";

echo "<script>
    alert('Proceso finalizado. La ventana se cerrará.');
    window.close();
</script>";
