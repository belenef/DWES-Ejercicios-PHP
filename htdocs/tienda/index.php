<?php
// Parte de conexión (esto también lo podemos usar desde stock.php)
$dwes = new mysqli('localhost', 'dwes', 'dwes', 'tienda');
if ($dwes->connect_errno != null) {
    die('Error conectando a la base de datos: ' . $dwes->connect_error);
}

// Si estamos mostrando la lista de productos (no estamos viniendo desde stock.php)
if (!defined('DESDE_STOCK')) {

    $consulta = "SELECT cod, nombre_corto, PVP FROM producto";
    $resultado = $dwes->query($consulta);

    if ($resultado === false) {
        die("Error en la consulta: " . $dwes->error);
    }

    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>PRINCIPAL</title>
        <style>
            body{ 
                font-family: Arial;
                color: #212222ff;
            }

            header{
                background-color: #B3E5FC;
                padding: 20px;
                border-radius: 10px;
            }
            .custom-list {
            list-style: none;
            padding-left: 0;
            }

            .custom-list li::before {
            content: "⭐";
            margin-right: 15px;
            }

            a{
                text-decoration: none;
                color: darkgoldenrod;
            }

            a:visited{
                color: lightslategray;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>Lista de productos</h1>
        </header>
        
        <ul class="custom-list">
            <?php while ($producto = $resultado->fetch_object()): ?>
                <li>
                    <a href="stock.php?cod=<?= $producto->cod ?>">
                        <?= $producto->nombre_corto ?> - <?= $producto->PVP ?> €
                    </a>
                </li>
            <?php endwhile; ?>
        </ul>

    </body>
    </html>
    <?php
    $resultado->free();
    $dwes->close();
}
?>
