<?php
class Model {
	protected $conexion;

	public function __construct($dbname, $dbuser, $dbpass, $dbhost){

		$opc = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');
		try {
			// HAY QUE ESPECIFICAR EL PUERTO '3307' PARA QUE ME VAYA LA BASE DE DATOS
			$mvc_bd_conexion = new PDO('mysql:host='. $dbhost .':3307;dbname=alimentos', 'belen', 'belen', $opc);
			
			$this->conexion = $mvc_bd_conexion;
		} catch (PDOException $e) {
			$error = 'Fallo la conexion: ' . $e->getMessage();
			//die('No ha sido posible realizar la conexion con la base de datos: '. $mvc_bd_conexion->connect_error);
			die('No ha sido posible realizar la conexion con la base de datos: '. $error);
		}
	 }

	private function dameAlimentosDB($sql){
		$result = $this->conexion->query($sql);

		$alimentos = array();

		while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
			$alimentos[] = $row;
		}

		return $alimentos;
	}

	public function dameAlimentos(){
		$sql = 'SELECT * FROM alimentos ORDER BY energia DESC;';
		return $this->dameAlimentosDB($sql);
	}

	
	public function buscarAlimentosPorNombre($nombre){
		$nombre = htmlspecialchars($nombre);
		$sql = 'SELECT * FROM alimentos WHERE nombre LIKE "'. $nombre .'" ORDER BY energia DESC;';
	
		return $this->dameAlimentosDB($sql);
	}

	// FUNCION PARA BUSCAR POR ENERGIA
	public function buscarAlimentosPorEnergia($energia){
		$energia = htmlspecialchars($energia);
		$sql = 'SELECT * FROM alimentos WHERE energia LIKE "'. $energia .'" ORDER BY energia DESC;';
	
		return $this->dameAlimentosDB($sql);
	}

	// FUNCION PARA BÚSQUEDA COMBINADA
	public function buscarAlimentosCombinada($nombre, $energia){
		$nombre = htmlspecialchars($nombre);
		$energia = htmlspecialchars($energia);
		$sql = 'SELECT * FROM alimentos WHERE nombre LIKE "'. $nombre .'" AND energia LIKE "'. $energia .'" ORDER BY energia DESC;';
		return $this->dameAlimentosDB($sql);
	}

	public function dameAlimento($id){
		$id = htmlspecialchars($id);
		$sql = 'SELECT * FROM alimentos WHERE id='. $id .';';

		return $this->dameAlimentosDB($sql)[0];
	}

	public function insertarAlimento($n, $e, $p, $hc, $f, $g){
		$n = htmlspecialchars($n);
		$e = htmlspecialchars($e);
		$p = htmlspecialchars($p);
		$hc = htmlspecialchars($hc);
		$f = htmlspecialchars($f);
		$g = htmlspecialchars($g);

		$sql = 'INSERT INTO alimentos (nombre, energia, proteina, hidratocarbono, fibra, grasatotal) VALUES ("'. $n .'",'. $e .','. $p .','. $hc .','. $f .','. $g .');';

		$result = $this->conexion->query($sql);
		return $result;
	}

	public function validarDatos($n, $e, $p, $hc, $f, $g) {
		return (is_string($n) & is_numeric($e) & is_numeric($p) & is_numeric($hc) & is_numeric($f) & is_numeric($g));
	}
}
?>