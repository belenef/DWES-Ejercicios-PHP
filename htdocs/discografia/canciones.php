<?php

$mensaje = "";
$resultados = [];
$busqueda = "";
$campo = "ambos";
$genero = "";

// Conexión PDO
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
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $dwes) {
    $busqueda = trim($_POST['busqueda'] ?? '');
    $campo = $_POST['campo'] ?? 'ambos'; // titulo, album, ambos
    $genero = $_POST['genero'] ?? '';

    if ($busqueda === '') {
        $mensaje = "Introduce un término de búsqueda.";
    } else {
        $param = '%' . $busqueda . '%';
        $params = [':p' => $param];

        // Construir WHERE según opciones
        $where = [];
        if ($campo === 'titulo') {
            $where[] = "titulo LIKE :p";
        } elseif ($campo === 'album') {
            $where[] = "album LIKE :p";
        } else { // ambos
            $where[] = "(titulo LIKE :p OR album LIKE :p)";
        }

        // Si se ha elegido un género (no vacío), añadirlo como filtro exacto
        if ($genero !== '') {
            $where[] = "genero = :g";
            $params[':g'] = $genero;
        }

        // Construir la consulta final
        $sql = "SELECT * FROM cancion";
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }
        $sql .= " ORDER BY titulo";

        // Ejecutar consulta
        try {
            $stmt = $dwes->prepare($sql);
            $stmt->execute($params);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (empty($resultados)) {
                $mensaje = "No se han encontrado canciones para '" . htmlspecialchars($busqueda) . "'.";
            }
        } catch (PDOException $e) {
            $mensaje = "Error en la búsqueda: " . htmlspecialchars($e->getMessage());
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Búsqueda de canciones</title>
    <style>
       
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        .panel {
            border:5px solid #9e9a95ff;
            background-color: #bceeff;
            padding:12px;
            width:520px;
            border-radius: 30px;
          
        }
        h1 { 
            margin:0 0 8px 0; 
            font-size:30px;
            color: #333;
        }
        label { 
            display:block; margin-top:8px; 
        }
        input[type="text"] {
             width:90%; padding:4px; 
            }
        .radios {
             margin:6px 0; 
            }
        .radios label {
             margin-right:12px; 
            }
        select {
             padding:4px; 
            }
        button {
             margin-top:8px;
              padding:6px 10px; 
            }
        table { 
            border-collapse:collapse;
            margin-top:35px; width:100%;
            max-width:900px; background:#fff; 
        }
        th, td { 
            border:1px solid #ccc;
            padding:5px; 
            text-align:left; 
            
        }
        .mensaje { 
            color:#900; 
            margin-top:8px; 
        }
    </style>
</head>
<body>
    <div class="panel">
        <h1>Búsqueda de canciones</h1>

        <?php if ($mensaje !== ""): ?>
            <p class="mensaje"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <form method="post" action="canciones.php">
            <label for="busqueda">Texto a buscar:</label>
            <input type="text" id="busqueda" name="busqueda" value="<?php echo htmlspecialchars($busqueda); ?>" required>

            <!--Botones para filtrar la busqueda-->
            <div class="radios">
                <label for="busqueda">Buscar en:</label>
                <input type="radio" name="campo" value="titulo" <?php if($campo === 'titulo') echo 'checked'; ?>> Títulos de canción</input>
                <input type="radio" name="campo" value="album" <?php if($campo === 'album') echo 'checked'; ?>> Nombres de álbum</input>
                <input type="radio" name="campo" value="ambos" <?php if($campo === 'ambos') echo 'checked'; ?>> Ambos campos</input>
            </div>

            <label for="genero">Género musical:</label>
            <select id="genero" name="genero">
                <option value="Pop" <?php if($genero === 'Pop') echo 'selected'; ?>>Pop</option>
            </select>

            <br>
            <button type="submit">Buscar</button>
        </form>
    </div>

    <!--Si hay resultados, mostrar la tabla-->
    <?php if (!empty($resultados)): ?>
        <table>
            <thead>
                <tr>
                    <?php foreach (array_keys($resultados[0]) as $col): ?>
                        <th><?php echo htmlspecialchars($col); ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($resultados as $fila): ?>
                    <tr>
                        <?php foreach ($fila as $valor): ?>
                            <td><?php echo htmlspecialchars((string)$valor); ?></td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <p><a href="index.php">Volver a la lista</a> | <a href="albumnuevo.php">Añadir disco</a></p>
</body>
</html>
<?php
// Cerrar conexión
if (isset($dwes)) { $dwes = null; }
?>