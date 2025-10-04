<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Soporte</title>
    </head>

    <body>

        <?php

            class Soporte{
                public $titulo;
                protected $numero;
                public $precio;
                private $VAT = 0.21;
                public function __construct($titulo, $numero, $precio){
                    $this->titulo = $titulo;
                    $this->numero = $numero;
                    $this->precio = $precio;
                }

                //getPrecio()
                
                public function getPrecio(){
                    return $this->precio;
                }

                public function getPrecioConIVA(){
                    return $this->precio * (1 + $this->VAT);
                }   

                public function getNumero(){
                    return $this->numero;
                }

                public function muestraResumen(){
                    echo "<br>" . $this->titulo . "<br>";
                    echo "" . $this->getPrecio() . " € (IVA no incluido)<br>";
                }
            }
            ?>
            
        
    </body>
</html>