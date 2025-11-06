<?php
session_start();
require_once 'conexion.php'; // conexión PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] != UPLOAD_ERR_OK) {
        die("Error al subir la imagen.");
    }

    // Validar tipo de imagen (solo PNG o JPG)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $tipo = $finfo->file($_FILES['imagen']['tmp_name']);
    $extensiones = ['jpg' => 'image/jpeg', 'png' => 'image/png'];

    if (false === $ext = array_search($tipo, $extensiones, true)) {
        die("❌ Formato no permitido. Solo se aceptan imágenes PNG o JPG.");
    }

    // Comprobar que GD esté habilitado
    if (!extension_loaded('gd')) {
        die("⚠️ Error: La extensión GD no está habilitada en tu PHP.");
    }

    // Crear carpeta del usuario
    $ruta_usuario = "img/users/$username";
    if (!is_dir($ruta_usuario)) {
        mkdir($ruta_usuario, 0777, true);
    }

    // Cargar la imagen original
    $imagen = ($ext == 'jpg') ? imagecreatefromjpeg($_FILES['imagen']['tmp_name'])
                              : imagecreatefrompng($_FILES['imagen']['tmp_name']);

    // Crear versiones con tamaños exactos
    $grande = imagescale($imagen, 360, 480); // para el perfil
    $pequena = imagescale($imagen, 72, 96);  // para mostrar junto al nombre

    // Guardar archivos
    $big_path = "$ruta_usuario/{$username}Big.$ext";
    $small_path = "$ruta_usuario/{$username}Small.$ext";

    if ($ext == 'jpg') {
        imagejpeg($grande, $big_path);
        imagejpeg($pequena, $small_path);
    } else {
        imagepng($grande, $big_path);
        imagepng($pequena, $small_path);
    }

    imagedestroy($imagen);
    imagedestroy($grande);
    imagedestroy($pequena);

    // Guardar en la base de datos
    $sql = "INSERT INTO usuarios (username, password, img_big, img_small)
            VALUES (:username, :password, :img_big, :img_small)";
    $stmt = $dwes->prepare($sql);
    $stmt->execute([
        ':username' => $username,
        ':password' => $password,
        ':img_big' => $big_path,
        ':img_small' => $small_path
    ]);

    echo "✅ Usuario registrado con éxito. <a href='login.php'>Inicia sesión</a>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            color: #333;
        }
        .custom-list {
            list-style-type: none;
            padding: 0;
        }
        .custom-list li {
            margin-bottom: 10px;
        }
        .custom-list li a {
            text-decoration: none;
            color: #007BFF;
        }
        .custom-list li a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<h2>Registro de usuario</h2>
<form action="registro.php" method="POST" enctype="multipart/form-data">
    Usuario: <input type="text" name="username" required><br>
    Contraseña: <input type="password" name="password" required><br>
    Imagen de perfil: <input type="file" name="imagen" required><br>
    <input type="submit" value="Registrar">
</form>
</body>
</html>
