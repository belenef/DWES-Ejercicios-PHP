<?php

$opc = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si falla la conexión mostramos mensaje en la página
    $dwes = null;
    $mensaje = "Error de conexión a la base de datos.";
}

$usuario = $_POST["usuario"];
$password = $_POST["password"];

$password_hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $dwes->prepare("INSERT into tabla_usuarios (usuario, password) VALUES (:usuario,:password)");

$stmt-> execute([$usuario, $password_hashed]);

echo "<p style= 'color: green;'> Te has registrado correctamente! :) </p>";


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Discografia - Registro</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin:20px; 
            background:#f4f4f4; 
        }
        input[type="text"], input[type="password"] {
            width:100px; 
            border-radius: 6px;
            margin-bottom:4px; 
        }


    </style>
</head>
<body>
    <h1>Registro</h1>

    <!--Lanza mensaje si hay error o no-->
    <?php if ($mensaje !== ""): ?>
        <p class="<?php echo ($mensaje === 'Registro successful' || $mensaje === 'Access successful') ? 'mensaje' : 'error'; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </p>
        <form method="post" action="">
            <div>
                <!--Label para el usuario-->
                <label for="usuario">Nombre de usuario:</label>
                <!--Input para el usuario-->
                <input type="text" id="usuario" name="usuario" required>
            </div>
            <div>
                <!--Label para la contraseña-->
                <label for="password">Escribe una contraseña:</label>
                <!--Input para la contraseña-->
                <input type="password" id="password" name="password" required>
            </div>
            <!--Botón de envío-->
            <div style="margin-top:10px;">
                <button type="submit">Registrarme</button>
            </div>
        </form>
    <?php endif; ?>

    
</body>
</html>