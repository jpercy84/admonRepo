<?php
/**
 * Clase que controla la salida a un archivo plano
 * @author Euclides Rodriguez Gaitan
 *
 */
if(!defined('s3_entrada') || !s3_entrada) die('No es un punto de entrada valido');

class S3ArchivoPlano{
	private $nombreArchivo;
	private $directorio;
	
	function __construct(){		
//		ob_start();
	}
	
	public function setNombreArchivo($nombreArchivo){
		$this->nombreArchivo = $nombreArchivo;
	}
	
	public function getNombreArchivo(){
		return $this->nombreArchivo;
	}
	
	public function setDirectorio($directorio){
		$this->directorio = $directorio;
	}
	
	public function crearArchivo(){
		$rutaArchivo = $this->directorio.$this->nombreArchivo;
		if (!$fh = fopen($rutaArchivo, 'w+')) {
			__M("No pudo crear el archivo $this->nombreArchivo");
			die();
		}
	}
	
	public function escribir($contenido){
		$rutaArchivo = $this->directorio.$this->nombreArchivo;
		if (!$fh = fopen($rutaArchivo, 'a')) {
			die("No puede abrir el archivo ($rutaArchivo)");
			return false;
		}
		$contenido = $contenido.chr(13).chr(10);
		if (fwrite($fh,$contenido) === FALSE) {
			die("No puede escribir la línea en el archivo $this->nombreaArchivo");
			return false;
		}
	}
	public function mostrarEnPantalla(){
		$rutaArchivo = $this->directorio.$this->nombreArchivo;			
		header('Content-Disposition: attachment; filename="'.$this->nombreArchivo.'"');
		header("Content-Type: text/plain");	
		ob_clean();
    	flush();			
		readfile($rutaArchivo);
		exit();
	}
				
}
?>