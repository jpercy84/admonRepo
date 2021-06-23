<?php
/**
 * Clase que controla la hoja de un libro de Excel
 * @author Euclides Rodriguez Gaitan
 *
 */
if(!defined('s3_entrada') || !s3_entrada) die('No es un punto de entrada valido');
require_once('lib/includes/PEAR/Spreadsheet_Excel_Writer/Writer.php');
require_once('lib/aplicacion/Excel/S3HojaExcel.php');
class S3HojaExcel{	
	private $nombreHoja;
	private $writer;
	private $hoja; 
	private $formatoTitulo;
	
	public function __construct($writer){
		$this->writer = $writer;	
		$this->configurarFormatos();
	}
	
	public function crear($nombreHoja){		
		$this->hoja = $this->writer->addWorksheet($nombreHoja);
		$this->hoja->setInputEncoding('utf-8');		
	}
	
	
	private function configurarFormatos(){
		$this->configurarFormatoTitulo();
	}	
	
	private function configurarFormatoTitulo(){
		$formatoTitulo =& $this->writer->addFormat();		
		$this->writer->setCustomColor(12, 37, 64, 97);				
		$formatoTitulo->setFontFamily('Calibri'); 
		$formatoTitulo->setSize('11');	
		$formatoTitulo->setAlign('center');
		$formatoTitulo->setFgColor(12);
		$formatoTitulo->setColor('white'); 			
		$formatoTitulo->setBorderColor('black');				
		$this->formatoTitulo = $formatoTitulo;
	}
	
	public function fijarAnchoColumna($columna, $ancho){		
		$columna = $this->convertirLetraColumnaAEntero($columna);		
		$this->hoja->setColumn($columna,$columna,$ancho);
	}

	public function imprimirCeldaTitulo($referenciaFila, $referenciaColumna, $contenido){
		$fila = $referenciaFila-1;			
		$columna = $this->convertirLetraColumnaAEntero($referenciaColumna);			
		$this->hoja->writeString($fila, $columna, $contenido, $this->formatoTitulo);
	}
	
	public function imprimirCelda($referenciaFila, $referenciaColumna, $contenido){
		$fila = $referenciaFila-1;			
		$columna = $this->convertirLetraColumnaAEntero($referenciaColumna);			
		$this->hoja->writeString($fila, $columna, $contenido, "");
	}
	
	public function convertirLetraColumnaAEntero($letraColumna){
		$caracteres = str_split($letraColumna);		
		$numero = $this->obtenerNumeroDesdeLetra($caracteres[0]);
		if(count($caracteres)>1){			
			$num2daLetra=$this->obtenerNumeroDesdeLetra($caracteres[1]);
			$numero = $numero*26+$num2daLetra;			
		}
		$numero = $numero-1;		
		return $numero;
	}
	
	public function imprimirCabeceras($cabeceras){
		$this->hoja->writeRow(0, 0, $cabeceras, $this->formatoTitulo);		
	}
	
	private function obtenerNumeroDesdeLetra($letra){
		$letras = array('1'=>'A', '2'=>'B', '3'=>'C', '4'=>'D', '5'=>'E', '6'=>'F', '7'=>'G', '8'=>'H', '9'=>'I', '10'=>'J', '11'=>'K', '12'=>'L',
						'13'=>'M', '14'=>'N', '15'=>'O', '16'=>'P', '17'=>'Q', '18'=>'R', '19'=>'S', '20'=>'T', '21'=>'U', '22'=>'V', '23'=>'W', 
						'24'=>'X', '25'=>'Y', '26'=>'Z');		
		return array_search($letra, $letras);		
	}
	
	public function combinarCeldas($filaInicio, $columnaInicio, $filaFin, $columnaFin){
		$filaInicio= $filaInicio-1;
		$filaFin= $filaFin-1;		
		$columnaInicio = $this->obtenerNumeroDesdeLetra($columnaInicio)-1;		
		$columnaFin = $this->obtenerNumeroDesdeLetra($columnaFin)-1;
		$this->hoja->setMerge($filaInicio, $columnaInicio, $filaFin, $columnaFin);
	}
	
	function imprimirDatos($registros, $formato="", $columnasTexto=array()){
		$fila=1;
		foreach($registros as $registro){
			$columna=0;
			foreach($registro as $dato){		
				if(in_array($columna, $columnasTexto)){									
					$escribio = $this->hoja->writeString($fila, $columna, $dato, $formato);
				}else{
					$escribio = $this->hoja->write($fila, $columna, $dato, $formato);
				}
				if($escribio!=0){
					die("Fallo");
				}
				$columna++;
			}
			$fila++;
		}
	}
//        function S3HojaExcel() {
//        $this->reader = new Spreadsheet_Excel_Reader();
//        parent::Spreadsheet_Excel_Writer();
//        $this->setTempDir(realpath('./cache/tmp'));
//    }
}
?>