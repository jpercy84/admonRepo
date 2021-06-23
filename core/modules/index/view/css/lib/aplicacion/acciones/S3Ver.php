<?php
/**
 * Clase que controla la vista de detalle
 * @author Euclides Rodriguez Gaitan
 *
 */
if(!defined('s3_entrada') || !s3_entrada) die('No es un punto de entrada valido');
class S3Ver{
	private $objetoBD;
	private $objetoNegocio;
	
	public function getObjeto(){
		return $this->objetoNegocio;
	}
	
	public function __construct($objeto){
		$this->objetoBD = $objeto;
		$utils = new S3Utils();
		$claseON = $utils->obtenerClaseNegocioDeDO($this->objetoBD);
		require_once('modelo/negocio/objetos/'.$claseON.'.php');	
		$this->objetoNegocio = new $claseON();
	}
	
	 public function obtenerRegistro($registro){
	 	return $this->objetoNegocio->obtenerRegistro($registro);
	 }
}
?>