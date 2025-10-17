<?php

if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'creado') {
    echo "<p style='color: green;'>Álbum creado correctamente.</p>";
}

// conexion base de datos discografia
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
$dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
} catch (PDOException $e) {
echo 'Falló la conexión: ' . $e->getMessage();
}
    // Consulta para obtener la lista de discos
    $consulta = "SELECT * FROM album";
    $resultado = $dwes->query($consulta);
    ?>


    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Discografia</title>
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
        <header>
            <h1>Lista de discos</h1>
        </header>

        <!--lista de discos-->
        <ul class="custom-list">
            <?php while ($album = $resultado->fetch(PDO::FETCH_ASSOC)): ?>
                <li>
                    <a href="album.php?codigo=<?= $album['codigo'] ?>">
                        <?= $album['codigo'] ?> - 
                        <?= $album['titulo'] ?> - 
                        <?= $album['discografica'] ?> - 
                        <?= $album['formato'] ?> - 
                        <?= $album['fechaLanzamiento'] ?> -
                        <?= $album['fechaCompra'] ?> -
                        <?= $album['precio'] ?>

                    </a>
                </li>
            <?php endwhile; ?>
        </ul>

        <p><a href="canciones.php">Búsqueda de canciones</a></p>
        <p><a href="albumnuevo.php">Añadir nuevo disco</a></p>


    </body>
    </html>
    <?php
    
    //Cierra conexión
    $dwes = null;

?>
