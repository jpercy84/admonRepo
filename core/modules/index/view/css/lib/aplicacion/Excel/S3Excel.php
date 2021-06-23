<?php

/**
 * Clase que controla la importación y exportación en Excel
 * @author Euclides Rodriguez Gaitan
 *
 */
if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');
require_once('lib/includes/PEAR/Spreadsheet_Excel_Writer/Writer.php');
require_once('lib/includes/PEAR/Spreadsheet_Excel_Writer/Reader.php');
require_once('lib/aplicacion/Excel/S3HojaExcel.php');

class S3Excel {

    private $writer;
    private $reader;
    private $nombreArchivo;

    public function __construct() {
        $this->writer = new Spreadsheet_Excel_Writer();
        $this->reader = new Spreadsheet_Excel_Reader();
        $this->reader->setOutputEncoding('UTF-8');
        
        // $this->reader = new Spreadsheet_Excel_Reader();
        //parent::Spreadsheet_Excel_Writer();
        $this->writer->setTempDir(realpath('./cache/tmp'));
        
    }

    public function crearLibro($nombreArchivo) {
        $this->writer->setVersion(8);
        $this->nombreArchivo = $nombreArchivo;
    }

    public function crearHoja($nombreHoja) {
        $hoja = new S3HojaExcel($this->writer);
        $hoja->crear($nombreHoja);
        return $hoja;
    }

    public function imprimir() {
        $this->writer->send($this->nombreArchivo);
        $this->writer->close();
    }

    public function leerArchivo($archivo) {
        $this->reader->read($archivo);
    }

    function obtenerCabeceras($hoja) {
        $cabeceras = $this->obtenerFila($hoja, 1);
        return $cabeceras;
    }

    function obtenerFila($hoja, $fila) {
        $filaDatos = array();
        $hoja--;
        $filaLeida = $this->reader->sheets[$hoja]['cells'][$fila];
        if (count($filaLeida) > 0) {
            $columnaFinal = array_pop(array_keys($filaLeida));
            $c = 1;
            $finFila = false;
            while (!$finFila) {
                if (array_key_exists($c, $filaLeida)) {
                    $filaDatos[$c] = utf8_encode($filaLeida[$c]);
                } else {
                    if ($columnaFinal > 0) {
                        if ($c >= $columnaFinal) {
                            $finFila = true;
                        } else {
                            $filaDatos[$c] = "";
                        }
                    }
                }
                $c++;
            }
        }
        return $filaDatos;
    }

    function obtenerFilasConInicio($hoja, $filaInicio, $columnaFin, $utfEncode = true) {
        $filas = array();
        $hoja--;
        $filasLeidas = $this->reader->sheets[$hoja]['cells'];
        foreach ($filasLeidas as $numFila => $fila) {
            if ($numFila >= $filaInicio) {
                $filaLeida = $filasLeidas[$numFila];
                $c = 1;
                $finFila = false;
                while (!$finFila) {
                    if (array_key_exists($c, $filaLeida)) {
                        $filas[$numFila][$c] = ($utfEncode) ? utf8_encode($filaLeida[$c]) : $filaLeida[$c];
                    } else {
                        if ($c <= $columnaFin) {
                            $filas[$numFila][$c] = "";
                        } else {
                            $finFila = true;
                        }
                    }
                    $c++;
                }
            }
        }
        return $filas;
    }

//    function S3Excel() {
//       
//    }

}

?>