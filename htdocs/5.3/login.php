<?php
// Iniciar sesión
session_start();

$mensaje = "";
$showLoginForm = true;

$opc = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'];
try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si falla la conexión mostramos mensaje en la página
    $dwes = null;
    $mensaje = "Error de conexión a la base de datos.";
}

// Procesado de formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['usuario']) && isset($_POST['password']) && $dwes) {
        $usuario = trim($_POST['usuario']);
        $password = $_POST['password'];

        if ($usuario === '' || $password === '') {
            $mensaje = "Login fallido. Usuario y/o contraseña vacíos.";
            $showLoginForm = true;
        } else {
            try {
                $stmt = $dwes->prepare("SELECT password FROM tabla_usuarios WHERE usuario = :usuario LIMIT 1");
                $stmt->execute([':usuario' => $usuario]);
                $fila = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($fila && password_verify($password, $fila['password'])) {
                    // Login exitoso: almacenar el usuario en la sesión
                    $_SESSION['usuario'] = $usuario;
                    $mensaje = "¡Login exitoso, bienvenido, $usuario!";
                    
                    // Redirigir a la página de bienvenida (por ejemplo, pagina_bienvenida.php)
                    header("Location: ../discografia/index.php");
                    exit(); // Es importante usar exit() después de header para evitar que se ejecute código adicional
                } else {
                    // Login fallido
                    $mensaje = "Login fallido. Usuario o contraseña incorrectos.";
                    $showLoginForm = true;
                }

            } catch (PDOException $e) {
                $mensaje = "Error al intentar hacer login.";
                $showLoginForm = true;
            }
        }
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy(); // Destruir la sesión
    header("Location: " . $_SERVER['PHP_SELF']); // Redirigir al login
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Discografia - Login</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin:20px; 
            background:#f4f4f4; 
        }
        input[type="text"], input[type="password"] {
            width:200px; 
            border-radius: 6px;
            margin-bottom:4px; 
        }
        .mensaje { 
            color: green; 
            margin-bottom:10px; 
        }
        .error { 
            color: red; 
            margin-bottom:10px; 
        }
        header {
            margin-bottom: 20px;
        }
        .logout {
            float: right;
            padding: 8px 16px;
            background-color: #f44336;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .logout:hover {
            background-color: #d32f2f;
        }
        .register {
            float: right;
            padding: 8px 16px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-right: 10px;
        }
        .register:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<header>
    <?php if (isset($_SESSION['usuario'])): ?>
        <span>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?></span>
        <a href="?logout" class="logout">Logout</a>
    <?php else: ?>
        <!-- Enlace a la página de registro solo si no hay sesión activa -->
        <a href="registro.php" class="register">Registrarme</a>
    <?php endif; ?>
</header>

<h1>Login</h1>

<!--Lanza mensaje si hay error o no-->
<?php if ($mensaje !== ""): ?>
    <p class="<?php echo ($mensaje === '¡Login exitoso, bienvenido, ' . htmlspecialchars($usuario) . '!') ? 'mensaje' : 'error'; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
    </p>
<?php endif; ?>

<!--Si no hay sesión activa, mostrar formulario de login-->
<?php if (!isset($_SESSION['usuario']) && $showLoginForm): ?>
    <form method="post" action="">
        <div>
            <!--Label para el usuario-->
            <label for="usuario">Usuario:</label>
            <!--Input para el usuario-->
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div>
            <!--Label para la contraseña-->
            <label for="password">Contraseña:</label>
            <!--Input para la contraseña-->
            <input type="password" id="password" name="password" required>
        </div>
        <!--Botón de envío-->
        <div style="margin-top:10px;">
            <button type="submit">Iniciar sesión</button>
        </div>
    </form>
<?php endif; ?>

</body>
</html>
