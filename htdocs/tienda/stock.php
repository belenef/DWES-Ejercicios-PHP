<!--ESTILOS-->

<style>
    input[type="number"]{
        width: 40px;                         
        border: 2px solid #C71585;
        border-radius: 3px;
        margin-bottom: 10px;
    }

     body{ 
            font-family: Arial; 
            color: #212222ff;
        }

    header{
        background-color: lightpink;
        color: white;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
    }
</style>


<?php
// Avisamos que venimos desde stock.php para que index.php no imprima HTML
define('DESDE_STOCK', true);
require 'index.php'; // Solo carga la conexión, no la lista de productos

$cod = $_GET['cod'] ?? null;
if (!$cod) {
    die("Producto no especificado.");
}

// Si se envió el formulario, actualizar stock
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['unidades'] as $tienda => $unidades) {
        $unidades = (int)$unidades;
        $dwes->query("UPDATE stock SET unidades=$unidades WHERE producto='$cod' AND tienda=(SELECT cod FROM tienda WHERE nombre='$tienda')");
    }
    echo "<p style='color:green;'>Stock actualizado correctamente</p>";
}

// Consultar el stock actual
$resultado = $dwes->query("SELECT tienda.nombre AS tienda, stock.unidades FROM stock JOIN tienda ON stock.tienda = tienda.cod WHERE stock.producto='$cod'");

// al pinchar en un producto, te da la opción de actualizar el stock
// IMPRIMIR POR PANTALLA:
echo "<header><h1>Stock del producto en las tiendas:</h1></header>";
echo "<form method='POST'>";
while ($fila = $resultado->fetch_assoc()) {
    echo "Tienda {$fila['tienda']}: 
          <input type='number' name='unidades[{$fila['tienda']}]' value='{$fila['unidades']}'> unidades.<br>";
}
echo "<input type='submit' value='Actualizar'>";
echo "</form>";

$dwes->close();
?>
