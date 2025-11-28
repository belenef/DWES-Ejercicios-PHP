
<?php
// acceder a la API
// $url = "https://pokeapi.co/api/v2/";
// $json = file_get_contents($url); 
// $data = json_decode($json, true);

// echo "<pre>";
// print_r($data);

$region_to_pokedex = [
    "kanto" => 1,
    "johto" => 2,
    "hoenn" => 3,
    "sinnoh" => 4,
    "unova" => 8,
    "kalos" => 12,
    "alola" => 16,
    "galar" => 27,
    "paldea" => 30
];


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

$url = "https://pokeapi.co/api/v2/pokedex/1";
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
       /* Estilo general de lista y li (ya no es necesario si usamos tarjetas, pero lo dejo) */
        #regiones-ul {
            list-style-type: none;
            margin-left: 27%;
        }
        #regiones-li {
            display: inline;
            margin: 10px;
            font-weight: bold;
            background-color: rgb(255, 174, 26);
            padding: 5px;
            border-radius: 7px;
        }
        #regiones-li a {
            text-decoration: none;
        }
        #regiones-ul #regiones-li:hover {
            background-color: rgb(255, 174, 26);   
        }

        /* Título */
        h1 {
            text-align: center;
        }

        /* Hacer que el body ocupe toda la pantalla y sea flex vertical */
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;  /* 100% de la altura de la ventana */
            margin: 0;
        }

        /* Header, nav y footer mantienen su tamaño natural */
        header, nav, footer {
            flex-shrink: 0;  /* no se encogen */
        }

        /* Contenedor de contenido con scroll */
        #iniciales {
            flex: 1;             /* ocupa todo el espacio restante */
            overflow-y: auto;    /* scroll vertical si es necesario */
            padding: 20px;
            box-sizing: border-box;
            background-image: url("img/container_bg.png");
        }

        /* Personalizar scroll */
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

        /* Contenedor de tarjetas */
        #regiones-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
        }

        /* Tarjeta de región */
        .region-card {
            width: 350px;
            height: 250px;
            background-color: rgb(255, 174, 26);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, background-color 0.3s;

            /* Flexbox para centrar contenido */
            display: flex;
            flex-direction: column;
            justify-content: center; /* centra verticalmente */
            align-items: center;     /* centra horizontalmente */
            padding: 10px;
            box-sizing: border-box;
        }

        /* Contenedor de los iniciales dentro de la tarjeta */
        .region-card .initials {
            display: flex;
            justify-content: space-around;
            width: 100%;
            margin-bottom: 10px;
        }

        /* Imagen de los Pokémon iniciales */
        .region-card .initials img {
            width: 80px;   /* más grande */
            height: 80px;  /* más grande */
            object-fit: contain;
        }

        /* Nombre de la región */
        .region-card h2 {
            font-size: 24px;  /* más grande */
            font-weight: bold;
            margin: 0;
            text-align: center;
            flex-grow: 1;         /* ocupa espacio restante para centrar vertical */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Enlaces dentro de la tarjeta */
        .region-card a {
            text-decoration: none;
            color: inherit;
        }

        /* Efecto hover en la tarjeta */
        .region-card:hover {
            background-color: rgba(224, 154, 24, 1);
            transform: scale(1.05);
        }



    </style>
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
    <h1>Regiones Pokémon</h1>
    <div id="regiones-scroll">
        <div id="regiones-container">
            <?php foreach ($regions as $region): ?>
                <?php $name = $region["name"]; ?>
                <article class="region-card">
                    <a href="region.php?name=<?= $name ?>">
                        
                        <h2><?= ucfirst($name) ?></h2>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</div>




<div class="abajo"></div>

<footer> Trabajo &nbsp;<strong> Desarrollo Web en Entorno Servidor </strong>&nbsp; 2023/2024 IES Serra Perenxisa.</footer>

</body>
</html>


