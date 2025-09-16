<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>TECNOLOGIAS</title>
    </head>

    <body>

        <header>
            <?php
                // Incluye el contenido de cabecera desde otro archivo PHP
                require("cabecera.inc.php");
             ?> 
        </header>

        <!-- Barra de navegación -->
        <nav>
            <a href="principal.php">principal.php</a>
        </nav>
       
        <!-- Sección principal con lista de tecnologías -->
        <section>
             <p>
                <ul>
                    <li>Github</li>
                    <li>Google</li>
                    <li>Visual Studio Code</li>
                    <li>Bootstrap</li>
                </ul>
            </p>
        </section>
        
        <footer>
              <?php
                // Incluye el contenido del footer desde otra carpeta
                require(__DIR__ . '/../2.2/footer.inc.php');
             ?> 
        </footer>
    </body>
</html>