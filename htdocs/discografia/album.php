<?php
// Conexión a la base de datos con PDO
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
} catch (PDOException $e) {
    echo 'Falló la conexión: ' . $e->getMessage();
    exit;
}

// Recoge el parámetro del álbum
$cod = isset($_GET['codigo']) ? $_GET['codigo'] : null;

if (!$cod) {
    echo "No se ha especificado un álbum.";
    exit;
}

// Consulta información del álbum
$consultaAlbum = $dwes->prepare("SELECT * FROM album WHERE codigo = ?");
$consultaAlbum->execute([$cod]);
$album = $consultaAlbum->fetch(PDO::FETCH_ASSOC);

if (!$album) {
    echo "Álbum no encontrado.";
    exit;
}


// Consulta canciones del álbum 
$consultaCanciones = $dwes->prepare("SELECT * FROM cancion WHERE album = ? ORDER BY posicion ASC");
$consultaCanciones->execute([$cod]);
$canciones = $consultaCanciones->fetchAll(PDO::FETCH_ASSOC);

// Si el formato es nulo o cadena vacía, mostramos "Desconocido"
$formato = (!empty($album['formato'])) ? htmlspecialchars($album['formato']) : 'Desconocido';

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($album['titulo']) ?></title>
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
    <h1><?= htmlspecialchars($album['titulo']) ?></h1>
    <p><strong>Discográfica:</strong> <?= htmlspecialchars($album['discografica']) ?></p>
    <p><strong>Formato:</strong> <?= $formato ?></p>
    <p><strong>Fecha de lanzamiento:</strong> <?= htmlspecialchars($album['fechaLanzamiento']) ?></p>
    <p><strong>Fecha de compra:</strong> <?= htmlspecialchars($album['fechaCompra']) ?></p>
    <p><strong>Precio:</strong> <?= htmlspecialchars($album['precio']) ?> €</p>
    <h2>Canciones</h2>
    <ul>
        <?php if ($canciones): ?>
            <?php foreach ($canciones as $c): ?>
                <li>
                    <?= htmlspecialchars($c['posicion']) ?>. 
                    <?= htmlspecialchars($c['titulo']) ?> 
                    (<?= htmlspecialchars($c['duracion']) ?>, <?= htmlspecialchars($c['genero']) ?>)
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No hay canciones registradas.</li>
        <?php endif; ?>
    </ul>
    
    
    <p>
        <a href="cancionnueva.php?codigo=<?= urlencode($album['codigo']) ?>">Añadir nueva canción</a> |
        <a href="borraralbum.php?codigo=<?= urlencode($album['codigo']) ?>">Borrar álbum</a> |
        <a href="index.php?codigo=<?= urlencode($album['codigo']) ?>">Volver a la lista de discos</a>
    </p>

</body>
</html>

<?php
$dwes = null;
?>
