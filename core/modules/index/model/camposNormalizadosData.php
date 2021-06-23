<?php
/**
* @author Ing. John Percybrooks
* @class PerfilData
* @brief Modelo de base de datos para la tabla de BAQ_SISBEN
**/
class camposNormalizadosData {
	public static $tablename = "BAQ_CAMPOS_NORMALIZADOS";


	public function camposNormalizadosdata(){
		$this->nombreCampo = "";
		$this->campoNormalizado = "";
		
	}


	public static function add($field, $textField){

            $sqlQuery = "INSERT INTO ".self::$tablename." (nombreCampo, campoNormalizado)
                        VALUES ('" . $field ."', '" . $textField. "')";
            $response= Executor::doit($sqlQuery);
            return $response;
        }


	public static function getCamposNormalizados(){
		$sql = "select nombreCampo, campoNormalizado from ".self::$tablename." order by campoNormalizado";
		$query = Executor::doit($sql);
		return $query[0];
	}

	
	public static function getCampo($campo){
		$sql = "select PK_baq_campos_normalizados,nombreCampo from ".self::$tablename." where campoNormalizado=\"$campo\"";
		$query = Executor::doit($sql);
		return Model::one($query[0],new camposNormalizadosData());
	}

	public static function nuevo($nomtable){

		//Delete table if exists
		$sql = "DROP TABLE IF EXISTS " . $nomtable . " ;";
		Executor::doit($sql);

		//Create new table
		$sql = "Create table ".$nomtable."( PK_".$nomtable." bigint(20) NOT NULL AUTO_INCREMENT,
		`borrado` int(1) NOT NULL,
		`fecha_creacion` datetime NOT NULL,
		`fecha_actualizacion` datetime DEFAULT NULL,
		`fecha_eliminacion` datetime DEFAULT NULL,
		`usuario_creacion` bigint(20) NOT NULL,
		`usuario_actualizacion` bigint(20) DEFAULT NULL,
		`usuario_eliminacion` bigint(20) DEFAULT NULL,
		PRIMARY KEY (PK_".$nomtable."))ENGINE=InnoDB  DEFAULT CHARSET=latin1;";
		Executor::doit($sql);
		
	}

	public static function agregar($nomtable,$nomcampo,$tipo){
		$sql = "Alter table ".$nomtable. " ADD ".$nomcampo. " ".$tipo." DEFAULT NULL";
		Executor::doit($sql);
		return $sql;
		
	}
}

?>