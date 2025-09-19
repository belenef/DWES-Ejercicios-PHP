<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>SERVER</title>
    </head>

    <body>

        <style>
            table, td, th {
                    margin-top: 10px;
                    border: 1px solid lightblue;
                    border-radius: 7px;
                    padding: 10px;
                    
            }

            th{
                font-family: sans-serif;
                color: darkblue;
                background-color: lightblue;
            }
                
        </style>

        <header>
            <?php
                // Incluye la cabecera desde otra carpeta
                 require(__DIR__ . '/../2.1/cabecera.inc.php');
             ?> 
        </header>

        <!-- Barra de navegación -->
         <nav>
           <a href="../2.1/principal.php">principal.php</a>
        </nav>

        <!-- Sección principal con tabla de información del servidor -->
        <section>
            <table>
                <thead>
                    <tr>
                        <th>Clave</th>  <!-- Nombre de la variable de servidor -->
                        <th>Valor</th>  <!-- Valor de la variable de servidor -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Recorre el array $_SERVER y muestra todas las claves y valores
                        foreach($_SERVER as $clave => $valor) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($clave) . "</td>";   // Evita problemas de caracteres especiales
                            echo "<td>" . htmlspecialchars($valor) . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>
        
        <footer>
              <?php
                 // Incluye el footer
                require("footer.inc.php");
             ?> 
        </footer>
        
    </body>
</html>