<?php
/**
* @author Ing. John Percybrooks
* @class PerfilData
* @brief Modelo de base de datos para la tabla de BAQ_LOGS_FILTROS_TABLE
**/
class FiltrosLogsTableData {
	public static $tablename = "BAQ_LOGS_FILTROS_TABLE";


	public function FiltrosLogsTableData(){
		$this->PK_baq_logs_filtros_table = "";
		$this->FK_baq_logs_filtros = "";
        $this->baq_nom_tables = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (FK_baq_logs_filtros,baq_nom_tables) ";
		$sql .= "value (\"$this->FK_baq_logs_filtros\",\"$this->baq_nom_tables\")";
		return Executor::doit($sql);
		//echo $sql;
	}
}

?>