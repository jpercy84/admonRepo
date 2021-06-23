<?php 
    class baqSearch{

        public static function getTables(){
            $sqlQuery = "SELECT * FROM BAQ_TABLES";
            $response = Executor::doit($sqlQuery);
            $tables = Model::many($response[0], new baqSearch());
            return $tables;
        }
        public static function searchID($ID, $fields, $table){
            $sqlQuery = "SELECT " . $fields . " FROM " . $table . " WHERE numero_documento = '" . $ID . "';";
            $response = Executor::doit($sqlQuery);
            $table = Model::many($response[0], new baqSearch());
            return $table;
            
        }

        public static function searchAll($table){
            $sqlQuery = "SELECT * FROM " . $table . " WHERE numero_documento != '';";
            $response = Executor::doit($sqlQuery);
            $table = Model::many($response[0], new baqSearch());
            return $table;
        }

        public static function getColumns($table){
            $sqlFields = "select normalizados.nombreCampo from BAQ_CAMPOS_NORMALIZADOS AS normalizados INNER JOIN 
                            (select filter.FK_baq_campos_normalizados from BAQ_CAMPOS_FILTRO AS filter INNER JOIN 
                            BAQ_TABLES AS tables ON  tables.PK_baq_tables = filter.FK_baq_tables WHERE 
                            tables.nombreTabla = '" . $table . "') AS idFiltro 
                            ON idFiltro.FK_baq_campos_normalizados = normalizados.PK_baq_campos_normalizados;";
            $responseFields = Executor::doit($sqlFields);
            $fieldsMany = Model::many($responseFields[0], new baqSearch());
            return $fieldsMany;
        }


        public static function getDatosColumns($campo,$table){
            $sqlFields = "SELECT $campo as datos FROM $table GROUP BY $campo";
            $responseFields = Executor::doit($sqlFields);
            $fieldsMany = Model::many($responseFields[0], new baqSearch());
            return $fieldsMany;
        }

        public static function checkID($ID, $table){
            $sqlQuery = "SELECT * FROM " . $table . " WHERE numero_documento = '" . $ID . "';";
            $response = Executor::doit($sqlQuery);
            return $response;
        }

        public static function getNormalizeFields(){
            $sqlQuery = "SELECT * FROM BAQ_CAMPOS_NORMALIZADOS";
            $response = Executor::doit($sqlQuery);
            $fields = Model::many($response[0], new baqSearch());
            return $fields;
        }
    }
?>