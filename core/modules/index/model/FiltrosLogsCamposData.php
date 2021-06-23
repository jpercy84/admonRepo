<?php
/**
* @author Ing. John Percybrooks
* @class PerfilData
* @brief Modelo de base de datos para la tabla de BAQ_LOGS_FILTROS_CAMPOS
**/
class FiltrosLogsCamposData {
	public static $tablename = "BAQ_LOGS_FILTROS_CAMPOS";

	public function FiltrosLogsCamposData(){
		$this->PK_baq_logs_filtros_campos = "";
		$this->FK_baq_logs_filtros_table = "";
		$this->filtro = "";
		$this->campodato = "";
        $this->baq_nom_campo_normalizado = "";
	}

	public function add(){
		$sql = "insert into ".self::$tablename." (FK_baq_logs_filtros_table,baq_nom_campo_normalizado,filtro,campodato) ";
		$sql .= "value (\"$this->FK_baq_logs_filtros_table\",\"$this->baq_nom_campo_normalizado\",\"$this->filtro\",\"$this->campodato\")";
		return Executor::doit($sql);
	}

	public static function getLogFiltrosCampos(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new FiltrosLogsCamposData());
     }
}

?>