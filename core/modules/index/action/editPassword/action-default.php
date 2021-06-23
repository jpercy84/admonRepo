<?php
    include "core/modules/index/model/baqUsers.php";
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_POST)){
        $id = baqUsers::getID($_POST["email"]);
        //print_r($id);
        $email =  Session::get("email");
        $response = baqUsers::getUserInfo("jose@caro.co");
        $infos = mysqli_fetch_array($response,MYSQLI_ASSOC);
        print_r($infos);
        print($infos["email"]);
    }
?>