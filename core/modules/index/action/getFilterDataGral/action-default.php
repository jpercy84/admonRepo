<?php
    include "core/modules/index/model/searchDocument.php";
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_POST)){

        $data = baqSearch::searchID($_POST["ID"], $_POST["fields"], $_POST["table"]);
        echo json_encode($data);
//        echo json_encode(mysqli_fetch_object($data));
    }

?>