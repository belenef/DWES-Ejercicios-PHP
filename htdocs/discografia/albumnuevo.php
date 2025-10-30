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

$mensaje = "";

// Procesar formulario si se envía
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $codigo = $_POST['codigo'] ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $discografica = $_POST['discografica'] ?? '';
    $formato = $_POST['formato'] ?? '';
    $fechaLanzamiento = $_POST['fechaLanzamiento'] ?? '';
    $fechaCompra = $_POST['fechaCompra'] ?? '';
    $precio = $_POST['precio'] ?? '';

   if ($codigo && $titulo && $discografica && $formato && $fechaLanzamiento && $fechaCompra && $precio) {
    try {
        $insert = $dwes->prepare(
            "INSERT INTO album (codigo, titulo, discografica, formato, fechaLanzamiento, fechaCompra, precio) VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $insert->execute([$codigo, $titulo, $discografica, $formato, $fechaLanzamiento, $fechaCompra, $precio]);
        header('Location: http://discografia.local/index.php?mensaje=creado');
        exit;
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Código de error para clave duplicada
            $mensaje = "<p style='color: red;'>Error: El código ya existe. Introduce uno diferente.</p>";
        } else {
            $mensaje = "<p style='color: red;'>Error al añadir el álbum: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    }
} else {
    $mensaje = "<p style='color: red;'>Debes completar todos los campos.</p>";
}
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Añadir Album</title>
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
    <h1>Añadir nuevo álbum</h1>

    <?php echo $mensaje; ?>

    <form method="post">
        <label>Código:</label><br>
        <input type="text" name="codigo" required><br><br>

        <label>Título:</label><br>
        <input type="text" name="titulo" required><br><br>

        <label>Discográfica:</label><br>
        <input type="text" name="discografica" required><br><br>

        <label>Formato:</label><br>
        <input type="text" name="formato" required><br><br>

        <label>Fecha de lanzamiento:</label><br>
        <input type="date" name="fechaLanzamiento" required><br><br>

        <label>Fecha de compra:</label><br>
        <input type="date" name="fechaCompra" required><br><br>

        <label>Precio:</label><br>
        <input type="text" name="precio" required><br><br>

        <input type="submit" value="Guardar">
    </form>

    <p><a href="index.php">Volver a la lista de discos</a></p>
</body>
</html>
    
<?php

$dwes = null;
?>