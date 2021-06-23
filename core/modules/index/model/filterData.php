<?php
    class filterData{

        public static function getFilterTables($table, $optionFilter, $columnTable, $text, $limit="", $fields = ""){
            switch ($optionFilter){
                case "1":
                    $filter = $text.'%';
                    break;
                case "2":
                    $filter = '%'.$text;
                    break;
                case "3":
                    $filter = '%'.$text.'%';
                    break;
            }

            if($limit == ""){
                $sqlQuery = "SELECT ". $fields . " FROM ". $table ." WHERE ". $columnTable . " LIKE '". $filter ."';";
            }else{
                $sqlQuery = "SELECT * FROM ". $table ." WHERE ". $columnTable . " LIKE '". $filter ."' LIMIT 1;";
            }
            $response = Executor::doit($sqlQuery);
            $tables = Model::many($response[0], new filterData());
            return $tables;
        }


        public static function getCrossTablesData($table1, $table2, $fields1, $fields2, $columnTable, $optionFilter, $text, $limit = ''){
          $fieldToCross = "numero_documento";

            switch ($optionFilter){
                case "1":
                    $filter = $text.'%';
                    break;
                case "2":
                    $filter = '%'.$text;
                    break;
                case "3":
                    $filter = '%'.$text.'%';
                    break;
            }

            if($limit == 'limit'){
                $sqlQuery  = "SELECT " . $fields1 . ", " . $fields2 . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 ;
                $sqlQuery .= ".". $fieldToCross ."= " . $table2 . "." . $fieldToCross ." WHERE " . $table1 . '.'. $columnTable . " LIKE '". $filter ."' LIMIT 1;";
    
            }else{
                $sqlQuery  = "SELECT " . $fields1 . ", " . $fields2 . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 ;
                $sqlQuery .=  ".". $fieldToCross ."= " . $table2 . "." . $fieldToCross ." WHERE " . $table1 . '.'. $columnTable . " LIKE '". $filter ."';";   
            }

            $response = Executor::doit($sqlQuery);
            $result = Model::many($response[0], new filterData());
            return $result;

        }

        public static function getCrossTablesDataNumerico($table1, $table2, $fields1, $fields2, $columnTable, $optionFilter, $text, $optionFilter2, $text2, $limit = ''){

           $fieldToCross = "numero_documento";

            switch ($optionFilter){
                case "1":
                    $filter = '>';
                    $comp = ' and ';
                    break;
                case "2":
                    $filter = '<';
                    $comp = ' and ';
                    break;
                case "3":
                    $filter = '=';
                    $comp = '';
                    break;
            }
            switch ($optionFilter2){
                case "1":
                    $filter2 = '>';
                    $comp = ' and ';
                    break;
                case "2":
                    $filter2 = '<';
                    $comp = ' and ';
                    break;
                case "3":
                    $filter2 = '=';
                    $comp = '';
                    break;
            }

            if($limit == 'limit'){
                if($optionFilter!=3){
                     $sqlQuery  = "SELECT " . $fields1 . ", " . $fields2 . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 ;
                     $sqlQuery .= ".". $fieldToCross ."= " . $table2 . "." . $fieldToCross ." WHERE " . $table1 . '.'. $columnTable . $filter . ' '. $text.$comp.$columnTable.' '.$filter2.' '.$text2." LIMIT 1;";
                }
                if($optionFilter==3){
                     $sqlQuery  = "SELECT " . $fields1 . ", " . $fields2 . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 ;
                     $sqlQuery .= ".". $fieldToCross ."= " . $table2 . "." . $fieldToCross ." WHERE " . $table1 . '.'. $columnTable . $filter . ' '. $text." LIMIT 1;";
                }

            }else{
               if($optionFilter!=3){
                     $sqlQuery  = "SELECT " . $fields1 . ", " . $fields2 . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 ;
                     $sqlQuery .= ".". $fieldToCross ."= " . $table2 . "." . $fieldToCross ." WHERE " . $table1 . '.'. $columnTable . $filter . ' '. $text.$comp.$columnTable.' '.$filter2.' '.$text2.";";
                }
                if($optionFilter==3){
                     $sqlQuery  = "SELECT " . $fields1 . ", " . $fields2 . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 ;
                     $sqlQuery .= ".". $fieldToCross ."= " . $table2 . "." . $fieldToCross ." WHERE " . $table1 . '.'. $columnTable . $filter . ' '. $text.";";
                }   
            }

            $response = Executor::doit($sqlQuery);
            $result = Model::many($response[0], new filterData());
            return $result;

        }

        public static function getFilterTablesNumerico($table, $optionFilter, $optionFilter2, $columnTable, $text, $text2, $limit="", $fields = ""){
            switch ($optionFilter){
                case "1":
                    $filter = '>';
                    $comp = ' and ';
                    break;
                case "2":
                    $filter = '<';
                    $comp = ' and ';
                    break;
                case "3":
                    $filter = '=';
                    $comp = '';
                    break;
            }
            switch ($optionFilter2){
                case "1":
                    $filter2 = '>';
                    $comp = ' and ';
                    break;
                case "2":
                    $filter2 = '<';
                    $comp = ' and ';
                    break;
                case "3":
                    $filter2 = '=';
                    $comp = '';
                    break;
            }
            
            if($limit == ""){
                if($optionFilter!=3){
                   $sqlQuery = "SELECT ". $fields . " FROM ". $table ." WHERE ". $columnTable . $filter .' '.$text.$comp.$columnTable. $filter2.' '. $text2.";";
                }

                if($optionFilter==3){
                   $sqlQuery = "SELECT ". $fields . " FROM ". $table ." WHERE ". $columnTable . $filter .' '.$text.";";
                }

            }else{

                if($optionFilter!=3){
                     $sqlQuery = "SELECT * FROM ". $table ." WHERE ". $columnTable . $filter . ' ' . $text.$comp.$columnTable.' '.$filter2.' '.$text2." LIMIT 1;";
                }

                if($optionFilter==3){
                     $sqlQuery = "SELECT * FROM ". $table ." WHERE ". $columnTable . $filter . ' ' . $text.$comp." LIMIT 1;";
                }
                
            }

            $response = Executor::doit($sqlQuery);
            $tables = Model::many($response[0], new filterData());
            return $tables;
        }


        public static function getFilterTablesAdvanced($table, $columna, $columnDatos, $limit="", $fields = ""){
             
           $i=1;   
           $cantColumn  = $_GET['cantCampos'];  
           if($limit == "")$sqlQuery = "SELECT ". $fields . " FROM ". $table ." WHERE ";
           if($limit != "")$sqlQuery = "SELECT * FROM ". $table ." WHERE ";


           if( $_GET['cantCampos'] ){
                $k = 1;
                while ($k <= $cantColumn) {                    
                    $columnDatos  = $_GET['columnDatos'.$k];
                    $column  = $_GET['columnaSelec'.$k];
                    $posicion_coincidencia = strpos($columnDatos, "'");
                    if($limit == ""){
                        if( $cantColumn == $k ){
                            if ($posicion_coincidencia === false) {
                                $sqlQuery .= $column ." = '". $columnDatos ."';";   
                            }else{
                                $sqlQuery .= $column ." = ''". $columnDatos ."';";   
                            }
                        }else{
                            if ($posicion_coincidencia === false) {
                                $sqlQuery .= $column ." = '". $columnDatos . "' AND " ;
                            }else{
                                $sqlQuery .= $column ." = ''". $columnDatos . "' AND " ;
                            }
                        }
                    }else{
                        if( $cantColumn == $k ){                        
                            if ($posicion_coincidencia === false) {
                                $sqlQuery .= $column ." = '". $columnDatos . "' LIMIT 1;" ; 
                            }else{
                                $sqlQuery .= $column ." = ''". $columnDatos . "' LIMIT 1;" ; 
                            }
                        }else{
                            if ($posicion_coincidencia === false) {
                            $sqlQuery .= $column ." = '". $columnDatos . "' AND " ; 
                            }else{
                            $sqlQuery .= $column ." = ''". $columnDatos . "' AND " ; 
                            }
                        }
                    }
                $k++;
                }
            }else{
                $cantColumn  =  count($columna);
                foreach($columna as $rowColumna){
                    $columnDatos  = $_GET['columnDatos'.$i];           
                    $column = $rowColumna;
                    if($limit == ""){
                            if( $cantColumn == $i ){
                                if ($posicion_coincidencia === false) {
                                    $sqlQuery .= $column ." = '". $columnDatos ."';"; 
                                    }else{
                                    $sqlQuery .= $column ." = ''". $columnDatos ."';"; 
                                    }
                            }else{
                                    if ($posicion_coincidencia === false) {
                                    $sqlQuery .= $column ." = '". $columnDatos . "' AND " ; 
                                    }else{
                                    $sqlQuery .= $column ." = ''". $columnDatos . "' AND " ; 
                                    }
                            }
                    }else{
                                if( $cantColumn == $i ){
                                if ($posicion_coincidencia === false) {
                                    $sqlQuery .= $column ." = '". $columnDatos . "' LIMIT 1;" ; 
                                    }else{
                                    $sqlQuery .= $column ." = ''". $columnDatos . "' LIMIT 1;" ; 
                                    }
                            }else{

                                    if ($posicion_coincidencia === false) {
                                    $sqlQuery .= $column ." = '". $columnDatos . "' AND " ; 
                                    }else{
                                    $sqlQuery .= $column ." = ''". $columnDatos . "' AND " ; 
                                    }
                            }
                    }
                    $i++;
                }
            }  
            $response = Executor::doit($sqlQuery);
            $tables = Model::many($response[0], new filterData());
            return $tables;
        }
        public static function getCrossTablesDataAdvanced($table1, $table2, $fields1, $fields2, $limit = ''){
           $column  = $_GET['columna']; 
           $i = 1;
           $cantColumn  =  count($column);
           $sqlQuery  = "SELECT " . $fields1 . ", " . $fields2 . " FROM " . $table1 . " INNER JOIN " . $table2 . " ON " . $table1 ;
           $sqlQuery .= ".numero_documento = " . $table2 . ".numero_documento WHERE " . $table1 . '.';
           foreach($column as $rowColumna){
                $columnDatos  = $_GET['columnDatos'.$i];           
                $columna = $rowColumna;
                if($limit == 'limit'){
                    if( $cantColumn == $i ){
                        $sqlQuery .= $columna. " = '". $columnDatos . "' LIMIT 1 ";
                    }else{
                        $sqlQuery .= $columna. " = '". $columnDatos . "' AND ";                                  
                    }
                }else{
                    if( $cantColumn == $i ){
                        $sqlQuery .= $columna. " = '". $columnDatos . "'";
                    }else{
                        $sqlQuery .= $columna. " = '". $columnDatos . "' AND ";                                  
                    }
                }
               $i++;
           } 
            $response = Executor::doit($sqlQuery);
            $result = Model::many($response[0], new filterData());
            return $result;
        }
    }
?>