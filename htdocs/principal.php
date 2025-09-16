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

                require("cabecera.inc.php");
             ?> 
        </header>
        <nav>
            <a href="tecnologias.php">tecnologias.php</a> |
            <a href="rrss.php">rrss.php</a> |
            <a href="count.php">count.php</a> |
            <a href="http://www.gmail.com">beleneezz@gmail.com</a>

        </nav>

        <section>
            <p>
            Hola, mi nombre es Belén, tengo 18 años y estoy en proceso de ejercer 
            como desarrolladora web
            <br>
                <img src="kirby.png" alt="Kirby montado en una estrella" width="100" height="100">
        
            </p>

            <h2>Contacto</h2>
            <h4>Aquí podrás enviar alguna consulta:</h4>
                <form action="#" method="post">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required><br><br>

                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" required><br><br>

                    <label for="consulta">Consulta:</label><br>
                    <textarea id="consulta" name="consulta" rows="4" cols="40" required></textarea><br><br>

                    <input type="submit" value="Enviar">
                </form>
            
        </section>
        
        <footer>
            <?php

                require("footer.inc.php");
             ?> 
        </footer>
        

    </body>
</html>