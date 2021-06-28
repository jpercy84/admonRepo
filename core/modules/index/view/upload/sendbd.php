<?php
//error_reporting(0);
include "./res/referencias.php";
ini_set( 'memory_limit', '4000M' );
ini_set( 'max_execution_time',  '3000');
include "core/modules/index/model/SolSisbenData.php"; 


require_once 'spoutmaster/src/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

 //use Box\Spout\Reader\ReaderFactory;  
 //use Box\Spout\Common\Type;



 
$reader = ReaderEntityFactory::createXLSXReader();
 $reader->setShouldFormatDates(true);

$archivo = $_POST['fileToUpload'];
$filePath = 'core/modules/index/action/_upload/descargas/'.$archivo;
//echo $archivo;
//var_dump($archivo);
$reader->open($filePath);
$count = 1;
$data=array();

foreach ($reader->getSheetIterator() as $sheet) {
   if ($sheet->getName() === 'Hoja1') {
   
   $sol= new SolSisbenData();  
  $u = $sol->delete(); 


   
    foreach ($sheet->getRowIterator() as $row) {
        // do stuff with the row
      //$count = 2;
      if($count > 1) {
       $cells = $row->getCells();
       $CellRadicado = $cells[0]; // 4 because first column is at index 0.
       $radicado = $CellRadicado->getValue();
       $CellPrimerNombre = $cells[2];
       $pnombre = $CellPrimerNombre->getValue();
       $CellSegundoNombre = $cells[3]; // 4 because first column is at index 0.
       $snombre = $CellSegundoNombre->getValue();
       $CellPrimerApellido = $cells[4]; // 4 because first column is at index 0.
       $papellido = $CellPrimerApellido->getValue();
       $CellSegundoApellido = $cells[5]; // 4 because first column is at index 0.
       $sapellido = $CellSegundoApellido->getValue();
       $CellDcoumento = $cells[11]; // 4 because first column is at index 0.
       $documento = $CellDcoumento->getValue();
       $CellTipoTramite = $cells[16]; // 4 because first column is at index 0.
       $tipotramite = $CellTipoTramite->getValue();
       $CellEstadoTramite = $cells[224]; // 4 because first column is at index 0.
       $estadotramite = $CellEstadoTramite->getValue();
       
       $CellObservacion = $cells[229]; // 4 because first column is at index 0.
       $observacion = $CellObservacion->getValue();
       


                            $solicitud = new SolSisbenData();
                            $solicitud->radicado = $radicado;
                            $solicitud->documento = $documento;
                            $solicitud->primer_nombre = $pnombre;
                            $solicitud->segundo_nombre = $snombre;
                            $solicitud->primer_apellido = $papellido;
                            $solicitud->segundo_apellido = $sapellido;
                            $solicitud->tipo_tramite = $tipotramite;
                            $solicitud->estado_tramite = $estadotramite;
                            $solicitud->observaciones = $observacion;
                            
                            
          
                            
                            $u = $solicitud->add();



      }
      $count++;
      
      
        
    }
  }
}

$reader->close();
unlink('core/modules/index/action/_upload/descargas/'.$archivo);
//echo 'fdfdf';

//var_dump($data);
?>