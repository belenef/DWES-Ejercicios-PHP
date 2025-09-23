<style>
            form{
                color: #333;
                background-color: lightblue;
                padding: 30px;
                border-radius: 10px;
                width: 500px;
                box-shadow: #9c9c9cff 5px 5px 25px;
                margin: auto;
            }

           i{
                color: #fa0000ff;
                text-align: center;
            }


            
</style>
        <section>
                <!-- le pedimos los numeros al usuario -->
                <form action="sumar_numeros.php" method="POST">
                    Número 1: <input type="text" name="num1" required><br>
                    Número 2: <input type="text" name="num2" required><br>
                    <input type="submit" value="Sumar">
                </form>
        </section>
                

            <!-- funcion para sumar dos numeros con manejo de errores -->
            <?php
            function sumarNumeros($numero1, $numero2) {

                // Verifica si ambos valores son numéricos
                if (!is_numeric($numero1) || !is_numeric($numero2)) {
                    // Si no son numéricos, lanza una excepción
                    throw new Exception("<p style= 'text-align: center;'><i>Error: Uno de los valores no es un número.</i></p>");
                }
                return $numero1 + $numero2 ;
            }

                try {
                    // Prueba la función con dos números
                    $numero1 = $_POST['num1'];
                    $numero2 = $_POST['num2'];
                    $resultado = sumarNumeros($numero1, $numero2);
                    echo"<br>";
                    echo "<p style= 'text-align: center;'> La suma de $numero1 y $numero2 es: $resultado</p>";

                } catch (Exception $e) {
                    // Captura y muestra el mensaje de error si ocurre una excepción
                    echo $e->getMessage();
                }
            ?>
            