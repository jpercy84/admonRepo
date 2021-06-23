<?php
    include "core/modules/index/model/searchDocument.php";
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_GET)){
        $response = baqSearch::getNormalizeFields();
        echo json_encode($response);        
    }

?>