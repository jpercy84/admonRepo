<?php
//require_once 'phpoffice/PhpSpreadsheet/IOFactory.php';
//ob_start();
error_reporting(0);
header('Cache-Control: max-age=0');



/*
include "core/modules/index/model/IclData.php"; 


require_once 'spoutmaster/src/Spout/Autoloader/autoload.php';

use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

 use Box\Spout\Reader\ReaderFactory;  
 use Box\Spout\Common\Type;
*/
   

//session_start();
//if ($_SESSION['newsession'] == false and $_SESSION['TypeUser'] == 'Admin' ){


function fragmentar_archivo($tmp_name,$size,$name,$name2){


$target_path = "core/modules/index/action/_upload/descargas/";
$tmp_name = $_FILES['fileToUpload']['tmp_name'];
$size = $_FILES['fileToUpload']['size'];
$name = $_FILES['fileToUpload']['name'];
$name2 = $_POST['filename'];

$target_file = $target_path.$name;

$complete =$target_path.$name2;


$com = fopen($complete, "ab");

error_log($target_path);


$nombre_extension = explode('.', basename($name2));
    // Obtenemos la extensión
    $extension=array_pop($nombre_extension);
    // Obtenemos el nombre
    $nombre=array_pop($nombre_extension);


      $in = fopen($tmp_name, "rb");
       if ( $in ) {
        
           while ( $buff = fread( $in, 1048576 ) ) {
              // fwrite($out, $buff);
             fwrite($com, $buff); 
            //var_dump($tmp_name);
            
           }  
       }
       fclose($in);


fclose($com);
}



function ingresar_icl($archivo) { 



 $secret_key = "YOUR_SECRET_KEY";
                $issuer_claim = "THE_ISSUER"; // this can be the servername
                $audience_claim = "THE_AUDIENCE";
                $issuedat_claim = time(); // issued at
                $notbefore_claim = $issuedat_claim + 10; //not before in seconds
                $expire_claim = $issuedat_claim + 60; // expire time in seconds
                $token = array(
                   "iss" => $issuer_claim,
                   "aud" => $audience_claim,
                   "iat" => $issuedat_claim,
                   "nbf" => $notbefore_claim,
                   "exp" => $expire_claim,
                   "data" => array(
                   "menu" => $perfil
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);


 
$reader = ReaderEntityFactory::createXLSXReader();
//$reader = ReaderEntityFactory::createReaderFromFile('pruebaicl.xlsx');
$archivo = $_POST['fileToUpload'];
$filePath = 'core/modules/index/action/_icl/descargas/'.$archivo;
$reader->open($filePath);
$count = 1;
$data=array();
 
foreach ($reader->getSheetIterator() as $sheet) {
   if ($sheet->getName() === 'ICL') {
     

   
    foreach ($sheet->getRowIterator() as $row) {
        // do stuff with the row
      //$count = 2;
      if($count > 2) {
       $cells = $row->getCells();
$CellnomDpto = $cells[3]; // 4 because first column is at index 0.
$dpto_nom = $CellnomDpto->getValue();
$ciudad_mun = '08001';
 $edad = '25';
                      
//echo $email;

                           $crue = new IclData();
                            $crue->nombre_dpto = $dpto_nom;
                            $crue->FK_BAQ_MUNICIPIO_SISBEN = $ciudad_mun;
                            $crue->edad = $edad;
                             $crue->sexo = 'M';
                            $crue->fuente_tipo_contagio = 'Casa';
                            $crue->ubicacion = 'CAsa';
                            $crue->estado = 'leve';
                            $crue->nacionalidad_nom = 'colombiana';
                            $crue->nombre1 = 'pedro';
                            $crue->nombre2 = 'juan';
                            $crue->apellido1 = 'perez';
                            $crue->apellido2 = 'nada';
                            $crue->tipo_id = 'n';
                            $crue->numero_documento = '232343432';
                            $crue->fecha_muestra = '2010-04-01';
//$crue->fecha_muestra = "2020-10-14";
                            $crue->fecha_resultado = '2014-01-25';
                            $crue->eapb = 'pe';
                            $crue->direccion = 'dfd';  
                            $crue->telefono = '3333333';  
                            $crue->resultado = 'ok'; 
                            $crue->borrado = 0;
                            $crue->fecha_creacion = date('Y-m-d H:m:i');
                            $crue->usuario_creacion=1;

                            
          
                         $u = $crue->add();


      }
      $count++;
      
      //echo($rowAsArray);
        
    }
  }
}

$reader->close();
//var_dump($data);
}
?>