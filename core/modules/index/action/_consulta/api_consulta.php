<?php

include "core/modules/index/model/SolSisbenData.php";



  function listar_datos($doc,$tipo) {  
        $table= '';
        if($tipo==1)
        {
          $datos = SolSisbenData::getSolicitudByRadicado($doc);  
        }
        if($tipo==2)
        {
          $datos = SolSisbenData::getSolicitudByDocumento($doc);  
        }
        
           echo json_encode(array("table" => $datos));                

        
  }


  ?>