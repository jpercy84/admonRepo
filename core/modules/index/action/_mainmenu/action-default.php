<?php

error_reporting(0);
//use \Firebase\JWT\JWT;
include_once "core/modules/index/action/_mainmenu/api_menu.php";


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
        
        case 'consulta':
            $tipo = $data->tipo;
            if ($tipo=="menuuser")
            {
              $email = Session::get("email");
              $campobusqueda = $email;
            }
            if($tipo=="menu")
            {
              $email = $data->email;
              $campobusqueda = $email;
            }
            if($tipo=="menuperfil")
            {
              $idperfil = $data->perfil;
              $campobusqueda = $idperfil; 
            }
            listar_menu($campobusqueda,$tipo);//Buscar menu por email de usuario
            break;
        case 'consultaxperfil':
            $tipo = $data->tipo;
            $idperfil = $data->perfil;
            $campobusqueda = $idperfil;
            //echo json_encode(array("message" => "Probar variable.".$email));
            listar_menu($campobusqueda,$tipo);//Buscar menu por perfil 
            break;
            
        default:
            # code...
            break;
    }

}

?>

