<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>COUNT</title>
    </head>

    <body>

        <header>
            <?php
                // Incluye el contenido de cabecera desde otra carpeta
                require(__DIR__ . '/../2.1/cabecera.inc.php');
             ?> 
        </header>

        <!-- Barra de navegación -->
         <nav>
           <a href="../2.1/principal.php">principal.php</a>
        </nav>

        <!-- Sección principal con conteo y cálculo de factorial -->
        <section>
          
            <?php
                // Mostrar números del 1 al 30 separados por espacio
                echo "<br>";
                for ($i = 1; $i < 31; $i++) {
                    echo $i . " ";
                    
                }
            
                // Calcular y mostrar el factorial de 5
                $factorial = 1;
                $cadena = "5! = ";
                for ($j = 5; $j >= 1; $j--) {
                    $factorial *= $j;   // Multiplicación que se acumula
                    $cadena .= $j;  // Construcción de la cadena del factorial
                    if ($j > 1) {
                        $cadena .= " x ";  // Añade el símbolo de multiplicación si no es el último número       
                    }
                }
                $cadena .= " = " . $factorial;  // Añade el resultado final
                echo "<br><br>" . $cadena;  // Muestra el resultado en pantalla
            ?>
        </section>
        
        <footer>
              <?php
                // Incluye el contenido del footer
                require("footer.inc.php");
             ?> 
        </footer>
        
    </body>
</html>