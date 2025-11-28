<?php
$region = $_GET["name"]; // recoger la región de la URL

// Tabla de equivalencias región → pokedex ID
$region_to_pokedex = [
    "kanto" => 2,
    "johto" => 3,
    "hoenn" => 4,
    "sinnoh" => 5,
    "unova" => 8,
    "kalos" => 12,
    "alola" => 16
];


// Obtener el ID correspondiente
$pokedex_id = $region_to_pokedex[$region];

// Llamada correcta a la Pokédex de esa región
$url = "https://pokeapi.co/api/v2/pokedex/" . $pokedex_id;
$json = file_get_contents($url);
$data = json_decode($json, true);

$pokemon_entries = $data["pokemon_entries"];
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pokemon</title>
	<link rel="stylesheet" type="text/css" href="examen.css">
    <style>
        #iniciales ul {
            list-style: none;
            padding: 0;
            margin-left:85px;
            column-count: 6;       /* Número de columnas que quieras */
            column-gap: 20px;     /* Espacio entre columnas */
        }

        #iniciales li {
            padding: 6px 10px;
            font-size: 20px;
            text-shadow: 0.1px 0.1px 0.2px black;
            break-inside: avoid;   /* Evita que un item se divida entre columnas */
        }


        #iniciales {
            background-image: url("img/container_bg.png");
            float: left;
            width: 100%;
            height: 500px;

            overflow-y: auto; /* permite scroll vertical */
            overflow-x: hidden; /* evita desbordamiento horizontal */
        }


        #iniciales::-webkit-scrollbar {
            width: 10px;
        }

        #iniciales::-webkit-scrollbar-thumb {
            background: orange;
            border-radius: 10px;
        }

        #iniciales::-webkit-scrollbar-track {
            background: #fff3;
        }

        #iniciales {
            flex: 1; /* Ocupa todo el espacio disponible */
        }

        h1{
            text-align: center;
        }

        
    </style>
</head>
<body>
 
<header> Mi blog de &nbsp;&nbsp; <img src="img/International_Pokémon_logo.svg.png"></header>



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


<div id="iniciales">
<!-- mostrar regiones -->
<h1>Pokémons de la región de <?= ucfirst($region) ?></h1>

<ul>
<?php foreach ($pokemon_entries as $entry): ?>
    <?php $name = $entry["pokemon_species"]["name"]; ?>
    <li><a href="pokemon.php?name=<?= $name ?>"><?= ucfirst($name) ?></a></li>
<?php endforeach; ?>
</ul>

</div>


<div class="abajo"></div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>


