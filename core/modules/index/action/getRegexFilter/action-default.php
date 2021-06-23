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

        $table = $_GET['table'];
        $filtroGral = $_GET['filtroGral'];
        
        $optionFilter = $_GET['optionFilter'];
        $columnTable = $_GET['columnTable'];
//$filtroGral=1;//


        $text = $_GET['text'];
        if ($_GET['fields'] != ''){
            $fields = $_GET['fields'];
        } else{
            $fields = '';
        }

        if($filtroGral==2){
            if ($_GET['accion'] == 'checkFilterRegex'){
                $response = filterData::getFilterTables($table, $optionFilter, $columnTable, $text, "1", '');
            }
            else{


                $optionFilter2 = $_GET['optionFilter2']; 
                $text2 = $_GET['text2'];


                $camposnorm = $_GET['camposf'];

                $filtrolog = new FiltrosLogsData();
                
                $tfiltro = "Texto";
              
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
                if($optionFilter!=3){
                    if($optionFilter == 1 ){
                        $filtro = 'Comiencen con';
                    }
                    if($optionFilter == 2 ){
                        $filtro = 'Terminen con';
                    }
                    if($optionFilter == 3 ){
                        $filtro = 'Incluyan';
                    }
                        
                }

                $k = 1;
               
                  
                 if($optionFilter!=3){   
                  
                  $filtrologCampo = new FiltrosLogsCamposData();
                  $filtrologCampo->FK_baq_logs_filtros_table =  $codfiltrologtable;
                  $filtrologCampo->baq_nom_campo_normalizado = $camposnorm;
                  $filtrologCampo->filtro = $filtro;
                  $filtrologCampo->campodato = $text;
                  $y = $filtrologCampo->add();
                  $codfiltrologcampo = $y[1];

                 



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
     



                $response = filterData::getFilterTables($table, $optionFilter, $columnTable, $text, '', $fields);
            }
        }

        if($filtroGral==1){

              $optionFilter2 = $_GET['optionFilter2']; 
              $text2 = $_GET['text2'];
          
            if ($_GET['accion'] == 'checkFilterRegex'){
                $response = filterData::getFilterTablesNumerico($table, $optionFilter, $optionFilter2, $columnTable, $text, $text2, "1", '');
            }else{


                $optionFilter2 = $_GET['optionFilter2']; 
                $text2 = $_GET['text2'];


                $camposnorm = $_GET['camposf'];

                $filtrolog = new FiltrosLogsData();
                
                $tfiltro = "Numerico";
              
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
                if($optionFilter!=3){
                    if($optionFilter == 1 ){
                        $filtro = 'Mayor que';
                    }
                    if($optionFilter == 2 ){
                        $filtro = 'Menor que';
                    }
                    if($optionFilter2 == 1 ){
                        $filtro2 = 'Mayor que ';
                    }
                    if($optionFilter2 == 2 ){
                        $filtro2 = 'Menor que ';
                    }    
                }

                $k = 1;
               
                  
                 if($optionFilter!=3){   
                  
                  $filtrologCampo = new FiltrosLogsCamposData();
                  $filtrologCampo->FK_baq_logs_filtros_table =  $codfiltrologtable;
                  $filtrologCampo->baq_nom_campo_normalizado = $camposnorm;
                  $filtrologCampo->filtro = $filtro;
                  $filtrologCampo->campodato = $text;
                  $y = $filtrologCampo->add();
                  $codfiltrologcampo = $y[1];

                  $filtrologCampo2 = new FiltrosLogsCamposData();
                  $filtrologCampo2->FK_baq_logs_filtros_table =  $codfiltrologtable;
                  $filtrologCampo2->baq_nom_campo_normalizado = $camposnorm;
                  $filtrologCampo2->filtro = $filtro2;
                  $filtrologCampo2->campodato = $text2;
                  $y = $filtrologCampo2->add();
                  $codfiltrologcampo2 = $y[1];



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



                $response = filterData::getFilterTablesNumerico($table, $optionFilter,  $optionFilter2, $columnTable, $text, $text2, '', $fields);
            }
        }

        //echo $response;
        
        echo json_encode($response);
    }

?>