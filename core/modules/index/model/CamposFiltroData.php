<?php
/**
* @author Ing. John Percybrooks
* @class PerfilData
* @brief Modelo de base de datos para la tabla de BAQ_SISBEN
**/
class CamposFiltroData {
	public static $tablename = "BAQ_CAMPOS_FILTRO";

	public function CamposFiltrodata(){
		$this->PK_baq_campos_filtro = "";
		$this->FK_baq_tables = "";
		$this->FK_baq_campos_normalizados = "";
	}	

	public function add(){
		$sql = "insert into ".self::$tablename." (FK_baq_tables,FK_baq_campos_normalizados)";
		$sql .= " value (\"$this->FK_baq_tables\",\"$this->FK_baq_campos_normalizados\")";

		Executor::doit($sql);
		return $sql;
	}
}

?>