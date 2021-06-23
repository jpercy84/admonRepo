<?php
/**
 * Clase que controla los errores globales
 * @author Euclides Rodriguez Gaitan
 *
 */
if(!defined('s3_entrada') || !s3_entrada) die('No es un punto de entrada valido');
class S3Error{
	private $erroresGlobales;
	public function agregarError($error){
		$this->erroresGlobales[] = $error;
	}
	
	public function getErroresGlobales(){
		return $this->erroresGlobales;
	}
}
?>