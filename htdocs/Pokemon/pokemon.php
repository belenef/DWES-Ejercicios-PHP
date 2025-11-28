<?php
$pokemon_name = $_GET['name'];

// Llamada a la API de Pokémon individual
$url = "https://pokeapi.co/api/v2/pokemon/" . strtolower($pokemon_name);
$json = file_get_contents($url);
$data = json_decode($json, true);

// Datos principales
$image = $data['sprites']['front_default'];
$types = array_map(fn($t) => $t['type']['name'], $data['types']);
$height = $data['height'];
$weight = $data['weight'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= ucfirst($pokemon_name) ?></title>
    <link rel="stylesheet" href="examen.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        header, footer {
            text-align: center;
            padding: 10px;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        article {
            border-radius: 60px;
            padding: 20px;
            text-align: center;
            margin: 0;
            max-width: 400px;
            width: 90%;
            box-shadow: 4px 10px 15px rgba(0,0,0,0.3);
            background-color: rgba(241, 182, 18, 0.8);
        }

        article h1, article p {
            margin: 0;
            padding: 4px 0;

        }

        article h1{
            border-bottom: 5px solid #fff;
            text-shadow: 2px 2px 2px gray;
            
        }
        article strong{
            color: whitesmoke;
            text-shadow: 2px 2px 2px gray;
            
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
<header>Mi blog de <img src="img/International_Pokémon_logo.svg.png" alt="Pokémon Logo"></header>
<nav>
    <strong>
        <a href="index.php">Inicio</a> &nbsp;&nbsp;
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
<main class="pokemon-detail">
    <article>
        <h1><?= ucfirst($pokemon_name) ?></h1>
        <img src="<?= $image ?>" alt="<?= $pokemon_name ?>">
        <div class="pokemon-info"><br>
            <p><strong>Tipos:</strong> <?= implode(', ', $types) ?></p>
            <p><strong>Altura:</strong> <?= $height / 10 ?> m</p>
            <p><strong>Peso:</strong> <?= $weight / 10 ?> kg</p>
        </div>
    </article>
</main>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>
</body>
</html>
