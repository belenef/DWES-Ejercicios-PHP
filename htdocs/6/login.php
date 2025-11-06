<?php
session_start();
require_once 'conexion.php'; // conexión PDO

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id, password, img_small, img_big FROM usuarios WHERE username = :username";
    $stmt = $dwes->prepare($sql);
    $stmt->execute([':username' => $username]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password'])) {
        $_SESSION['usuario'] = $username;
        $_SESSION['img_small'] = $usuario['img_small'];
        $_SESSION['img_big'] = $usuario['img_big'];
        header("Location: subida.php");
        exit();
    } else {
        echo "<p style='color: red;'>Usuario o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"><title>Login</title>
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
<h2>Iniciar sesión</h2>
<form action="login.php" method="POST">
    Usuario: <input type="text" name="username" required><br>
    Contraseña: <input type="password" name="password" required><br>
    <input type="submit" value="Entrar">
</form>
<a href="registro.php">Registrarse</a>
</body>
</html>
