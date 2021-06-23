<?php

//error_reporting(0);
include_once "core/modules/index/action/_logs/api_logs.php";


if(!empty($_POST)){

$data = json_decode(file_get_contents("php://input"));  
$accion = $data->accion;

switch ($accion) {
    case 'consultagral':
        $idperfil='';
        listar_perfil($idperfil);
        break;
    case 'ingresar':
        ingresar_perfil($data);
        break;
    case 'consulta':
        listar_log();
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

}


?>

