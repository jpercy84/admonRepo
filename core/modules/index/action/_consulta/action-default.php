<?php

//error_reporting(0);
include_once "core/modules/index/action/_consulta/api_consulta.php";
/**
* Proceso de login
**/ 


if(!empty($_POST)){

   $doc = $_POST["doc"];  
   $tipoBusqueda = $_POST["tipoBusqueda"];  

   listar_datos($doc,$tipoBusqueda);


  
}


?>

