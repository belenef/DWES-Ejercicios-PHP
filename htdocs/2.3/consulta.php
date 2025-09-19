<?php
    echo 'La persona es: ';
    echo $_POST['nombre'];
    echo '<br>Su correo electrónico es: ';
    echo $_POST['email'];
    echo $_POST['checkbox'] ? '<br>El checkbox está marcado' : '<br>El checkbox no está marcado';
    echo $_POST['date'] ? '<br>La fecha seleccionada es: ' . $_POST['date'] : '<br>No se ha seleccionado ninguna fecha';
    echo $_POST['consulta'] ? '<br>La consulta es: ' . $_POST['consulta'] : '<br>No se ha realizado ninguna consulta';
?>