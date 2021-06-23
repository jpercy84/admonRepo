<?php
    include "core/modules/index/model/filterData.php";
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_GET)){
        $table = $_GET['table'];
        $optionFilter = $_GET['optionFilter'];
        $columnTable = $_GET['columnTable'];
        $text = $_GET['text'];
        $response = filterData::getFilterTables($table, $optionFilter, $columnTable, $text);
        echo json_encode($response);  
    }

?>