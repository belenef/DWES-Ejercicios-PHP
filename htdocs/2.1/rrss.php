<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>RRSS</title>
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

        <!-- Sección principal con enlaces a redes sociales -->
        <section>
            <p>Sígueme en mis redes sociales</p>

             <a href="http://www.facebook.com">
                <img src="../2.1/Facebook.jpg" alt="Facebook" width="50" height="50">
            </a>

            <a href="http://www.x.com">
                <img src="../2.1/Twitter.jpg" alt="Twitter" width="50" height="50">
            </a>
        </section>
        
        <footer>
              <?php
                // Incluye el contenido del footer desde otra carpeta
                require(__DIR__ . '/../2.2/footer.inc.php');
             ?> 
        </footer>
        
    </body>
</html>