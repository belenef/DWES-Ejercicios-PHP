<?php
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
    // Usa 127.0.0.1 en lugar de localhost para evitar conflictos con sockets
    $dwes = new PDO(
        'mysql:host=localhost;port=3312;dbname=discografia;charset=utf8',
        'discografia',
        'discografia',
        $opc
    );
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}
// Recoge el código del álbum
$cod = isset($_GET['codigo']) ? $_GET['codigo'] : null;
$mensaje = "";

// Obtiene información del álbum si se pasó el código
if ($cod) {
    $consultaAlbum = $dwes->prepare("SELECT * FROM album WHERE codigo = ?");
    $consultaAlbum->execute([$cod]);
    $album = $consultaAlbum->fetch(PDO::FETCH_ASSOC);

    if (!$album) {
        $mensaje = "Álbum no encontrado. El formulario seguirá apareciendo.";
        $album = ['titulo' => 'Álbum desconocido'];
    }
} else {
    $mensaje = "No se especificó un álbum. El formulario seguirá apareciendo.";
    $album = ['titulo' => 'Álbum desconocido'];
}

// Procesar formulario si se envía
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['titulo'] ?? '';
    $posicion = $_POST['posicion'] ?? '';
    $duracion = $_POST['duracion'] ?? '';
    $genero = $_POST['genero'] ?? '';

    if ($titulo && $posicion && $duracion && $genero && $cod) {
        $insert = $dwes->prepare(
            "INSERT INTO cancion (titulo, album, posicion, duracion, genero) VALUES (?, ?, ?, ?, ?)"
        );
        $insert->execute([$titulo, $cod, $posicion, $duracion, $genero]);
        $mensaje = "<p style='color: green;'>Canción añadida correctamente.</p>";
    } elseif (!$cod) {
        $mensaje = "<p style='color: red;'>No se pudo guardar la canción porque no se especificó un álbum.</p>";
    } else {
        $mensaje = "<p style='color: red;'>Debes completar todos los campos.</p>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Añadir Canción</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 20px;
        background-color: #f4f4f4;
    }
    h1 {
        color: #333;
    }

</style>
<body>
    <h1>Añadir nueva canción</h1>
    <p><strong>Álbum:</strong> <?= htmlspecialchars($album['titulo']) ?></p>

    <?php if ($mensaje): ?>
        <p><?= $mensaje ?></p>
    <?php endif; ?>

    <form method="post">
        <label>Título:</label><br>
        <input type="text" name="titulo" required><br><br>

        <label>Posición:</label><br>
        <input type="number" name="posicion" min="1" required><br><br>

        <label>Duración:</label><br>
        <input type="text" name="duracion" required><br><br>

        <label>Género:</label><br>
        <input type="text" name="genero" required><br><br>

        <input type="submit" value="Guardar">
    </form>

    <?php if ($cod): ?>
        <p><a href="album.php?codigo=<?= urlencode($cod) ?>">Volver al álbum</a></p>
    <?php endif; ?>
</body>
</html>

<?php
$dwes = null;
?>