<?php
/**
 * Clase que encapsula las funciones de manipulación
 * @author Euclides Rodriguez Gaitan
 *
 */
if(!defined('s3_entrada') || !s3_entrada) die('No es un punto de entrada valido');
class S3Tiempo{	
	function formatearFecha($fecha, $formatoInicial='d/m/Y', $formatoFinal='Y-m-d'){
		if(isset($fecha) && !empty($fecha)){
			list($dia, $mes, $anio) = split( '[/]', $fecha);
			$marcaTiempo = mktime(0,0,0, date($mes), date($dia), date($anio));						
			return date($formatoFinal, $marcaTiempo);
		}else{
			return 0;
		}
	}
}
?>