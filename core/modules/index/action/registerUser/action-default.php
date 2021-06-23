<?php
    include "core/modules/index/model/baqUsers.php";

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_POST)){
        if($_POST["p_nombre"] != "" &&  $_POST["p_apellido"] != "" && $_POST["sexo"] != ""
        && $_POST["email"] != "" && $_POST["password"] != "" && $_POST["perfil"] != "" ){
            $responseEmail = baqUsers::checkEmail($_POST["email"]);
            if ($responseEmail[0]->num_rows != 0){
                http_response_code(400);
                echo json_encode(
                    array(
                        "error" => "Email ya registrado",

                    ));
            }
            else {
                $responseUsers = baqUsers::createUser($_POST["p_nombre"],
                $_POST["s_nombre"], $_POST["p_apellido"], $_POST["s_apellido"],
                $_POST["sexo"]);       
                $responseLogins = baqUsers::createLogin($responseUsers[1], $_POST["email"], $_POST["password"]);
                $responsePerfil = baqUsers::createPerfil($responseUsers[1], $_POST["perfil"]);
                http_response_code(200);
                echo json_encode(
                    array(
                        "message" => "Usuario agregado correctamente.",
                        "error" => "",
                    ));
            }
        }
        else{
        Core::alert("Datos vacios");
        Core::redir("./");
        }
        
    
    
    }

    
?>