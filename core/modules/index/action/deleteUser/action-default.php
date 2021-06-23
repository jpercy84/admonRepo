<?php
    include "core/modules/index/model/baqUsers.php";

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_POST)){
        $response = baqUsers::deleteUser($_POST["email"]);
        echo json_encode(
            array(
                "message" => "Usuario agregado correctamente.",
                "error" => "",
            ));

    }

    
?>