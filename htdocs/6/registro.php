<?php

session_start();

$opc = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
$mensaje = "";  

try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si falla la conexión mostramos mensaje en la página
    $dwes = null;
    $mensaje = "Error de conexión a la base de datos.";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!empty($_POST["usuario"]) && !empty($_POST["password"])) {
        $usuario = $_POST["usuario"];
        $password = $_POST["password"];

        $password_hashed = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $dwes->prepare("INSERT INTO tabla_usuarios (usuario, password) VALUES (:usuario, :password)");
            $stmt->execute([':usuario' => $usuario, ':password' => $password_hashed]);

            $mensaje = "Te has registrado correctamente! :)";

            header("Location: login.php");
            exit();

        } catch (PDOException $e) {
            // Maneja posibles errores en la inserción
            $mensaje = "Error al registrar el usuario: " . $e->getMessage();
        }
    } else {
        $mensaje = "Por favor, llena todos los campos.";
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registro</title>
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
            margin-bottom: 20px;
            display:flex;
            justify-content:space-between;
            align-items:center;
        }
        .title { margin:0; font-size:1.5em; }
        .logout {
            padding: 8px 16px;
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
        .login-btn:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <header>
        <h1 class="title">Registro</h1>
        <?php if (isset($_SESSION['usuario'])): ?>
            <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <?php else: ?>
            <a href="login.php" class="login-btn">Login</a>
        <?php endif; ?>
    </header>

    <!--Lanza mensaje si hay error o no-->
    <?php if ($mensaje !== ""): ?>
        <p class="<?php echo ($mensaje === 'Te has registrado correctamente! :)') ? 'mensaje' : 'error'; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </p>
    <?php endif; ?>

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
        <div style="margin-top: 10px;">
            <button type="submit">Registrarme</button>
        </div>
    </form>
</body>
</html>