<?php
error_reporting(1);
use \Firebase\JWT\JWT;
include "core/modules/index/model/IclData.php"; 
require 'core/modules/index/action/phpoffice/vendor/autoload.php';

//ini_set( 'upload_max_filesize' , '1024M' ); este no sirve con ini_set
//ini_set( 'post_max_size', '500M'); tampoco sive con ini_set
ini_set( 'memory_limit', '4000M' );
ini_set( 'max_execution_time',  '3000');
//echo ini_get('memory_limit');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xls;



/*$cacheMethod = PHPExcel_CachedObjectStorageFactory:: cache_to_phpTemp;
    $cacheSettings =  array('memoryCacheSize' => '3600MB', 'cacheTime' => '3000');
    PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);
*/
  function listar_perfil($id) {  

    $perfil = PerfilData::getPerfiles($id);
    
         if($perfil!=null){

                
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
                           
            
            if(count($perfil)>0):
              $tableperfil = '';
              if($id==''){ //Mostrar Todos los perfiles
                   
                  foreach($perfil as $row):

                  $tableperfil .= '<tr id="cliente'.$row->idperfil.'">
                                <td>'.$row->idperfil.'</td>
                                <td>'.$row->nombre.'</td>
                                <td><button value="Consultar" title="Consultar" onclick="ver_perfil('.$row->idperfil.')" class="btn btn-primary">
                                <i class="fa fa-search-plus"></i></button>&nbsp;
                                <button value="Actualizar" title="Actualizar" onclick="actualizar_perfil('.$row->idperfil.')"  class="btn btn-default"><i class="fa fa-edit">
                                </i></button>&nbsp;<button value="Eliminar" onclick="eliminar_perfil('.$row->idperfil.')" title="Actualizar" class="btn btn-danger">
                                <i class="fa fa-trash"></i></button>
                                </td>
                            </tr>';
                  endforeach;  
                  
              }else{   ////Mostrar el detalle de un Perfil
                  foreach($perfil as $row):

                   $tableperfil  .= '<table id="datatable-perfil" class="table table-responsive" style="width:100%">
                  
                      <tr height="30">
                         
                        <td width="18%"><b>Id Perfil</b></td>
                        <td width="81%" colspan="2">'.$row->idperfil.'</td>
                        </tr>
                      <tr height="30">
                         
                        <td width="18%"><b>Nombre</b></td>
                          <td width="81%" colspan="2">'.$row->nombre.'</td>
                        </tr>
                      <tr height="30">
                          
                        <td width="18%"><b>Usuario Creación</b></td>
                          <td width="81%" colspan="2">'.$row->user.'</td>
                        </tr>
                      <tr /height="30">
                        
                        <td><b>Fecha Creación</b></td>
                        <td colspan="2">'.$row->fecha_creacion.'</td>
                       </tr>
                     </table>';
                 endforeach; 
              }   
              echo json_encode(array("tableperfil" => $tableperfil)); 
          endif;
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se encontraron perfiles registrados"));

    }
  }



  function ingresar_icl($tipo,$tamanio,$archivotmp,$nomarchivo) {  

    //$perfil = PerfilData::add($objperfil->nombre,);
    
         if($tipo!=null){


               $file_mimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');


                 if(isset($nomarchivo) && in_array($tipo, $file_mimes)) {
                    $arr_file = explode('.', $nomarchivo);
                    $extension = end($arr_file);

                     switch ($extension) {
                        case 'csv':
                           $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                        break;
                        case 'xlsx':
                         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                        break;
                        case 'xls':
                         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                        break;
                      }
     
    
                       $reader->setReadDataOnly(true); 
                       $reader->setLoadSheetsOnly('ICL'); 
                       $spreadsheet = $reader->load($archivotmp);
                       //$spreadsheet->setReadDataOnly(true);    
                       //$spreadsheet->setLoadSheetsOnly('spreadsheetname');  

                        $sheetData   = $spreadsheet->getSheetByName('ICL');
                       //$sheetData   = $spreadsheet->setLoadSheetsOnly('ICL');  
                        $data        = true;
                        $count       = 3;
                        while ($data) 
                        {
                              $dpto_nom = trim($sheetData->getCellByColumnAndRow(4, $count)->getValue());
                              $ciudad_mun     = $sheetData->getCellByColumnAndRow(5, $count)->getValue();
                              $edad       = $sheetData->getCellByColumnAndRow(7, $count)->getValue();
                              $sexo       = $sheetData->getCellByColumnAndRow(9, $count)->getValue();
                              $fuente_contagio      = $sheetData->getCellByColumnAndRow(10, $count)->getValue();
                              $ubicacion       = $sheetData->getCellByColumnAndRow(11, $count)->getValue();
                              $estado       = $sheetData->getCellByColumnAndRow(12, $count)->getValue();
                              $nacionalidad       = $sheetData->getCellByColumnAndRow(14, $count)->getValue();


                              $primer_nombre     = $sheetData->getCellByColumnAndRow(15, $count)->getValue();
                              $segundo_nombre     = $sheetData->getCellByColumnAndRow(16, $count)->getValue();
                              $primer_apellido     = $sheetData->getCellByColumnAndRow(17, $count)->getValue();
                              $segundo_apellido     = $sheetData->getCellByColumnAndRow(18, $count)->getValue();
                              $tipo_id     = $sheetData->getCellByColumnAndRow(19, $count)->getValue();
                              $num_documento     = $sheetData->getCellByColumnAndRow(20, $count)->getValue();
                              $fecha_muestram     = $sheetData->getCellByColumnAndRow(102, $count)->getValue();
                              
                              $fecha_muestra = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha_muestram);
                              $fecha_muestra = date_format($fecha_muestra, 'Y-m-d');                           
                              //$fecha_nacimiento = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha_nacimientom);


                              $fecha_resultadom    = $sheetData->getCellByColumnAndRow(103, $count)->getValue();
                              $fecha_resultado = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fecha_resultadom);
                              $fecha_resultado = date_format($fecha_resultado, 'Y-m-d'); 
                              $eapb     = $sheetData->getCellByColumnAndRow(105, $count)->getValue();
                              $direccion     = $sheetData->getCellByColumnAndRow(107, $count)->getValue();
                              $telefono     = $sheetData->getCellByColumnAndRow(108, $count)->getValue();
                              $resultado     = $sheetData->getCellByColumnAndRow(111, $count)->getValue();
//var_dump($dpto_nom);
 
             //var_dump($dpto_nom);
                                
                            if(empty($dpto_nom) || $dpto_nom == ''){
                               $data = false;

                            }else{
                       
               // echo json_encode(array("exito" => "guardado".$fecha_muestra)); 
        
                            $crue = new IclData();
                            $crue->nombre_dpto = $dpto_nom;
                            $crue->FK_BAQ_MUNICIPIO_SISBEN = $ciudad_mun;
                            $crue->edad = $edad;
                            $crue->sexo = $sexo;
                            $crue->fuente_tipo_contagio = $fuente_contagio;
                            $crue->ubicacion = $ubicacion;
                            $crue->estado = $estado;
                            $crue->nacionalidad_nom = $nacionalidad;
                            $crue->nombre1 = $primer_nombre;
                            $crue->nombre2 = $segundo_nombre;
                            $crue->apellido1 = $primer_apellido;
                            $crue->apellido2 = $segundo_apellido;
                            $crue->tipo_id = $tipo_id;
                            $crue->numero_documento = $num_documento;
                            $crue->fecha_muestra = $fecha_muestra;
//$crue->fecha_muestra = "2020-10-14";
                            $crue->fecha_resultado = $fecha_resultado;
                            $crue->eapb = $eapb;
                            $crue->direccion = $direccion;  
                            $crue->telefono = $telefono;  
                            $crue->resultado = $resultado;  
                            $crue->borrado = 0;
                            $crue->fecha_creacion = date('Y-m-d H:m:i');
                            $crue->usuario_creacion=1;

                            
          
                         $u = $crue->add();
                         //$idsisben = $u[1];
                         //echo "<br>";
                         $count++;
                        //echo json_encode(array("exito" => "guardados".$u));

                      }

                    }
                   


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
                   "menu" => $crue
                ));

                http_response_code(200);

                $jwt = JWT::encode($token, $secret_key);
                               
               

            
                
             echo json_encode(array("exito" => "guardado")); 
        }      
        
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se pudo registrar el archivo"));

    }
  }


function modificar_perfil($objperfil) {  

    
         if($objperfil!=null){

                
               $perfil = new PerfilData();
               $perfil->PK_baq_perfiles = $objperfil->idperfil;
               $perfil->nombre = $objperfil->perfil;
               $perfil->borrado = 0;
               $perfil->fecha_actualizacion = date('Y-m-d H:m:i');
               $perfil->usuario_actualizacion = 1;
          
          
               $u = $perfil->update();
               
               $list ="\"\"";
                foreach ($objperfil->opcionmenu as $clave => $valor) :
                   //echo '<p>', htmlspecialchars( $valor), '</p>', PHP_EOL;
                   $menuperfil = PerfilSubmenuData::getPerfilSubMenu($objperfil->idperfil,$valor); 
                   if(!$menuperfil)
                   {
                       //echo json_encode(array("exito" => " nooooo guardado")); 
                       $perfil = new PerfilSubmenuData();
                       $perfil->FK_BAQ_SUBMENUS = $valor;
                       $perfil->FK_BAQ_PERFILES = $objperfil->idperfil;
                       $perfil->borrado = 0;
                       $perfil->fecha_creacion = date('Y-m-d H:m:i');
                       $perfil->usuario_creacion = 1;
                       $u = $perfil->add();

                    } 
               endforeach;

               $list = implode(",",$objperfil->opcionmenu);
               
               $mperfilnotin = PerfilSubmenuData::getPerfilSubmenuNotIn($objperfil->idperfil,$list); 
               foreach ($mperfilnotin as $row_submenu) :

                  if($row_submenu!=''){

                       $perfil = new PerfilSubmenuData();
                       $perfil->FK_BAQ_SUBMENUS=$row_submenu->idsubmenu;
                       $perfil->FK_BAQ_PERFILES=$objperfil->idperfil;
                       $perfil->borrado = 1;
                       $perfil->fecha_eliminacion = date('Y-m-d H:m:i');
                       $perfil->usuario_eliminacion = 1;
                       $u = $perfil->delete();

                  }

               endforeach;


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
                               
               

            
                
              echo json_encode(array("exito" => "guardado")); 
        
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se encontraron perfiles registrados"));

    }
  }



  function eliminar_perfil($objperfil) {  

    
         if($objperfil!=null){

                
               $perfil = new PerfilData();
               $perfil->PK_baq_perfiles = $objperfil->idperfil;
               $perfil->borrado = 1;
               $perfil->fecha_eliminacion = date('Y-m-d H:m:i');
               $perfil->usuario_eliminacion = 1;
          
          
               $u = $perfil->delete();
               
               
               
               
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
                               
               

            
                
              echo json_encode(array("exito" => "eliminado")); 
        
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se encontraron perfiles registrados"));

    }
  }


  ?>