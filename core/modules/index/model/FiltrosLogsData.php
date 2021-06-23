<?php
/**
* @author Ing. John Percybrooks
* @class PerfilData
* @brief Modelo de base de datos para la tabla de BAQ_LOGS_FILTROS
**/
class FiltrosLogsData {
	public static $tablename = "BAQ_LOGS_FILTROS";

	public function FiltrosLogsData(){
		$this->PK_baq_logs_filtros = "";
		$this->tipo_filtro = "";
		$this->usuario_query = "";
		$this->fecha_query="";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (tipo_filtro,usuario_query,fecha_query) ";
		$sql .= "value (\"$this->tipo_filtro\",\"$this->usuario_query\",\"$this->fecha_query\")";
		return Executor::doit($sql);
	}

	public static function getLogFiltros(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new FiltrosLogsData());
     }
}

?>