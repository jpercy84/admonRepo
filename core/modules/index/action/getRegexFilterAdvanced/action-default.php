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

        $table = $_GET['tableFltAdvanced'];
        $columna = $_GET['columna'];
        $tipofiltro = $_GET['tipofiltro'];


        if ($_GET['fields'] != ''){
            $fields = $_GET['fields'];
        } else{
            $fields = '';
        }

         

         


        
        //$responselogs = FiltrosLogsData::getFilterTablesAdvanced($table, $columna, $columnDatos, "1",'');camposf
      
          if ($_GET['acciones'] == 'checkFilterRegex'){


                $response = filterData::getFilterTablesAdvanced($table, $columna, $columnDatos, "1",'');
            }
            else{

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
                $filtrologTable->baq_nom_tables = $table;
                $x = $filtrologTable->add();
                $codfiltrologtable = $x[1];

                
                $camposnorm = $_GET['camposf'];

                $k = 1;
                foreach($camposnorm as $rowColumnaNorm)
                {
                  $filtrologCampo = new FiltrosLogsCamposData();
                  $filtrologCampo->FK_baq_logs_filtros_table =  $codfiltrologtable;
                  $filtrologCampo->baq_nom_campo_normalizado = $rowColumnaNorm;
                  $filtrologCampo->filtro = "Igual a";
                  $filtrologCampo->campodato = $_GET['columnDatos'.$k];
                  $y = $filtrologCampo->add();
                  $codfiltrologcampo = $y[1];
                  $k++;
                }

                $fieldsp = explode(",", $fields);
                $v = 1;
                foreach($fieldsp as $rowfields)
                {
                   
                  $campbusq =   explode("AS", $rowfields );
                  $rowfields = str_replace("`", "", $campbusq[1]);
                  $filtrologVista = new FiltrosLogsVistaData();
                  $filtrologVista->FK_baq_logs_filtros_table =  $codfiltrologtable;
                  $filtrologVista->baq_nom_campos_normalizados = $rowfields;
                  $yv = $filtrologVista->add();
                  $filtrologVista = $yv[1];
                  $v++;
                }

            

                


                $response = filterData::getFilterTablesAdvanced($table, $columna, $columnDatos, '', $fields);
            }

        echo json_encode($response);
    }

?>