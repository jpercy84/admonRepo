<?php
/**
 * Clase que controla los reporte Exportable
 * @author Euclides Rodriguez Gaitan
 *
 */
if(!defined('s3_entrada') || !s3_entrada) die('No es un punto de entrada valido');
require_once('lib/aplicacion/Excel/S3Excel.php');
require_once('lib/aplicacion/reportes/S3Reporte.php');

class S3ReporteExportable extends S3Reporte{
	public function exportar($filtros = null){
            $this->realizarActualizaciones();
            $cabeceras = $this->obtenerCabeceras();		
            $registros = $this->obtenerRegistros($filtros);		
            $nombreArchivo = $this->obtenerNombreArchivo();
            $nombreHoja = $this->obtenerNombreHojaPrincipal();
            $excel = new S3Excel();
            $excel->crearLibro($nombreArchivo);		
            $hoja = $excel->crearHoja($nombreHoja);
            $hoja->imprimirCabeceras($cabeceras);
            //__P($registros['datos']);
            if(isset($registros['datos']) && count($registros['datos'])>0){
                    $hoja->imprimirDatos($registros['datos'],'',$registros['columnas_texto']);
            }
            $excel->imprimir();
          //  die();
	}
}
?>