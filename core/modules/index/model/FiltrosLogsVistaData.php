<?php
/**
* @author Ing. John Percybrooks
* @class PerfilData
* @brief Modelo de base de datos para la tabla de BAQ_LOGS_FILTROS_VISTA
**/
class FiltrosLogsVistaData {
	public static $tablename = "BAQ_LOGS_FILTROS_VISTA";


	public function FiltrosLogsVistaData(){

		$this->PK_baq_logs_filtros_vista = "";
		$this->FK_baq_logs_filtros_table = "";
		$this->baq_nom_campos_normalizados = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (FK_baq_logs_filtros_table,baq_nom_campos_normalizados) ";
		$sql .= "value (\"$this->FK_baq_logs_filtros_table\",\"$this->baq_nom_campos_normalizados\")";
		return Executor::doit($sql);
	}

	public static function getLogFiltrosVista(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new FiltrosLogsVistaData());
     }
}

?>