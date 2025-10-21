<?php

// conexion base de datos discografia
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
$dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
} catch (PDOException $e) {
echo 'Falló la conexión: ' . $e->getMessage();
}

    try {
    $dwes = new PDO('mysql:host=localhost;dbname=discografia', 'discografia', 'discografia', $opc);
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Crear valores de usuarios y guardarlos en la base de datos
    $usuarios = [
        ['usuario' => 'ana', 'password' => 'pass123'],
        ['usuario' => 'juan', 'password' => 'miClave45']
    ];

    // Insertar usuarios en la tabla / con IGNORE para evitar duplicados
    $stmt = $dwes->prepare("INSERT IGNORE INTO tabla_usuarios (usuario, password) VALUES (:usuario, :password)");
    foreach ($usuarios as $u) {
        // Hashear la contraseña antes de guardarla
        $hash = password_hash($u['password'], PASSWORD_DEFAULT);
        // Ejecutar la inserción
        $stmt->execute([':usuario' => $u['usuario'], ':password' => $hash]);
    }
    // echo "Usuarios creados.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
    


// Consulta para obtener la lista de usuarios
    $consulta = "SELECT * FROM tabla_usuarios";
    $resultado = $dwes->query($consulta);


// Procesar formulario de login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $dwes) {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    // Si algún campo está vacío lanza error
    if ($usuario === '' || $password === '') {
        $mensaje = "Login failed";
    } else {
        try {
            // Buscar usuario en la base de datos
            $stmt = $dwes->prepare("SELECT id, usuario, password FROM tabla_usuarios WHERE usuario = :usuario LIMIT 1");
            // Ejecutar la consulta
            $stmt->execute([':usuario' => $usuario]);
            // Obtener la fila resultante
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verificar contraseña
            if ($fila && password_verify($password, $fila['password'])) {
                // Contraseña correcta
                $mensaje = "Login successful";
            } else {
                // Contraseña incorrecta
                $mensaje = "Login failed";
            }

        // Lanzar excepción en caso de error
        } catch (PDOException $e) {
            $mensaje = "Login failed";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Discografia - Login</title>

    <style>
        .mensaje { 
            color: green;
         }

        .error { 
            color: red;
         }

         body{
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
         }

         input[type="text"]{
            width: 200px;                         
            border-radius: 3px;
            margin-bottom: 10px;
        }

        input[type="password"]{
            width: 200px;                         
            border-radius: 3px;
            margin-bottom: 10px;
        }
    </style>
    
</head>
<body>
    <header>
        <h1>Login</h1>
    </header>

    <?php if ($mensaje !== ""): ?>
        <!--Muestra por pantalla el mensaje de error o éxito-->
        <p class="<?php echo ($mensaje === 'Login successful') ? 'mensaje' : 'error'; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </p>
    <!--Acaba el if-->
    <?php endif; ?>

    <!-- Formulario de Login -->
    <form method="post" action="">
        <div>
            <!--Espacio para poner el usuario-->
            <label for="usuario">Usuario:</label>
            <input type="text" id="usuario" name="usuario" required>
        </div>
        <div>
            <!--Espacio para poner la contraseña-->
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <!--Botón de inicio de sesión-->
        <button type="submit">Iniciar sesión</button>
    </form>
</body>

</html>