<?php
    include "core/modules/index/model/searchDocument.php";
    include "core/modules/index/model/FiltrosLogsData.php";
    include "core/modules/index/model/FiltrosLogsTableData.php";
    include "core/modules/index/model/FiltrosLogsCamposData.php";
    include "core/modules/index/model/FiltrosLogsVistaData.php";
    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_POST)){



                //$tipofiltro = $_GET['tipofiltro'];
                //$camposnorm = $_GET['camposf'];

          
                $filtrolog = new FiltrosLogsData();
               
                $tfiltro = "Cruzar por documento";
                
                if($_POST["switche"]==1)
                {

                 $filtrolog->tipo_filtro = $tfiltro;
                 $filtrolog->usuario_query = Session::get("ID");
                 $filtrolog->fecha_query = date('Y-m-d H:m:i');
                 $u = $filtrolog->add();
                 $codfiltrolog = $u[1];
                 Session::set("codfiltrolog", $codfiltrolog);
               }

                $codfiltrolog = Session::get("codfiltrolog");


                $filtrologTable = new FiltrosLogsTableData();
                $filtrologTable->FK_baq_logs_filtros =  $codfiltrolog;
                $filtrologTable->baq_nom_tables = $_POST["table"];
                $x = $filtrologTable->add();
                $codfiltrologtable1 = $x[1];

                
                
               
                $filtro = 'Documento igual a';
                  



                
                  
                  $filtrologCampo = new FiltrosLogsCamposData();
                  $filtrologCampo->FK_baq_logs_filtros_table =  $codfiltrologtable1;
                  $filtrologCampo->baq_nom_campo_normalizado = 'Numero de documento';
                  $filtrologCampo->filtro = $filtro;
                  $filtrologCampo->campodato = $_POST["ID"];
                  $y = $filtrologCampo->add();
                  $codfiltrologcampo = $y[1];

              



                $fieldsp = explode(",", $_POST["fields"]);
                //echo $fieldsp;
                $v = 1;
                foreach($fieldsp as $rowfields)
                {
                    
                  //$campbusq =   explode("AS", $rowfields );
                  //$rowfields = str_replace("`", "", $campbusq[1]);
                  $filtrologVista = new FiltrosLogsVistaData();
                  $filtrologVista->FK_baq_logs_filtros_table =  $codfiltrologtable1;
                  $filtrologVista->baq_nom_campos_normalizados = $rowfields;
                  $yv = $filtrologVista->add();
                  $filtrologVista = $yv[1];
                  $v++;
                }

                /*$fieldss = explode(",", $fields2);
                $l = 1;
                foreach($fieldss as $rowfields2)
                {
                    
                  $campbusq2 =   explode("AS", $rowfields2 );
                  $rowfields2 = str_replace("`", "", $campbusq2[1]);  
                  $filtrologVista2 = new FiltrosLogsVistaData();
                  $filtrologVista2->FK_baq_logs_filtros_table =  $codfiltrologtable2;
                  $filtrologVista2->baq_nom_campos_normalizados = $rowfields2;
                  $yv = $filtrologVista2->add();
                  $filtrologVista2 = $yv[1];
                  $l++;
                }*/
         






        $data = baqSearch::searchID($_POST["ID"], $_POST["fields"], $_POST["table"]);
        echo json_encode($data);
//        echo json_encode(mysqli_fetch_object($data));
    }

?>