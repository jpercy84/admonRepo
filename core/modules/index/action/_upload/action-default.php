<?php
error_reporting(1);
//header('Cache-Control: max-age=0');


  
//ini_set( 'memory_limit', '4000M' );
//ini_set( 'max_execution_time',  '3000');
//ini_set( 'upload_max_size' , '256M' );
//ini_set( 'upload_max_filesize' , '256M' );
//ini_set( 'post_max_size', '256M');
ini_set( 'upload_max_size' , '500M' );
ini_set( 'upload_max_filesize' , '500M' );
ini_set( 'post_max_size', '500M');
ini_set( 'memory_limit', '500M' );
ini_set( 'max_execution_time',  '300000');



//error_reporting(0);
//include_once "core/modules/index/action/_icl/api_icl.php";
include_once "core/modules/index/action/_upload/fragmentar.php";



header("Access-Control-Allow-Origin: *");

//header("Content-Type", "application/x-www-form-urlencoded", true);
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if(!empty($_POST)){


//$data = json_decode(file_get_contents("php://input"));
$accion = $_POST["accion"]; 
//$tipo = $_FILES['archivo']['type'];
//$tamanio = $_FILES['archivo']['size'];
//$archivotmp = $_FILES['archivo']['tmp_name'];
//$nomarchivo = $_FILES['archivo']['name'];
//$accion = $data->accion;

switch ($accion) {
    case 'consultagral':
        $idperfil='';
        listar_perfil($idperfil);
        break;
    case 'ingresarbd':
        $archivo = $_POST['fileToUpload'];
        ingresar_icl($archivo);
        break;
    case 'fragmentar':
        $tmp_name = $_FILES['fileToUpload']['tmp_name'];
        $size = $_FILES['fileToUpload']['size'];
        $name = $_FILES['fileToUpload']['name'];
        $name2 = $_POST['filename'];
        fragmentar_archivo($tmp_name,$size,$name,$name2);
        break;
    case 'modificar':
        modificar_perfil($data);
        break;
    case 'eliminar':
        eliminar_perfil($data);
        break;
    default:
        # code...
        break;
}




  
  //if($data->accion!=''){
  
}


?>

