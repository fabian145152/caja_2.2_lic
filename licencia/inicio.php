<?php
// upload_licencia.php
$targetDir = __DIR__ . DIRECTORY_SEPARATOR; // misma carpeta
$targetFile = $targetDir . 'licencia_encriptada.txt';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] === UPLOAD_ERR_NO_FILE) {
        $message = 'No se subió ningún archivo.';
    } else {
        $f = $_FILES['fileToUpload'];
        if ($f['error'] !== UPLOAD_ERR_OK) {
            $message = 'Error al subir (código: ' . $f['error'] . ').';
        } else {
            $originalName = basename($f['name']);
            if ($originalName !== 'licencia_encriptada.txt') {
                $message = 'El archivo debe llamarse exactamente licencia_encriptada.txt';
            } else {
                if (move_uploaded_file($f['tmp_name'], $targetFile)) {
                    $message = 'Archivo subido correctamente.';
                } else {
                    $message = 'Error al mover el archivo al destino.';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Licencia</title>
    <style>
        body {
            font-family: Arial;
            max-width: 600px;
            margin: 50px auto;
            padding: 0 20px;
        }

        .box {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
        }

        .message {
            margin: 12px 0;
            padding: 10px;
            border-radius: 6px;
            background: #f5f5f5;
        }
    </style>
</head>

<body>
    <h1>Subir licencia_encriptada.txt</h1>

    <div class="box">
        <?php if ($message): ?>
            <div class="message">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data">
            <label for="fileToUpload">Selecciona licencia_encriptada.txt:</label><br><br>
            <input type="file" name="fileToUpload" id="fileToUpload" accept=".txt" required>
            <br><br>
            <button type="submit">Subir</button>
        </form>
    </div>

    <hr>
    <p>Ver el archivo actual:</p>
    <ul>
        <?php if (file_exists($targetFile)): ?>
            <li><a href="licencia_encriptada.txt" target="_blank">licencia_encriptada.txt</a></li>
        <?php else: ?>
            <li>No hay licencia_encriptada.txt en la carpeta.</li>
        <?php endif; ?>
        <br><br><br>
        <a href="desencriptar.php">DESBLOQUEAR</a>

    </ul>
</body>

</html>