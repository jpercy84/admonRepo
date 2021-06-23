<?php
    error_reporting(0);
    include "core/modules/index/model/filterData.php";
    include "core/modules/index/model/FiltrosLogsData.php";
    include "core/modules/index/model/FiltrosLogsTableData.php";
    include "core/modules/index/model/FiltrosLogsCamposData.php";
    include "core/modules/index/model/FiltrosLogsVistaData.php";

    
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    if(!empty($_GET)){

        //GET tables to cross
        $table1 = $_GET['table1'];
        $table2 = $_GET['table2'];

        //$filtroGral = $_GET['filtroG'];

        //GET fields to pass in each table
        $fields1 = $_GET['fields1'];
        $fields2 = $_GET['fields2'];

        $tipofiltro = $_GET['tipofiltro'];
        //Option filter start with = 1, include = 2, end with = 3
        //$optionFilter = $_GET['optionFilter'];

        //Table to pass filter
        //$columnTable = $_GET['columnTable'];

        //Text to find in table
        //$text = $_GET['text'];

        //Action to check if exist a result
        if ($_GET['accion'] == 'checkFilterCross'){
          
                 $response = filterData::getCrossTablesDataAdvanced($table1, $table2, $fields1, $fields2, $columnTable, $optionFilter, $text, $optionFilter2, $text2, 'limit');
           
        }
        else{

               //echo 'esto'.$_GET['accion'].'ya';
             if($tipofiltro)
             {

               $filtrolog = new FiltrosLogsData();
                if($tipofiltro==1)
                {
                    $tfiltro = "Numerico";
                }  
                if($tipofiltro==2)
                {
                    $tfiltro = "Texto";
                }
                if($tipofiltro==3)
                {
                    $tfiltro = "Multiple";
                }  
                $filtrolog->tipo_filtro = $tfiltro;
                $filtrolog->usuario_query = Session::get("ID");
                $filtrolog->fecha_query = date('Y-m-d H:m:i');
                $u = $filtrolog->add();
                $codfiltrolog = $u[1];
               


                $filtrologTable = new FiltrosLogsTableData();
                $filtrologTable->FK_baq_logs_filtros =  $codfiltrolog;
                $filtrologTable->baq_nom_tables = $table1;
                $x = $filtrologTable->add();
                $codfiltrologtable1 = $x[1];

                $filtrologTable2 = new FiltrosLogsTableData();
                $filtrologTable2->FK_baq_logs_filtros =  $codfiltrolog;
                $filtrologTable2->baq_nom_tables = $table2;
                $x2 = $filtrologTable2->add();
                $codfiltrologtable2 = $x2[1];

                
                
                $camposnorm = explode(",", $_GET['camposf']);
                $k = 1;
                foreach($camposnorm as $rowColumnaNorm)
                {
                    
                  $filtrologCampo = new FiltrosLogsCamposData();
                  $filtrologCampo->FK_baq_logs_filtros_table =  $codfiltrologtable1;
                  $filtrologCampo->baq_nom_campo_normalizado = $rowColumnaNorm;
                  $filtrologCampo->filtro = "Igual a";
                  $filtrologCampo->campodato = $_GET['columnDatos'.$k];
                  $y = $filtrologCampo->add();
                  $codfiltrologcampo = $y[1];
                  $k++;
                }


                $fieldsp = explode(",", $fields1);
                $v = 1;
                foreach($fieldsp as $rowfields)
                {
                    
                  $campbusq =   explode("AS", $rowfields );
                  $rowfields = str_replace("`", "", $campbusq[1]);
                  $filtrologVista = new FiltrosLogsVistaData();
                  $filtrologVista->FK_baq_logs_filtros_table =  $codfiltrologtable1;
                  $filtrologVista->baq_nom_campos_normalizados = $rowfields;
                  $yv = $filtrologVista->add();
                  $filtrologVista = $yv[1];
                  $v++;
                }

                $fieldss = explode(",", $fields2);
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
                }
            }
           
             $response = filterData::getCrossTablesDataAdvanced($table1, $table2, $fields1, $fields2,'');
           
        }

        echo json_encode($response);
    }

?>