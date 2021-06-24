<?php
    include "core/modules/index/model/searchDocument.php";
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_POST)){

        $exists = baqSearch::checkID($_POST["id"], $_POST["table"]);

        echo json_encode(
            array(
                "exist" => $exists[0]->num_rows,
                "table" => $_POST["table"],
                "ID" => $_POST["id"]
            ));
    }

?>