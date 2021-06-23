<?php
ini_set('display_errors', 1);
error_reporting(1);


ini_set( 'upload_max_size' , '256M' );
ini_set( 'upload_max_filesize' , '256M' );
ini_set( 'post_max_size', '256M');
ini_set( 'memory_limit', '2058M' );
ini_set( 'max_execution_time',  '300');



include_once "core/modules/index/action/_repo/api_repo.php";


if(!empty($_POST)){



$accion = $_POST["accion"];  
if($accion==null){
    $data = json_decode(file_get_contents("php://input"));  
    $accion = $data->accion;
}



switch ($accion) {

    case 'ingresar':  //COPIADO TEMPORAL DEL ARCHIVO AL SERVIDOR



        $data = json_decode(file_get_contents("php://input"));
        $tipo = $_FILES['archivo']['type'];
        $tamanio = $_FILES['archivo']['size'];
        $archivotmp = $_FILES['archivo']['tmp_name'];
        $nomarchivo = $_FILES['archivo']['name'];
        $ruta_destino_archivo = "core/modules/index/action/_repo/descargas/";
        unlink('core/modules/index/action/_repo/descargas/'.'repositorio.xlsx');
        if (copy ($_FILES['archivo']['tmp_name'], "core/modules/index/action/_repo/descargas/".'repositorio.xlsx')) 
        {
              ingresar_repo($tipo,$tamanio,$archivotmp,$nomarchivo);

        }else{
           echo json_encode(array("message" => "No se pudo registrar el archivo"));
        }
        
        break;
    case 'consultar_normalizados':
    
        listar();

        break;
    case 'insertar':
        insertar_repo($data);
        break;
    default:
        # code...
        break;
}




  
  //if($data->accion!=''){
  
}


?>

