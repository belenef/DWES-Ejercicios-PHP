<?php
//Conexión a la base de datos
$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
try {
    
    $dwes = new PDO(
        'mysql:host=127.0.0.1;port=3307;dbname=usuarios_db;charset=utf8',
        'dwes_user',  
        'dwes_pass',  
        $opc
    );
    $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Falló la conexión: ' . $e->getMessage());
}
?>
