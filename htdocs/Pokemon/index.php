
<?php
// acceder a la API
// $url = "https://pokeapi.co/api/v2/";
// $json = file_get_contents($url); 
// $data = json_decode($json, true);

// echo "<pre>";
// print_r($data);



//mostrar todas las regiones
$url = "https://pokeapi.co/api/v2/region/";
$json = file_get_contents($url);
$data = json_decode($json,true);
// Extraer la lista de regiones
$regions = $data["results"];

//mostrar pokemons
// $url = "https://pokeapi.co/api/v2/pokemon/";
// $json = file_get_contents($url);
// $data = json_decode($json,true);


?>



<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pokemon</title>
	<link rel="stylesheet" type="text/css" href="examen.css">
</head>
<body>
 
<header> Mi blog de &nbsp;&nbsp; <img src="img/International_Pokémon_logo.svg.png"></header>



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


<div id="iniciales">
<!-- mostrar regiones -->
<h1>Regiones Pokémon</h1>
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


