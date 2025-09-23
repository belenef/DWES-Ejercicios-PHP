<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>REGISTRO</title>
    </head>

    <body>
        <style>
            body{
                font-family: Arial, sans-serif;
                background-color: #f0f8ff;
            }

            h4{
                text-align: center;
                color: darkblue;
            }

            form{
                color: #333;
                background-color: lightblue;
                padding: 30px;
                border-radius: 10px;
                width: 500px;
                box-shadow: #9c9c9cff 5px 5px 25px;
                margin: auto;
            }

            p{
                text-align: center;
            }

            /*Modifica los campos (donde se escribe) de cada tipo*/ 
            input[type="text"],
            input[type="password"],
            input[type="email"],
            input[type="date"] {
                    width: 300px;           
                    padding: 3px;               
                    border: 2px solid #87b3c0ff; 
                    border-radius: 5px;     
                    box-sizing: border-box; /* Incluye padding en el ancho */
            }

            input[type="text"]:hover,
            input[type="password"]:hover,
            input[type="email"]:hover,
            input[type="date"]:hover {
                   background-color: #f3f0f0ff;
            }

            input[type="submit"] {
                    background-color: #87b3c0ff;
                    color: #333;
                    padding: 10px 20px;
                    border: none;
                    border-radius: 5px;
                    cursor: pointer;
                    text-align: center;
            }

            input[type="submit"]:hover {
                    background-color: darkblue;
                    color: white;
            }

        
        </style>
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

         <!-- Sección principal formulario de registro -->
        <section>

         <h4>Registro:</h4>
                <form name="input" action="../2.3/registro.php" method="post">

                    <!-- Campo de texto para nombre -->
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required><br><br>

                    <!-- Campo de texto para apellido -->
                    <label for="apellido">Apellido:</label>
                    <input type="text" id="apellido" name="apellido" required><br><br>

                    <!-- Campo de texto para nombre de usuario -->
                    <label for="username">Nombre de usuario:</label>
                    <input type="text" id="username" name="username" required><br><br>

                    <!-- Campo de texto para contraseña -->
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required><br><br>

                    <!-- Campo de texto para contraseña (verificación) -->
                    <label for="password_verificacion">Verificar contraseña:</label>
                    <input type="password" id="password_verificacion" name="password_verificacion" required><br><br>

                    <!-- Campo de texto para email -->
                    <label for="email">Correo electrónico:</label>
                    <input type="email" id="email" name="email" required><br><br>


                    <!-- Campo para seleccionar fecha de nacimiento -->
                    <label for="fecha_nacimiento">Fecha de nacimiento:</label>
                    <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" required><br><br>

                    <!-- Campo para seleccionar genero -->
                    <label for="genero">Género:</label>
                    <select id="genero" name="genero" required>
                        <option value="masculino">Masculino</option>
                        <option value="femenino">Femenino</option>
                        <option value="otro">Otro</option>
                    </select><br><br>

                    <!-- Campo para aceptar condiciones -->
                    <label for="checkbox">Aceptar condiciones:</label>
                    <input type="checkbox" id="checkbox" name="checkbox" required><br><br>

                    <!-- Campo para aceptar mandar publicidad -->
                    <label for="checkbox_publicidad">Aceptar mandar publicidad:</label>
                    <input type="checkbox" id="checkbox_publicidad" name="checkbox_publicidad"><br><br>

                    <!-- Botón para enviar el formulario -->
                    <input type="submit" value="Enviar">
                </form>

                 <?php
                    if ($_SERVER["REQUEST_METHOD"] === "POST") {
                        // Recoger los valores del formulario
                        $password = $_POST['password'];
                        $password_verificacion = $_POST['password_verificacion'];

                        if ($password === $password_verificacion) {
                            echo "<br>";
                            echo "<p style='color: green;'>Las contraseñas coinciden. :) <br> ¡ Te has registrado correctamente !</p>";

                        } else {
                            echo "<br>";
                            echo "<p style='color: red;'>Las contraseñas no coinciden. :( <br> Por favor, intenta de nuevo.</p>";
                        }
                    }
                ?>


        </section>
        
        <footer>
              <?php
                // Incluye el contenido del footer
                require(__DIR__ . "/../2.2/footer.inc.php");
             ?> 
        </footer>
        
    </body>
</html>