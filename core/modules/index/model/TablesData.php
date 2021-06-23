<?php
/**
* @author Ing. John Percybrooks
* @class PerfilData
* @brief Modelo de base de datos para la tabla de BAQ_SISBEN
**/
class TablesData {
	public static $tablename = "BAQ_TABLES";


	public function Tablesdata(){
		$this->PK_baq_tables = "";
		$this->nombreTabla = "";
		$this->fecha_creacion = "";
		$this->usuario_creacion = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (nombreTabla,fecha_creacion,usuario_creacion)";
		$sql .= "value (\"$this->nombreTabla\",\"$this->fecha_creacion\",\"$this->usuario_creacion\")";

		$queryResponse = Executor::doit($sql);
		if (!$queryResponse[0]){
			$sql = "select * from ".self::$tablename." where nombreTabla = \"".$this->nombreTabla."\" LIMIT 1;";
			$tableExistResponse = Executor::doit($sql);
			$id = mysqli_fetch_array($tableExistResponse[0])[0];
			$queryResponse[0] = TRUE;
			$queryResponse[1] = $id;
			$sql = "DELETE FROM BAQ_CAMPOS_FILTRO where FK_baq_tables = ".$id." ;";
			$responseDeleteOldRows = Executor::doit($sql);
		}
		return $queryResponse;
	}

	


}

?>