<?php

include "Soporte.php";
$soporte1 = new Soporte("Tenet", 22, 3);
echo "<strong>" . $soporte1->titulo . "</strong>";
echo "<br>Precio: " . $soporte1->getPrecio() . " euros";
echo "<br>Precio IVA incluido: " . $soporte1->getPrecioConIVA() . " euros";
$soporte1->muestraResumen();
echo "<br><hr>";

?>


<?php
    include "CintaVideo.php";
    $miCinta = new CintaVideo("Los cazafantasmas", 23, 3.5, 107);
    echo "<strong>" . $miCinta->titulo . "</strong>";
    echo "<br>Precio: " . $miCinta->getPrecio() . " euros";
    echo "<br>Precio IVA incluido: " . $miCinta->getPrecioConIva() . " euros";
    echo "<br>Película en VHS:";
    $miCinta->muestraResumen();
    echo "<hr>";
   
    
?>


<?php
   include "Dvd.php";
    $miDvd = new Dvd("Origen", 24, 15, "es,en,fr", "16:9");
    echo "<strong>" . $miDvd->titulo . "</strong>";
    echo "<br>Precio: " . $miDvd->getPrecio() . " euros";
    echo "<br>Precio IVA incluido: " . $miDvd->getPrecioConIva() . " euros";
    echo "<br>Película en DVD:";
    $miDvd->muestraResumen();
     echo "<hr>";
    
?>

<?php
    include "Juego.php";
    $miJuego = new Juego("The Last of Us Part II", 26, 49.99, "PS4", 1, 1);
    echo "<strong>" . $miJuego->titulo . "</strong>";
    echo "<br>Precio: " . $miJuego->getPrecio() . " euros";
    echo "<br>Precio IVA incluido: " . $miJuego->getPrecioConIva() . " euros";
    echo "<br>Juego para: " . $miJuego->consola . "";
    $miJuego->muestraResumen();
?>