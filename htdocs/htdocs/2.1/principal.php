<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>PRINCIPAL</title>
    </head>

    <body>
        
        <style>
           header{
                background-color: lightblue;
                text-align: center;
                padding: 10px;
           }
            
       </style>
        <header>
             <?php
                // Incluye el contenido de cabecera desde otro archivo PHP
                require("cabecera.inc.php");
             ?> 
        </header>
        <nav>

           <!-- Barra de navegación con enlaces a otras páginas -->
            <a href="tecnologias.php">tecnologias.php</a> |
            <a href="rrss.php">rrss.php</a> |
            <a href="/2.2/count.php">count.php</a> |
            <a href="/2.2/server.php">server.php</a> |
            <a href="http://www.gmail.com">beleneezz@gmail.com</a>

        </nav>

        <!-- Sección principal del contenido -->
        <section>
            <p>
            Hola, mi nombre es Belén, tengo 18 años y estoy en proceso de ejercer 
            como desarrolladora web
            <br>
                <img src="kirby.png" alt="Kirby montado en una estrella" width="100" height="100">
        
            </p>

            <!-- formulario de contacto -->
            <h2>Contacto</h2>
            <h4>Aquí podrás enviar alguna consulta:</h4>
                <form name="input" action="../2.3/consulta.php" method="post">

                    <!-- Campo de texto para nombre -->
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required><br><br>

                    <!-- Campo de texto para email -->
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" required><br><br>

                    <!-- Campo para checkbox -->
                    <label for="checkbox">Checkbox:</label>
                    <input type="checkbox" id="checkbox" name="checkbox"><br><br>

                    <!-- Campo para seleccionar fecha -->
                    <label for="date">Fecha:</label>
                    <input type="date" id="date" name="date"><br><br>

                    <!-- Área de texto para consulta -->
                    <label for="consulta">Consulta:</label><br>
                    <textarea id="consulta" name="consulta" rows="4" cols="40" required></textarea><br><br>

                    <!-- Botón para enviar el formulario -->
                    <input type="submit" value="Enviar">
                </form>
            
        </section>
        
        <footer>
            <?php
                // Incluye el contenido del footer desde otra carpeta
                require(__DIR__ . '/../2.2/footer.inc.php');
             ?> 
        </footer>
        

    </body>
</html>