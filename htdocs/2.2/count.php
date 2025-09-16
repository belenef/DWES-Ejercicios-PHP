<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>COUNT</title>
    </head>

    <body>

        <header>
            <?php

                require(__DIR__ . '/../2.1/cabecera.inc.php');
             ?> 
        </header>

        
         <nav>
           <a href="../2.1/principal.php">principal.php</a>
        </nav>

        <section>
          
            <?php
                echo "<br>";
                for ($i = 1; $i < 31; $i++) {
                    echo $i . " ";
                    
                }
            
                // Calcular y mostrar el factorial de 5
                $factorial = 1;
                $cadena = "5! = ";
                for ($j = 5; $j >= 1; $j--) {
                    $factorial *= $j;
                    $cadena .= $j;
                    if ($j > 1) {
                        $cadena .= " x ";
                    }
                }
                $cadena .= " = " . $factorial;
                echo "<br><br>" . $cadena;
            ?>
        </section>
        
        <footer>
              <?php

                require("footer.inc.php");
             ?> 
        </footer>
        
    </body>
</html>