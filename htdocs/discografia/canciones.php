<?php
session_start();

$mensaje = "";
$resultados = [];
$busqueda = "";
$campo = "ambos";
$genero = "";

// Configuración de cookie para últimas búsquedas
$cookieName = 'latest_searches_discografia';
$maxSaved = 5;
$cookieTtl = time() + 30*24*3600; // 30 días

// Manejo de limpiar búsquedas (antes de cualquier salida)
if (isset($_GET['clear_searches'])) {
    setcookie($cookieName, '', time() - 3600, '/');
    // redirigir sin parámetros
    $base = strtok($_SERVER['REQUEST_URI'], '?');
    header('Location: ' . $base);
    exit();
}

// Conexión PDO
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
    
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

// Función para realizar búsqueda
function realizar_busqueda($dwes, $busqueda, $campo, $genero, &$mensaje) {
    $resultados = [];
    $busqueda = trim($busqueda);
    if ($busqueda === '') {
        $mensaje = "Introduce un término de búsqueda.";
        return $resultados;
    }

    $param = '%' . $busqueda . '%';
    $params = [':p' => $param];

    $where = [];
    if ($campo === 'titulo') {
        $where[] = "titulo LIKE :p";
    } elseif ($campo === 'album') {
        $where[] = "album LIKE :p";
    } else { // ambos
        $where[] = "(titulo LIKE :p OR album LIKE :p)";
    }

    if ($genero !== '') {
        $where[] = "genero = :g";
        $params[':g'] = $genero;
    }

    $sql = "SELECT * FROM cancion";
    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }
    $sql .= " ORDER BY titulo";

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

    return $resultados;
}

// Procesar búsqueda desde POST (formulario) o GET (enlaces de últimas búsquedas)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $dwes) {
    $busqueda = trim($_POST['busqueda'] ?? '');
    $campo = $_POST['campo'] ?? 'ambos';
    $genero = $_POST['genero'] ?? '';

    if ($busqueda !== '') {
        $resultados = realizar_busqueda($dwes, $busqueda, $campo, $genero, $mensaje);

        // Actualizar cookie de últimas búsquedas
        $saved = [];
        if (!empty($_COOKIE[$cookieName])) {
            $decoded = json_decode($_COOKIE[$cookieName], true);
            if (is_array($decoded)) $saved = $decoded;
        }
        $normalized = mb_strtolower($busqueda);
        foreach ($saved as $k => $v) {
            if (mb_strtolower($v) === $normalized) {
                unset($saved[$k]);
            }
        }
        array_unshift($saved, $busqueda);
        $saved = array_slice($saved, 0, $maxSaved);
        setcookie($cookieName, json_encode($saved), $cookieTtl, '/');
    } else {
        $mensaje = "Introduce un término de búsqueda.";
    }
} elseif (isset($_GET['q']) && $dwes) {
    // Búsqueda triggered desde enlace de últimas búsquedas (GET)
    $busqueda = trim($_GET['q']);
    $campo = $_GET['campo'] ?? 'ambos';
    $genero = $_GET['genero'] ?? '';

    if ($busqueda !== '') {
        $resultados = realizar_busqueda($dwes, $busqueda, $campo, $genero, $mensaje);

        // Actualizar cookie también para búsquedas por GET
        $saved = [];
        if (!empty($_COOKIE[$cookieName])) {
            $decoded = json_decode($_COOKIE[$cookieName], true);
            if (is_array($decoded)) $saved = $decoded;
        }
        $normalized = mb_strtolower($busqueda);
        foreach ($saved as $k => $v) {
            if (mb_strtolower($v) === $normalized) {
                unset($saved[$k]);
            }
        }
        array_unshift($saved, $busqueda);
        $saved = array_slice($saved, 0, $maxSaved);
        setcookie($cookieName, json_encode($saved), $cookieTtl, '/');
        // No redirect: mostramos resultados directamente
    }
}

// Leer últimas búsquedas para mostrar 
$latestSearches = [];
if (!empty($_COOKIE[$cookieName])) {
    $decoded = json_decode($_COOKIE[$cookieName], true);
    if (is_array($decoded)) $latestSearches = $decoded;
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
        .latest {
            margin-top: 12px;
            background: #fff;
            padding: 8px;
            border-radius: 8px;
            max-width: 520px;
        }
        .latest ul { margin: 6px 0 0 18px; padding:0; }
        .latest a { text-decoration: none; color: #007BFF; }
        .clear-btn { margin-left: 8px; font-size:0.9em; }
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
                <option value="" <?php if($genero === '') echo 'selected'; ?>>-- Todos --</option>
                <option value="Pop" <?php if($genero === 'Pop') echo 'selected'; ?>>Pop</option>
            </select>

            <br>
            <button type="submit">Buscar</button>
            <?php if (!empty($latestSearches)): ?>
                <a class="clear-btn" href="?clear_searches=1">Limpiar últimas búsquedas</a>
            <?php endif; ?>
        </form>

        <?php if (!empty($latestSearches)): ?>
            <div class="latest">
                <strong>Últimas búsquedas</strong>
                <ul>
                    <?php foreach ($latestSearches as $s): ?>
                        <li>
                            <a href="?q=<?php echo urlencode($s); ?>"><?php echo htmlspecialchars($s); ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

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