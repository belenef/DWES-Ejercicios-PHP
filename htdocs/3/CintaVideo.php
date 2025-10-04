<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Cinta video</title>
    </head>

    <body>

        <?php

            class CintaVideo extends Soporte{
              private $duracion;

               public function __construct($titulo, $numero, $precio, $duracion) {

                parent::__construct($titulo, $numero, $precio);
                $this->duracion=$duracion;
            }
            

              public function getDuracion(){
                    return $this->duracion;
                }

                 public function muestraResumen(){
                    parent::muestraResumen();
                    echo "Duración: " . $this->getDuracion() . " minutos<br><br>";
                }
            }
            ?>
            
        
    </body>
</html>


