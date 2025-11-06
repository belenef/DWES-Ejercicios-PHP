<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario'];
$img_small = $_SESSION['img_small'];
$img_big = $_SESSION['img_big'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Perfil de <?php echo htmlspecialchars($usuario); ?></title>
<style>
    body { 
        font-family: Arial, sans-serif; 
        text-align: center; 
        margin-top: 50px; 
    }
    .perfil { 
        border: 1px solid #ccc; 
        display: inline-block; 
        padding: 20px; 
        border-radius: 10px; 
    }
    .nombre { 
        display: flex; 
        justify-content: center; 
        align-items: center; 
        gap: 10px; 
        margin-bottom: 20px; 
    }
    .nombre img { 
        width: 72px; 
        height: 96px; 
        border-radius: 5px; 
        object-fit: cover; 
    }
    .imagen-grande { 
        width: 360px; 
        height: 480px; 
        border-radius: 10px; 
        object-fit: cover; 
    }
</style>
</head>
<body>

<div class="perfil">
    <div class="nombre">
        <img src="<?php echo htmlspecialchars($img_small); ?>" alt="Mini perfil">
        <h2><?php echo htmlspecialchars($usuario); ?></h2>
    </div>

    <h3>Imagen de perfil (360x480):</h3>
    <img src="<?php echo htmlspecialchars($img_big); ?>" alt="Imagen grande" class="imagen-grande"><br><br>

    <a href="logout.php">Cerrar sesión</a>
</div>

</body>
</html>
