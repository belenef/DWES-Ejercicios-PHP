<?php
// Login con cookie de usuario autenticado
$mensaje = "";
$showConfirm = false;
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

// Poblar usuarios iniciales (solo si no existen) — evita duplicados comprobando antes
if ($dwes) {
    try {
        $usuarios = [
            ['usuario' => 'ana', 'password' => 'pass123'],
            ['usuario' => 'juan', 'password' => 'miClave45']
        ];
        $sel = $dwes->prepare("SELECT COUNT(*) FROM tabla_usuarios WHERE usuario = :usuario");
        $ins = $dwes->prepare("INSERT INTO tabla_usuarios (usuario, password) VALUES (:usuario, :password)");
        foreach ($usuarios as $u) {
            $sel->execute([':usuario' => $u['usuario']]);
            if ($sel->fetchColumn() == 0) {
                $hash = password_hash($u['password'], PASSWORD_DEFAULT);
                $ins->execute([':usuario' => $u['usuario'], ':password' => $hash]);
            }
        }
    } catch (PDOException $e) {
        // no mostrar detalles sensibles
    }
}

// comprobar cookie existente
$cookieUser = $_COOKIE['usuario_autenticado'] ?? ''; // Usuario
$cookieValid = false;

if ($cookieUser !== '' && $dwes) {
    try {
        //Consulta
        $stmt = $dwes->prepare("SELECT COUNT(*) FROM tabla_usuarios WHERE usuario = :usuario");
        $stmt->execute([':usuario' => $cookieUser]);
        if ($stmt->fetchColumn() > 0) {
            $cookieValid = true;
        } else {
            // borrar cookie inválida
            setcookie('usuario_autenticado', '', time() - 3600, '/');
            $cookieUser = '';
        }
    } catch (PDOException $e) {
        setcookie('usuario_autenticado', '', time() - 3600, '/');
        $cookieUser = '';
    }
}

// Procesado de formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Confirmación a partir de la pantalla que propone usar la cookie
    if (isset($_POST['confirm']) && $cookieValid) {
        if ($_POST['confirm'] === 'yes') {
            $mensaje = "Access successful";
            $showLoginForm = false;
            $showConfirm = false;
        } else {
            // usuario pulsa No: borrar cookie y recargar para mostrar formulario
            setcookie('usuario_autenticado', '', time() - 3600, '/');
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }


    // Procesar login 
    } elseif (isset($_POST['usuario']) && isset($_POST['password']) && $dwes) {
        $usuario = trim($_POST['usuario']);
        $password = $_POST['password'];

        if ($usuario === '' || $password === '') {
            $mensaje = "Login failed";
            $showLoginForm = true;

        } else {

            try {
                $stmt = $dwes->prepare("SELECT password FROM tabla_usuarios WHERE usuario = :usuario LIMIT 1");
                $stmt->execute([':usuario' => $usuario]);
                $fila = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($fila && password_verify($password, $fila['password'])) {
                    // crear cookie y redirigir para que esté disponible en $_COOKIE
                    setcookie('usuario_autenticado', $usuario, time() + 7 * 24 * 3600, '/', '', false, true);
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit;

                } else {
                    $mensaje = "Login failed";
                    $showLoginForm = true;
                }

            } catch (PDOException $e) {
                $mensaje = "Login failed";
                $showLoginForm = true;
            }
        }
    }
}

// Si no se ha enviado nada y existe cookie válida, mostrar confirmación
if (!$mensaje && $cookieValid && $_SERVER['REQUEST_METHOD'] !== 'POST') {
    $showConfirm = true;
    $showLoginForm = false;
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
            width:100px; 
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

    </style>
</head>
<body>
    <h1>Login</h1>

    <!--Lanza mensaje si hay error o no-->
    <?php if ($mensaje !== ""): ?>
        <p class="<?php echo ($mensaje === 'Login successful' || $mensaje === 'Access successful') ? 'mensaje' : 'error'; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </p>
    <?php endif; ?>

    <!--Si se ha confirmado el login, mostrar mensaje-->
    <?php if ($showConfirm && $cookieUser !== ''): ?>
        <div class="confirm-box">
            <p>Do you want to log in as <?php echo htmlspecialchars($cookieUser); ?>?</p>
            <form method="post" action="">
                <button class="btn" type="submit" name="confirm" value="yes">Yes</button>
                <button class="btn" type="submit" name="confirm" value="no">No</button>
            </form>
        </div>

    <!--Si no hay cookie, mostrar formulario de login-->
    <?php elseif ($showLoginForm): ?>
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