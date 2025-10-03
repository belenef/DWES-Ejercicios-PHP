<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Dvd</title>
    </head>

    <body>

        <?php

            class Dvd extends Soporte{
              public $idiomas;
              private $formatPantalla;

               public function __construct($titulo, $numero, $precio, $idiomas, $formatPantalla) {

                parent::__construct($titulo, $numero, $precio);
                $this->idiomas=$idiomas;
                $this->formatPantalla=$formatPantalla;
            }
            

              public function getIdiomas(){
                    return $this->idiomas;
                }

                public function getFormatPantalla(){
                    return $this->formatPantalla;
                }


                 public function muestraResumen(){
                    echo "<br>" . $this->titulo . "";
                    echo "<br>" . $this->getPrecio() . " € (IVA no incluido)<br>";
                    echo "Idiomas: " . $this->getIdiomas() . "<br>";
                    echo "Formato Pantalla: " . $this->getFormatPantalla() . "<br>";
                }
            }
            ?>
            
        
    </body>
</html>


