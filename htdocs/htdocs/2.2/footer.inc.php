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

       // Array multidimensional con días y meses
        $fechaTexto = [
            "dias" => [
                "Domingo", "Lunes", "Martes", "Miércoles",
                "Jueves", "Viernes", "Sábado"
            ],
            "meses" => [
                1 => "Enero", "Febrero", "Marzo", "Abril",
                "Mayo", "Junio", "Julio", "Agosto",
                "Septiembre", "Octubre", "Noviembre", "Diciembre"
            ]
        ];

        // Obtener texto desde el array
        $diaTexto = $fechaTexto["dias"][$diaSemana];
        $mesTexto = $fechaTexto["meses"][$mes];

        // Mostrar fecha en formato: Miércoles, 20 de septiembre de 2023
        echo "{$diaTexto}, {$dia} de {$mesTexto} de {$anio}";
    ?>
</p>
