<?php
error_reporting(0);
ini_set( 'memory_limit', '4000M' );
ini_set( 'max_execution_time',  '3000');
use \Firebase\JWT\JWT;

require_once 'spoutmaster/src/Spout/Autoloader/autoload.php';
global $pathJSON;
global $pathPython;
$pathJSON ='/var/www/baq60project/appbaq60/core/modules/index/action/_repo/descargas/pythonJSON.json';
$pathPython = 'python3  /var/www/baq60project/pythonScripts/repoDatabase.py';


use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;

  function listar() {  
    include "core/modules/index/model/camposNormalizadosData.php"; 
    $res = [];
 
    $campos = camposNormalizadosData::getCamposNormalizados();
 
         if($campos!=null){

                 
                           
            
            if(count($campos)>0):
              $tablecampos = '';
              
                   while ($rw = mysqli_fetch_assoc($campos)) {
                       $res[] = $rw;
                   }

                  
                 echo  json_encode($res,JSON_UNESCAPED_UNICODE);
                   



          endif;
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se encontraron perfiles registrados"));

    }
  }



function ingresar_repo($tipo,$tamanio,$archivotmp,$nomarchivo) {  

    //$perfil = PerfilData::add($objperfil->nombre,);
    
if($tipo!=null){

 
             


$reader = ReaderEntityFactory::createXLSXReader();
 $reader->setShouldFormatDates(true);

//$archivo = 'pruebaicl.xlsx';
//$filePath = 'core/modules/index/action/_icl/descargas/'.$archivo;
$filePath = $archivotmp;
$reader->open($filePath);
$count = 1;
$data=array();
$j=0;
foreach ($reader->getSheetIterator() as $sheet) {
   if ($sheet->getName() === 'Hoja1') {
     

   $titulo = [];
    foreach ($sheet->getRowIterator() as $row) {
        
      $i=0;
      if($count == 1) {
        for ($i<=0;$i<=200;$i++){
               
             $cells = $row->getCells();
             
             $Celltitulo = $cells[$i]; 
             //var_dump($Celltitulo);
             if($Celltitulo){
             if(empty($Celltitulo->getValue()))
             {
              $i=200;
              break;
                //echo $Celltitulo->getValue();
             }else{
                $j+=1;
                $titulo[] = $Celltitulo->getValue();
               
             }
           }
        }
       


      }else{
        break;
        //exit();
      }
      $count++; 
        
    }
  }else{
    echo json_encode(array("message" =>'Hoja no encontrada')); 
    exit();
    //break;
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
                   "menu" => $nomarchivo
                ));

                http_response_code(200);
 
                $jwt = JWT::encode($token, $secret_key);
 
                echo json_encode(array("message" =>'r',"cantidad" =>$j ,"titulos" => $titulo,"archivo" => $archivotmp)); 
                //echo json_encode($titulo);
          
        
    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se pudo registrar el archivo"));

    }
  }
  function convertir_ascii($cadena){

         $unwanted_array = array('Á'=>'&Aacute;', 'É'=>'&Eacute;', 'Í'=>'&Iacute;', 'Ñ'=>'&Ntilde;', 'Ó'=>'&Oacute;',
                                    'Ú'=>'&Uacute;','Ü'=>'&Uuml;', 'á'=>'&aacute;', 'é'=>'&eacute;', 'í'=>'&iacute;',
                                    'ñ'=>'&ntile;', 'ó'=>'&oacute;', 'ú'=>'&uacute;',  'ü'=>'&uuml;' );
            $str = strtr( $cadena, $unwanted_array );
            return $str;

   }

function eliminar_acentos($cadena){
    
    //Reemplazamos la A y a
    $cadena = str_replace(
    array('Á', 'À', 'Â', 'Ä', 'á', 'à', 'ä', 'â', 'ª'),
    array('A', 'A', 'A', 'A', 'a', 'a', 'a', 'a', 'a'),
    $cadena
    );
 
    //Reemplazamos la E y e
    $cadena = str_replace(
    array('É', 'È', 'Ê', 'Ë', 'é', 'è', 'ë', 'ê'),
    array('E', 'E', 'E', 'E', 'e', 'e', 'e', 'e'),
    $cadena );
 
    //Reemplazamos la I y i
    $cadena = str_replace(
    array('Í', 'Ì', 'Ï', 'Î', 'í', 'ì', 'ï', 'î'),
    array('I', 'I', 'I', 'I', 'i', 'i', 'i', 'i'),
    $cadena );
 
    //Reemplazamos la O y o
    $cadena = str_replace(
    array('Ó', 'Ò', 'Ö', 'Ô', 'ó', 'ò', 'ö', 'ô'),
    array('O', 'O', 'O', 'O', 'o', 'o', 'o', 'o'),
    $cadena );
 
    //Reemplazamos la U y u
    $cadena = str_replace(
    array('Ú', 'Ù', 'Û', 'Ü', 'ú', 'ù', 'ü', 'û'),
    array('U', 'U', 'U', 'U', 'u', 'u', 'u', 'u'),
    $cadena );
 
    //Reemplazamos la N, n, C y c
    $cadena = str_replace(
    array('Ñ', 'ñ', 'Ç', 'ç'),
    array('N', 'n', 'C', 'c'),
    $cadena
    );
    
    return $cadena;
  }


function insertar_repo($objcampos){
  include "core/modules/index/model/camposNormalizadosData.php"; 
  include "core/modules/index/model/TablesData.php"; 
  include "core/modules/index/model/CamposFiltroData.php";
  include "core/modules/index/model/baqUsers.php";

    //$perfil = PerfilData::add($objperfil->nombre,);
    $r=''; 
    if($objcampos!=null){
      $nom_tabla = $objcampos->nom_tabla;
      $nombre_tablai = $nom_tabla;
      $nombre_tabla = eliminar_acentos(strtoupper(str_replace(' ','_',$nom_tabla))); 

      $table = new TablesData();
      $table->nombreTabla = 'BAQ_'.$nombre_tabla; 
      $table->fecha_creacion = date('Y-m-d H:m:i'); 

//Creation query variables
      $email = Session::get("email");
      $id = baqUsers::getID($email);
      $queryP1 = 'INSERT INTO BAQ_'. $nombre_tabla . ' (usuario_creacion, fecha_creacion, borrado, ';
      $queryP2 = '';
      $queryP3 = ') VALUES ('.$id.', \'' . date('Y-m-d H:m:i') . '\', 0,';
      $queryP4 = '';
      $queryP5 = ')';
//Crection columns excel array
      $excelColNums = [];
      $numExcelCol = 0;
      $flagCols = 0;
//Creation excel columns names array
      $excelColNames = [];
      $table->usuario_creacion = $id; 


               
               $u = $table->add();
               $idtable = $u[1];

               $camposFiltro = new CamposFiltroData();
                            

               $newtable = new camposNormalizadosData();
               $y = $newtable->nuevo('BAQ_'.$nombre_tabla); 
               
              foreach ($objcampos->opcioncampo as $clave => $valor) :
                     $valor_inicial = $valor;

                     if($valor!='' && $valor!=$nombre_tablai){
                          array_push($excelColNums, $numExcelCol);
                          array_push($excelColNames, $objcampos->camposExcel[$numExcelCol]);
                          $campon = camposNormalizadosData::getCampo(convertir_ascii($valor)); 
                          $f = convertir_ascii($valor);
                          
                         if($campon!=''){ //El campo ya se encuentra registrado en la tabla de normalizados
                            
                            $valor = $campon->nombreCampo;
                            $idcamponormalizado = $campon->PK_baq_campos_normalizados;
                            $camposFiltro->FK_baq_tables = $idtable;               
                            $camposFiltro->FK_baq_campos_normalizados = $idcamponormalizado;
                            $q = $camposFiltro->add();
                            

                         }else{// no se encuentra, hay que formatear el dato e ingresar en la tabla normalizados
                           $valor = eliminar_acentos(strtolower(str_replace(' ','_',$valor))); 
                           $response = $newtable->add($valor, convertir_ascii($valor_inicial));
                           $idcamponormalizado =  $response[1];
                           

 

                           $camposFiltro->FK_baq_tables = $idtable;               
                           $camposFiltro->FK_baq_campos_normalizados = $idcamponormalizado;
                           $q = $camposFiltro->add();
                         
                         }
//FILL QUERY VARIABLES
                      if ($flagCols != 0){
                        $queryP2 .= ", ";
                        $queryP4 .= ", "; 
                      }
                        $queryP2 .= $valor;
                        $queryP4 .= "%s"; 
                        $flagCols += 1;

//
                         $a = $newtable->agregar('BAQ_'.$nombre_tabla,$valor,'varchar(200)'); 
                      }
                $numExcelCol += 1;
               endforeach;
               
               $queryP1 .= $queryP2 .= $queryP3 .= $queryP4 .= $queryP5;
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
                   "menu" => $nomarchivo
                ));


                $jwt = JWT::encode($token, $secret_key);
 
                $dataToPython = array(
                    "nameTable" =>$nombre_tabla,
                    "query" =>$queryP1,
                    "colNums" => $excelColNums,
                    "colNames" =>$excelColNames
                );
                global $pathJSON;
                global $pathPython;
                $jsonToPython = json_encode($dataToPython);

                file_put_contents($pathJSON, $jsonToPython);
                $resultPython = shell_exec($pathPython);
                if($resultPython != "Success"){
                  http_response_code(500);
                  echo json_encode(array("message" => $resultPython));
                  return;
               }

               http_response_code(200);
               echo json_encode(array("id_table" => $u));

    }else{
        http_response_code(401);
        echo json_encode(array("message" => "No se pudo registrar el archivo"));

    }
  }






  ?>
