<?php

//error_reporting(0);
include_once "core/modules/index/action/_adminmenu/api_menu.php";
/**
* Proceso de login
**/ 

header("Access-Control-Allow-Origin: *");

header("Content-Type", "application/x-www-form-urlencoded", true);
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if(!empty($_POST)){

$data = json_decode(file_get_contents("php://input"));  
$accion = $data->accion;

switch ($accion) {
    case 'consultagral':
        $idmenu='';
        listar_menu($idmenu);
        break;
    case 'ingresar':
        ingresar_perfil($data);
        break;
    case 'consulta':
        $idmenu=$data->idmenu;
        listar_menu($idmenu);
        break;
    case 'consultasubmenu':
        listar_submenu();
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

