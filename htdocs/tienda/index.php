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
                background-color: #ffffffff;
                color: #ff3fb2;
            }

            header{
                background-color: #ffcdec;
                padding: 20px;
                border-radius: 10px;
            }
            .custom-list {
            list-style: none;
            padding-left: 0;
            }

            .custom-list li::before {
                content: ""; /* Necesario para mostrar el pseudo-elemento */
                display: inline-block;
                width: 20px;  /* ancho deseado */
                height: 20px; /* alto deseado */
                margin-right: 10px;
                margin-bottom: 5px;
                background-image: url("icono.png");
                background-size: contain;  /* Ajusta la imagen al tamaño del bloque */
                background-repeat: no-repeat;
                vertical-align: middle;    /* centra con el texto */
            }


            a{
                text-decoration: none;
                color: #ff3fb2;
            }

            a:visited{
                color: lightgrey;
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
