<?php
// Inicializar variables
$search_name = $_GET['name'] ?? '';
$search_region = $_GET['region'] ?? '';
$search_type = $_GET['type'] ?? '';
$pokemon = null;

// Función para buscar Pokémon por nombre
function search_pokemon_by_name($name) {
    $url = "https://pokeapi.co/api/v2/pokemon/" . strtolower($name);
    $json = @file_get_contents($url);
    if (!$json) return null;
    $data = json_decode($json, true);
    return $data;
}

// Función para obtener Pokémon de una región
function get_pokemon_by_region($region_name) {
    $region_to_pokedex = [
        "kanto" => 2,
        "johto" => 3,
        "hoenn" => 4,
        "sinnoh" => 5,
        "unova" => 8,
        "kalos" => 12,
        "alola" => 16
    ];
    if (!isset($region_to_pokedex[$region_name])) return [];
    $pokedex_id = $region_to_pokedex[$region_name];
    $url = "https://pokeapi.co/api/v2/pokedex/$pokedex_id";
    $json = file_get_contents($url);
    $data = json_decode($json, true);
    return $data['pokemon_entries'] ?? [];
}

// Función para buscar Pokémon por tipo
function get_pokemon_by_type($type) {
    $url = "https://pokeapi.co/api/v2/type/" . strtolower($type);
    $json = @file_get_contents($url);
    if (!$json) return [];
    $data = json_decode($json, true);
    return $data['pokemon'] ?? [];
}

// Procesar búsqueda por nombre
if ($search_name) {
    $pokemon = search_pokemon_by_name($search_name);
    if ($pokemon) {
        $types = array_map(fn($t) => $t['type']['name'], $pokemon['types']);
        $height = $pokemon['height'];
        $weight = $pokemon['weight'];
        $image = $pokemon['sprites']['front_default'];
    }
} elseif ($search_region) {
    $results = [];
    $entries = get_pokemon_by_region($search_region);
    foreach ($entries as $entry) {
        $p = search_pokemon_by_name($entry['pokemon_species']['name']);
        if ($p) $results[] = $p;
    }
} elseif ($search_type) {
    $results = [];
    $entries = get_pokemon_by_type($search_type);
    foreach ($entries as $entry) {
        $p = search_pokemon_by_name($entry['pokemon']['name']);
        if ($p) $results[] = $p;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Buscar Pokémon</title>
<link rel="stylesheet" href="examen.css">
<style>
    body { 
        font-family: Arial, sans-serif;
        display: flex;
        flex-direction: column; 
        margin: 0;
        min-height: 100vh;
        background-color: #f5f5f5;
    }
   
    .search-form { 
        text-align: center; 
        margin: 20px auto;
        background: #fff;
        padding: 15px;
        border-radius: 25px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        max-width: 655px;
        height: 30px;
    }
    .search-form input, .search-form select, .search-form button { 
        font-size: 16px; 
        padding: 5px; 
        margin: auto; 
        border-radius: 10px;
        border: 1px solid #ccc;
    }
    .search-form input:focus, .search-form select:focus {
        outline: none;
        border-color: #3b4cca;
        box-shadow: 0 0 5px rgba(59,76,202,0.5);
    }
    .search-form button {
        background-color: #3b4cca;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: 0.3s;
    }
    .search-form button:hover {
        background-color: #ff1c1c;
    }
    main {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: flex-start;
        padding: 20px;
        flex-wrap: wrap;
        gap: 20px;
    }
    article {
        border-radius: 60px;
        padding: 20px;
        text-align: center;
        max-width: 400px;
        width: 90%;
        box-shadow: 4px 10px 15px rgba(0,0,0,0.3);
        background-color: rgba(187,194,190,0.8);
        margin-bottom: 20px;
    }
    article h1, article p {
        margin: 0;
        padding: 4px 0;
        margin-bottom: 20px;
    }
    article h1 {
        border-bottom: 5px solid #fff;
    }
    .pokemon-detail img {
        width: 250px;
        height: 250px;
        display: block;
        margin: 0 auto 10px auto; 
    }
    .pokemon-info {
        font-size: 20px;
        text-align: left;
    }
</style>
</head>
<body>
<header>Mi blog de <img src="img/International_Pokémon_logo.svg.png" alt="Logo"></header>
<nav>
    <strong>
        <a href="region.php?name=kanto">G1 Kanto</a> &nbsp;&nbsp;
        <a href="region.php?name=johto">G2 Johto</a> &nbsp;&nbsp;
        <a href="region.php?name=hoenn">G3 Hoenn</a> &nbsp;&nbsp;
        <a href="region.php?name=sinnoh">G4 Sinnoh</a> &nbsp;&nbsp;
        <a href="region.php?name=unova">G5 Unova</a> &nbsp;&nbsp;
        <a href="region.php?name=kalos">G6 Kalos</a> &nbsp;&nbsp;
        <a href="region.php?name=alola">G7 Alola</a> &nbsp;&nbsp;
        <a href="region.php?name=galar">G8 Galar</a> &nbsp;&nbsp;
        <a href="region.php?name=paldea">G9 Paldea</a> &nbsp;&nbsp;
        <a href="search.php">Búsqueda</a>
    </strong>
</nav>
<div class="search-form">
    <form method="get">
        <input type="text" name="name" placeholder="Buscar por nombre" value="<?= htmlspecialchars($search_name) ?>">
        <select name="region">
            <option value="">Seleccionar región</option>
            <option value="kanto" <?= $search_region=='kanto'?'selected':'' ?>>Kanto</option>
            <option value="johto" <?= $search_region=='johto'?'selected':'' ?>>Johto</option>
            <option value="hoenn" <?= $search_region=='hoenn'?'selected':'' ?>>Hoenn</option>
            <option value="sinnoh" <?= $search_region=='sinnoh'?'selected':'' ?>>Sinnoh</option>
            <option value="unova" <?= $search_region=='unova'?'selected':'' ?>>Unova</option>
            <option value="kalos" <?= $search_region=='kalos'?'selected':'' ?>>Kalos</option>
            <option value="alola" <?= $search_region=='alola'?'selected':'' ?>>Alola</option>
        </select>
        <input type="text" name="type" placeholder="Buscar por tipo" value="<?= htmlspecialchars($search_type) ?>">
        <button type="submit">Buscar</button>
    </form>
</div>

<main class="pokemon-detail">
    <?php if ($pokemon): ?>
        <article>
            <h1><?= ucfirst($pokemon['name']) ?></h1>
            <img src="<?= $image ?>" alt="<?= $pokemon['name'] ?>">
            <div class="pokemon-info"><br>
                <p><strong>Tipos:</strong> <?= implode(', ', $types) ?></p>
                <p><strong>Altura:</strong> <?= $height / 10 ?> m</p>
                <p><strong>Peso:</strong> <?= $weight / 10 ?> kg</p>
            </div>
        </article>
    <?php elseif (!empty($results)): ?>
        <?php foreach ($results as $p): 
            $types = array_map(fn($t)=>$t['type']['name'], $p['types']);
        ?>
            <article>
                <h1><?= ucfirst($p['name']) ?></h1>
                <img src="<?= $p['sprites']['front_default'] ?>" alt="<?= $p['name'] ?>">
                <div class="pokemon-info"><br>
                    <p><strong>Tipos:</strong> <?= implode(', ', $types) ?></p>
                    <p><strong>Altura:</strong> <?= $p['height']/10 ?> m</p>
                    <p><strong>Peso:</strong> <?= $p['weight']/10 ?> kg</p>
                </div>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="text-align:center;">No se encontraron resultados.</p>
    <?php endif; ?>
</main>


<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>
</body>
</html>
