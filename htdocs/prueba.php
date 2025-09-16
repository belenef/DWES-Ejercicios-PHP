<!doctype html>
<html>
    <head>
    <meta charset="UTF-8">
    <title>Primera prueba php</title>
</head>
<body>
    
     <?php
            $cantidad = 3;
            $precio = 1.6;
            $total = $cantidad * $precio;
            echo "<h3>El total es $total</h3>";

            include("archivo.php");
            include_once("otro.php");
            require("prueba.inc.php");
            require_once("inventado.php");

    ?> 

</body>
</html>



