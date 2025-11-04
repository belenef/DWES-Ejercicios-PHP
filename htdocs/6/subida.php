<?php
// Iniciar la sesión
session_start();

// Cerrar sesión cuando se presiona el botón de logout
    // Logout
if (isset($_GET['logout'])) {
    session_destroy(); // Destruir la sesión
    header("Location: login.php"); // Redirigir al login
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Archivos</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 20px; 
            background: #f4f4f4; 
        }
        input[type="text"], input[type="password"] {
            width: 200px; 
            border-radius: 6px;
            margin-bottom: 4px; 
        }
        .mensaje { color: green; }
        .error { color: red; }

        header {
            margin-bottom: 10px;
        }

       
        .title { margin: 0; font-size: 1.5em; }

        .logout {
            margin-bottom: 30px;
            padding: 4px 8px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            
            
        }
        .logout:hover { background-color: #d32f2f; }

        .login-btn {
            padding: 8px 16px;
            
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        
    </style>
</head>
<body>

<header>
        <?php if (isset($_SESSION['usuario'])): ?>
            <a href="?logout" class="logout">Logout</a><br><br>
                <span>Bienvenid@, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
                <hr>
            <?php endif; ?>
    <h1 class="title">Subir Archivos</h1>
    
</header>


<form action="subida.php" method="post" enctype="multipart/form-data">
    <label for="archivo">Selecciona el archivo a subir:</label>
    <input type="file" name="archivo" id="archivo">
    <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
    <input type="submit" value="Enviar">
</form>

<?php
// Comprobar si hay algún archivo cargado
if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] == UPLOAD_ERR_OK) {
    echo '<br>';
    echo '<i><b> Archivo cargado: </b></i>' . $_FILES['archivo']['name'];
}

// Lógica para la validación del archivo subido
switch ($_FILES['archivo']['error']) {
    case UPLOAD_ERR_OK:
        break;
    case UPLOAD_ERR_NO_FILE:
        throw new RuntimeException('No file sent.');
    case UPLOAD_ERR_INI_SIZE:
    case UPLOAD_ERR_FORM_SIZE:
        throw new RuntimeException('Exceeded filesize limit.');
    default:
        throw new RuntimeException('Unknown errors.');
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$ext = array_search(
    $finfo->file($_FILES['archivo']['tmp_name']),
    array(
        'jpg' => 'image/jpeg',
        'png' => 'image/png',
    ),
    true
);

if ($ext === false) {
    throw new RuntimeException('Invalid file format.');
}
?>

</body>
</html>
