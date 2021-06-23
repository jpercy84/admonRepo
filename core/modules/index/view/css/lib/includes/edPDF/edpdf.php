<?php

if (!defined('s3_entrada') || !s3_entrada)
    die('No es un punto de entrada valido');

require_once 'lib/includes/edPDF/include/fpdf/fpdf.php';
require_once 'lib/includes/edPDF/include/fpdi/fpdi.php';

class edPDF extends FPDI {
    private $colorTexto = array();
    private $colorFill = array();
    function __construct() {
        parent::__construct();
    }
    
    /**
     * Funcion para agregar paginas del documento al documento generado
     * 
     * @param String $documento => Nombre de la plantilla
     * @param Int $pagina => Pagina de la plantilla que desea importar en la nueva pagina del documento
     * @param String $ruta => Ruta en donde se encuentran alojadas las plantillas en el servidor (Default => uploads/plantillas/)
     */
    public function edPdfAddPage($documento, $pagina = 1, $ruta = 'uploads/plantillas/') {
        $this->AddPage();
        $this->setSourceFile($ruta . $documento);
        $tplIdx = $this->importPage($pagina);
        $this->useTemplate($tplIdx, null, null, null, null, true);
    }
    
    /**
     * Funcion para insertar el texto deseado en la plantilla PDF
     * 
     * @param String $texto => Texto a insertar
     * @param Int $x => Posicion en X
     * @param Int $y => Posicion en Y
     * @param String $style => Estilo de la letra puede usar BUI (siendo B => Negrita, U => subrayado, I => Italica)
     * @param Int $font_size => Tamaño de la fuente
     * @param String $family => Font family
     */
    function insertar($texto, $x, $y, $style = '', $font_size = 9, $family = 'Arial') {
        $this->SetFont($family, $style, $font_size);

        if(is_array($this->colorTexto) && count($this->colorTexto) == 3) {
            $this->SetTextColor($this->colorTexto[0], $this->colorTexto[1], $this->colorTexto[2]);
        } else {
            $this->SetTextColor(0, 255, 0);
        }
        $this->SetXY($x, $y);
        $this->Write(0, $texto);
    }
    
    /**
     * Funcion para insertar el texto deseado en la plantilla PDF
     * a traves de un MultiCell
     * 
     * @param String $texto => Texto a insertar
     * @param Int $x => Posicion en X
     * @param Int $y => Posicion en Y
     * @param Int $w => Ancho de celdas. Si 0, estos se extienden hasta l márgen derecha de la página.
     * @param Int $h => Alto de las celdas
     * @param String $a => Alineacion del texto puede usar LCRJ (Siendo L = izquierda, C= centrado, R = derecha, J = texto justificado [por defecto]) 
     * @param String $style => Estilo de la letra puede usar BUI (siendo B => Negrita, U => subrayado, I => Italica)
     * @param Int $font_size => Tamaño de la fuente
     * @param Boolean
     * @param String $family => Font family
     */
    function insertarCelda($texto, $x, $y, $w, $h, $a = 'J', $style = '', $font_size = 9, $fc = false, $family = 'Arial') {
        $fill = false;
        $this->SetFont($family, $style, $font_size);

        if(is_array($this->colorTexto) && count($this->colorTexto) == 3) {
            $this->SetTextColor($this->colorTexto[0], $this->colorTexto[1], $this->colorTexto[2]);
        } else {
            $this->SetTextColor(0, 255, 0);
        }
        
        if(is_array($this->colorFill) && count($this->colorFill) == 3 && $fc == true) {
            $this->SetFillColor($this->colorFill[0], $this->colorFill[1], $this->colorFill[2]);
            $fill = true;
        }
        
        $this->SetXY($x, $y);       
        $this->MultiCell($w, $h, $texto, 0, $a, $fill);
    }
    
    /**
     * Exportar PDF
     * 
     * @param String $nombre_documento => Nombre de la salida del documento
     * @param Char $destino => Destino de salida valores opcionales de fpdf (pueden ser I => ver en navegador, D => forzar descarga)
     */
    function generarPDF($nombre_documento, $destino) {
        $this->Output($nombre_documento, $destino);
    }
    
    /**
     * Funcion para descargar el documento (plantilla) en vacio en caso que se requira
     * 
     * @param String $documento => Nombre del documento con Extension (.pdf)
     * @param String $ruta => Ruta de la carpeta que contiene las plantillas (Default = uploads/plantillas/)
     */
    public function edPdfAddAllPages($documento, $ruta = 'uploads/plantillas/') {
        $cant = $this->setSourceFile($ruta . $documento);

        for ($i = 1; $i <= $cant; $i++) {
            $this->AddPage();
            $tplIdx = $this->importPage($i);
            $this->useTemplate($tplIdx, null, null, null, null, true);
        }
    }
    
    /**
     * Convertir de Hexadecimal a RGB
     * 
     * @param String/Array $hex => Color en formato hexadecimal
     */
    public function asignarColor($hex) {
        if(is_array($hex) && count($hex) == 3) {
            $rgb = $hex;
            
        } else {
            $hex = str_replace("#", "", $hex);
            if (strlen($hex) == 3) {
                $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
            } else {
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
            }
            $rgb = array($r, $g, $b);
        }
        
        $this->colorTexto = $rgb;
    }
    
    /**
     * Convertir de Hexadecimal a RGB
     * 
     * @param String/Array $hex => Color en formato hexadecimal
     */
    public function asignarFondo($hex) {
        if(is_array($hex) && count($hex) == 3) {
            $rgb = $hex;
            
        } else {
            $hex = str_replace("#", "", $hex);
            if (strlen($hex) == 3) {
                $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
                $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
                $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
            } else {
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
            }
            $rgb = array($r, $g, $b);
        }
        
        $this->colorFill = $rgb;
    }

}
