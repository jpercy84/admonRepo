<?php
/**
 * Clase que controla los reporte
 * @author Euclides Rodriguez Gaitan
 *
 */
if(!defined('s3_entrada') || !s3_entrada) die('No es un punto de entrada valido');
require_once('lib/aplicacion/Excel/S3Excel.php');
require_once('lib/aplicacion/S3ArchivoPlano.php');
class S3Importador{
	private $filaInicial;
	private $columnaFinal;
	private $rutaArchivo;
	private $excel;
	private $camposObligatorios;
	private $camposNumericos;
	private $camposFecha;
	protected $nombreArchivo;
	protected $archivoPlano;
	protected $cabeceras;
	protected $datosAdicionales;
	
	function __construct(){
		$this->excel = new S3Excel();
	}
	
	public function setRangoCeldas($filaInicial, $columnaFinal){
					
		$hoja = $this->excel->crearHoja("Temp");
		
		$this->filaInicial = $filaInicial;
		$this->columnaFinal = $hoja->convertirLetraColumnaAEntero($columnaFinal);		
	}

	public function setDatosAdicionales($datos){
		$this->datosAdicionales = $datos;
	}
	
	public function setCamposObligatorios($camposObligatorios){
		$this->camposObligatorios = $camposObligatorios;
	}

	public function setCamposNumericos($camposNumericos){
		$this->camposNumericos = $camposNumericos;
	}

	public function setCamposFecha($camposFecha){
		$this->camposFecha = $camposFecha;
	}
	
	public function configurar($nombreArchivo){
		global $aplicacion;		
		$this->archivoPlano = new S3ArchivoPlano();
		$this->nombreArchivo = $nombreArchivo;
		$lenguajeApp = $aplicacion->getLenguaje()->getLenguajeAplicacion();
		$rutaUploadDir = $aplicacion->getConfig()->getVariableConfig('aplicacion-ruta_directorio_upload');
		$dirArchivoPlano = $rutaUploadDir."/LogsCargas/"; 
		$nombreArchivoPlano = "RC_".str_replace('.xls','.txt',$nombreArchivo);
		$this->archivoPlano->setNombreArchivo($nombreArchivoPlano);
		$this->archivoPlano->setDirectorio($dirArchivoPlano);
		$this->rutaArchivo = $rutaUploadDir."/".$nombreArchivo;
		$this->excel->leerArchivo($this->rutaArchivo);
		$this->cabeceras = $this->excel->obtenerCabeceras(1);		
	}
	
	public function procesar(){
		global $aplicacion;														
		$filas = $this->excel->obtenerFilasConInicio(1, $this->filaInicial, $this->columnaFinal);	
		$this->archivoPlano->escribir("Inicia la carga de actualización masiva. Hora: ".date('Y-m-d H:i:s'));
		$auditoriaId = $this->guardarAuditoria($filas);		
		for($l=$this->filaInicial;$l<count($filas)+$this->filaInicial;$l++){
			$resultadoFila="";			
			if($this->validarFila($filas[$l], $resultadoFila)){				
				$this->procesarFila($filas[$l], $resultadoFila, $auditoriaId);
			}
			if(!empty($resultadoFila)){				
				$resultadoFila = "Fila $l:".$resultadoFila;
				$this->archivoPlano->escribir($resultadoFila);
			}
		}		
		$this->archivoPlano->escribir("Se Finaliza la carga");	
		$this->archivoPlano->mostrarEnPantalla();	
	}	

	private function validarFila($fila, &$resultadoFila){								
		$camposInvalidos = array();				
		if($this->validarCamposObligatorios($fila, $camposInvalidos)){			
			if($this->validarCamposNumericos($fila, $camposInvalidos)){								
				if($this->validarCamposFecha($fila, $camposInvalidos)){					
					return true;
				}else{													
					$camposInvalidos = implode(",",$camposInvalidos);					
					$resultadoFila.= "Los campos ({$camposInvalidos}) deben ser fechas validas con formato 24/03/2010 (dd/mm/yyyy).";										
					return false;
				}
			}else{				
				$camposInvalidos = implode(",",$camposInvalidos);					
				$resultadoFila.="Los campos ({$camposInvalidos}) deben ser numericos.";										
				return false;
			}
		}else{
			$camposInvalidos = implode(",",$camposInvalidos);					
			$resultadoFila.="Los campos ({$camposInvalidos}) son obligatorios.";
			return false;
		}		 		
		return true;
	}
	
	private function validarCamposObligatorios($fila, &$camposInvalidos){						
		foreach($fila as $columna=>$valor){			
			if(array_key_exists($columna, $this->camposObligatorios)){
				if(empty($valor)){
					$camposInvalidos[]=$this->camposObligatorios[$columna];
				}
			}
		}
		if(count($camposInvalidos)>0){
			return false;
		}		
		return true;			
	}
	
	private function validarCamposNumericos($fila, &$camposInvalidos){										
		foreach($fila as $columna=>$valor){
			if(array_key_exists($columna, $this->camposNumericos)){							
				if(!is_numeric($valor)){					
					$camposInvalidos[]=$this->camposNumericos[$columna];
				}				
			}
		}		
		if(count($camposInvalidos)>0){
			return false;
		}		
		return true;
	}
	
	private function validarCamposFecha($fila, &$camposInvalidos){													
		foreach($fila as $columna=>$valor){
			if(array_key_exists($columna, $this->camposFecha)){
				$regexmail = "(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)[0-9]{2}";				
				if (!ereg($regexmail, $valor)){
					$camposInvalidos[]=$this->camposFecha[$columna];					
				}	
			}
		}
		if(count($camposInvalidos)>0){
			return false;
		}		
		return true;
	}

	/**
	 * Convierte la fila que entra en un arreglo en un arreglo asociado asignandole las cabeceras
	 * @param $fila
	 * @return unknown_type
	 */
	protected function obtenerRegistro($fila){		
		$registro = array();		
		foreach($fila as $columna=>$valor){					
			$registro[$this->cabeceras[$columna]] = $valor;
		}		
		return $registro;
	}	
}
?>