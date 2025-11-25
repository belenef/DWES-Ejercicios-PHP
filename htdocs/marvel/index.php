<?php
// Cargar JSON desde archivo
$json = file_get_contents('marvel_characters.json'); // tu JSON completo
$data = json_decode($json, true);

// Verificar que se haya decodificado correctamente
if (!$data) {
    die("Error al decodificar JSON");
}

//css
echo '
<style>
table {
    border-collapse: separate;
    border: 2px solid rgb(0,0,0);
    border-radius: 10px;
    overflow: hidden;  
    width: 100%;
}
th, td {
    border: 1px solid rgb(0,0,0);
    padding: 5px;
    text-align: left;
    background-color: rgb(230,230,230);
    color: rgb(0,0,0);
}
th {
    font-family: Arial, sans-serif;
    text-align: center;
    background-color: rgb(226,0,26);
    color: rgb(255,255,255);
}

img{
    margin-left: 50px;
}

p{
margin-top: -2px;
}
</style>
';

// Crear tabla HTML
echo '<table>';
echo '<tr><th>Personaje</th><th>Cómics</th></tr>';

// Recorrer cada personaje (es un array)
foreach ($data as $character) {
    $nombre = isset($character['name']) ? $character['name'] : "Desconocido";

    // Verificar si hay cómics
    if (isset($character['comics']['items']) && count($character['comics']['items']) > 0) {
        $comicsList = [];
        foreach ($character['comics']['items'] as $comic) {
            $comicsList[] = $comic['name'];
        }
        $comicsHTML = htmlspecialchars(implode(", ", $comicsList));
    } else {
        // Si no hay cómics o el array está vacío, mostramos la imagen
       $comicsHTML = '<img src="KIRBY.png" alt="No hay comics" width="50"><br><p>No hay cómics disponibles</p>';

        
    }

    echo "<tr>";
    echo "<td>" . htmlspecialchars($nombre) . "</td>";
    echo "<td>" . $comicsHTML . "</td>";
    echo "</tr>";
}
?>