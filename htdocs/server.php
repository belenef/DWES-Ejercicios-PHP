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

                require("cabecera.inc.php");
             ?> 
        </header>

        
        <nav>
           <a href="principal.php">principal.php</a>
        </nav>

        <section>
            <table>
                <thead>
                    <tr>
                        <th>Clave</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($_SERVER as $clave => $valor) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($clave) . "</td>";
                            echo "<td>" . htmlspecialchars($valor) . "</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </section>
        
        <footer>
              <?php

                require("footer.inc.php");
             ?> 
        </footer>
        
    </body>
</html>