<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Juego</title>
    </head>

    <body>

        <?php

            class Juego extends Soporte{
              public $consola;
              private $minNumJugadores;
              private $maxNumJugadores;

               public function __construct($titulo, $numero, $precio, $consola) {

                parent::__construct($titulo, $numero, $precio, $consola);
                $this->consola=$consola;
            }
            

              public function muestraJugadoresPosibles(){
                
              }

              public function getConsola(){
                
              }

                 public function muestraResumen(){
                    echo "<br>" . $this->titulo . "";
                    echo "<br>" . $this->getPrecio() . " € (IVA no incluido)<br>";
                    echo "<br>". $this->getConsola() . "<br>";
                    echo "<br>". $this->getMinNumJugadores() .
                    "". $this->getMaxNumJugadores() .

                }
            }
            ?>
            
        
    </body>
</html>


