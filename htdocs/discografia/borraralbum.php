<?php
//eliminar un album y todas sus canciones asociadas

$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
    exit;
}

// Recoge el código del álbum
$cod = isset($_GET['codigo']) ? $_GET['codigo'] : null;

if ($cod) {
    // Eliminar canciones
    $eliminarCanciones = $dwes->prepare("DELETE FROM cancion WHERE album = ?");
    $eliminarCanciones->execute([$cod]);

    // Eliminar álbum
    $eliminarAlbum = $dwes->prepare("DELETE FROM album WHERE codigo = ?");
    $eliminarAlbum->execute([$cod]);

    echo "<p style='color: green;'>Álbum y canciones asociadas eliminados correctamente.</p>";
} else {
    echo "<p style='color: red;'>No se especificó un álbum.</p>";
}
//si hay un error, vuelve a album.php y reporta el error
header("Location: index.php");
exit;

?>