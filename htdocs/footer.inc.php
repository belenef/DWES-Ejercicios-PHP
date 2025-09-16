 <style>
           footer{
                background-color: lightblue;
                text-align: center;
                padding: 10px;
                color: darkblue;
                font-family: sans-serif;
                border: 1px solid darkblue;
                margin-top: 20px;
           }
            
</style>


<p>
    <?php
        //nombre
        echo "Belén Escrich <br>";

        // Obtener número de día de la semana y mes
        $diaSemana = date("w"); // 0 (domingo) a 6 (sábado)
        $dia = date("d");
        $mes = date("n"); // 1 a 12
        $anio = date("Y");

        // Día de la semana
        switch ($diaSemana) {
            case 0: $diaTexto = "Domingo"; break;
            case 1: $diaTexto = "Lunes"; break;
            case 2: $diaTexto = "Martes"; break;
            case 3: $diaTexto = "Miércoles"; break;
            case 4: $diaTexto = "Jueves"; break;
            case 5: $diaTexto = "Viernes"; break;
            case 6: $diaTexto = "Sábado"; break;
        }

        // Mes 
        switch ($mes) {
            case 1: $mesTexto = "enero"; break;
            case 2: $mesTexto = "febrero"; break;
            case 3: $mesTexto = "marzo"; break;
            case 4: $mesTexto = "abril"; break;
            case 5: $mesTexto = "mayo"; break;
            case 6: $mesTexto = "junio"; break;
            case 7: $mesTexto = "julio"; break;
            case 8: $mesTexto = "agosto"; break;
            case 9: $mesTexto = "septiembre"; break;
            case 10: $mesTexto = "octubre"; break;
            case 11: $mesTexto = "noviembre"; break;
            case 12: $mesTexto = "diciembre"; break;
        }

        // Mostrar fecha en formato: Miércoles, 20 de septiembre de 2023
        echo "{$diaTexto}, {$dia} de {$mesTexto} de {$anio}";
    ?>
</p>
