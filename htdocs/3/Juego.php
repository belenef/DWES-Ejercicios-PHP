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

               public function __construct($titulo, $numero, $precio, $consola, $minNumJugadores, $maxNumJugadores) {

                parent::__construct($titulo, $numero, $precio);
                $this->consola=$consola;
                $this->minNumJugadores=$minNumJugadores;
                $this->maxNumJugadores=$maxNumJugadores;
            }
            

            // Método que muestra los posibles jugadores
            public function muestraJugadoresPosibles(){
            if ($this->minNumJugadores == 1 && $this->maxNumJugadores == 1){
                echo "Para un jugador<br>";
            } elseif ($this->minNumJugadores == $this->maxNumJugadores){
                echo "Para " . $this->minNumJugadores . " jugadores<br>";
            } else {
                echo "De " . $this->minNumJugadores . " a " . $this->maxNumJugadores . " jugadores<br>";
            }
        }

                 public function muestraResumen(){      
                    parent::muestraResumen();
                    $this->muestraJugadoresPosibles();
                }
            }
            ?>
            
        
    </body>
</html>


