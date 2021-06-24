<?php
    include "core/modules/index/model/searchDocument.php";
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_POST)){
        //$ruta = $_POST["ruta"];
        $response = baqSearch::getDatosColumns($_POST["campo"],$_POST["tabla"]);
        echo json_encode($response); 
     }
?>