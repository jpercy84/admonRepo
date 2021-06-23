<?php
    include "core/modules/index/model/baqUsers.php";
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_POST)){
        $id = baqUsers::getID($_POST["savedEmail"]);
        $updateUsers = baqUsers::updateBaqUsers($id, $_POST["pNombre"], $_POST["sNombre"],
                    $_POST["pApellido"], $_POST["sApellido"], $_POST["sexo"]);
        $updateLogins = baqUsers::updateBaqLogins($id, $_POST["email"]);
        $updatePerfil = baqUsers::updateBaqPerfilesUsuarios($id, $_POST["perfil"]);
        echo json_encode (
            array(
                "update user" => $updateUsers,
                "update login" => $updateLogins,
                "update Perfil" => $updatePerfil
            )
        );        
    }

?>